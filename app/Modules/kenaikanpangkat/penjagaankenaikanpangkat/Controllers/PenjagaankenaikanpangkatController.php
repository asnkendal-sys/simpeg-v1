<?php namespace App\Modules\kenaikanpangkat\penjagaankenaikanpangkat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\penjagaankenaikanpangkat\Models\PenjagaankenaikanpangkatModel;
use Input,View, Request, Form, File;

/**
* Penjagaankenaikanpangkat Controller
* @var Penjagaankenaikanpangkat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenjagaankenaikanpangkatController extends Controller {
    protected $penjagaankenaikanpangkat;

    public function __construct(PenjagaankenaikanpangkatModel $penjagaankenaikanpangkat){
        $this->penjagaankenaikanpangkat = $penjagaankenaikanpangkat;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $penjagaankenaikanpangkats = $this->penjagaankenaikanpangkat
                			->orWhere('nousul', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tglusul', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nip', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjeniskp', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('user_id', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('role_id', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('created_at', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $penjagaankenaikanpangkats = $this->penjagaankenaikanpangkat->all();
            }
        }else{
            $penjagaankenaikanpangkats = $this->penjagaankenaikanpangkat->all();
        }
        return View::make('penjagaankenaikanpangkat::index', compact('penjagaankenaikanpangkats'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('penjagaankenaikanpangkat::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenjagaankenaikanpangkatModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penjagaankenaikanpangkat->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penjagaankenaikanpangkat = $this->penjagaankenaikanpangkat->find($id);
        //if (is_null($penjagaankenaikanpangkat)){return \Redirect::to('kenaikanpangkat/penjagaankenaikanpangkat/index');}
        return View::make('penjagaankenaikanpangkat::edit', compact('penjagaankenaikanpangkat'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenjagaankenaikanpangkatModel::$rules);
        
        if ($validation->passes()){
            $penjagaankenaikanpangkat = $this->penjagaankenaikanpangkat->find($id);
            echo ($penjagaankenaikanpangkat->update($input))?4:"Gagal Disimpan";
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
                $this->penjagaankenaikanpangkat->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penjagaankenaikanpangkat->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
