<?php namespace App\Models\PPPKPW;

use Illuminate\Database\Eloquent\Model;
use App\Models\Riwayat\TTE;

class UsulanPPPKPW extends Model {

    protected $guarded = array();
    protected $connection = "tugumuda";
    protected $table = "tr_pppkpw";

    protected $primaryKey = ['idpppk', 'nip'];
    public $incrementing = false;

    public static function generateSK($nip, $idpppk, $sts_kontrak)
    {
        $pdf = PDF::loadHTML(View::make('perpanjangankontrakpw::skpetikan_tte',[
            'nip' => $nip,
            'idpppk' => $idpppk,
            'sts_kontrak' => $sts_kontrak,
        ]))->setPaper('legal', 'potrait');
        
        $output = $pdf->stream();
        $file_path = 'pppkpw/draft/'.$nip.'_'.$idpppk.'_'.$sts_kontrak.'.pdf';

        if (Storage::disk('local')->has($file_path)) {
            unlink(base_path('storage/app/'.$file_path));
        }

        if (Storage::disk('local')->put($file_path, $output)) {
            $tte = TTE::where('nip_pengusul',$nip)->where('jenis','PPPKPW')->where('id_sk',$idpppk)->first();
            
            if (empty($tte)) {
                $tte = new TTE();
                $tte->jenis = "PPPKPW";
                $tte->id_sk = $idpppk;
                $tte->nip_pengusul = $nip;
                $tte->user_id = \Session::get('user_id');
                $tte->role_id = \Session::get('role_id');
                $tte->created_at = sekarang();
                $tte->file_awal = $nip.'_'.$idpppk.'_'.$sts_kontrak.'.pdf';
                $tte->save();
            }
            return true;
        }

        return 0;
    }

    public function riwayatTTE()
    {
        return $this->belongsTo('App\Models\Riwayat\TTE','idpppk','id_sk')->where('jenis','=','PPPKPW')->where('nip_pengusul','=',$this->nip);
    }

    public function statusTTE()
    {
        $r_tte = $this->riwayatTTE;
        if (!empty($r_tte)) {
            return $r_tte->proses==0?"Mengusulkan":"Selesai";
        }

        return "Belum Mengusulkan";
    }

    public function pejabatPenetap()
    {
        return $this->belongsTo('App\Models\Pegawai','nipkepalabkd','nip');
    }
}