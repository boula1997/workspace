<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {dd("Not allowed");
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->boolean('status')->default(0);            
            $table->unsignedBigInteger('employee_id')->nullable(); 
            $table->foreign('employee_id')->references('id')->on('admins')->onDelete('cascade');
            $table->boolean('difficulty')->default(0);
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
        Schema::dropIfExists('followups');
    }
}
