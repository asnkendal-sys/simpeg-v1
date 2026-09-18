<?php namespace App\Models\Riwayat;

use Illuminate\Database\Eloquent\Model;

class DiklatFungsional extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "r_dikfung";

  public function getNamaDiklatAttribute()
  {
      return $this->dikfung;
  }

  public function getNomorSttpAttribute()
  {
      return $this->nosttpdikfung;
  }

  public function getTempatDiklatAttribute()
  {
      return $this->tmdikfung;
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