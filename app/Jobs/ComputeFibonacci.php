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
    public $userTimeout;
    public $failOnTimeout = true;

    // I've tried. this does not work
    // public $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $numb, int $userTimeout)
    {
        // I've tried. this does not work. provided a workaround to tackle this
        // $this->timeout = $userTimeout;

        $this->numb = $numb;
        $this->userTimeout = now()->addSeconds($userTimeout + 2);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = $this->compute($this->numb);

        if ($result == 'failed') return;

        Fibonacci::first()->update([
            'status' => Fibonacci::PROCESSED,
            'result' => $result
        ]);
    }

    private function compute($numb)
    {
        if ($numb <= 1) return 1;

        if ($this->userTimeout->toDateTimeString() == now()->toDateTimeString()) {
            $this->fail(new \Exception('get Timedout'));
            $this->delete();
            return 'failed';
        }

        return $this->compute($numb - 1) + $this->compute($numb - 2);
    }
}
