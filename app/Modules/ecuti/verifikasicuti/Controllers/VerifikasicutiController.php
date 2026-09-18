<?php namespace App\Modules\ecuti\verifikasicuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\verifikasicuti\Models\VerifikasicutiModel;
use Input,View, Request, Form, File;

/**
* Verifikasicuti Controller
* @var Verifikasicuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class VerifikasicutiController extends Controller {
    protected $verifikasicuti;

    public function __construct(VerifikasicutiModel $verifikasicuti){
        $this->verifikasicuti = $verifikasicuti;
    }

    public function getIndex(){
        cekAjax();
        return View::make('verifikasicuti::index');
    }
    public function postAwal(){
        cekAjax();
        $halaman = Request::segment(4);
        return View::make('verifikasicuti::index', compact($halaman));
    }
    public function getHalamanverifikasiatasan(){
        cekAjax();
        $halaman = 1;
        return View::make('verifikasicuti::index', compact($halaman));
    }
    public function getHalamanverifikasiwewenang(){
        cekAjax();
        $halaman = 2;
        return View::make('verifikasicuti::index', compact($halaman));
    }

    public function getAtasan(){
        $where2 = "tr_ijin_cuti.opd_status = '1' ";
        $where2 .= "AND tr_ijin_cuti.atasan_status != '1'"; 
        // $where2 = "tr_ijin_cuti.opd_status = '1' ";
        
        if (\Session::get('role_id') == 3 || \Session::get('role_id') == 4) {
            $where2 .= "AND tr_ijin_cuti.idskpd like '".\Session::get('idskpd')."%'";
        }
        if (\Session::get('role_id') == 5) {
            $where2 .= "AND (tr_ijin_cuti.atasan_nip = '".\Session::get('user_id')."' OR tr_ijin_cuti.nip = '".\Session::get('user_id')."')";
        }
        /*Khusus Untuk BUPATI dan SEKDA Verifikator adalah ADMIN OPD*/
        if (\Input::get('atasankhusus') == 1) {
            $where2 = "tr_ijin_cuti.opd_status = '1' AND tr_ijin_cuti.atasan_status != 1 AND (tr_ijin_cuti.atasan_nip = '-' OR tr_ijin_cuti.atasan_idskpd = '01') ";
        }

        $where = "tr_ijin_cuti.nousul != ''";
        if (\Input::get('atasankhusus') != "" or Input::has('search') or Input::get('bulan') != '' or Input::get('id_jenis_cuti') != '' or Input::get('idskpd') != '' ) {
            (Input::get('search')!='')?$where.=" and (tr_ijin_cuti.nip like '%".Input::get('search')."%' or tr_ijin_cuti.nama like '%".Input::get('search')."%')":"";
            (Input::get('bulan')!='')?$where.=" and month(tr_ijin_cuti.tgl_usul) = '".Input::get('bulan')."'":"";
            (Input::get('id_jenis_cuti')!='')?$where.=" and tr_ijin_cuti.id_jenis_cuti = '".Input::get('id_jenis_cuti')."'":"";
            (Input::get('idskpd')!='' && \Session::get('role_id') != 4)?$where.=" and tr_ijin_cuti.idskpd = '".Input::get('idskpd')."'":"";

            $atasans = $this->verifikasicuti
            ->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
            ->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->whereRaw($where2)
            ->whereRaw($where)
            ->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
        // ->paginate($_ENV['configurations']['list-limit']);
            ->get();
            
        }else{
            //$atasans = $this->verifikasicuti->all();
            $atasans = $this->verifikasicuti
                ->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
                ->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
                ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                ->whereRaw($where2)
                ->whereRaw($where)
                ->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
            // ->paginate($_ENV['configurations']['list-limit']);
                ->get();
        }
        return View::make('verifikasicuti::atasan', compact('atasans'));
    }

    public function getWewenang(){
        $where2 = "tr_ijin_cuti.atasan_status = 1 ";
        $where2 .= "AND tr_ijin_cuti.wewenang_status != '1'";
        // $where2 = "tr_ijin_cuti.opd_status = '1' ";
        
        if (\Session::get('role_id') == 3 || \Session::get('role_id') == 4) {
            $where2 .= "AND tr_ijin_cuti.idskpd like '".\Session::get('idskpd')."%'";
        }
        if (\Session::get('role_id') == 5) {
            $where2 .= "AND (tr_ijin_cuti.wewenang_nip = '".\Session::get('user_id')."' OR tr_ijin_cuti.nip = '".\Session::get('user_id')."')";
        }

        /*Khusus Untuk BUPATI dan SEKDA Verifikator adalah ADMIN OPD*/
        if (\Input::get('wewenangkhusus') == 2) {
            // $where2 = "tr_ijin_cuti.atasan_status = 1 AND tr_ijin_cuti.wewenang_status != 1 AND (tr_ijin_cuti.wewenang_nip = '-' OR LEFT(tr_ijin_cuti.wewenang_idskpd,2) = '01') ";
            $where2 = "tr_ijin_cuti.wewenang_status != 1 AND (tr_ijin_cuti.wewenang_nip = '-' OR tr_ijin_cuti.wewenang_idskpd = '01') ";
        }

        $where = "tr_ijin_cuti.nousul != ''";
        if (\Input::get('wewenangkhusus') != "" or Input::has('search') or Input::get('bulan') != '' or Input::get('id_jenis_cuti') != '' or Input::get('idskpd') != '' ) {
            (Input::get('search')!='')?$where.=" and (tr_ijin_cuti.nip like '%".Input::get('search')."%' or tr_ijin_cuti.nama like '%".Input::get('search')."%')":"";
            (Input::get('bulan')!='')?$where.=" and month(tr_ijin_cuti.tgl_usul) = '".Input::get('bulan')."'":"";
            (Input::get('id_jenis_cuti')!='')?$where.=" and tr_ijin_cuti.id_jenis_cuti = '".Input::get('id_jenis_cuti')."'":"";
            (Input::get('idskpd')!='' && \Session::get('role_id') != 4)?$where.=" and tr_ijin_cuti.idskpd = '".Input::get('idskpd')."'":"";

            $wewenangs = $this->verifikasicuti
            ->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
            ->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->whereRaw($where2)
            ->whereRaw($where)
            // ->paginate($_ENV['configurations']['list-limit']);
            ->get();
            
        }else{
            $wewenangs = $this->verifikasicuti
            ->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
            ->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->whereRaw($where2)
            ->whereRaw($where)
            ->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
            // ->paginate($_ENV['configurations']['list-limit']);
            ->get();
        }
        return View::make('verifikasicuti::wewenang', compact('wewenangs'));
    }
    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('verifikasicuti::'.$view.'_view');

    }
    /*function Menampilkan Modal atribut dari link */
    function postModal(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('verifikasicuti::'.$view.'_modal');
    }

    /*25 APRIL 2019 Progress Modal Verifikasi Atasan*/
    public function postVerifikasiatasan(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        if ($input['atasan_status'] == 1 || $input['atasan_status'] == 0) {
            $input['atasan_alasan'] = "";
        }
        $verifikasicuti = $this->verifikasicuti->find($id);
        echo ($verifikasicuti->update($input))?1:"Gagal Disimpan";
    }

    /*25 APRIL 2019 Progress Modal Verifikasi Atasan*/
    public function postVerifikasinomiatasan(){
        cekAjax();
        $nousul = Input::get('nousul');
        $data = Input::except('_token');
        $dt['nousul'] = $nousul;
        if ($data['atasan_status'] == 1 || $data['atasan_status'] == 0) {
            $data['atasan_alasan'] = "";
        }
        if(!\DB::table("tr_ijin_cuti")->where($dt)->update($data)){
            echo "Verifikasi Nominatif Cuti gagal disimpan";
        }else{
            echo 1;
        }
    }

    public function postVerifikasiwewenang(){
        cekAjax();
        $id     = Input::get('id');
        $nip    = Input::get('nip');
        $input  = Input::all();
        if ($input['wewenang_status'] == 1 || $input['wewenang_status'] == 0) {
            $input['wewenang_alasan'] = "";
        }
        /*START PROSES HITUNG*/
        // $id_rcuti = getIdCutiTerbaru($nip);
        /*ENDOF PROSES HITUNG*/
        $verifikasicuti = $this->verifikasicuti->find($id);
        echo ($verifikasicuti->update($input))?1:"Gagal Disimpan";
    }

    /*25 APRIL 2019 Progress Modal Verifikasi wewenang VERIFIKASI NOMINASI BELUM TERPAKAI*/
    public function postVerifikasinomiwewenang(){
        cekAjax();
        $nousul = Input::get('nousul');
        $data = Input::except('_token');
        $dt['nousul'] = $nousul;
        if ($data['wewenang_status'] == 1 || $data['wewenang_status'] == 0) {
            $data['wewenang_alasan'] = "";
        }
        if(!\DB::table("tr_ijin_cuti")->where($dt)->update($data)){
            echo "Verifikasi Nominatif Cuti gagal disimpan";
        }else{
            echo 1;
        }
    }

}
