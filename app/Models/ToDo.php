<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class ToDo extends Model
  {
    use HasFactory;
    protected $fillable = [
      'name',
      'status',
      'completed_at'
    ];
    protected $casts = [
      'completed_at' => 'datetime:Y-m-d h:i:s'
    ];
  }
