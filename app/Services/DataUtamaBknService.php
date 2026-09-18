<?php
namespace App\Services;

use App\Repositories\DataUtamaRepository;

class DataUtamaBknService
{
    private $repo;

    public function __construct(DataUtamaRepository $repo)
    {
        $this->repo = $repo;
    }

    public function fetchDataUtama($nip)
    {
        $response = $this->repo->fetch($nip);

        return $response;
    }
}