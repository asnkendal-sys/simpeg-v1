<?php namespace App\Modules\epersonal\nominatifpenjagaanpkpppk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpenjagaanpkpppk\Models\NominatifpenjagaanpkpppkModel;
use Input,View, Request, Form, File;

/**
* Nominatifpenjagaanpkpppk Controller
* @var Nominatifpenjagaanpkpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaanpkpppkController extends Controller {
    protected $nominatifpenjagaanpkpppk;

    public function __construct(NominatifpenjagaanpkpppkModel $nominatifpenjagaanpkpppk){
        $this->nominatifpenjagaanpkpppk = $nominatifpenjagaanpkpppk;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpenjagaanpkpppks = $this->nominatifpenjagaanpkpppk
                			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('updated_at', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $nominatifpenjagaanpkpppks = $this->nominatifpenjagaanpkpppk->all();
            }
        }else{
            $nominatifpenjagaanpkpppks = $this->nominatifpenjagaanpkpppk->all();
        }
        return View::make('nominatifpenjagaanpkpppk::index', compact('nominatifpenjagaanpkpppks'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('nominatifpenjagaanpkpppk::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, NominatifpenjagaanpkpppkModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->nominatifpenjagaanpkpppk->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function view data atribut dari link */
      function postData(){
            cekAjax();
            $view = Request::segment(4);
            return View::make('nominatifpenjagaanpkpppk::'.$view.'_data');
      }

      function postPrint(){
            $view = Request::segment(4);
            return View::make('nominatifpenjagaanpkpppk::'.$view.'_print');
      }

      function postExcel(){
            $view = Request::segment(4);
            return View::make('nominatifpenjagaanpkpppk::'.$view.'_excel');
      }

      function getNominatifpenjagaanperpanjanganpppk() {
            cekAjax();
            return View::make('nominatifpenjagaanpkpppk::index_nominatifpenjagaanperpanjanganpppk');
      }

    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $nominatifpenjagaanpkpppk = $this->nominatifpenjagaanpkpppk->find($id);
        //if (is_null($nominatifpenjagaanpkpppk)){return \Redirect::to('epersonal/nominatifpenjagaanpkpppk/index');}
        return View::make('nominatifpenjagaanpkpppk::edit', compact('nominatifpenjagaanpkpppk'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, NominatifpenjagaanpkpppkModel::$rules);
        
        if ($validation->passes()){
            $nominatifpenjagaanpkpppk = $this->nominatifpenjagaanpkpppk->find($id);
            echo ($nominatifpenjagaanpkpppk->update($input))?4:"Gagal Disimpan";
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
                $this->nominatifpenjagaanpkpppk->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->nominatifpenjagaanpkpppk->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
