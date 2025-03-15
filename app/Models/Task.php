<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'sample_input',
        'sample_output',
        'test_cases'
    ];

    protected $casts = [
        'test_cases' => 'array'
    ];
}
