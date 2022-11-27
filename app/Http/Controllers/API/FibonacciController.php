<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ComputeFibonacci;
use App\Jobs\TimeoutWatcher;
use App\Models\Fibonacci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FibonacciController extends Controller
{
    public function result()
    {
        $fibo = Fibonacci::first();

        if ($fibo->status == Fibonacci::PROCESSING) {
            return [
                'status' => 'Processing',
                'result' => null
            ];
        }

        if ($fibo->status == Fibonacci::FAILED) {
            return [
                'status' => 'Failed due to timeout',
                'result' => null
            ];
        }

        return [
            'status' => 'Processed',
            'result' => $fibo->result
        ];
    }

    public function compute()
    {
        request()->validate([
            'numb' => 'required|integer',
            'timeout' => 'integer'
        ]);

        $fibo = Fibonacci::first();

        if ($fibo->status == Fibonacci::PROCESSING) {
            return response()->json([
                'message' => "Cannot process request. We're still computing the result. Visit /result endpoint to see the status"
            ], 422);
        }

        Fibonacci::first()->update([
            'status' => Fibonacci::PROCESSING
        ]);

        ComputeFibonacci::dispatch(request()->numb, request()->timeout);

        return [
            'message' => "Request accepted. Computing... Visit /result endpoint to see the status"
        ];
    }
}
