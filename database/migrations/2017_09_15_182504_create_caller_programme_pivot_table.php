<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallerProgrammePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caller_programme', function (Blueprint $table) {
            $table->integer('caller_id')->unsigned()->index();
            //$table->foreign('caller_id')->references('id')->on('caller')->onDelete('cascade');
            $table->integer('programme_id')->unsigned()->index();
            //$table->foreign('programme_id')->references('id')->on('programme')->onDelete('cascade');
            $table->primary(['caller_id', 'programme_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('caller_programme');
    }
}
