<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('appointment1')->nullable();
            $table->text('copyright')->nullable();
            $table->text('meta_data')->nullable();
            $table->unsignedBigInteger('setting_id');
            $table->string('locale')->index();
            $table->unique(['setting_id', 'locale']);
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
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
        Schema::dropIfExists('setting_translations');
    }
}
