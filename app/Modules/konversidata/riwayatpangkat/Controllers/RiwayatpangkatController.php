<?php namespace App\Modules\konversidata\riwayatpangkat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\riwayatpangkat\Models\RiwayatpangkatModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Riwayatpangkat Controller
* @var Riwayatpangkat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatpangkatController extends Controller {
    protected $riwayatpangkat;

    public function __construct(RiwayatpangkatModel $riwayatpangkat){
        $this->riwayatpangkat = $riwayatpangkat;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $riwayatpangkats = $this->riwayatpangkat
                    ->where('konversi', 5)
                			->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $riwayatpangkats = $this->riwayatpangkat->all();
            }
        }else{
            $riwayatpangkats = $this->riwayatpangkat->all();
        }
        return View::make('riwayatpangkat::index', compact('riwayatpangkats'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('riwayatpangkat::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatpangkatModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/rpangkat';
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
                            'idgolru'  => $value->idgolru,
                            'pejmenpkt'  => $value->pejmenpkt,
                            'nosk'  => $value->nosk,
                            'tgsk'  => $value->tgsk,
                            'tmtpkt'  => $value->tmtpkt,
                            'gapok'  => $value->gapok,
                            'thkerja'  => $value->thkerja,
                            'blkerja'  => $value->blkerja,
                            'stspangkat'  => $value->stspangkat,
                            'user_id' => $value->user_id,
                            'role_id' => $value->role_id,
                            'created_at' => $value->created_at,
                            'updated_at' => $value->updated_at,
                        ];

                        if($value->nip != ''){
                            $cek = \DB::table('r_gol')->where('id', $value->id)->count();
                            if($cek > 0){
                                if(\DB::table('r_gol')->where('id', $value->id)->update($insert)){
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pangkat')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pangkat')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }else{
                                if(\DB::table('r_gol')->insert($insert)){
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pangkat')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->id, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pangkat')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 5;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->riwayatpangkat->create($inputs))?1:"Gagal Disimpan";
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
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatpangkat::'.$view.'_data', $data);
    }

    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){
            $data['file'] = 'konversipangkat_berhasil';
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversipangkat_gagal';
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['file'] = 'konversipangkat';
            $data['rs'] = \DB::table('a_konversidata_pangkat')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatpangkat::'.$view.'_excel', $data);
    }


    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $riwayatpangkat = $this->riwayatpangkat->find($id);
        //if (is_null($riwayatpangkat)){return \Redirect::to('konversidata/riwayatpangkat/index');}
        return View::make('riwayatpangkat::edit', compact('riwayatpangkat'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatpangkatModel::$rules);
        
        if ($validation->passes()){
            $riwayatpangkat = $this->riwayatpangkat->find($id);
            echo ($riwayatpangkat->update($input))?4:"Gagal Disimpan";
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
                $this->riwayatpangkat->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->riwayatpangkat->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
