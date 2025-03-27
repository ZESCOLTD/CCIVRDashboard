<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('man_no')->unique();
            $table->string('nrc')->nullable()->unique();
            $table->string('name')->nullable();

            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();

            $table->date('dob')->nullable();
            $table->string('sex',10)->nullable();

            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->string('bu_code')->nullable();
            $table->string('cc_code')->nullable();
            $table->string('bu_name')->nullable();
            $table->string('cc_name')->nullable();

            $table->string('directorate')->nullable();
            $table->string('division')->nullable();
            $table->string('location')->nullable();
            $table->string('functional_section')->nullable();
            $table->string('station')->nullable();
            $table->string('position')->nullable();
            $table->string('job_code')->nullable();
            $table->string('job_title')->nullable();
            $table->string('grade')->nullable();

            $table->integer('status')->default(1)->comment("0 -> inactive, 1 -> active, 2 -> blocked");//0 ->inactive, 1 -> active, 2 -> blocked

            $table->boolean('is_banned')->default(false);
            $table->timestamp('banned_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
