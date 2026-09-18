<?php
namespace App\Services;

use App\Repositories\PpoRepository;

class PpoService
{
    private $repo;
    private $data;
    public function __construct(PpoRepository $repo)
    {
        $this->repo = $repo;
    }



    public function fetch()
    {
        $this->data = collect($this->repo->fetchPpo());
        return $this;
    }

    public function fetchHistory($tglAwal, $tglAkhir)
    {
        $this->data = collect($this->repo->fetchHistory($tglAwal, $tglAkhir));
        return $this;
    }
    public function filter($field, $value)
    {
        $collect = collect($this->data);

        $this->data = collect($collect->filter(function ($item) use ($field, $value) {
            return $item[$field] == $value;
        }));
        return $this;
    }
    public function first()
    {
        return $this->data->first();
    }
    public function get()
    {
        return collect($this->data->all());
    }

    public function store($data)
    {
        return $this->repo->apiPath('/api/skp/save')->store($data);
    }
}
