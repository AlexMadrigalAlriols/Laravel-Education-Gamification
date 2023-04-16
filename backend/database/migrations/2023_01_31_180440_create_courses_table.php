<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->increments("id_course")->unique();
            $table->string('code')->unique();
            $table->string("course_name");
            $table->unsignedBigInteger("id_teacher");
            $table->unsignedBigInteger("id_college");
            $table->string("img")->default("null");
            $table->text("shop")->default('{}');
            $table->text("requests")->default('[]');
            $table->text("tasks")->default('{}');;
            $table->timestamps();
            $table->foreign('id_college')->references('id_college')->on('colleges');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
