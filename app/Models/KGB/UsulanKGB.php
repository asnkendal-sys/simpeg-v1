<?php namespace App\Models\KGB;

use Illuminate\Database\Eloquent\Model;
use App\Models\Riwayat\TTE;

class UsulanKGB extends Model {

    protected $guarded = array();
    protected $connection = "tugumuda";
    protected $table = "tr_kgb";

    protected $primaryKey = ['idkgb', 'nip'];
    public $incrementing = false;

    public static function generateSK($nip, $idkgb, $jnskgb)
    {
        $pdf = PDF::loadHTML(View::make('penetapannominatif::sk_tte',[
            'nip' => $nip,
            'idkgb' => $idkgb,
        'jnskgb' => $jnskgb,
        ]))->setPaper('legal', 'potrait');
        
        $output = $pdf->stream();
        $file_path = 'kgb/draft/'.$nip.'_'.$idkgb.'_'.$jnskgb.'.pdf';

        if (Storage::disk('local')->has($file_path)) {
            unlink(base_path('storage/app/'.$file_path));
        }

        if (Storage::disk('local')->put($file_path, $output)) {
            $tte = TTE::where('nip_pengusul',$nip)->where('jenis','KGB')->where('id_sk',$idkgb)->first();
            
            if (empty($tte)) {
                $tte = new TTE();
                $tte->jenis = "KGB";
                $tte->id_sk = $idkgb;
                $tte->nip_pengusul = $nip;
                $tte->user_id = \Session::get('user_id');
                $tte->role_id = \Session::get('role_id');
                $tte->created_at = sekarang();
                $tte->file_awal = $nip.'_'.$idkgb.'_'.$jnskgb.'.pdf';
                $tte->save();
            }
            return true;
        }

        return 0;
    }

    public function riwayatTTE()
    {
        return $this->belongsTo('App\Models\Riwayat\TTE','idkgb','id_sk')->where('jenis','=','KGB')->where('nip_pengusul','=',$this->nip);
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
        return $this->belongsTo('App\Models\Pegawai','nippb','nip');
    }
}