<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Campos que se pueden guardar desde el frontend
    protected $fillable = [
        'title',
        'description',
        'completed'
    ];

    // Asegurarme que "completed" sea siempre true/false
    protected $casts = [
        'completed' => 'boolean',
    ];
}
