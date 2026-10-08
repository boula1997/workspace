<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ready-made gig messages (App\Models\ReadyClientResbonseMessage):
 *
 *  - `type` becomes `gig_type` and only allows 'freelance' | 'job'.
 *  - New `is_comment`  (default false): the message is meant for a post COMMENT; false = private message.
 *  - New `is_personal` (default true):  sent as Boula Nessim; false = sent as the Blanko company.
 *
 * The old `type` also had a third value, 'comment' (borrowed by freelance gigs when replying on a
 * post). Those rows become gig_type = 'freelance' + is_comment = true, which is exactly how the app
 * used them. Any other / empty `type` value stops the migration before anything is changed.
 *
 * Works on MySQL/MariaDB (native ENUM) and PostgreSQL (CHECK constraint). The native column rename
 * needs MySQL 8.0.3+ / MariaDB 10.5.2+ (Laravel 10 without doctrine/dbal).
 */
return new class extends Migration
{
    private string $table = 'ready_client_resbonse_messages';
    private string $checkName = 'ready_client_resbonse_messages_gig_type_check';

    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            // A database that never had this table (e.g. a local copy): create it in the new shape.
            Schema::create($this->table, function (Blueprint $table) {
                $table->id();
                $table->text('message');
                $table->string('language', 10);
                $table->enum('gig_type', ['freelance', 'job'])->default('freelance');
                $table->boolean('is_comment')->default(false);
                $table->boolean('is_personal')->default(true);
                $table->unsignedTinyInteger('isActive')->default(1);
                $table->timestamps();
            });
            return;
        }

        if (Schema::hasColumn($this->table, 'type') && !Schema::hasColumn($this->table, 'gig_type')) {
            $unexpected = DB::table($this->table)
                ->where(fn ($q) => $q->whereNull('type')->orWhereNotIn('type', ['freelance', 'job', 'comment']))
                ->distinct()
                ->pluck('type')
                ->map(fn ($v) => $v === null ? 'NULL' : "'{$v}'")
                ->all();

            if ($unexpected) {
                throw new RuntimeException(
                    "{$this->table}.type contains values that cannot become freelance/job: "
                    . implode(', ', $unexpected) . '. Fix or remove those rows, then run this migration again. Nothing was changed.'
                );
            }

            Schema::table($this->table, function (Blueprint $table) {
                $table->renameColumn('type', 'gig_type');
            });
        }

        if (!Schema::hasColumn($this->table, 'is_comment')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->boolean('is_comment')->default(false)->after('gig_type');
            });
        }

        if (!Schema::hasColumn($this->table, 'is_personal')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->boolean('is_personal')->default(true)->after('is_comment');
            });
        }

        // 'comment' was a type of its own; it is now freelance + is_comment.
        DB::table($this->table)
            ->where('gig_type', 'comment')
            ->update(['gig_type' => 'freelance', 'is_comment' => true]);

        $this->restrictGigType();
    }

    public function down(): void
    {
        if (!Schema::hasTable($this->table) || !Schema::hasColumn($this->table, 'gig_type')) {
            return;
        }

        // Best effort: it cannot be known which comment rows were 'comment' before and which are new.
        $this->releaseGigType();

        if (Schema::hasColumn($this->table, 'is_comment')) {
            DB::table($this->table)->where('is_comment', true)->update(['gig_type' => 'comment']);
        }

        Schema::table($this->table, function (Blueprint $table) {
            foreach (['is_comment', 'is_personal'] as $column) {
                if (Schema::hasColumn($this->table, $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->renameColumn('gig_type', 'type');
        });
    }

    private function restrictGigType(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE `{$this->table}` MODIFY `gig_type` ENUM('freelance','job') NOT NULL DEFAULT 'freelance'");
        } elseif ($driver === 'pgsql') {
            $exists = DB::selectOne(
                'SELECT 1 AS found FROM pg_constraint WHERE conname = ? AND conrelid = ?::regclass',
                [$this->checkName, $this->table]
            );
            if (!$exists) {
                DB::statement(
                    "ALTER TABLE \"{$this->table}\" ADD CONSTRAINT \"{$this->checkName}\" CHECK (\"gig_type\"::text IN ('freelance','job'))"
                );
            }
        }
    }

    private function releaseGigType(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE `{$this->table}` MODIFY `gig_type` VARCHAR(20) NOT NULL DEFAULT 'freelance'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE \"{$this->table}\" DROP CONSTRAINT IF EXISTS \"{$this->checkName}\"");
        }
    }
};
