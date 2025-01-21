<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {dd("Not allowed");
        Schema::create('accountants', function (Blueprint $table) {
            $table->id();
            $table->double('received')->default(0);

            $table->unsignedBigInteger('employee_id')->nullable(); $table->foreign('employee_id')->references('id')->on('admins')->onDelete('cascade');
            
            $table->double('has')->default(0);
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
        Schema::dropIfExists('accountants');
    }
}
