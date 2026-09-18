<?php namespace App\Modules\administrator\tugasgurudosen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\tugasgurudosen\Models\TugasgurudosenModel;
use Input,View, Request, Form, File;

/**
* Tugasgurudosen Controller
* @var Tugasgurudosen
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TugasgurudosenController extends Controller {
    protected $tugasgurudosen;

    public function __construct(TugasgurudosenModel $tugasgurudosen){
        $this->tugasgurudosen = $tugasgurudosen;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $tugasgurudosens = $this->tugasgurudosen
                			->orWhere('tugasgurudosen', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $tugasgurudosens = $this->tugasgurudosen->all();
            }
        }else{
            $tugasgurudosens = $this->tugasgurudosen->all();
        }
        return View::make('tugasgurudosen::index', compact('tugasgurudosens'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('tugasgurudosen::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TugasgurudosenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->tugasgurudosen->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $tugasgurudosen = $this->tugasgurudosen->find($id);
        //if (is_null($tugasgurudosen)){return \Redirect::to('administrator/tugasgurudosen/index');}
        return View::make('tugasgurudosen::edit', compact('tugasgurudosen'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idtugasgurudosen');
        $input = Input::all();
        $validation = \Validator::make($input, TugasgurudosenModel::$rules);
        
        if ($validation->passes()){
            $tugasgurudosen = $this->tugasgurudosen->find($id);
            echo ($tugasgurudosen->update($input))?4:"Gagal Disimpan";
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
                $this->tugasgurudosen->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->tugasgurudosen->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
