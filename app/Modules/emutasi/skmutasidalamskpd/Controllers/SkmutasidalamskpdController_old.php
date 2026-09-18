<?php namespace App\Modules\emutasi\skmutasidalamskpd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\skmutasidalamskpd\Models\SkmutasidalamskpdModel;
use Input,View, Request, Form, File;

/**
* Skmutasidalamskpd Controller
* @var Skmutasidalamskpd
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkmutasidalamskpdController extends Controller {
    protected $skmutasidalamskpd;

    public function __construct(SkmutasidalamskpdModel $skmutasidalamskpd){
        $this->skmutasidalamskpd = $skmutasidalamskpd;
    }

    public function getIndex(){
        cekAjax();
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::get('statususul') != '') or (Input::get('statussk') != '')) {
            $where = "tr_mutasi_dalam_skpd.idusul != ''";
            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_mutasi_dalam_skpd.idskpd like '$idskpd%'";
            }
            if(Input::get('statussk') != ''){
                $statussk = Input::get('statussk');
                $where .= " and tr_mutasi_dalam_skpd.statussk = '$statussk'";
            }
            if(Input::get('statususul') != ''){
                $statususul = Input::get('statususul');
                $where .= " and tr_mutasi_dalam_skpd.statususul = '$statususul'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_mutasi_dalam_skpd.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
            }
            if(session('role_id') > 3){
                $where .= " and tr_mutasi_dalam_skpd.idskpd like \"".session('idskpd')."%\" ";
            }
            
            $skmutasidalamskpds = $this->skmutasidalamskpd
            ->select('tr_mutasi_dalam_skpd.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_skpd.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_skpd.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_skpd.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_skpd.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

            ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_skpd.idskpd', '=', 'skpdlama.idskpd')
            ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_skpd.idskpdbaru', '=', 'skpdbaru.idskpd')
            ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tr_mutasi_dalam_skpd.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('tb_01', 'tr_mutasi_dalam_skpd.nip', '=', 'tb_01.nip')
            ->leftjoin('a_jabfung', 'tr_mutasi_dalam_skpd.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_skpd.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_skpd.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
            ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_skpd.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
            ->whereRaw($where)
            ->orderby('tr_mutasi_dalam_skpd.nousul','desc')
            ->orderBy(\DB::raw('tr_mutasi_dalam_skpd.nousul desc,tr_mutasi_dalam_skpd.nip'))
            ->paginate($_ENV['configurations']['list-limit']);
            
        }else{
            $skmutasidalamskpds = $this->skmutasidalamskpd->all();
        }
        return View::make('skmutasidalamskpd::index', compact('skmutasidalamskpds'));
    }
    /*SAVE NO KOLEKTIF BLM*/
    function postNokolektif(){
     $nousul = Input::get('nousul');
     $rs = \DB::table('tr_mutasi_dalam_skpd')->where('nousul', $nousul)->first();
     echo json_encode($rs);
     
 }
 /*function nomor sk kolektif*/
 function postNokolektifmutasidalamskpd(){
    $data = array();
    // if(Input::get('verifiksai') == 2){
    //     $dt['statussk'] = 2;
    // }

    $arrnot = array('','_token');
    $keydate = array('','tmt','tglsurat');

    $dt['nousul'] = Input::get('nousul');
    // $data['statususul'] = Input::get('statususul');

    // $data['statussk'] = 1;
    foreach($_POST as $key=>$value){
        if(array_search($key,$keydate)!=''){
            $val = explode("-",$value);
            $value = $val[2]."-".$val[1]."-".$val[0];
        }
        if(array_search($key,$arrnot)==""){
            $data[$key] = $value;
        }
    }

    echo (\DB::table('tr_mutasi_dalam_skpd')->where($dt)->update($data))?4:"Gagal Disimpan";
    

            // $rs = $this->db->get_where('mutasi_dalam_skpd', array('nousul'=> Input::get('nousul'), 'statussk'=>1));
            // foreach ($rs->result() as $item) {
            //     $this->emutasi_list->actiscetakantar(Input::get('iscetaksk'), $item->idusul, $item->nip);
            // }
}
/*========= end of mutasi dalam skpd ============*/
/*function view data atribut dari link */
function postCetak(){
    $view = Request::segment(4);
    return View::make('skmutasidalamskpd::'.$view.'_print');
}
function getCetak(){
    $view = Request::segment(4);
    return View::make('skmutasidalamskpd::'.$view.'_print');
}

/*function view data atribut dari link */
function postData(){
    cekAjax();
    $view = Request::segment(4);
    return View::make('skmutasidalamskpd::'.$view.'_data');
}

}
