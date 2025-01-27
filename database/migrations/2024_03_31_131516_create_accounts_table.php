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
        //dd("Make sure you took a backup of data");
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->integer('cost');
            $table->integer('payed');
            $table->integer('debit');
            $table->boolean('status')->default(0);
            $table->boolean('appearance')->default(0);
            $table->boolean('deal')->default(0);
            $table->date('deadline')->nullable();
            $table->date('lastTransaction')->nullable();
            $table->integer('fees');
            $table->longText('tasks')->nullable();
            $table->longText('codeLinks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
