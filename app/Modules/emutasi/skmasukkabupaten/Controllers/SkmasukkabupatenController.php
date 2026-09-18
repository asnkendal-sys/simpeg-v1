<?php namespace App\Modules\emutasi\skmasukkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\skmasukkabupaten\Models\SkmasukkabupatenModel;
use Input,View, Request, Form, File;

/**
* Skmasukkabupaten Controller
* @var Skmasukkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkmasukkabupatenController extends Controller {
    protected $skmasukkabupaten;

    public function __construct(SkmasukkabupatenModel $skmasukkabupaten){
        $this->skmasukkabupaten = $skmasukkabupaten;
    }

    public function getIndex(){
        cekAjax();
        $where = " tr_mutasi_masuk_daerah.nip != ''";


        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {
            (Input::get('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $skmasukkabupatens = $this->skmasukkabupaten
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
            $skmasukkabupatens = $this->skmasukkabupaten->all();
        }

        return View::make('skmasukkabupaten::index', compact('skmasukkabupatens'));
    }

    public function getCreate(){
        cekAjax();
        return View::make('skmasukkabupaten::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SkmasukkabupatenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->skmasukkabupaten->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $skmasukkabupaten = $this->skmasukkabupaten->find($id);
        //if (is_null($skmasukkabupaten)){return \Redirect::to('emutasi/skmasukkabupaten/index');}
        return View::make('skmasukkabupaten::edit', compact('skmasukkabupaten'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, SkmasukkabupatenModel::$rules);

        if ($validation->passes()){
            $skmasukkabupaten = $this->skmasukkabupaten->find($id);
            echo ($skmasukkabupaten->update($input))?4:"Gagal Disimpan";
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
                $this->skmasukkabupaten->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->skmasukkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function getCetak(){        
        $view = Request::segment(4);
        return View::make('skmasukkabupaten::'.$view.'_print');
    }
}
