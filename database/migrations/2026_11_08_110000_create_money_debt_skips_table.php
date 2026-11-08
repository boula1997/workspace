<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Months in which a fixed debt is skipped (not paid), so the Money tab leaves it out of that
     * month's remaining. A debt with no row for a month is counted as usual.
     */
    public function up(): void
    {
        if (Schema::hasTable('money_debt_skips')) {
            return;
        }

        Schema::create('money_debt_skips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('money_debt_id')->constrained('money_debts')->cascadeOnDelete();
            $table->string('month', 7);
            $table->timestamps();

            $table->unique(['money_debt_id', 'month'], 'money_debt_skips_debt_month_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('money_debt_skips');
    }
};
