<?php namespace App\Modules\epersonal\perubahanriwayat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\perubahanriwayat\Models\PerubahanriwayatModel;
use App\Models\SinkronisasiModel;
use Input,View, Request, Form, File;

/**
* Perubahanriwayat Controller
* @var Perubahanriwayat
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PerubahanriwayatController extends Controller {
    protected $perubahanriwayat;

    public function __construct(PerubahanriwayatModel $perubahanriwayat){
        $this->perubahanriwayat = $perubahanriwayat;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $perubahanriwayats = $this->perubahanriwayat
                			->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('nip', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('idjab', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('jab', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('skpd', 'LIKE', '%'.Input::get('search').'%')
                            ->orWhere('tmtjab', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $perubahanriwayats = $this->perubahanriwayat->all();
            }
        }else{
            $perubahanriwayats = $this->perubahanriwayat->all();
        }
        return View::make('perubahanriwayat::index', compact('perubahanriwayats'));
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('perubahanriwayat::'.$view.'', $data);
    }

    //{controller-show}

    /*function post edit riwayat*/
    function postEditriwayat(){
        cekAjax();
        $id = Input::get("id");
        $tb = Input::get("tb");
        $rs = \DB::table($tb.' as a')
            ->select('a.*',
            \DB::raw('IF(a.status = 1,"Disetujui",IF(a.status = 2,"Ditolak","Belum ada tanggapan")) as stspermohonan'),
            \DB::raw('IF(a.status = 1,"-",IF(a.status = 2,a.ketditolak,"Belum ada tanggapan")) as ketpermohonan')
        )
            ->where('id', $id)->first();
        echo json_encode($rs);
    }

    /*function untuk membatalkan perubahan biodata*/
    function postBtlperubahan(){
        cekAjax();
        $id = Input::get('id');
        $table = Input::get('tb');
        if(\DB::table($table)->where('id', $id)->delete()){
            echo "9";
        }else{
            echo "Data Gagal Dibatalkan";
        }
    }

    /*function index riwayat pangkat detail*/
    public function getRpangkatdetail(){
      /*cekAjax();*/
      $where = ' tb_01.idjenkedudupeg not in (99,21)';
      if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
      }else if(Input::get('nip')!=''){
         $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
      }

      if (Input::has('search') or Input::has('idskpd')) {
           (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
           (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpangkats = \DB::table('r_gol_temp')
                ->select(
                    'r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_gol_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
      }else{
            $rpangkats = \DB::table('r_gol_temp')
                ->select(
                    'r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_gol_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
      }
      return View::make('perubahanriwayat::rpangkat_detail', compact('rpangkats'));
    }

    /*function index riwayat pangkat*/
    public function getRpangkat(){
       /*cekAjax();*/
       $where = ' tb_01.idjenkedudupeg not in (99,21)';
       if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
       }

       if (Input::has('search') or Input::has('idskpd')) {
           (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
           (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpangkats = \DB::table('r_gol_temp')
                ->select(
                    'r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_gol_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
       }else{
            $rpangkats = \DB::table('r_gol_temp')
                ->select(
                    'r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_gol_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
       }
       return View::make('perubahanriwayat::rpangkat', compact('rpangkats'));
    }

    /*function verifikasi riwayat pangkat*/
    public function postVerrpangkat(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rpangkat);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rgol','idjnsaksi','status','ketditolak','status1','status2');
            }else{
                $arrnot = array('','_token','status1','status2');
            }
            $keydate = array('','tgsk','tmtpkt');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_gol')->insert($data);
                    if($rs){
                        \DB::table('r_gol_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_gol_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_gol')->where('id', $input['id_rgol'])->update($data);
                    if($rs){
                        \DB::table('r_gol_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_gol_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_gol')->where('id', $input['id_rgol'])->delete();
                    if($rs){
                        \DB::table('r_gol_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_gol_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function index riwayat jabatan detail*/
    public function getRjabdetail(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }else if(Input::get('nip')!=''){
          $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
       }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rjabs = \DB::table('r_jab_temp')
                ->select(
                    'r_jab_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan','tb_01.idskpd','a_skpd.path',
                    \DB::raw('if(r_jab_temp.idjenjab>4, "Struktural", if(r_jab_temp.idjenjab=2, "Fungsional Tertentu", if(r_jab_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_jab_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_jab_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rjabs = \DB::table('r_jab_temp')
                ->select(
                    'r_jab_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan', 'tb_01.idskpd','a_skpd.path',
                    \DB::raw('if(r_jab_temp.idjenjab>4, "Struktural", if(r_jab_temp.idjenjab=2, "Fungsional Tertentu", if(r_jab_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_jab_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_jab_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rjab_detail', compact('rjabs'));
    }

    /*function index riwayat jabatan*/
    public function getRjab(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rjabs = \DB::table('r_jab_temp')
                ->select(
                    'r_jab_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan','tb_01.idskpd','a_skpd.path',
                    \DB::raw('if(r_jab_temp.idjenjab>4, "Struktural", if(r_jab_temp.idjenjab=2, "Fungsional Tertentu", if(r_jab_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_jab_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_jab_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rjabs = \DB::table('r_jab_temp')
                ->select(
                    'r_jab_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan', 'tb_01.idskpd','a_skpd.path',
                    \DB::raw('if(r_jab_temp.idjenjab>4, "Struktural", if(r_jab_temp.idjenjab=2, "Fungsional Tertentu", if(r_jab_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_jab_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_jab_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rjab', compact('rjabs'));
    }

private function jabatanSerializeDatasiasn($data)
    {
        // 14072025
        $idjabFung = '';
        $idjabFungUm = '';
        $eselon_id = '';

        if ($data['idjenjab'] == 1) {
            $jenisJabatan = "1";
            $eselon_id =  getIdEselon($data['esl']);
            // $idjab =  $data['idskpd'];
        } elseif ($data['idjenjab'] == 2) {
            $jenisJabatan = "2";
            $idjab =  $data['idjab'];
            $idjabFung =  getJabatanIdSapk($data['idjenjab'],  $data['idjab']);
            $eselon_id = 0;
        } elseif ($data['idjenjab'] == 3) {
            $jenisJabatan = "4";
            $idjabFungUm =  getJabatanIdSapk($data['idjenjab'],  $data['idjab']);
            $eselon_id = 0;
        } else {
            $jenisJabatan = "1";
            $eselon_id =  getIdEselon($data['esl']);
        }

        $tglsk = explode("-", $data['tgsk']);
        $tmtjab = explode("-", $data['tmtjab']);
        $instansiid =  getUnOrId(substr($data['idskpd'], 0, 2));
        $unorid =  getUnOrId($data['idskpd']);
        $jenjabsiasn = \DB::table('a_jenjab')->where('idjenjab', '=', $data['idjenjab'])->first()->idsiasn;
        if (!empty($data['idtugasdokter'])) {
            $subJabatanId = \DB::table('a_tugasdokter')->where('idtugasdokter', '=', $data['idtugasdokter'])->first()->idsiasn;
        } elseif (!empty($data['idtugasgurudosen'])) {
            $subJabatanId = \DB::table('a_matkulpel')->where('idtugasgurudosen', '=', $data['idtugasgurudosen'])->first()->idsiasn;
        } else {
            $subJabatanId = '';
        }
        $dataSend  = [
            'eselonId' => (@$data['esl'] != '') ? $eselon_id : '',
            'id' => "",
            'instansiId' => ENV('INSTANSI_ID'),
            'instansiIndukId' => ENV('INSTANSI_ID'),
            'jabatanFungsionalId' => $idjabFung,
            'jabatanFungsionalUmumId' => $idjabFungUm,
            'jenisJabatan' => $jenjabsiasn,
            'jenisMutasiId' => "MJ", #sementara mutasi jabatan
            'jenisPenugasanId' => "D",
            'nomorSk' => $data['nosk'],
            'pnsId' => getPnsIdSapk($data['nip']),
            'satuanKerjaId' => "A5EB03E241F1F6A0E040640A040252AD",
            'subJabatanId' => $subJabatanId,
            'tanggalSk' =>  date('d-m-Y', strtotime($data['tgsk'])),
            'tmtJabatan' => date('d-m-Y', strtotime($data['tmtjab'])),
            'tmtMutasi' => date('d-m-Y', strtotime($data['tmtjab'])),
            'tmtPelantikan' => date('d-m-Y', strtotime($data['tmtjab'])),
            'unorId' => "$unorid"
        ];

        return $dataSend;
        // 14072025
    }


    /*function verifikasi riwayat jabatan*/
    public function postVerrjab(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rjabatan);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rjab','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgsk','tmtjab');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                   // 14072025
                    $rspegawai = \DB::table("tb_01")->where("nip", $input['nip'])->first();
                    if ($rspegawai->idstspeg != '3') {
                        $dataSend = $this->jabatanSerializeDatasiasn($input);
                        $send = accessDatapostsiasn('jabatan/unorjabatan/save', $dataSend);

                        if ($send->message == "success") {
                            $rs = \DB::table('r_jab')->insert($data);
                            if ($rs) {
                                \DB::table('r_jab_temp')->where('id', $input['id'])->delete();
                                echo "4";
                            } else {
                                echo "Data Gagal Disimpan";
                            }
                        } else {
                            echo 'Gagal Sinkron Data, ' . $send->message;
                        }
                    } elseif ($rspegawai->idstspeg == '3') {
                        $rs = \DB::table('r_jab')->insert($data);
                        if ($rs) {
                            \DB::table('r_jab_temp')->where('id', $input['id'])->delete();
                            echo "4";
                        } else {
                            echo "Data Gagal Disimpan";
                        }
                    }
                    // 14072025
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_jab_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_jab')->where('id', $input['id_rjab'])->update($data);
                    if($rs){
                        \DB::table('r_jab_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_jab_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_jab')->where('id', $input['id_rjab'])->delete();
                    if($rs){
                        \DB::table('r_jab_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_jab_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

   /*function index riwayat kgb detail*/
   public function getRkgbdetail(){
      /*cekAjax();*/
      $where = ' tb_01.idjenkedudupeg not in (99,21)';
      if(session('role_id') > 3){
           if(session('role_id') == 5){
               $where.= " and tb_01.nip = \"".session('user_id')."\" ";
           }else{
               $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
           }
      }else if(Input::get('nip')!=''){
         $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
      }

      if (Input::has('search') or Input::has('idskpd')) {
           (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
           (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

           $rkgbs = \DB::table('r_kgb_temp')
               ->select(
                   'r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                   \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
               )
               ->join('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')
               ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
               ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
               ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
               ->whereRaw($where)
               ->orderBy('r_kgb_temp.created_at', 'desc')
               ->orderBy('tb_01.idskpd', 'asc')
               ->paginate($_ENV['configurations']['list-limit']);
      }else{
           $rkgbs = \DB::table('r_kgb_temp')
               ->select(
               'r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
               \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
           )
               ->join('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')
               ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
               ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
               ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
               ->whereRaw($where)
               ->orderBy('r_kgb_temp.created_at', 'desc')
               ->orderBy('tb_01.idskpd', 'asc')
               ->paginate($_ENV['configurations']['list-limit']);
      }
      return View::make('perubahanriwayat::rkgb_detail', compact('rkgbs'));
   }

    /*function index riwayat kgb*/
    public function getRkgb(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rkgbs = \DB::table('r_kgb_temp')
                ->select(
                    'r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_kgb_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rkgbs = \DB::table('r_kgb_temp')
                ->select(
                'r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.idskpd','a_skpd.path',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
                ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_kgb_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rkgb', compact('rkgbs'));
    }

    /*function verifikasi riwayat kgb*/
    public function postVerrkgb(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rkgb);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rkgb','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tmtkgb','tglkgb');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_kgb')->insert($data);
                    if($rs){
                        \DB::table('r_kgb_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_kgb_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_kgb')->where('id', $input['id_rkgb'])->update($data);
                    if($rs){
                        \DB::table('r_kgb_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_kgb_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_kgb')->where('id', $input['id_rkgb'])->delete();
                    if($rs){
                        \DB::table('r_kgb_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_kgb_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function index riwayat pendidikan detail*/
    public function getRpenddetail(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }else if(Input::get('nip')!=''){
           $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
         }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpends = \DB::table('r_pend_temp')
                ->select(
                    'r_pend_temp.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->whereRaw($where)
                ->orderBy('r_pend_temp.created_at', 'desc')
                ->orderBy('r_pend_temp.tgijaz', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpends = \DB::table('r_pend_temp')
                ->select(
                    'r_pend_temp.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->whereRaw($where)
                ->orderBy('r_pend_temp.created_at', 'desc')
                ->orderBy('r_pend_temp.tgijaz', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rpend_detail', compact('rpends'));
    }

    /*function index riwayat pendidikan*/
    public function getRpend(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpends = \DB::table('r_pend_temp')
                ->select(
                    'r_pend_temp.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->whereRaw($where)
                ->orderBy('r_pend_temp.created_at', 'desc')
                ->orderBy('r_pend_temp.tgijaz', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpends = \DB::table('r_pend_temp')
                ->select(
                    'r_pend_temp.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->whereRaw($where)
                ->orderBy('r_pend_temp.created_at', 'desc')
                ->orderBy('r_pend_temp.tgijaz', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rpend', compact('rpends'));
    }

    /*function verifikasi riwayat pendidikan*/
    public function postVerrpend(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rpend);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rpend','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgijaz');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_pend')->insert($data);
                    if($rs){
                    
                    // copy data dari file temp ke file utama
                        $columnsToCopy = [
                            'filename',
                            'kode',
                            'size',
                            'nip',
                            'user_id',
                            'role_id',
                            'created_at',
                            'status',
                            'jenis',
                            'subjenis',
                            'subsubjenis',
                            'riwayat_flag',
                            'verified'
                        ];
                        $totalRowsInserted = 0;
                        $masterTable = 'files';
                        // Gunakan CHUNK untuk memproses 500 baris sekaligus, menghemat memori
                        \DB::connection('efile_2017')->table('files_temp')
                            ->select($columnsToCopy)
                            ->where('subjenis', $input['id'])
                            ->chunk(500, function ($tempRecords) use ($masterTable, &$totalRowsInserted) {

                                $dataToInsert = [];

                                // Ubah Collection menjadi array data mentah yang dibutuhkan oleh insert()
                                foreach ($tempRecords as $record) {
                                    // Karena $record adalah StdClass, kita konversi ke array
                                    $dataToInsert[] = (array) $record;
                                }

                                // Lakukan INSERT BATCH pada tabel utama
                                if (!empty($dataToInsert)) {
                                    $inserted = \DB::connection('efile_2017')->table($masterTable)->insert($dataToInsert);
                                    $totalRowsInserted += count($dataToInsert);
                                }
                            });

                        // end
                        \DB::connection('efile_2017')->table('files_temp')->where('subjenis', $input['id'])->delete();
                        // end copy dari file utama
                    
                    
                        \DB::table('r_pend_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_pend_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_pend')->where('id', $input['id_rpend'])->update($data);
                    if($rs){
                        \DB::table('r_pend_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_pend_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_pend')->where('id', $input['id_rpend'])->delete();
                    if($rs){
                        \DB::table('r_pend_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_pend_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

     /*function index riwayat diklat struktural detail*/
     public function getRdikstrudetail(){
         /*cekAjax();*/
         $where = ' tb_01.idjenkedudupeg not in (99,21)';
         if(session('role_id') > 3){
             if(session('role_id') == 5){
                 $where.= " and tb_01.nip = \"".session('user_id')."\" ";
             }else{
                 $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
             }
         }else if(Input::get('nip')!=''){
            $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
         }

         if (Input::has('search') or Input::has('idskpd')) {
             (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
             (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

             $rdikstrus = \DB::table('r_dikstru_temp')
                 ->select(
                     'r_dikstru_temp.*'/*, 'a_dikstru.dikstru'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                     \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                 )
                 ->join('tb_01', 'r_dikstru_temp.nip', '=', 'tb_01.nip')
                 ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                 ->leftjoin('a_dikstru', 'r_dikstru_temp.iddikstru', '=', 'a_dikstru.iddikstru')
                 ->whereRaw($where)
                 ->orderBy('r_dikstru_temp.created_at', 'desc')
                 ->orderBy('tb_01.idskpd', 'asc')
                 ->paginate($_ENV['configurations']['list-limit']);
         }else{
             $rdikstrus = \DB::table('r_dikstru_temp')
                 ->select(
                     'r_dikstru_temp.*'/*, 'a_dikstru.dikstru'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                     \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                 )
                 ->join('tb_01', 'r_dikstru_temp.nip', '=', 'tb_01.nip')
                 ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                 ->leftjoin('a_dikstru', 'r_dikstru_temp.iddikstru', '=', 'a_dikstru.iddikstru')
                 ->whereRaw($where)
                 ->orderBy('r_dikstru_temp.created_at', 'desc')
                 ->orderBy('tb_01.idskpd', 'asc')
                 ->paginate($_ENV['configurations']['list-limit']);
         }
         return View::make('perubahanriwayat::rdikstru_detail', compact('rdikstrus'));
     }

    /*function index riwayat diklat struktural*/
    public function getRdikstru(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rdikstrus = \DB::table('r_dikstru_temp')
                ->select(
                    'r_dikstru_temp.*'/*, 'a_dikstru.dikstru'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikstru_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikstru', 'r_dikstru_temp.iddikstru', '=', 'a_dikstru.iddikstru')
                ->whereRaw($where)
                ->orderBy('r_dikstru_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rdikstrus = \DB::table('r_dikstru_temp')
                ->select(
                    'r_dikstru_temp.*'/*, 'a_dikstru.dikstru'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikstru_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikstru', 'r_dikstru_temp.iddikstru', '=', 'a_dikstru.iddikstru')
                ->whereRaw($where)
                ->orderBy('r_dikstru_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rdikstru', compact('rdikstrus'));
    }

    /*function verifikasi riwayat diklat struktural*/
    public function postVerrdikstru(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rdikstru);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rdikstru','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgijaz');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                   // $rs = \DB::table('r_dikstru')->insert($data);
                    $rs = \DB::table('r_dikstru')->insertGetId($data);;
                    if($rs){
                     // copy data dari file temp ke file utama
                        $columnsToCopy = [
                            'filename',
                            'kode',
                            'size',
                            'nip',
                            'user_id',
                            'role_id',
                            'created_at',
                            'status',
                            'jenis',
                            //'subjenis',
                            'subsubjenis',
                            'riwayat_flag',
                            'verified'
                        ];
                        $totalRowsInserted = 0;
                        $masterTable = 'files';
                        // Gunakan CHUNK untuk memproses 500 baris sekaligus, menghemat memori
                        \DB::connection('efile_2017')->table('files_temp')
                            ->select($columnsToCopy)
                            ->where('subjenis', $input['id'])
                            ->chunk(500, function ($tempRecords) use ($masterTable, &$totalRowsInserted, $rs) {

                                $dataToInsert = [];

                                // Ubah Collection menjadi array data mentah yang dibutuhkan oleh insert()
                                foreach ($tempRecords as $record) {


                                    // Karena $record adalah StdClass, kita konversi ke array terlebih dahulu
                                    $row = (array) $record;

                                    // Tambahkan kunci 'subjenis' ke dalam array baris ini
                                    $row['subjenis'] = $rs;

                                    // Tambahkan baris yang sudah lengkap (termasuk subjenis) ke array utama
                                    $dataToInsert[] = $row;
                                }

                                // Lakukan INSERT BATCH pada tabel utama
                                if (!empty($dataToInsert)) {
                                    $inserted = \DB::connection('efile_2017')->table($masterTable)->insert($dataToInsert);
                                    $totalRowsInserted += count($dataToInsert);
                                }
                            });

                        // end
                        \DB::connection('efile_2017')->table('files_temp')->where('subjenis', $input['id'])->delete();
                        // end copy dari file utama
                    
                    
                        \DB::table('r_dikstru_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_dikstru_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_dikstru')->where('id', $input['id_rdikstru'])->update($data);
                    if($rs){
                        \DB::table('r_dikstru_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_dikstru_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_dikstru')->where('id', $input['id_rdikstru'])->delete();
                    if($rs){
                        \DB::table('r_dikstru_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_dikstru_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function index riwayat diklat fungsional detail*/
    public function getRdikfungdetail(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }else if(Input::get('nip')!=''){
            $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
         }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rdikfungs = \DB::table('r_dikfung_temp')
                ->select(
                    'r_dikfung_temp.*'/*, 'a_dikfung.dikfung'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikfung_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikfung', 'r_dikfung_temp.iddikfung', '=', 'a_dikfung.iddikfung')
                ->whereRaw($where)
                ->orderBy('r_dikfung_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rdikfungs = \DB::table('r_dikfung_temp')
                ->select(
                    'r_dikfung_temp.*'/*, 'a_dikfung.dikfung'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikfung_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikfung', 'r_dikfung_temp.iddikfung', '=', 'a_dikfung.iddikfung')
                ->whereRaw($where)
                ->orderBy('r_dikfung_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rdikfung_detail', compact('rdikfungs'));
    }

    /*function index riwayat diklat struktural*/
    public function getRdikfung(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rdikfungs = \DB::table('r_dikfung_temp')
                ->select(
                    'r_dikfung_temp.*'/*, 'a_dikfung.dikfung'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikfung_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikfung', 'r_dikfung_temp.iddikfung', '=', 'a_dikfung.iddikfung')
                ->whereRaw($where)
                ->orderBy('r_dikfung_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rdikfungs = \DB::table('r_dikfung_temp')
                ->select(
                    'r_dikfung_temp.*'/*, 'a_dikfung.dikfung'*/,'tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_dikfung_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_dikfung', 'r_dikfung_temp.iddikfung', '=', 'a_dikfung.iddikfung')
                ->whereRaw($where)
                ->orderBy('r_dikfung_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rdikfung', compact('rdikfungs'));
    }

    /*function verifikasi riwayat diklat struktural*/
    public function postVerrdikfung(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rdikfung);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rdikfung','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgijaz');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    //     /* candra verifikasi dan sinkronisasi */
                    //$pnsId = $sinkron->getPnsIdSapk($data['nip']);
                    //if (empty($pnsId)) {
                     //   echo "Data Gagal Disimpan idsapk tidak ditemukan";
                    //} else {
                $rs = \DB::table('r_dikfung')->insertGetId($data);
                    if($rs){
                    // copy data dari file temp ke file utama
                            $columnsToCopy = [
                                'filename',
                                'kode',
                                'size',
                                'nip',
                                'user_id',
                                'role_id',
                                'created_at',
                                'status',
                                'jenis',
                                //'subjenis',
                                'subsubjenis',
                                'riwayat_flag',
                                'verified'
                            ];
                            $totalRowsInserted = 0;
                            $masterTable = 'files';
                            // Gunakan CHUNK untuk memproses 500 baris sekaligus, menghemat memori
                            \DB::connection('efile_2017')->table('files_temp')
                                ->select($columnsToCopy)
                                ->where('subjenis', $input['id'])
                                ->chunk(500, function ($tempRecords) use ($masterTable, &$totalRowsInserted, $rs) {

                                    $dataToInsert = [];

                                    // Ubah Collection menjadi array data mentah yang dibutuhkan oleh insert()
                                    foreach ($tempRecords as $record) {


                                        // Karena $record adalah StdClass, kita konversi ke array terlebih dahulu
                                        $row = (array) $record;

                                        // Tambahkan kunci 'subjenis' ke dalam array baris ini
                                        $row['subjenis'] = $rs;

                                        // Tambahkan baris yang sudah lengkap (termasuk subjenis) ke array utama
                                        $dataToInsert[] = $row;
                                    }

                                    // Lakukan INSERT BATCH pada tabel utama
                                    if (!empty($dataToInsert)) {
                                        $inserted = \DB::connection('efile_2017')->table($masterTable)->insert($dataToInsert);
                                        $totalRowsInserted += count($dataToInsert);
                                    }
                                });

                            // end
                            \DB::connection('efile_2017')->table('files_temp')->where('subjenis', $input['id'])->delete();
                            // end copy dari file utama
                  // $dataSend = $this->dikfungSerializeData($data);
                        // $send = accessDatapostsiasn('kursus/save', $dataSend);
                        // if ($send->message == "success") {
                        //     $update =  \DB::table('r_dikfung')->where('id', $rs)
                        //         ->update(['idsapk' =>  $send->{'mapData'}->rwKursusId]);
                        //     echo '4';
                        // } else {
                        //     echo 'Gagal Sinkron Data, ' . $send->message;
                        // }
                        \DB::table('r_dikfung_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                    //}
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_dikfung_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_dikfung')->where('id', $input['id_rdikfung'])->update($data);
                    if($rs){
                        \DB::table('r_dikfung_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_dikfung_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_dikfung')->where('id', $input['id_rdikfung'])->delete();
                    if($rs){
                        \DB::table('r_dikfung_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_dikfung_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
// candra
    /*function simpan riwayat dikfung pegawai bkn to simpeg*/
    public function postSyncrdikfungbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rdikfungsync);
        if ($validation->passes()) {
            $arrnot = array('', '_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'idsapk' => $input['iddikfungbkn'],
                //'idjendik_SAPK' => 2,
                'iddikfung' => $this->siasn->getIdkursus($input['namaKursus'], 2),
                'dikfung' => $input['namaKursus'],
                'tgsttpdikfung' => date('Y-m-d', strtotime($input['tanggalKursus'])),
                'tgmul' => date('Y-m-d', strtotime($input['tanggalKursus'])),
                'tgsel' => date('Y-m-d', strtotime($input['tanggalSelesaiKursus'])),
                'penyelenggara' => $input['institusiPenyelenggara'],
                'nosttpdikfung' => $input['noSertipikat'],
                'jamhari' => $input['jumlahJam'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            $rscek = \DB::table('r_dikfung')->where('idsapk', $input['iddikfungbkn'])->count();
            if ($rscek > 0) {
                echo (\DB::table('r_dikfung')->where('idsapk', $input['iddikfungbkn'])->update($data)) ? 4 : "Gagal Sinkron Data";
            } else {
                echo (\DB::table('r_dikfung')->insert($data)) ? 1 : "Gagal Sinkron Data";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
/*function simpan riwayat dikfung pegawai simpeg to bkn*/
    public function postSyncrdikfungsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->dikfungSerializeData($input);
        $send = accessDatapostsiasn('kursus/save', $dataSend);

        if ($send->message == "success") {
            $this->saveRdikfungmodal($input);
            $update =  \DB::table('r_dikfung')->where('id', $input['id'])
                ->update(['idsapk' =>  $send->{'mapData'}->rwKursusId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, ' . $send->message;
        }
    }

/*function simpan riwayat dikfung pegawai simpeg to bkn*/
    private function dikfungSerializeData($data)
    {
        $sinkron = new SinkronisasiModel();
        $tahun = date('Y', strtotime($data['tgsttpdikfung']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahunKursus' => (int)$tahun,
            'jenisDiklatId' => '2',
            'jenisKursusSertipikat' => 'F',
            'namaKursus' => $data['dikfung'],
            'tanggalKursus' => date('Y-m-d', strtotime($data['tgsttpdikfung'])),
            'tanggalSelesaiKursus' => date('Y-m-d', strtotime($data['tgsel'])),
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdikfung'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $sinkron->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    // candra end

     /*function index riwayat diklat teknis detail*/
     public function getRdiktekdetail(){
         /*cekAjax();*/
         $where = ' tb_01.idjenkedudupeg not in (99,21)';
         if(session('role_id') > 3){
             if(session('role_id') == 5){
                 $where.= " and tb_01.nip = \"".session('user_id')."\" ";
             }else{
                 $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
             }
         }else if(Input::get('nip')!=''){
            $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
         }

         if (Input::has('search') or Input::has('idskpd')) {
             (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
             (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

             $rdikteks = \DB::table('r_diktek_temp')
                 ->select(
                 'r_diktek_temp.*','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                 \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
             )
                 ->join('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')
                 ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                 ->whereRaw($where)
                 ->orderBy('r_diktek_temp.created_at', 'desc')
                 ->orderBy('tb_01.idskpd', 'asc')
                 ->paginate($_ENV['configurations']['list-limit']);
         }else{
             $rdikteks = \DB::table('r_diktek_temp')
                 ->select(
                 'r_diktek_temp.*','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                 \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
             )
                 ->join('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')
                 ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                 ->whereRaw($where)
                 ->orderBy('r_diktek_temp.created_at', 'desc')
                 ->orderBy('tb_01.idskpd', 'asc')
                 ->paginate($_ENV['configurations']['list-limit']);
         }
         return View::make('perubahanriwayat::rdiktek_detail', compact('rdikteks'));
     }

    /*function index riwayat diklat teknis*/
    public function getRdiktek(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rdikteks = \DB::table('r_diktek_temp')
                ->select(
                'r_diktek_temp.*','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->whereRaw($where)
                ->orderBy('r_diktek_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rdikteks = \DB::table('r_diktek_temp')
                ->select(
                'r_diktek_temp.*','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->whereRaw($where)
                ->orderBy('r_diktek_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rdiktek', compact('rdikteks'));
    }


/* candra */
    /*function simpan riwayat diktek pegawai simpeg to bkn*/
    public function postSyncrdikteksimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->diktekSerializeData($input);
        $send = accessDatapostsiasn('kursus/save', $dataSend);

        if ($send->message == "success") {
            $this->saveRdiktekmodal($input);
            $update =  \DB::table('r_diktek')->where('id', $input['id'])
                ->update(['idsapk' =>  $send->{'mapData'}->rwKursusId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, ' . $send->message;
        }
    }

    /*function simpan riwayat diktek pegawai simpeg to bkn*/
    private function diktekSerializeData($data)
    {
        $sinkron = new SinkronisasiModel();
        $tahun = date('Y', strtotime($data['tgsttpdiktek']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahunKursus' => (int)$tahun,
            'jenisDiklatId' => '3',
            'jenisKursusSertipikat' => 'T',
            'namaKursus' => $data['nmdiktek'],
            // // 'tanggalKursus' => $data['tgsttpdiktek'],
            // 'tanggalKursus' => $data['tgmul'],
            // 'tanggalSelesaiKursus' => $data['tgsel'],
            'tanggalKursus' => date('d-m-Y', strtotime($data['tgmul'])),
            'tanggalSelesaiKursus' => date('d-m-Y', strtotime($data['tgsel'])),
        
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdiktek'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $sinkron->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan rdiktek simpeg sekaligus sinkron siasn*/
    function saveRdiktekmodal($input)
    {
        $arrnot = array('', '_token', 'idjnsaksi', 'iddiktekbkn');
        $keydate = array('', 'tgmul', 'tgsel', 'tgsttpdiktek');

        foreach ($_POST as $key => $value) {
            if (array_search($key, $keydate) != '') {
                $val = explode("-", $value);
                $value = $val[2] . "-" . $val[1] . "-" . $val[0];
            }
            if (array_search($key, $arrnot) == "") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');
        return $data;

        // \DB::table('r_diktek')->where('id', $input['id'])->update($data);
    }
    /* candra end */

    /*function verifikasi riwayat diklat struktural*/
    public function postVerrdiktek(){
        cekAjax();
        $input = Input::all();
      /* candra */
      $sinkron = new SinkronisasiModel();
      /* candra end */
        $validation = \Validator::make($input, \BiodataModel::$rdiktek);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rdiktek','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgijaz');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                 
                   /* candra verifikasi dan sinkronisasi */
                    $pnsId = $sinkron->getPnsIdSapk($data['nip']);
                    if (empty($pnsId)) {
                        echo "Data Gagal Disimpan idsapk tidak ditemukan";
                    } else {
                        $rs = \DB::table('r_diktek')->insertGetId($data);
                        if ($rs) {
                        
                        // copy data dari file temp ke file utama
                            $columnsToCopy = [
                                'filename',
                                'kode',
                                'size',
                                'nip',
                                'user_id',
                                'role_id',
                                'created_at',
                                'status',
                                'jenis',
                                //'subjenis',
                                'subsubjenis',
                                'riwayat_flag',
                                'verified'
                            ];
                            $totalRowsInserted = 0;
                            $masterTable = 'files';
                            // Gunakan CHUNK untuk memproses 500 baris sekaligus, menghemat memori
                            \DB::connection('efile_2017')->table('files_temp')
                                ->select($columnsToCopy)
                                ->where('subjenis', $input['id'])
                                ->chunk(500, function ($tempRecords) use ($masterTable, &$totalRowsInserted, $rs) {

                                    $dataToInsert = [];

                                    // Ubah Collection menjadi array data mentah yang dibutuhkan oleh insert()
                                    foreach ($tempRecords as $record) {


                                        // Karena $record adalah StdClass, kita konversi ke array terlebih dahulu
                                        $row = (array) $record;

                                        // Tambahkan kunci 'subjenis' ke dalam array baris ini
                                        $row['subjenis'] = $rs;

                                        // Tambahkan baris yang sudah lengkap (termasuk subjenis) ke array utama
                                        $dataToInsert[] = $row;
                                    }

                                    // Lakukan INSERT BATCH pada tabel utama
                                    if (!empty($dataToInsert)) {
                                        $inserted = \DB::connection('efile_2017')->table($masterTable)->insert($dataToInsert);
                                        $totalRowsInserted += count($dataToInsert);
                                    }
                                });

                            // end
                            \DB::connection('efile_2017')->table('files_temp')->where('subjenis', $input['id'])->delete();
                            // end copy dari file utama
                            \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                        
                            $dataSend = $this->diktekSerializeData($data);
                            $send = accessDatapostsiasn('kursus/save', $dataSend);
                            if ($send->message == "success") {
                                $update =  \DB::table('r_diktek')->where('id', $rs)
                                    ->update(['idsapk' =>  $send->{'mapData'}->rwKursusId]);
                                echo '4';
                            } else {
                                echo 'Gagal Sinkron Data, ' . $send->message;
                            }
                            \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                        } else {
                            echo "Data Gagal Disimpan";
                        }
                    }
                    /* end candra verifikasi dan sinkronisasi */
                    // $rs = \DB::table('r_diktek')->insert($data);
                    // if($rs){
                    //     \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                    //     echo "4";
                    // }else{
                    //     echo "Data Gagal Disimpan";
                    // }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_diktek_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                  
                    // $data['updated_at'] = gmdate("Y-m-d H:i", time() + 60 * 60 * 7);
                    //                   $rs = \DB::table('r_diktek')->where('id', $input['id_rdiktek'])->update($data);
                    // if ($rs) {
                    //     \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                    //     echo "4";
                    // } else {
                    //     echo "Data Gagal Disimpan";
                    // }
                
                // candra edit
                    $pnsId = $sinkron->getPnsIdSapk($data['nip']);
                    $data['updated_at'] = gmdate("Y-m-d H:i", time() + 60 * 60 * 7);
                    if (empty($pnsId)) {
                        echo "Data Gagal Disimpan idsapk tidak ditemukan";
                    } else {
                        $rs = \DB::table('r_diktek')->where('id', $input['id_rdiktek'])->update($data);
                        if ($rs) {
                            $dataSend = $this->diktekSerializeData($input);
                            $send = accessDatapostsiasn('kursus/save', $dataSend);
                            if ($send->message == "success") {
                                $update =  \DB::table('r_diktek')->where('id', $input['id_rdiktek'])
                                    ->update(['idsapk' =>  $send->{'mapData'}->rwKursusId]);
                                echo '4';
                            } else {
                                echo 'Gagal Sinkron Data, ' . $send->message;
                            }
                            \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                        } else {
                            echo "Data Gagal Disimpan";
                        }
                    }
                    // end candra edit

                    // $rs = \DB::table('r_diktek')->where('id', $input['id_rdiktek'])->update($data);
                    // if ($rs) {
                    //     \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                    //     echo "4";
                    // } else {
                    //     echo "Data Gagal Disimpan";
                    // }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_diktek_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_diktek')->where('id', $input['id_rdiktek'])->delete();
                    if($rs){
                        \DB::table('r_diktek_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_diktek_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function index riwayat hkuman disiplin detail*/
    public function getRhukdisdetail(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }else if(Input::get('nip')!=''){
            $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
         }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rhukdiss = \DB::table('r_hukdis_temp')
                ->select(
                    'r_hukdis_temp.*','a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_hukdis_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rhukdiss = \DB::table('r_hukdis_temp')
                ->select(
                    'r_hukdis_temp.*','a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_hukdis_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rhukdis_detail', compact('rhukdiss'));
    }

    /*function index riwayat hkuman disiplin*/
    public function getRhukdis(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rhukdiss = \DB::table('r_hukdis_temp')
                ->select(
                    'r_hukdis_temp.*','a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_hukdis_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rhukdiss = \DB::table('r_hukdis_temp')
                ->select(
                    'r_hukdis_temp.*','a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
                )
                ->join('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_hukdis_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rhukdis', compact('rhukdiss'));
    }

    /*function verifikasi riwayat hukuman disiplin*/
    public function postVerrhukdis(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rhukdis);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rhukdis','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgsk','tgmul','tgsel');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_hukdis')->insert($data);
                    if($rs){
                        \DB::table('r_hukdis_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_hukdis_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_hukdis')->where('id', $input['id_rhukdis'])->update($data);
                    if($rs){
                        \DB::table('r_hukdis_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_hukdis_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_hukdis')->where('id', $input['id_rhukdis'])->delete();
                    if($rs){
                        \DB::table('r_hukdis_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_hukdis_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function index riwayat pppk detail*/
    public function getRpppkdetail(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }else if(Input::get('nip')!=''){
            $where.= " and tb_01.nip = \"".Input::get('nip')."\" ";
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpppks = \DB::table('r_pppk_temp')
                ->select(
                'r_pppk_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan','tb_01.idskpd','a_skpd.path',
                \DB::raw('if(r_pppk_temp.idjenjab>4, "Struktural", if(r_pppk_temp.idjenjab=2, "Fungsional Tertentu", if(r_pppk_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_pppk_temp.idesl', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_pppk_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_pppk_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_pppk_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_pppk_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpppks = \DB::table('r_pppk_temp')
                ->select(
                'r_pppk_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan', 'tb_01.idskpd','a_skpd.path',
                \DB::raw('if(r_pppk_temp.idjenjab>4, "Struktural", if(r_pppk_temp.idjenjab=2, "Fungsional Tertentu", if(r_pppk_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_pppk_temp.idesl', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_pppk_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_pppk_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_pppk_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_pppk_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rpppk_detail', compact('rpppks'));
    }

    /*function index riwayat pppk*/
    public function getRpppk(){
        /*cekAjax();*/
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd')) {
            (Input::has('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            $rpppks = \DB::table('r_pppk_temp')
                ->select(
                'r_pppk_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan','tb_01.idskpd','a_skpd.path',
                \DB::raw('if(r_pppk_temp.idjenjab>4, "Struktural", if(r_pppk_temp.idjenjab=2, "Fungsional Tertentu", if(r_pppk_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_pppk_temp.idesl', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_pppk_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_pppk_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_pppk_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_pppk_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rpppks = \DB::table('r_pppk_temp')
                ->select(
                'r_pppk_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan', 'tb_01.idskpd','a_skpd.path',
                \DB::raw('if(r_pppk_temp.idjenjab>4, "Struktural", if(r_pppk_temp.idjenjab=2, "Fungsional Tertentu", if(r_pppk_temp.idjenjab=3, "Fungsional Umum", "-"))) as jenis_jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
            )
                ->join('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')
                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'r_pppk_temp.idesl', '=', 'a_esl.idesl')
                ->leftjoin('a_tugasgurudosen', 'r_pppk_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->leftjoin('a_tugasdokter', 'r_pppk_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                ->leftjoin('a_penetapsk', 'r_pppk_temp.pejmen', '=', 'a_penetapsk.id')
                ->whereRaw($where)
                ->orderBy('r_pppk_temp.created_at', 'desc')
                ->orderBy('tb_01.idskpd', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('perubahanriwayat::rpppk', compact('rpppks'));
    }

    /*function verifikasi riwayat pppk*/
    public function postVerrpppk(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, \BiodataModel::$rpppk);
        if ($validation->passes()){
            if($input['status'] == 1){
                $arrnot = array('','_token','id','id_rpppk','idjnsaksi','status','ketditolak');
            }else{
                $arrnot = array('','_token');
            }
            $keydate = array('','tgsk','tmtjab','tglskmutasi','tmtmutasi','tglsk_pppk','tmtawal','tmtakhir','tglsk_calon');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    if($value != ''){
                        $val = explode("-",$value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    }else{
                        $value = '0000-00-00';
                    }
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            if($input['idjnsaksi'] == 1){
                if($input['status'] == 1){
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                      // $rs = \DB::table('r_pppk')->insert($data);
                    $rs = \DB::table('r_pppk')->insertGetId($data);
                    if($rs){
                    // copy data dari file temp ke file utama
                        $columnsToCopy = [
                            'filename',
                            'kode',
                            'size',
                            'nip',
                            'user_id',
                            'role_id',
                            'created_at',
                            'status',
                            'jenis',
                            //'subjenis',
                            //'subsubjenis',
                            'riwayat_flag',
                            'verified'
                        ];
                        $totalRowsInserted = 0;
                        $masterTable = 'files';
                        // Gunakan CHUNK untuk memproses 500 baris sekaligus, menghemat memori
                        \DB::connection('efile_2017')->table('files_temp')
                            ->select($columnsToCopy)
                            ->where('subjenis', $input['id'])
                            ->chunk(500, function ($tempRecords) use ($masterTable, &$totalRowsInserted, $rs) {

                                $dataToInsert = [];

                                // Ubah Collection menjadi array data mentah yang dibutuhkan oleh insert()
                                foreach ($tempRecords as $record) {


                                    // Karena $record adalah StdClass, kita konversi ke array terlebih dahulu
                                    $row = (array) $record;

                                    // Tambahkan kunci 'subjenis' ke dalam array baris ini
                                    $row['subjenis'] = $rs;
  $row['subsubjenis'] = '40';
                                    // Tambahkan baris yang sudah lengkap (termasuk subjenis) ke array utama
                                    $dataToInsert[] = $row;
                                }

                                // Lakukan INSERT BATCH pada tabel utama
                                if (!empty($dataToInsert)) {
                                    $inserted = \DB::connection('efile_2017')->table($masterTable)->insert($dataToInsert);
                                    $totalRowsInserted += count($dataToInsert);
                                }
                            });

                        // end
                        \DB::connection('efile_2017')->table('files_temp')->where('subjenis', $input['id'])->delete();

                    
                        \DB::table('r_pppk_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_pppk_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 2){
                if($input['status'] == 1){
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    $rs = \DB::table('r_pppk')->where('id', $input['id_rpppk'])->update($data);
                    if($rs){
                        \DB::table('r_pppk_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else if($input['status'] == 2){
                    $rs = \DB::table('r_pppk_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }else if($input['idjnsaksi'] == 3){
                if($input['status'] == 1){
                    $rs = \DB::table('r_pppk')->where('id', $input['id_rpppk'])->delete();
                    if($rs){
                        \DB::table('r_pppk_temp')->where('id', $input['id'])->delete();
                        echo "4";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }else{
                    $rs = \DB::table('r_pppk_temp')->where('id', $input['id'])->update($data);
                    if($rs){
                        echo "5";
                    }else{
                        echo "Data Gagal Disimpan";
                    }
                }
            }
            if($input['status'] == 1){
                $verfile = \DB::connection('efile_2017')->table('files')
                    ->where('nip','=',\Input::get('nip'))
                    ->where('subjenis','=',\Input::get('id_rpppk'))
                    ->update(array('verified' => 1, 'verifikator' => \Session::get('user_id')));
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
}
