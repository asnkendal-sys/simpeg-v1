<?php

namespace App\Modules\konversidata\konversipppk\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PPPK\Konversi;
use App\Models\PPPK\PPPKExcel;
use Input, View, Request, Form, File, DB;
use Maatwebsite\Excel\Facades\Excel;


class KonversipppkController extends Controller
{
    protected $konversi;

    public function __construct(Konversi $konversi)
    {
        $this->konversi = $konversi;
    }

    public function getIndex()
    {
        cekAjax();
        if (strlen(Input::has('search')) > 0) {
            $pppk_excel = PPPKExcel::select(\DB::raw('excel, updated_at, COUNT(*) AS jml, SUM(IF(STATUS = 3, 1, 0)) berhasil, SUM(IF(STATUS != 3, 1, 0)) gagal'))
                ->where('excel', 'like', '%' . Input::get('search') . '%')
                ->orWhere('excel_2', 'like', '%' . Input::get('search') . '%')
                ->orderBy('updated_at', 'desc')
                ->groupBy('excel_2')
                ->paginate(50);
        } else {
            $pppk_excel = PPPKExcel::select(\DB::raw('excel, updated_at, COUNT(*) AS jml, SUM(IF(STATUS = 3, 1, 0)) berhasil, SUM(IF(STATUS != 3, 1, 0)) gagal'))
                ->orderBy('updated_at', 'desc')->groupBy('excel_2')->paginate(50);
        }

        //$pppk_excel = PPPKExcel::all();
        return View::make('konversipppk::index', compact('pppk_excel'));
    }

    public function getCreate()
    {
        cekAjax();
        return View::make('konversipppk::create');
    }

    public function postCreate()
    {
        // echo "Fitur ini sedang dalam perbaikan";
        cekAjax();
        $input = Input::all();
        $inputs['user_id'] = \Session::get('user_id');
        $inputs['role_id'] = \Session::get('role_id');

        $filename = '';
        $filename_original = '';
        if (Input::hasFile('konversi')) {
            $destinationPath = base_path() . '/packages/upload/excel/mpppk';
            $mode = 0777;
            $recursive = false;
            $file = Input::file('konversi');
            if ($file != '') {
                $destinationPath = str_replace("\\", '/', $destinationPath);
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, $mode, $recursive);
                }

                $tipefile = $file->getClientOriginalExtension();
                $filename_new = 'pppk_' . date('Ymd') . $filename_original . str_random(5) . '.' . $tipefile;
                @unlink($destinationPath . '/' . $filename_new);
                $file->move($destinationPath, $filename_new);
                $filename = $filename_new;
                $file_path = $destinationPath . '/' . $filename_new;
                $filename_original = $file->getClientOriginalName();
            }
        }

        echo $filename_original;

        if ($filename_original != '') {
            $x = 0;
            $y = 0;
            $execution_time = 0;
            $data = Excel::load($file_path, function ($reader) {})->get();
            if (!empty($data) && $data->count()) {
                $time_start = microtime(true);
                $simpan = 0;
                $konversi = 0;
                $pegawai = 0;
                $riwayat = 0;
                // print_r($data);
                foreach ($data as $key => $value) {
                    if (trim($value->nip_baru, " ") != '') {
                        $PPPKExcel = PPPKExcel::firstOrNew([
                            'NIP_BARU' => $value->nip_baru,
                            'excel_2' => $filename_new
                        ]);

                        $PPPKExcel->NO = $value->no;
                        $PPPKExcel->NO_PESERTA = $value->no_peserta;
                        $PPPKExcel->NIP_BARU = $value->nip_baru;
                        $PPPKExcel->NO_PERTIMBANGAN = $value->no_pertimbangan;
                        $PPPKExcel->TGL_PERTIMBANGAN = $value->tgl_pertimbangan;
                        $PPPKExcel->NAMA = $value->nama;
                        $PPPKExcel->TEMPAT_LAHIR = $value->tempat_lahir;
                        $PPPKExcel->TGL_LAHIR = $value->tgl_lahir;
                        $PPPKExcel->JENKEL = $value->jenkel;
                        $PPPKExcel->AGAMA = $value->agama;
                        $PPPKExcel->JENIS_DOKUMEN = $value->jenis_dokumen;
                        $PPPKExcel->NO_DOKUMEN = $value->no_dokumen;
                        $PPPKExcel->ALAMAT = $value->alamat;
                        $PPPKExcel->STATUS_PERKAWINAN = $value->status_perkawinan;
                        $PPPKExcel->NO_SURAT_DOKTER = $value->no_surat_dokter;
                        $PPPKExcel->TGL_SURAT_DOKTER = $value->tgl_surat_dokter;
                        $PPPKExcel->NO_SURAT_BEBAS_NARKOBA = $value->no_surat_bebas_narkoba;
                        $PPPKExcel->TGL_SURAT_NARKOBA = $value->tgl_surat_narkoba;
                        $PPPKExcel->NO_SURAT_KEPOLISIAN = $value->no_surat_kepolisian;
                        $PPPKExcel->TGL_SURAT = $value->tgl_surat;
                        $PPPKExcel->GOLRU = $value->golru;
                        $PPPKExcel->TMT_CPNS = $value->tmt_cpns;
                        $PPPKExcel->GAJI_POKOK = $value->gaji_pokok_rp;
                        $PPPKExcel->TKT_PENDIDIKAN = $value->tkt_pendidikan;
                        $PPPKExcel->PENDIDIKAN = $value->pendidikan;
                        $PPPKExcel->NO_IJAZAH = $value->no_ijazah;
                        $PPPKExcel->TGL_TAHUN_LULUS = $value->tgl_tahun_lulus;
                        $PPPKExcel->NAMA_SEKOLAH = $value->nama_sekolah;
                        $PPPKExcel->IDSAPK_JABATAN = $value->idsapk_jabatan;
                        $PPPKExcel->JABATAN_CPNS = $value->jabatan_cpns;
                        $PPPKExcel->SATUAN_KERJA = $value->satuan_kerja;
                        $PPPKExcel->IDSAPK_SKPD = $value->idsapk_skpd;
                        $PPPKExcel->UNIT_KERJA = $value->unit_kerja;
                        $PPPKExcel->WILAYAH_KANREG = $value->wilayah_kanreg;
                        $PPPKExcel->KPPN = $value->kppn;
                        $PPPKExcel->NO_USUL = $value->no_usul;
                        $PPPKExcel->TGL_USUL = $value->tgl_usul;
                        $PPPKExcel->TMS = $value->tms_btl;
                        $PPPKExcel->MK_TAHUN = $value->mk_tahun;
                        $PPPKExcel->MK_BULAN = $value->mk_bulan;
                        $PPPKExcel->NO_SK = $value->no_sk;
                        $PPPKExcel->TGL_SK = $value->tgl_sk;
                        $PPPKExcel->UNOR_INDUK = $value->unor_induk;
                        $PPPKExcel->ORANG_ID = $value->orang_id_pns_id_pppk_id;
                        $PPPKExcel->jenisjabatan = $value->jenis_jabatan;
                        $PPPKExcel->PENETAP_SK = trim($value->penetap_sk);
                        $PPPKExcel->NO_SK_CPPPK = $value->no_sk_cpppk;
                        $PPPKExcel->TGL_SK_CPPK = $value->tgl_sk_cppk;
                        $PPPKExcel->NO_SK_PERJANJIAN = $value->no_sk_perjanjian;
                        $PPPKExcel->TGL_SK_PERJANJIAN = $value->tgl_sk_perjanjian;
                        $PPPKExcel->TMT_AWAL = $value->tmt_awal;
                        $PPPKExcel->TMT_AKHIR = $value->tmt_akhir;
                      $PPPKExcel->GELAR_DEPAN = $value->gelar_depan;
                        $PPPKExcel->GELAR_BELAKANG = $value->gelar_belakang;
$PPPKExcel->STATUS_PEGAWAI = $value->status_pegawai;
                        $PPPKExcel->excel = $filename_original;
                        $PPPKExcel->status = 0;

                       

                        if ($PPPKExcel->save() == 1) {
                            
                            $simpan++;
                            $PPPKExcel->konversi();
                            if ($PPPKExcel->status == 1) {
                                $konversi++;
                                $PPPKExcel->simpanPegawai();
                                
                                
                                if ($PPPKExcel->status == 2) {
                                    $pegawai++;
                                    $PPPKExcel->simpanRiwayat();
                                    if ($PPPKExcel->status == 3) {
                                        $riwayat++;
                                    }
                                }
                            }
                        }

                        $x++;
                    }
                }

                // return $riwayat . ' berhasil dikonversi, dari ' . $x . ' data!';
            } else {
                return "Gagal Disimpan";
            }
        }
        // return 'Gagal Disimpan';
    }

    // function postData(){
    //     cekAjax();
    //     $data['attr'] = \DB::table('a_konversidata')->where('filename', Input::get('file'))->first();
    //     if(Input::get('status') == 1){
    //         $data['alert'] = 'alert-success';
    //         $data['title'] = 'KONVERSI BERHASIL';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->where('status', 1)->get();
    //     }else if(Input::get('status') == 2){
    //         $data['alert'] = 'alert-danger';
    //         $data['title'] = 'KONVERSI GAGAL';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->where('status', 2)->get();
    //     }else{
    //         $data['alert'] = 'alert-warning';
    //         $data['title'] = 'KONVERSI';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->get();
    //     }

    //     $view = Request::segment(4);
    //     return View::make('konversipppk::'.$view.'_data', $data);
    // }

    // function postExcel(){
    //     /*cekAjax();*/
    //     if(Input::get('status') == 1){
    //         $data['file'] = 'konversi_berhasil';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->where('status', 1)->get();
    //     }else if(Input::get('status') == 2){
    //         $data['file'] = 'konversi_gagal';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->where('status', 2)->get();
    //     }else{
    //         $data['file'] = 'konversi';
    //         $data['rs'] = \DB::table('a_konversidata_mpppk_hostory')->where('filename', Input::get('file'))->get();
    //     }

    //     $view = Request::segment(4);
    //     return View::make('konversipppk::'.$view.'_excel', $data);
    // }

    //{controller-show}

    public function getEdit($id = false)
    {
        cekAjax();
        $id = ($id == false) ? Input::get('id') : '';
        $konversi = $this->konversi->find($id);
        //if (is_null($konversi)){return \Redirect::to('konversidata/konversi/index');}
        return View::make('konversipppk::edit', compact('konversi'));
    }

    public function postEdit()
    {
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, Konversi::$rules);

        if ($validation->passes()) {
            $konversi = $this->konversi->find($id);
            echo ($konversi->update($input)) ? 4 : "Gagal Disimpan";
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postDelete()
    {
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->konversi->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        } else {
            echo ($this->konversi->find($ids)->delete()) ? 9 : 'Gagal Dihapus';
        }
    }
}
