<?php
namespace App\Repository;

interface PropertyRepositoryInterface
{
    public function create(array $data) : array;   
}