<?php namespace App\Models\PPPK;

use Illuminate\Database\Eloquent\Model;

class RPPPK extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "r_pppk";

  public function getNamaSkpdAttribute()
  {
      return $this->rskpd->skpd;
  }

  public function getUnitKerjaAttribute()
  {
      return \App\Models\Master\Skpd::where('idskpd','=',$this->kdunit)
        ->where('flag','=',1)->first()->skpd;
  }

  public function getPangkatAttribute()
  {
      return $this->golruang->pangkat;
  }

  public function getTmtpktAttribute()
  {
      return formatTanggalPanjang($this->tmtakhir);
  }

  public function getTanggalSkAttribute()
  {
      return formatTanggalPanjang($this->tgsk);
  }

  public function rskpd(){
      return $this->belongsTo('App\Models\Master\Skpd','idskpd','idskpd');
  }

  public function golruang(){
      return $this->belongsTo('App\Models\Master\Golruang','idgolru','idgolru');
  }

  public function pegawai(){
      return $this->belongsTo('App\Models\Pegawai','nip','nip');
  }
}
