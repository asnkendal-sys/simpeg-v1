<?php namespace App\Modules\ecuti\penyesuaiankuota\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\penyesuaiankuota\Models\PenyesuaiankuotaModel;
use Input,View, Request, Form, File;

/**
* Penyesuaiankuota Controller
* @var Penyesuaiankuota
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenyesuaiankuotaController extends Controller {
    protected $penyesuaiankuota;

    public function __construct(PenyesuaiankuotaModel $penyesuaiankuota){
        $this->penyesuaiankuota = $penyesuaiankuota;
    }

    public function getIndex(){
        cekAjax();

        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }

        if (Input::has('search')) {
            $where .= " AND tb_01.nama LIKE '%".Input::get('search')."%' ";
            $penyesuaiankuotas = $this->penyesuaiankuota
            ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $penyesuaiankuotas = $this->penyesuaiankuota->all();
        }
        return View::make('penyesuaiankuota::index', compact('penyesuaiankuotas'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('penyesuaiankuota::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenyesuaiankuotaModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penyesuaiankuota->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penyesuaiankuota = $this->penyesuaiankuota->find($id);
        //if (is_null($penyesuaiankuota)){return \Redirect::to('ecuti/penyesuaiankuota/index');}
        return View::make('penyesuaiankuota::edit', compact('penyesuaiankuota'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenyesuaiankuotaModel::$rules);
        
        if ($validation->passes()){
            $penyesuaiankuota = $this->penyesuaiankuota->find($id);
            echo ($penyesuaiankuota->update($input))?4:"Gagal Disimpan";
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
                $this->penyesuaiankuota->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penyesuaiankuota->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
