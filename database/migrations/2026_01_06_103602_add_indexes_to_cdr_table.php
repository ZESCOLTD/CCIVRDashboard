<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Add this at the top

class AddIndexesToCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Disable strict mode for THIS session only
        DB::statement("SET SESSION sql_mode = ''");

        // 2. Run the index commands
        DB::statement('ALTER TABLE `cdr` ADD INDEX `idx_calldate_dst` (`calldate`, `dst`)');
        DB::statement('ALTER TABLE `cdr` ADD INDEX `idx_calldate_disposition` (`calldate`, `disposition`)');
        DB::statement('ALTER TABLE `cdr` ADD INDEX `idx_calldate_src` (`calldate`, `src`)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `cdr` DROP INDEX `idx_calldate_dst`');
        DB::statement('ALTER TABLE `cdr` DROP INDEX `idx_calldate_disposition`');
        DB::statement('ALTER TABLE `cdr` DROP INDEX `idx_calldate_src`');
    }
}
