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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string("name");
            $table->string("last_name");
            $table->string("nick")->unique();
            $table->string("email")->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("password");
            $table->enum('role',["student","teacher","college_manager","admin"]);
            $table->integer("pepas")->default(0);
            $table->string("profile_img")->default("/assets/img/prueba.png");
            $table->unsignedBigInteger("id_college")->nullable();
            $table->json("courses");
            $table->unsignedBigInteger("id_poper")->nullable();
            $table->json("inventory");
            $table->date("birth_date")->nullable();
            $table->boolean("force_change_pass")->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_college')->references('id_college')->on('colleges');
            $table->foreign('id_poper')->references('id_poper')->on('popers');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
