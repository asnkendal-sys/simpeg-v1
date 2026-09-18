<?php namespace App\Models\Riwayat;

use Illuminate\Database\Eloquent\Model;

class DiklatStruktural extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "r_dikstru";

  public function getNamaDiklatAttribute()
  {
      return $this->dikstru;
  } 

  public function getNomorSttpAttribute()
  {
      return $this->nosttpdikstru;
  } 

  public function getTempatDiklatAttribute()
  {
      return $this->tmdikstru;
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

  public function Pegawai()
  {
    return $this->belongsTo('App\Models\Pegawai', 'nip', 'nip');
  }
}