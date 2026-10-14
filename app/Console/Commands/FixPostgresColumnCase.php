<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Restores camelCase column names (isActive, isMultiply, ...) on a PostgreSQL database that was
 * imported from MySQL.
 *
 * MySQL column names are case-insensitive, so the code reads `isActive`; PostgreSQL folds unquoted
 * names to lower case, so a converted dump has `isactive`. Laravel quotes identifiers, so every
 * query for "isActive" then fails with "column ... does not exist".
 *
 *   php artisan db:fix-pg-column-case            preview only
 *   php artisan db:fix-pg-column-case --apply    rename (one transaction)
 */
class FixPostgresColumnCase extends Command
{
    protected $signature = 'db:fix-pg-column-case
                            {--apply : Rename the columns (default is a preview that changes nothing)}
                            {--connection= : Connection to fix (default: the default connection)}
                            {--extra= : More camelCase column names, comma separated}';

    protected $description = 'Rename lower-cased PostgreSQL columns (isactive) back to the camelCase names the code uses (isActive)';

    // Column names the application reads in camelCase (from the migrations and the code).
    private const NAMES = [
        'clickTime', 'editsPercent', 'githubDevModeLinkBack', 'githubDevModeLinkFront', 'hasPhone',
        'isActive', 'isCreate', 'isEdit', 'isExcavation', 'isFixed', 'isGeneral', 'isHosted', 'isIndex',
        'isMultiply', 'isNotification', 'isOverthinking', 'isPaid', 'isPersonal', 'isShow', 'isYousab',
        'lastTransaction', 'negotiatePercent', 'newsletterEmail', 'pricePerHour', 'reactPermissions',
        'renewalDate', 'reqType', 'reqValue', 'routesLink', 'screenCard', 'serviceRequest', 'startTime',
        'stopClosing',
    ];

    public function handle(): int
    {
        $connection = DB::connection($this->option('connection') ?: null);

        if ($connection->getDriverName() !== 'pgsql') {
            $this->error('This command is only for PostgreSQL (this connection uses ' . $connection->getDriverName() . ').');
            return self::FAILURE;
        }

        $extra = array_filter(array_map('trim', explode(',', (string) $this->option('extra'))));
        $wanted = [];
        foreach (array_merge(self::NAMES, $extra) as $name) {
            $wanted[strtolower($name)] = $name;
        }

        $schema = $connection->getConfig('schema') ?: 'public';
        $columns = $connection->select(
            "select c.table_name, c.column_name
               from information_schema.columns c
               join information_schema.tables t
                 on t.table_schema = c.table_schema and t.table_name = c.table_name and t.table_type = 'BASE TABLE'
              where c.table_schema = ?
              order by c.table_name, c.ordinal_position",
            [$schema]
        );

        $existing = [];
        foreach ($columns as $column) {
            $existing[$column->table_name][$column->column_name] = true;
        }

        $renames = [];
        $skipped = [];
        foreach ($columns as $column) {
            $target = $wanted[strtolower($column->column_name)] ?? null;
            if ($target === null || $target === $column->column_name) {
                continue;
            }
            // only the lower-case fold is renamed; anything else is a deliberate spelling
            if ($column->column_name !== strtolower($column->column_name)) {
                continue;
            }
            if (isset($existing[$column->table_name][$target])) {
                $skipped[] = [$column->table_name, $column->column_name, $target];
                continue;
            }
            $renames[] = [$column->table_name, $column->column_name, $target];
        }

        if (!$renames && !$skipped) {
            $this->info('Nothing to do: no lower-cased camelCase columns found in schema "' . $schema . '".');
            return self::SUCCESS;
        }

        if ($renames) {
            $this->table(['Table', 'Column now', 'Becomes'], $renames);
        }
        foreach ($skipped as [$table, $from, $to]) {
            $this->warn("Skipped {$table}: both \"{$from}\" and \"{$to}\" exist - resolve by hand.");
        }

        if (!$this->option('apply')) {
            $this->line(count($renames) . ' column(s) would be renamed in ' . count(array_unique(array_column($renames, 0)))
                . ' table(s). Preview only - run again with --apply to rename.');
            return self::SUCCESS;
        }

        $quote = fn (string $identifier) => '"' . str_replace('"', '""', $identifier) . '"';

        $connection->transaction(function () use ($connection, $renames, $schema, $quote) {
            foreach ($renames as [$table, $from, $to]) {
                $connection->statement(sprintf(
                    'ALTER TABLE %s.%s RENAME COLUMN %s TO %s',
                    $quote($schema), $quote($table), $quote($from), $quote($to)
                ));
            }
        });

        $this->info('Renamed ' . count($renames) . ' column(s).');
        return self::SUCCESS;
    }
}
