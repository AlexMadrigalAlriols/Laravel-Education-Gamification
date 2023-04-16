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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id("id_tasks");
            $table->unsignedBigInteger("id_category")->nullable();
            $table->unsignedBigInteger("id_course_uf")->nullable();
            $table->enum('type',["task","forum","exam","file","link","page"]);
            $table->string('title');
            $table->string('description');
            $table->text('file_rubrica')->nullable();
            $table->text('contents');
            $table->date('limit_date')->nullable();
            $table->integer('percentage');
            $table->integer('max_mark');
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
        Schema::dropIfExists('tasks');
    }
};
