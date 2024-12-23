<?php

namespace App\Repositories;

interface PaymentsRepositoryInterface extends BaseRepository
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function monthlyTotalContributions($args);
    public function initiateWorkflow($args);
    public function getDefinition($args, $id);
    public function getRecentResourceTrack($args, $id);
    public function getArrears();
    public function individualArrears($args);
    public function arrearsInformations();
    public function arrearsComputations($args1);
    public function createArrears($args1, $args2, $args3);
        


}
