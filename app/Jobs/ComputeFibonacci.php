<?php

namespace App\Jobs;

use App\Models\Fibonacci;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeFibonacci implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $numb;
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $numb)
    {
        $this->numb = $numb;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = Fibonacci::compute($this->numb);

        dump($result);

        $fib = Fibonacci::first();

        if ($fib->status == Fibonacci::FAILED) return;

        $fib->update([
            'status' => Fibonacci::PROCESSED,
            'result' => $result
        ]);
    }
}
