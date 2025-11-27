<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileNameToStasisCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stasis_cdr', function (Blueprint $table) {
            // Adding the file_name column to link to the Recordings model.
            // It is nullable because some CDR entries might not have an associated recording.
            $table->string('file_name')
                  ->after('caller_number') // Positioning it logically near other identifiers
                  ->nullable()
                  ->index()
                  ->comment('The base name of the recording file, used to link to the Recordings table.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stasis_cdr', function (Blueprint $table) {
            $table->dropIndex(['file_name']); // Drop the index first
            $table->dropColumn('file_name');
        });
    }
}