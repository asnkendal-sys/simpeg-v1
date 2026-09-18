<?php namespace App\Modules\konversidata\konversicpns\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\konversidata\konversicpns\Models\KonversicpnsModel;
use Input,View, Request, Form, File;
use Maatwebsite\Excel\Facades\Excel;

/**
* Konversicpns Controller
* @var Konversicpns
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class KonversicpnsController extends Controller {
    protected $konversicpns;

    public function __construct(KonversicpnsModel $konversicpns){
        $this->konversicpns = $konversicpns;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $konversicpnss = $this->konversicpns
                    ->where('konversi', 2)
                			->Where('filename_original', 'LIKE', '%'.Input::get('search').'%')
                ->orderBy('created_at', 'desc')
                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $konversicpnss = $this->konversicpns->all();
            }
        }else{
            $konversicpnss = $this->konversicpns->all();
        }
        return View::make('konversicpns::index', compact('konversicpnss'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('konversicpns::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KonversicpnsModel::$rules);
        if ($validation->passes()){
            $inputs['user_id'] = \Session::get('user_id');
            $inputs['role_id'] = \Session::get('role_id');

            $filename = '';
            $filename_original = '';
            if (Input::hasFile('konversi')){
                $destinationPath = base_path().'/packages/upload/excel/cpns';
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
                            'nip' => $value->nip_baru,
                            'nama' => KonversicpnsModel::listName($value->nama,1),
                            //'gdp' => $value->gelar_depan,
                            'gdb' => KonversicpnsModel::listName($value->nama,2),
                            'tmlhr' => $value->tempat_lahir,
                            'tglhr' => date('Y-m-d', strtotime($value->tgl_lahir)), /*tanggal*/
                            'idjenkel' => KonversicpnsModel::idKelamin($value->jenkel), /*plaintex*/
                            'idagama' => KonversicpnsModel::idAgama($value->agama), /*plaintex*/
                            'alm' => $value->alamat,
                            //'idstskawin' => $value->status_perkawinan, /*plaintex*/
                            'idstskawin' => getAttr('a_stskawin', 'stskawin', $value->status_perkawinan, 'idstskawin'), /*plaintex*/
                            'idgolrucpn' => getAttr('a_golruang', 'golru', $value->golru, 'idgolru'), /*plaintext*/
                            'mkthncpn' => $value->mk_tahun,
                            'mkblncpn' => $value->mk_bulan,
                            'tmtcpn' => date('Y-m-d', strtotime($value->tmt_cpns)), /*tanggal*/
                            'tgskcpn' => date('Y-m-d', strtotime($value->tgl_sk)), /*tanggal*/
                            'pejmencpn' => getAttr('a_penetapsk', 'jabatan', $value->pejabat_penetap, 'id'), /*plaintext*/
                            'noskcpn' => $value->no_sk,
                            'idgolrupkt' => getAttr('a_golruang', 'golru', $value->golru, 'idgolru'), /*plaintext*/
                            'mkthnpkt' => $value->mk_tahun,
                            'mkblnpkt' => $value->mk_bulan,
                            'tmtpkt' => date('Y-m-d', strtotime($value->tmt_cpns)), /*tanggal*/
                            'tgskpkt' => date('Y-m-d', strtotime($value->tgl_sk)), /*tanggal*/
                            'pejmenpkt' => getAttr('a_penetapsk', 'jabatan', $value->pejabat_penetap, 'id'), /*plaintext*/
                            'noskpkt' => $value->no_sk,
                            'idtkpendid' => getAttr('a_tkpendid', 'tkpendid', $value->tkt_pendidikan, 'idtkpendid'), /*plaintext*/
                            'idjenjurusan' => getAttr('a_jenjurusan', 'jenjurusan', $value->pendidikan, 'idjenjurusan'), /*plaintext*/
                            'namasekolah' => $value->nama_sekolah,
                            'noijaz' => $value->no_ijazah,
                            'thijaz' => date('Y', strtotime($value->tgl_tahun_lulus)), /*integer tahun*/
                            'idtkpendidawal' => getAttr('a_tkpendid', 'tkpendid', $value->tkt_pendidikan, 'idtkpendid'), /*plaintext*/
                            'idjenjurusanawal' => getAttr('a_jenjurusan', 'jenjurusan', $value->pendidikan, 'idjenjurusan'), /*plaintext*/
                            'noijazawal' => $value->no_ijazah,
                            'thijazawal' => date('Y', strtotime($value->tgl_tahun_lulus)), /*integer tahun*/
                            'idjabfung' => getAttr('a_jabfung', 'jabfung', $value->jabatan_cpns, 'idjabfung'), /*plaintext*/
                            'idjabfungum' => getAttr('a_jabfungum', 'jabfungum', $value->jabatan_cpns, 'idjabfungum'), /*plaintext*/
                            //'kdunit' => $value->unit_kerja, /*kode 2 digit*/
                            //'idskpd' => $value->unit_kerja,
                            'kdunit' => substr(getAttr('a_skpd', 'skpd', $value->unit_kerja, 'idskpd'),0,2), /*kode 2 digit*/
                            'idskpd' => getAttr('a_skpd', 'skpd', $value->unit_kerja, 'idskpd'),
                            'pejmenjbt' => getAttr('a_penetapsk', 'jabatan', $value->pejabat_penetap, 'id'), /*plaintext*/
                            'idsapk' => $value->idsapk_asn,
                            'noskjbt' => $value->no_sk,
                            'tgskjbt' => date('Y-m-d', strtotime($value->tgl_sk)), /*tanggal*/
                            'tmtjbt' => date('Y-m-d', strtotime($value->tmt_cpns)),
                            'idstspeg' => 1, /*$value->status_pegawai*/
                            'idjenkepeg' => 1, /*pns daerah otonom*/
                            'isdiperbantukan' => 2, /*tidak diperbantukan*/
                            'idjenkedudupeg' => 1, /*$value->kedudukan_pegawai*/
                            'usiapens' => 1, /*agar bisa langsung login*/
                            'photo' => 'default.jpg', /*agar bisa langsung login*/
                            'password' => md5(str_replace('-','',$value->tgl_lahir)), /*password login from taggal lahir*/
                            'idjenjab' => KonversicpnsModel::idJenjab($value->jenis_jabatan),
                            'created_at' => sekarang()
                        ];

                        if($value->nip_baru != ''){
                            $cek = \DB::table('tb_01')->where('nip', $value->nip_baru)->count();
                            if($cek > 0){
                                $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 2];
                                $insert_batch = array_merge($insert, $insert1);
                                if(\DB::table('a_konversidata_cpns')->insert($insert_batch)){
                                    $y++;
                                }
                            }else{
                                if(\DB::table('tb_01')->insert($insert)){
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 1];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_cpns')->insert($insert_batch)){
                                        $x++;
                                    }
                                }else{
                                    $insert1 = ['id_konversi' => $value->no, 'filename' => $filename, 'status' => 2];
                                    $insert_batch = array_merge($insert, $insert1);
                                    if(\DB::table('a_konversidata_cpns')->insert($insert_batch)){
                                        $y++;
                                    }
                                }
                            }
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                }

                $inputs['konversi'] = 2;
                $inputs['terkonversi'] = $x;
                $inputs['gagalkonversi'] = $y;
                $inputs['waktu'] = $execution_time;
                $inputs['jumlah_data'] = $data->count();
                $inputs['filename'] = $filename;
                $inputs['file_path'] = $file_path;
                $inputs['filename_original'] = $filename_original;
                echo ($this->konversicpns->create($inputs))?1:"Gagal Disimpan";
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
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->where('status', 1)->get();
        }else if(Input::get('status') == 2){
            $data['alert'] = 'alert-danger';
            $data['title'] = 'KONVERSI GAGAL';
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['alert'] = 'alert-warning';
            $data['title'] = 'KONVERSI';
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('konversicpns::'.$view.'_data', $data);
    }

    function postExcel(){
        /*cekAjax();*/
        if(Input::get('status') == 1){
            $data['file'] = 'konversicpns_berhasil';
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->where('status', 1)->get();
        }else if(Input::get('status') == 2){
            $data['file'] = 'konversicpns_gagal';
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->where('status', 2)->get();
        }else{
            $data['file'] = 'konversicpns';
            $data['rs'] = \DB::table('a_konversidata_cpns')->where('filename', Input::get('file'))->get();
        }

        $view = Request::segment(4);
        return View::make('konversicpns::'.$view.'_excel', $data);
    }

    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $konversicpns = $this->konversicpns->find($id);
        //if (is_null($konversicpns)){return \Redirect::to('konversidata/konversicpns/index');}
        return View::make('konversicpns::edit', compact('konversicpns'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, KonversicpnsModel::$rules);
        
        if ($validation->passes()){
            $konversicpns = $this->konversicpns->find($id);
            echo ($konversicpns->update($input))?4:"Gagal Disimpan";
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
                $this->konversicpns->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->konversicpns->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
