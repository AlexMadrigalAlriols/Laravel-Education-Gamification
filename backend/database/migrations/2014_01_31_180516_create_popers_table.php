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
        Schema::create('popers', function (Blueprint $table) {
            $table->id('id_poper');
            $table->string("poper_name");
            $table->text("skin");
            $table->integer("level");
            $table->integer("current_exp");
            $table->text("stats");
            $table->text("stats_base");
            $table->text("abilities");
            $table->enum('element',["wild","ember","water","psyco","smog","brawny"]);
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
        Schema::dropIfExists('popers');
    }
};
