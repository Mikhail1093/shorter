<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IpGeoBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_geo_base', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip')->unique();
            $table->timestamps();
            $table->string('city')->default(null);
            $table->string('state')->default(null);
            $table->string('country')->default(null);
            $table->string('country_code');
            $table->string('continent');
            $table->string('continent_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
