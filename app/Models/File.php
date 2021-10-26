<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class File extends Model
{
    use HasFactory, HasEagerLimit;

    protected $fillable = ['user_id', 'path'];
}
