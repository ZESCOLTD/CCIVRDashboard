<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Add this line

class RemoveOnUpdateFromStartedAtInAgentBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('agent_breaks', function (Blueprint $table) {
            // Drop the existing 'started_at' column
            $table->dropColumn('started_at');
        });

        Schema::table('agent_breaks', function (Blueprint $table) {
            // Re-add the 'started_at' column without ON UPDATE CURRENT_TIMESTAMP
            // It should be nullable or have a default, but NOT update on every change.
            // We'll give it a default CURRENT_TIMESTAMP, which will be overridden by Laravel's now()
            // when you create a new record.
            $table->timestamp('started_at')
                  ->after('agent_id') // Maintain column order
                  ->default(DB::raw('CURRENT_TIMESTAMP')); // No ON UPDATE here!
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agent_breaks', function (Blueprint $table) {
            // For rollback, drop the corrected column
            $table->dropColumn('started_at');
        });

        Schema::table('agent_breaks', function (Blueprint $table) {
            // Re-add the column with the original (incorrect) definition
            $table->timestamp('started_at')
                  ->after('agent_id') // Maintain column order
                  ->default(DB::raw('CURRENT_TIMESTAMP'))
                  ->useCurrentOnUpdate(); // This re-adds the problematic clause
        });
    }
}
