<?php
namespace App\Repository;

interface PropertyRepositoryInterface
{
    public function create(array $data) : array;

    public function list($search = '') : ?\Illuminate\contracts\Pagination\LengthAwarePaginator;
}