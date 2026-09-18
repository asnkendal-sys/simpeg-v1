<?php namespace App\Modules\administrator\jabatanfungsional\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\jabatanfungsional\Models\JabatanfungsionalModel;
use Input,View, Request, Form, File;

/**
* Jabatanfungsional Controller
* @var Jabatanfungsional
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanfungsionalController extends Controller {
    protected $jabatanfungsional;

    public function __construct(JabatanfungsionalModel $jabatanfungsional){
        $this->jabatanfungsional = $jabatanfungsional;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $jabatanfungsionals = $this->jabatanfungsional
                    ->select('a_jabfung.*', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'))
                    ->orWhere('jabfung', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('jabfung2', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $jabatanfungsionals = $this->jabatanfungsional->all();
            }
        }else{
            $jabatanfungsionals = $this->jabatanfungsional->all();
        }
        return View::make('jabatanfungsional::index', compact('jabatanfungsionals'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('jabatanfungsional::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, JabatanfungsionalModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->jabatanfungsional->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $jabatanfungsional = $this->jabatanfungsional->find($id);
        //if (is_null($jabatanfungsional)){return \Redirect::to('administrator/jabatanfungsional/index');}
        return View::make('jabatanfungsional::edit', compact('jabatanfungsional'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjabfung');
        $input = Input::all();
        $isguru = Input::get('isguru');
        $input['isguru'] = ($isguru != '')?$isguru:0;
        $validation = \Validator::make($input, JabatanfungsionalModel::$rules);
        
        if ($validation->passes()){
            $jabatanfungsional = $this->jabatanfungsional->find($id);
            echo ($jabatanfungsional->update($input))?4:"Gagal Disimpan";
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
                $this->jabatanfungsional->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->jabatanfungsional->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
