<?php

namespace App\Services;

/**
 * Splits a SQL script into statements the way database editors do:
 *  - statements end at `;` (the older `++` separator still works),
 *  - comments are removed: `-- ...`, `/* ... *\/` and, on MySQL, `# ...`,
 *  - nothing inside quotes counts: '...', "...", `...` and PostgreSQL $tag$...$tag$ bodies,
 *  - empty statements (only whitespace / comments) are dropped.
 */
class SqlScriptSplitter
{
    public static function split(string $sql, string $driver = 'mysql'): array
    {
        $statements = [];
        $current = '';
        $length = strlen($sql);
        $i = 0;

        while ($i < $length) {
            $char = $sql[$i];
            $next = $i + 1 < $length ? $sql[$i + 1] : '';

            // Line comment: skip to the end of the line (the newline itself is kept)
            if (($char === '-' && $next === '-') || ($char === '#' && $driver === 'mysql')) {
                $end = strpos($sql, "\n", $i);
                $i = $end === false ? $length : $end;
                continue;
            }

            // Block comment
            if ($char === '/' && $next === '*') {
                $end = strpos($sql, '*/', $i + 2);
                $i = $end === false ? $length : $end + 2;
                $current .= ' ';
                continue;
            }

            // Quoted text / identifiers ('' "" `` doubled = escaped; MySQL also allows backslash escapes)
            if ($char === "'" || $char === '"' || $char === '`') {
                $j = $i + 1;
                while ($j < $length) {
                    if ($sql[$j] === '\\' && $driver === 'mysql' && $char !== '`') {
                        $j += 2;
                        continue;
                    }
                    if ($sql[$j] === $char) {
                        if ($j + 1 < $length && $sql[$j + 1] === $char) {
                            $j += 2;
                            continue;
                        }
                        break;
                    }
                    $j++;
                }
                $current .= substr($sql, $i, min($j, $length - 1) - $i + 1);
                $i = $j + 1;
                continue;
            }

            // PostgreSQL dollar-quoted body ($$ ... $$ or $tag$ ... $tag$)
            if ($char === '$' && $driver === 'pgsql' && preg_match('/\G\$([A-Za-z_][A-Za-z0-9_]*)?\$/', $sql, $m, 0, $i)) {
                $end = strpos($sql, $m[0], $i + strlen($m[0]));
                $end = $end === false ? $length : $end + strlen($m[0]);
                $current .= substr($sql, $i, $end - $i);
                $i = $end;
                continue;
            }

            // Statement separators
            if ($char === ';' || ($char === '+' && $next === '+')) {
                $statements[] = $current;
                $current = '';
                $i += $char === ';' ? 1 : 2;
                continue;
            }

            $current .= $char;
            $i++;
        }
        $statements[] = $current;

        return array_values(array_filter(array_map('trim', $statements), fn ($s) => $s !== ''));
    }
}
