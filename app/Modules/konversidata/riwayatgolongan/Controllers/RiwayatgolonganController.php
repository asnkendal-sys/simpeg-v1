<?php namespace App\Modules\konversidata\riwayatgolongan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\riwayatgolongan\Models\RiwayatgolonganModel;
use Input,View, Request, Form, File;

/**
* Riwayatgolongan Controller
* @var Riwayatgolongan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatgolonganController extends Controller {
    protected $riwayatgolongan;

    public function __construct(RiwayatgolonganModel $riwayatgolongan){
        $this->riwayatgolongan = $riwayatgolongan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $riwayatgolongans = $this->riwayatgolongan
                			->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $riwayatgolongans = $this->riwayatgolongan->all();
            }
        }else{
            $riwayatgolongans = $this->riwayatgolongan->all();
        }
        return View::make('riwayatgolongan::index', compact('riwayatgolongans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('riwayatgolongan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatgolonganModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->riwayatgolongan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $riwayatgolongan = $this->riwayatgolongan->find($id);
        //if (is_null($riwayatgolongan)){return \Redirect::to('konversidata/riwayatgolongan/index');}
        return View::make('riwayatgolongan::edit', compact('riwayatgolongan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatgolonganModel::$rules);
        
        if ($validation->passes()){
            $riwayatgolongan = $this->riwayatgolongan->find($id);
            echo ($riwayatgolongan->update($input))?4:"Gagal Disimpan";
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
                $this->riwayatgolongan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->riwayatgolongan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
