<?php namespace App\Modules\konversidata\referensipendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\referensipendidikan\Models\ReferensipendidikanModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Referensipendidikan Controller
* @var Referensipendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class ReferensipendidikanController extends Controller {
    protected $referensipendidikan;

    public function __construct(ReferensipendidikanModel $referensipendidikan){
        $this->referensipendidikan = $referensipendidikan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $referensipendidikans = $this->referensipendidikan
                ->where('konversi', 3)
                ->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')
                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $referensipendidikans = $this->referensipendidikan->all();
            }
        }else{
            $referensipendidikans = $this->referensipendidikan->all();
        }
        return View::make('referensipendidikan::index', compact('referensipendidikans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('referensipendidikan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, ReferensipendidikanModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/refpendidikan';
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
                            'idjenjurusan' => $value->idjenjurusan,
                            'jenjurusan' => $value->jenjurusan,
                            'idtkpendid' => $value->idtkpendid,
                            'idgolru' => $value->idgolru,
                            'idfungsional' => $value->idfungsional,
                            'idkeljurusan' => $value->idkeljurusan,
                            'user_id' => $value->user_id,
                            'role_id' => $value->role_id,
                            'created_at' => $value->created_at,
                            'updated_at' => $value->updated_at
                        ];

                        $where = ['idjenjurusan' => $value->idjenjurusan];

                        $cek = \DB::table('a_jenjurusan')->where('idjenjurusan', $value->idjenjurusan)->count();
                        if($cek > 0){
                            if(\DB::table('a_jenjurusan')->where($where)->update($insert)){
                                $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 1];
                                $insert_batch = array_merge($insert, $insert1);
                                if(\DB::table('a_konversidata_refpendidikan')->insert($insert_batch)){
                                    $x++;
                                }
                            }else{
                                $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 2];
                                $insert_batch = array_merge($insert, $insert1);
                                if(\DB::table('a_konversidata_refpendidikan')->insert($insert_batch)){
                                    $y++;
                                }
                            }
                        }else{
                            if(\DB::table('a_jenjurusan')->insert($insert)){
                                $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 1];
                                $insert_batch = array_merge($insert, $insert1);
                                if(\DB::table('a_konversidata_refpendidikan')->insert($insert_batch)){
                                    $x++;
                                }
                            }else{
                                $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 2];
                                $insert_batch = array_merge($insert, $insert1);
                                if(\DB::table('a_konversidata_refpendidikan')->insert($insert_batch)){
                                    $y++;
                                }
                            }
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 3;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->referensipendidikan->create($inputs))?1:"Gagal Disimpan";
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
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->where('status', 1)->get();
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('referensipendidikan::'.$view.'_data', $data);
    }

    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){
            $data['file'] = 'konversi_refpendidikan_berhasil';
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->where('status', 1)->get();
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversi_refpendidikan_gagal';
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['file'] = 'konversi_refpendidikan';
            $data['rs'] = \DB::table('a_konversidata_refpendidikan')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('referensipendidikan::'.$view.'_excel', $data);
    }


    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $referensipendidikan = $this->referensipendidikan->find($id);
        //if (is_null($referensipendidikan)){return \Redirect::to('konversidata/referensipendidikan/index');}
        return View::make('referensipendidikan::edit', compact('referensipendidikan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, ReferensipendidikanModel::$rules);
        
        if ($validation->passes()){
            $referensipendidikan = $this->referensipendidikan->find($id);
            echo ($referensipendidikan->update($input))?4:"Gagal Disimpan";
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
                $this->referensipendidikan->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->referensipendidikan->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function utnuk download referensi pendidikan sekarang*/
    function getExcelreferensi(){
        /*cekAjax();*/
        $data['file'] = 'referensi_jenjurusan';
        $data['rs'] = \DB::table('a_jenjurusan')->orderBy('idjenjurusan')->get();

        return View::make('referensipendidikan::referensi_excel', $data);
    }
}
