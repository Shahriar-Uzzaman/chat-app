<?php

namespace App\Services\Location;

use App\Repositories\Contracts\Location\CountryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CountryService
{
    public function __construct(public CountryRepositoryInterface $locationRepo)
    {}

    public function getAll()
    {
        return $this->locationRepo->getAll();
    }

    public function getById(int $id)
    {
        try {
            $location = $this->locationRepo->getById($id);
            if (!$location) {
                throw new \Exception("Country not found!");
            }

            return $location;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $name = trim($data['name']);
            $isNameExists = $this->locationRepo->getByName($name);
            if ($isNameExists) {
                throw new \Exception("Country already exists!");
            }

            $iso2 = trim($data['iso2']);
            $isIso2Exists = $this->locationRepo->getByIso2($iso2);
            if ($isIso2Exists) {
                throw new \Exception("Country code already exists!");
            }

            $newCountry = $this->locationRepo->store([
                'name' => $name,
                'iso2' => strtoupper($iso2),
            ]);
            DB::commit();
            return $newCountry;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $country = $this->locationRepo->getById($id);
            if (!$country) {
                throw new \Exception("Country not found!");
            }

            $this->locationRepo->update($id, $data);
            DB::commit();
            return $this->locationRepo->getById($id);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $country = $this->locationRepo->getById($id);
            if (!$country) {
                throw new \Exception("Country not found!");
            }

            $this->locationRepo->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
