<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class RetryFailedJobsCommand extends Command
{
    protected $signature = 'jobs:retry-failed';
    protected $description = 'Retry failed jobs with retry_count < 3';

    public function handle()
    {
        $failedJobs = DB::table('failed_jobs')
            ->where('retry_count', '<', 3)
            ->where('status', 'failed')
            ->get();

        foreach ($failedJobs as $job) {
            try {
                Queue::connection($job->connection)->pushRaw($job->payload, $job->queue);

                DB::table('failed_jobs')->where('id', $job->id)->update([
                    'retry_count'     => $job->retry_count + 1,
                    'last_attempt_at' => now(),
                    'status'          => 'retrying'
                ]);

                $this->info("Retried Job ID: {$job->id}");
            } catch (\Throwable $e) {
                $this->error("Retry failed for Job ID: {$job->id} — {$e->getMessage()}");
            }
        }
    }
}
