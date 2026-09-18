<?php namespace App\Modules\administrator\jabatanfungsionalumum\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\jabatanfungsionalumum\Models\JabatanfungsionalumumModel;
use Input,View, Request, Form, File;

/**
* Jabatanfungsionalumum Controller
* @var Jabatanfungsionalumum
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanfungsionalumumController extends Controller {
    protected $jabatanfungsionalumum;

    public function __construct(JabatanfungsionalumumModel $jabatanfungsionalumum){
        $this->jabatanfungsionalumum = $jabatanfungsionalumum;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $jabatanfungsionalumums = $this->jabatanfungsionalumum
                			->orWhere('idjabfungum', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('jabfungum', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $jabatanfungsionalumums = $this->jabatanfungsionalumum->all();
            }
        }else{
            $jabatanfungsionalumums = $this->jabatanfungsionalumum->all();
        }
        return View::make('jabatanfungsionalumum::index', compact('jabatanfungsionalumums'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('jabatanfungsionalumum::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, JabatanfungsionalumumModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->jabatanfungsionalumum->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $jabatanfungsionalumum = $this->jabatanfungsionalumum->find($id);
        //if (is_null($jabatanfungsionalumum)){return \Redirect::to('administrator/jabatanfungsionalumum/index');}
        return View::make('jabatanfungsionalumum::edit', compact('jabatanfungsionalumum'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjabfungum');
        $input = Input::all();
        $validation = \Validator::make($input, JabatanfungsionalumumModel::$rules);
        
        if ($validation->passes()){
            $jabatanfungsionalumum = $this->jabatanfungsionalumum->find($id);
            echo ($jabatanfungsionalumum->update($input))?4:"Gagal Disimpan";
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
                $this->jabatanfungsionalumum->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->jabatanfungsionalumum->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
