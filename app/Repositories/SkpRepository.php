<?php
namespace App\Repositories;

/**
 *
 */
class SkpRepository extends BaseRepository
{
  protected $unwrap=['mapData','data'];

  protected $path = '/api/skp/pns';
  public function __construct(){
      parent::__construct();
      $this->baseUrl = config('bkn.base_url_duplex_resource');
  }
}

?>
