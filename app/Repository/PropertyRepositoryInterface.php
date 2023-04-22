<?php
namespace App\Repository;

interface PropertyRepositoryInterface
{
    public function create(array $data) : array;

    public function list($search = '') : ?\Illuminate\contracts\Pagination\LengthAwarePaginator;

    public function destroy(int $id) : array;

    public function find(int $id) : \App\Models\Property;

    public function update(array $data, int $id) : array;
}