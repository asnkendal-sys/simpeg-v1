<?php namespace App\Modules\administrator\sekolahswasta\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\sekolahswasta\Models\SekolahswastaModel;
use Input,View, Request, Form, File;

/**
* Sekolahswasta Controller
* @var Sekolahswasta
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SekolahswastaController extends Controller {
    protected $sekolahswasta;

    public function __construct(SekolahswastaModel $sekolahswasta){
        $this->sekolahswasta = $sekolahswasta;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $sekolahswastas = $this->sekolahswasta
                			->orWhere('nmasekolah', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $sekolahswastas = $this->sekolahswasta->all();
            }
        }else{
            $sekolahswastas = $this->sekolahswasta->all();
        }
        return View::make('sekolahswasta::index', compact('sekolahswastas'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('sekolahswasta::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SekolahswastaModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->sekolahswasta->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $sekolahswasta = $this->sekolahswasta->find($id);
        //if (is_null($sekolahswasta)){return \Redirect::to('administrator/sekolahswasta/index');}
        return View::make('sekolahswasta::edit', compact('sekolahswasta'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, SekolahswastaModel::$rules);
        
        if ($validation->passes()){
            $sekolahswasta = $this->sekolahswasta->find($id);
            echo ($sekolahswasta->update($input))?4:"Gagal Disimpan";
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
                $this->sekolahswasta->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->sekolahswasta->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
