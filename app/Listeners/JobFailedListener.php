<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class JobFailedListener
{
    public function handle(JobFailed $event): void
    {
        $payload = json_decode($event->job->getRawBody(), true);
        $jobType = $payload['job'] ?? 'unknown';
        $userId  = $payload['data']['command']['user_id'] ?? null;

        $uuid = $event->job->uuid() ?? (string) Str::uuid();

        DB::table('failed_jobs')->updateOrInsert(
            ['uuid' => $uuid],
            [
                'job_type'        => $jobType,
                'user_id'         => $userId,
                'retry_count'     => DB::raw('retry_count + 1'),
                'last_attempt_at' => now(),
                'status'          => 'failed',
                'connection'      => $event->connectionName,
                'queue'           => $event->job->getQueue(),
                'payload'         => $event->job->getRawBody(),
                'exception'       => $event->exception->getMessage(),
                'failed_at'       => Carbon::now(),
            ]
        );
    }
}
