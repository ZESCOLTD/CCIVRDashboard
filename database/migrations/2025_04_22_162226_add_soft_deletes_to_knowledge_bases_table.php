<?php

 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;

 class AddSoftDeletesToKnowledgeBasesTable extends Migration
 {
     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::table('knowledge_bases', function (Blueprint $table) {
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
         Schema::table('knowledge_bases', function (Blueprint $table) {
             $table->dropSoftDeletes();
         });
     }
 }