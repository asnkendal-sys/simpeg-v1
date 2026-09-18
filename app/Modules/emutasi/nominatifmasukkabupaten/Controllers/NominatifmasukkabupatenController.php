<?php namespace App\Modules\emutasi\nominatifmasukkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\nominatifmasukkabupaten\Models\NominatifmasukkabupatenModel;
use Input,View, Request, Form, File;

/**
* Nominatifmasukkabupaten Controller
* @var Nominatifmasukkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifmasukkabupatenController extends Controller {
    protected $nominatifmasukkabupaten;

    public function __construct(NominatifmasukkabupatenModel $nominatifmasukkabupaten){
        $this->nominatifmasukkabupaten = $nominatifmasukkabupaten;
    }

    public function getIndex(){
        cekAjax();
        $where = " tr_mutasi_masuk_daerah.nip != ''";


        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {
            (Input::get('idskpd')!='')?$where.=" and tr_mutasi_masuk_daerah.idskpdbaru LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search')!='')?$where.=" and (tr_mutasi_masuk_daerah.nama LIKE '%".Input::get('search')."%' or tr_mutasi_masuk_daerah.nip LIKE '%".Input::get('search')."%')":"";


            $nominatifmasukkabupatens = $this->nominatifmasukkabupaten
            ->select('tr_mutasi_masuk_daerah.*','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
            )
            ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
            ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
            ->whereRaw($where)
            ->orderBy('tr_mutasi_masuk_daerah.nousul','desc')
            ->paginate($_ENV['configurations']['list-limit']);


        }else{
            $nominatifmasukkabupatens = $this->nominatifmasukkabupaten->all();
        }

        return View::make('nominatifmasukkabupaten::index', compact('nominatifmasukkabupatens'));
    }

    public function getCreate(){
        cekAjax();
        return View::make('nominatifmasukkabupaten::create');
    }

    public function postCreate(){
        cekAjax();

        $arrnot     = array("","nip","nousulx","tglusul","n","_token");
        $arrindex   = array("","idusul","nip");
        $keyin      = array("","idusul","nousul");
        $keyout     = array("","idusul","nousul");
        $keydate    = array("","tglskpermintaan","tglhr");

        $dt['nousul']   = Input::get('nousul');
        $dti['tglusul'] = date("Y-m-d", strtotime(Input::get('tglusul')));
        $dt['tglusul']  = date("Y-m-d", strtotime(Input::get('tglusul')));

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
                    $rs = \DB::table('tr_mutasi_masuk_daerah')->select(\DB::raw("CONCAT(DATE_FORMAT('".$dti['tglusul']."','%y%m%d'),
                        LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))->where('tglusul', $dti['tglusul'])->first();

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
                    $rssimpan = \DB::table('tr_mutasi_masuk_daerah')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $nominatifmasukkabupaten = $this->nominatifmasukkabupaten->find($id);
        //if (is_null($nominatifmasukkabupaten)){return \Redirect::to('emutasi/nominatifmasukkabupaten/index');}
        return View::make('nominatifmasukkabupaten::edit', compact('nominatifmasukkabupaten'));
    }

    public function postEdit(){
       cekAjax();
       $keynot = array("","idusul","nousul","idjenjurusanx","idjabjbtbarux","_token");
       $data = array();
       $keydate = array("","tglhr","tglusul","tglskpermintaan");

       foreach($_POST as $key=>$value){
           if(array_search($key,$keynot)==""){
               if(array_search($key,$keydate)){
                   $data[$key] = date("Y-m-d", strtotime($value));
               }else{
                   $data[$key] = $value;
               }

           }
       }

       $dt['idusul'] = Input::get('idusul');

       if(\DB::table("tr_mutasi_masuk_daerah")->where($dt)->update($data)){
        echo 1;
    }else{
        echo "Update data mutasi gagal disimpan";
    }
}

public function postDelete(){
    cekAjax();
    $ids = Input::get('id');
    if (is_array($ids)){
        foreach($ids as $id){
            $this->nominatifmasukkabupaten->find($id)->delete();
        }
        echo 'Data berhasil dihapus';
    }
    else{
        echo ($this->nominatifmasukkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
    }
}

/*function view data atribut dari link */
function postData(){
    cekAjax();
    $view = Request::segment(4);
    return View::make('nominatifmasukkabupaten::'.$view.'_data');
}

/*function view data atribut dari link */
function postCetakall(){
    $nousul 	= Input::get('nousul');
    $dt['no_sp'] 	    = Input::get('no_sp');
    $dt['tgl_sp'] 	    = date('Y-m-d', strtotime(Input::get('tgl_sp')));
    $dt['berkas_sp'] 	= Input::get('berkas_sp');

    $update = \DB::table('tr_mutasi_masuk_daerah')->where('nousul','=',$nousul)->update($dt);

    $view = Request::segment(4);
    return View::make('nominatifmasukkabupaten::'.$view.'_print');

}

/*function view data atribut dari link */
function getCetak(){
    $view = Request::segment(4);
    return View::make('nominatifmasukkabupaten::'.$view.'_print');

}

/*function cek / validasi nip*/
function postCeknip(){
    cekAjax();
    $nip 	= Input::get('nip');
    $rs = \DB::table('tb_01')->select('nip')->where('nip', $nip)->first();

    if(strlen($nip) != 18){
        $arr['err']  = 0;
        $arr['text'] = '<i class="fa fa-exclamation-circle" style="color: #9acd32;"> Nomor Induk Pegawai harus 18 digit.</i>';
    }else{
        if(count($rs) > 0){
            $arr['err']  = 0;
            $arr['text'] = '<i class="fa fa-times-circle" style="color: #ff0000;"> Nomor Induk Pegawai sudah digunakan.</i>';
        }else{
            $arr['err']  = 1;
            $arr['text'] = '<i class="fa fa-check-circle" style="color: #008000"> Nomor Induk Pegawai tersedia.</i>';
        }
    }

    echo json_encode($arr);
}

/*function list jabatan struktural selact 2*/
function postListjabstruk2(){
    cekAjax();
    $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
    /*$id         = substr(Input::get('id'),0,2);*/
    $per_page   = intval(Input::get('per_page'));
    $start      = (intval(Input::get('page'))-1)*$per_page;
    $page       = intval(Input::get('page'));

    $where = "a.jab like '%".$keyword."%' or a.idskpd like '%".$keyword."%'";

    $rs = \DB::table('a_skpd as a')
    ->select('a.idskpd as id','a.jab as text')
    ->where('flag', 1)
    ->whereRaw($where)
    ->orderBy('a.idskpd','asc');

    $arr['result']      = count($rs->get());
    $arr['per_page']    = $per_page;
    $arr['page']        = (($page>0)?$page:1);
    $arr['rows']        = $rs->skip($start)->take($per_page)->get();
    echo json_encode($arr);
}
/*function list jabatan fungsional select 2*/
function postListjabfung2(){
    cekAjax();
    $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
    $id         = substr(Input::get('id'),0,2);
    $per_page   = intval(Input::get('per_page'));
    $start      = (intval(Input::get('page'))-1)*$per_page;
    $page       = intval(Input::get('page'));

    $where      = "a.jabfung like '%".$keyword."%' or a.idjabfung like '%".$keyword."%'";

    $rs = \DB::table('a_jabfung as a')
    ->select('a.idjabfung as id','a.jabfung as text')
    ->where('flag', 1)
    ->whereRaw($where)
    ->orderBy('a.jabfung','asc')
    ->orderBy('a.idjabfung','asc');

    $arr['result']      = count($rs->get());
    $arr['per_page']    = $per_page;
    $arr['page']        = (($page>0)?$page:1);
    $arr['rows']        = $rs->skip($start)->take($per_page)->get();
    echo json_encode($arr);
}

/*function list jabatan fungsional umum select 2*/
function postListjabfungum2(){
    cekAjax();
    $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
    $id         = substr(Input::get('id'),0,2);
    $per_page   = intval(Input::get('per_page'));
    $start      = (intval(Input::get('page'))-1)*$per_page;
    $page       = intval(Input::get('page'));

    $where      = "a.jabfungum like '%".$keyword."%' or a.idjabfungum like '%".$keyword."%'";

    $rs = \DB::table('a_jabfungum as a')
    ->select('a.idjabfungum as id','a.jabfungum as text')
    ->where('flag', 1)
    ->whereRaw($where)
    ->orderBy('a.jabfungum','asc')
    ->orderBy('a.idjabfungum','asc');

    $arr['result']      = count($rs->get());
    $arr['per_page']    = $per_page;
    $arr['page']        = (($page>0)?$page:1);
    $arr['rows']        = $rs->skip($start)->take($per_page)->get();
    echo json_encode($arr);
}

/*function list jabatan fungsional umum select 2*/
function postJenjurusan(){
    cekAjax();
    $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
    /*$id         = substr(Input::get('id'),0,2);*/
    $idtkpendid = Input::get('idtkpendid');
    $per_page   = intval(Input::get('per_page'));
    $start      = (intval(Input::get('page'))-1)*$per_page;
    $page       = intval(Input::get('page'));

    $where      = "a.idtkpendid = '".$idtkpendid."' and (a.jenjurusan like '%".$keyword."%' or a.idjenjurusan like '%".$keyword."%')";

    $rs = \DB::table('a_jenjurusan as a')
    ->select('a.idjenjurusan as id','a.jenjurusan as text')
    ->whereRaw($where)
    ->orderBy('a.jenjurusan','asc')
    ->orderBy('a.idjenjurusan','asc');

    $arr['result']      = count($rs->get());
    $arr['per_page']    = $per_page;
    $arr['page']        = (($page>0)?$page:1);
    $arr['rows']        = $rs->skip($start)->take($per_page)->get();
    echo json_encode($arr);
}

public function postDeletenominatif(){
    cekAjax();
    $nousuls = Input::get('nousul');
    if (is_array($nousuls)){
        foreach($nousuls as $nousul){
            $this->nominatifmasukkabupaten->find($nousul)->delete();
        }
        echo 'Data berhasil dihapus';
    }
    else{
        echo ($this->nominatifmasukkabupaten->where('nousul',$nousuls)->delete())?9:'Gagal Dihapus';
    }
}

/*function preview nominatif*/
function postDatanominatifmutasi(){
    $id = Input::get('idusul');

    $rs = \DB::table('tr_mutasi_masuk_daerah')
    ->select('tr_mutasi_masuk_daerah.*','a_agama.agama','a_jenkel.jenkel','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.jab','a_jabfung.jabfung','a_jabfungum.jabfungum',
        \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
    )
    ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
    ->leftjoin('a_agama', 'tr_mutasi_masuk_daerah.idagama', '=', 'a_agama.idagama')
    ->leftjoin('a_jenkel', 'tr_mutasi_masuk_daerah.idjenkel', '=', 'a_jenkel.idjenkel')
    ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
    ->where('tr_mutasi_masuk_daerah.idusul', $id)
    ->first();

    if($rs->tembusan == "")
    {
        $rs->tembusan = '
        <ol style="float: left; margin-top: 1px; margin-left: -1.2em;">
        <li>Isikan disini lalu tekan enter untuk tembusan selanjutnya</li>
        </ol>';
    }

    echo json_encode($rs);
}

public function postVerifikasi(){
    cekAjax();

    $keynot = array("","idusul","nousul","idjenjurusanx","idjabjbtbarux","_token","tmt_berlaku");
    $data = array();
    $keydate = array("","tglhr","tglusul","tglskpermintaan","tglsurat","tmt","tglsk_persetujuan","tglsk_pengantar","tgl_kajian","tglsk_kanreg");

    foreach($_POST as $key=>$value){
     if(array_search($key,$keynot)==""){
         if(array_search($key,$keydate)){
             $data[$key] = date("Y-m-d", strtotime($value));
         }else{
             $data[$key] = $value;
         }

     }
 }

 $dt['idusul'] = Input::get('idusul');
 $dt['nousul'] = Input::get('nousul');

 $data['ispengantar'] = Input::get('ispengantar');
 $data['ispermohonan'] = Input::get('ispermohonan');
 $data['isskcpns'] = Input::get('isskcpns');
 $data['isskpns'] = Input::get('isskpns');
 $data['isskpkt'] = Input::get('isskpkt');
 $data['iskarpeg'] = Input::get('iskarpeg');
 $data['isdhr'] = Input::get('isdhr');
 $data['isspskpd'] = Input::get('isspskpd');
 $data['isijazah'] = Input::get('isijazah');
 $data['issnikah'] = Input::get('issnikah');
 $data['ispernyataan'] = Input::get('ispernyataan');
 /*Start Of Reza*/
 $data['idpemerintah'] = Input::get('idpemerintah');

 $data['tembusan'] = Input::get('tembusan');

 $data['statususul'] = Input::get('statususul');
 if($data['statususul'] == 2){
    $data['kettms'] = Input::get('kettms');
    $data['ketbtl'] = '';
}else if($data['statususul'] == 3){
    $data['kettms'] = '';
    $data['ketbtl'] = Input::get('ketbtl');
}else{
    $data['kettms'] = '';
    $data['ketbtl'] = '';
}

$data['statussk'] = Input::get('statussk');
if($data['statussk'] == 1 || $data['iscetaksk'] == 1){
    $data['nosk'] = Input::get('nosk');
    $data['nosk2'] = Input::get('nosk2');
    $data['tglsurat'] = date("Y-m-d", strtotime(Input::get('tglsurat')));
    $data['tmt'] = date("Y-m-d", strtotime(Input::get('tmt')));
    $data['iscetaksk'] = Input::get('iscetaksk');

    $data['kepalabkd'] = Input::get('kepalabkd');
    $data['nipkepalabkd'] = Input::get('nipkepalabkd');
    $data['pangkatbkd'] = Input::get('pangkatbkd');
    $data['jabkepalabkd'] = Input::get('jabkepalabkd');

    $data['bupati'] = Input::get('bupati');
    $data['jabbupati'] = Input::get('jabbupati');

    $data['kepalasekda'] = Input::get('kepalasekda');
    $data['nipsekda'] = Input::get('nipsekda');
    $data['pangkatsekda'] = Input::get('pangkatsekda');
    $data['jabkepalasekda'] = Input::get('jabkepalasekda');    
    $data['idstspeg'] = '2';
    $data['usiapens'] = '1';

}else if($data['statussk'] == 2){
    $data['nosk_persetujuan'] = Input::get('nosk_persetujuan');
    $data['nosk_persetujuan2'] = Input::get('nosk_persetujuan2');
    $data['tglsk_persetujuan'] = (Input::get('tglsk_persetujuan')!='')?date("Y-m-d", strtotime(Input::get('tglsk_persetujuan'))):'';
    $data['nosk_pengantar'] = Input::get('nosk_pengantar');
    $data['tglsk_pengantar'] = (Input::get('tglsk_pengantar')!='')?date("Y-m-d", strtotime(Input::get('tglsk_pengantar'))):'';
    $data['penetapsk_kanreg'] = Input::get('penetapsk_kanreg');
    $data['nosk_kanreg'] = Input::get('nosk_kanreg');
    $data['tglsk_kanreg'] = (Input::get('tglsk_kanreg')!='')?date("Y-m-d", strtotime(Input::get('tglsk_kanreg'))):'';
    $data['tgl_kajian'] = (Input::get('tgl_kajian')!='')?date("Y-m-d", strtotime(Input::get('tgl_kajian'))):'';
    $data['idstspeg'] = '2';
    $data['usiapens'] = '1';
            // $data['iscetaksk'] = '';
}else{
            // $data['nosk'] = '';
            // $data['nosk2'] = '';
            // $data['tglsurat'] = '';
            // $data['tmt'] = '';
    $data['iscetaksk'] = '';
            // $data['kepalabkd'] = '';
            // $data['nipkepalabkd'] = '';
            // $data['pangkatbkd'] = '';
            // $data['bupati'] ='';
}

echo (\DB::table("tr_mutasi_masuk_daerah")->where($dt)->update($data))?1:"Gagal Disimpan";
}
}
