<?php namespace App\Modules\administrator\liburnasional\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\liburnasional\Models\LiburnasionalModel;
use Input,View, Request, Form, File;

/**
* Liburnasional Controller
* @var Liburnasional
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class LiburnasionalController extends Controller {
    protected $liburnasional;

    public function __construct(LiburnasionalModel $liburnasional){
        $this->liburnasional = $liburnasional;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $liburnasionals = $this->liburnasional
                			->orWhere('tgl', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('keterangan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('user_id', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('role_id', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('created_at', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('updated_at', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $liburnasionals = $this->liburnasional->all();
            }
        }else{
            $liburnasionals = $this->liburnasional->all();
        }
        return View::make('liburnasional::index', compact('liburnasionals'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('liburnasional::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, LiburnasionalModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->liburnasional->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $liburnasional = $this->liburnasional->find($id);
        //if (is_null($liburnasional)){return \Redirect::to('administrator/liburnasional/index');}
        return View::make('liburnasional::edit', compact('liburnasional'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, LiburnasionalModel::$rules);
        
        if ($validation->passes()){
            $liburnasional = $this->liburnasional->find($id);
            echo ($liburnasional->update($input))?4:"Gagal Disimpan";
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
                $this->liburnasional->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->liburnasional->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
