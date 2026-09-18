<?php

namespace App\Http\Controllers;

use App\Models\SinkronisasiModel;
use App\Modules\epersonal\biodata\Models\SinkronsiasnModel;
use View, Validator, Input, Session, Redirect, Auth;


class SinkronisasiController extends Controller {

    public function __construct(SinkronisasiModel $siasn){
        $this->siasn = $siasn;
    }
    
    public function getIndex() {
        echo $this->siasn->getTest();
    }

    /*function simpan riwayat dikstru pegawai bkn to simpeg*/
    public function postSyncrdikstrubkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rdikstrusync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                //'tahun' => $input['tahun'],
                'idsapk' => $input['iddikstrubkn'],
                'iddikstru' => $this->siasn->getTable('a_dikstru', 'iddikstru', $input['latihanStrukturalId'], 'idsapk'),
                'dikstru' => $input['latihanStrukturalNama'],
                'tgsttpdikstru' => date('Y-m-d', strtotime($input['tanggal'])),
                'tgsel' => date('Y-m-d', strtotime($input['tanggalSelesai'])),
                'penyelenggara' => $input['institusiPenyelenggara'],
                'nosttpdikstru' => $input['nomor'],
                'jamhari' => $input['jumlahJam'],
                'idjendiklat' => 1,
                'latthn' => date('Y', strtotime($input['tanggal'])),
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            $rscek = \DB::table('r_dikstru')->where('idsapk', $input['iddikstrubkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_dikstru')->where('idsapk', $input['iddikstrubkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_dikstru')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat dikstru pegawai simpeg to bkn*/
    public function postSyncrdikstrusimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->dikstruSerializeData($input);
        $send = accessDatapostsiasn('diklat/save',$dataSend);

        if ($send->message == "success") {
            $this->saveRdikstrumodal($input);
            $update =  \DB::table('r_dikstru')->where('id', $input['id'])
                ->update(['idsapk'=>  $send->{'mapData'}->rwDiklatId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat dikstru pegawai simpeg to bkn*/
    private function dikstruSerializeData($data)
    {
        $tahun = date('Y', strtotime($data['tgsttpdikstru']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahun' => (int)$tahun,
            'latihanStrukturalId' => $this->siasn->getTable('a_dikstru', 'iddikstru', $data['iddikstru'], 'idsapk'),
            'latihanStrukturalNama' => $data['dikstru'],
            'tanggal' => $data['tgsttpdikstru'],
            'tanggalSelesai' => $data['tgsel'],
            'nomor' => $data['nosttpdikstru'],
            'jumlahJam' => (int)$jam,
            'institusiPenyelenggara' => $data['penyelenggara'],
            'pnsOrangId' => $this->siasn->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan rdikstru simpeg sekaligus sinkron siasn*/
    function saveRdikstrumodal($input){
        $arrnot = array('','_token','idjnsaksi','iddikstrubkn');
        $keydate = array('','tgmul','tgsel','tgsttpdikstru');

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('user_id');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_dikstru')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat seminar pegawai bkn to simpeg*/
    public function postSyncrseminarbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rseminarsync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'idsapk' => $input['idseminarbkn'],
                'nmseminar' => $input['namaKursus'],
                'jamhari' => $input['jumlahJam'],
                'tgmul' => date('Y-m-d', strtotime($input['tanggalKursus'])),
                'tgsel' => date('Y-m-d', strtotime($input['tanggalSelesaiKursus'])),
                'penyelenggara' => $input['institusiPenyelenggara'],
                'nopiagam' => $input['noSertipikat'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            $rscek = \DB::table('r_seminar')->where('idsapk', $input['idseminarbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_seminar')->where('idsapk', $input['idseminarbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_seminar')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat seminar pegawai simpeg to bkn*/
    public function postSyncrseminarsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->seminarSerializeData($input);
        $send = accessDatapostsiasn('kursus/save',$dataSend);

        if ($send->message == "success") {
            $this->saveRseminarmodal($input);
            $update =  \DB::table('r_seminar')->where('id', $input['id'])
                ->update(['idsapk'=>  $send->{'mapData'}->rwKursusId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat seminar pegawai simpeg to bkn*/
    private function seminarSerializeData($data)
    {
        $tahun = date('Y', strtotime($data['tgmul']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahunKursus' => (int)$tahun,
            'jenisDiklatId' => '9',
            'jenisKursusSertipikat' => 'P',
            'namaKursus' => $data['nmseminar'],
            'tanggalKursus' => $data['tgmul'],
            'tanggalSelesaiKursus' => $data['tgsel'],
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nopiagam'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan rseminar simpeg sekaligus sinkron siasn*/
    function saveRseminarmodal($input){
        $arrnot = array('','_token','idjnsaksi','idseminarbkn');
        $keydate = array('','tgmul','tgsel','tgsttpseminar');

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_seminar')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat dikfung pegawai bkn to simpeg*/
    public function postSyncrdikfungbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rdikfungsync);
        if ($validation->passes()){
            $arrnot = array('','_token');
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
            if($rscek > 0){
                echo (\DB::table('r_dikfung')->where('idsapk', $input['iddikfungbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_dikfung')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat dikfung pegawai simpeg to bkn*/
    public function postSyncrdikfungsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->dikfungSerializeData($input);
        $send = accessDatapostsiasn('kursus/save',$dataSend);

        if ($send->message == "success") {
            $this->saveRdikfungmodal($input);
            $update =  \DB::table('r_dikfung')->where('id', $input['id'])
                ->update(['idsapk'=>  $send->{'mapData'}->rwKursusId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        
        }
    }

    /*function simpan riwayat dikfung pegawai simpeg to bkn*/
    private function dikfungSerializeData($data)
    {
        $tahun = date('Y', strtotime($data['tgsttpdikfung']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahunKursus' => (int)$tahun,
            'jenisDiklatId' => '2',
            'jenisKursusSertipikat' => 'F',
            'namaKursus' => $data['dikfung'],
            // 'tanggalKursus' => $data['tgsttpdikfung'],
            // 'tanggalSelesaiKursus' => $data['tgsel'],
        	'tanggalKursus' => date('d-m-Y', strtotime($data['tgsttpdikfung'])),
            'tanggalSelesaiKursus' => date('d-m-Y', strtotime($data['tgsel'])),
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdikfung'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $this->siasn->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan rdikfung simpeg sekaligus sinkron siasn*/
    function saveRdikfungmodal($input){
        $arrnot = array('','_token','idjnsaksi','iddikfungbkn');
        $keydate = array('','tgmul','tgsel','tgsttpdikfung');

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_dikfung')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat diktek pegawai bkn to simpeg*/
    public function postSyncrdiktekbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rdikteksync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'idsapk' => $input['iddiktekbkn'],
                #'idjendik_SAPK' => 3,
                #'iddiktek' => getIdkursus($input['namaKursus'], 3),
                'nmdiktek' => $input['namaKursus'],
                // 'tgsttpdiktek' => $input['tanggalKursus'],
                // 'tgmul' => $input['tanggalKursus'],
                // 'tgsel' => $input['tanggalSelesaiKursus'],
                'tgsttpdiktek' => date('Y-m-d', strtotime($input['tanggalKursus'])),
                'tgmul' => date('Y-m-d', strtotime($input['tanggalKursus'])),
                'tgsel' => date('Y-m-d', strtotime($input['tanggalSelesaiKursus'])),
                'penyelenggara' => $input['institusiPenyelenggara'],
                'nosttpdiktek' => $input['noSertipikat'],
                'jamhari' => $input['jumlahJam'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            $rscek = \DB::table('r_diktek')->where('idsapk', $input['iddiktekbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_diktek')->where('idsapk', $input['iddiktekbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_diktek')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat diktek pegawai simpeg to bkn*/
    public function postSyncrdikteksimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->diktekSerializeData($input);
        $send = accessDatapostsiasn('kursus/save',$dataSend);

        if ($send->message == "success") {
            $this->saveRdiktekmodal($input);
            $update =  \DB::table('r_diktek')->where('id', $input['id'])
                ->update(['idsapk'=>  $send->{'mapData'}->rwKursusId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat diktek pegawai simpeg to bkn*/
    private function diktekSerializeData($data)
    {
        $tahun = date('Y', strtotime($data['tgsttpdiktek']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahunKursus' => (int)$tahun,
            'jenisDiklatId' => '3',
            'jenisKursusSertipikat' => 'T',
            'namaKursus' => $data['nmdiktek'],

            // edited candra 15072024
            // tidak bisa sincron siasn
            'tanggalKursus' => date('d-m-Y', strtotime($data['tgsttpdiktek'])),
            'tanggalSelesaiKursus' => date('d-m-Y', strtotime($data['tgsel'])),
            // 'tanggalKursus' => $data['tgsttpdiktek'],
            // 'tanggalSelesaiKursus' => $data['tgsel'],
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdiktek'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $this->siasn->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan rdiktek simpeg sekaligus sinkron siasn*/
    function saveRdiktekmodal($input){
        $arrnot = array('','_token','idjnsaksi','iddiktekbkn');
        $keydate = array('','tgmul','tgsel','tgsttpdiktek');

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_diktek')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat akredit pegawai bkn to simpeg*/
    public function postSyncrakreditbkn()
    {
        cekAjax();
        $input = Input::all();
      if($input['kreditPenunjangBaru']==''){
            $input['kreditPenunjangBaru']='0';
      $kpbaru='0';
            }else{
            $kpbaru=$input['kreditPenunjangBaru'];
            }
            if($input['kreditUtamaBaru']==''){
                    $input['kreditUtamaBaru']='0';
            $kubaru='0';
            }else{
           $kubaru=$input['kreditUtamaBaru'];
            }
        $validation = \Validator::make($input, SinkronsiasnModel::$rakreditsync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');
        
               
            $data = array(
                'nip' => $input['nip'],
            'jabfung' => $input['jabfung'],
                'idsapk' => $input['idakreditbkn'],
                'kbtotal' => $input['kreditBaruTotal'],
                'kpbaru' => $kpbaru,
                'kubaru' =>$kubaru,
                'nosk' => $input['nomorSk'],
                'periodemulai' => date('Y-m-d', strtotime($input['tahunMulaiPenailan'])),
                'periodeselesai' => date('Y-m-d', strtotime($input['tahunSelesaiPenailan'])),
                'tgsk' => date('Y-m-d', strtotime($input['tanggalSk'])),
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );
$rscek = \DB::table('r_akredit')->where('idsapk', $input['idakreditbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_akredit')->where('idsapk', $input['idakreditbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_akredit')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat akredit pegawai simpeg to bkn*/
    public function postSyncrakreditsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
   $getjabfung = \DB::table('r_jab')->where('idjab', $input['idjabfung'])->where('nip', $input['nip'])->orderBy('tmtjab', 'desc')->take(1)->get();
       $input['rwJabatanId'] = $getjabfung[0]->idjabbkn;
        if (!empty($input['idakreditbkn'])) {
            $input['idakred'] = $input['idakreditbkn'];
        } else {
            $input['idakred'] = null;
        }
        $dataSend = $this->akreditSerializeData($input);
    //print_r($getjabfung);
     //print_r($input);
    //print_r($dataSend);
        $send = accessDatapostsiasn('angkakredit/save',$dataSend);

        if ($send->message == "success") {
            $this->saveRakreditmodal($input);
            $update =  \DB::table('r_akredit')->where('id', $input['id'])
                ->update(['idsapk'=>  $send->{'mapData'}->rwAngkaKreditId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat akredit pegawai simpeg to bkn*/
    private function akreditSerializeData($data)
    {
    if ($data['jenisakred'] == "1") {
            $isAngkaKreditPertama = '1';
            $isintegrasi = '0';
            $iskonversi = '0';
        } else if ($data['jenisakred'] == "2") {
            $isAngkaKreditPertama = '0';
            $isintegrasi = '1';
            $iskonversi = '0';
        } else {
            $isAngkaKreditPertama = '0';
            $isintegrasi = '0';
            $iskonversi = '1';
        }
        $dataSend  = [
            'id' => $data['idakred'],
            'nip' => $data['nip'],
            'isAngkaKreditPertama' => '-',
            'kreditBaruTotal' => $data['kbtotal'],
            'kreditPenunjangBaru' => $data['kpbaru'],
            'kreditUtamaBaru' => $data['kubaru'],
            'nomorSk' => $data['nosk'],
            'BulanMulaiPenailan' => (string)date('m', strtotime($data['periodemulai'])),
            'TahunMulaiPenailan' => (string)date('Y', strtotime($data['periodemulai'])),
            'BulanSelesaiPenailan' => (string)date('m', strtotime($data['periodeselesai'])),
            'TahunSelesaiPenailan' => (string)date('Y', strtotime($data['periodeselesai'])),

            /*'bulanMulaiPenilaian' => (string)date('m', strtotime($data['periodemulai'])),
            'bulanSelesaiPenilaian' => (string)date('m', strtotime($data['periodeselesai'])),
            'tahunMulaiPenilaian' => (string)date('Y', strtotime($data['periodemulai'])),
            'tahunSelesaiPenilaian' => (string)date('Y', strtotime($data['periodeselesai'])),*/

            'tanggalSk' => $data['tgsk'],
            'pnsId' => $this->siasn->getPnsIdSapk($data['nip']),
            'pnsUserId' => $this->siasn->getPnsIdSapk($data['nip']),
        'rwJabatanId' => $data['rwJabatanId'],
        'isAngkaKreditPertama' => $isAngkaKreditPertama,
            'isIntegrasi' => $isintegrasi,
            'isKonversi' => $iskonversi,
        ];

        return $dataSend;
    }

    /*simpan rakredit simpeg sekaligus sinkron siasn*/
    function saveRakreditmodal($input){
        $arrnot = array('','_token','idjnsaksi','idakreditbkn');
        $keydate = array('','tgsk','periodemulai','periodeselesai');

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_akredit')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat skp22 pegawai bkn to simpeg*/
    public function postSyncrskp22bkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rskp22sync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'idsapk' => $input['idskpbkn'],
                'tahun' => $input['tahun'],
                //'nama' => $this->siasn->getAttpegawai($input['nip'], "namalengkap"),
                //'idgol' => $this->siasn->getAttpegawai($input['nip'], "idgolrupkt"),
                //'gol' => $this->siasn->getAttpegawai($input['nip'], "golrupkt"),
                //'idjenjab' => $this->siasn->getAttpegawai($input['nip'], "namalengkap"),
                //'idjab' => $this->siasn->getAttpegawai($input['nip'], "idjab"),
                //'jab' => $this->siasn->getAttpegawai($input['nip'], "jabatan"),
                //'idskpd' => $this->siasn->getAttpegawai($input['nip'], "idskpd"),
                //'skpd' => $this->siasn->getAttpegawai($input['nip'], "skpd"),
                'capaiankinerja' => ucwords(strtolower($input['kuadranKinerjatext'])),
                'ratinghasil' => ucwords(strtolower($input['hasilKinerjatext'])),
                'ratingperilaku' => ucwords(strtolower($input['perilakuKerjatext'])),
                'predikatkinerja' => ucwords(strtolower($input['kuadranKinerjatext'])),
                //'statusPenilai' => (($input['statusPenilai'] == 'ASN')?'1':'2'),
                'nippenilai' => $input['nipNrpPenilai'],
                'pejpenilai' => $input['namaPenilai'],
                'jabpenilai' => $input['penilaiJabatanNm'],
                //'idgolpenilai' => $input['penilaiGolonganId'],
                'skpd' => $input['penilaiUnorNm'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => gmdate("Y-m-d H:i", time()+60*60*7)
            );

            $rscek = \DB::table('r_kinerjaasn')->where('idsapk', $input['idskpbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_kinerjaasn')->where('idsapk', $input['idskpbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_kinerjaasn')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat skp22 pegawai simpeg to bkn*/
    public function postSyncrskp22simpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->skp22SerializeData($input);
  $send = accessDatapostsiasn('skp22/save', $dataSend);

        if ($send->message == "success") {
            $this->saveRskp22modal($input);
            $update =  \DB::table('r_kinerjaasn')->where('id', $input['id'])
                ->update(['idsapk' =>  $send->mapData]); //$send->{'mapData'}->rwKursusId]
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, ' . $send->message;
        }
    }

    /*function simpan riwayat skp22 pegawai simpeg to bkn*/
    private function skp22SerializeData($data)
    {
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahun' => (int)$data['tahun'],

            'hasilKinerjaNilai' =>(int)getAttr('a_perilaku_kerja', 'perilaku_kerja', $data['ratinghasil'], 'id'),
            'perilakuKerjaNilai' => (int)getAttr('a_perilaku_kerja', 'perilaku_kerja', $data['ratingperilaku'], 'id'),
            'kuadranKinerjaNilai' => (int)getAttr('a_kuadran_kerja', 'kuadran_kerja', $data['predikatkinerja'], 'id'),
            'statusPenilai' => 'ASN',
            'penilaiNipNrp' => $data['nippenilai'],
            'penilaiNama' => $data['pejpenilai'],
            'penilaiJabatan' => $data['jabpenilai'],
            'penilaiUnorNama' => $data['skpd'],
            'penilaiGolongan' => getAttr('tb_01', 'nip', $data['nippenilai'], 'idgolrupkt'),

            'pnsDinilaiOrang' => $this->siasn->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    /*simpan skp22 simpeg sekaligus sinkron siasn*/
    function saveRskp22modal($input){
        $arrnot = array('','_token','idjnsaksi','idskpbkn');
        $keydate = array('',);

        foreach ($_POST as $key=>$value) {
            if (array_search($key, $keydate)!='') {
                $val = explode("-", $value);
                $value = $val[2]."-".$val[1]."-".$val[0];
            }
            if (array_search($key, $arrnot)=="") {
                $data[$key] = $value;
            }
        }

        $data['user_id'] = \Session::get('is_nip');
        $data['role_id'] = \Session::get('role_id');

        \DB::table('r_kinerjaasn')->where('id', $input['id'])->update($data);
    }

    /*function simpan riwayat skp pegawai bkn to simpeg*/
    public function postSyncrskpbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, SinkronsiasnModel::$rskpsync);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'tahun' => $input['tahun'],
                'nilai' => $input['nilaiSkp'],
                'idjenjab' => $input['jenisJabatan'],
                'jenisppk' => substr($input['jenisPeraturanKinerjaKd'],-2),
                'orpel' => $input['orientasiPelayanan'],
                'integritas' => $input['integritas'],
                'komitmen' => $input['komitmen'],
                'disiplin' => @$input['disiplin'],
                'kerjasama' => $input['kerjasama'],
                'pim' => @$input['kepemimpinan'],
                'jumlah' => $input['jumlah'],
                'nilairatarata' => $input['nilairatarata'],
                'nilaiperilaku' => $input['nilaiPerilakuKerja'],
                'nilaikinerja' => $input['nilaiPrestasiKerja'],

                'nippenilai' => $input['penilaiNipNrp'],
                'pejpenilai' => $input['penilaiNama'],
                'jabpenilai' => $input['penilaiJabatan'],
                'golpenilai' => $input['penilaiGolongan'],
                'tmtpktpenilai' => date('Y-m-d', strtotime($input['penilaiTmtGolongan'])),
                'skpdpenilai' => $input['penilaiUnorNama'],

                'nipatasan' => $input['atasanPenilaiNipNrp'],
                'pejatasan' => $input['atasanPenilaiNama'],
                'jabatasan' => $input['atasanPenilaiJabatan'],
                'golatasan' => $input['atasanPenilaiGolongan'],
                'tmtpktatasan' => date('Y-m-d', strtotime($input['atasanPenilaiTmtGolongan'])),
                'skpdatasan' => $input['atasanPenilaiUnorNama'],

                'statusPenilai' => $input['statusPenilai'],
                'statusAtasan' => $input['statusAtasanPenilai'],
                'idbkn' => $input['idskpbkn'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            echo "<pre>";
            print_r($data);
            echo "</pre>";
            exit();

            $rscek = \DB::table('r_skp')->where('idbkn', $input['idskpbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_skp')->where('idbkn', $input['idskpbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_skp')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat siasn pegawai simpeg to bkn*/
    public function postSyncrskpsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->skpSerializeData($input);

        echo "<pre>";
        print_r($dataSend);
        echo "</pre>";
        exit();

        $send = accessDatapostsiasn('skp/2021/save',$dataSend);

        if ($send->message == "success") {
            $update =  \DB::table('r_skp')->where('id', $input['id'])
                ->update(['idbkn'=>  $send->mapData]); //$send->{'mapData'}->rwSkpId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat skp pegawai simpeg to bkn*/
    private function skpSerializeData($data)
    {
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahun' => (int)$data['tahun'],
            'nilaiSkp' => (float)$data['nilai'],
            'jenisJabatan' => (($data['idjenjab'] == 3)?4:$data['idjenjab']),
            'jenisPeraturanKinerjaKd' => (($data['jenisppk']!='')?'PP'.$data['jenisppk']:''),
            'orientasiPelayanan' => (float)$data['orpel'],
            'integritas' => (float)$data['integritas'],
            'komitmen' => (float)$data['komitmen'],
            'disiplin' => (float)(($data['disiplin']!='')?$data['disiplin']:0.01),
            'kerjasama' => (float)(($data['kerjasama']!='')?$data['kerjasama']:0.01),
            'kepemimpinan' => (float)$data['pim'],
            'jumlah' => (float)$data['jumlah'],
            'nilairatarata' => (float)$data['nilairatarata'],
            'nilaiPerilakuKerja' => (float)$data['nilaiperilaku'],
            'nilaiPrestasiKerja' => (float)$data['nilaikinerja'],

            'penilaiNipNrp' => $data['nippenilai'],
            'penilaiNama' => $data['pejpenilai'],
            'penilaiJabatan' => $data['jabpenilai'],
            'penilaiGolongan' => $data['golpenilai'],
            'penilaiTmtGolongan' => $data['tmtpktpenilai'],
            'penilaiUnorNama' => $data['skpdpenilai'],

            'atasanPenilaiNipNrp' => $data['nipatasan'],
            'atasanPenilaiNama' => $data['pejatasan'],
            'atasanPenilaiJabatan' => $data['jabatasan'],
            'atasanPenilaiGolongan' => $data['golatasan'],
            'atasanPenilaiTmtGolongan' => $data['tmtpktatasan'],
            'atasanPenilaiUnorNama' => $data['skpdpenilai'],

            'inisiatifKerja' => 0.01,
            'konversiNilai' => 0.01,
            'nilaiIntegrasi' => 0.01,

            'statusPenilai' => 'ASN',
            'statusAtasanPenilai' => 'ASN',
            'pnsDinilaiOrang' =>  getPnsIdSapk($data['nip'],0),
            'pnsUserId' =>  \Config::get('global.pns_user_id'),
        ];

        return $dataSend;
    }

//candra
public function postIpasnopd(){
 $input = Input::all();
        // print_r($input);

        $pegawais = \DB::table('tb_01')->select(
            'tb_01.nip',
            'nama',
            'tr_ipasn.kinerja',
            'tr_ipasn.hukdis',
            'tr_ipasn.kompetensi',
            'tr_ipasn.kualifikasi',
            'tr_ipasn.subtotal',
            'tr_ipasn.tgipasn',
            'idgolrupkt',
            'idesljbt',
            'idskpd',
            'tmtpkt',
            'tmtesljbt',
            'tmtcpn',
            'a_jenjab.order as order',
            'a_golruang.golru',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan'
        )

            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            // ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            // ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            // ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
            ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
            ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . $input['id'] . '%')->where('idstspeg', '=', 2)
            ->orderBy(\DB::raw('a_jenjab.order,tb_01.idesljbt asc,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
            ->get();

        foreach ($pegawais as $pegawai) {

            // if ($pegawai->nip == '196706172008011004') {
            $bkn = accessDatariwayatsiasn('pns/nilaiipasn', $pegawai->nip);
            // $kinerja = $bkn->kinerja;
            // $disiplin = $bkn->disiplin;
            // $kompetensi = $bkn->kompetensi;
            // $kualifikasi = $bkn->kualifikasi;

            $rscek = \DB::table('tr_ipasn')->where('nip', $pegawai->nip)
                // ->where('tgipasn', date('Y-m-d', strtotime($bkn->created_at)))
                ->count();

            if ($rscek > 0) {
              $tanggal = date('Y-m-d', strtotime($bkn->created_at));
            $sqlstring = "update tr_ipasn set tgipasn='$tanggal',kinerja='$bkn->kinerja',hukdis='$bkn->disiplin',kompetensi='$bkn->kompetensi',kualifikasi='$bkn->kualifikasi',subtotal='$bkn->subtotal',instansiKerjaId='$bkn->instansiKerjaId',unorIndukNama='$bkn->unorIndukNama',tahun='$bkn->tahun' where nip='$pegawai->nip'";
            \DB::statement($sqlstring);
//                 try {
//                     // \DB::table('tr_ipasn')->delete()->where('nip', $pegawai->nip);
//                     \DB::table('tr_ipasn')->update([
//                         // 'nip' => $pegawai->nip,
//                         'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
//                         'kinerja' => $bkn->kinerja,
//                         'hukdis' => $bkn->disiplin,
//                         'kompetensi' => $bkn->kompetensi,
//                         'kualifikasi' => $bkn->kualifikasi,
//                         'subtotal' => $bkn->subtotal,
//                     'instansiKerjaId' => $bkn->instansiKerjaId,
//                 'unorIndukNama' => $bkn->unorIndukNama,
//                 'tahun' => $bkn->tahun,
//                     ])->where('nip', $pegawai->nip);
//                     // echo '1';

//                 //     \DB::table('tr_ipasn')->insert([
//                 //         'nip' => $pegawai->nip,
//                 //         'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
//                 //         'kinerja' => $bkn->kinerja,
//                 //         'hukdis' => $bkn->disiplin,
//                 //         'kompetensi' => $bkn->kompetensi,
//                 //         'kualifikasi' => $bkn->kualifikasi,
//                 //         'subtotal' => $bkn->subtotal,
//                 //      'instansiKerjaId' => $bkn->instansiKerjaId,
//                 // 'unorIndukNama' => $bkn->unorIndukNama,
//                 // 'tahun' => $bkn->tahun,
//                 //     ]);
//                 } catch (\Exception $e) {
//                     echo $e->getMessage();
//                 }
            } else {
                try {
                    \DB::table('tr_ipasn')->insert([
                        'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
                     'instansiKerjaId' => $bkn->instansiKerjaId,
                'unorIndukNama' => $bkn->unorIndukNama,
                'tahun' => $bkn->tahun,
                    ]);
                    echo '1';
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            echo 'done';
            // }
        }
}

public function postCipasnglobal(){
 $input = Input::all();
        $pegawais = \DB::table('tb_01')->select(
            'tb_01.nip',
            'nama',
            'tr_ipasn.kinerja',
            'tr_ipasn.hukdis',
            'tr_ipasn.kompetensi',
            'tr_ipasn.kualifikasi',
            'tr_ipasn.subtotal',
            'tr_ipasn.tgipasn',
            'idgolrupkt',
            'idesljbt',
            'idskpd',
            'tmtpkt',
            'tmtesljbt',
            'tmtcpn',
            'a_jenjab.order as order',
            'a_golruang.golru',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan'
        )

            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            // ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            // ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            // ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
            ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
            ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . $input['id'] . '%')->where('idstspeg', '=', 2)
            ->orderBy(\DB::raw('a_jenjab.order,tb_01.idesljbt asc,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
            ->get();

        foreach ($pegawais as $pegawai) {

            // if ($pegawai->nip == '196706172008011004') {
            $bkn = accessDatariwayatsiasn('pns/nilaiipasn', $pegawai->nip);
            // $kinerja = $bkn->kinerja;
            // $disiplin = $bkn->disiplin;
            // $kompetensi = $bkn->kompetensi;
            // $kualifikasi = $bkn->kualifikasi;

            $simpan = array(
                'nip' => $pegawai->nip,
                'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                'kinerja' => $bkn->kinerja,
                'hukdis' => $bkn->disiplin,
                'kompetensi' => $bkn->kompetensi,
                'kualifikasi' => $bkn->kualifikasi,
                'subtotal' => $bkn->subtotal,
            );


            $rscek = \DB::table('tr_ipasn')->where('nip', $pegawai->nip)
                // ->where('tgipasn', date('Y-m-d', strtotime($bkn->created_at)))
                ->count();

            if ($rscek > 0) {
             $tanggal = date('Y-m-d', strtotime($bkn->created_at));
            $sqlstring = "update tr_ipasn set tgipasn='$tanggal',kinerja='$bkn->kinerja',hukdis='$bkn->disiplin',kompetensi='$bkn->kompetensi',kualifikasi='$bkn->kualifikasi',subtotal='$bkn->subtotal',instansiKerjaId='$bkn->instansiKerjaId',unorIndukNama='$bkn->unorIndukNama',tahun='$bkn->tahun' where nip='$pegawai->nip'";
            \DB::statement($sqlstring);
                // try {
                //     \DB::table('tr_ipasn')->update([
                //         // 'nip' => $pegawai->nip,
                //         'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                //         'kinerja' => $bkn->kinerja,
                //         'hukdis' => $bkn->disiplin,
                //         'kompetensi' => $bkn->kompetensi,
                //         'kualifikasi' => $bkn->kualifikasi,
                //         'subtotal' => $bkn->subtotal,
                //      'instansiKerjaId' => $bkn->instansiKerjaId,
                // 'unorIndukNama' => $bkn->unorIndukNama,
                // 'tahun' => $bkn->tahun,
                //     ])->where('nip', $pegawai->nip);
                //     echo '1';
                // } catch (\Exception $e) {
                //     echo $e->getMessage();
                // }
            } else {
                try {
                    \DB::table('tr_ipasn')->insert([
                        'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
                     'instansiKerjaId' => $bkn->instansiKerjaId,
                'unorIndukNama' => $bkn->unorIndukNama,
                'tahun' => $bkn->tahun,
                    ]);
                    echo '1';
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                echo 'tidak ada';
            }

            echo '<br/>';
            // }
        }
}

 public function postCipasn()
    {
 $input = Input::all();
        $nip = $input['id'];
 
 
 
         $lines = file('packages/tugumuda/token/token-key.txt');
        $kadaluarsa = strtotime(date($lines[0]));
        $skrg = strtotime(date('Y-m-d H:i:s'));
        if ($skrg > $kadaluarsa) {
            getTokenWSO2(ENV('CONSUMER_KEY'), ENV('CONSUMER_SECRET'), ENV('MODE'));
        }

        $lines2 = file('packages/tugumuda/token/token-sso.txt');
        $kadaluarsa2 = strtotime(date($lines2[0]));
        if ($skrg > $kadaluarsa2) {
            getTokenSSO(ENV('CLIENT_ID'), ENV('UNAME'), ENV('PSWD'), ENV('MODE'));
        }


        $base_url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/';

        $resultApi = apiResult($base_url . 'pns/nilaiipasn/' . $nip);
        $obj = json_decode($resultApi);
        $bkn  = $obj->{'data'};
print_r($bkn);
//         // $bkn = accessDatariwayatsiasn('pns/nilaiipasn', $nip);
            $rscek = \DB::table('tr_ipasn')->where('nip', $nip)
                    ->count();

        if ($rscek > 0) {
        
         $tanggal = date('Y-m-d', strtotime($bkn->created_at));
            $sqlstring = "update tr_ipasn set tgipasn='$tanggal',kinerja='$bkn->kinerja',hukdis='$bkn->disiplin',kompetensi='$bkn->kompetensi',kualifikasi='$bkn->kualifikasi',subtotal='$bkn->subtotal',instansiKerjaId='$bkn->instansiKerjaId',unorIndukNama='$bkn->unorIndukNama',tahun='$bkn->tahun' where nip='$nip'";
            \DB::statement($sqlstring);
         
        // print_r($rscek);
//             // try {
//             //     \DB::table('tr_ipasn')->update([
//             //         'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
//             //         'kinerja' => $bkn->kinerja,
//             //         'hukdis' => $bkn->disiplin,
//             //         'kompetensi' => $bkn->kompetensi,
//             //         'kualifikasi' => $bkn->kualifikasi,
//             //         'subtotal' => $bkn->subtotal,
//             //     'instansiKerjaId' => $bkn->instansiKerjaId,
//             //     'unorIndukNama' => $bkn->unorIndukNama,
//             //     'tahun' => $bkn->tahun,
//             //     ])->where('nip', $nip);
                echo '1';
//             // } catch (\Exception $e) {
//             //     echo $e->getMessage();
//             // }
        } else {
            try {
                \DB::table('tr_ipasn')->insert([
                    'nip' => $nip,
                    'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                    'kinerja' => $bkn->kinerja,
                    'hukdis' => $bkn->disiplin,
                    'kompetensi' => $bkn->kompetensi,
                    'kualifikasi' => $bkn->kualifikasi,
                    'subtotal' => $bkn->subtotal,
                 'instansiKerjaId' => $bkn->instansiKerjaId,
                'unorIndukNama' => $bkn->unorIndukNama,
                'tahun' => $bkn->tahun,
                ]);
                echo '1';
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo 'tidak ada';
        }

 }

public function download($filename)
    {
        $filePath = public_path('pdf/' . $filename); // Sesuaikan dengan lokasi file PDF Anda

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404);
    }
 public function postCexcelipasn()
    {
        return View::make('home::dashboard.ipasn_excel');
    }
// end candra
}
