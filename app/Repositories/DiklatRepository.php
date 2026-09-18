<?php
namespace App\Repositories;

/**
 *
 */
class DiklatRepository extends BaseRepository
{
    protected $unwrap=['data'];

    protected $path = '/api/pns/rw-diklat';
    public function __construct()
    {
        parent::__construct();
    }
}
