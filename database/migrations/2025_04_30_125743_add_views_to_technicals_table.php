<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('technicals', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('technicals', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
