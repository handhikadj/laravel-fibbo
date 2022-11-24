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
use Illuminate\Support\Facades\Artisan;

class TimeoutWatcher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userTimeout = null;
    public $failOnTimeout = true;

    private $timeoutInitial = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?int $userTimeout)
    {
        $this->userTimeout = $userTimeout;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->userTimeout) {
            while (true) {
                sleep(1);

                $fibMod = Fibonacci::first();

                if ($fibMod->status == Fibonacci::PROCESSED) {
                    return;
                }

                if ($fibMod->status == Fibonacci::FAILED) {
                    return;
                }

                if ($this->userTimeout == $this->timeoutInitial && $fibMod->status == Fibonacci::PROCESSING) {
                    $this->fail(new Exception('get timedout'));
                    Artisan::call('queue:clear');
                    return;
                } else {
                    $this->timeoutInitial++;
                }
            }
        }
    }
}
