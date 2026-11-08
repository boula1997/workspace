<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The app's Money tab: each admin's income per month ("2026-11") and the fixed debts they pay
     * every month. What remains (income minus debts) is worked out by the app, not stored.
     */
    public function up(): void
    {
        if (!Schema::hasTable('money_incomes')) {
            Schema::create('money_incomes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('month', 7);
                $table->decimal('amount', 14, 2);
                $table->timestamps();

                $table->unique(['admin_id', 'month'], 'money_incomes_admin_id_month_unique');
            });
        }

        if (!Schema::hasTable('money_debts')) {
            Schema::create('money_debts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('name');
                $table->decimal('amount', 14, 2);
                $table->timestamps();

                $table->index('admin_id', 'money_debts_admin_id_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('money_debts');
        Schema::dropIfExists('money_incomes');
    }
};
