<?php namespace App\Modules\emutasi\skmutasiantarskpd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\skmutasiantarskpd\Models\SkmutasiantarskpdModel;
use Input,View, Request, Form, File;

/**
* Skmutasiantarskpd Controller
* @var Skmutasiantarskpd
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkmutasiantarskpdController extends Controller {
    protected $skmutasiantarskpd;

    public function __construct(SkmutasiantarskpdModel $skmutasiantarskpd){
        $this->skmutasiantarskpd = $skmutasiantarskpd;
    }

    public function getIndex(){
        cekAjax();
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::get('statususul') != '') or (Input::get('statussk') != '')) {
            $where = "tr_mutasi_dalam_daerah.idusul != ''";
            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_mutasi_dalam_daerah.idskpd like '$idskpd%'";
            }
            if(Input::get('statussk') != ''){
                $statussk = Input::get('statussk');
                $where .= " and tr_mutasi_dalam_daerah.statussk = '$statussk'";
            }
            if(Input::get('statususul') != ''){
                $statususul = Input::get('statususul');
                $where .= " and tr_mutasi_dalam_daerah.statususul = '$statususul'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_mutasi_dalam_daerah.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
            }
            if(\session::get('role_id')<=3){
                $skmutasiantarskpds = $this->skmutasiantarskpd
                ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                    ,'skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

                ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
                ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
                ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
                ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
                ->paginate($_ENV['configurations']['list-limit']);
            }
            else
            {
                $skmutasiantarskpds = $this->skmutasiantarskpd
                ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                    ,'skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

                ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
                ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
                ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
                ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                ->whereRaw($where)
                ->where('tr_mutasi_dalam_daerah.no_suratrek','!=','')
                ->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
                ->paginate($_ENV['configurations']['list-limit']);
            }
        }else{
            $skmutasiantarskpds = $this->skmutasiantarskpd->all();
        }
        return View::make('skmutasiantarskpd::index', compact('skmutasiantarskpds'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('skmutasiantarskpd::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SkmutasiantarskpdModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->skmutasiantarskpd->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $skmutasiantarskpd = $this->skmutasiantarskpd->find($id);
        //if (is_null($skmutasiantarskpd)){return \Redirect::to('emutasi/skmutasiantarskpd/index');}
        return View::make('skmutasiantarskpd::edit', compact('skmutasiantarskpd'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, SkmutasiantarskpdModel::$rules);
        
        if ($validation->passes()){
            $skmutasiantarskpd = $this->skmutasiantarskpd->find($id);
            echo ($skmutasiantarskpd->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->skmutasiantarskpd->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->skmutasiantarskpd->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function getCetak(){
        $view = Request::segment(4);
        return View::make('skmutasiantarskpd::'.$view.'_print');
    }
    function postCetak(){
        $view = Request::segment(4);
        return View::make('skmutasiantarskpd::'.$view.'_print');
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('skmutasiantarskpd::'.$view.'_data');
    }

    /*Start Reza Pembuatan Modal untuk all Print*/
    public function postModalprint(){
        $inputs['tgl_notadinas'] = date('Y-m-d', strtotime(Input::get('tgl_notadinas')));
        // $inputs['nomor'] = \Input::get('nomor');
        $inputs['nousul'] = \Input::get('nousul');
        // $inputs['pil_print'] = \Input::get('pil_print');
        $contents = view('skmutasiantarskpd::notadinas_print',compact('inputs'));
        return $contents;

    }
    /*End Of Reza*/
}
