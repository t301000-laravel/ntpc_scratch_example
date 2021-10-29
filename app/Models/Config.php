<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'enable'];

    public $timestamps = false; // 不需要 created_at and updated_at
}
