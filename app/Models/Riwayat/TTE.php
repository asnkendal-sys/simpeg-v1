<?php namespace App\Models\Riwayat;

use Illuminate\Database\Eloquent\Model;
use App\Models\Riwayat\TTE;
use PDF, Storage,View;
use App\Models\KGB\UsulanKGB;

class TTE extends Model {

    protected $guarded = array();
    protected $connection = "tugumuda";
    protected $table = "r_tte";

    public function usulanKGB()
    {
        return UsulanKGB::where('idkgb',$this->id_sk)
         ->where('nip',$this->nip_pengusul)->first();
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai','nip_pengusul','nip');
    }
}