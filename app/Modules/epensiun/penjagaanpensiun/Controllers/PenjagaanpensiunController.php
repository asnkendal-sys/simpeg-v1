<?php namespace App\Modules\epensiun\penjagaanpensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\penjagaanpensiun\Models\PenjagaanpensiunModel;
use Input,View, Request, Form, File;

/**
* Penjagaanpensiun Controller
* @var Penjagaanpensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenjagaanpensiunController extends Controller {
    protected $penjagaanpensiun;

    public function __construct(PenjagaanpensiunModel $penjagaanpensiun){
        $this->penjagaanpensiun = $penjagaanpensiun;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $penjagaanpensiuns = $this->penjagaanpensiun
            ->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $penjagaanpensiuns = $this->penjagaanpensiun->all();
            }
        }else{
            $penjagaanpensiuns = $this->penjagaanpensiun->all();
        }
        return View::make('penjagaanpensiun::index', compact('penjagaanpensiuns'));
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('penjagaanpensiun::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('penjagaanpensiun::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('penjagaanpensiun::'.$view.'_excel');
    }

    public function getCreate(){
        cekAjax();
        return View::make('penjagaanpensiun::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenjagaanpensiunModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penjagaanpensiun->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penjagaanpensiun = $this->penjagaanpensiun->find($id);
        //if (is_null($penjagaanpensiun)){return \Redirect::to('epensiun/penjagaanpensiun/index');}
        return View::make('penjagaanpensiun::edit', compact('penjagaanpensiun'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenjagaanpensiunModel::$rules);
        
        if ($validation->passes()){
            $penjagaanpensiun = $this->penjagaanpensiun->find($id);
            echo ($penjagaanpensiun->update($input))?4:"Gagal Disimpan";
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
                $this->penjagaanpensiun->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penjagaanpensiun->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
