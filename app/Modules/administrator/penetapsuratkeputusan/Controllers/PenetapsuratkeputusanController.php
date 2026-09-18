<?php namespace App\Modules\administrator\penetapsuratkeputusan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\penetapsuratkeputusan\Models\PenetapsuratkeputusanModel;
use Input,View, Request, Form, File;

/**
* Penetapsuratkeputusan Controller
* @var Penetapsuratkeputusan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenetapsuratkeputusanController extends Controller {
    protected $penetapsuratkeputusan;

    public function __construct(PenetapsuratkeputusanModel $penetapsuratkeputusan){
        $this->penetapsuratkeputusan = $penetapsuratkeputusan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $penetapsuratkeputusans = $this->penetapsuratkeputusan
                			->orWhere('jabatan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('namalengkap', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nip', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('pangkat', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $penetapsuratkeputusans = $this->penetapsuratkeputusan->all();
            }
        }else{
            $penetapsuratkeputusans = $this->penetapsuratkeputusan->all();
        }
        return View::make('penetapsuratkeputusan::index', compact('penetapsuratkeputusans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('penetapsuratkeputusan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenetapsuratkeputusanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penetapsuratkeputusan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penetapsuratkeputusan = $this->penetapsuratkeputusan->find($id);
        //if (is_null($penetapsuratkeputusan)){return \Redirect::to('administrator/penetapsuratkeputusan/index');}
        return View::make('penetapsuratkeputusan::edit', compact('penetapsuratkeputusan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenetapsuratkeputusanModel::$rules);
        
        if ($validation->passes()){
            $penetapsuratkeputusan = $this->penetapsuratkeputusan->find($id);
            echo ($penetapsuratkeputusan->update($input))?4:"Gagal Disimpan";
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
                $this->penetapsuratkeputusan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penetapsuratkeputusan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
