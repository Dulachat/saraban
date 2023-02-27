<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class government extends Model
{
    use HasFactory;
    protected $fillable = [
        'government_id',
        'government_name'
    ];
}
