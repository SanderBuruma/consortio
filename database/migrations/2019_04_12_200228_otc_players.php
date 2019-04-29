<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OtcPlayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otc_players', function (Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('db_id')->unique();
            $table->integer('total_matches')->default(0);
            $table->integer('total_matches_ffa')->default(0);
            $table->integer('rank')->default(999);
            $table->integer('rank_ffa')->default(999);
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
        Schema::dropIfExists('otc_players');
    }
}
