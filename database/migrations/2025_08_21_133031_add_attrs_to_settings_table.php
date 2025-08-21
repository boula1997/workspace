<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer("pricePerHour")->default(150);
            $table->integer("editsPercent")->default(20);
            $table->integer("negotiatePercent")->default(20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn("pricePerHour");
            $table->dropColumn("editsPercent");
            $table->dropColumn("negotiatePercent");
        });
    }
};
