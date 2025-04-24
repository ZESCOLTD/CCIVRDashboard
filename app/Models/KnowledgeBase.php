<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;

 class KnowledgeBase extends Model
 {
     use HasFactory, SoftDeletes;

     protected $fillable = [
         'topic',
         'description',
         'last_updated',
     ];

     protected $casts = [
         'last_updated' => 'datetime',
     ];
 }