<?php

namespace App\Services;

use App\Repositorys\InterfaceRepositorys;
use Illuminate\Http\Request;

interface InterfaceService
{
    public function __construct(InterfaceRepositorys $repository);

    public function importService($data);
}

