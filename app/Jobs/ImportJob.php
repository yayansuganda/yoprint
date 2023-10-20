<?php

namespace App\Jobs;

use App\Handler\UpsertHandler;
use App\Repositorys\ImportRepositorys;
use App\Services\ImportService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            StatusJob::dispatch()->onQueue('yoprint')->onConnection('redis');
            (new ImportService(new ImportRepositorys))->importService($this->data);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

}
