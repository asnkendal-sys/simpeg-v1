<?php namespace App\Modules\kenaikanpangkat\penjadwalankp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\penjadwalankp\Models\PenjadwalankpModel;
use Input,View, Request, Form, File;

class PenjadwalankpController extends Controller {

	/**
	 * Penjadwalankp Repository
	 *
	 * @var Penjadwalankp
	 */
	protected $penjadwalankp;

	public function __construct(PenjadwalankpModel $penjadwalankp){
        $this->penjadwalankp = $penjadwalankp;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		$penjadwalankps = \DB::table('tr_kenaikan_pangkat_jadwal')
						->paginate($_ENV['configurations']['list-limit']);
		return View::make('penjadwalankp::index', compact('penjadwalankps'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('penjadwalankp::create');
	}

	public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenjadwalankpModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penjadwalankp->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

	public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penjadwalankp = $this->penjadwalankp->find($id);
        return View::make('penjadwalankp::edit', compact('penjadwalankp'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenjadwalankpModel::$rules);
        
        if ($validation->passes()){
            $penjadwalankp = $this->penjadwalankp->find($id);
            echo ($penjadwalankp->update($input))?4:"Gagal Disimpan";
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
                $this->penjadwalankp->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penjadwalankp->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }
	
}
