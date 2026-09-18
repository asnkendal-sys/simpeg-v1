<?php namespace App\Modules\administrator\tugasdokter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\tugasdokter\Models\TugasdokterModel;
use Input,View, Request, Form, File;

/**
* Tugasdokter Controller
* @var Tugasdokter
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TugasdokterController extends Controller {
    protected $tugasdokter;

    public function __construct(TugasdokterModel $tugasdokter){
        $this->tugasdokter = $tugasdokter;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $tugasdokters = $this->tugasdokter
                			->orWhere('tugasdokter', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $tugasdokters = $this->tugasdokter->all();
            }
        }else{
            $tugasdokters = $this->tugasdokter->all();
        }
        return View::make('tugasdokter::index', compact('tugasdokters'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('tugasdokter::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TugasdokterModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->tugasdokter->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $tugasdokter = $this->tugasdokter->find($id);
        //if (is_null($tugasdokter)){return \Redirect::to('administrator/tugasdokter/index');}
        return View::make('tugasdokter::edit', compact('tugasdokter'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idtugasdokter');
        $input = Input::all();
        $validation = \Validator::make($input, TugasdokterModel::$rules);
        
        if ($validation->passes()){
            $tugasdokter = $this->tugasdokter->find($id);
            echo ($tugasdokter->update($input))?4:"Gagal Disimpan";
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
                $this->tugasdokter->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->tugasdokter->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
