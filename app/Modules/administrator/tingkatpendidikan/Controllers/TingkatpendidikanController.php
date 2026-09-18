<?php namespace App\Modules\administrator\tingkatpendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\tingkatpendidikan\Models\TingkatpendidikanModel;
use Input,View, Request, Form, File;

/**
* Tingkatpendidikan Controller
* @var Tingkatpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TingkatpendidikanController extends Controller {
    protected $tingkatpendidikan;

    public function __construct(TingkatpendidikanModel $tingkatpendidikan){
        $this->tingkatpendidikan = $tingkatpendidikan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $tingkatpendidikans = $this->tingkatpendidikan
                			->orWhere('tkpendid', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('maxgol', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('singkatan', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $tingkatpendidikans = $this->tingkatpendidikan->all();
            }
        }else{
            $tingkatpendidikans = $this->tingkatpendidikan->all();
        }
        return View::make('tingkatpendidikan::index', compact('tingkatpendidikans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('tingkatpendidikan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TingkatpendidikanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->tingkatpendidikan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $tingkatpendidikan = $this->tingkatpendidikan->find($id);
        //if (is_null($tingkatpendidikan)){return \Redirect::to('administrator/tingkatpendidikan/index');}
        return View::make('tingkatpendidikan::edit', compact('tingkatpendidikan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idtkpendid');
        $input = Input::all();
        $validation = \Validator::make($input, TingkatpendidikanModel::$rules);
        
        if ($validation->passes()){
            $tingkatpendidikan = $this->tingkatpendidikan->find($id);
            echo ($tingkatpendidikan->update($input))?4:"Gagal Disimpan";
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
                $this->tingkatpendidikan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->tingkatpendidikan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
