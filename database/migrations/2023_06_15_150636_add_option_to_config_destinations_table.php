<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionToConfigDestinationsTable extends Migration
{

    protected $connection = 'mysql';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_destinations', function (Blueprint $table) {
            //
            $table->string('option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_destinations', function (Blueprint $table) {
            //
        });
    }
}
