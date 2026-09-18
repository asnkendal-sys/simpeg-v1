<?php namespace App\Modules\epersonal\urutanjabatanpegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\urutanjabatanpegawai\Models\UrutanjabatanpegawaiModel;
use Input,View, Request, Form, File;

/**
* Urutanjabatanpegawai Controller
* @var Urutanjabatanpegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UrutanjabatanpegawaiController extends Controller {
    protected $urutanjabatanpegawai;

    public function __construct(UrutanjabatanpegawaiModel $urutanjabatanpegawai){
        $this->urutanjabatanpegawai = $urutanjabatanpegawai;
    }

    public function getIndex(){
        cekAjax();

        if (Input::has('idskpd')) {
            if(strlen(Input::get('idskpd')) > 2){
                $urutanjabatanpegawais = geturutanpegawai(Input::get('idskpd'),substr(Input::get('idskpd'),0,-3));
                // $urutanjabatanpegawais = geturutanpegawai(Input::get('idskpd'),substr(Input::get('idskpd'),1,2));
            }else{
                $urutanjabatanpegawais = geturutanpegawai(Input::get('idskpd'),'');
            }

        }else{
            if(session('role_id') <= 3){
                $idskpd = '25';
            }else{
                $idskpd = session('idskpd');
            }

            if(strlen($idskpd) > 2){
                $urutanjabatanpegawais = geturutanpegawai($idskpd,substr($idskpd,0,- 3));
            }else{
                $urutanjabatanpegawais = geturutanpegawai($idskpd, '');
            }
        }

        return View::make('urutanjabatanpegawai::index', compact('urutanjabatanpegawais'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('urutanjabatanpegawai::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, UrutanjabatanpegawaiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->urutanjabatanpegawai->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $urutanjabatanpegawai = $this->urutanjabatanpegawai->find($id);
        //if (is_null($urutanjabatanpegawai)){return \Redirect::to('epersonal/urutanjabatanpegawai/index');}
        return View::make('urutanjabatanpegawai::edit', compact('urutanjabatanpegawai'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, UrutanjabatanpegawaiModel::$rules);
        
        if ($validation->passes()){
            $urutanjabatanpegawai = $this->urutanjabatanpegawai->find($id);
            echo ($urutanjabatanpegawai->update($input))?4:"Gagal Disimpan";
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
                $this->urutanjabatanpegawai->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->urutanjabatanpegawai->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
