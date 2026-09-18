<?php namespace App\Modules\ecuti\nominatifcuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\nominatifcuti\Models\NominatifcutiModel;
use Input,View, Request, Form, File;

use App\Models\Riwayatcuti;
/**
* Nominatifcuti Controller
* @var Nominatifcuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifcutiController extends Controller {
    protected $nominatifcuti;

    public function __construct(NominatifcutiModel $nominatifcuti){
        $this->nominatifcuti = $nominatifcuti;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_ijin_cuti.nousul != '' ";
        if(session('role_id') > 3){
            $where .= " and tr_ijin_cuti.idskpd like \"".session('idskpd')."%\" ";
        }
        if(session('role_id') == 5){
            $where .= " and tr_ijin_cuti.nip like \"".session('user_id')."%\" ";
        }
        if (Input::has('search') or Input::get('bulan') != '' or Input::get('id_jenis_cuti') != '' or Input::get('idskpd') != '' ) {
            (Input::get('search')!='')?$where.=" and (tr_ijin_cuti.nip like '%".Input::get('search')."%' or tr_ijin_cuti.nama like '%".Input::get('search')."%')":"";
            (Input::get('bulan')!='')?$where.=" and month(tr_ijin_cuti.tgl_usul) = '".Input::get('bulan')."'":"";
            (Input::get('id_jenis_cuti')!='')?$where.=" and tr_ijin_cuti.id_jenis_cuti = '".Input::get('id_jenis_cuti')."'":"";
            (Input::get('idskpd')!='' && \Session::get('role_id') != 4)?$where.=" and tr_ijin_cuti.idskpd = '".Input::get('idskpd')."'":"";
            
            $nominatifcutis = $this->nominatifcuti
            ->select('tr_ijin_cuti.*',
                'a_golruang.golru','a_golruang.pangkat',
                'tb_01.nip','tb_01.idjenjab','tb_01.idskpd','tb_01.idjenjab',
                \DB::raw('tb_01.hp as telepon'),
                \DB::raw('IF(tb_01.idjenjab>4,b.jab,IF(tb_01.idjenjab=2,c.jabfung,IF(tb_01.idjenjab=3,d.jabfungum,IF(tb_01.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap')
            )
            ->leftjoin('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_skpd as b', 'tb_01.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'tb_01.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'tb_01.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as e', 'tb_01.idjabnonjob', '=', 'e.idjabnonjob')
            ->whereRaw($where)
            ->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
            ->paginate($_ENV['configurations']['list-limit']);
            
        }else{
            $nominatifcutis = $this->nominatifcuti->all();
        }

        if (\Session::get('role_id') <= 4) {
            return View::make('nominatifcuti::index_opd', compact('nominatifcutis'));
        }else{
            return View::make('nominatifcuti::index_pegawai', compact('nominatifcutis'));
        }
    }
    /*function cari pegawai*/
    function postCaripegawai(){
        cekAjax();
        $keyword    = Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));
        /*ADD KONDISI KHUSUS BUPATI*/
        $where1 = "b.id = 004 AND (b.jabatan like \"%".$keyword."%\" or b.namalengkap like \"%".$keyword."%\")";
        $where2 = "(a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\")";
        
        $rs1 = \DB::table('a_penetapsk as b')
        ->select('b.nip', 'b.namalengkap as nama', 'b.nip as id', 'b.namalengkap as text',\DB::raw('"default.png" as photo'),\DB::raw('"-" as skpd'), 'b.jabatan as jabatan',\DB::raw('b.namalengkap as namalengkap') )
        ->whereRaw($where1);

        $rs2 = \DB::table('tb_01 as a')
        ->select(
            'a.nip', 'a.nama', 'a.nip as id', 'a.nama as text', 'a.photo', 'b.skpd',
            \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
            \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
        )
        ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
        ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
        ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
        ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
        ->whereRaw($where2)
        ->orderBy('a.nama','asc')
        ->orderBy('a.nip','asc');
        $rs = $rs1->union($rs2);
        $arr['result']      = count($rs->get());
        $arr['per_page']    = $per_page;
        $arr['page']        = (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }


    public function getCreate(){
        cekAjax();
        if (\Session::get('role_id') <= 4) {
            return View::make('nominatifcuti::create_opd');
        }else{
            return View::make('nominatifcuti::create_pegawai');
        }
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, NominatifcutiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->nominatifcuti->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postSimpannominatif(){
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","nousul","tgl_usul","_token");
        $arrindex   = array("","nip");
        $keyin      = array("","nousul");
        $keyout     = array("","nousul");
        $keydate    = array("",'tgl_mulai','tgl_selesai');

        $tgl_usul = date("Y-m-d", strtotime(Input::get('tgl_usul')));
        $dti['tgl_usul'] = $tgl_usul;
        $dt['tgl_usul'] = $tgl_usul;

        $dt['nousul'] = Input::get('nousul');
        $dt['user_id']   =\session::get('user_id');  
        $dt['role_id']   =\session::get('role_id');  
        
        foreach($_POST as $key=>$value){

            if(array_search($key,$arrnot)==""){
                if(array_search($key,$keyin)!=""){
                    $keys =  array_keys($keyin,$key);
                    $key  = $keyout[$keys[0]];
                }
                if(!is_array($value)){
                    $dt[$key] = $value;
                    if(array_search($key,$arrindex)!=""){
                        $dti[$key] = $value;
                    }
                }

                if($dt['nousul']==''){
                    $rs = \DB::table('tr_ijin_cuti')->select(\DB::raw("CONCAT(DATE_FORMAT('".$dti['tgl_usul']."','%y%m%d'),
                        LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))->where('tgl_usul', $dti['tgl_usul'])->first();

                    $dt['nousul'] = $rs->kd;
                }

                if(is_array($value)){
                    foreach($value as $key2=>$value2){
                        $dt[$key2] = $value2;                                                
                        if(array_search($key2,$arrindex)!=""){
                            $dti[$key2] = $value2;
                        }
                        if(array_search($key2,$keydate)!=''){
                        // if(array_search($key2)!=''){
                            if($value2 != ''){
                                $val = explode("-",$value2);
                                $dt[$key2] = $val[2]."-".$val[1]."-".$val[0];
                            }else{
                                $dt[$key2] = '0000-00-00';
                            }
                        }                        
                    }
                    $rssimpan = \DB::table('tr_ijin_cuti')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    public function postSimpandaripegawai(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, NominatifcutiModel::$rules);
        if ($validation->passes()){
            $input['tgl_usul'] = date("Y-m-d", strtotime(Input::get('tgl_usul')));
            $input['tgl_mulai'] = date("Y-m-d", strtotime(Input::get('tgl_mulai')));
            $input['tgl_selesai'] = date("Y-m-d", strtotime(Input::get('tgl_selesai')));
            // $input['user_id'] = \Session::get('user_id');
            // if($input['nousul']==''){
            $rs = \DB::table('tr_ijin_cuti')->select(\DB::raw("CONCAT(DATE_FORMAT('".$input['tgl_usul']."','%y%m%d'),
                LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))->where('tgl_usul', $input['tgl_usul'])->first();
            $input['nousul'] = $rs->kd;
            // }

            $input['role_id'] = \Session::get('role_id');
            echo ($this->nominatifcuti->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $nominatifcuti = $this->nominatifcuti->find($id);
        //if (is_null($nominatifcuti)){return \Redirect::to('ecuti/nominatifcuti/index');}
        return View::make('nominatifcuti::edit', compact('nominatifcuti'));
    }



    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->nominatifcuti->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->nominatifcuti->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }
    /*Start Of Reza 18 April 2019*/
    public function postHapusnominatif(){
        cekAjax();
        $nousuls = Input::get('nousul');
        echo ($this->nominatifcuti->where('nousul',$nousuls)->delete())?9:'Gagal Dihapus';
    }
    /* Catatan : 
    - Perlu Master Hari kerja dalam seminggu 
        -> Karena ada OPD yang hari kerjanya 5 dan ada yg 6
    - Dan Master HARI LIBUR
    */
    /*24 APRIL 2019 Progress Modal Verifikasi dan edit usulan OPD*/
    public function postVerifikasidariopd(){
        cekAjax();
        $id = Input::get('id');
        $nousul = Input::get('nousul');
        $input = Input::all();
        $tglsk_cuti = (isset($input['tglsk_cuti']))?$input['tglsk_cuti']:"";
        if ($input['opd_status'] == 1) {
            $input['opd_alasan'] = "";
        }
        // if ($input['atasan_status'] == 1) {
        //     $input['atasan_alasan'] = "";
        // }
        // if ($input['wewenang_status'] == 1) {
        //     $input['wewenang_alasan'] = "";
        // }
        if ($tglsk_cuti != "") {
            $input['tglsk_cuti'] = date("Y-m-d", strtotime(Input::get('tglsk_cuti')));
        }
        // if ($input['atasan_sts_plt'] != 2) {
        //     $input['atasan_jab_plt'] = "";
        // }
        // if ($input['wewenang_sts_plt'] != 2) {
        //     $input['wewenang_jab_plt'] = "";
        // }
        $nominatifcuti = $this->nominatifcuti->find($id);
        echo ($nominatifcuti->update($input))?1:"Gagal Disimpan";
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        // $validation = \Validator::make($input, NominatifcutiModel::$rules);
        // if ($validation->passes()){
        $nominatifcuti = $this->nominatifcuti->find($id);
        $input['tgl_usul'] = date("Y-m-d", strtotime(Input::get('tgl_usul')));
        $input['tgl_mulai'] = date("Y-m-d", strtotime(Input::get('tgl_mulai')));
        $input['tgl_selesai'] = date("Y-m-d", strtotime(Input::get('tgl_selesai')));
        echo ($nominatifcuti->update($input))?1:"Gagal Disimpan";
        // }
        // else{
            // echo 'Input tidak valid';
        // }
    }
    
    public function postCeknippadanousul(){
        $nip = Input::get('nip');
        $nousul = Input::get('nousul');
        $ret['ceknip'] = CekPegawaiPadaNoUsulCuti($nousul,$nip);
        echo json_encode($ret);
    }

    public function postDetailcuti(){
        $data['nip'] = Input::get('nip');
        $data['nama'] = Input::get('nama');
        return View::make('nominatifcuti::riwayatcuti_popup', compact('data'));
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifcuti::'.$view.'_view');

    }
    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifcuti::'.$view.'_data');
    }
    /*function view Print atribut dari link */
    function postPrint(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifcuti::'.$view.'_print');
    }

    /*function view Modal atribut dari link */
    function postModal(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifcuti::'.$view.'_modal');
    }

    /*Function Untuk menadaptkan detail pegawai yang menjadi atasan dan wewenang*/
    public function postDetailpegawai(){
        $nip = Input::get('nip');
        if ($nip == "-") {
            $rs = \DB::table('a_penetapsk as b')
            ->select('b.jabatan as jabatan',\DB::raw('b.namalengkap as namalengkap') )
            ->whereRaw('b.id = 004')
            ->first();

            $ret['nama']     = $rs->namalengkap;
            $ret['jab']      = $rs->jabatan;
            $ret['pangkat']  = "-";
            $ret['idjenjab'] = "-";
            $ret['idjab']    = "-";
            $ret['idskpd']   = "-";
            $ret['skpd']     = "-";
        }else{
            $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golrupkt.golru','a_skpd.skpd','a_esl.esl',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap, b_skpd.skpd as unit'),

        // \DB::raw('IF(tb_01.idjenjab=1,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),

                // \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),

                \DB::raw('
                    IF(tb_01.iskepsek=1 AND LEFT(tb_01.idskpd,2)="04",a_skpd.jab,
                    IF(tb_01.idjenjab>4,a_skpd.jab,
                    IF(tb_01.idjenjab=2,a_jabfung.jabfung,
                    IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,
                    IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-"))))) as jabatan'),

                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjab'),

                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia, a_golrucpn.golru as golrucpn, a_golrucpn.pangkat as pangkatcpn, a_golrupns.golru as golrupns, a_golrupns.pangkat as pangkatpns, a_golrupkt.golru as golrupkt, a_golrupkt.pangkat as pangkatpkt")
            )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->join('a_skpd as b_skpd', 'tb_01.kdunit', '=', 'b_skpd.idskpd')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_golruang as a_golrucpn', 'tb_01.idgolrucpn', '=', 'a_golrucpn.idgolru')
            ->leftjoin('a_golruang as a_golrupns', 'tb_01.idgolrupns', '=', 'a_golrupns.idgolru')
            ->leftjoin('a_golruang as a_golrupkt', 'tb_01.idgolrupkt', '=', 'a_golrupkt.idgolru')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->where('nip', $nip)
            ->orderBy('tb_01.idjenjab', 'asc')
            ->orderBy('tb_01.idgolrupkt', 'desc')
            ->orderBy('tb_01.tmtpkt', 'asc')
            ->first();
            $ret['nama']     = $rs->namalengkap;
            $ret['jab']      = $rs->jabatan;
            $ret['pangkat']  = $rs->pangkatpkt;
            $ret['idjenjab'] = $rs->idjenjab;
            $ret['idjab']    = $rs->idjab;
            $ret['idskpd']   = $rs->idskpd;
            $ret['skpd']     = $rs->skpd;
        }

        echo json_encode($ret);
    }


    public function postHitungharikerja(){
        $nip             = \Input::get('nip');
        $jml_hari_kerja  = 0;
        $jml_hari_sabtu  = 0;
        $jml_hari_minggu = 0;

        $tgl_mulai   = Input::get('tgl_mulai');
        $tgl_selesai = Input::get('tgl_selesai');

        $tgl_mulai = date_create_from_format('d-m-Y', $tgl_mulai);
        $tgl_mulai = date_format($tgl_mulai, 'Y-m-d');

        $tgl_selesai = date_create_from_format('d-m-Y', $tgl_selesai);
        $tgl_selesai = date_format($tgl_selesai, 'Y-m-d');

        $jml_hari_libur = CheckHariLibur($tgl_mulai,$tgl_selesai);

        $tgl_mulai = strtotime($tgl_mulai);
        $tgl_selesai = strtotime($tgl_selesai);
        $angka_hari_mulai   = date("N", $tgl_mulai)." - Hari : ".date("D", $tgl_mulai);
        $angka_hari_selesai = date("N", $tgl_selesai)." - Hari : ".date("D", $tgl_selesai);

        $rs  = \DB::table('tb_01')->select('hari_kerja')->where('nip', $nip)->first();
        if ($rs->hari_kerja == 5) {
            /*FUNCTION UNTUK 5 (LIMA) HARI KERJA*/
            for ($i=$tgl_mulai; $i <= $tgl_selesai; $i += (60 * 60 * 24)) 
            {
                if (date('w', $i) !== '0' && date('w', $i) !== '6')
                {
                    if(CheckLibur(date('Y-m-d',$i)) == 0){
                        $jml_hari_kerja++;
                    }
                } 
                else {
                    if (date('w', $i) != 0) {
                     $jml_hari_sabtu++;
                 }else{
                    $jml_hari_minggu++;
                }
            }
        }
    }
    if ($rs->hari_kerja == 6) {
        /*FUNCTION UNTUK 6 (LIMA) HARI KERJA*/
        for ($i=$tgl_mulai; $i <= $tgl_selesai; $i += (60 * 60 * 24)) 
        {
            if (date('w', $i) !== '0' && date('w', $i) !== '6')
            {
                if(CheckLibur(date('Y-m-d',$i)) == 0){
                    $jml_hari_kerja++;
                }
            } 
            else {
                if (date('w', $i) != 0) {
                 $jml_hari_sabtu++;
                 if(CheckLibur(date('Y-m-d',$i)) == 0){
                    $jml_hari_kerja++;
                }
            }else{
                $jml_hari_minggu++;
            }
        }
    }
}
if ($rs->hari_kerja == 7) {
    /*FUNCTION UNTUK 7 (LIMA) HARI KERJA*/
    for ($i=$tgl_mulai; $i <= $tgl_selesai; $i += (60 * 60 * 24)) 
    {
        if (date('w', $i) !== '0' && date('w', $i) !== '6')
        {
            if(CheckLibur(date('Y-m-d',$i)) == 0){
                $jml_hari_kerja++;
            }
        } 
        else {
            if (date('w', $i) != 0) {
             $jml_hari_sabtu++;
             if(CheckLibur(date('Y-m-d',$i)) == 0){
                $jml_hari_kerja++;
            }
        }else{
            $jml_hari_minggu++;
            if(CheckLibur(date('Y-m-d',$i)) == 0){
                $jml_hari_kerja++;
            }
        }
    }
}
}


$ret['shift_hari_kerja'] = $rs->hari_kerja;
$ret['jml_hari_kerja'] = $jml_hari_kerja;

$ret['angka_hari_mulai']   = $angka_hari_mulai;
$ret['angka_hari_selesai'] = $angka_hari_selesai;

$ret['tgl_mulai']   = $tgl_mulai;
$ret['tgl_selesai'] = $tgl_selesai;

$ret['jml_hari_kerja'] = $jml_hari_kerja;
$ret['jml_hari_sabtu'] = $jml_hari_sabtu;
$ret['jml_hari_minggu'] = $jml_hari_minggu;
$ret['jml_hari_libur'] = $jml_hari_libur;

echo json_encode($ret);
}


/*Function Penyesuaian Kuota Update R_CUTI dan TB_01*/
public function postPenyesuaiankuota(){
    cekAjax();
    $nip = Input::get('nip');
    $input = Input::all();

    $penyu = \PenyesuaiankuotaModel::create(
        ['nip' => $nip,
        'hari_kerja' => \Input::get('hari_kerja'),
        'k_tahunan_n2' => \Input::get('k_tahunan_n2'),
        'k_tahunan_n1' => \Input::get('k_tahunan_n1'),
        'k_tahunan_n' => \Input::get('k_tahunan_n'),

        'k_besar_bulan' => \Input::get('k_besar_bulan'),
        'k_besar_hari' => \Input::get('k_besar_hari'),

        'k_sakit_tahun' => \Input::get('k_sakit_tahun'),
        'k_sakit_bulan' => \Input::get('k_sakit_bulan'),
        'k_sakit_hari' => \Input::get('k_sakit_hari'),

        'k_lahir_bulan' => \Input::get('k_lahir_bulan'),
        'k_lahir_hari' => \Input::get('k_lahir_hari'),

        'k_penting_bulan' => \Input::get('k_penting_bulan'),
        'k_penting_hari' => \Input::get('k_penting_hari'),

        'k_cltn_tahun' => \Input::get('k_cltn_tahun'),
        'k_cltn_bulan' => \Input::get('k_cltn_bulan'),
        'k_cltn_hari' => \Input::get('k_cltn_hari'),

        'user_id' => \Session::get('user_id'),
        'role_id' => \Session::get('role_id'),
        'created_at' => date("Y-m-d H:i:s")
    ]
);
    if($penyu){
        $rs = \DB::table('tb_01')->where('nip', $nip)->update(['hari_kerja' => \Input::get('hari_kerja')]);
        $final_kuota_tahunann2 = \Input::get('k_tahunan_n2');
        $final_kuota_tahunann1 = \Input::get('k_tahunan_n1');
        $final_kuota_tahunan   = \Input::get('k_tahunan_n');
        $final_kuota_besar     = HitungPenyusuaian(0,\Input::get('k_besar_bulan'),\Input::get('k_besar_hari'));
        $final_kuota_sakit     = HitungPenyusuaian(\Input::get('k_sakit_tahun'),\Input::get('k_sakit_bulan'),\Input::get('k_sakit_hari'));
        $final_kuota_lahirkan  = HitungPenyusuaian(0,\Input::get('k_lahir_bulan'),\Input::get('k_lahir_hari'));
        $final_kuota_penting   = HitungPenyusuaian(0,\Input::get('k_penting_bulan'),\Input::get('k_penting_hari'));
        $final_kuota_cltn      = HitungPenyusuaian(\Input::get('k_cltn_tahun'),\Input::get('k_cltn_bulan'),\Input::get('k_cltn_hari'));

        $rcuti = Riwayatcuti::create( 
            [
                'nip' => $nip, 
                'nousul' => 0,
                'jencuti' => 0,
                'thn' => date('Y'),
                'ket' => "Penyesuaian",
                'kuota_tahunan_n2' => $final_kuota_tahunann2,
                'kuota_tahunan_n1' => $final_kuota_tahunann1,
                'kuota_tahunan_n' => $final_kuota_tahunan,
                'kuota_besar' => $final_kuota_besar,
                'kuota_sakit' => $final_kuota_sakit,
                'kuota_melahirkan' => $final_kuota_lahirkan,
                'kuota_penting' => $final_kuota_penting,
                'kuota_diluarnegara' => $final_kuota_cltn
            ]
        );
        if ($rcuti) {
            $pesan = '1';
        }
    }else{
        $pesan =  "Penyesuaian Gagal Dilakukan";
    }

    echo $pesan;
}

/*FUNGSI UNTUK MENJALANKAN ATURAN CUTI*/
public function postCekkuotacuti(){
    $nip           = Input::get('nip');
    $id_jenis_cuti = Input::get('id_jenis_cuti');
    $pgw           = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
    $mk_thn        = $pgw->thn_cpns; //masa kerja dalam tahun
    $ret['notif']  = 0; //untuk menandai return jika ada aturan tidak terpenuhi = 1
    $ret['dis_mulai']  = 0; //untuk menandai return untuk disabled tanggal mulai
    $ret['dis_selesai']  = 0; //untuk menandai return untuk disabled tanggal selesai

    // $ret['detail'] = $pgw;
    $v = "<span style='color:green;'><i class='fa fa-check-circle' title='Memenuhi Syarat'/></span>";
    $x = "<span style='color:red;'><i class='fa fa-times-circle' title='Tidak Memenuhi Syarat'/></span>";
    $feedback      = "<p class='text-center'>
    <b>.: Perhatian :.</b>
    </p>
    Berdasarkan <a href='".url()."/packages/upload/pdf/Peraturan-BKN-Nomor-24-Tahun-2017-tentang-tata-Cara-Pemberian-Cuti-PNS.pdf' target='_blank'> Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil&nbsp;<i class='glyphicon glyphicon-new-window'></i></a>. Usulan cuti <b>".getJenisCuti($id_jenis_cuti)."</b> tidak dapat dilanjukan karena : <br> 
    <table class='table table-striped table-hover table-condensed table-bordered' width='100%'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center' style='vertical-align: middle;' width='3%'>NO</th>
    <th class='text-center' style='vertical-align: middle;'>KETERANGAN</th>
    <th class='text-center' style='vertical-align: middle;'>SYARAT</th>
    <th class='text-center' style='vertical-align: middle;'>KONDISI</th>
    <th class='text-center' style='vertical-align: middle;' width='3%'>STATUS</th>
    </tr>
    </thead>
    <tbody>"; //Feedback dalam bentuk tabel jika ada aturan yang tidak terpenuhi

    $rs = \DB::table('view_kuota_cuti')->where('nip', $nip)->first(); //Membaca riwayat cuti terakhir
    
    if (count($rs) > 0) {

        if ($id_jenis_cuti == 1) {
            $ret['kuota_cuti'] = ($rs->kuota_tahunan_n2+$rs->kuota_tahunan_n1+$rs->kuota_tahunan_n);
            /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
            if ($mk_thn < 1) {
                /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
                $ret['notif']       = 1; 
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $ret['kuota_cuti']  = 0;
                $feedback .="<tr>
                <td>1</td>
                <td>Masa Kerja</td>
                <td>1 Tahun</td>
                <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
                <td class='text-center' style='vertical-align: middle;'> $x </td>
                </tr>";
            }else{
                $feedback .="<tr><td>1</td><td>Masa Kerja</td><td>1 Tahun</td><td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td><td class='text-center' style='vertical-align: middle;'> $v </td></tr>";
            }
            /*Kondisi jika YBS guru*/
            if ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300') {
                $ret['notif']       = 1;
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $ret['kuota_cuti']  = 0;
                $feedback .= "<tr>
                <td>2</td>
                <td>Jabatan Guru</td>
                <td class='text-center' colspan='3'>Tidak berhak atas cuti tahunan</td>
                </tr>"; //Nanti dibuat tabel notifnya yang menyatakan Jab GURU tidak berhak atas cuti tahunan
            }

            /*Cetak keterangan jika ada kondisi yg terpenuhi*/
            if ($mk_thn < 1 || ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300')) {
                $feedback .="</tbody>
                </table>
                <b>Keterangan : </b> <br>
                <table class='table table-striped table-hover table-condensed table-bordered'>
                <tr>
                <td width='3%'></td>
                <td>
                <li>PNS yang menduduki jabatan guru pada sekolah dan jabatan dosen pada perguruan tinggi yang mendapat liburan menurut peraturan perundang-undangan, disamakan dengan PNS yang telah menggunakan hak cuti tahunan.</li>
                <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
                </td>
                </tr>
                </table>";
            }


        }//Sudah tinggal return peringatan jika ada aturan yang tidak terpenuhi

        else if ($id_jenis_cuti == 2) {

            $ret['kuota_cuti'] = $rs->kuota_besar;
            /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
            if ($mk_thn < 5) {
                /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
                $ret['notif']       = 1;
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $ret['kuota_cuti'] = 0;
                $feedback .="<tr>
                <td>1</td>
                <td>Masa Kerja</td>
                <td>5 Tahun</td>
                <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
                <td class='text-center' style='vertical-align: middle;'> $x </td>
                </tr>";
            }else{
                $feedback .="<tr>
                <td>1</td>
                <td>Masa Kerja</td>
                <td>5 Tahun</td>
                <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
                <td class='text-center' style='vertical-align: middle;'> $v </td>
                </tr>";
            }

            /*Kondisi jika YBS sudah pernah menjalankan cuti Tahunan pada tahun berjalan*/
            /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
            $r_besar = getRiwayatcuti($nip,2,"");
            $r_tahun = getRiwayatcuti($nip,1,date('Y'));
            /*Kondisi YBS sudah mengambil cuti tahunan pada tahun berjalan*/
            // if ($r_tahun->lama_cuti != 0 && $r_tahun == date("Y") ) {//date("Y") diganti dengan tahun inputan tanggal mulai
            if ($r_tahun->lama_cuti != 0) {
                $ret['notif']  = 1;
                $ret['kuota_cuti'] = ($rs->kuota_besar-$r_tahun->lama_cuti);
                $feedback .="<tr>
                <td>2</td>
                <td>Cuti Tahunan</td>
                <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
                <td>Melakukan Cuti Tahunan selama ".$r_tahun->lama_cuti." Hari</td>
                <td class='text-center' style='vertical-align: middle;'>".$v."</td>
                </tr>";
            }

            if ($mk_thn < 5 || $r_tahun->lama_cuti != 0) {
                $feedback .="</tbody>
                </table>
                <b>Keterangan : </b> <br>
                <table class='table table-striped table-hover table-condensed table-bordered'>
                <tr>
                <td width='3%'></td>
                <td>
                <li>PNS yang telah menggunakan hak atas cuti tahunan pada tahun yang bersangkutan maka hak atas cuti besar yang bersangkutan diberikan dengan memperhitungkan hak atas cuti tahunan yang telah digunakan.</li>
                <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
                </td>
                </tr>
                </table>";
            }
        }

        else if ($id_jenis_cuti == 3) {
            $ret['kuota_cuti'] = $rs->kuota_sakit;
        }

        else if ($id_jenis_cuti == 4) {

            $jum_anak = Hitanakkandung($nip,$pgw->tmtcpn); //Fungsi untuk mendapatkan jumlah anak "KANDUNG"
            $ret['kuota_cuti'] = $rs->kuota_melahirkan;
            if($jum_anak>=3 && $pgw->idjenkel!=1){
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $feedback .="<tr>
                <td>1</td>
                <td>Jumlah Anak YBS Berhak Cuti</td>
                <td>Maksimal 3 Anak</td>
                <td>2 Anak</td>
                <td class='text-center' style='vertical-align: middle;'>{!! $v !!}</td>
                </tr>";
            }
            if($pgw->idjenkel==1){
                $ret['notif']       = 1;
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $ret['kuota_cuti'] = 0;
                $feedback .="<tr>
                <td>1</td>
                <td>Cuti Melahirkan</td>
                <td class='text-center' colspan='3'>PNS Laki - Laki tidak berhak atas <b>Cuti Melahirkan</b></td>
                </tr>";
                $feedback .="</tbody>
                </table>
                <b>Keterangan : </b> <br>
                <table class='table table-striped table-hover table-condensed table-bordered'>
                <tr>
                <td width='3%'></td>
                <td>
                <li>Bagi PNS Laki - Laki yang yang isterinya melahirkan/operasi caesar silahkan mengajukan cuti karena alasan penting dengan melampirkan surat keterangan rawat inap dari Unit Pelayanan Kesehatan.</li>
                <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
                </td>
                </tr>
                </table>";
            }

        }
        else if ($id_jenis_cuti == 5) {
            $ret['kuota_cuti'] = $rs->kuota_penting;
        }

        else if ($id_jenis_cuti == 6) {
            $ret['kuota_cuti'] = $rs->kuota_diluarnegara;
            /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
            if ($mk_thn < 5) {
                /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_mulai']   = 1;
                $ret['dis_selesai'] = 1;
                $feedback .="<tr>
                <td>1</td>
                <td>Masa Kerja</td>
                <td>5 Tahun</td>
                <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
                <td class='text-center' style='vertical-align: middle;'> $x </td>
                </tr>";
                $feedback .="</tbody>
                </table>
                <b>Keterangan : </b> <br>
                <table class='table table-striped table-hover table-condensed table-bordered'>
                <tr>
                <td width='3%'></td>
                <td>
                <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
                </td>
                </tr>
                </table>";
            }
        }
        else{
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
        }
    }else{
        $ret['notif']      = 1;
        $ret['kuota_cuti'] = 0;
        $ret['feedback']   = "Periksa Riwayat / Penyesuaian Kuota Cuti Anda";
    }
    $ret['feedback'] = $feedback;
    $ret['kuota_cuti'] = number_format($ret['kuota_cuti'], 0, ',', '');
    // $ret['kuota_cuti'] = number_format($ret['kuota_cuti'], 0, '.', '');
    echo json_encode($ret);
}

public function postCekkuotabytanggalmulai(){
    $nip           = Input::get('nip');
    $tgl_mulai     = Input::get('tgl_mulai');
    $tanggalmulai  = date("Y-m-d", strtotime(Input::get('tgl_mulai')));
    $pgw           = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
    $mk_thn        = $pgw->thn_cpns; //masa kerja dalam tahun
    $id_jenis_cuti = Input::get('id_jenis_cuti');
    $tahun_cuti    = substr($tgl_mulai, 6,10);
    $ret['notif']  = 0; //untuk menandai return jika ada aturan tidak terpenuhi = 1
    $ret['dis_mulai']  = 0; //untuk menandai return untuk disabled tanggal mulai
    $ret['dis_selesai']  = 0; //untuk menandai return untuk disabled tanggal selesai
    $v = "<span style='color:green;'><i class='fa fa-check-circle' title='Memenuhi Syarat'/></span>";
    $x = "<span style='color:red;'><i class='fa fa-times-circle' title='Tidak Memenuhi Syarat'/></span>";
    $feedback      = "<p class='text-center'><b>.: Perhatian :.</b></p>
    Berdasarkan <a href='".url()."/packages/upload/pdf/Peraturan-BKN-Nomor-24-Tahun-2017-tentang-tata-Cara-Pemberian-Cuti-PNS.pdf' target='_blank'> Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil&nbsp;<i class='glyphicon glyphicon-new-window'></i></a>. Usulan cuti <b>".getJenisCuti($id_jenis_cuti)."</b> tidak dapat dilanjukan karena : <br> 
    <table class='table table-striped table-hover table-condensed table-bordered' width='100%'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center' style='vertical-align: middle;' width='3%'>NO</th>
    <th class='text-center' style='vertical-align: middle;'>KETERANGAN</th>
    <th class='text-center' style='vertical-align: middle;'>SYARAT</th>
    <th class='text-center' style='vertical-align: middle;'>KONDISI</th>
    <th class='text-center' style='vertical-align: middle;' width='3%'>STATUS</th>
    </tr>
    </thead>
    <tbody>"; //Feedback dalam bentuk tabel jika ada aturan yang tidak terpenuhi

    $rs = \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
    if ($id_jenis_cuti == 1) {
        $ret['kuota_cuti'] = ($rs->kuota_tahunan_n2+$rs->kuota_tahunan_n1+$rs->kuota_tahunan_n);
        
        if ($rs->thn<$tahun_cuti) {
            $kuota_tahunan = ($rs->kuota_tahunan_n1+(($rs->kuota_tahunan_n>6)?6:$rs->kuota_tahunan_n)+12);
            $ret['kuota_cuti'] = $kuota_tahunan;    
        }
        /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
        if ($mk_thn < 1) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1; 
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>1 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'>$x</td>
            </tr>";
        }else{
            $feedback .="<tr><td>1</td><td>Masa Kerja</td><td>1 Tahun</td><td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td><td class='text-center' style='vertical-align: middle;'>$v</td></tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Besar pada tahun berjalan*/
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        $r_besar  = getRiwayatcuti($nip,2,$tahun_cuti);
        if ($tahun_cuti == $r_besar->thn) { 
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_selesai'] = 1;
            $feedback .= "<tr>
            <td>2</td>
            <td>Cuti Besar</td>
            <td>Tidak/Belum mengambil cuti besar pada tahun berjalan - (<b>".$tahun_cuti."</b>)</td>
            <td>Sudah</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
        }

        /*Cetak keterangan jika ada kondisi yg terpenuhi*/
        if ($tahun_cuti == $r_besar->thn || $mk_thn < 1 || ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300')) {
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang menduduki jabatan guru pada sekolah dan jabatan dosen pada perguruan tinggi yang mendapat liburan menurut peraturan perundang-undangan, disamakan dengan PNS yang telah menggunakan hak cuti tahunan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
    }
    else if($id_jenis_cuti == 2){
        $ret['kuota_cuti'] = $rs->kuota_besar;
        if ($mk_thn < 5) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
        }else{
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $v </td>
            </tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Tahunan pada tahun berjalan*/
        $r_besar = getRiwayatcuti($nip,2,"");
        $r_tahun = getRiwayatcuti($nip,1,$tahun_cuti);
        /*Kondisi YBS sudah mengambil cuti tahunan pada tahun berjalan*/
            // if ($r_tahun->lama_cuti != 0 && $r_tahun == date("Y") ) {//date("Y") diganti dengan tahun inputan tanggal mulai
        if ($r_tahun->lama_cuti != 0) {
            $ret['notif']       = 1;
            $ret['kuota_cuti'] = ($rs->kuota_besar-$r_tahun->lama_cuti);
            $feedback .="<tr>
            <td>2</td>
            <td>Cuti Tahunan</td>
            <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
            <td>Melakukan Cuti Tahunan selama ".$r_tahun->lama_cuti." Hari</td>
            <td class='text-center' style='vertical-align: middle;'> $v </td>
            </tr>";
        }else{
            $feedback .="<tr>
            <td>2</td>
            <td>Cuti Tahunan</td>
            <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
            <td>Belum</td>
            <td class='text-center' style='vertical-align: middle;'> $v </td>
            </tr>";
        }

        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
        $thn_bisa_besar = ($r_besar->thn+5);//thn_bisa_besar = tahun terakhir mengajukan cuti besar ditambah rentang 5 tahun
        $tgl_bisa_besar = date('Y-m-d',strtotime("+5 year",strtotime($r_besar->tgmul)));
        if($tanggalmulai >= $tgl_bisa_besar){
            $ret['kuota_cuti']  = (3*30.44);
            // $ret['x']  = $tanggalmulai." - ".$tgl_bisa_besar;
        }else{
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_selesai'] = 1;
            $feedback .= "<tr>
            <td>3</td>
            <td>Rentang Pengajuan</td>
            <td>Per 5 Tahun (".formattanggalpanjang($r_besar->tgmul).")</td>
            <td>".formattanggalpanjang($tgl_bisa_besar)."<br>".getJarakDuaTanggal3(date('Y/m/d'),$tgl_bisa_besar)."</td>
            <td class='text-center' style='vertical-align: middle;'>$x</td>
            </tr>";
        }

        if( ($mk_thn < 5) || ($r_tahun->lama_cuti != 0) || ($per_5thn!=5 && $tahun_cuti>$per_5thn) || ($thn_bisa_besar <= $tahun_cuti) ){
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang telah menggunakan hak atas <b>cuti tahunan</b> pada tahun yang bersangkutan maka hak atas <b>cuti besar</b> yang bersangkutan diberikan dengan memperhitungkan hak atas <b>cuti tahunan</b> yang telah digunakan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
    }
    else if ($id_jenis_cuti == 3) {
        $ret['kuota_cuti'] = $rs->kuota_sakit;
    }

    else if ($id_jenis_cuti == 4) {
        $jum_anak = Hitanakkandung($nip,$pgw->tmtcpn); 
        $ret['kuota_cuti'] = $rs->kuota_melahirkan;
        if($jum_anak>=3){
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $feedback .="<tr>
            <td>1</td>
            <td>Jumlah Anak YBS Berhak Cuti</td>
            <td>Maksimal 3 Anak</td>
            <td>".$jum_anak." Anak</td>
            <td class='text-center' style='vertical-align: middle;'>$v</td>
            </tr>";
        }
    }
    else if ($id_jenis_cuti == 5) {
        $ret['kuota_cuti'] = $rs->kuota_penting;
        /*Kondisi jika YBS sudah pernah menjalankan cuti Alsan Penting pada tahun berjalan*/
        $r_penting  = getRiwayatcuti($nip,5,$tahun_cuti);
        if ($tahun_cuti==$r_penting->thn) { 
            $ret['notif']  = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .= "<tr>
            <td>1</td>
            <td>Hak Cuti</td>
            <td colspan='2'>YBS sudah mengambil Cuti Alasan Penting pada tahun berjalan (".$tahun_cuti.")</td>
            <td class='text-center' style='vertical-align: middle;'>$x</td>
            </tr>";
        }
        if ($tahun_cuti>$r_penting->thn) { 
            $ret['kuota_cuti'] = 30.44;
        }
    }

    else if ($id_jenis_cuti == 6) {
        $ret['kuota_cuti'] = $rs->kuota_diluarnegara;
    }

    else{
        $ret['kuota_cuti'] = 0;    
    }

    $ret['feedback'] = $feedback;
    $ret['kuota_cuti'] = number_format($ret['kuota_cuti'], 0, ',', '');
    echo json_encode($ret);
}

public function postCekkuotafinal(){
    $nip           = Input::get('nip');
    $tgl_mulai     = Input::get('tgl_mulai');
    $tgl_usul      = Input::get('tgl_usul');

    /*Review 091019 Add maksimal input pengajuan cuti adalah 10 hari kalender*/
   // $date1  =date_create(date("Y-m-d"));
   // $date2  =date_create($tgl_mulai);
   // $diff   =date_diff($date1,$date2);
   // $jarak =  $diff->format("%R%a");
   //  echo $diff->format("%R%a days");
   //  echo "<br> ".$jarak."<br> ".abs($jarak);
   //   if ($jarak < -10) {
   //       $ret['notif'] = 1;
   //      $feedback = "<b>Perhatian!</b> : Maksimal Tanggal Untuk Pengusulan Cuti Adalah Maksimal berjarak 10 Hari Kalender";
   //      exit();
   //  }
    /*Merged Fungsi Jadi Satu, Cek jika tanggal ada isinya atau tidak*/
    if (Input::get('tgl_mulai') != 0) {
        $tanggalmulai  = date("Y-m-d", strtotime(Input::get('tgl_mulai')));
        $tahun_cuti    = substr($tgl_mulai, 6,10);
    }else{
        $tanggalmulai  = 0;
        $tahun_cuti    = 0;
    }

    $pgw           = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
    $mk_thn        = $pgw->thn_cpns; //masa kerja dalam tahun
    $id_jenis_cuti = Input::get('id_jenis_cuti');
    $ret['notif']  = 0; //untuk menandai return jika ada aturan tidak terpenuhi = 1
    $ret['dis_mulai']  = 0; //untuk menandai return untuk disabled tanggal mulai
    $ret['dis_selesai']  = 0; //untuk menandai return untuk disabled tanggal selesai
    $v = "<span style='color:green;'><i class='fa fa-check-circle' title='Memenuhi Syarat'/></span>";
    $x = "<span style='color:red;'><i class='fa fa-times-circle' title='Tidak Memenuhi Syarat'/></span>";
    $feedback      = "<p class='text-center'><b>.: Perhatian :.</b></p>
    Berdasarkan <a href='".url()."/packages/upload/pdf/Peraturan-BKN-Nomor-24-Tahun-2017-tentang-tata-Cara-Pemberian-Cuti-PNS.pdf' target='_blank'> Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil&nbsp;<i class='glyphicon glyphicon-new-window'></i></a>. Usulan cuti <b>".getJenisCuti($id_jenis_cuti)."</b> tidak dapat dilanjukan karena : <br> 
    <table class='table table-striped table-hover table-condensed table-bordered' width='100%'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center' style='vertical-align: middle;' width='3%'>NO</th>
    <th class='text-center' style='vertical-align: middle;'>KETERANGAN</th>
    <th class='text-center' style='vertical-align: middle;'>SYARAT</th>
    <th class='text-center' style='vertical-align: middle;'>KONDISI</th>
    <th class='text-center' style='vertical-align: middle;' width='3%'>STATUS</th>
    </tr>
    </thead>
    <tbody>"; //Feedback dalam bentuk tabel jika ada aturan yang tidak terpenuhi

    $rs = \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
    if ($id_jenis_cuti == 1) {
        $ret['kuota_cuti'] = ($rs->kuota_tahunan_n2+$rs->kuota_tahunan_n1+$rs->kuota_tahunan_n);
        
        if ($tahun_cuti !=0 && $rs->thn<$tahun_cuti) {
            $kuota_tahunan = ($rs->kuota_tahunan_n1+(($rs->kuota_tahunan_n>6)?6:$rs->kuota_tahunan_n)+12);
            $ret['kuota_cuti'] = $kuota_tahunan;    
        }
        /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
        if ($mk_thn < 1) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1; 
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>1 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'>$x</td>
            </tr>";
        }else{
            $feedback .="<tr><td>1</td><td>Masa Kerja</td><td>1 Tahun</td><td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td><td class='text-center' style='vertical-align: middle;'>$v</td></tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Besar pada tahun berjalan*/
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        if ($tahun_cuti != 0) {   
            $r_besar  = getRiwayatcuti($nip,2,$tahun_cuti);
            if ($tahun_cuti == $r_besar->thn) { 
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_selesai'] = 1;
                $feedback .= "<tr>
                <td>2</td>
                <td>Cuti Besar</td>
                <td>Tidak/Belum mengambil cuti besar pada tahun berjalan - (<b>".$tahun_cuti."</b>)</td>
                <td>Sudah</td>
                <td class='text-center' style='vertical-align: middle;'> $x </td>
                </tr>";
            }
        }
        /*Kondisi jika YBS guru*/
        if ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300') {
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
            $feedback .= "<tr>
            <td>2</td>
            <td>Jabatan Guru</td>
            <td class='text-center' colspan='3'>Tidak berhak atas cuti tahunan</td>
            </tr>"; 
        }

        /*Cetak keterangan jika ada kondisi yg terpenuhi*/
        if ($tahun_cuti == (($tahun_cuti!=0)?$r_besar->thn:"1") || $mk_thn < 1 || ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300')) {
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang menduduki jabatan guru pada sekolah dan jabatan dosen pada perguruan tinggi yang mendapat liburan menurut peraturan perundang-undangan, disamakan dengan PNS yang telah menggunakan hak cuti tahunan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
    }
    else if($id_jenis_cuti == 2){
        $ret['kuota_cuti'] = $rs->kuota_besar;
        if ($mk_thn < 5) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
        }else{
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $v </td>
            </tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Tahunan pada tahun berjalan*/
        $r_besar = getRiwayatcuti($nip,2,"");
        if ($tahun_cuti !=0) {
            $r_tahun = getRiwayatcuti($nip,1,$tahun_cuti);
            /*Kondisi YBS sudah mengambil cuti tahunan pada tahun berjalan*/
            // if ($r_tahun->lama_cuti != 0 && $r_tahun == date("Y") ) {//date("Y") diganti dengan tahun inputan tanggal mulai
            if ($r_tahun->lama_cuti != 0) {
                $ret['notif']       = 1;
                $ret['kuota_cuti'] = ($rs->kuota_besar-$r_tahun->lama_cuti);
                $feedback .="<tr>
                <td>2</td>
                <td>Cuti Tahunan</td>
                <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
                <td>Melakukan Cuti Tahunan selama ".$r_tahun->lama_cuti." Hari</td>
                <td class='text-center' style='vertical-align: middle;'> $v </td>
                </tr>";
            }else{
                $feedback .="<tr>
                <td>2</td>
                <td>Cuti Tahunan</td>
                <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
                <td>Belum</td>
                <td class='text-center' style='vertical-align: middle;'> $v </td>
                </tr>";
            }
        }

        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
        $thn_bisa_besar = ($r_besar->thn+5);//thn_bisa_besar = tahun terakhir mengajukan cuti besar ditambah rentang 5 tahun
        $tgl_bisa_besar = date('Y-m-d',strtotime("+5 year",strtotime($r_besar->tgmul)));
        if ($tanggalmulai!=0 ) {

            if($tanggalmulai >= $tgl_bisa_besar){
                $ret['kuota_cuti']  = (3*30.44);
            // $ret['x']  = $tanggalmulai." - ".$tgl_bisa_besar;
            }else{
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_selesai'] = 1;
                $feedback .= "<tr>
                <td>3</td>
                <td>Rentang Pengajuan</td>
                <td>Per 5 Tahun (".formattanggalpanjang($r_besar->tgmul).")</td>
                <td>".formattanggalpanjang($tgl_bisa_besar)."<br>".getJarakDuaTanggal3(date('Y/m/d'),$tgl_bisa_besar)."</td>
                <td class='text-center' style='vertical-align: middle;'>$x</td>
                </tr>";
            }
        }

        if( ($mk_thn < 5) || ( (($tahun_cuti!=0)?$r_tahun->lama_cuti:"0") != 0) || ( (($tahun_cuti!=0)?$per_5thn:"0") !=5 && $tahun_cuti>(($tahun_cuti!=0)?$per_5thn:"0")) || ($thn_bisa_besar <= $tahun_cuti) ){
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang telah menggunakan hak atas <b>cuti tahunan</b> pada tahun yang bersangkutan maka hak atas <b>cuti besar</b> yang bersangkutan diberikan dengan memperhitungkan hak atas <b>cuti tahunan</b> yang telah digunakan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
    }
    else if ($id_jenis_cuti == 3) {
        $ret['kuota_cuti'] = $rs->kuota_sakit;
    }

    else if ($id_jenis_cuti == 4) {
        $jum_anak = Hitanakkandung($nip,$pgw->tmtcpn); 
        $ret['kuota_cuti'] = $rs->kuota_melahirkan;
        if($jum_anak>=3){
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $feedback .="<tr>
            <td>1</td>
            <td>Jumlah Anak YBS Berhak Cuti</td>
            <td>Maksimal 3 Anak</td>
            <td>".$jum_anak." Anak</td>
            <td class='text-center' style='vertical-align: middle;'>$v</td>
            </tr>";
        }
        if($pgw->idjenkel==1){
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Cuti Melahirkan</td>
            <td class='text-center' colspan='3'>PNS Laki - Laki tidak berhak atas <b>Cuti Melahirkan</b></td>
            </tr>";
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>Bagi PNS Laki - Laki yang yang isterinya melahirkan/operasi caesar silahkan mengajukan cuti karena alasan penting dengan melampirkan surat keterangan rawat inap dari Unit Pelayanan Kesehatan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
    }
    else if ($id_jenis_cuti == 5) {
        $ret['kuota_cuti'] = $rs->kuota_penting;
        $r_penting  = getRiwayatcuti($nip,5,$tahun_cuti);
        /*REVISI BU EFI -> 1 Tahun bisa lebih dari 1x pengajuan*/
        /*Kondisi jika YBS sudah pernah menjalankan cuti Alsan Penting pada tahun berjalan*/
        // if($tahun_cuti !=0 ){
        //     if ($tahun_cuti==$r_penting->thn) { 
        //      $ret['notif']       = 1;
        //      $ret['kuota_cuti']  = 0;
        //      $ret['dis_mulai']   = 1;
        //      $ret['dis_selesai'] = 1;
        //      $feedback .= "<tr>
        //      <td>1</td>
        //      <td>Hak Cuti</td>
        //      <td colspan='2'>YBS sudah mengambil Cuti Alasan Penting pada tahun berjalan (".$tahun_cuti.")</td>
        //      <td class='text-center' style='vertical-align: middle;'>$x</td>
        //      </tr>";
         // }else{
        $ret['dis_mulai']   = 0;
        $ret['dis_selesai'] = 0;
        // }
    // }

        if ($tahun_cuti!=0 && $tahun_cuti>$r_penting->thn) { 
            $ret['kuota_cuti'] = 30.44;
        }
    }

    else if ($id_jenis_cuti == 6) {
        $ret['kuota_cuti'] = $rs->kuota_diluarnegara;
        /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
        if ($mk_thn < 5) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
    }

    else{
        $ret['dis_mulai']   = 0;
        $ret['dis_selesai'] = 0;
        $ret['kuota_cuti']  = 0; 
    }

    $ret['feedback'] = $feedback;
    $ret['kuota_cuti'] = number_format($ret['kuota_cuti'], 0, ',', '');
    echo json_encode($ret);
}

public function postCekkuotaedit(){
    $nip           = Input::get('nip');
    $tgl_mulai     = Input::get('tgl_mulai');

    /*Merged Fungsi Jadi Satu, Cek jika tanggal ada isinya atau tidak*/
    if (Input::get('tgl_mulai') != 0) {
        $tanggalmulai  = date("Y-m-d", strtotime(Input::get('tgl_mulai')));
        $tahun_cuti    = substr($tgl_mulai, 6,10);
    }else{
        $tanggalmulai  = 0;
        $tahun_cuti    = 0;
    }

    $pgw           = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
    $mk_thn        = $pgw->thn_cpns; //masa kerja dalam tahun
    $id_jenis_cuti = Input::get('id_jenis_cuti');
    $ret['notif']  = 0; //untuk menandai return jika ada aturan tidak terpenuhi = 1
    $ret['dis_mulai']  = 0; //untuk menandai return untuk disabled tanggal mulai
    $ret['dis_selesai']  = 0; //untuk menandai return untuk disabled tanggal selesai
    $v = "<span style='color:green;'><i class='fa fa-check-circle' title='Memenuhi Syarat'/></span>";
    $x = "<span style='color:red;'><i class='fa fa-times-circle' title='Tidak Memenuhi Syarat'/></span>";
    $feedback      = "<p class='text-center'><b>.: Perhatian :.</b></p>
    Berdasarkan <a href='".url()."/packages/upload/pdf/Peraturan-BKN-Nomor-24-Tahun-2017-tentang-tata-Cara-Pemberian-Cuti-PNS.pdf' target='_blank'> Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil&nbsp;<i class='glyphicon glyphicon-new-window'></i></a>. Usulan cuti <b>".getJenisCuti($id_jenis_cuti)."</b> tidak dapat dilanjukan karena : <br> 
    <table class='table table-striped table-hover table-condensed table-bordered' width='100%'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center' style='vertical-align: middle;' width='3%'>NO</th>
    <th class='text-center' style='vertical-align: middle;'>KETERANGAN</th>
    <th class='text-center' style='vertical-align: middle;'>SYARAT</th>
    <th class='text-center' style='vertical-align: middle;'>KONDISI</th>
    <th class='text-center' style='vertical-align: middle;' width='3%'>STATUS</th>
    </tr>
    </thead>
    <tbody>"; //Feedback dalam bentuk tabel jika ada aturan yang tidak terpenuhi

    $rs = \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
    if ($id_jenis_cuti == 1) {
        $ret['kuota_cuti'] = ($rs->kuota_tahunan_n2+$rs->kuota_tahunan_n1+$rs->kuota_tahunan_n);
        
        if ($tahun_cuti !=0 && $rs->thn<$tahun_cuti) {
            $kuota_tahunan = ($rs->kuota_tahunan_n1+(($rs->kuota_tahunan_n>6)?6:$rs->kuota_tahunan_n)+12);
            $ret['kuota_cuti'] = $kuota_tahunan;    
        }
        /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
        if ($mk_thn < 1) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1; 
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>1 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'>$x</td>
            </tr>";
        }else{
            $feedback .="<tr><td>1</td><td>Masa Kerja</td><td>1 Tahun</td><td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td><td class='text-center' style='vertical-align: middle;'>$v</td></tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Besar pada tahun berjalan*/
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        if ($tahun_cuti != 0) {   
            $r_besar  = getRiwayatcuti($nip,2,$tahun_cuti);
            if ($tahun_cuti == $r_besar->thn) { 
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_selesai'] = 1;
                $feedback .= "<tr>
                <td>2</td>
                <td>Cuti Besar</td>
                <td>Tidak/Belum mengambil cuti besar pada tahun berjalan - (<b>".$tahun_cuti."</b>)</td>
                <td>Sudah</td>
                <td class='text-center' style='vertical-align: middle;'> $x </td>
                </tr>";
            }
        }
        /*Kondisi jika YBS guru*/
        if ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300') {
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti']  = 0;
            $feedback .= "<tr>
            <td>2</td>
            <td>Jabatan Guru</td>
            <td class='text-center' colspan='3'>Tidak berhak atas cuti tahunan</td>
            </tr>"; 
        }

        /*Cetak keterangan jika ada kondisi yg terpenuhi*/
        if ($tahun_cuti == (($tahun_cuti!=0)?$r_besar->thn:"1") || $mk_thn < 1 || ($pgw->idjenjab = 2 && substr($pgw->idjabfung, 0,3) == '300')) {
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang menduduki jabatan guru pada sekolah dan jabatan dosen pada perguruan tinggi yang mendapat liburan menurut peraturan perundang-undangan, disamakan dengan PNS yang telah menggunakan hak cuti tahunan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
    }
    else if($id_jenis_cuti == 2){
        $ret['kuota_cuti'] = $rs->kuota_besar;
        if ($mk_thn < 5) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
        }else{
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $v </td>
            </tr>";
        }
        /*Kondisi jika YBS sudah pernah menjalankan cuti Tahunan pada tahun berjalan*/
        $r_besar = getRiwayatcuti($nip,2,"");
        if ($tahun_cuti !=0) {
            $r_tahun = getRiwayatcuti($nip,1,$tahun_cuti);
            /*Kondisi YBS sudah mengambil cuti tahunan pada tahun berjalan*/
            // if ($r_tahun->lama_cuti != 0 && $r_tahun == date("Y") ) {//date("Y") diganti dengan tahun inputan tanggal mulai
            if ($r_tahun->lama_cuti != 0) {
                $ret['notif']       = 1;
                $ret['kuota_cuti'] = ($rs->kuota_besar-$r_tahun->lama_cuti);
                $feedback .="<tr>
                <td>2</td>
                <td>Cuti Tahunan</td>
                <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
                <td>Melakukan Cuti Tahunan selama ".$r_tahun->lama_cuti." Hari</td>
                <td class='text-center' style='vertical-align: middle;'> $v </td>
                </tr>";
            }else{
                $feedback .="<tr>
                <td>2</td>
                <td>Cuti Tahunan</td>
                <td>Belum/Sudah mengambil cuti tahunan pada tahun berjalan</td>
                <td>Belum</td>
                <td class='text-center' style='vertical-align: middle;'> $v </td>
                </tr>";
            }
        }

        /*HARUSNYA Letak Kondisi saat memilih tanggal mulai*/
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
        $thn_bisa_besar = ($r_besar->thn+5);//thn_bisa_besar = tahun terakhir mengajukan cuti besar ditambah rentang 5 tahun
        $tgl_bisa_besar = date('Y-m-d',strtotime("+5 year",strtotime($r_besar->tgmul)));
        if ($tanggalmulai!=0 ) {

            if($tanggalmulai >= $tgl_bisa_besar){
                $ret['kuota_cuti']  = (3*30.44);
            // $ret['x']  = $tanggalmulai." - ".$tgl_bisa_besar;
            }else{
                $ret['notif']       = 1;
                $ret['kuota_cuti']  = 0;
                $ret['dis_selesai'] = 1;
                $feedback .= "<tr>
                <td>3</td>
                <td>Rentang Pengajuan</td>
                <td>Per 5 Tahun (".formattanggalpanjang($r_besar->tgmul).")</td>
                <td>".formattanggalpanjang($tgl_bisa_besar)."<br>".getJarakDuaTanggal3(date('Y/m/d'),$tgl_bisa_besar)."</td>
                <td class='text-center' style='vertical-align: middle;'>$x</td>
                </tr>";
            }
        }

        if( ($mk_thn < 5) || ( (($tahun_cuti!=0)?$r_tahun->lama_cuti:"0") != 0) || ( (($tahun_cuti!=0)?$per_5thn:"0") !=5 && $tahun_cuti>(($tahun_cuti!=0)?$per_5thn:"0")) || ($thn_bisa_besar <= $tahun_cuti) ){
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>PNS yang telah menggunakan hak atas <b>cuti tahunan</b> pada tahun yang bersangkutan maka hak atas <b>cuti besar</b> yang bersangkutan diberikan dengan memperhitungkan hak atas <b>cuti tahunan</b> yang telah digunakan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
        /*Reset Kuota Jika sudah Lebih dari 5 Tahun dari pengajuan terakhir*/
    }
    else if ($id_jenis_cuti == 3) {
        $ret['kuota_cuti'] = $rs->kuota_sakit;
    }

    else if ($id_jenis_cuti == 4) {
        $jum_anak = Hitanakkandung($nip,$pgw->tmtcpn); 
        $ret['kuota_cuti'] = $rs->kuota_melahirkan;
        if($jum_anak>=3){
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $feedback .="<tr>
            <td>1</td>
            <td>Jumlah Anak YBS Berhak Cuti</td>
            <td>Maksimal 3 Anak</td>
            <td>".$jum_anak." Anak</td>
            <td class='text-center' style='vertical-align: middle;'>$v</td>
            </tr>";
        }
        if($pgw->idjenkel==1){
            $ret['notif']       = 1;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $ret['kuota_cuti'] = 0;
            $feedback .="<tr>
            <td>1</td>
            <td>Cuti Melahirkan</td>
            <td class='text-center' colspan='3'>PNS Laki - Laki tidak berhak atas <b>Cuti Melahirkan</b></td>
            </tr>";
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>Bagi PNS Laki - Laki yang yang isterinya melahirkan/operasi caesar silahkan mengajukan cuti karena alasan penting dengan melampirkan surat keterangan rawat inap dari Unit Pelayanan Kesehatan.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
    }
    else if ($id_jenis_cuti == 5) {
        $ret['kuota_cuti'] = $rs->kuota_penting;
        /*Kondisi jika YBS sudah pernah menjalankan cuti Alsan Penting pada tahun berjalan*/
        if($tahun_cuti !=0 ){
            $r_penting  = getRiwayatcuti($nip,5,$tahun_cuti);
            if ($tahun_cuti==$r_penting->thn) { 
                $ret['notif']  = 1;
                $ret['kuota_cuti'] = 0;
                $feedback .= "<tr>
                <td>1</td>
                <td>Hak Cuti</td>
                <td colspan='2'>YBS sudah mengambil Cuti Alasan Penting pada tahun berjalan (".$tahun_cuti.")</td>
                <td class='text-center' style='vertical-align: middle;'>$x</td>
                </tr>";
            }
        }

        if ($tahun_cuti!=0 && $tahun_cuti>$r_penting->thn) { 
            $ret['kuota_cuti'] = 30.44;
        }
    }

    else if ($id_jenis_cuti == 6) {
        $ret['kuota_cuti'] = $rs->kuota_diluarnegara;
        /*Kondisi Masa Kerja Berdsarkan TMT CPNS*/
        if ($mk_thn < 5) {
            /*Send Feedback untuk masa kerja yang tidak terpenuhi*/
            $ret['notif']       = 1;
            $ret['kuota_cuti']  = 0;
            $ret['dis_mulai']   = 1;
            $ret['dis_selesai'] = 1;
            $feedback .="<tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>".getJarakDuaTanggal3($pgw->tmtcpn,date('Y/m/d'))."</td>
            <td class='text-center' style='vertical-align: middle;'> $x </td>
            </tr>";
            $feedback .="</tbody>
            </table>
            <b>Keterangan : </b> <br>
            <table class='table table-striped table-hover table-condensed table-bordered'>
            <tr>
            <td width='3%'></td>
            <td>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
            </td>
            </tr>
            </table>";
        }
    }

    else{
        $ret['dis_mulai']   = 1;
        $ret['dis_selesai'] = 1;
        $ret['kuota_cuti']  = 0; 
    }

    $ret['feedback'] = $feedback;
    $ret['kuota_cuti'] = number_format($ret['kuota_cuti'], 0, ',', '');
    echo json_encode($ret);
}

}

