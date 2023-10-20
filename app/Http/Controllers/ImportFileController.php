<?php

namespace App\Http\Controllers;

use App\Events\StatusJobEvent;
use App\Http\Requests\ImportRequest;
use App\Jobs\ImportJob;
use App\Jobs\StatusJob;
use App\Models\ImportFile;
use App\Traits\GetDataRows;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class ImportFileController extends Controller
{
    use GetDataRows;

    public function index(){
        $batches = DB::table('job_batches')->get();
        return view('index', compact('batches'));
    }

    public function store(ImportRequest $request){
        $headerCsv =  ImportFile::headerCsv();
        $data = $this->getDataRows($request->file, $headerCsv);
        $batch = Bus::batch([new ImportJob(collect($data))])
                    ->onQueue('yoprint')
                    ->onConnection('redis')
                    ->name($request->file->getClientOriginalName())
                    ->dispatch();
        return $batch;
    }

    public function batch($batch) {
        $cek = Bus::findBatch($batch);
        return $cek;
    }
}
