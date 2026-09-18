<?php namespace App\Modules\konversidata\konversigelar\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\konversigelar\Models\KonversigelarModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Konversigelar Controller
* @var Konversigelar
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class KonversigelarController extends Controller {
    protected $konversigelar;

    public function __construct(KonversigelarModel $konversigelar){
        $this->konversigelar = $konversigelar;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $konversigelars = $this->konversigelar
                    ->where('konversi', 1)
                			->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')
                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $konversigelars = $this->konversigelar->all();
            }
        }else{
            $konversigelars = $this->konversigelar->all();
        }
        return View::make('konversigelar::index', compact('konversigelars'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('konversigelar::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KonversigelarModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/gelar';
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
                        $update = ['gdp' => $value->gdp, 'gdb' => $value->gdb]; $where = ['nip' => $value->nip];
                        if(\DB::table('tb_01')->where($where)->update($update)){
                            $insert = ['id_konversi' => $value->id, 'filename' => $filename, 'niplama' => $value->niplama, 'nip' => $value->nip, 'gdp' => $value->gdp, 'gdb' => $value->gdb, 'status' => 1];
                            if(\DB::table('a_konversidata_gelar')->insert($insert)){
                                $x++;
                            }                            
                        }else{                                                        
                            $insert = ['id_konversi' => $value->id, 'filename' => $filename, 'niplama' => $value->niplama, 'nip' => $value->nip, 'gdp' => $value->gdp, 'gdb' => $value->gdb, 'status' => 2];
                            if(\DB::table('a_konversidata_gelar')->insert($insert)){
                                $y++;
                            }                            
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 1;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->konversigelar->create($inputs))?1:"Gagal Disimpan";
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
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->where('status', 1)->get();            
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->get();
        }        
        
        $view = Request::segment(4);
        return View::make('konversigelar::'.$view.'_data', $data);
    }
    
    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){             
            $data['file'] = 'konversigelar_berhasil';
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->where('status', 1)->get();            
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversigelar_gagal';
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['file'] = 'konversigelar';
            $data['rs'] = \DB::table('a_konversidata_gelar')->where('filename', Input::get('file'))->get();
        }        
        
        $view = Request::segment(4);
        return View::make('konversigelar::'.$view.'_excel', $data);        
    }
    
    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $konversigelar = $this->konversigelar->find($id);
        //if (is_null($konversigelar)){return \Redirect::to('konversidata/konversigelar/index');}
        return View::make('konversigelar::edit', compact('konversigelar'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, KonversigelarModel::$rules);
        
        if ($validation->passes()){
            $konversigelar = $this->konversigelar->find($id);
            echo ($konversigelar->update($input))?4:"Gagal Disimpan";
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
                $this->konversigelar->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->konversigelar->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    public function getHistori($id = false){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $konversigelars = $this->konversigelar
                    ->orWhere('konversi', 'LIKE', '%'.Input::get('search').'%')

                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $konversigelars = $this->konversigelar->all();
            }
        }else{
            $konversigelars = $this->konversigelar->all();
        }
        return View::make('konversigelar::histori', compact('konversigelars'));
    }

    public function getExcel(){
            $input = ''; $s_pokok = ''; $s_wajib = '';
            $file = '/packages/upload/excel/gelar/gdb.xls';
                   
            /*Excel::load($file, function ($reader)use($input,$s_pokok,$s_wajib){

                $reader->each(function($sheet)use($input,$s_pokok,$s_wajib) {
                    foreach ($sheet->toArray() as $key => $value) {
                        if(!empty($value)){
                            foreach ($value as $v) {
                                echo $v['niplama']." - ".$v['nip']." - ".$v['gdp']." - ".$v['gdp'];
                            }
                        }
                    }
                });
            });*/

            /*$path = './packages/upload/excel/gdb.xls';
            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){
                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        foreach ($value as $v) {
                            echo $v[1]." - ".$v[2]." - ".$v[3];
                        }
                    }
                }
                if(!empty($insert)){
                    echo "Gagal";
                }
            }*/

            $path = './packages/upload/excel/gelar/vvx2gFp.xls';
            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    echo $value['nip']." - ".$value['gdp']." - ".$value['gdb']."<br>";
                    /*echo "<pre>";
                        print_r($value);
                    echo "</pre>";*/
                }

                if(!empty($insert)){
                    /*DB::table('items')->insert($insert);
                    dd('Insert Record successfully.');*/
                    echo "Gagal";
                }
            }
    }

    public function postUpload(){
        cekAjax();
        $s_pokok = \DB::table('mst_jenis_simpanan')->where('id','=',1)->first();
        $s_wajib = \DB::table('mst_jenis_simpanan')->where('id','=',2)->first();

        $input = Input::all();
        $row['tanggal'] = date('Y-m-d');
        $validation = \Validator::make($input, SimpananModel::$rules);
        if ($validation->passes()){
            $row['user_id'] = \Session::get('user_id');
            $row['role_id'] = \Session::get('role_id');
            $file='';
            if (Input::hasFile('file')){
                $destinationPath = base_path().'/packages/upload/excel/'.\Session::get('user_id');
                $mode = 0777;
                $recursive = false;
                $f = Input::file('file');
                if($f != ''){
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    if(!is_dir($destinationPath)){
                        mkdir($destinationPath, $mode, $recursive);
                    }
                    //                die($destinationPath);
                    $tipefile = $f->getClientOriginalExtension();
                    $filename = str_replace(' ', '-', $f->getClientOriginalName());
                    @unlink($destinationPath.'/'.$filename);
                    $f->move($destinationPath, $filename);
                    $file= $destinationPath.'/'.$filename;
                    // $input['foto'] = $filename;
                }
            }else{
            }
            //debug($destinationPath);
            Excel::load($file, function ($reader)use($input,$s_pokok,$s_wajib){

                $reader->each(function($sheet)use($input,$s_pokok,$s_wajib) {
                    /* Cari anggota */
                    $anggota = array();
                    /* $anggota = \DB::table('mst_pegawai')->get();
                                 foreach($anggota as $ag){
                                     $anggo[$ag->kode]=$ag;
                                 } */
                    // debug($sheet);
                    foreach ($sheet->toArray() as $row) {
                        $temp = array();
                        $tes = array();
                        // sort($row);

                        foreach($row as $r){
                            $temp[]=$r;
                        }
                        $anggota = \DB::table('mst_anggota')->where('no','=',$temp[0])->first();


                        /*  foreach($anggota as $apa){
                                   $tes[]=$apa;
                               } */

                        $cek = \DB::table('tr_simpanan')->where('id_anggota','=',@$anggota->id)->count();
                        if($cek>0){
                            $sp = 0;
                            $sw = $s_wajib->duit;
                            $ss = $temp[2]-$s_wajib->duit;
                        }else{
                            $sp = ($temp[2]-$s_pokok->duit<0)?0:$s_pokok->duit;
                            $sw = ($temp[2]-$s_pokok->duit >=$s_wajib->duit)?$s_wajib->duit:0;
                            $ss = ($temp[2]-($s_wajib->duit+$s_pokok->duit)>0)?($temp[2]-($s_wajib->duit+$s_pokok->duit)):0;
                        }

                        $urutan = \SimpananModel::where('bulan','=',$input['bulan'])
                            ->where('tahun','=',$input['tahun'])->count()+1;
                        //	debug($temp);
                        //	debug($anggo);
                        if($sp==0 and $sw==0 and $ss==0){

                        }else{
                            \DB::table('tr_simpanan')->insert(array(
                                    'no_transaksi'		=>	'TSX1'.str_pad($input['bulan'],2,"0",STR_PAD_LEFT).''.substr($input['tahun'],2,2).''.str_pad($urutan,4,"0",STR_PAD_LEFT),
                                    'tanggal'		=>	date('Y-m-d'),
                                    'bulan'			=>	$input['bulan'],
                                    'tahun'			=>	$input['tahun'],
                                    'id_anggota'	=>	@$anggota->id,
                                    'sp'			=>	$sp,
                                    'sw'			=>	$sw,
                                    'ss'			=>	$ss,
                                    'id_jns_transaksi'			=>	1,
                                    'created_at'	=>	sekarang(),
                                    'user_id'		=>	\Session::get('user_id'),
                                    'role_id'		=>	\Session::get('role_id'))
                            );
                        }
                        //	$this->simpanan->create($row);
                    }
                });
            });
            echo 1;
        }
        else{


            echo 'Input tidak valid';
        }
    }
}
