<?php namespace App\Modules\kenaikangajiberkala\mastergaji\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\mastergaji\Models\MastergajiModel;
use Input,View, Request, Form, File;

/**
* Mastergaji Controller
* @var Mastergaji
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MastergajiController extends Controller {
    protected $mastergaji;

    public function __construct(MastergajiModel $mastergaji){
        $this->mastergaji = $mastergaji;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $mastergajis = $this->mastergaji
                    ->select('a_gaji.*','a_golruang.golru', 'a_golruang.pangkat')
                    ->leftJoin('a_golruang', 'a_gaji.pkt', '=', 'a_golruang.idgolru')
                    ->orWhere('gaji', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('dasarhukum', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('ket', 'LIKE', '%'.Input::get('search').'%')
                    ->orderBy('a_gaji.tahun')
                    ->orderBy('a_gaji.pkt')
                    ->orderBy('a_gaji.msk')

                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $mastergajis = $this->mastergaji->all();
            }
        }else{
            $mastergajis = $this->mastergaji->all();
        }
        return View::make('mastergaji::index', compact('mastergajis'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('mastergaji::create');
    }

    public function getCreatep3k(){
        cekAjax();
        $idstspeg = 3;
        return View::make('mastergaji::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, MastergajiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            // dd($input); die();
            echo ($this->mastergaji->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postCreatep3k(){
        cekAjax();
        // $input = Input::all();
        $input = Input::except('_token');
        $validation = \Validator::make($input, MastergajiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            // dd($input); die();
            echo (\DB::table('a_gaji_pppk')->insert($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $idstspeg = 2;
        $mastergaji = $this->mastergaji->find($id);

        return View::make('mastergaji::edit', compact('mastergaji'))->with('idstspeg',$idstspeg);
    }

    public function getEditp3k($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $idstspeg = 3;
        $mastergaji = \DB::table('a_gaji_pppk')->find($id);

        return View::make('mastergaji::edit', compact('mastergaji'))->with('idstspeg',$idstspeg);
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $idstspeg = Input::get('idstspeg');
        $input = Input::except('idstspeg');
        $inputp3k = Input::except('idstspeg','_token');
        
        $validation = \Validator::make($input, MastergajiModel::$rules);
        
        if ($validation->passes()){
            if($idstspeg==2){
                $mastergaji = $this->mastergaji->find($id);
                echo ($mastergaji->update($input))?4:"Gagal Disimpan";
            }else{
                echo (\DB::table('a_gaji_pppk')->where('id',$id)->update($inputp3k))?4:"Gagal Disimpan";
            }
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
                $this->mastergaji->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->mastergaji->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    public function postDeletep3k(){
        cekAjax();
        $ids = Input::get('id');

        if (is_array($ids)){
            foreach($ids as $id){
                \DB::table('a_gaji_pppk')->where('id',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::table('a_gaji_pppk')->where('id',$ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('mastergaji::'.$view."_data");
    }

    /*function simpan mastergaji*/
    function postMastergaji(){
        cekAjax();
        $id = Input::get('tahun');
        $input = Input::all();
        $idstspeg = Input::get('idstspeg');
        
        if($idstspeg==2){
            $table = "a_gaji";
        }else{
            $table = "a_gaji_pppk";
        }
        
        $validation = \Validator::make($input, MastergajiModel::$rules_mastergaji);

        if ($validation->passes()){
            \DB::table($table)->where('tahun', '!=', $id)->update(array('status'=>2));
            echo (\DB::table($table)->where('tahun', '=', $id)->update(array('status'=>1, 'updated_at'=>date('Y-m-d H:i:s'))))?4:"Gagal Disimpan";
        }
        else{
            echo 'Tahun master gaji tidak boleh kosong';
        }
    }

    public function getDatagajip3k(){
        $gajip3ks = \DB::table('a_gaji_pppk')
                    ->select('a_gaji_pppk.*','a_golruang.golru', 'a_golruang.golru_p3k', 'a_golruang.pangkat')
					->leftJoin('a_golruang', 'a_gaji_pppk.pkt', '=', 'a_golruang.idgolru')
                    ->orWhere('gaji', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('dasarhukum', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('ket', 'LIKE', '%'.Input::get('search').'%')
                    ->orderBy('a_gaji_pppk.tahun', 'desc')
                    ->orderBy('a_gaji_pppk.pkt', 'desc')
                    ->orderBy('a_gaji_pppk.msk', 'desc')
					->paginate($_ENV['configurations']['list-limit']);
                    
		return View::make('mastergaji::index_p3k', compact('gajip3ks'));
	}
    
}
