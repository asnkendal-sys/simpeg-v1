<?php namespace App\Modules\emutasi\skpengangkatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\skpengangkatan\Models\SkpengangkatanModel;
use Input,View, Request, Form, File;

/**
* Skpengangkatan Controller
* @var Skpengangkatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkpengangkatanController extends Controller {
    protected $skpengangkatan;

    public function __construct(SkpengangkatanModel $skpengangkatan){
        $this->skpengangkatan = $skpengangkatan;
    }

        public function getIndex(){
        cekAjax();
        $where = "tr_mutasi_pengangkatan.idusul != ''";
        if(session('role_id') > 3){
            $where .= " and tr_mutasi_pengangkatan.idskpd like \"".session('idskpd')."%\" ";
        }
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::get('statususul') != '') or (Input::get('statussk') != '')) {
            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_mutasi_pengangkatan.idskpd like '$idskpd%'";
            }
            if(Input::get('statussk') != ''){
                $statussk = Input::get('statussk');
                $where .= " and tr_mutasi_pengangkatan.statussk = '$statussk'";
            }
            if(Input::get('statususul') != ''){
                $statususul = Input::get('statususul');
                $where .= " and tr_mutasi_pengangkatan.statususul = '$statususul'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_mutasi_pengangkatan.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
            }
            
            $skpengangkatans = $this->skpengangkatan
            ->select('tr_mutasi_pengangkatan.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                \DB::raw('IF(tr_mutasi_pengangkatan.idjenjab>4,skpdlama.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                \DB::raw('IF(tr_mutasi_pengangkatan.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_pengangkatan.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_pengangkatan.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

            ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_pengangkatan.idskpd', '=', 'skpdlama.idskpd')
            ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_pengangkatan.idskpdbaru', '=', 'skpdbaru.idskpd')
            ->leftjoin('a_tkpendid', 'tr_mutasi_pengangkatan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tr_mutasi_pengangkatan.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tr_mutasi_pengangkatan.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('tb_01', 'tr_mutasi_pengangkatan.nip', '=', 'tb_01.nip')
            ->leftjoin('a_jabfung', 'tr_mutasi_pengangkatan.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tr_mutasi_pengangkatan.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_pengangkatan.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
            ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_pengangkatan.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
            ->whereRaw($where)
            ->orderby('tr_mutasi_pengangkatan.nousul','desc')
            ->orderBy(\DB::raw('tr_mutasi_pengangkatan.nousul desc,tr_mutasi_pengangkatan.nip'))
            ->paginate($_ENV['configurations']['list-limit']);
            
        }else{
            $skpengangkatans = $this->skpengangkatan->all();
        }
        return View::make('skpengangkatan::index', compact('skpengangkatans'));
    }


      /*SAVE NO KOLEKTIF BLM*/
    function postNokolektif(){
     $nousul = Input::get('nousul');
     $rs = \DB::table('tr_mutasi_pengangkatan')->where('nousul', $nousul)->where('statususul',1)->where('statussk',1)->first();
     if(count($rs)<=0){
        $rs = \DB::table('tr_mutasi_pengangkatan')->where('nousul', $nousul)->first();
     }
     	echo json_encode($rs);
     }

	 /*function nomor sk kolektif*/
	 function postNokolektifpengangkatan(){
	    $data = array();
	    // if(Input::get('verifikasi') == 2){
	    //     $dt['statussk'] = 2;
	    // }

	    $arrnot = array('','_token');
        $keydate = array('','tmt','tglsurat','tmt','periode_tgl1','periode_tgl2');
        $periode_tgl1 = Input::get('periode_tgl1');
        $periode_tgl2 = Input::get('periode_tgl2');
  // candra
        $nousul = Input::get('nousul');
        // candra end
	    // $dt['nousul'] = Input::get('nousul');

        $where = "tr_mutasi_pengangkatan.statususul = 1 and tr_mutasi_pengangkatan.statussk = 1" ;
 // candra edit 31012025
        // if (($periode_tgl1 != '0000-00-00') and ($periode_tgl2 != '0000-00-00')) {
        //     $periode_tgl1 = date('Y-m-d', strtotime($periode_tgl1));
        //     $periode_tgl2 = date('Y-m-d', strtotime($periode_tgl2));

        //     $where .= " and tglusul between \"" . $periode_tgl1 . "\" and \"" . $periode_tgl2 . "\"";
        // } else {
        //     echo "Periode harus diisi.";
        //     exit();
        // }
        // candra end

        // candra
        $periode_tgl1 = date('Y-m-d', strtotime($periode_tgl1));
        $periode_tgl2 = date('Y-m-d', strtotime($periode_tgl2));

        if (($periode_tgl1 != '0000-00-00') && ($periode_tgl2 != '0000-00-00') and ($periode_tgl1 != '1970-01-01') && ($periode_tgl2 != '1970-01-01')) {
            $where .= " and tglusul between \"" . $periode_tgl1 . "\" and \"" . $periode_tgl2 . "\"";
        } elseif (!empty($nousul)) {
            $where .= " and nousul = \"" . $nousul . "\"";
        } else {
            echo "Periode harus diisi.";
            exit();
        }


        // candra end
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

	    echo (\DB::table('tr_mutasi_pengangkatan')->whereRaw($where)->update($data))?4:"Gagal Disimpan";
	    

	            // $rs = $this->db->get_where('mutasi_dalam_skpd', array('nousul'=> Input::get('nousul'), 'statussk'=>1));
	            // foreach ($rs->result() as $item) {
	            //     $this->emutasi_list->actiscetakantar(Input::get('iscetaksk'), $item->idusul, $item->nip);
	            // }
	}
	/*========= end of mutasi dalam skpd ============*/
	/*function view data atribut dari link */
	function postCetak(){
	    $view = Request::segment(4);
	    return View::make('skpengangkatan::'.$view.'_print');
	}
	function getCetak(){
	    $view = Request::segment(4);
	    return View::make('skpengangkatan::'.$view.'_print');
	}

	/*function view data atribut dari link */
	function postData(){
	    cekAjax();
	    $view = Request::segment(4);
	    return View::make('skpengangkatan::'.$view.'_data');
	}

	/*function view data atribut dari link */
	function postExcel(){
	    $view = Request::segment(4);    
	    return View::make('skpengangkatan::'.$view.'_excel');	}


}
