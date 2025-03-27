<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->string('code')->default(0);
            $table->string('name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_types');
    }
};
