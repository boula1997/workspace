<?php

namespace App\Services;

/**
 * Builds the "schema difference" text the SQL tab shows in its Differences modal.
 *
 * This is a port of the app's former client-side detectAndStoreDifferences() logic, so the
 * text format (and therefore the app's parsing of it) is unchanged. The schema shape is the
 * same one the app used to store in d_b_credentials.last_snapshot:
 *   [ table => [ { column, type, nullable, nullableLabel, defaultValue, extra, key,
 *                  comment, isForeignKey, referencedTable }, ... ], ... ]
 */
class SchemaDiffService
{
    public const BASELINE_MESSAGE = 'Baseline snapshot captured — no prior schema was on record, so this establishes the starting point for future change detection.';

    /**
     * Turn the rows produced by DatabaseController::getDatabase() into
     * [organized schema, per-table meta].
     */
    public static function organize(array $rows): array
    {
        $organized = [];
        $tableMeta = [];

        foreach ($rows as $col) {
            $table = $col['TABLE_NAME'];

            if (!isset($organized[$table])) {
                $organized[$table] = [];
                $tableMeta[$table] = [
                    'rowCount'             => $col['ROW_COUNT'] ?? 0,
                    'latestCreatedAt'      => $col['LATEST_CREATED_AT'] ?? null,
                    'latestCreatedAtCount' => $col['LATEST_CREATED_AT_COUNT'] ?? 0,
                    'latestUpdatedAt'      => $col['LATEST_UPDATED_AT'] ?? null,
                    'latestUpdatedAtCount' => $col['LATEST_UPDATED_AT_COUNT'] ?? 0,
                ];
            }

            $organized[$table][] = [
                'column'         => $col['Field'],
                'type'           => $col['Type'] ?? null,
                'nullable'       => ($col['Null'] ?? null) === 'YES' ? 'YES' : 'NO',
                'nullableLabel'  => ($col['Null'] ?? null) === 'YES' ? 'Optional' : 'Required',
                'defaultValue'   => $col['Default'] ?? null,
                'extra'          => $col['Extra'] ?? '',
                'key'            => $col['Key'] ?? '',
                'comment'        => $col['Comment'] ?? '',
                'isForeignKey'   => (bool) ($col['IS_FOREIGN_KEY'] ?? false),
                'referencedTable' => $col['REFERENCED_TABLE'] ?? null,
            ];
        }

        return [$organized, $tableMeta];
    }

    /**
     * Compare two schemas and return the diff lines (empty array = no changes).
     */
    public static function diffLines(array $prevTables, array $currTables): array
    {
        $lines = [];

        foreach ($currTables as $table => $columns) {
            if (!array_key_exists($table, $prevTables)) {
                $lines[] = "+ Table added: {$table}";
                foreach ($columns ?? [] as $col) {
                    $lines[] = self::formatColumnDetails((string) $table, $col, '  + ');
                }
            }
        }

        foreach ($prevTables as $table => $columns) {
            if (!array_key_exists($table, $currTables)) {
                $lines[] = "- Table removed: {$table}";
                foreach ($columns ?? [] as $col) {
                    $lines[] = self::formatColumnDetails((string) $table, $col, '  - ');
                }
            }
        }

        foreach ($currTables as $table => $columns) {
            if (!array_key_exists($table, $prevTables)) {
                continue;
            }

            $prevColMap = self::buildColumnMap($prevTables[$table]);
            $currColMap = self::buildColumnMap($columns);

            foreach ($currColMap as $name => $col) {
                if (!isset($prevColMap[$name])) {
                    $lines[] = '+ Column added:';
                    $lines[] = self::formatColumnDetails((string) $table, $col, '  ');
                }
            }

            foreach ($prevColMap as $name => $prevCol) {
                if (!isset($currColMap[$name])) {
                    $lines[] = '- Column removed:';
                    $lines[] = self::formatColumnDetails((string) $table, $prevCol, '  ');
                    continue;
                }

                $changes = self::columnChangeLines($prevCol, $currColMap[$name]);
                if ($changes) {
                    $lines[] = "~ Column modified: {$table}.{$name}";
                    array_push($lines, ...$changes);
                    $lines[] = '  Current definition:';
                    $lines[] = self::formatColumnDetails((string) $table, $currColMap[$name], '  ');
                }
            }
        }

        return $lines;
    }

    /**
     * Wrap diff lines (or the baseline message) in the standard header.
     */
    public static function buildText(?string $database, $credentialId, string $detectedAt, array $lines): string
    {
        return implode("\n", array_merge([
            'Database: ' . (($database !== null && $database !== '') ? $database : 'N/A'),
            'Credential ID: ' . $credentialId,
            'Detected at: ' . $detectedAt,
            '',
        ], $lines));
    }

    private static function buildColumnMap($columns): array
    {
        $map = [];
        foreach ($columns ?? [] as $col) {
            if (isset($col['column']) && $col['column'] !== '') {
                $map[$col['column']] = $col;
            }
        }
        return $map;
    }

    private static function parseEnumOrSet($type): ?array
    {
        if ($type === null || $type === '') {
            return null;
        }
        if (!preg_match('/^(enum|set)\((.*)\)$/i', (string) $type, $m)) {
            return null;
        }
        return ['kind' => strtoupper($m[1]), 'values' => $m[2]];
    }

    private static function present($value): bool
    {
        // JS truthiness for strings: only null/'' are falsy here ("0" is truthy in JS).
        return $value !== null && $value !== '' && $value !== false;
    }

    private static function formatColumnDetails(string $table, ?array $col, string $titlePrefix): string
    {
        if (!$col) {
            return '';
        }

        $enum = self::parseEnumOrSet($col['type'] ?? null);
        $detail = [
            "{$titlePrefix}{$table}.{$col['column']}",
            '  Type: ' . (self::present($col['type'] ?? null) ? $col['type'] : 'unknown'),
        ];

        if ($enum) {
            $detail[] = "  {$enum['kind']} values: {$enum['values']}";
        }

        $nullable = $col['nullable'] ?? $col['nullableLabel'] ?? 'unknown';
        $default = array_key_exists('defaultValue', $col) && $col['defaultValue'] !== null ? $col['defaultValue'] : 'NULL';
        $detail[] = "  Nullable: {$nullable}";
        $detail[] = "  Default: {$default}";

        if (self::present($col['key'] ?? null)) $detail[] = "  Key: {$col['key']}";
        if (self::present($col['extra'] ?? null)) $detail[] = "  Extra: {$col['extra']}";
        if (self::present($col['comment'] ?? null)) $detail[] = "  Comment: {$col['comment']}";
        if (!empty($col['isForeignKey']) && self::present($col['referencedTable'] ?? null)) {
            $detail[] = "  Foreign key -> {$col['referencedTable']}";
        }

        return implode("\n", $detail);
    }

    private static function columnChangeLines(array $prev, array $curr): array
    {
        $dash = fn ($v) => self::present($v) ? $v : '-';
        $changes = [];

        if (($prev['type'] ?? '') !== ($curr['type'] ?? '')) {
            $changes[] = '  Type: ' . $dash($prev['type'] ?? null) . ' -> ' . $dash($curr['type'] ?? null);
            $prevEnum = self::parseEnumOrSet($prev['type'] ?? null);
            $currEnum = self::parseEnumOrSet($curr['type'] ?? null);
            if ($prevEnum) $changes[] = "  Old {$prevEnum['kind']} values: {$prevEnum['values']}";
            if ($currEnum) $changes[] = "  New {$currEnum['kind']} values: {$currEnum['values']}";
        }

        $prevNullable = $prev['nullable'] ?? $prev['nullableLabel'] ?? null;
        $currNullable = $curr['nullable'] ?? $curr['nullableLabel'] ?? null;
        if ($prevNullable !== $currNullable) {
            $changes[] = '  Nullable: ' . $dash($prevNullable) . ' -> ' . $dash($currNullable);
        }

        $prevDefault = $prev['defaultValue'] ?? 'NULL';
        $currDefault = $curr['defaultValue'] ?? 'NULL';
        if ((string) $prevDefault !== (string) $currDefault) {
            $changes[] = "  Default: {$prevDefault} -> {$currDefault}";
        }

        foreach (['key' => 'Key', 'extra' => 'Extra', 'comment' => 'Comment'] as $field => $label) {
            if (($prev[$field] ?? '') !== ($curr[$field] ?? '')) {
                $changes[] = "  {$label}: " . $dash($prev[$field] ?? null) . ' -> ' . $dash($curr[$field] ?? null);
            }
        }

        $prevFk = !empty($prev['isForeignKey']) ? ($prev['referencedTable'] ?? '') : '';
        $currFk = !empty($curr['isForeignKey']) ? ($curr['referencedTable'] ?? '') : '';
        if ($prevFk !== $currFk) {
            $changes[] = '  Foreign key: ' . $dash($prevFk) . ' -> ' . $dash($currFk);
        }

        return $changes;
    }
}
