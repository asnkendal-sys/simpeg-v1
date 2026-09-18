<?php namespace App\Modules\emutasi\skluarkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\skluarkabupaten\Models\SkluarkabupatenModel;
use Input,View, Request, Form, File;

/**
* Skluarkabupaten Controller
* @var Skluarkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkluarkabupatenController extends Controller {
    protected $skluarkabupaten;

    public function __construct(SkluarkabupatenModel $skluarkabupaten){
        $this->skluarkabupaten = $skluarkabupaten;
    }

        public function getIndex(){
        cekAjax();
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {
                $where = "tr_mutasi_luar_daerah.idusul != ''";
                if(Input::get('idskpd') != ''){
                    $idskpd = Input::get('idskpd');
                    $where .= " and tr_mutasi_luar_daerah.idskpd like '$idskpd%'";
                }

                if(strlen(Input::has('search')) > 0) {
                    $where .=" and (tr_mutasi_luar_daerah.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
                }

                $skluarkabupatens = $this->skluarkabupaten
                    ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat','tb_01.nama',
                    \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                    \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
                )
                ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
                ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
                ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
                ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
                ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
                ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
                ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.nip'))
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $skluarkabupatens = $this->skluarkabupaten->all();
        }
        return View::make('skluarkabupaten::index', compact('skluarkabupatens'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('skluarkabupaten::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SkluarkabupatenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->skluarkabupaten->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $skluarkabupaten = $this->skluarkabupaten->find($id);
        //if (is_null($skluarkabupaten)){return \Redirect::to('emutasi/skluarkabupaten/index');}
        return View::make('skluarkabupaten::edit', compact('skluarkabupaten'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, SkluarkabupatenModel::$rules);
        
        if ($validation->passes()){
            $skluarkabupaten = $this->skluarkabupaten->find($id);
            echo ($skluarkabupaten->update($input))?4:"Gagal Disimpan";
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
                $this->skluarkabupaten->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->skluarkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function getCetak(){
        $view = Request::segment(4);
        return View::make('skluarkabupaten::'.$view.'_print');
    }
}
