<?php
namespace App\Services;


use App\Repositories\SkpRepository;
class SkpService
{
    private $repo;
    private $data;
    public function __construct(SkpRepository $repo)
    {
      $this->repo = $repo;

    }



    public function fetch($nip)
    {
      $this->data = collect($this->repo->fetch($nip));
      return $this;
    }
    public function filter($field, $value)
    {
      $collect = collect($this->data);

      $this->data = collect($collect->filter(function($item) use($field, $value) {
        return $item[$field] == $value;
      }));
      return $this;
    }
    public function first(){
      return $this->data->first();
    }
    public function get(){
      return collect($this->data->all());
    }

    public function store($data)
    {
      return $this->repo->apiPath('/api/skp/save')->store($data);
    }
}
