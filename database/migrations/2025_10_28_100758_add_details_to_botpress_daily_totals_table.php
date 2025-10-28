<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToBotpressDailyTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('other_channels', function (Blueprint $table) {
            // Use TEXT to allow for long content (up to 65,535 bytes)
            $table->text('details')->nullable()->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('other_channels', function (Blueprint $table) {
            $table->dropColumn('details');
        });
    }
}
