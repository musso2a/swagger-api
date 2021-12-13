<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['body', 'user_id', 'completed'];

    protected $hidden = [
        'id',
        'user_id',
    ];
}
