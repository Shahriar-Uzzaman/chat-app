<?php

namespace App\Repositories\Contracts\Location;

interface CountryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getByName(string $name);
    public function getByIso2(string $iso2);
    public function store(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
