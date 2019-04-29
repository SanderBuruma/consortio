<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->after('remember_token');
            $table->string('street')->nullable()->after('remember_token');
            $table->integer('streetnr')->nullable()->after('remember_token');
            $table->string('province')->nullable()->after('remember_token');
            $table->string('country')->nullable()->after('remember_token');
            $table->string('telephone1')->nullable()->after('remember_token');
            $table->string('telephone2')->nullable()->after('remember_token');
            $table->string('profilePic')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('street');
            $table->dropColumn('streetnr');
            $table->dropColumn('province');
            $table->dropColumn('country');
            $table->dropColumn('telephone1');
            $table->dropColumn('telephone2');
            $table->dropColumn('profilePic');
        });
    }
}
