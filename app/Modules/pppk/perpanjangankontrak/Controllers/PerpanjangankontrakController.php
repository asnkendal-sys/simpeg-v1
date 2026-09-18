<?php namespace App\Modules\pppk\perpanjangankontrak\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pppk\perpanjangankontrak\Models\PerpanjangankontrakModel;
use Input,View, Request, Form, File, Session;
use PDF;

use App\Models\PPPK\RPPPK;
use App\Services\PPPKService;
use App\Models\PPPK\UsulanPPPK;

class PerpanjangankontrakController extends Controller {

	protected $perpanjangankontrak;

	public function getIndex(){
        cekAjax();
		if(strlen(Input::has('search')) > 0){
			$rpppk = RPPPK::with('pegawai')
				->where('sts_kontrak','=',2)
				->where('nip','like','%'.Input::get('search').'%')
				->orderBy('idskpd')
				->orderBy('tmtawal', 'desc');
		}else{
			$rpppk = RPPPK::with('pegawai')
				->where('sts_kontrak','=',2)
				->orderBy('idskpd')
				->orderBy('tmtawal', 'desc');
		}

        if (Session::get('role_id') > 3) {
            $rpppk = $rpppk->where('r_pppk.idskpd','like', Session::get('idskpd')."%");
        }
		$rpppk = $rpppk->paginate($_ENV['configurations']['list-limit']);

        return View::make('perpanjangankontrak::index', compact('rpppk'));
    }

    public function getIndexnominatif(){
        cekAjax();
        $where = "tr_pppk.sts_kontrak = 2 ";
        if (session('role_id') > 3) {
            $where.= " and tr_pppk.idskpd like \"".session('idskpd')."%\" ";
        }

        $jenis = 'PPPK';
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::has('tahun') != '') or (Input::has('bulan') != '') or (Input::has('status') != '') or (Input::has('statussk') != '') or (Input::get('status_tte') != '')) {
            (Input::get('bulan') != '')?$where .= " and MONTH(tr_pppk.tmtawal) = \"".Input::get('bulan')."\"":"";
            (Input::get('tahun') != '')?$where .= " and YEAR(tr_pppk.tmtawal) = \"".Input::get('tahun')."\"":"";
            (Input::get('statussk') != '')?$where .= " and tr_pppk.statussk = \"".Input::get('statussk')."\"":"";            
            (Input::get('status') != '')?$where .= " and tr_pppk.status = \"".Input::get('status')."\"":"";            
            (Input::get('idskpd') != '')?$where .=" and tr_pppk.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search') != '')?$where .=" and (tr_pppk.nama LIKE '%".Input::get('search')."%' or tr_pppk.nip LIKE '%".Input::get('search')."%')":"";
            if (Input::get('status_tte') != '') {
                if (Input::get('status_tte')=='belum_mengusulkan') {
                    $where .= " and r_tte.proses IS NULL";
                }else{
                    $where .= " and r_tte.proses = \"".Input::get('status_tte')."\"";
                }
            }
            
            $rpppk = PerpanjangankontrakModel::select('tr_pppk.*','r_tte.proses',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
                    ->leftJoin('r_tte', function($join)use($jenis){                       
                         $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                            ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                            ->where('r_tte.jenis','=',$jenis); 
                    })
                    ->whereRaw($where)->orderBy('kdunit')->orderBy('tmtawal')->orderBy('status')->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpppk = PerpanjangankontrakModel::select('tr_pppk.*','r_tte.proses',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
                ->leftJoin('r_tte', function($join)use($jenis){
                    $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                        ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                        ->where('r_tte.jenis','=',$jenis); 
                })
                ->whereRaw($where)->orderBy('kdunit')->orderBy('tmtawal')->orderBy('status')->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->paginate($_ENV['configurations']['list-limit']);
        }

        return View::make('perpanjangankontrak::index_nominatif', compact('rpppk'));
    }

	public function getCreate()
	{
		return View::make('perpanjangankontrak::create');
	}

    public function getCreateaps()
	{
		return View::make('perpanjangankontrak::createaps');
    }

//	public function postNominatif(){
//        cekAjax();
//        $data['idskpd'] = Input::get('idskpd');
//        $data['tahun'] = Input::get('tahun');
//        $pegawai = \App\Models\Pegawai::where('idskpd','like',Input::get('idskpd').'%')
//            // ->where("DATE(tmtmulaiawal_pppk) <= '".date( (Input::get('tahun')-5).'-'.Input::get('bulan').'-1' )."'" )
//            ->whereYear('tmtakhirakhir_pppk','=',$data['tahun'])
//            ->pppk()
//            ->aktif()
//            ->get();
//
//        return View::make('perpanjangankontrak::nominatif', compact('pegawai','data'));
//    }

    public function postCreate()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PerpanjangankontrakModel::$rules);
        if ($validation->passes()){
            $data = array();
            /*ambil post dari inputan*/
            $bulan = $input['bulan'];
            $tahunkgb = $input['tahun'];
            $tmtmulaiakhir_pppk = $input['tmtmulaiakhir_pppk'];                        
            $idskpd = $input['idskpd'];
            $nip = $input['nip'];
            $status = $input['status'];
            $status_keterangan = $input['status_keterangan'];

            $data = array();
            foreach($nip as $key => $item){
                $attr = PerpanjangankontrakModel::getattpppk($item);
                $tahunperpanjangan = ($attr->selisih_tahun > $input['tahunperpanjangan'])?$input['tahunperpanjangan']:$attr->selisih_tahun;                
                // $tmtakhirakhir_pppk = ($tahunperpanjangan > 0)?date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' + '.$tahunperpanjangan.' year -1 day')):date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' + '.$attr->selisih_bulankerja.' month -1 day'));        
                $selisih_masakerja = $attr->mkthnakhir_pppk + $attr->selisih_tahunkerja + 1;
                $temp_arr1 = array(                                        
                    'nip' => $item,
                    'idpppk' => $tahunkgb.''.$bulan.'.'.$attr->idskpd,
                    'niplama' => $attr->nip_lama,
                    'nipbaru' => $attr->nip,
                    'nama' => $attr->nama,
                    'tmlhr' => $attr->tmlhr,
                    'tglhr' => $attr->tglhr,
                    'idjenjab' => $attr->idjenjab,
                    'idjab' => $attr->kdjabskr,
                    'jab' => $attr->namajab,
                    'kdunit' => substr($attr->idskpdskr,0,2),
                    'idskpd' => $attr->idskpdskr,
                    'skpd' => $attr->skpdskr,

                    'nosk_calon' => $attr->noskcalonawal_pppk,
                    'tglsk_calon' => $attr->tgskcalonawal_pppk,
                    'nosk_pppk' => $attr->noskawal_pppk,
                    'tglsk_pppk' => $attr->tgskawal_pppk,

                    'pejmen' => $attr->pejmenakhir_pppk,
                    'tmtawall' => $attr->tmtmulaiakhir_pppk,
                    'tmtakhirl' => $attr->tmtakhirakhir_pppk,
                    'noskl' => $attr->nojanjiakhir_pppk,
                    'tgskl' => $attr->tgljanjiakhir_pppk,
                    'idgolrul' => $attr->idgolruakhir_pppk,
                    'golrul' => $attr->golru_p3k,
                    'thkerjal' => $attr->mkthnakhir_pppk,
                    'blkerjal' => $attr->mkblnakhir_pppk,
                    'gajil' => $attr->gajiakhir_pppk,

                    'tmtawal' => date("Y-m-d", strtotime($tmtmulaiakhir_pppk)),                    
                    'idgolru' => $attr->idgolruakhir_pppk,
                    'golru' => $attr->golru_p3k,
                    'thkerja' => $selisih_masakerja, //$attr->mkthnakhir_pppk + $tahunperpanjangan,
                    'blkerja' => $attr->mkblnakhir_pppk,
                    'gaji' => getGaji($attr->idgolruakhir_pppk, $selisih_masakerja,3),

                    'idtkpendid' => $attr->idtkpendid,
                    'tkpendid' => $attr->tkpendid,
                    'idjenjurusan' => $attr->idjenjurusan,
                    'jenjurusan' => $attr->jenjurusan,
                    'agama' => $attr->agama,

                    'status' => $status[$item],
                    'status_keterangan' => $status_keterangan[$item],

                    /*diisi sesuai kondisi skpd dan golongan*/
                    'idpejab' => '005',
                    'bupati' => getPenetapsk('005', 'namalengkap'),
                    'kepalabkd' => getKepskpd('25','nama'),
                    'jabkepalabkd' => getKepskpd('25','jab'),
                    'nipkepalabkd' => getKepskpd('25','nip'),
                    'pangkatbkd' => getKepskpd('25','pangkat'),
                    'golrubkd' => getKepskpd('25','golru'),
                    
                    'kepalasekda' => getKepskpd('01','nama'),
                    'jabkepalasekda' => getKepskpd('01','jab'),
                    'nipsekda' => getKepskpd('01','nip'),
                    'pangkatsekda' => getKepskpd('01','pangkat'),                    

                    'created_at' => sekarang(),
                    'role_id' => \Session::get('role_id'),
                    'user_id' => \Session::get('user_id')
                );

                if($tahunperpanjangan >= 5){
                    $temp_arr2 = array(
                        'sts_kontrak' => 2,
                        'tmtakhir' => date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' + '.$tahunperpanjangan.' year -1 day')),
                        'perpanjangan' => $tahunperpanjangan,
                        'perpanjangan_bulan' => 0,
                        'perpanjangan_satuan' => 'Tahun',
                        'idjenpens' => '',
                        'keterangan' => '',
                        'bup' => ($attr->pensiunnext!='')?$attr->pensiunnext:date("Y-m-d")
                    );
                }else{
                    if($attr->selisih_bulankerja >= 12){
                        if($attr->selisih_bulankerja > 12){
                            $temp_arr2 = array(
                                'sts_kontrak' => 2,
                                'tmtakhir' => date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' + '.($tahunperpanjangan + 1).' year -1 day')),                                                            
                                'perpanjangan' => $tahunperpanjangan + 1,
                                'perpanjangan_bulan' => 0, //$attr->selisih_bulankerja%12
                                'perpanjangan_satuan' => 'Tahun',
                                'idjenpens' => '',
                                'keterangan' => '',
                                'bup' => ($attr->pensiunnext!='')?$attr->pensiunnext:date("Y-m-d")
                            );
                        }else{
                            $temp_arr2 = array(
                                'sts_kontrak' => 2,                            
                                'tmtakhir' => date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' -1 day')),
                                'perpanjangan' => $tahunperpanjangan,
                                'perpanjangan_bulan' => 0,
                                'perpanjangan_satuan' => 'Tahun',
                                'idjenpens' => '',
                                'keterangan' => '',
                                'bup' => ($attr->pensiunnext!='')?$attr->pensiunnext:date("Y-m-d")
                            );
                        }
                    }else if($attr->selisih_bulankerja > 0){
                        $temp_arr2 = array(
                            'sts_kontrak' => 2,
                            'tmtakhir' => date('Y-m-d', strtotime($tmtmulaiakhir_pppk. ' + 1 year -1 day')),
                            'perpanjangan' => 1,
                            'perpanjangan_bulan' => 0,
                            'perpanjangan_satuan' => 'Tahun', //Bulan
                            'idjenpens' => '',
                            'keterangan' => '',
                            'bup' => ($attr->pensiunnext!='')?$attr->pensiunnext:date("Y-m-d")
                        );
                    }else{
                        $temp_arr2 = array(
                            'sts_kontrak' => 3,
                            'tmtakhir' => date('Y-m-d', strtotime($attr->pensiunnext. ' -1 day')),
                            'perpanjangan_bulan' => '',
                            'perpanjangan' => '',
                            'perpanjangan_satuan' => '',
                            'idjenpens' => 1,
                            'keterangan' => 'Pensiun BUP',
                            'bup' => ($attr->pensiunnext!='')?$attr->pensiunnext:date("Y-m-d")
                        );
                    }
                }                
                
                $temp_arr = array_merge($temp_arr1, $temp_arr2);

                array_push($data,$temp_arr);                
            }

            // echo "<pre>";
            //     print_r($data);
            // echo "</pre>";
            // exit();
            if (! empty($nip)){
                if(!\DB::table('tr_pppk')->insert($data)){
                    echo "Perpanjangan Kontrak PPPK gagal disimpan.";
                }else{
                    echo 1;
                }
            }else{
                echo 'Input tidak valid';
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('perpanjangankontrak::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('perpanjangankontrak::'.$view.'_print');
    }

    function getCetak(){
        // if (Session::get('role_id') < 3) {
            $view = Request::segment(4);
            $id = Request::segment(5);                    
            $tmtawal = Request::segment(7);
            $kode = Request::segment(6);
            $item = null;

            if($id == "all"){
                $item = PerpanjangankontrakModel::
                    whereRaw("MONTH(tr_pppk.tmtawal) = \"".$kode."\" and YEAR(tr_pppk.tmtawal) = \"".$tmtawal."\"")                    
                    ->where('sts_kontrak','=',2)->where('status','=',1)
                    ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->get();
            }else if($id == "kolektif"){
                $item = PerpanjangankontrakModel::where('tmtawal','=',$tmtawal)
                    ->where('sts_kontrak','=',2)->where('status','=',1)->where('kdunit','=', $kode)
                    ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->get();
            }else{
                $item = PerpanjangankontrakModel::where('id','=',$id)
                ->where('sts_kontrak','=',2)->where('status','=',1)->where('nip','=',$kode)
                ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->first();
            }

            return View::make('perpanjangankontrak::'.$view.'_print',compact('item','id','kode','tmtawal'));    
        // }else{
        //     abort(404);
        // }
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('perpanjangankontrak::'.$view.'_excel');
    }

    public function postDelete(){
        cekAjax();
        $data['idpppk'] = Input::get('id');
        $data['nip'] = Input::get('nip');
        $data['sts_kontrak'] = 2;

        echo (\DB::table('tr_pppk')->where($data)->delete())?9:'Gagal Dihapus';
    }

    /*function preview edit kgb*/
    function postEditpppk(){
        $idpppk = Input::get('idpppk');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_pppk as a')
            ->select('a.*', \DB::raw("
                    DATE_FORMAT(a.tglhr,'%d-%m-%Y') AS tglhr_,
                    DATE_FORMAT(a.tmtawall,'%d-%m-%Y') AS tmtawall_,
                    DATE_FORMAT(a.tmtakhirl,'%d-%m-%Y') AS tmtakhirl_,
                    DATE_FORMAT(a.tgskl,'%d-%m-%Y') AS tgskl_,
                    DATE_FORMAT(a.tmtawall,'%d-%m-%Y') AS tmtawall_,
                    DATE_FORMAT(a.tmtawal,'%d-%m-%Y') AS tmtawal_,
                    DATE_FORMAT(a.tmtakhir,'%d-%m-%Y') AS tmtakhir_
                ")
            )
            ->where('a.idpppk', $idpppk)
            ->where('a.sts_kontrak', 2)
            ->where('a.nip', $nip)
            ->first();

        echo json_encode($rs);
    }

    /*simpan update usulan pppk*/
    public function postUpdatepppk(){
        cekAjax();
        $input = Input::all();
        $dt['idpppk'] = $input['idpppk'];
        $dt['nip'] = $input['nip'];
        $dt['sts_kontrak'] = 2;

        $validation = \Validator::make($input, PerpanjangankontrakModel::$rule_updates);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('','tmtawal','tmtakhir');

            foreach ($input as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    } else {
                        $value = '0000-00-00';
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                    if($key == 'status'){
                        if($data[$key] == 2){
                            $data['no_urut'] = 0; 
                        }
                    }
                }
            }

            $awal  = new \DateTime($input['tmtawal']);
            $akhir = new \DateTime($input['tmtakhir']);
            $diff = $awal->diff($akhir->modify('+1 day'));

            $data['perpanjangan'] = $diff->y;
            $data['perpanjangan_bulan'] = $diff->m;
            $data['perpanjangan_satuan'] = ($diff->y >= 1)?'TAHUN':'BULAN';

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            $data['updated_at'] = sekarang();
                        
            if (\DB::table('tr_pppk')->where($dt)->update($data)) {
                echo "4";
            } else {
                echo "Data Gagal Disimpan";
            }
        }else{
            echo 'Input tidak valid';
        }
    }

    /*function untuk verifikasi pppk*/
    function postVerifikasipppk(){
        cekAjax();
        $input = Input::all();
        $dt['idpppk'] = $input['idpppk'];
        $dt['nip'] = $input['nip'];
        $dt['sts_kontrak'] = 2;
        $validation = \Validator::make($input, PerpanjangankontrakModel::$rule_verifikasi);

        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgsk');

            foreach ($input as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    } else {
                        $value = '0000-00-00';
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            if(Input::get('statususul') == 1){
                $data['kettms'] = '';
                $data['ketbtl'] = '';
            }else if(Input::get('statususul') == 2){
                $data['statussk'] = '';
                $data['ketbtl'] = '';
                $data['tgsk'] = '';
            }else {
                $data['statussk'] = '';
                $data['kettms'] = '';
                $data['tgsk'] = '';
            }
            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            $data['updated_at'] = sekarang();

            if (\DB::table('tr_pppk')->where($dt)->update($data)) {
                // if (Input::get('statussk') == '1') {
                //     $pppk = UsulanPPPK::where('nip','=',Input::get('nip'))
                //         ->where('idpppk','=',Input::get('idpppk'))
                //         ->where('sts_kontrak','=',2)
                //         ->first();

                //     if($pppk != null){
                //         if ($pppk->sts_kontrak == 2) {
                //             $s_pppk = new PPPKService($pppk);
                //             if($s_pppk->generateSK()){
                //                 return 4;
                //             }

                //             return 0;
                //         }
                //     }
                // } //di proses langusung saat ajukan tte
                return 4;
            } else {
                echo "Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function getEditskinduk()
    {
        cekAjax();
        return View::make('perpanjangankontrak::editskinduk');
    }

    public function postSimpanskinduk()
    {
        cekAjax();        
        $rpppk = PerpanjangankontrakModel::where('id', Input::get('id'))->first();                
        if (!empty($rpppk)) {            
            // Ambil data yang memenuhi kriteria, diurutkan berdasarkan tanggal lahir (asc)
            $rpppks = PerpanjangankontrakModel::where('sts_kontrak', 2)
                ->where('status', 1)
                ->where('tmtawal', $rpppk->tmtawal)
                ->orderBy('tglhr', 'asc')
                ->get();

            $noUrut = 1;
            foreach ($rpppks as $item) {                
                $rpppks = PerpanjangankontrakModel::
                    where('id','=',$item->id)                    
                    ->update([                    
                        'nosk' => Input::get('nosk'),
                        'tgsk' => Input::get('tgsk'),
                        'no_urut' => $noUrut
                    ]);

                $noUrut++;
            }                

            return 1;                        
        }        
    }

    public function getEditspinduk()
    {
        cekAjax();
        return View::make('perpanjangankontrak::editspinduk');
    }

    public function postSimpanspinduk()
    {
        cekAjax();
        
        $rpppk = PerpanjangankontrakModel::find(Input::get('id'));
        
        if (!empty($rpppk)) {
            if (Input::get('tipe') == 'all') {
                $rpppks = PerpanjangankontrakModel::
                    where('sts_kontrak','=',2)
                    ->where('status','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)                    
                    ->update([
                        'no_sp_induk' => Input::get('no_sp_induk'),
                        'tgl_sp_induk' => Input::get('tgl_sp_induk')
                    ]);

                return 1;
            }else if (Input::get('tipe') == 'kolektif') {
                $rpppks = PerpanjangankontrakModel::
                    where('sts_kontrak','=',2)
                    ->where('status','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)
                    ->where('kdunit','=',$rpppk->kdunit)
                    ->update([
                        'no_sp_induk' => Input::get('no_sp_induk'),
                        'tgl_sp_induk' => Input::get('tgl_sp_induk')
                    ]);

                return 1;
            }else{
                $rpppk->no_sp_induk = Input::get('no_sp_induk');
                $rpppk->tgl_sp_induk = Input::get('tgl_sp_induk');
                return $rpppk->save()?1:0;
            }
        }
        return 0;
    }

    public function getEditspkinduk()
    {
        cekAjax();
        return View::make('perpanjangankontrak::editspkinduk');
    }

    public function postSimpanspkinduk()
    {
        cekAjax();
        
        $rpppk = PerpanjangankontrakModel::find(Input::get('id'));
        
        if (!empty($rpppk)) {
            if (Input::get('tipe') == 'all') {
                $rpppks = PerpanjangankontrakModel::
                    where('sts_kontrak','=',2)
                    ->where('status','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)                    
                    ->update([
                        'no_spk_induk' => Input::get('no_spk_induk'),
                        'tgl_spk_induk' => Input::get('tgl_spk_induk')
                    ]);

                return 1;
            }else if (Input::get('tipe') == 'kolektif') {
                $rpppks = PerpanjangankontrakModel::
                    where('sts_kontrak','=',2)
                    ->where('status','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)
                    ->where('kdunit','=',$rpppk->kdunit)
                    ->update([
                        'no_spk_induk' => Input::get('no_spk_induk'),
                        'tgl_spk_induk' => Input::get('tgl_spk_induk')
                    ]);

                return 1;
            }else{
                $rpppk->no_spk_induk = Input::get('no_spk_induk');
                $rpppk->tgl_spk_induk = Input::get('tgl_spk_induk');
                return $rpppk->save()?1:0;
            }
        }
        return 0;
    }

    /*function untuk simpan attribut pengantar*/
    public function postSuratpengantar(){
        $tmtawal = Input::get('tmtawal');
        $idskpd = Input::get('idskpd');

        $data['nosk_pengantar'] = Input::get('nosk_pengantar');
        $data['berkas_pengantar'] = Input::get('berkas_pengantar');
        $data['tgl_skpengantar'] = date('Y-m-d', strtotime(Input::get('tgl_skpengantar')));        
        $data['nippen_sp'] = Input::get('nippen_sp');
        $data['jabpen_sp'] = Input::get('jabpen_sp');
        $data['pejpen_sp'] = Input::get('pejpen_sp');
        $data['golpen_sp'] = Input::get('golpen_sp');

        if(($tmtawal != '') and ($idskpd != '')){
            \DB::table('tr_pppk')->where('tmtawal', $tmtawal)->where('status','=',1)->where('sts_kontrak','=',2)->where('idskpd','like',''.$idskpd. '%')->update($data);

            $item = null;
            $id = 'kolektif';            
            $kode = $idskpd;
            $item = PerpanjangankontrakModel::where('tmtawal','=',$tmtawal)
                ->where('status','=', 1)
                ->where('sts_kontrak','=',2)
                ->where('kdunit','=', $kode)
                ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->get();

            $item2 = PerpanjangankontrakModel::where('tmtawal','=',$tmtawal)
                ->where('status','=', 2)                
                ->where('kdunit','=', $kode)
                ->orWhere(function($q) use ($kode) {
                    $q->where('sts_kontrak', '=', 3)
                    ->where('kdunit', '=', $kode);
                })
                ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->get();

            if(Input::get('actpengantar') == 1){
                return View::make('perpanjangankontrak::pengantarsk_print', compact('item','item2','id','kode','tmtawal'));
            }

            if(Input::get('actnominatif') == 1){
                return View::make('perpanjangankontrak::pengantarnom_print', compact('item','item2','id','kode','tmtawal'));
            }            
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    /*function untuk cek usulan sudah ada tau belum*/    
    function postCeknominatif(){
        $nip = Input::get('nip');

        $rs = \DB::table('tr_pppk')
            ->where('nip','=',$nip)
            ->where('sts_kontrak','=',2)
            ->where('statususul','!=',1)
            ->count();
        if($rs>0){
            echo 1;
        } else{
            echo 0;
        }
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('perpanjangankontrak::'.$view.'_view');
    }

    public function postCreateaps() {
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","tglusul","_token","tmtx");
        $arrindex   = array("","idusul","nip");        
        // dd($arrnot);
        $keyin      = array("","idusul","nip");
        $keyout     = array("","idusul","nip");
        $keydate    = array('','tmtpens','bup','tmtawal','tmtakhir');

        $arrtmtakhirl   = array("","tmtakhirl");
        $arrskpd   = array("","idskpd");

        //$tglusul = date("Y-m-d", strtotime(Input::get('tmtx')));
        //$dti['tglusul'] = $tglusul;
        $dt['role_id']   =\session::get('role_id') ;
        $dt['user_id']   =\session::get('user_id') ;


        foreach($_POST as $key=>$value){

            if(array_search($key,$arrnot)==""){
                if(array_search($key,$keyin)!=""){
                    $keys =  array_keys($keyin,$key);
                    $key  = $keyout[$keys[0]];
                }
                if(!is_array($value)){
                    $dt[$key] = $value;
                    if(array_search($key,$arrindex)!=""){
                        //$dti[$key] = $value;
                    }
                }

                if(is_array($value)){
                    foreach($value as $key2=>$value2){
                        $dt[$key2] = $value2;
                        if(array_search($key2,$arrindex)!=""){
                            //$dti[$key2] = $value2;
                        }
                        if(array_search($key2,$keydate)!=''){
                            if($value2 != ''){
                                $val = explode("-",$value2);
                                $dt[$key2] = $val[2]."-".$val[1]."-".$val[0];
                            }else{
                                $dt[$key2] = '0000-00-00';
                            }
                        }
                        //array idpppk
                        if(array_search($key2,$arrtmtakhirl)!=""){
                            $tmtakhirl = $value2;
                        }
                        if(array_search($key2,$arrskpd)!=""){
                            $idskpd = $value2;
                        }
                    }

                    $awal  = new \DateTime($dt['tmtawal']);
                    $akhir = new \DateTime($dt['tmtakhir']);
                    $diff = $awal->diff($akhir->modify('+1 day'));

                    $dt['perpanjangan'] = $diff->y;
                    $dt['perpanjangan_bulan'] = $diff->m;
                    $dt['perpanjangan_satuan'] = ($diff->y >= 1)?'TAHUN':'BULAN';

                    $dt['status'] = 1;
                    $dt['gaji'] = getGaji($dt['idgolru'],$dt['thkerja'],3);
                    $dt['golru'] = getAttr('a_golruang', 'idgolru', $dt['idgolru'], 'golru_p3k');
                    $dt['perpanjangan'] = PerpanjangankontrakModel::getKontrak($dt['tmtawal'], $dt['tmtakhir'], 1);
                    $dt['idpppk'] = date('Ym', strtotime($tmtakhirl)).'.'.$idskpd; 
                    $dt['created_at'] = sekarang();                                   

                    // echo "<pre>";
                    //     print_r($dt);
                    // echo "</pre>";
                    // exit();
                    $rssimpan = \DB::table('tr_pppk')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    public function postAjukantte()
    {
        cekAjax();

        if (Input::has('nip') && Input::has('idpppk')) {
            $usulanPPPK = UsulanPPPK::where('nip','=',Input::get('nip')) 
                ->where('idpppk','=',Input::get('idpppk'))->first();
            if (!empty($usulanPPPK)) {                
                $s_pppk = new PPPKService($usulanPPPK);
                if($s_pppk->generateSK('PPPK')){                    
                    return $s_pppk->ajukanTTE('PPPK')?1:"Gagal Mengajukan TTE!";
                }                                                                 
            }
        }

        return "PPPK Tidak Ditemukan";
    }

    public function postCekberkas(){
        $nip = Input::get('nip');
        $sts_kontrak = Input::get('sts_kontrak');
        $cek = PerpanjangankontrakModel::cekDokumen($nip, $sts_kontrak);
        
        return $cek;
    }
}
