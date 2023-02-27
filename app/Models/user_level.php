<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_level extends Model
{
    use HasFactory;
    protected $fillable = [
        'u_level_id',
        'lv_name',
    ];
}
