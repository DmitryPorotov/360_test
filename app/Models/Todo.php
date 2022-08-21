<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'user_id',
        'description',
        'is_done'
    ];

    protected $casts = [
        'is_done' => 'boolean'
    ];
}
