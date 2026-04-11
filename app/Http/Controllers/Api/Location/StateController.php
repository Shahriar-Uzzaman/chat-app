<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StateRequest;
use App\Services\Location\StateService;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(public StateService $stateService)
    {}

    public function getAll()
    {
        return $this->success($this->stateService->getAll(), "State list retrieved successfully");
    }

    public function getById(int $id)
    {
        return $this->success($this->stateService->getById($id), "State retrieved successfully");
    }

    public function getByCountryId(int $id)
    {
        return $this->success($this->stateService->getByCountryId($id), "State list retrieved successfully");
    }

    public function create(StateRequest $request)
    {
        return $this->success($this->stateService->store($request->validated()), "State created successfully");
    }

    public function update(int $id, StateRequest $request)
    {
        return $this->success($this->stateService->update($id, $request->validated()), "State updated successfully");
    }

    public function delete(int $id)
    {
        return $this->success($this->stateService->delete($id), "State deleted successfully");
    }
}
