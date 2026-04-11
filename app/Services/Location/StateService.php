<?php

namespace App\Services\Location;

use App\Repositories\Contracts\Location\StateRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StateService
{
    public function __construct(public StateRepositoryInterface $stateRepo)
    {}

    public function getAll()
    {
        return $this->stateRepo->getAll();
    }

    public function getById(int $id)
    {
        return $this->stateRepo->getById($id);
    }

    public function getByCountryId(int $id)
    {
        return $this->stateRepo->getByCountryId($id);
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $state = $this->stateRepo->getByName($data['name']);
            if ($state) {
                throw new \Exception("State already exists");
            }

            $newState = $this->stateRepo->store($data);
            DB::commit();
            return $newState;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $state = $this->stateRepo->getById($id);
            if (!$state) {
                throw new \Exception("State not found");
            }

            $updatedState = $this->stateRepo->update($id, $data);
            DB::commit();
            return $updatedState;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $state = $this->stateRepo->getById($id);
            if (!$state) {
                throw new \Exception("State not found");
            }

            $this->stateRepo->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
