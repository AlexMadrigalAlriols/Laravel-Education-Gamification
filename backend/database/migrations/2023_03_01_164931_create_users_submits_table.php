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
        Schema::create('users_submits', function (Blueprint $table) {
            $table->id("id_users_submits");
            $table->unsignedBigInteger("id_tasks")->nullable();
            $table->unsignedBigInteger("id_user")->nullable();
            $table->text('submit');
            $table->integer("mark")->default(0);
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
        Schema::dropIfExists('users_submits');
    }
};
