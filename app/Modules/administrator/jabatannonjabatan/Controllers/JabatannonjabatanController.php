<?php namespace App\Modules\administrator\jabatannonjabatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\jabatannonjabatan\Models\JabatannonjabatanModel;
use Input,View, Request, Form, File;

/**
* Jabatannonjabatan Controller
* @var Jabatannonjabatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatannonjabatanController extends Controller {
    protected $jabatannonjabatan;

    public function __construct(JabatannonjabatanModel $jabatannonjabatan){
        $this->jabatannonjabatan = $jabatannonjabatan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $jabatannonjabatans = $this->jabatannonjabatan
                			->orWhere('jabnonjob', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $jabatannonjabatans = $this->jabatannonjabatan->all();
            }
        }else{
            $jabatannonjabatans = $this->jabatannonjabatan->all();
        }
        return View::make('jabatannonjabatan::index', compact('jabatannonjabatans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('jabatannonjabatan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, JabatannonjabatanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->jabatannonjabatan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $jabatannonjabatan = $this->jabatannonjabatan->find($id);
        //if (is_null($jabatannonjabatan)){return \Redirect::to('administrator/jabatannonjabatan/index');}
        return View::make('jabatannonjabatan::edit', compact('jabatannonjabatan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjabnonjob');
        $input = Input::all();
        $validation = \Validator::make($input, JabatannonjabatanModel::$rules);
        
        if ($validation->passes()){
            $jabatannonjabatan = $this->jabatannonjabatan->find($id);
            echo ($jabatannonjabatan->update($input))?4:"Gagal Disimpan";
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
                $this->jabatannonjabatan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->jabatannonjabatan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
