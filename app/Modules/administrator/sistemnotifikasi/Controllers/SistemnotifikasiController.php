<?php namespace App\Modules\administrator\sistemnotifikasi\Controllers;

require 'tugumuda-notifications/vendor/autoload.php';

use Tugumuda\Notifications\Notification;
use Tugumuda\Notifications\Access;
use App\Http\Controllers\Controller;
use App\Modules\administrator\sistemnotifikasi\Models\SistemnotifikasiModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Sistemnotifikasi Controller
 * @var Sistemnotifikasi
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Divisi Software Development - Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class SistemnotifikasiController extends Controller {
    protected $sistemnotifikasi;

    public function __construct(SistemnotifikasiModel $sistemnotifikasi){
        $this->sistemnotifikasi = $sistemnotifikasi;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $sistemnotifikasis = $this->sistemnotifikasi
                    ->orWhere('title', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('notification', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('tgl_publish', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('flag', 'LIKE', '%'.Input::get('search').'%')
                    ->orWhere('publish_at', 'LIKE', '%'.Input::get('search').'%')

                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $sistemnotifikasis = $this->sistemnotifikasi->all();
            }
        }else{
            $sistemnotifikasis = $this->sistemnotifikasi->all();
        }
        return View::make('sistemnotifikasi::index', compact('sistemnotifikasis'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('sistemnotifikasi::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SistemnotifikasiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            $input['tgl_publish'] = date('Y-m-d H:i:s', strtotime(Input::get('tgl_publish')));

            echo ($this->sistemnotifikasi->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $sistemnotifikasi = $this->sistemnotifikasi->find($id);
        //if (is_null($sistemnotifikasi)){return \Redirect::to('administrator/sistemnotifikasi/index');}
        return View::make('sistemnotifikasi::edit', compact('sistemnotifikasi'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, SistemnotifikasiModel::$rules);

        if ($validation->passes()){
            $input['tgl_publish'] = date('Y-m-d H:i:s', strtotime(Input::get('tgl_publish')));
            $sistemnotifikasi = $this->sistemnotifikasi->find($id);
            echo ($sistemnotifikasi->update($input))?4:"Gagal Disimpan";
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
                $this->sistemnotifikasi->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->sistemnotifikasi->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    public function postData()
    {
        cekAjax();
        $view = Request::segment(4);
        return View::make('sistemnotifikasi::'.$view.'_data');
    }

    /*function delete penerima*/
    public function postDeletepenerima(){
        cekAjax();
        $ids = Input::get('id');
        echo (\DB::table('tr_notification_system_penerima')->where('id', $ids)->delete())?9:'Gagal Dihapus';
    }

    /*function untuk simpan penerima notifikasi*/
    function postSavepenerimanotif(){
        cekAjax();
        $input = Input::all();
        $idnotifikasi = $input['idnotifikasi'];
        $idkategori = $input['idkategori'];
        $penerima = $input['penerima'];
        unset($input['_token']);
        switch ($idkategori) {
            case 1 :
                echo (\DB::table('tr_notification_system_penerima')->insert($input))?4:"Gagal Disimpan";
                break;
            case 2 :
                $post = array();
                foreach($penerima as $item){
                    if($item!=''){
                        $data[] = array(
                            'idnotifikasi' => $idnotifikasi,
                            'idkategori' => $idkategori,
                            'penerima' => $item,
                            'user_id' => \Session::get('user_id'),
                            'role_id' => \Session::get('role_id'),
                            'updated_at' => sekarang()
                        );
                    }
                }
                array_push($post,$data);
                echo (\DB::table('tr_notification_system_penerima')->insert($data))?4:"Gagal Disimpan";
                break;
            case 3 :
                $post = array();
                foreach($penerima as $item){
                    if($item!=''){
                        $data[] = array(
                            'idnotifikasi' => $idnotifikasi,
                            'idkategori' => $idkategori,
                            'penerima' => $item,
                            'user_id' => \Session::get('user_id'),
                            'role_id' => \Session::get('role_id'),
                            'updated_at' => sekarang()
                        );
                    }
                }
                array_push($post,$data);
                echo (\DB::table('tr_notification_system_penerima')->insert($data))?4:"Gagal Disimpan";
                break;
            case 4 :
                $post = array();
                $filename = '';
                $filename_original = '';
                if (Input::hasFile('penerima')){
                    $destinationPath = base_path().'/packages/upload/excel/notifikasi';
                    $mode = 0777;
                    $recursive = false;
                    $file = Input::file('penerima');
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
                    $datax = Excel::load($file_path, function($reader) {})->get();
                    if(!empty($datax) && $datax->count()){
                        $time_start = microtime(true);
                        foreach ($datax as $key => $value) {
                            if($value->nip != ''){
                                $data[] = array(
                                    'idnotifikasi' => $idnotifikasi,
                                    'idkategori' => $idkategori,
                                    'penerima' => $value->nip,
                                    'user_id' => \Session::get('user_id'),
                                    'role_id' => \Session::get('role_id'),
                                    'updated_at' => sekarang()
                                );
                            }
                        }
                        array_push($post,$data);
                        echo (\DB::table('tr_notification_system_penerima')->insert($data))?4:"Gagal Disimpan";
                    }
                }else{
                    echo "Gagal Disimpan";
                }

                break;
            default: echo 'Kategori Penerima harus diisi.';
        }
    }

    /*function untuk kirim notifikasi*/
    public function postSavenotifkirim(){
        $x = 0;
        $idnotifikasi = Input::get('idnotifikasi');
        $rsnotifikasi = \DB::table('tr_notification_system')->where('id', $idnotifikasi)->first();

        $x1 = 0; $x2 = 0; $x3 = 0;
        $where1 = ''; $where2 = ''; $where3 = '';
        $data = array();
        $penerima = '';

        $rs1 = \DB::table('tr_notification_system_penerima')->where('idnotifikasi', $idnotifikasi)->where('idkategori', 1);
        $rs2 = \DB::table('tr_notification_system_penerima')->where('idnotifikasi', $idnotifikasi)->where('idkategori', 2);
        $rs3 = \DB::table('tr_notification_system_penerima')->where('idnotifikasi', $idnotifikasi)->where('idkategori','>=',3);

        $count1 = $rs1->count();
        $count2 = $rs2->count();
        $count3 = $rs3->count();

        /*kondisi semua opd*/
        if($count1 > 0){
            $rspenerima1 = \DB::table('tb_01')
                    ->select('nip', 'nama', 'fcm_token')
                    ->where('fcm_token', '!=', '')
                    ->whereRaw("idjenkedudupeg not in (99,21)")
                    ->get();

            $data = array_merge($data,$rspenerima1);
        }

        /*echo "<pre>";
            print_r($rspenerima1);
        echo "</pre>";
        exit();*/

        /*kondisi opd tertentu*/
        if($count2 > 0){
            foreach($rs2->get() as $item){
                $x2++;
                $where2 .= "idskpd like \"".$item->penerima."%\"".(($x2==$count2)?'':' or ');
            }
            $rspenerima2 = \DB::table('tb_01')
                ->select('nip', 'nama', 'fcm_token')
                ->where('fcm_token', '!=', '')
                ->whereRaw($where2)
                ->get();

            $data = array_merge($data,$rspenerima2);
        }

        /*echo "<pre>";
            print_r($rspenerima2);
        echo "</pre>";
        exit();*/

        /*kondisi pegawai tertentu*/
        if($count3 > 0){
            foreach($rs3->get() as $item){
                $x3++;
                $where3 .= "'".$item->penerima."'".(($x3==$count3)?'':', ');
            }
            $rspenerima3 = \DB::table('tb_01')
                ->select('nip', 'nama', 'fcm_token')
                ->where('fcm_token', '!=', '')
                ->whereRaw('nip in ('.$where3.')')
                ->get();

            $data = array_merge($data,$rspenerima3);
        }

        /*echo "<pre>";
        print_r($rspenerima3);
        echo "</pre>";
        exit();*/

        $receipent = array();
        $jumlah = count($data);
        if($jumlah > 0){
            foreach ($data as $item) {
                $receipent[$x] = $item->fcm_token;
                $x++;
            }

            $notif = (new Notification())->api('POST', $_ENV['API_CUTI'].'/notifications')
                ->withBody(['fcm_token'=> $receipent,'title' => $rsnotifikasi->title, 'body' =>$rsnotifikasi->notification, 'id_notification' => $idnotifikasi])
                ->send();

            /*echo "<pre>";
            print_r($notif);
            echo "</pre>";
            exit();*/

            if($notif->status == '200'){
                /*update data notifikasi terkirim*/
                \DB::table('tr_notification_system')
                    ->where('id', $idnotifikasi)
                    ->update(array('flag'=>1, 'publish_at'=>sekarang()));

                echo 4;
            }else{
                echo "Terjadi Kesalahan";
            }
        }else{
            echo "Pengguna SIKEP tidak ditemukan.";
        }
    }
}
