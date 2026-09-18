<?php
namespace App\Repositories;

use App\Repositories\IApiBknRepository;

  class DataUtamaRepository extends BaseRepository 
  {
    protected $unwrap=['data'];
    protected $path = '/api/pns/data-utama';
  }