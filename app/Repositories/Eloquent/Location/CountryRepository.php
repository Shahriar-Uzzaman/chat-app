<?php

namespace App\Repositories\Eloquent\Location;

use App\Models\Country;
use App\Repositories\Contracts\Location\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    public function getAll()
    {
        $name = request()->name;
        $iso2 = request()->iso2;

        $query = Country::query();
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($iso2) {
            $query->where('iso2', 'like', '%' . $iso2 . '%');
        }

        return $query->get();
    }

    public function getById($id)
    {
        return Country::where("id", $id)->first();
    }

    public function getByName(string $name)
    {
        return Country::where('name', $name)->first();
    }

    public function getByIso2(string $iso2)
    {
        return Country::where('iso2', $iso2)->first();
    }

    public function store(array $data)
    {
        return Country::create($data);
    }

    public function update(int $id, array $data)
    {
        return Country::where("id", $id)->update($data);
    }

    public function delete(int $id)
    {
        return Country::where('id', $id)->delete();
    }
}
