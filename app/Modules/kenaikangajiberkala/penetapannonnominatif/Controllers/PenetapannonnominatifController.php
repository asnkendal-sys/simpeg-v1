<?php namespace App\Modules\kenaikangajiberkala\penetapannonnominatif\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\penetapannonnominatif\Models\PenetapannonnominatifModel;
use Input,View, Request, Form, File;

/**
* Penetapannonnominatif Controller
* @var Penetapannonnominatif
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenetapannonnominatifController extends Controller {
    protected $penetapannonnominatif;

    public function __construct(PenetapannonnominatifModel $penetapannonnominatif){
        $this->penetapannonnominatif = $penetapannonnominatif;
    }

        public function getIndex(){
        cekAjax();
        $where = "tr_kgb.idkgb != ''";
        if(session('role_id') > 3){
            $where .= " and tr_kgb.kdskpd like \"".session('idskpd')."%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('bulan') != '') or (Input::get('tahun') != '') or (Input::get('jnskgb') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idstspeg') != '')) {
            if(Input::get('bulan') != ''){
                $where .= " and MID(tr_kgb.idkgb,5,2) = \"".Input::get('bulan')."\"";
            }

            if(Input::get('tahun') != ''){
                $where .= " and LEFT(idkgb,4) = \"".Input::get('tahun')."\"";
            }

            if(Input::get('jnskgb') != ''){
                $where .= " and jnskgb = \"".Input::get('jnskgb')."\"";
            }

            if(Input::get('statussk') != ''){
                $where .= " and statussk = \"".Input::get('statussk')."\"";
            }

            if(Input::get('idstspeg') != ''){
                $where .= " and b.idstspeg = \"".Input::get('idstspeg')."\"";
            }

            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and MID(idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_kgb.nip like '%".Input::get('search')."%' or tr_kgb.karpeg like '%".Input::get('search')."%' or tr_kgb.nama like '%".Input::get('search')."%')";
            }

            $penetapannonnominatifs = $this->penetapannonnominatif
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                    b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                    b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                    IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                    IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))
                ->paginate($_ENV['configurations']['list-limit']);

        }else{
            $penetapannonnominatifs = $this->penetapannonnominatif->all();
        }
        return View::make('penetapannonnominatif::index', compact('penetapannonnominatifs'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('penetapannonnominatif::create');
    }

    public function getCreatep3k()
	{
        return View::make('penetapannonnominatif::createp3k');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannonnominatifModel::$rules);
        if ($validation->passes()){

            $nip = $input['nip']; /*nip penerima kgb*/
            $tmtkgbb = $input['tmtkgbb']; /*tmt kgb*/
            $tgskkgb = $input['tgskkgb']; /*tanggal skkgb*/
            $noskkgbb = $input['noskkgbb']; /*no skkgb*/
            $mktkgbb = $input['mktkgbb']; /*masa kerja tahun*/
            $mkbkgbb = $input['mkbkgbb']; /*masa kerja bulan*/
            $golru = $input['golru']; /*golongan ruang acuan kgb*/
            $idacuan = $input['idacuan']; /*idacuan*/
            $idstspeg = $input['idstspeg'];

            $idskpd = $input['idskpd'];
            list($tgl,$bln,$thn) = explode('-', $tmtkgbb);
            $idkgb = $thn.''.$bln.'.'.$idskpd;
            $jnskgb = \PenetapannominatifModel::getJeniskgb($golru,$idskpd,$idstspeg);
            if($jnskgb == 1){
                $statususul = 1;
                $statussk = 1;
            }else{
                $statususul = 0;
                $statussk = 0;
            }

            $attr = PenetapannonnominatifModel::getattkgb($nip);
            $data = array(
                'idkgb' => $idkgb, /*id kgb group*/
                'nip' => $nip, /*nip penerima kgb*/
                'jnskgb' => $jnskgb,
                'statususul' => 0,
                'statussk' => 0,
                'statuskgb' => 2,

                'karpeg' => $attr->nokarpeg,
                'nama' => $attr->nama,
                'tmplahir' => $attr->tmlhr,
                'tgllahir' => $attr->tglhr,
                'golpns' => $attr->idgolrupkt,

                'golpnsname' => $attr->golru,
                'tmtgollama' => $attr->tmtpkt,
                'ideselon' => $attr->idesljbt,
                'eseloname' => $attr->esl,
                'tmteselon' => $attr->tmtesljbt,

                'mkthn' => $attr->mkthnpkt,
                'mkbln' => $attr->mkblnpkt,

                'jurusan' => $attr->jenjurusan,
                'thijaz' => $attr->thijaz,
                'agama' => $attr->agama,
                'usiakgb' => $attr->usia,

                'tmtkgbl' => $attr->tmtkgb,
                'mktkgbl' => $attr->mkgolthnkgb,
                'mkbkgbl' => $attr->mkgolblnkgb,
                'gkgbl' => getgaji($golru,$attr->mkgolthnkgb,$attr->idstspeg), /*besar gaji lama*/ /*$golru = $attr->idgolrupkt*/
                'noskkgbl' => $attr->noskkgb,
                'pejpenkgbl' => $attr->pejmenkgb,
                'tglskkgbl' => $attr->tgskkgb,

                'idjabskr' => $attr->idjenjab,
                'kdjabskr' => $attr->kdjabskr,
                'nmajab' => $attr->namajab,
                'kdskpdskr' => $attr->idskpd,
                'tmpskpdskr' => $attr->skpdskr,
                'golpnsskr' => $attr->golruskr,

                'iddiperbantukan' => $attr->iddiperbantukan,
                'lokdiperbantukan' => $attr->nmasekolah,

                'tmtjbt' => $attr->tmtjbt,
                'tmtkgbb' => date("Y-m-d", strtotime($tmtkgbb)), /*tmt kgb*/
                'mktkgbb' => $mktkgbb, /*thn tmt kgb*/
                'mkbkgbb' => $mkbkgbb, /*bln tmt kgb*/
                'kdgolmktkgbb' => $attr->idgolrupkt."".$mktkgbb, /*kode gol dan mkt*/
                'gkgbb' => getgaji($attr->idgolrupkt,$mktkgbb,$attr->idstspeg), /*besar gaji baru*/ /*$golru = $attr->idgolrupkt*/
                'noskkgbb' => $noskkgbb, /*nomor skkgb*/

                /*diisi sesuai kondisi skpd dan golongan*/

                'idpejab' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'idpenetap'),
                'jabpenkgbb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'jab_utuh'),
                'pejpenkgbb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'nama'),
                'nippb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'nip'),
                'golrupb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'pangkat'),
                'tglskkgbb' => date("Y-m-d", strtotime($tgskkgb)), /*tanggal sk kgb*/

                'kdskpd' => $attr->idskpd, /*id skpd sekarang*/
                'namaskpd' => $attr->skpd, /*nama skpd sekarang*/

                'acuan' => $idacuan, /*$attr->idgolrupkt*/
                'nomgpl' => terbilang(getGaji($attr->idgolrupkt,$attr->mkgolthnkgb,$attr->idstspeg))."rupiah",/*$golru = nominal gaji lama*/
                'nomgpb' => terbilang(getGaji($golru,$mktkgbb,$attr->idstspeg))."rupiah", /*$golru = nominal gaji baru*/
                'statususul' => $statususul,
                'statussk' => $statussk,
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang(),
                'user_id' => \Session::get('user_id')
            );

            if(!\DB::table('tr_kgb')->insert($data)){
                echo "Kenaikan gaji berkala gagal disimpan.";
            }else{
                echo 1;
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postCreatep3k(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannonnominatifModel::$rules);
        if ($validation->passes()){

            $nip = $input['nip']; /*nip penerima kgb*/
            $tmtkgbb = $input['tmtkgbb']; /*tmt kgb*/
            $tgskkgb = $input['tgskkgb']; /*tanggal skkgb*/
            $noskkgbb = $input['noskkgbb']; /*no skkgb*/
            $mktkgbb = $input['mktkgbb']; /*masa kerja tahun*/
            $mkbkgbb = $input['mkbkgbb']; /*masa kerja bulan*/
            $golru = $input['golru']; /*golongan ruang acuan kgb*/
            $idacuan = $input['idacuan']; /*idacuan*/
            $idstspeg = $input['idstspeg'];

            $idskpd = $input['idskpd'];
            list($tgl,$bln,$thn) = explode('-', $tmtkgbb);
            $idkgb = $thn.''.$bln.'.'.$idskpd;
            $jnskgb = \PenetapannominatifModel::getJeniskgb($golru,$idskpd,$idstspeg);
            if($jnskgb == 1){
                $statususul = 1;
                $statussk = 1;
            }else{
                $statususul = 0;
                $statussk = 0;
            }

            $attr = PenetapannonnominatifModel::getattkgb($nip);
            $data = array(
                'idkgb' => $idkgb, /*id kgb group*/
                'nip' => $nip, /*nip penerima kgb*/
                'jnskgb' => $jnskgb,
                'statususul' => 0,
                'statussk' => 0,
                'statuskgb' => 2,

                'karpeg' => $attr->nokarpeg,
                'nama' => $attr->nama,
                'tmplahir' => $attr->tmlhr,
                'tgllahir' => $attr->tglhr,
                'idstspeg' => $idstspeg,
                'golpns' => $attr->idgolrupkt,

                'golpnsname' => $attr->golru,
                'tmtgollama' => $attr->tmtpkt,
                'ideselon' => $attr->idesljbt,
                'eseloname' => $attr->esl,
                'tmteselon' => $attr->tmtesljbt,

                'mkthn' => $attr->mkthnpkt,
                'mkbln' => $attr->mkblnpkt,

                'jurusan' => $attr->jenjurusan,
                'thijaz' => $attr->thijaz,
                'agama' => $attr->agama,
                'usiakgb' => $attr->usia,

                'tmtkgbl' => $attr->tmtkgb,
                'mktkgbl' => $attr->mkgolthnkgb,
                'mkbkgbl' => $attr->mkgolblnkgb,
                'gkgbl' => getgaji($golru,$attr->mkgolthnkgb,$attr->idstspeg), /*besar gaji lama*/ /*$golru = $attr->idgolrupkt*/
                'noskkgbl' => $attr->noskkgb,
                'pejpenkgbl' => $attr->pejmenkgb,
                'tglskkgbl' => $attr->tgskkgb,

                'idjabskr' => $attr->idjenjab,
                'kdjabskr' => $attr->kdjabskr,
                'nmajab' => $attr->namajab,
                'kdskpdskr' => $attr->idskpd,
                'tmpskpdskr' => $attr->skpdskr,
                'golpnsskr' => $attr->golruskr,

                'iddiperbantukan' => $attr->iddiperbantukan,
                'lokdiperbantukan' => $attr->nmasekolah,

                'tmtjbt' => $attr->tmtjbt,
                'tmtkgbb' => date("Y-m-d", strtotime($tmtkgbb)), /*tmt kgb*/
                'mktkgbb' => $mktkgbb, /*thn tmt kgb*/
                'mkbkgbb' => $mkbkgbb, /*bln tmt kgb*/
                'kdgolmktkgbb' => $attr->idgolrupkt."".$mktkgbb, /*kode gol dan mkt*/
                'gkgbb' => getgaji($attr->idgolrupkt,$mktkgbb,$attr->idstspeg), /*besar gaji baru*/ /*$golru = $attr->idgolrupkt*/
                'noskkgbb' => $noskkgbb, /*nomor skkgb*/

                /*diisi sesuai kondisi skpd dan golongan*/
                'idpejab' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'idpenetap'),
                'jabpenkgbb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'jab_utuh'),
                'pejpenkgbb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'nama'),
                'nippb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'nip'),
                'golrupb' => PenetapannonnominatifModel::attrKepskpd($attr->idgolrupkt,$attr->idskpd,$attr->idstspeg,'pangkat'),
                'tglskkgbb' => date("Y-m-d", strtotime($tgskkgb)), /*tanggal sk kgb*/

                'kdskpd' => $attr->idskpd, /*id skpd sekarang*/
                'namaskpd' => $attr->skpd, /*nama skpd sekarang*/

                'acuan' => $idacuan, /*$attr->idgolrupkt*/
                'nomgpl' => terbilang(getGaji($attr->idgolrupkt,$attr->mkgolthnkgb,$attr->idstspeg))."rupiah",/*$golru = nominal gaji lama*/
                'nomgpb' => terbilang(getGaji($golru,$mktkgbb,$attr->idstspeg))."rupiah", /*$golru = nominal gaji baru*/
                'statususul' => $statususul,
                'statussk' => $statussk,
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang(),
                'user_id' => \Session::get('user_id')
            );

            if(!\DB::table('tr_kgb')->insert($data)){
                echo "Kenaikan gaji berkala gagal disimpan.";
            }else{
                echo 1;
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }


    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penetapannonnominatif = $this->penetapannonnominatif->find($id);
        //if (is_null($penetapannonnominatif)){return \Redirect::to('kenaikangajiberkala/penetapannonnominatif/index');}
        return View::make('penetapannonnominatif::edit', compact('penetapannonnominatif'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannonnominatifModel::$rules);
        
        if ($validation->passes()){
            $penetapannonnominatif = $this->penetapannonnominatif->find($id);
            echo ($penetapannonnominatif->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


	
        public function postDelete(){
        cekAjax();
        /*$ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->penetapannonnominatif->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penetapannonnominatif->find($ids)->delete())?9:'Gagal Dihapus';
        }*/

        $data['idkgb'] = Input::get('id');
        $data['nip'] = Input::get('nip');

        echo (\DB::table('tr_kgb')->where($data)->delete())?9:'Gagal Dihapus';
    }

    public function postAcuan(){
        cekAjax();

        $nip = Input::get('nip');
        $idacuan = Input::get('idacuan');
        $rs = '';

        /*kondisi acuan*/
        if($idacuan == '1'){
            $row = \DB::table('tb_01')
                    ->select(
                        \DB::raw("
                            idstspeg,pejmenkgb as pejmen, noskkgb as nosk, tgskkgb as tgsk, idgolrupkt as golru,
                            IF(LENGTH(mkgolthnkgb)=1,CONCAT('0',mkgolthnkgb),IF(LENGTH(mkgolthnkgb)=0,'00',mkgolthnkgb)) AS mkgolthn,
                            IF(LENGTH(mkgolblnkgb)=1,CONCAT('0',mkgolblnkgb),IF(LENGTH(mkgolblnkgb)=0,'00',mkgolblnkgb)) AS mkgolbln,
                            DATE_FORMAT(tmtkgb,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtkgb, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtkgb, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                    )
                    ->where('nip', $nip)->first();
        }else if($idacuan == '2'){
            $row = \DB::table('tb_01')
                    ->select(
                        \DB::raw("
                            idstspeg,pejmenpkt as pejmen, noskpkt as nosk, tgskpkt as tgsk, idgolrupkt as golru,
                            IF(LENGTH(mkthnpkt)=1,CONCAT('0',mkthnpkt),IF(LENGTH(mkthnpkt)=0,'00',mkthnpkt)) AS mkgolthn,
                            IF(LENGTH(mkblnpkt)=1,CONCAT('0',mkblnpkt),IF(LENGTH(mkblnpkt)=0,'00',mkblnpkt)) AS mkgolbln,
                            DATE_FORMAT(tmtpkt,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtpkt, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtpkt, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                    )
                    ->where('nip', $nip)->first();
        }else if($idacuan == '3'){
            $row = \DB::table('tb_01')
                    ->select(
                        \DB::raw("
                            idstspeg,pejmenpns as pejmen, noskpns as nosk, tgskpns as tgsk, idgolrupns as golru,
                            IF(LENGTH(mkthnpns)=1,CONCAT('0',mkthnpns),IF(LENGTH(mkthnpns)=0,'00',mkthnpns)) AS mkgolthn,
                            IF(LENGTH(mkblnpns)=1,CONCAT('0',mkblnpns),IF(LENGTH(mkblnpns)=0,'00',mkblnpns)) AS mkgolbln,
                            DATE_FORMAT(tmtpns,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtpns, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtpns, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                    )
                    ->where('nip', $nip)->first();
        }else if($idacuan == '4'){
            $row = \DB::table('tb_01')
                    ->select(
                        \DB::raw("
                            idstspeg,pejmencpn as pejmen, noskcpn as nosk, tgskcpn as tgsk, idgolrucpn as golru,
                            IF(LENGTH(mkthncpn)=1,CONCAT('0',mkthncpn),IF(LENGTH(mkthncpn)=0,'00',mkthncpn)) AS mkgolthn,
                            IF(LENGTH(mkblncpn)=1,CONCAT('0',mkblncpn),IF(LENGTH(mkblncpn)=0,'00',mkblncpn)) AS mkgolbln,
                            DATE_FORMAT(tmtcpn,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtcpn, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtcpn, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                    )
                    ->where('nip', $nip)->first();
        }

        $thmker = intval($row->mkgolthn)+2;

        $blnker = '00';
        if($thmker != ''){
            if (strlen($thmker)==1) $thmker="0".$thmker;
        }
        if($blnker != ''){
            $blnker = '00';
        }

        $gaji = getgaji($row->golru,$row->mkgolthn,$row->idstspeg);
        $gajikgb = getgaji($row->golru,$thmker,$row->idstspeg);
        $noskkgb = \PenetapannonnominatifModel::getnoskkgb($row->tmtkgbasli, substr($row->golru,0,1), date('Y'));

        /*pejabat penetap*/
        if(($row->golru >= 11) and ($row->golru <= 24)){
            $pejmenkgb = "Kepala Bidang Pengembangan dan Mutasi Pegawai Badan Kepegawaian Daerah";
        }else if(($row->golru >= 31) and ($row->golru <= 34)){
            $pejmenkgb = "Kepala Badan Kepegawaian Daerah";
        }else if(($row->golru >= 41) and ($row->golru <= 42)){
            $pejmenkgb = "Sekretaris Daerah";
        }else if(($row->golru >= 43) and ($row->golru <= 45)){
            $pejmenkgb = "Bupati Tegal";
        }else{
            $pejmenkgb = "";
        }

        $ret[] = array(
            'gaji'=>$gaji,
            'pejmen'=>$row->pejmen,
            'nosk'=>$row->nosk,
            'tgsk'=>date('d-m-Y', strtotime($row->tgsk)),
            'golru'=>$row->golru,
            'tmt'=>$row->tmt,
            'mkgolthn'=>$row->mkgolthn,
            'mkgolbln'=>$row->mkgolbln,
            'tmtkgb'=>$row->tmtkgb,
            'mkgolthnkgb'=>$thmker,
            'mkgolblnkgb'=>$blnker,
            'gajikgb'=>$gajikgb,
            'tgskkgb'=>date('d-m-Y'),
            //'noskkgb'=>$noskkgb,
            'noskkgb'=>'',
            'pejmenkgb'=>$pejmenkgb,
            'idacuan'=>$idacuan
        );

        echo json_encode($ret);
    }

    /*function untuk mendapatkan detail pegawai*/
    /*function detail pegawai*/
    function postDetailpegawai(){
        cekAjax();
        $nip = Input::get('nip');
        if($nip != ''){
            $ret = \DB::table('tb_01 as a')
                ->select(
                    'a.*','b.skpd', 'c.isguru',
                    \DB::raw('IF(LENGTH(a.idskpd) > 3, CONCAT(b.skpd," ",g.skpd), g.skpd) as skpdunit'),
                    \DB::raw("DATE_FORMAT(DATE_ADD(a.tmtkgb, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgbnext"),
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,h.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", ",""),a.gdb) as namalengkap'),
                    'e.jenjurusan', 'f.jenjurusan as jenjurusanawal'
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as g', 'a.kdunit', '=', 'g.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as h', 'a.idjabnonjob', '=', 'h.idjabnonjob')
                ->leftjoin('a_jenjurusan as e', 'a.idjenjurusan', '=', 'e.idjenjurusan')
                ->leftjoin('a_jenjurusan as f', 'a.idjenjurusanawal', '=', 'f.idjenjurusan')
                ->where('a.nip', '=', $nip)->first();

            /*pemiliha awal acuan*/
            if($ret->tmtpkt > $ret->tmtkgb){
                $thmkerac = 2;
            }else{
                $thmkerac = 1;
            }

            $ret->idacuan = $thmkerac;

            $thmker = intval($ret->mkgolthnkgb)+2;

            $blnker = '00';
            if($thmker != ''){
                if (strlen($thmker)==1) $thmker="0".$thmker;
            }

            if($blnker != ''){
                $blnker = '00';
            }

            $ret->mkgolthnkgb = $thmker;
            $ret->mkgolblnkgb = $blnker;

        }else{
            $ret = '';
        }

        echo json_encode($ret);
    }

    /*function cetak sperorangan*/
    function getCetaksk(){
        return View::make('penetapannominatif::skkgb');
    }

    /*function untuk cetak sk non nominatif kolektif*/
    function getCetakskkolektif(){
        return View::make('penetapannonnominatif::skkgbkolektif');
    }

    /*function untuk cetak nominatif dari non nominatif*/
    function getCetaknominatif(){
        return View::make('penetapannonnominatif::sknominatif');
    }

    /*function view data kenaikan gaji berkala tanda diterima */
    function getCetakditerima(){
        return View::make('penetapannonnominatif::skditerima');
    }
}
