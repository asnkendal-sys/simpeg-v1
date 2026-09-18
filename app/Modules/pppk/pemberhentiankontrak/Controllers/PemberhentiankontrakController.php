<?php namespace App\Modules\pppk\pemberhentiankontrak\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pppk\pemberhentiankontrak\Models\PemberhentiankontrakModel;
use App\Modules\pppk\perpanjangankontrak\Models\PerpanjangankontrakModel;
use App\Modules\kenaikangajiberkala\penetapannominatif\Models\PenetapannominatifModel;
use Input,View, Request, Form, File, Session;

use App\Models\PPPK\RPPPK;
use App\Services\PPPKService;
use App\Models\PPPK\UsulanPPPK;
class PemberhentiankontrakController extends Controller {

	protected $pemberhentiankontrak;

    public function getIndex(){
        cekAjax();
        if(strlen(Input::has('search')) > 0){
            $rpppk = RPPPK::with('pegawai')
                ->where('sts_kontrak','=',3)
                ->where('nip','like','%'.Input::get('search').'%')
                ->orderBy('idskpd')
                ->orderBy('tmtawal', 'desc');
        }else{
            $rpppk = RPPPK::with('pegawai')
                ->where('sts_kontrak','=',3)
                ->orderBy('idskpd')
                ->orderBy('tmtawal', 'desc');
        }

        if (Session::get('role_id') > 3) {
            $rpppk = $rpppk->where('r_pppk.idskpd','like', Session::get('idskpd')."%");
        }
        $rpppk = $rpppk->paginate($_ENV['configurations']['list-limit']);

        return View::make('pemberhentiankontrak::index', compact('rpppk'));
    }

    public function getIndexnominatif(){
        cekAjax();
        $where = "tr_pppk.sts_kontrak = 3 ";
        if (session('role_id') > 3) {
            $where.= " and tr_pppk.idskpd like \"".session('idskpd')."%\" ";
        }

        $jenis = 'PPPK-PEMBERHENTIAN';
        if ((strlen(Input::has('search')) > 0) or (Input::get('idjenpens') != '') or (Input::get('idskpd') != '') or (Input::has('tahun') != '') or (Input::has('bulan') != '') or (Input::has('statussk') != '') or (Input::get('status_tte') != '')) {
            (Input::get('idjenpens') != '')?$where .= " and tr_pppk.idjenpens = \"".Input::get('idjenpens')."\"":"";
            (Input::get('bulan') != '')?$where .= " and MONTH(tr_pppk.bup) = \"".Input::get('bulan')."\"":"";
            (Input::get('tahun') != '')?$where .= " and YEAR(tr_pppk.bup) = \"".Input::get('tahun')."\"":"";
            (Input::get('statussk') != '')?$where .= " and tr_pppk.statussk = \"".Input::get('statussk')."\"":"";            
            (Input::get('idskpd') != '')?$where .=" and tr_pppk.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search') != '')?$where .=" and (tr_pppk.nama LIKE '%".Input::get('search')."%' or tr_pppk.nip LIKE '%".Input::get('search')."%')":"";
            if (Input::get('status_tte') != '') {
                if (Input::get('status_tte')=='belum_mengusulkan') {
                    $where .= " and r_tte.proses IS NULL";
                }else{
                    $where .= " and r_tte.proses = \"".Input::get('status_tte')."\"";
                }
            }

            $rpppk = PemberhentiankontrakModel::select('tr_pppk.*','a_jenpens.jenpens', 'r_tte.proses',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
                ->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                ->leftJoin('r_tte', function($join)use($jenis){                       
                        $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                        ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                        ->where('r_tte.jenis','=',$jenis); 
                })                
                ->whereRaw($where)->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpppk = PemberhentiankontrakModel::select('tr_pppk.*','a_jenpens.jenpens', 'r_tte.proses',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
                ->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                ->leftJoin('r_tte', function($join)use($jenis){                       
                        $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                        ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                        ->where('r_tte.jenis','=',$jenis); 
                })                
                ->whereRaw($where)->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->paginate($_ENV['configurations']['list-limit']);
        }

        return View::make('pemberhentiankontrak::index_nominatif', compact('rpppk'));
    }

    public function getCreate()
    {
        return View::make('pemberhentiankontrak::create');
    }

    public function getCreateaps()
	{
		return View::make('pemberhentiankontrak::createaps');
    }

    public function postCreate()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PemberhentiankontrakModel::$rules);
        if ($validation->passes()){
            $data = array();
            /*ambil post dari inputan*/
            $bulan = $input['bulan'];
            $tahunkgb = $input['tahun'];            
            $bup = $input['bup'];
            $idskpd = $input['idskpd'];
            $nip = $input['nip'];

            $data = array();
            foreach($nip as $key => $item){
                $attr = PerpanjangankontrakModel::getattpppk($item);
                /*masa kerja*/
                $mkbln = substr($attr->mkskr,-2) + $attr->mkblncpn;
                if($mkbln > 12){
                    $thnmkskr = substr($attr->mkskr,0,-2)+1;
                    $blnmkskr = "0".($mkbln-12);
                }else{
                    $thnmkskr = substr($attr->mkskr,0,-2);
                    $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
                }
                $temp_arr = array(
                    'status' => 1,
                    'sts_kontrak' => 3,
                    'idjenpens' => 1,
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

                    'tmtawal' => $attr->tmtmulaiakhir_pppk,
                    'tmtakhir' => $attr->tmtakhirakhir_pppk,
                    'idgolru' => $attr->idgolruakhir_pppk,
                    'golru' => $attr->golru_p3k,
                    'thkerja' => $thnmkskr + 1, //$thnmkskr,
                    'blkerja' => $attr->mkblnakhir_pppk, //$blnmkskr,
                    'gaji' => getGaji($attr->idgolruakhir_pppk,($thnmkskr + 1),3), //$attr->gajiakhir_pppk,

                    'idtkpendid' => $attr->idtkpendid,
                    'tkpendid' => $attr->tkpendid,
                    'idjenjurusan' => $attr->idjenjurusan,
                    'jenjurusan' => $attr->jenjurusan,
                    'agama' => $attr->agama,
                    
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
                    'keterangan' => 'Pensiun BUP',
                    'bup' => $bup[$item],
                    
                    'created_at' => sekarang(),
                    'role_id' => \Session::get('role_id'),
                    'user_id' => \Session::get('user_id')
                );                
                array_push($data,$temp_arr);
            }

//            echo "<pre>";
//                print_r($data);
//            echo "</pre>";
//            exit();
            
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
        return View::make('pemberhentiankontrak::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('pemberhentiankontrak::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('pemberhentiankontrak::'.$view.'_excel');
    }

    public function postDelete(){
        cekAjax();
        $data['idpppk'] = Input::get('id');
        $data['nip'] = Input::get('nip');
        $data['sts_kontrak'] = 3;

        echo (\DB::table('tr_pppk')->where($data)->delete())?9:'Gagal Dihapus';
    }

    /*function preview edit kgb*/
    function postEditpppk(){
        $idpppk = Input::get('idpppk');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_pppk as a')
            ->join('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')
            ->select('a.*','a_jenpens.jenpens', \DB::raw("
                    DATE_FORMAT(a.tglhr,'%d-%m-%Y') AS tglhr_,
                    DATE_FORMAT(a.tmtawall,'%d-%m-%Y') AS tmtawall_,
                    DATE_FORMAT(a.tmtakhirl,'%d-%m-%Y') AS tmtakhirl_,
                    DATE_FORMAT(a.tgskl,'%d-%m-%Y') AS tgskl_,
                    DATE_FORMAT(a.tmtawall,'%d-%m-%Y') AS tmtawall_,
                    DATE_FORMAT(a.tmtawal,'%d-%m-%Y') AS tmtawal_,
                    DATE_FORMAT(a.bup,'%d-%m-%Y') AS bup_,
                    DATE_FORMAT(a.tmtakhir,'%d-%m-%Y') AS tmtakhir_,
                    DATE_FORMAT(a.tgl_dasar,'%d-%m-%Y') AS tgl_dasar_,
                    DATE_FORMAT(a.tmt_dasar,'%d-%m-%Y') AS tmt_dasar_
                ")
        )
            ->where('a.idpppk', $idpppk)
            ->where('a.sts_kontrak', 3)
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
        $dt['sts_kontrak'] = 3;

        $validation = \Validator::make($input, PemberhentiankontrakModel::$rule_updates);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('','bup','tgl_dasar','tmt_dasar');

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
        $dt['sts_kontrak'] = 3;
        $validation = \Validator::make($input, PemberhentiankontrakModel::$rule_verifikasi);

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
                echo "4";
            } else {
                echo "Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postAjukantte()
    {
        cekAjax();

        if (Input::has('nip') && Input::has('idpppk')) {
            $usulanPPPK = UsulanPPPK::where('nip','=',Input::get('nip')) 
                ->where('idpppk','=',Input::get('idpppk'))->first();
            if (!empty($usulanPPPK)) {                
                $s_pppk = new PPPKService($usulanPPPK);
                if($s_pppk->generateSK('PPPK-PEMBERHENTIAN')){                    
                    return $s_pppk->ajukanTTE('PPPK-PEMBERHENTIAN')?1:"Gagal Mengajukan TTE!";
                }                                                                 
            }
        }

        return "PPPK Tidak Ditemukan";
    }

    /*function cari pegawai*/
    public function postCaripegawai()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $where = "a.idstspeg = 3 and (a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\")";
        if (session('role_id') == 4) {
            $where .= " and a.idskpd like \"".session('idskpd')."%\" and a.idjenkedudupeg not in (99,21)";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.nip',
                'a.nama',
                'a.nip as id',
                'a.nama as text',
                'a.photo',
                'b.skpd',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
            )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
            ->whereRaw($where)
            /*->where('a.nip', 'like', '%'.$keyword. '%')
            ->orwhere('a.nama', 'like', '%'.$keyword. '%')*/
            ->orderBy('a.nama', 'asc')
            ->orderBy('a.nip', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function untuk cek usulan sudah ada tau belum*/    
    function postCeknominatif(){
        $nip = Input::get('nip');

        $rs = \DB::table('tr_pppk')
            ->where('nip','=',$nip)
            ->where('sts_kontrak','=',3)
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
        return View::make('pemberhentiankontrak::'.$view.'_view');
    }

    public function postCreateaps() {
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","tglusul","_token","tmtx");
        $arrindex   = array("","idusul","nip");        
        // dd($arrnot);
        $keyin      = array("","idusul","nip");
        $keyout     = array("","idusul","nip");
        $keydate    = array('','tmtpens','bup','tmt_dasar','tgl_dasar');

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
                    
                    $dt['status'] = 1;
                    $dt['gaji'] = getGaji($dt['idgolru'],$dt['thkerja'],3);
                    $dt['golru'] = getAttr('a_golruang', 'idgolru', $dt['idgolru'], 'golru_p3k');                    
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

    function getCetak(){
        // if (Session::get('role_id') < 3) {
            $view = Request::segment(4);
            $id = Request::segment(5);                    
            $bup = Request::segment(7);
            $kode = Request::segment(6);
            $item = null;

            if($id == "all"){
                $item = PemberhentiankontrakModel::join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                    ->select('tr_pppk.*', 'a_jenpens.jenpens')
                    ->whereRaw("MONTH(tr_pppk.bup) = \"".$kode."\" and YEAR(tr_pppk.bup) = \"".$bup."\"")                    
                    ->where('sts_kontrak','=',3)
                    ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->get();
            }else if($id == "kolektif"){
                $item = PemberhentiankontrakModel::join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                    ->select('tr_pppk.*', 'a_jenpens.jenpens')
                    ->where('sts_kontrak','=',3)->where('bup','=',$bup)
                    ->where('kdunit','=', $kode)
                    ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->get();
            }else{
                $item = PemberhentiankontrakModel::join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                    ->select('tr_pppk.*', 'a_jenpens.jenpens')
                    ->where('sts_kontrak','=',3)->where('id','=',$id)
                    ->where('nip','=',$kode)
                    ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                    ->first();
            }

            return View::make('pemberhentiankontrak::'.$view.'_print',compact('item','id','kode','bup'));    
        // }else{
        //     abort(404);
        // }
    }

    /*function untuk simpan attribut pengantar*/
    public function postSuratpengantar(){
        $bup = Input::get('bup');
        $idskpd = Input::get('idskpd');

        $data['nosk_pengantar'] = Input::get('nosk_pengantar');
        $data['berkas_pengantar'] = Input::get('berkas_pengantar');
        $data['tgl_skpengantar'] = date('Y-m-d', strtotime(Input::get('tgl_skpengantar')));
        $data['nippen_sp'] = Input::get('nippen_sp');
        $data['jabpen_sp'] = Input::get('jabpen_sp');
        $data['pejpen_sp'] = Input::get('pejpen_sp');
        $data['golpen_sp'] = Input::get('golpen_sp');

        if(($bup != '') and ($idskpd != '')){
            \DB::table('tr_pppk')->where('bup', $bup)->where('sts_kontrak','=',3)->where('idskpd','like',''.$idskpd. '%')->update($data);

            $item = null;
            $id = 'kolektif';            
            $kode = $idskpd;                
            $item = PemberhentiankontrakModel::join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                ->select('tr_pppk.*', 'a_jenpens.jenpens')
                ->where('sts_kontrak','=',3)->where('bup','=',$bup)
                ->where('kdunit','=', $kode)
                ->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->get();

            if(Input::get('actpengantar') == 1){
                return View::make('pemberhentiankontrak::pengantarsk_print', compact('item','id','kode','bup'));
            }

            if(Input::get('actnominatif') == 1){
                return View::make('pemberhentiankontrak::nominatifsk_print', compact('item','id','kode','bup'));
            }            
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    //surat pengantar bkpp
    public function postSuratpengantarbkpp(){
        $bup = Input::get('bup');
        $idskpd = Input::get('idskpd');
        $nip = Input::get('nip');
        
        $data['no_hukdis_bkd'] = Input::get('no_hukdis_bkd');
        $data['no_pidana_bkd'] = Input::get('no_pidana_bkd');
        $data['tgl_hukpid_bkd'] = date('Y-m-d', strtotime(Input::get('tgl_hukpid_bkd')));
        $data['jabkepalabkd'] = Input::get('jabkepalabkd');
        $data['kepalabkd'] = Input::get('kepalabkd');
        $data['nipkepalabkd'] = Input::get('nipkepalabkd');
        $data['pangkatbkd'] = Input::get('pangkatbkd');
        $data['golrubkd'] = Input::get('golrubkd');

        if(($bup != '') and ($idskpd != '')){
            \DB::table('tr_pppk')->where('nip', $nip)->where('bup', $bup)->where('idskpd','like',''.$idskpd. '%')->update($data);

            if(Input::get('acthukdisbkpp') == 1){
                return View::make('pemberhentiankontrak::surat_thukdisbkpp', array('bup'=>$bup, 'idskpd'=>$idskpd, 'nip'=>$nip));
            }

            if(Input::get('actpidanabkpp') == 1){
                return View::make('pemberhentiankontrak::surat_tpidanabkpp', array('bup'=>$bup, 'idskpd'=>$idskpd, 'nip'=>$nip));
            }
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    //hukdis opd
    public function postSurathukpid(){
        $bup = Input::get('bup');
        $idskpd = Input::get('idskpd');
        $nip = Input::get('nip');
        
        $data['no_hukdis_opd'] = Input::get('no_hukdis_opd');
        $data['no_pidana_opd'] = Input::get('no_pidana_opd');
        $data['tgl_hukpid_opd'] = date('Y-m-d', strtotime(Input::get('tgl_hukpid_opd')));
        $data['nippen_hukpid'] = Input::get('nippen_hukpid');
        $data['jabpen_hukpid'] = Input::get('jabpen_hukpid');
        $data['pejpen_hukpid'] = Input::get('pejpen_hukpid');
        $data['pangpen_hukpid'] = Input::get('pangpen_hukpid');
        $data['golpen_hukpid'] = Input::get('golpen_hukpid');

        if(($bup != '') and ($idskpd != '')){
            \DB::table('tr_pppk')->where('nip', $nip)->where('bup', $bup)->where('idskpd','like',''.$idskpd. '%')->update($data); //tambah nip

            if(Input::get('acthukdisopd') == 1){
                return View::make('pemberhentiankontrak::surat_thukdis', array('bup'=>$bup, 'idskpd'=>$idskpd, 'nip'=>$nip));
            }

            if(Input::get('actpidanaopd') == 1){
                return View::make('pemberhentiankontrak::surat_tpidana', array('bup'=>$bup, 'idskpd'=>$idskpd, 'nip'=>$nip));
            // echo "tes";
            }
        }else{
            echo "Data tidak ditemukan.";
        }
    }
}
