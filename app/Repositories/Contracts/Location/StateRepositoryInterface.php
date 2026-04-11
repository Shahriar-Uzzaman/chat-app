<?php

namespace App\Repositories\Contracts\Location;

interface StateRepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function getByCountryId(int $countryId);
    public function getByName(string $name);
    public function store(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
