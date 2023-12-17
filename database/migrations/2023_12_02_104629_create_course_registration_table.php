<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegistrationTable extends Migration
{
    public function up()
    {
        Schema::create('course_registration', function (Blueprint $table) {

            $table->primary(['course_id', 'registration_id']);

            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('registration_id');

            $table->enum('group', ['A', 'E']);

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_registration');
    }
}
