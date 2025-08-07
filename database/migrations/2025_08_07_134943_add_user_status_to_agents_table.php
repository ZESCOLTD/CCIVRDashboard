<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserStatusToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // We use Schema::table() because we are modifying an existing table.
        Schema::table('agents', function (Blueprint $table) {
            // Add the new 'user_status' column.
            // It's a string type.
            // We make it nullable() in case existing rows don't have a value.
            // We place it after the 'status' column for logical organization.
            $table->string('user_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This method is for rolling back the migration.
        Schema::table('agents', function (Blueprint $table) {
            // It simply removes the column we added in the 'up' method.
            $table->dropColumn('user_status');
        });
    }
}
