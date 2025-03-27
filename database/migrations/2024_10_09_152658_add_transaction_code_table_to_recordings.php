<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCodeTableToRecordings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->integer('transaction_code')->nullable(); // Add your new field here
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->dropColumn('transaction_code');
        });
    }
}
