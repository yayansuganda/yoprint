<?php
namespace App\Traits;

use Spatie\SimpleExcel\SimpleExcelReader;

trait GetDataRows
{
    public function getDataRows($file, $header) {
        return SimpleExcelReader::create($file, type:'csv')
                                ->useHeaders($header)
                                ->getRows();
    }
}
