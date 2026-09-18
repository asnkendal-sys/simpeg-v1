<?php namespace App\Modules\konversidata\riwayatdikstru\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\riwayatdikstru\Models\RiwayatdikstruModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Riwayatdikstru Controller
* @var Riwayatdikstru
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatdikstruController extends Controller {
    protected $riwayatdikstru;

    public function __construct(RiwayatdikstruModel $riwayatdikstru){
        $this->riwayatdikstru = $riwayatdikstru;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $riwayatdikstrus = $this->riwayatdikstru
                    ->where('konversi', 6)
                			->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $riwayatdikstrus = $this->riwayatdikstru->all();
            }
        }else{
            $riwayatdikstrus = $this->riwayatdikstru->all();
        }
        return View::make('riwayatdikstru::index', compact('riwayatdikstrus'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('riwayatdikstru::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatdikstruModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/rdikstru';
                $mode = 0777;
                $recursive = false;
                $file = Input::file('konversi');
                if($file != ''){
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    if(!is_dir($destinationPath)){
                        mkdir($destinationPath, $mode, $recursive);
                    }

                    $tipefile = $file->getClientOriginalExtension();
                    $filename_new = str_random(7).'.'.$tipefile;
                    @unlink($destinationPath.'/'.$filename_new);
                    $file->move($destinationPath, $filename_new);
                    $filename = $filename_new;
                    $file_path = $destinationPath.'/'.$filename_new;
                    $filename_original = $file->getClientOriginalName();
                }
            }

            if($filename_original != ''){
                $x = 0; $y = 0; $execution_time = 0;
                $data = Excel::load($file_path, function($reader) {})->get();
                if(!empty($data) && $data->count()){
                    $time_start = microtime(true);
                    foreach ($data as $key => $value) {
                        $insert = [
                            'niplama'  => $value->niplama,
                            'nip'  => $value->nip,
                            'idjendiklat'  => $value->idjendiklat,
                            'laturut'  => $value->laturut,
                            'iddikstru'  => $value->iddikstru,
                            'dikstru'  => $value->dikstru,
                            'penyelenggara'  => $value->penyelenggara,
                            'tmdikstru'  => $value->tmdikstru,
                            'angkatan'  => $value->angkatan,
                            'tgmul'  => $value->tgmul,
                            'tgsel'  => $value->tgsel,
                            'jamhari'  => $value->jamhari,
                            'nosttpdikstru'  => $value->nosttpdikstru,
                            'tgsttpdikstru'  => $value->tgsttpdikstru,
                            'nousul'  => $value->nousul,
                            'latthn'  => $value->latthn,
                            'latsts'  => $value->latsts,
                            'user_id' => $value->user_id,
                            'role_id' => $value->role_id,
                            'created_at' => $value->created_at,
                            'updated_at' => $value->updated_at,
                        ];

                        if($value->nip != ''){
                            $cek = \DB::table('r_dikstru')->where('id', $value->id)->count();
                            if($cek > 0){
                                if(\DB::table('r_dikstru')->where('id', $value->id)->update($insert)){
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_dikstru')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_dikstru')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }else{
                                if(\DB::table('r_dikstru')->insert($insert)){
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_dikstru')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_dikstru')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 6;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->riwayatdikstru->create($inputs))?1:"Gagal Disimpan";
            }else{
                echo "Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    function postData(){
        cekAjax();
        $data['attr'] = \DB::table('a_konversidata')->where('filename', Input::get('file'))->first();
        if(Input::get('status') == 1){
            $data['alert'] = 'alert-success';
            $data['title'] = 'KONVERSI BERHASIL';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatdikstru::'.$view.'_data', $data);
    }

    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){
            $data['file'] = 'konversidikstru_berhasil';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversidikstru_gagal';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['file'] = 'konversidikstru';
            $data['rs'] = \DB::table('a_konversidata_dikstru')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatdikstru::'.$view.'_excel', $data);
    }


    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $riwayatdikstru = $this->riwayatdikstru->find($id);
        //if (is_null($riwayatdikstru)){return \Redirect::to('konversidata/riwayatdikstru/index');}
        return View::make('riwayatdikstru::edit', compact('riwayatdikstru'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatdikstruModel::$rules);
        
        if ($validation->passes()){
            $riwayatdikstru = $this->riwayatdikstru->find($id);
            echo ($riwayatdikstru->update($input))?4:"Gagal Disimpan";
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
                $this->riwayatdikstru->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->riwayatdikstru->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
