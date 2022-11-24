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

    public static function compute(int $num)
    {
        if ($num <= 1) return 1;

        return round(pow((sqrt(5) + 1) / 2, $num) / sqrt(5));
    }
}
