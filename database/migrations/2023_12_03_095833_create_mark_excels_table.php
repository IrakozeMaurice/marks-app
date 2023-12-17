<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkExcelsTable extends Migration
{

    public function up()
    {
        Schema::create('mark_excels', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('mark_id');

            $table->string('column0')->nullable();
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            $table->string('column3')->nullable();
            $table->string('column4')->nullable();
            $table->string('column5')->nullable();
            $table->string('column6')->nullable();
            $table->string('column7')->nullable();
            $table->string('column8')->nullable();
            $table->string('column9')->nullable();

            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mark_excels');
    }
}
