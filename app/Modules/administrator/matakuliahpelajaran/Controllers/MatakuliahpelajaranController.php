<?php namespace App\Modules\administrator\matakuliahpelajaran\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\matakuliahpelajaran\Models\MatakuliahpelajaranModel;
use Input,View, Request, Form, File;

/**
* Matakuliahpelajaran Controller
* @var Matakuliahpelajaran
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MatakuliahpelajaranController extends Controller {
    protected $matakuliahpelajaran;

    public function __construct(MatakuliahpelajaranModel $matakuliahpelajaran){
        $this->matakuliahpelajaran = $matakuliahpelajaran;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $matakuliahpelajarans = $this->matakuliahpelajaran
                			->orWhere('idtugasgurudosen', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idmatkulpel', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('matkulpel', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $matakuliahpelajarans = $this->matakuliahpelajaran->all();
            }
        }else{
            $matakuliahpelajarans = $this->matakuliahpelajaran->all();
        }
        return View::make('matakuliahpelajaran::index', compact('matakuliahpelajarans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('matakuliahpelajaran::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, MatakuliahpelajaranModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->matakuliahpelajaran->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $matakuliahpelajaran = $this->matakuliahpelajaran->find($id);
        //if (is_null($matakuliahpelajaran)){return \Redirect::to('administrator/matakuliahpelajaran/index');}
        return View::make('matakuliahpelajaran::edit', compact('matakuliahpelajaran'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idmatkulpel');
        $input = Input::all();
        $validation = \Validator::make($input, MatakuliahpelajaranModel::$rules);
        
        if ($validation->passes()){
            $matakuliahpelajaran = $this->matakuliahpelajaran->find($id);
            echo ($matakuliahpelajaran->update($input))?4:"Gagal Disimpan";
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
                $this->matakuliahpelajaran->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->matakuliahpelajaran->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
