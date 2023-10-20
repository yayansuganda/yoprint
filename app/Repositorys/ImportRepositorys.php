<?php
namespace App\Repositorys;

use App\Models\ImportFile;
use Illuminate\Support\Facades\DB;

class ImportRepositorys implements InterfaceRepositorys
{
    public function updateOrInsert(array $data)
    {
        ImportFile::upsert($data, ['unique_key']);
    }

    public function getJobBatche()  {
        return DB::table('job_batches')->get();
    }

}
