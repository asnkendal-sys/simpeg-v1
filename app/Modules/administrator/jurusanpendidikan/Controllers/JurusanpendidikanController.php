<?php namespace App\Modules\administrator\jurusanpendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\jurusanpendidikan\Models\JurusanpendidikanModel;
use Input,View, Request, Form, File;

/**
* Jurusanpendidikan Controller
* @var Jurusanpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JurusanpendidikanController extends Controller {
    protected $jurusanpendidikan;

    public function __construct(JurusanpendidikanModel $jurusanpendidikan){
        $this->jurusanpendidikan = $jurusanpendidikan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $jurusanpendidikans = $this->jurusanpendidikan
                			->orWhere('jenjurusan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idtkpendid', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $jurusanpendidikans = $this->jurusanpendidikan->all();
            }
        }else{
            $jurusanpendidikans = $this->jurusanpendidikan->all();
        }
        return View::make('jurusanpendidikan::index', compact('jurusanpendidikans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('jurusanpendidikan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, JurusanpendidikanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->jurusanpendidikan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $jurusanpendidikan = $this->jurusanpendidikan->find($id);
        //if (is_null($jurusanpendidikan)){return \Redirect::to('administrator/jurusanpendidikan/index');}
        return View::make('jurusanpendidikan::edit', compact('jurusanpendidikan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjenjurusan');
        $input = Input::all();
        $validation = \Validator::make($input, JurusanpendidikanModel::$rules);
        
        if ($validation->passes()){
            $jurusanpendidikan = $this->jurusanpendidikan->find($id);
            echo ($jurusanpendidikan->update($input))?4:"Gagal Disimpan";
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
                $this->jurusanpendidikan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->jurusanpendidikan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
