<?php

namespace App\Services;

/**
 * Server-side port of the SQL tab's table/column search (partial / exact / smart).
 *
 * Mirrors the former client-side logic so the tables list gives the same results:
 *   - sql.tsx: getSearchTerms(), columnMatchesTerm() and the filteredTablesByLetter memo
 *   - components/sql/smartSearch.ts: smartMatches() and helpers
 *
 * A column is an array: ['column' => string, 'type' => ?string, 'nullable' => 'YES'|'NO',
 * 'defaultValue' => mixed].
 */
class SchemaSearchMatcher
{
    public const MODES = ['partial', 'exact', 'smart'];

    // Fuzzy comparison is skipped for long text (only the cheap checks run).
    private const MAX_FUZZY_TEXT_LENGTH = 160;

    private const WORD_SEPARATORS = '/[\s_\-.,;:\'"`()\[\]{}<>\/\\\\|=+*&^%$#@!?~]+/u';

    // ───────────────────────── terms ─────────────────────────

    /**
     * "a + b + 'c d'" => ['a', 'b', 'c d']  (exact mode keeps the original case).
     */
    public static function terms(?string $search, bool $preserveCase = false): array
    {
        if ($search === null || $search === '') {
            return [];
        }

        $processed = $preserveCase ? $search : mb_strtolower($search);
        $terms = [];

        foreach (explode('+', $processed) as $piece) {
            $term = $preserveCase ? $piece : trim($piece);
            $len = mb_strlen($term);

            if ($len >= 2) {
                $first = mb_substr($term, 0, 1);
                $last = mb_substr($term, -1);
                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    $term = mb_substr($term, 1, $len - 2);
                }
            }

            if ($term !== '') {
                $terms[] = $term;
            }
        }

        return $terms;
    }

    // ───────────────────────── table-level matching ─────────────────────────

    /**
     * Does this table (by name or by any of its columns) match the search?
     * $mode: partial | exact | smart
     */
    public static function tableMatches(string $tableName, array $columns, string $search, string $mode): bool
    {
        $exact = $mode === 'exact';
        $smart = $mode === 'smart';
        $terms = self::terms($search, $exact);

        if (!$terms) {
            return true; // empty search => no filtering
        }

        if ($exact) {
            $name = self::stripSpaces($tableName);
            foreach ($terms as $term) {
                if ($name === self::stripSpaces($term)) {
                    return true;
                }
            }
            foreach ($columns as $col) {
                foreach ($terms as $term) {
                    if (self::columnMatchesTerm($col, $term, true, true)) {
                        return true;
                    }
                }
            }
            return false;
        }

        if ($smart) {
            foreach ($terms as $term) {
                if (self::smartMatches($tableName, $term)) {
                    return true;
                }
            }
            foreach ($columns as $col) {
                foreach ($terms as $term) {
                    if (self::smartMatches($col['column'] ?? '', $term) || self::columnMatchesTerm($col, $term, false, true)) {
                        return true;
                    }
                }
            }
            return false;
        }

        // partial
        $name = mb_strtolower(self::stripSpaces($tableName));
        foreach ($terms as $term) {
            if (str_contains($name, mb_strtolower(self::stripSpaces($term)))) {
                return true;
            }
        }
        foreach ($columns as $col) {
            foreach ($terms as $term) {
                if (self::columnMatchesTerm($col, $term, false, true)) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function stripSpaces(string $value): string
    {
        return preg_replace('/\s+/u', '', $value) ?? $value;
    }

    public static function columnMatchesTerm(array $col, string $term, bool $exact = false, bool $ignoreSpaces = false): bool
    {
        $column = (string) ($col['column'] ?? '');
        $type = (string) ($col['type'] ?? '');
        $nullable = (string) ($col['nullable'] ?? '');
        $default = (string) ($col['defaultValue'] ?? '');

        if ($ignoreSpaces) {
            $term = self::stripSpaces($term);
            $column = self::stripSpaces($column);
            $type = self::stripSpaces($type);
            $nullable = self::stripSpaces($nullable);
            $default = self::stripSpaces($default);
        }

        if ($exact) {
            return $column === $term || $type === $term || $nullable === $term || $default === $term;
        }

        $lower = mb_strtolower($term);
        return str_contains(mb_strtolower($column), $lower)
            || str_contains(mb_strtolower($type), $lower)
            || str_contains(mb_strtolower($nullable), $lower)
            || str_contains(mb_strtolower($default), $lower);
    }

    // ───────────────────────── smart matching ─────────────────────────

    public static function smartMatches($text, $term): bool
    {
        $source = (string) ($text ?? '');
        $rawTerm = trim((string) ($term ?? ''));
        if ($source === '' || $rawTerm === '') {
            return false;
        }

        $lowerText = mb_strtolower($source);
        $lowerTerm = mb_strtolower($rawTerm);

        // 1. plain partial match
        if (str_contains($lowerText, $lowerTerm)) {
            return true;
        }

        // 2. ignore separators and camelCase
        $looseTerm = self::looseForm($rawTerm);
        $looseText = self::looseForm($source);
        if ($looseTerm !== '' && str_contains($looseText, $looseTerm)) {
            return true;
        }

        // 3. singular / plural
        $stemmedLooseTerm = self::stem($looseTerm);
        if (mb_strlen($stemmedLooseTerm) >= 3 && $stemmedLooseTerm !== $looseTerm && str_contains($looseText, $stemmedLooseTerm)) {
            return true;
        }

        $allowFuzzy = mb_strlen($source) <= self::MAX_FUZZY_TEXT_LENGTH;

        // 4 + 5. word-by-word comparison (with typo tolerance on short text)
        $queryWords = array_map([self::class, 'stem'], self::splitWords($rawTerm));
        if (!$queryWords) {
            return false;
        }

        $textWords = array_map([self::class, 'stem'], self::splitWords($source));
        if (!$textWords) {
            return false;
        }

        $everyWordFound = true;
        foreach ($queryWords as $qw) {
            $found = false;
            foreach ($textWords as $tw) {
                if (self::wordsAlike($qw, $tw, $allowFuzzy)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $everyWordFound = false;
                break;
            }
        }
        if ($everyWordFound) {
            return true;
        }

        // Typos in a whole identifier written without separators ("orderprodcut" vs "order_product").
        if ($allowFuzzy && mb_strlen($looseTerm) >= 4 && !self::hasDigit($looseTerm) && mb_strlen($looseText) <= 64) {
            $max = self::allowedEdits(mb_strlen($stemmedLooseTerm));
            if ($max > 0 && self::editDistance($stemmedLooseTerm, self::stem($looseText), $max) <= $max) {
                return true;
            }
        }

        return false;
    }

    private static function splitWords(string $value): array
    {
        $value = preg_replace('/([a-z0-9])([A-Z])/u', '$1 $2', $value);
        $value = preg_replace('/([A-Z]+)([A-Z][a-z])/u', '$1 $2', $value);
        $parts = preg_split(self::WORD_SEPARATORS, mb_strtolower($value)) ?: [];

        return array_values(array_filter($parts, fn ($p) => $p !== ''));
    }

    // Removes every separator so "product_offer", "productOffer" and "product offer" match.
    private static function looseForm(string $value): string
    {
        return preg_replace('/[\s_\-.]+/u', '', mb_strtolower($value)) ?? '';
    }

    // Very small English stemmer: only handles plurals.
    private static function stem(string $word): string
    {
        if (mb_strlen($word) <= 3) {
            return $word;
        }
        if (str_ends_with($word, 'ies') && mb_strlen($word) > 4) {
            return mb_substr($word, 0, -3) . 'y';
        }
        if (preg_match('/(ches|shes|sses|xes|zes)$/', $word)) {
            return mb_substr($word, 0, -2);
        }
        if (str_ends_with($word, 's') && !str_ends_with($word, 'ss')) {
            return mb_substr($word, 0, -1);
        }
        return $word;
    }

    // How many typos we tolerate for a word of this length.
    private static function allowedEdits(int $length): int
    {
        return $length <= 3 ? 0 : ($length <= 5 ? 1 : 2);
    }

    private static function hasDigit(string $value): bool
    {
        return (bool) preg_match('/\d/', $value);
    }

    private static function wordsAlike(string $queryWord, string $textWord, bool $allowFuzzy): bool
    {
        if ($queryWord === $textWord) {
            return true;
        }
        if (mb_strlen($queryWord) >= 3 && str_contains($textWord, $queryWord)) {
            return true;
        }
        if (!$allowFuzzy || self::hasDigit($queryWord) || self::hasDigit($textWord)) {
            return false;
        }
        $max = self::allowedEdits(mb_strlen($queryWord));
        if ($max === 0) {
            return false;
        }
        return self::editDistance($queryWord, $textWord, $max) <= $max;
    }

    // Bounded Damerau-Levenshtein (adjacent swaps count as one edit). Returns max + 1 once exceeded.
    private static function editDistance(string $a, string $b, int $max): int
    {
        if ($a === $b) {
            return 0;
        }

        $a = mb_str_split($a);
        $b = mb_str_split($b);
        $la = count($a);
        $lb = count($b);

        if (abs($la - $lb) > $max) {
            return $max + 1;
        }

        $rows = [];
        for ($i = 0; $i <= $la; $i++) {
            $rows[$i] = array_fill(0, $lb + 1, 0);
            $rows[$i][0] = $i;
        }
        for ($j = 0; $j <= $lb; $j++) {
            $rows[0][$j] = $j;
        }

        for ($i = 1; $i <= $la; $i++) {
            $rowMin = PHP_INT_MAX;
            for ($j = 1; $j <= $lb; $j++) {
                $cost = $a[$i - 1] === $b[$j - 1] ? 0 : 1;
                $value = min($rows[$i - 1][$j] + 1, $rows[$i][$j - 1] + 1, $rows[$i - 1][$j - 1] + $cost);
                if ($i > 1 && $j > 1 && $a[$i - 1] === $b[$j - 2] && $a[$i - 2] === $b[$j - 1]) {
                    $value = min($value, $rows[$i - 2][$j - 2] + 1);
                }
                $rows[$i][$j] = $value;
                if ($value < $rowMin) {
                    $rowMin = $value;
                }
            }
            if ($rowMin > $max) {
                return $max + 1;
            }
        }

        return $rows[$la][$lb];
    }
}
