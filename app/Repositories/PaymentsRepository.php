<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use App\Repositories\BaseRepository;


class PaymentsRepository implements BaseRepository
{
    /**
     * Create a new class instance.
     */

     protected $model;
    public function __construct(MonthlyPayment $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

}
