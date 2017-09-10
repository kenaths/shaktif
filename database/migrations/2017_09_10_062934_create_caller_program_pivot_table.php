<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallerProgramPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caller_program', function (Blueprint $table) {
            $table->integer('caller_id')->unsigned()->index();
            //$table->foreign('caller_id')->references('id')->on('caller')->onDelete('cascade');
            $table->integer('program_id')->unsigned()->index();
            //$table->foreign('program_id')->references('id')->on('program')->onDelete('cascade');
            $table->primary(['caller_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('caller_program');
    }
}
