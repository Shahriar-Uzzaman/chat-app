<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\CountryRequest;
use App\Services\Location\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(public CountryService $countryService)
    {}

    public function getAll()
    {
        return $this->success($this->countryService->getAll(), "Country list retrieved successfully");
    }

    public function getById(int $id)
    {
        return $this->success($this->countryService->getById($id), "Country retrieved successfully");
    }

    public function store(CountryRequest $request)
    {
        return $this->success($this->countryService->store($request->validated()), "Country created successfully");
    }

    public function update(int $id, CountryRequest $request)
    {
        return $this->success($this->countryService->update($id, $request->validated()), "Country updated successfully");
    }

    public function delete(int $id)
    {
        return $this->success($this->countryService->delete($id), "Country deleted successfully");
    }
}
