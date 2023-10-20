<?php
namespace App\Services;

use App\Repositorys\InterfaceRepositorys;

class ImportService implements InterfaceService
{
    private $repository;
    public function __construct(InterfaceRepositorys $repository)
    {
        $this->repository = $repository;
    }

    public function importService($data)
    {
        foreach (collect($data)->chunk(500) ?? [] as $item) {
            $this->repository->updateOrInsert($item->toArray() ?? []);
        }
    }

}
