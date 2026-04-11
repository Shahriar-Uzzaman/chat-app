<?php

namespace App\Repositories\Eloquent\Location;

use App\Models\State;
use App\Repositories\Contracts\Location\StateRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StateRepository implements StateRepositoryInterface
{
    public function getAll()
    {
        $name = request('name');
        $countryName = request('country_name');
        $iso2 = request('iso2');

        return State::query()
            ->select([
                'states.*',
                'countries.name as country_name',
                'countries.iso2 as country_iso2',
            ])
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->when($name, function ($query, $name) {
                $query->where('states.name', 'like', '%' . $name . '%');
            })
            ->when($countryName, function ($query, $countryName) {
                $query->where('countries.name', 'like', '%' . $countryName . '%');
            })
            ->when($iso2, function ($query, $iso2) {
                $query->where('countries.iso2', 'like', '%' . $iso2 . '%');
            })
            ->orderBy('states.name')
            ->get();
    }

    public function getById(int $id)
    {
        return State::where("id", $id)->first();
    }

    public function getByCountryId(int $countryId)
    {
        return State::where("country_id", $countryId)->first();
    }

    public function getByName(string $name)
    {
        return State::where("name", $name)->first();
    }

    public function store(array $data)
    {
        return State::create($data);
    }

    public function update(int $id, array $data)
    {
        return State::where("id", $id)->update($data);
    }

    public function delete(int $id)
    {
        return State::where("id", $id)->delete();
    }
}
