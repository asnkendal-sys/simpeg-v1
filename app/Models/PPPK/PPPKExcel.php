<?php namespace App\Models\PPPK;

use Illuminate\Database\Eloquent\Model;

use Log;
use \App\Models\Master\Golruang;
use \App\Models\Master\Tkpendid;
use \App\Models\Master\Jenjurusan;
use \App\Models\Master\Jabfungum;
use \App\Models\Master\Jabfung;
use \App\Models\Master\PenetapSk;
use \App\Models\Master\Skpd;
use \App\Models\Pegawai;
use \App\Models\PPPK\RPPPK;
use App\Modules\konversidata\konversicpns\Models\KonversicpnsModel;

class PPPKExcel extends Model {

	protected $guarded = array();
    
    protected $table = "a_pppk_excel";

    public $timestamps = false;

    public function scopeBerhasil($query)
    {
        return $query->where('status','=',3);
    }

    public function scopeGagal($query)
    {
        return $query->where('status','<',3);
    }

    public function getJabatanAttribute(){
        $jabatan = '';

        if ($this->idjenjab > 4){
            $jab = $this->skpd;
            $jabatan = !empty($jab)?$jab->jab:'';
        }else if($this->idjenjab == 2){
            $jab = $this->jabfung;
            $jabatan = !empty($jab)?$jab->jabfung:'';
        }else if($this->idjenjab == 3){
            $jab = $this->jabfungum;
            $jabatan = !empty($jab)?$jab->jabfungum:'';
        }

        return strtoupper($jabatan);
    }

    public function getJabatan(){
        $jabatan = '';

        if ($this->idjenjab > 4){
            $jabatan = Skpd::where('idskpd','=',$this->idskpd)->first()->jab;
        }else if($this->idjenjab == 2){
            $jabatan = Jabfung::where('idjabfung','=',$this->idjab)->first()->jabfung->jabfung;
        }else if($this->idjenjab == 3){
		dd($this->jabfungum);
	    $jabatan = \App\Models\Master\Jabfungum::where('idjabfungum','=',$this->idjab.'')->first();
        	
	}

        return strtoupper($jabatan);
    }

    public function getNamaSkpdAtribute()
    {
        return Skpd::where('idskpd','=',$this->idskpd)->first()->path_short;
    }

    public function getGolonganAttribute()
    {
      return Golruang::where('idgolru','=',$this->idgolru)->first()->golru;
    }

    public function getKdunitAttribute(){
        return $this->idskpd==''?'':substr($this->idskpd, 0,2);
    }

    public function skpd(){
        return $this->belongsTo('App\Models\Master\Skpd','idskpd','idskpd');
    }

    public function golruang(){
      return $this->belongsTo('App\Models\Master\Golruang','idgolru','idgolru');
    }

    public function jabfung(){
      return $this->belongsTo('App\Models\Master\Jabfung','idjab','idjabfung');
    }

    public function jabfungum(){
      return $this->belongsTo('App\Models\Master\Jabfungum','idjab','idjabfungum');
    }

    public function konversi()
    {
        $idjenjab = $this->konvIdjenjab($this->jenisjabatan);

        $this->idjenkel = $this->konvIdjenkel($this->JENKEL);
        $this->idagama = $this->konvIdagama($this->AGAMA);
        $this->idstskawin = $this->konvIdstskawin($this->STATUS_PERKAWINAN);
        $this->idgolru = $this->konvIdgolru($this->GOLRU);
        $this->idtkpendid = $this->konvIdtkpendid($this->TKT_PENDIDIKAN);
        $this->idjenjurusan = $this->konvIdjenjurusan($this->PENDIDIKAN);
        $this->idjab = $this->konvIdjab($this->IDSAPK_JABATAN, $idjenjab);
        $this->idskpd = $this->konvIdskpd($this->IDSAPK_SKPD);
        $this->idjenjab = $idjenjab;

        $this->TGL_PERTIMBANGAN = dateParseYmd($this->TGL_PERTIMBANGAN,'d-m-Y');
        $this->TGL_LAHIR = dateParseYmd($this->TGL_LAHIR,'d-m-Y');
        $this->TGL_SURAT_DOKTER = dateParseYmd($this->TGL_SURAT_DOKTER,'d-m-Y');
        $this->TGL_SURAT_NARKOBA = dateParseYmd($this->TGL_SURAT_NARKOBA,'d-m-Y');
        $this->TGL_SURAT = dateParseYmd($this->TGL_SURAT,'d-m-Y');
        $this->TMT_CPNS = dateParseYmd($this->TMT_CPNS,'d-m-Y');
        $this->TGL_TAHUN_LULUS = dateParseYmd($this->TGL_TAHUN_LULUS,'d-m-Y');
        $this->status = 1;
        if($this->save()){
                return 1;
        }
        dd($this);
        return 0;
    }

    /*function get id jenis kelamin*/
    public static function konvIdjenkel($jenkel = ''){
        if($jenkel == 'Pria'){
            return 1;
        }else if($jenkel == 'Wanita'){
            return 2;
        }
        return '';
    }

     public static function konvIdagama($agama = ''){                    
        if($agama == 'Islam'){
            return 1;
        }else if($agama == 'Kristen'){
            return 2;
        }else if($agama == 'Katholik'){
            return 3;
        }else if($agama == 'Hindu'){
            return 4;
        }else if($agama == 'Budha'){
            return 5;
        }else if($agama == 'Konghucu'){
            return 6;
        }
        return '';
    }

    public static function konvIdstskawin($kawin = '')
    {
        if (($kawin == 'Menikah') or ($kawin == 'Kawin')) {
            return 1;
        }else if ($kawin == 'Janda/Duda') {
            return 2;
        }else if (($kawin == 'Belum Menikah') or ($kawin == 'Belum Kawin')) {
            return 3;
        }
        return '';
    }

    public static function konvIdgolru($golru = '')
    {
        if($golru != ''){
            $golru = Golruang::where('golru_p3k','=',$golru)->first();
            if(!empty($golru)){
                return $golru->idgolru;
            }
        }
        return '';
    }

    public static function konvIdtkpendid($tkpendid = '')
    {
        if($tkpendid != ''){
            $tkpendid = Tkpendid::where('tkpendid','=',$tkpendid)->first();
            if(!empty($tkpendid)){
                return $tkpendid->idtkpendid;
            }
        }
        return '';
    }

    public static function konvIdjenjurusan($jenjurusan='')
    {
        if($jenjurusan != ''){
            $jenjurusan = Jenjurusan::where('jenjurusan','=',$jenjurusan)->first();
            if(!empty($jenjurusan)){
                return $jenjurusan->idjenjurusan;
            }
        }
        return '';
    }

    public static function konvIdjab($jab = '',$idjenjab = '')
    {
        if($jab != '' && $idjenjab != ''){
            if($idjenjab == 3){
                // pelaksana
                $jab = Jabfungum::where('idsapk','=',$jab)->first();
                if(!empty($jab)){
                    return $jab->idjabfungum;
                }
            }
        }
        return '';
    }

    public static function konvIdskpd($skpd='')
    {
        if($skpd != ''){
            $skpd = Skpd::where('idsapk','=',$skpd)->first();
            if(!empty($skpd)){
                return $skpd->idskpd;
            }
        }
        return '';
    }

    public static function konvIdjenjab($jenisjabatan = '')
    {
        if ($jenisjabatan == 'Jabatan Pelaksana') {
            return 3;
        }
        return '';
    }

    // menyimpan data pegawai ke tb_01 
    public function simpanPegawai()
    {

        if(
            ($this->NIP_BARU != '')
            //($this->idjenkel != '') &&
            //($this->idagama != '') &&
            //($this->idstskawin != '') &&
            //($this->idgolru != '') &&
            //($this->idtkpendid != '') &&
            //($this->idjenjurusan != '') &&
            //($this->idjab != '') &&
            //($this->idskpd != '') &&
            //($this->idjenjab != '') &&
            //($this->TGL_PERTIMBANGAN != '') &&
            //($this->TGL_LAHIR != '') &&
            //($this->TGL_SURAT_DOKTER != '') &&
            //($this->TGL_SURAT_NARKOBA != '') &&
            //($this->TGL_SURAT != '') &&
            //($this->TMT_CPNS != '') &&
            //($this->TGL_TAHUN_LULUS != '')
        ){
            $pegawai = Pegawai::where('nip',$this->NIP_BARU)->first();
            // $pegawai = Pegawai::firstOrNew([
            //     'nip' => $this->NIP_BARU
            // ]);

            if(empty($pegawai)){
                $pegawai = new Pegawai;
                $pegawai->nip = $this->NIP_BARU;
                $pegawai->idstspeg = 3;
            }
            
            if($pegawai->idstspeg==3 || $pegawai->idstspeg == 4){
                if($this->idjenjab == 3){
                    $pegawai->idjabfungum = $this->idjab;
                }
            
              if ($this->idstspeg == '3') {
                    $pegawai->idjenkepeg = 8;
                }
                if ($this->idstspeg == '4') {
                    $pegawai->idjenkepeg = 9;
                }


                $pegawai->nama = KonversicpnsModel::listName($this->NAMA,1);
               // $pegawai->gdb = KonversicpnsModel::listName($this->NAMA, 2);
                $pegawai->gdp = $this->GELAR_DEPAN;
                $pegawai->gdb = $this->GELAR_BELAKANG;
                $pegawai->tmlhr = $this->TEMPAT_LAHIR;
                $pegawai->tglhr = $this->TGL_LAHIR;
                $pegawai->idjenkel = $this->idjenkel;
                $pegawai->idagama = $this->idagama;
                 $pegawai->idstspeg = $this->STATUS_PEGAWAI;
                // $pegawai->idjenkepeg = $idjenkepeg;
                $pegawai->idjenkedudupeg = 1;
                $pegawai->idstskawin = $this->idstskawin;
                $pegawai->alm = $this->ALAMAT;
                $pegawai->idjenjab = $this->idjenjab;
                $pegawai->idskpd = $this->idskpd;
                $pegawai->idtkpendid = $this->idtkpendid;
                $pegawai->idjenjurusan = $this->idjenjurusan;
                $pegawai->pejmenpkt = $this->PENETAP_SK;
                $pegawai->noskpkt = $this->NO_SK_CPPPK;
                $pegawai->tgskpkt = $this->TGL_SK_CPPK;
                $pegawai->pejmenawal_pppk = $this->PENETAP_SK;
                $pegawai->noskcalonawal_pppk = $this->NO_SK_CPPPK;
                $pegawai->tgskcalonawal_pppk = $this->TGL_SK_CPPK;
                $pegawai->noskawal_pppk = $this->NO_SK_CPPPK;
                $pegawai->tgskawal_pppk = $this->TGL_SK_CPPK;
                $pegawai->idgolruawal_pppk = $this->idgolru;
                $pegawai->mkthnawal_pppk = $this->MK_TAHUN;
                $pegawai->mkblnawal_pppk = $this->MK_BULAN;
                $pegawai->gajiawal_pppk = $this->GAJI_POKOK;
                $pegawai->idjenjabawal_pppk = $this->idjenjab;
                $pegawai->idjabawal_pppk = $this->idjab;
                $pegawai->nojanjiawal_pppk = $this->NO_SK_PERJANJIAN;
                $pegawai->tgljanjiawal_pppk = $this->TGL_SK_PERJANJIAN;
                $pegawai->tmtmulaiawal_pppk = $this->TMT_AWAL;
                $pegawai->tmtakhirawal_pppk = $this->TMT_AKHIR;
                $pegawai->pejmenakhir_pppk = $this->PENETAP_SK;
                $pegawai->noskakhir_pppk = $this->NO_SK_CPPPK;
                $pegawai->tgskakhir_pppk = $this->TGL_SK_CPPK;
                $pegawai->idgolruakhir_pppk = $this->idgolru;
                $pegawai->mkthnakhir_pppk = $this->MK_TAHUN;
                $pegawai->mkblnakhir_pppk = $this->MK_BULAN;
                $pegawai->gajiakhir_pppk = $this->GAJI_POKOK;
                $pegawai->idjenjabakhir_pppk = $this->idjenjab;
                $pegawai->idjabakhir_pppk = $this->idjab;
                $pegawai->nojanjiakhir_pppk = $this->NO_SK_PERJANJIAN;
                $pegawai->tgljanjiakhir_pppk = $this->TGL_SK_PERJANJIAN;
                $pegawai->tmtmulaiakhir_pppk = $this->TMT_AWAL;
                $pegawai->tmtakhirakhir_pppk = $this->TMT_AKHIR;
                $pegawai->pejmenkgb = $this->PENETAP_SK;
                $pegawai->idgolkgb = $this->idgolru;
                $pegawai->idgolrupkt = $this->idgolru;
                $pegawai->tmtkgb = $this->TMT_AWAL;
                $pegawai->mkgolthnkgb  = $this->MK_TAHUN;
                $pegawai->mkgolblnkgb = $this->MK_BULAN;
                $pegawai->kdunit = $this->kdunit;
                $pegawai->namasekolah = $this->NAMA_SEKOLAH;
                $pegawai->thijaz = date('Y',strtotime($this->TGL_TAHUN_LULUS));
                $pegawai->noijaz = $this->NO_IJAZAH;
                $pegawai->idtkpendidawal = $this->idtkpendid;
                $pegawai->idjenjurusanawal = $this->idjenjurusan;
                $pegawai->thijazawal = date('Y',strtotime($this->TGL_TAHUN_LULUS));
                $pegawai->noijazawal = $this->NO_IJAZAH;
                $pegawai->namasekolahawal = $this->NAMA_SEKOLAH;
                $pegawai->namasekolah = $this->NAMA_SEKOLAH;
                $pegawai->password = md5($this->NIP_BARU."");
                $pegawai->usiapens = 1;
                $pegawai->id_sapk = $this->ORANG_ID;
                $this->status = 2;

                if($pegawai->save() && $this->save()){
                        return 1;
                }

                return 0;
            }
        }
    }

    public function simpanRiwayat()
    {
        if(
            ($this->NIP_BARU != '')
        ){    
            // $penetap_sk_pppk = \Cache::remember('penetap_sk_pppk', 10, function () {
                $penetap_sk_pppk['kepalabkd'] = Pegawai::where('idskpd','=','25')->with('golruang')
                    ->where('idjabjbt','=', '25')
                    ->aktif()
                    ->first();

                $penetap_sk_pppk['bupati'] = PenetapSk::where('id','=','005')->first();

                $penetap_sk_pppk['kepalasekda'] = Pegawai::where('idskpd','=','01')->with('golruang')
                    ->where('idjabjbt','=', '01')
                    ->aktif()
                    ->first();

                // return $rs;
            // });


            $riwayat = RPPPK::firstOrNew([
                'nip' => $this->NIP_BARU,
                'tmtawal' => $this->TMT_AWAL,
                'niplama' => $this->NIP_BARU,
                'nipbaru' => $this->NIP_BARU,
                'sts_kontrak' => 1
            ]);
            
            $riwayat->no_urut = (int) trim($this->NO);
            $riwayat->no_spk = substr_replace('813/0027/2021', str_pad($this->NO, 3, '0', STR_PAD_LEFT), 8, 0);
            $riwayat->nosk_calon = $this->NO_SK_CPPPK;
            $riwayat->tglsk_calon = $this->TGL_SK_CPPK;
            $riwayat->nosk_pppk = $this->NO_SK_CPPPK;
            $riwayat->tglsk_pppk = $this->TGL_SK_CPPK;
            $riwayat->idjab = $this->idjab;
            $riwayat->jab = $this->jabatan;
            $riwayat->jabtext = '';
            $riwayat->kdunit = $this->kdunit;
            $riwayat->idskpd = $this->idskpd;
            $riwayat->skpd = $this->skpd->path_short;
            $riwayat->idgolru = $this->idgolru;
            $riwayat->golru = $this->GOLRU;
            $riwayat->thkerja = $this->MK_TAHUN;
            $riwayat->blkerja = $this->MK_BULAN;
            $riwayat->gaji = $this->GAJI_POKOK;
            $riwayat->tmtakhir = $this->TMT_AKHIR;
            $riwayat->idjenjab = $this->idjenjab;
            $riwayat->nosk = $this->NO_SK_CPPPK;
            $riwayat->tgsk = $this->TGL_SK_CPPK;
            $riwayat->nopak = '';
            $riwayat->pejmen = $this->PENETAP_SK;
            $riwayat->iskepsek = '';
            $riwayat->idkepsek = '';
            $riwayat->tmtkepsek = '';
            $riwayat->noskkepsek = '';
            $riwayat->idtugasdokter = '';
            $riwayat->idtugasgurudosen = '';
            $riwayat->idmatkulpel = '';
            $riwayat->matkulpel = '';
            $riwayat->isdiperbantukan = '';
            $riwayat->iddiperbantukan = '';
            $riwayat->idesl = '';
            $riwayat->esl = '';
            $riwayat->tmtesljbt = '';
            $riwayat->stsesl = '';
            $riwayat->iddesa = '';
            $riwayat->nmadesa = '';
            //$riwayat->statususul = 1
            //$riwayat->statussk = 1
            //$riwayat->kettms = ''
            //$riwayat->nosk_pengantar = ''
            //$riwayat->tgl_skpengantar = $this->
            //$riwayat->tglsurat = $this->
            //$riwayat->iscetaksk = $this->
            $riwayat->kepalabkd = $penetap_sk_pppk['kepalabkd']->nama_lengkap;
            $riwayat->jabkepalabkd = $penetap_sk_pppk['kepalabkd']->jabatan;
            $riwayat->nipkepalabkd = $penetap_sk_pppk['kepalabkd']->nip;
            $riwayat->pangkatbkd = $penetap_sk_pppk['kepalabkd']->golruang->pangkat;
            $riwayat->bupati = $penetap_sk_pppk['bupati']->namalengkap;
            $riwayat->file_excel = $this->excel_2;
            if(! empty($penetap_sk_pppk['kepalasekda'])){
                $riwayat->kepalasekda = $penetap_sk_pppk['kepalasekda']->nama_lengkap;
                $riwayat->jabkepalasekda = $penetap_sk_pppk['kepalasekda']->jabatan;
                $riwayat->nipsekda = $penetap_sk_pppk['kepalasekda']->nip;
                $riwayat->pangkatsekda = $penetap_sk_pppk['kepalasekda']->golruang->pangkat;
            }
            $riwayat->user_id = \Session::get('user_id');
            $riwayat->role_id = \Session::get('role_id');
            $this->status = 3;

            if($riwayat->save() && $this->save()){
                return 1;
            }

            return 0;
        }
    }


}
