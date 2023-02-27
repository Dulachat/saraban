<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;

    protected $fillable = [
        'docs_id',
        'type_id',
        'book_number',
        'title_data',
        'docs_name',
        'docs_detail',
        'path_data',
        'doas_reactive',
        'dos_reactive',
        'branch_reactive',
        'priority',
        'view_docs',
        'created_at',
        'docs_id',
        'update_at',
        'active'
        
    ];
}
