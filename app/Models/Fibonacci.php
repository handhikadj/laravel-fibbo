<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fibonacci extends Model
{
    use HasFactory;

    const PROCESSING = 0;
    const PROCESSED = 1;
    const FAILED = 2;

    protected $fillable = [
        'status',
        'result'
    ];
}
