<?php namespace App\Modules\konversidata\riwayatpppk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\riwayatpppk\Models\RiwayatpppkModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Riwayatpppk Controller
* @var Riwayatpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatpppkController extends Controller {
    protected $riwayatpppk;

    public function __construct(RiwayatpppkModel $riwayatpppk){
        $this->riwayatpppk = $riwayatpppk;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $riwayatpppks = $this->riwayatpppk
                    ->where('konversi', 8)
                			->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $riwayatpppks = $this->riwayatpppk->all();
            }
        }else{
            $riwayatpppks = $this->riwayatpppk->all();
        }
        return View::make('riwayatpppk::index', compact('riwayatpppks'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('riwayatpppk::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatpppkModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/rpppk';
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
                              // 'id_konversi' => $value->no,
                              'nip' => $value->nip,
                              'niplama' => $value->niplama,
                              'nipbaru' => $value->nipbaru,
                              'nosk_calon' => $value->nosk_calon,
                              'tglsk_calon' => date('Y-m-d', strtotime($value->tglsk_calon)),
                              'nosk_pppk' => $value->nosk_pppk,
                              'tglsk_pppk' => date('Y-m-d', strtotime($value->tglsk_pppk)),
                              'idjab' => $value->idjab,
                              'jab' => $value->jab,
                              // 'jabtext' => $value->jabtext,
                              // 'kdunit' => substr($value->idskpd,0,2),
                              'kdunit' => $value->kdunit?$value->kdunit:'',
                              'idskpd' => $value->idskpd,
                              'skpd' => $value->skpd,
                              'idgolru' => $value->idgolru,
                              'golru' => $value->golru,
                              'thkerja' => $value->thkerja,
                              'blkerja' => $value->blkerja,
                              'gaji' => $value->gaji,
                              'tmtawal' => date('Y-m-d', strtotime($value->tmtawal)),
                              'tmtakhir' => date('Y-m-d', strtotime($value->tmtakhir)),
                              'idjenjab' => $value->idjenjab,
                              'nosk' => $value->nosk,
                              'tgsk' => date('Y-m-d', strtotime($value->tgsk)),
                              'nopak' => $value->nopak,
                              'pejmen' => $value->pejmen,
                              'iskepsek' => $value->iskepsek,
                              'idkepsek' => $value->idkepsek,
                              'tmtkepsek' => date('Y-m-d', strtotime($value->tmtkepsek)),
                              'noskkepsek' => $value->noskkepsek,
                              'idtugasdokter' => $value->idtugasdokter,
                              'idtugasgurudosen' => $value->idtugasgurudosen,
                              'idmatkulpel' => $value->idmatkulpel,
                              'matkulpel' => $value->matkulpel,
                              'isdiperbantukan' => $value->isdiperbantukan,
                              'iddiperbantukan' => $value->iddiperbantukan,
                              'idesl' => $value->idesl,
                              'esl' => $value->esl,
                              'tmtesljbt' => date('Y-m-d', strtotime($value->tmtesljbt)),
                              'stsesl' => $value->stsesl,
                              'iddesa' => $value->iddesa,
                              'nmadesa' => $value->nmadesa,
                              'sts_kontrak' => $value->sts_kontrak,
                              
                        //     'tmtjab' => $value->tmtjab,
                        //     'idesl' => $value->idesl,
                        //     'nopak' => $value->nopak,
                        //     'idesljbt' => $value->idesljbt,
                        //     'esl' => $value->esl,
                        //     'user_id' => $value->user_id,
                        //     'role_id' => $value->role_id,
                        //     'created_at' => $value->created_at,
                        //     'updated_at' => $value->updated_at,
                        ];

                        if($value->nip != ''){
                            $cek = \DB::table('r_pppk')->where('id', $value->no)->count();
                            if($cek > 0){
                                if(\DB::table('r_pppk')->where('id', $value->no)->update($insert)){
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pppk')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pppk')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }else{
                                if(\DB::table('r_pppk')->insert($insert)){
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status_konv' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pppk')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status_konv' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_pppk')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 8;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->riwayatpppk->create($inputs))?1:"Gagal Disimpan";
            }else{
                echo "Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){
            $data['file'] = 'konversijab_berhasil';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversipppk_gagal';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['file'] = 'konversipppk';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatpppk::'.$view.'_excel', $data);
    }

    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $riwayatpppk = $this->riwayatpppk->find($id);
        //if (is_null($riwayatpppk)){return \Redirect::to('konversidata/riwayatpppk/index');}
        return View::make('riwayatpppk::edit', compact('riwayatpppk'));
    }

    function postData(){
        cekAjax();
        $data['attr'] = \DB::table('a_konversidata')->where('filename', Input::get('file'))->first();
        if(Input::get('status') == 1){
            $data['alert'] = 'alert-success';
            $data['title'] = 'KONVERSI BERHASIL';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->where('status_konv', 1)->get();
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->where('status_konv', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_pppk')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('riwayatpppk::'.$view.'_data', $data);
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RiwayatpppkModel::$rules);
        
        if ($validation->passes()){
            $riwayatpppk = $this->riwayatpppk->find($id);
            echo ($riwayatpppk->update($input))?4:"Gagal Disimpan";
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
                $this->riwayatpppk->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->riwayatpppk->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
