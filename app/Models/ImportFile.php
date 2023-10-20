<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function headerCsv() {
        return  [
                    'unique_key',
                    'product_title',
                    'product_description',
                    'style',
                    'sanmar_mainframe_color',
                    'size',
                    'color_name',
                    'piece_price'
                ];
    }

}
