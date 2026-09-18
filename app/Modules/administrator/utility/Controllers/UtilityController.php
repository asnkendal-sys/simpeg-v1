<?php namespace App\Modules\administrator\utility\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\utility\Models\UtilityModel;
use Input,View, Request, Form, File;

/**
* Utility Controller
* @var Utility
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UtilityController extends Controller {
    protected $utility;

    public function __construct(UtilityModel $utility){
        $this->utility = $utility;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $utilitys = $this->utility
                			->orWhere('nma_aplikasi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nma_instansi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('kab_instansi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('link_instansi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('email_instansi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('logo_instansi', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('thn_develop', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $utilitys = $this->utility->all();
            }
        }else{
            $utilitys = $this->utility->all();
        }
        return View::make('utility::index', compact('utilitys'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('utility::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, UtilityModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->utility->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $utility = $this->utility->find($id);
        //if (is_null($utility)){return \Redirect::to('administrator/utility/index');}
        return View::make('utility::edit', compact('utility'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, UtilityModel::$rules);
        
        if ($validation->passes()){
            $utility = $this->utility->find($id);
            echo ($utility->update($input))?4:"Gagal Disimpan";
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
                $this->utility->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->utility->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
