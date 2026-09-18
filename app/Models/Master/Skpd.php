<?php namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "a_skpd";

  public function kepala()
  {
      $this->pegawai
        ->where('idjabjbt','=', $this->idskpd)
        ->aktif()
        ->first();
  }

  public function pegawai()
  {
    return $this->hasMany('App\Models\Pegawai','idskpd','idskpd');
  }
}