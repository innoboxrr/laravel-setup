<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RetryFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retry-failed-jobs';

    protected $description = 'Retry all failed jobs';

    public function handle()
    {
        // Obtener todos los trabajos fallidos
        $failedJobs = DB::table('failed_jobs')->get();

        // Registrar las excepciones de los trabajos fallidos
        foreach ($failedJobs as $job) {
            Log::error('Failed job', [
                'id' => $job->id,
                'connection' => $job->connection,
                'queue' => $job->queue,
                'payload' => $job->payload,
                'exception' => $job->exception,
                'failed_at' => $job->failed_at,
            ]);
        }

        Artisan::call('queue:retry', ['id' => 'all']);
        $this->info('All failed jobs have been requeued.');
    }
}
