<?php namespace App\Modules\administrator\unitkerja\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\unitkerja\Models\UnitkerjaModel;
use Input,View, Request, Form, File;

/**
* Unitkerja Controller
* @var Unitkerja
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UnitkerjaController extends Controller {
    protected $unitkerja;

    public function __construct(UnitkerjaModel $unitkerja){
        $this->unitkerja = $unitkerja;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $unitkerjas = $this->unitkerja
                    ->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
                    ->select('a_skpd.*', 'a_esl.esl')
                    ->orWhere('a_skpd.idparent', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('a_skpd.skpd', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('a_skpd.path', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('a_skpd.jab', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('a_skpd.idesl', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $unitkerjas = $this->unitkerja->all();
            }
        }else{
            $unitkerjas = $this->unitkerja->all();
        }
        return View::make('unitkerja::index', compact('unitkerjas'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('unitkerja::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, UnitkerjaModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->unitkerja->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $unitkerja = $this->unitkerja->find($id);
        //if (is_null($unitkerja)){return \Redirect::to('administrator/unitkerja/index');}
        return View::make('unitkerja::edit', compact('unitkerja'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idskpd');
        $input = Input::all();
        $validation = \Validator::make($input, UnitkerjaModel::$rules);
        
        if ($validation->passes()){
            $unitkerja = $this->unitkerja->find($id);
            echo ($unitkerja->update($input))?4:"Gagal Disimpan";
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
                $this->unitkerja->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->unitkerja->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function outo idskpd*/
    public function postAutoidskpd(){
        $idparent = Input::get('idparent');
        $rs = \DB::table('a_skpd')
                ->select(\DB::raw('idskpd, idparent, skpd, RIGHT(idskpd, 2) as rights, (RIGHT(idskpd, 2) + 1) AS idbaru, tmstamp'))
                ->where('idskpd', 'like', ''.$idparent.'%')
                ->where('idparent', '=', $idparent)
                ->orderBy('idskpd', 'desc')
                ->orderBy('tmstamp', 'desc')
                ->take('1');

        $row = $rs->first();
        if($rs->count() > 0 ){
            $ret['idparent'] = $idparent;
            $ret['lastid'] = $row->idskpd;
            if (is_numeric($row->rights)) {
                $ret['idbaru'] = $row->idparent.".".((strlen($row->idbaru) == 1)?"0".$row->idbaru:$row->idbaru);
            } else {
                $x = substr($row->rights,0,1);
                $y = substr($row->rights,1,1) + 1;
                if($y > 9){
                    $ret['idbaru'] = $row->idparent.".??";
                }else{
                    $ret['idbaru'] = $row->idparent.".".$x."".$y;
                }
            }
        }else{
            $ret['idparent'] = $idparent;
            $ret['lastid'] = $idparent.".00";
            $ret['idbaru'] = $idparent.".01";
        }
        $ret['path'] = isset($row->skpd)?$row->skpd:'';

        echo json_encode($ret);
    }

}
