<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatistickData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects_statistic', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('links_data_id')->unsigned();
            $table->foreign('links_data_id')->references('id')->on('links_data')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('ip');
            $table->string('browser_version');
            $table->string('refer_link')->default(null);
            $table->string('country')->default(null);

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
