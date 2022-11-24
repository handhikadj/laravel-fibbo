<?php

namespace App\Console\Commands;

use App\Models\Fibonacci;
use Illuminate\Console\Command;

class ComputeFibo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:fibo {numb}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute Fibonacci';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $numb = $this->argument('numb');

        $result = Fibonacci::compute($numb);

        // Fibonacci::first()->update([
        //     'status' => Fibonacci::PROCESSED,
        //     'result' => $result
        // ]);
    }
}
