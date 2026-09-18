<?php namespace App\Modules\administrator\manajemenuser\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\manajemenuser\Models\ManajemenuserModel;
use Input,View, Request, Form, File;

/**
* Manajemenuser Controller
* @var Manajemenuser
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class ManajemenuserController extends Controller {
    protected $manajemenuser;

    public function __construct(ManajemenuserModel $manajemenuser){
        $this->manajemenuser = $manajemenuser;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $manajemenusers = $this->manajemenuser
                    ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
                    ->leftjoin('a_skpd', 'users.idskpd', '=', 'a_skpd.idskpd')
                    ->select('users.*', \DB::raw('roles.name as rolename'), 'a_skpd.skpd', \DB::raw('if(NOW() BETWEEN users.aktif_mulai AND users.aktif_selesai, 1, 0) as aktif'))
                    ->orWhere('users.name', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('users.username', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('users.email', 'LIKE', '%'.Input::get('search').'%')
                    ->where('users.role_id', '!=', 1)
                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $manajemenusers = $this->manajemenuser->all();
            }
        }else{
            $manajemenusers = $this->manajemenuser->all();
        }
        return View::make('manajemenuser::index', compact('manajemenusers'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('manajemenuser::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, ManajemenuserModel::$rules);
        if ($validation->passes()){
            unset($input['checkall']);
            if($input['role_id'] < 4){
                $input['idskpd'] = '';
            }
            $input['idcontexts'] = implode(",",$input['idcontexts']);
            $input['password'] = \Hash::make(Input::get('password'));
            $input['foto'] = 'default.jpg';
            echo ($this->manajemenuser->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $manajemenuser = $this->manajemenuser->find($id);
        //if (is_null($manajemenuser)){return \Redirect::to('administrator/manajemenuser/index');}
        return View::make('manajemenuser::edit', compact('manajemenuser'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, ManajemenuserModel::$rules);
        
        if ($validation->passes()){
            unset($input['checkall']);
            $input['idcontexts'] = implode(",",$input['idcontexts']);
            if(Input::get('password') != ''){
                $input['password'] = \Hash::make(Input::get('password'));
            }else{
                unset($input['password']);
            }

            if($input['role_id'] < 4){
                $input['idskpd'] = '';
            }
            $manajemenuser = $this->manajemenuser->find($id);
            echo ($manajemenuser->update($input))?4:"Gagal Disimpan";
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
                $this->manajemenuser->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->manajemenuser->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk menampilkan form setting*/
    public function getSetting(){
        cekAjax();
        return View::make('manajemenuser::setting');
    }

    /*function untuk menyimpan setting jadwal*/
    public function postSavesetting(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, ManajemenuserModel::$rules_setting);

        if ($validation->passes()){
            unset($input['_token']);
            if($input['username'] == 'all'){
                unset($input['username']);
                $manajemenuser = \DB::table('users')->where('role_id','=',4)->update($input);
            }else{
                $manajemenuser = \DB::table('users')->where('username', $input['username'])->update($input);
            }
            echo ($manajemenuser)?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function untuk menyimpan setting user pegawai*/
    public function postSettingpegawai(){
        cekAjax();
        $manajemenuser = \DB::table('tb_01')->where('nip','!=','')->update(array('usiapens'=>Input::get('usiapens')));
        echo ($manajemenuser)?4:"Gagal Disimpan";
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $data['role_id'] = Input::get('role_id');
        $data['context_id'] = Input::get('context_id');
        $data['rs'] = ManajemenuserModel::getContextmodule();
        $view = Request::segment(4);
        return View::make('manajemenuser::'.$view.'_data', $data);
    }
}
