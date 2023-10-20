<?php

namespace App\Jobs;

use App\Events\StatusJobEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class StatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $batches = DB::table('job_batches')->get();
        foreach ($batches as $value) {
            $data = Bus::findBatch($value->id);
                if (is_null($data->cancelled_at)) {
                    $status = "";
                    if ($data->failedJobs != 0) {
                        $status = "Failed";
                    } else if ($data->pendingJobs != 0) {
                        $status = "Pending";
                    } else {
                        $status = "Completed";
                    }

                    do {
                        event(new StatusJobEvent($value->id, $status, $data->progress()));
                    } while ($data->progress() < 100 );
                }
        }
    }
}
