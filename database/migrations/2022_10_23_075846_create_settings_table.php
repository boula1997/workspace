<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {dd("Not allowed");
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('white_logo')->nullable();
            $table->string('tab')->nullable();
            $table->string('image')->nullable();
            $table->text('map')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
