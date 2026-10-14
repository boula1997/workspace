<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * camelCase column names -> snake_case, in every table of the database.
 *
 * Why: PostgreSQL folds unquoted names to lower case while Laravel quotes them, so a column
 * called isActive only works on MySQL. snake_case works the same on both.
 *
 * - Works on MySQL/MariaDB and PostgreSQL, including a PostgreSQL copy imported from MySQL where
 *   the columns became all lower case (isactive): the actual spelling is looked up, then renamed.
 * - Safe to run again: columns that are already renamed are skipped. A table that has both
 *   spellings is left alone and reported.
 * - The table serviceRequests becomes service_requests.
 * - Data that stores column/table names (categories.search_keys, input_appearances, ...) is updated.
 *
 * MySQL needs RENAME COLUMN support (MySQL 8.0+ / MariaDB 10.5.2+); it is checked before anything
 * is changed.
 */
return new class extends Migration
{
    private const COLUMNS = [
        'isActive' => 'is_active',
        'lastTransaction' => 'last_transaction',
        'reactPermissions' => 'react_permissions',
        'reactplPermissions' => 'reactpl_permissions',
        'osActive' => 'os_active',
        'isGeneral' => 'is_general',
        'isForever' => 'is_forever',
        'isPaid' => 'is_paid',
        'isMultiply' => 'is_multiply',
        'hasPhone' => 'has_phone',
        'isCreate' => 'is_create',
        'isEdit' => 'is_edit',
        'isIndex' => 'is_index',
        'isShow' => 'is_show',
        'isNotification' => 'is_notification',
        'isOffline' => 'is_offline',
        'isOverthinking' => 'is_overthinking',
        'isPublic' => 'is_public',
        'isExcavation' => 'is_excavation',
        'newsletterEmail' => 'newsletter_email',
        'screenCard' => 'screen_card',
        'futureExpense' => 'future_expense',
        'githubDevModeLinkBack' => 'github_dev_mode_link_back',
        'githubDevModeLinkFront' => 'github_dev_mode_link_front',
        'isHosted' => 'is_hosted',
        'isPersonal' => 'is_personal',
        'isYousab' => 'is_yousab',
        'renewalDate' => 'renewal_date',
        'routesLink' => 'routes_link',
        'isFixed' => 'is_fixed',
        'serviceRequest' => 'service_request',
        'editsPercent' => 'edits_percent',
        'negotiatePercent' => 'negotiate_percent',
        'pricePerHour' => 'price_per_hour',
        'reqType' => 'req_type',
        'reqValue' => 'req_value',
        'startTime' => 'start_time',
        'stopClosing' => 'stop_closing',
        'clickTime' => 'click_time',
    ];

    private const TABLES = [
        'serviceRequests' => 'service_requests',
    ];

    public function up(): void
    {
        $this->assertSupported();
        $this->renameTables(self::TABLES);
        $this->renameColumns(self::COLUMNS);
        $this->renameInTriggerFunctions(self::COLUMNS);
        $this->renameStoredNames(self::COLUMNS, self::TABLES);
    }

    public function down(): void
    {
        $this->assertSupported();
        $this->renameColumns(array_flip(self::COLUMNS));
        $this->renameInTriggerFunctions(array_flip(self::COLUMNS));
        $this->renameTables(array_flip(self::TABLES));
        $this->renameStoredNames(array_flip(self::COLUMNS), array_flip(self::TABLES));
    }

    private function driver(): string
    {
        return DB::connection()->getDriverName();
    }

    private function quote(string $identifier): string
    {
        return $this->driver() === 'pgsql'
            ? '"' . str_replace('"', '""', $identifier) . '"'
            : '`' . str_replace('`', '``', $identifier) . '`';
    }

    private function assertSupported(): void
    {
        $driver = $this->driver();

        if ($driver === 'pgsql') {
            return;
        }
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            throw new RuntimeException("Unsupported database driver for this migration: {$driver}.");
        }

        $version = (string) DB::selectOne('select version() as v')->v;
        $isMaria = stripos($version, 'mariadb') !== false;
        $number = preg_match('/\d+\.\d+\.\d+/', $version, $m) ? $m[0] : '0.0.0';
        $minimum = $isMaria ? '10.5.2' : '8.0.0';

        if (version_compare($number, $minimum, '<')) {
            throw new RuntimeException(
                "This migration needs RENAME COLUMN support ({$minimum}+); the server is {$version}. Nothing was changed."
            );
        }
    }

    private function tables(): array
    {
        return array_map(
            fn ($t) => $t['name'] ?? $t,
            Schema::getTables()
        );
    }

    private function renameTables(array $map): void
    {
        $existing = $this->tables();
        $byLower = [];
        foreach ($existing as $name) {
            $byLower[strtolower($name)] = $name;
        }

        foreach ($map as $from => $to) {
            // the actual spelling: "serviceRequests" on MySQL, "servicerequests" in a lower-cased PostgreSQL copy
            $actual = in_array($from, $existing, true) ? $from : ($byLower[strtolower($from)] ?? null);
            if ($actual === null || $actual === $to || isset($byLower[strtolower($to)]) && $byLower[strtolower($to)] === $to) {
                continue;
            }

            DB::statement(sprintf('ALTER TABLE %s RENAME TO %s', $this->quote($actual), $this->quote($to)));
        }
    }

    private function renameColumns(array $map): void
    {
        $byLower = [];
        foreach ($map as $from => $to) {
            $byLower[strtolower($from)] = [$from, $to];
        }

        foreach ($this->tables() as $table) {
            $columns = Schema::getColumnListing($table);
            $present = array_flip($columns);
            $renames = [];

            foreach ($columns as $column) {
                $target = $byLower[strtolower($column)][1] ?? null;
                if ($target === null || $target === $column) {
                    continue;
                }
                if (isset($present[$target])) {
                    // both spellings exist: do not guess
                    echo "  skipped {$table}: both \"{$column}\" and \"{$target}\" exist\n";
                    continue;
                }
                $renames[] = [$column, $target];
            }

            if (!$renames) {
                continue;
            }

            // one statement per column: PostgreSQL does not accept several RENAME COLUMN clauses
            foreach ($renames as [$from, $to]) {
                DB::statement(sprintf(
                    'ALTER TABLE %s RENAME COLUMN %s TO %s',
                    $this->quote($table), $this->quote($from), $this->quote($to)
                ));
            }
        }
    }

    /**
     * PostgreSQL only: trigger functions that use a column by name. A MySQL column such as
     * "startTime ... ON UPDATE CURRENT_TIMESTAMP" becomes a trigger (NEW.starttime = now()) when it is
     * converted to PostgreSQL, and would fail after the rename.
     */
    private function renameInTriggerFunctions(array $map): void
    {
        if ($this->driver() !== 'pgsql') {
            return;
        }

        $functions = DB::select(
            'select distinct p.oid, pg_get_functiondef(p.oid) as def
               from pg_trigger t join pg_proc p on p.oid = t.tgfoid
              where not t.tgisinternal'
        );

        foreach ($functions as $function) {
            $definition = $function->def;
            $updated = $definition;

            foreach ($map as $from => $to) {
                $target = preg_match('/[A-Z]/', $to) ? '"' . $to . '"' : $to;
                $updated = preg_replace(
                    '/\b(NEW|OLD)\.(?:"' . preg_quote($from, '/') . '"|' . preg_quote($from, '/') . ')(?![\w"])/i',
                    '$1.' . $target,
                    $updated
                );
            }

            if ($updated !== $definition) {
                DB::unprepared($updated);
            }
        }
    }

    /**
     * Rows that store names of columns/tables: module search keys, input appearance settings,
     * blocked modules, menu tables and the table lists inside admin react permissions.
     */
    private function renameStoredNames(array $columns, array $tables): void
    {
        // categories.search_keys: "title,project.title,isPaid" -> names after the last dot are columns
        if (Schema::hasTable('categories') && Schema::hasColumn('categories', 'search_keys')) {
            foreach (DB::table('categories')->whereNotNull('search_keys')->get(['id', 'search_keys']) as $row) {
                $keys = array_map(function ($key) use ($columns) {
                    $key = trim($key);
                    $dot = strrpos($key, '.');
                    $name = $dot === false ? $key : substr($key, $dot + 1);
                    $new = $columns[$name] ?? $name;

                    return $dot === false ? $new : substr($key, 0, $dot + 1) . $new;
                }, explode(',', (string) $row->search_keys));
                $value = implode(',', $keys);

                if ($value !== $row->search_keys && trim($row->search_keys) !== $value) {
                    DB::table('categories')->where('id', $row->id)->update(['search_keys' => $value]);
                }
            }
        }

        // input_appearances.column_name (a column of some table)
        if (Schema::hasTable('input_appearances') && Schema::hasColumn('input_appearances', 'column_name')) {
            foreach ($columns as $from => $to) {
                $this->renameValue('input_appearances', 'column_name', $from, $to);
            }
        }

        // table names stored as values
        foreach ([['input_appearances', 'table_name'], ['blocked_modules', 'table_name'], ['mapping', 'table_name'],
                  ['menu_tables', 'child_table_name']] as [$table, $column]) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                foreach ($tables as $from => $to) {
                    $this->renameValue($table, $column, $from, $to);
                }
            }
        }

        // admins.react_permissions: JSON list of table names
        $permissionsColumn = Schema::hasColumn('admins', 'react_permissions') ? 'react_permissions'
            : (Schema::hasColumn('admins', 'reactPermissions') ? 'reactPermissions' : null);
        if ($permissionsColumn) {
            foreach (DB::table('admins')->whereNotNull($permissionsColumn)->get(['id', $permissionsColumn]) as $row) {
                $value = (string) $row->{$permissionsColumn};
                foreach ($tables as $from => $to) {
                    $value = str_replace('"' . $from . '"', '"' . $to . '"', $value);
                }
                if ($value !== (string) $row->{$permissionsColumn}) {
                    DB::table('admins')->where('id', $row->id)->update([$permissionsColumn => $value]);
                }
            }
        }
    }

    // Updates one stored name, unless the new name is already present (unique pairs such as
    // table_name + column_name must not collide).
    private function renameValue(string $table, string $column, string $from, string $to): void
    {
        $rows = DB::table($table)->where($column, $from)->get();

        foreach ($rows as $row) {
            $conflict = DB::table($table)->where($column, $to);
            foreach (['table_name'] as $pair) {
                if ($column !== $pair && isset($row->{$pair})) {
                    $conflict->where($pair, $row->{$pair});
                }
            }
            if (!$conflict->exists()) {
                DB::table($table)->where('id', $row->id)->update([$column => $to]);
            }
        }
    }
};
