<?php
namespace App\Services;

use App\Repositories\JabatanRepository;

class JabatanService
{
    private $repo;
    private $data;
    public function __construct(JabatanRepository $repo)
    {
        $this->repo = $repo;
    }



    public function fetch($nip)
    {
        $this->data = collect($this->repo->apiPath('/api/jabatan/pns')->fetch($nip));
        return $this;
    }

    public function fetchById($id)
    {
        $this->data = collect($this->repo->apiPath('/api/jabatan/id')->fetch($id));
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
        return $this->repo->apiPath('/api/jabatan/save')->store($data);
    }
}
