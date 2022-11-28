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
    public $timeout = 120;
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $numb, int $userTimeout)
    {
        $this->numb = $numb;
        $this->timeout = $userTimeout;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = $this->compute($this->numb);

        Fibonacci::first()->update([
            'status' => Fibonacci::PROCESSED,
            'result' => $result
        ]);
    }

    private function compute($numb)
    {
        if ($numb <= 1) return 1;

        return $this->compute($numb - 1) + $this->compute($numb - 2);
    }
}
