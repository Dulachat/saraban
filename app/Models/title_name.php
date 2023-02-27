<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class title_name extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_name_id',
        'u_id',
        'title_name',
    ];
}
