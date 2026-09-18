<?php namespace App\Models\Riwayat;

use Illuminate\Database\Eloquent\Model;

class DiklatTeknis extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "r_diktek";

  public function getNamaDiklatAttribute()
  {
      return $this->nmdiktek;
  } 

  public function getNomorSttpAttribute()
  {
      return $this->nosttpdiktek;
  } 

  public function getTempatDiklatAttribute()
  {
      return $this->tmdiktek;
  } 

  public function scopeOfTahun($query, $tahun)
  {
      return $query->where(function($query) use ($tahun){
        $query
        ->where('tgmul','like','%'.$tahun)
        ->orWhere('tgmul','like',$tahun.'%');
      });
  }

  public function scopeBelumSAPK($query)
  {
      return $query->whereNull('idsapk');
  }

  public function pegawai()
  {
    return $this->belongsTo('App\Models\Pegawai', 'nip', 'nip');
  }
}