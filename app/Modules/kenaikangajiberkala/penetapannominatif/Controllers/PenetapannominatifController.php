<?php

namespace App\Modules\kenaikangajiberkala\penetapannominatif\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\penetapannominatif\Models\PenetapannominatifModel;
use Input, View, Request, Form, File, Storage;
use PDF;

use App\Services\DigitalSignatureService;
use App\Services\KGBService;
use App\Models\KGB\UsulanKGB;

class PenetapannominatifController extends Controller
{
    protected $penetapannominatif;

    public function __construct(PenetapannominatifModel $penetapannominatif)
    {
        $this->penetapannominatif = $penetapannominatif;
    }

    public function getIndex()
    {
        cekAjax();
        $where = "tr_kgb.jnskgb != 0";
        if (session('role_id') > 3) {
            $where .= " and tr_kgb.kdskpd like \"" . session('idskpd') . "%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('bulan') != '') or (Input::get('tahun') != '') or (Input::get('jnskgb') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idstspeg') != '')  or (Input::get('status_tte') != '')) {
            if (Input::get('bulan') != '') {
                $where .= " and MID(tr_kgb.idkgb,5,2) = \"" . Input::get('bulan') . "\"";
            }

            if (Input::get('tahun') != '') {
                $where .= " and LEFT(idkgb,4) = \"" . Input::get('tahun') . "\"";
            }

            if (Input::get('jnskgb') != '') {
                $where .= " and jnskgb = \"" . Input::get('jnskgb') . "\"";
            }

            if (Input::get('statussk') != '') {
                $where .= " and statussk = \"" . Input::get('statussk') . "\"";
            }

            if (Input::get('idstspeg') != '') {
                $where .= " and b.idstspeg = \"" . Input::get('idstspeg') . "\"";
            }

            if (Input::get('idskpd') != '') {
                $idskpd = Input::get('idskpd');
                $where .= " and MID(idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'";
            }

            if (strlen(Input::has('search')) > 0) {
                $where .= " and (tr_kgb.nip like '%" . Input::get('search') . "%' or tr_kgb.karpeg like '%" . Input::get('search') . "%' or tr_kgb.nama like '%" . Input::get('search') . "%')";
            }

            if (Input::get('status_tte') != '') {
                if (Input::get('status_tte') == 'belum_mengusulkan') {
                    $where .= " and r_tte.proses IS NULL";
                } else {
                    $where .= " and r_tte.proses = \"" . Input::get('status_tte') . "\"";
                }
            }

            $penetapannominatifs = $this->penetapannominatif
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                        b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                        IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                        IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns, r_tte.proses"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->leftJoin('r_tte', function ($join) {
                    $join->on('r_tte.id_sk', '=', 'tr_kgb.idkgb');
                    $join->on('r_tte.nip_pengusul', '=', 'tr_kgb.nip');
                })
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))
                ->paginate($_ENV['configurations']['list-limit']);
        } else {
            $penetapannominatifs = $this->penetapannominatif->all();
        }
        return View::make('penetapannominatif::index', compact('penetapannominatifs'));
    }


    public function getCreate()
    {
        cekAjax();
        return View::make('penetapannominatif::create');
    }

    public function postCreate()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannominatifModel::$rules);
        if ($validation->passes()) {
            $data = array();
            /*ambil post dari inputan*/
            $bulan = $input['bulan'];
            $tahunkgb = $input['tahun'];
            $tmtkgbb = $input['tahun'] . "-" . $input['bulan'] . "-01";
            $skpd = $input['skpd'];
            $nip = $input['nip'];
            $tgskkgb = $input['tgskkgb'];
            $mktkgbb = $input['mktkgbb'];
            $mkbkgbb = $input['mkbkgbb'];
            $golpnsskr = $input['golpnsskr'];
            $idstspeg = $input['idstspeg'];
            //$noskkgbb = $input['noskkgbb'];
            $noskkgbb = '';

            /*acuan kgb*/
            $acuan = 3;

            $data = array();
            foreach ($nip as $key => $item) {
                $attr = PenetapannominatifModel::getattkgb($item);
                if ($attr->tmtpkt > $attr->tmtkgbl) { //$attr->tmtkgb
                    $thmker = $attr->mkthnpkt;
                    $acuan = 2;
                } else {
                    $thmker = $attr->mkgolthnkgb;
                    $acuan = 1;
                }

                $thmker2 = intval($thmker) + 2;
                if (strlen($thmker) == 1) $thmker = "0" . $thmker;
                if (strlen($thmker2) == 1) $thmker2 = "0" . $thmker2;
                $jnskgb = PenetapannominatifModel::getJeniskgb($golpnsskr[$item], $skpd[$item], $idstspeg[$item]);
                // dd($jnskgb); die();
                if ($jnskgb == 1) {
                    $statususul = 1;
                    $statussk = 1;
                } else {
                    $statususul = 0;
                    $statussk = 0;
                }

                $temp_arr = array(
                    'idkgb' => $tahunkgb . '' . $bulan . '.' . $skpd[$item],
                    'nip' => $item,
                    'jnskgb' => $jnskgb,
                    'statususul' => 0, /*aselinya 1*/
                    'statussk' => 0, /*aselinya 1*/
                    'statuskgb' => 1,

                    'karpeg' => $attr->nokarpeg,
                    'nama' => $attr->nama,
                    'tmplahir' => $attr->tmlhr,
                    'tgllahir' => $attr->tglhr,
                    'idstspeg' => $attr->idstspeg,
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
                    'mktkgbl' => ((strlen($attr->mkgolthnkgb) == 1) ? '0' . $attr->mkgolthnkgb : $attr->mkgolthnkgb),
                    'mkbkgbl' => ((strlen($attr->mkgolblnkgb) == 1) ? '0' . $attr->mkgolblnkgb : $attr->mkgolblnkgb),
                    'gkgbl' => PenetapannominatifModel::getGajiterakhir($item), /*besar gaji*/
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

                    'tmtjbt' => $attr->tmtmulaiawal_pppk,
                    'tmtjbt' => $attr->tmtakhirawal_pppk,
                    'tmtjbt' => $attr->tmtmulaiakhir_pppk,
                    'tmtjbt' => $attr->tmtakhirakhir_pppk,
                    'tmtjbt' => $attr->tmtjbt,
                    'tmtkgbb' => date("Y-m-d", strtotime($tmtkgbb)), /*tmt kgb*/
                    'mktkgbb' => $mktkgbb[$item], /*thn tmt kgb*/
                    'mkbkgbb' => $mkbkgbb[$item], /*bln tmt kgb*/
                    'kdgolmktkgbb' => $golpnsskr[$item] . "" . $thmker2, /*kode gol dan mkt*/
                    'gkgbb' => getGaji($golpnsskr[$item], $thmker2, $attr->idstspeg), /*jumlah gaji baru*/
                    'noskkgbb' => '', //$noskkgbb[$item]

                    /*diisi sesuai kondisi skpd dan golongan*/
                    'idpejab' => PenetapannominatifModel::attrKepskpd($attr->idgolrupkt, $attr->idskpd, $attr->idstspeg, 'idpenetap'),
                    'jabpenkgbb' => PenetapannominatifModel::attrKepskpd($golpnsskr[$item], $attr->idskpd, $attr->idstspeg, 'jab_utuh'),
                    'pejpenkgbb' => PenetapannominatifModel::attrKepskpd($golpnsskr[$item], $attr->idskpd, $attr->idstspeg, 'nama'),
                    'nippb' => PenetapannominatifModel::attrKepskpd($golpnsskr[$item], $attr->idskpd, $attr->idstspeg, 'nip'),
                    'golrupb' => PenetapannominatifModel::attrKepskpd($golpnsskr[$item], $attr->idskpd, $attr->idstspeg, 'pangkat'),
                    'tglskkgbb' => ($tgskkgb[$item] != '') ? date("Y-m-d", strtotime($tgskkgb[$item])) : '', /*tanggal sk kgb*/

                    'kdskpd' => $attr->idskpd, /*id skpd sekarang*/
                    'namaskpd' => $attr->skpd, /*nama skpd sekarang*/
                    'iscetaksk' => 0, /*iscetaksk*/ /*aselinya 1*/

                    'acuan' => $acuan,
                    'nomgpl' => terbilang(PenetapannominatifModel::getGajiterakhir($item)) . "rupiah",/*nominal gaji*/
                    'nomgpb' => terbilang(getGaji($golpnsskr[$item], $thmker2, $attr->idstspeg)) . "rupiah", /*nominal gaji*/
                    'statususul' => $statususul,
                    'statussk' => $statussk,
                    'role_id' => \Session::get('role_id'),
                    'created_at' => sekarang(),
                    'user_id' => \Session::get('user_id')
                );
                array_push($data, $temp_arr);
            }

            if (! empty($nip)) {
                if (!\DB::table('tr_kgb')->insert($data)) {
                    echo "Kenaikan gaji berkala gagal disimpan.";
                } else {
                    echo 1;
                }
            } else {
                echo 'Input tidak valid';
            }
        } else {
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false)
    {
        cekAjax();
        $id = ($id == false) ? Input::get('id') : '';
        $penetapannominatif = $this->penetapannominatif->find($id);
        //if (is_null($penetapannominatif)){return \Redirect::to('kenaikangajiberkala/penetapannominatif/index');}
        return View::make('penetapannominatif::edit', compact('penetapannominatif'));
    }

    public function postEdit()
    {
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannominatifModel::$rules);

        if ($validation->passes()) {
            $penetapannominatif = $this->penetapannominatif->find($id);
            echo ($penetapannominatif->update($input)) ? 4 : "Gagal Disimpan";
        } else {
            echo 'Input tidak valid';
        }
    }



    public function postDelete()
    {
        cekAjax();
        $data['idkgb'] = Input::get('id');
        $data['nip'] = Input::get('nip');

        echo (\DB::table('tr_kgb')->where($data)->delete()) ? 9 : 'Gagal Dihapus';
    }

    function postNominatif()
    {
        cekAjax();
        $data['idskpd'] = Input::get('idskpd');
        $data['bulan'] = Input::get('bulan');
        $data['tahun'] = Input::get('tahun');
        $data['tglskkgb'] = Input::get('tglskkgbb');
        $data['idstspeg'] = Input::get('idstspeg');

        return View::make('penetapannominatif::nominatif', compact('data'));
    }

    /*function cetak sperorangan*/
    function getCetaksk()
    {
        return View::make('penetapannominatif::skkgb');
    }

    /*function cetak sk kenaikan gaji berkala kolektif */
    function getCetakskkolektif()
    {
        return View::make('penetapannominatif::skkgbkolektif');
    }

    /*function view data kenaikan gaji berkala kolektif */
    function getCetaknominatif()
    {
        return View::make('penetapannominatif::sknominatif');
    }

    /*function view data kenaikan gaji berkala tanda diterima */
    function getCetakditerima()
    {
        return View::make('penetapannominatif::skditerima');
    }

    /*function view data atribut dari link */
    function postData()
    {
        cekAjax();
        $view = Request::segment(4);
        return View::make('penetapannominatif::' . $view . '_data');
    }

    /*function preview edit kgb*/
    function postEditkgb()
    {
        $idkgb = Input::get('idkgb');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_kgb as a')
            ->select(
                'tb_01.idstspeg',
                'a.*',
                \DB::raw('IF(tb_01.idstspeg=3,b.golru_p3k,b.golru) as golru'),
                'b.pangkat',
                \DB::raw("
                        IF(tb_01.idstspeg=3,c.golru_p3k,c.golru) as golrub, c.pangkat AS pangkatb,
                        DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_,
                        DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_,
                        DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_,
                        DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_,
                        DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_,
                        DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_,
                        DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_,
                        DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_
                    ")
            )
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpns', '=', 'c.idgolru')
            ->leftJoin('tb_01', 'a.nip', '=', 'tb_01.nip')
            ->where('a.idkgb', $idkgb)
            ->where('a.nip', $nip)
            ->first();

        echo json_encode($rs);
    }

    /*function untuk mendapatkan atribut acuan*/
    public function postAcuan()
    {
        cekAjax();

        $nip = Input::get('nip');
        $idacuan = Input::get('acuan');
        $idkgb = Input::get('idkgb');
        $rs = '';

        /*kondisi acuan*/
        if ($idacuan == 1) {
            $row = \DB::table('tr_kgb')
                ->select(
                    \DB::raw("
                            tb_01.idstspeg,pejpenkgbl as pejmen, noskkgbl as nosk,
                            DATE_FORMAT(tglskkgbl,'%d-%m-%Y') AS tgsk, golpnsskr as golru,
                            IF(LENGTH(mktkgbl)=1,CONCAT('0',mktkgbl),IF(LENGTH(mktkgbl)=0,'00',mktkgbl)) AS mkgolthn,
                            IF(LENGTH(mkbkgbl)=1,CONCAT('0',mkbkgbl),IF(LENGTH(mkbkgbl)=0,'00',mkbkgbl)) AS mkgolbln,
                            DATE_FORMAT(tmtkgbl,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtkgbl, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtkgbl, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                )
                ->leftjoin('tb_01', 'tr_kgb.nip', '=', 'tb_01.nip')
                ->where('tr_kgb.nip', $nip)->where('idkgb', $idkgb)->first();
        } else if ($idacuan == 2) {
            $row = \DB::table('tb_01')
                ->select(
                    \DB::raw("
                            tb_01.idstspeg,pejmenpkt as pejmen, noskpkt as nosk, tgskpkt as tgsk, idgolrupkt as golru,
                            IF(LENGTH(mkthnpkt)=1,CONCAT('0',mkthnpkt),IF(LENGTH(mkthnpkt)=0,'00',mkthnpkt)) AS mkgolthn,
                            IF(LENGTH(mkblnpkt)=1,CONCAT('0',mkblnpkt),IF(LENGTH(mkblnpkt)=0,'00',mkblnpkt)) AS mkgolbln,
                            DATE_FORMAT(tmtpkt,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtpkt, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtpkt, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                )
                ->where('nip', $nip)->first();
        } else if ($idacuan == 3) {
            $row = \DB::table('tb_01')
                ->select(
                    \DB::raw("
                            tb_01.idstspeg,pejmenpns as pejmen, noskpns as nosk, tgskpns as tgsk, idgolrupns as golru,
                            IF(LENGTH(mkthnpns)=1,CONCAT('0',mkthnpns),IF(LENGTH(mkthnpns)=0,'00',mkthnpns)) AS mkgolthn,
                            IF(LENGTH(mkblnpns)=1,CONCAT('0',mkblnpns),IF(LENGTH(mkblnpns)=0,'00',mkblnpns)) AS mkgolbln,
                            DATE_FORMAT(tmtpns,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtpns, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtpns, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                )
                ->where('nip', $nip)->first();
        } else if ($idacuan == 4) {
            $row = \DB::table('tb_01')
                ->select(
                    \DB::raw("
                            tb_01.idstspeg,pejmencpn as pejmen, noskcpn as nosk, tgskcpn as tgsk, idgolrucpn as golru,
                            IF(LENGTH(mkthncpn)=1,CONCAT('0',mkthncpn),IF(LENGTH(mkthncpn)=0,'00',mkthncpn)) AS mkgolthn,
                            IF(LENGTH(mkblncpn)=1,CONCAT('0',mkblncpn),IF(LENGTH(mkblncpn)=0,'00',mkblncpn)) AS mkgolbln,
                            DATE_FORMAT(tmtcpn,'%d-%m-%Y') AS tmt,
                            DATE_FORMAT(DATE_ADD(tmtcpn, INTERVAL 2 YEAR),'%d-%m-%Y') AS tmtkgb,
                            DATE_ADD(tmtcpn, INTERVAL 2 YEAR) AS tmtkgbasli
                        ")
                )
                ->where('nip', $nip)->first();
        }

        $thmker = intval($row->mkgolthn) + 2;

        $blnker = '00';
        if ($thmker != '') {
            if (strlen($thmker) == 1) $thmker = "0" . $thmker;
        }
        if ($blnker != '') {
            $blnker = '00';
        }

        $gaji = getgaji($row->golru, $row->mkgolthn, $row->idstspeg);
        $gajikgb = getgaji($row->golru, $thmker, $row->idstspeg);
        $noskkgb = \PenetapannonnominatifModel::getnoskkgb($row->tmtkgbasli, substr($row->golru, 0, 1), date('Y'));

        /*pejabat penetap*/
        if (($row->golru >= 11) and ($row->golru <= 24)) {
            $pejmenkgb = "Kepala Bidang Pengembangan dan Mutasi Pegawai Badan Kepegawaian Daerah";
        } else if (($row->golru >= 31) and ($row->golru <= 34)) {
            $pejmenkgb = "Kepala Badan Kepegawaian Daerah";
        } else if (($row->golru >= 41) and ($row->golru <= 42)) {
            $pejmenkgb = "Sekretaris Daerah";
        } else if (($row->golru >= 43) and ($row->golru <= 45)) {
            $pejmenkgb = "Bupati Tegal";
        } else {
            $pejmenkgb = "";
        }

        $ret[] = array(
            'gaji' => $gaji,
            'pejmen' => $row->pejmen,
            'nosk' => $row->nosk,
            'tgsk' => date('d-m-Y', strtotime($row->tgsk)),
            'golru' => $row->golru,
            'idstspeg' => $row->idstspeg,
            'tmt' => $row->tmt,
            'mkgolthn' => $row->mkgolthn,
            'mkgolbln' => $row->mkgolbln,
            'tmtkgb' => $row->tmtkgb,
            'mkgolthnkgb' => $thmker,
            'mkgolblnkgb' => $blnker,
            'gajikgb' => $gajikgb,
            'tgskkgb' => date('d-m-Y'),
            'noskkgb' => $noskkgb,
            'pejmenkgb' => $pejmenkgb,
            'idacuan' => $idacuan
        );

        echo json_encode($ret);
    }

    /*function untuk simpan update kgb*/
    function postUpdatekgb()
    {
        cekAjax();
        $input = Input::all();
        $dt['idkgb'] = $input['idkgb'];
        $dt['nip'] = $input['nip'];

        $golru = $input['golru'];
        $idstspeg = $input['idstspeg'];
        $data['tmtkgbb'] = date("Y-m-d", strtotime($input['tmtkgbb']));
        $data['mktkgbb'] = $input['mktkgbb'];
        $data['mkbkgbb'] = $input['mkbkgbb'];
        /*$data['noskkgbb'] = ((Input::get('statussk') == 1)?(Input::get('noskkgbb')!='')?Input::get('noskkgbb'):\PenetapannominatifModel::getNomorsk(Input::get('jnskgb'),substr($input['golru'],0,1),substr(Input::get('idkgb'),0,4)):Input::get('noskkgbb'));
        $data['tglskkgbb'] = date("Y-m-d", strtotime($input['tglskkgbb']));*/
        //sesuai kondisi di kendal
        $data['idpejab'] = $input['idpejab'];
        $data['jabpenkgbb'] = $input['jabpenkgbb'];
        $data['pejpenkgbb'] = $input['pejpenkgbb'];
        $data['nippb'] = $input['nippb'];
        $data['golrupb'] = $input['golrupb'];
        $data['acuan'] = $input['acuan']; /*idacuan*/
        $data['golpns'] = $input['golru'];
        $data['golpnsskr'] = $input['golru'];
        $data['golpnsname'] = getAttr('a_golruang', 'idgolru', $input['golru'], 'golru');
        $data['tmtkgbl'] = date('Y-m-d', strtotime($input['tmt']));
        $data['mktkgbl'] = $input['mkgolthn'];
        $data['mkbkgbl'] = $input['mkgolbln'];
        $data['gkgbl'] = $input['gaji'];
        $data['nomgpl'] = terbilang($input['gaji']) . "rupiah";
        $data['noskkgbl'] = $input['nosk'];
        $data['tglskkgbl'] = date('Y-m-d', strtotime($input['tgsk']));
        $data['pejpenkgbl'] = $input['pejmen'];
        $data['gkgbb'] = $input['gkgbb']; /*besar gaji baru*/
        $data['nomgpb'] = terbilang($input['gkgbb']) . "rupiah"; /*nominal gaji terbilang baru*/

        /*if(Input::get('statususul') == 1){
            $data['statususul'] = Input::get('statususul');
            $data['statussk'] = Input::get('statussk');
            $data['iscetaksk'] = Input::get('iscetaksk');
            $data['kettms'] = '';
            $data['ketbtl'] = '';
        }else if(Input::get('statususul') == 2){
            $data['statususul'] = Input::get('statususul');
            $data['statussk'] = '';
            $data['kettms'] = Input::get('kettms');
            $data['ketbtl'] = '';
        }else {
            $data['statususul'] = Input::get('statususul');
            $data['statussk'] = '';
            $data['kettms'] = '';
            $data['ketbtl'] = Input::get('ketbtl');
        }*/

        if (!\DB::table("tr_kgb")->where($dt)->update($data)) {
            echo "Edit Kenaikan Gaji Berkala gagal disimpan";
        } else {
            echo 4;
        }
    }

    /*function untuk verifikasi kgb*/
    function postVerifikasikgb()
    {
        cekAjax();
        $input = Input::all();
        $dt['idkgb'] = $input['idkgb'];
        $dt['nip'] = $input['nip'];

        if ((session('role_id') < 3) or (session('skpd_id') == '001')) {
            //if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4))){
            $noskkgbb = ((Input::get('statussk') == 1) ? (Input::get('noskkgbb') != '') ? Input::get('noskkgbb') : \PenetapannominatifModel::getNomorsk(Input::get('jnskgb'), substr(Input::get('golpnsskr'), 0, 1), substr(date('Y-m-d', strtotime(Input::get('tglskkgbb'))), 0, 4)) : Input::get('noskkgbb'));
            //$noskkgbb = ((Input::get('statussk') == 1)?(Input::get('noskkgbb')!='')?Input::get('noskkgbb'):\PenetapannominatifModel::getNomorsk(Input::get('jnskgb'),substr(Input::get('golpnsskr'),0,1),substr(Input::get('idkgb'),0,4)):Input::get('noskkgbb'));
        } else {
            $noskkgbb = $input['noskkgbb'];
        }

        if (Input::get('statususul') == 1) {
            $data = array(
                'ispengantar' => Input::get('ispengantar'),
                'isnominatif' => Input::get('isnominatif'),
                'isskpkt' => Input::get('isskpkt'),
                'isskkgb' => Input::get('isskkgb'),
                'isdp3' => Input::get('isdp3'),
                'isskhukdis' => Input::get('isskhukdis'),
                'isskpmk' => Input::get('isskpmk'),
                'statususul' => Input::get('statususul'),
                'statussk' => Input::get('statussk'),
                'iscetaksk' => Input::get('iscetaksk'),
                'kettms' => '',
                'ketbtl' => '',
                'idpejab' => Input::get('idpejab'),
                'noskkgbb' => $noskkgbb,
                'tglskkgbb' => date("Y-m-d", strtotime(Input::get('tglskkgbb'))),
                'jabpenkgbb' => Input::get('jabpenkgbb'),
                'pejpenkgbb' => Input::get('pejpenkgbb'),
                'nippb' => Input::get('nippb'),
                'golrupb' => Input::get('golrupb'),
                'updated_at' => sekarang(),
                'userver' => session('user_id')
            );

            /*if(Input::get('iscetaksk') == 1){
                $this->insertIntorkgb($dt['idkgb'], $dt['nip']);
            }else if(Input::get('iscetaksk') == 2){
                $this->batalIntorkgb($dt['idkgb'], $dt['nip']);
            }*/
        } else if (Input::get('statususul') == 2) {
            $data = array(
                'ispengantar' => Input::get('ispengantar'),
                'isnominatif' => Input::get('isnominatif'),
                'isskpkt' => Input::get('isskpkt'),
                'isskkgb' => Input::get('isskkgb'),
                'isdp3' => Input::get('isdp3'),
                'isskhukdis' => Input::get('isskhukdis'),
                'isskpmk' => Input::get('isskpmk'),
                'statususul' => Input::get('statususul'),
                'statussk' => '',
                'kettms' => Input::get('kettms'),
                'ketbtl' => '',
                'tglskkgbb' => '',
                'updated_at' => sekarang(),
                'userver' => session('user_id')/*
                'noskkgbb' => '',                ,
                'jabpenkgbb' => '',
                'pejpenkgbb' => '',
                'nippb' => '',
                'golrupb' => ''*/
            );
        } else {
            $data = array(
                'ispengantar' => Input::get('ispengantar'),
                'isnominatif' => Input::get('isnominatif'),
                'isskpkt' => Input::get('isskpkt'),
                'isskkgb' => Input::get('isskkgb'),
                'isdp3' => Input::get('isdp3'),
                'isskhukdis' => Input::get('isskhukdis'),
                'isskpmk' => Input::get('isskpmk'),
                'statususul' => Input::get('statususul'),
                'statussk' => '',
                'kettms' => '',
                'ketbtl' => Input::get('ketbtl'),
                'tglskkgbb' => '',
                'updated_at' => sekarang(),
                'userver' => session('user_id')/*,
                'noskkgbb' => '',
                'jabpenkgbb' => '',
                'pejpenkgbb' => '',
                'nippb' => '',
                'golrupb' => ''*/
            );
        }

        if (!\DB::table('tr_kgb')->where($dt)->update($data)) {
            return "Verifikasi Kenaikan Gaji Berkala gagal disimpan";
        } else {
            if (Input::get('statussk') == '1' && Input::get('jnskgb') == '2') {
                $kgb = UsulanKGB::where('nip', '=', Input::get('nip'))
                    ->where('idkgb', '=', Input::get('idkgb'))
                    ->first();

                if ($kgb != null) {
                    if ($kgb->jnskgb == 2) {
                        $s_kgb = new KGBService($kgb);
                        return $s_kgb->generateSK() == 1 ? 4 : 0;
                    }
                }
            }

            return 4;
        }

        return 0;
    }

    /*function post cetak sk*/
    public function postCetaksk()
    {
        cekAjax();
        $tmtkgb = Input::get('rectmtkgb');
        $idskpd = Input::get('recidskpd');
        $data['iscetaksk'] = Input::get('iscetaksk');

        /*update iscetak sk*/
        echo (\DB::table('tr_kgb')->where('tmtkgbb', $tmtkgb)->where('statussk', 1)->where('kdskpd', 'like', '' . $idskpd . '%')->update($data)) ? 4 : "Gagal Disimpan";
    }

    /*function untuk simpan attribut pengantar*/
    public function postSuratpengantar()
    {
        $jnskgb = Input::get('jnskgb');
        $idkgb = Input::get('idkgb');
        $idskpd = Input::get('idskpd');

        $data['no_sp'] = Input::get('no_sp');
        $data['berkas_sp'] = Input::get('berkas_sp');
        $data['tgl_sp'] = date('Y-m-d', strtotime(Input::get('tgl_sp')));
        $data['jabpen_sp'] = Input::get('jabpen_sp');
        $data['pejpen_sp'] = Input::get('pejpen_sp');
        $data['nippen_sp'] = Input::get('nippen_sp');
        $data['golpen_sp'] = Input::get('golpen_sp');

        if (($jnskgb != '') and ($idkgb != '')) {
            if ($idskpd == '04') {
                $periode = Input::get('periode');
                $piluptds = Input::get('piluptd');
                if (is_array($piluptds)) {
                    foreach ($piluptds as $piluptd) {
                        if ($piluptd == '04') {
                            $rs = \DB::table('tr_kgb')
                                ->join('a_skpd', 'tr_kgb.kdskpd', '=', 'a_skpd.idskpd')
                                ->whereRaw("tr_kgb.idkgb like \"" . $periode . "." . $piluptd . "%\" and tr_kgb.jnskgb = \"" . $jnskgb . "\" and a_skpd.id_unorindukflag = \"" . $idskpd . "\"");

                            $data['berkas_sp'] = $rs->count();
                            $rs->update($data);
                        } else {
                            $rs = \DB::table('tr_kgb')->where('jnskgb', $jnskgb)
                                ->where('idkgb', 'like', '' . $periode . "." . $piluptd . '%');

                            $data['berkas_sp'] = $rs->count();
                            $rs->update($data);
                        }
                    }

                    if (Input::get('actpengantar') == 1) {
                        return View::make('penetapannominatif::suratpengantar_dinas', array('jnskgb' => $jnskgb, 'periode' => $periode, 'piluptds' => $piluptds, 'idskpd' => $idskpd));
                    }

                    if (Input::get('actnominatif') == 1) {
                        return View::make('penetapannominatif::suratnominatif_dinas', array('jnskgb' => $jnskgb, 'periode' => $periode, 'piluptds' => $piluptds, 'idskpd' => $idskpd));
                    }
                } else {
                    echo "Data tidak ditemukan.";
                }
            } else {
                \DB::table('tr_kgb')->where('jnskgb', $jnskgb)->where('idkgb', 'like', '' . $idkgb . '%')->update($data);
                if (Input::get('actpengantar') == 1) {
                    return View::make('penetapannominatif::suratpengantar', array('jnskgb' => $jnskgb, 'idkgb' => $idkgb, 'idskpd' => $idskpd));
                }

                if (Input::get('actnominatif') == 1) {
                    return View::make('penetapannominatif::suratnominatif', array('jnskgb' => $jnskgb, 'idkgb' => $idkgb, 'idskpd' => $idskpd));
                }
            }
        } else {
            echo "Data tidak ditemukan.";
        }
    }

    /*function untuk post upload file*/
    public function postUploadfile()
    {
        cekAjax();
        $input = Input::all();
        $foto = '';
        $mode = 0777;
        $recursive = false;
        $file = $input['file'];

        //echo $_FILES["file"]["type"];
        if (isset($_FILES['file'])) {
            if ($_FILES['file']['size'] > 5242880) { //1 MB (size is also in bytes)
                // File too big
                echo "<b>File gagal dikirim.</b> Ukuran file maksimal 1 MB";
            } else {
                $destinationPath = base_path() . '/packages/upload/kgb-ledger/' . $input['tahun'] . "-" . $input['bulan'];
                if ($file) {
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, $mode, $recursive);
                    }
                    $tipefile = $file->getClientOriginalExtension();
                    $filename = $input['idskpd'] . '-' . $input['tahun'] . "-" . $input['bulan'] . '-ledger-gaji.' . $tipefile;
                    /*cek remove file*/
                    $rscek = \DB::table('tr_kgb_ledger')->where('idskpd', $input['idskpd'])->where('tahun', $input['tahun'])->where('bulan', $input['bulan'])->first();
                    if (count($rscek) > 0) {
                        @unlink(base_path() . '/packages/upload/kgb-ledger/' . $rscek->file);
                    }
                    $file->move($destinationPath, $filename);
                    $ledger = $input['tahun'] . "-" . $input['bulan'] . '/' . $filename;
                }

                if (count($rscek) > 0) {
                    echo (\DB::table('tr_kgb_ledger')->where(array('idskpd' => $input['idskpd'], 'tahun' => $input['tahun'], 'bulan' => $input['bulan']))->update(array('idskpd' => $input['idskpd'], 'tahun' => $input['tahun'], 'bulan' => $input['bulan'], 'file' => $ledger, 'role_id' => \Session::get('role_id'), 'user_id' => \Session::get('user_id'), 'updated_at' => sekarang()))) ? 4 : "Gagal Disimpan";
                } else {
                    echo (\DB::table('tr_kgb_ledger')->insert(array('idskpd' => $input['idskpd'], 'tahun' => $input['tahun'], 'bulan' => $input['bulan'], 'file' => $ledger, 'role_id' => \Session::get('role_id'), 'user_id' => \Session::get('user_id'), 'updated_at' => sekarang()))) ? 4 : "Gagal Disimpan";
                }
            }
        }
    }

    /*function untuk hapus file ledger*/
    public function postHapusledgergaji()
    {
        cekAjax();
        $dt['idskpd'] = Input::get('idskpd');
        $dt['bulan'] = Input::get('bulan');
        $dt['tahun'] = Input::get('tahun');

        if (\DB::table('tr_kgb_ledger')->where($dt)->delete()) {
            @unlink(base_path() . '/packages/upload/kgb-ledger/' . Input::get('file'));
            echo 9;
        } else {
            echo "Data gagal dihapus";
        }
    }

    public function postAjukantte()
    {
        cekAjax();

        if (Input::has('nip') && Input::has('idkgb')) {
            $usulanKGB = UsulanKGB::where('nip', '=', Input::get('nip'))
                ->where('idkgb', '=', Input::get('idkgb'))->first();
            if (!empty($usulanKGB)) {
                $s_kgb = new KGBService($usulanKGB);
                return $s_kgb->ajukanTTE() ? 1 : "Gagal Mengajukan TTE!";
            }
        }

        return "KGB Tidak Ditemukan";
    }

    public function pandu()
    {
        $pdf = PDF::loadview('penetapannominatif::sk_pandu');
    }

    // private function getFormData()
    // {
    //     $form_data = [
    //     [
    //       'name'     => 'file',
    //       'contents' => fopen(base_path('packages/tte/kgb/SuratKGB.pdf'),'r')
    //     ],
    //     [
    //         'name'     => 'imageTTD',
    //         'contents' => fopen(base_path('packages/ttd/ttd.png'),'r')
    //     ],
    //     [
    //         'name'     => 'passphrase',
    //         'contents' => '!Bsre1221*'
    //     ],
    //     [
    //         'name'     => 'nik',
    //         'contents' => '0803202100007062'
    //     ],
    //     [
    //         'name'     => 'tampilan',
    //         'contents' => 'visible'
    //     ],

    //     [
    //         'name'     => 'image',
    //         'contents' => 'true'
    //     ],

    //     [
    //         'name'     => 'width',
    //         'contents' => '100'
    //     ],
    //     [
    //         'name'     => 'height',
    //         'contents' => '50'
    //     ],
    //     [
    //         'name'     => 'tag_koordinat',
    //         'contents' => '#'
    //     ],

    //     ];

    //     return $form_data;
    // }

    // public function getPandu(DigitalSignatureService)
    // {
    //     // DS
    //     $form_data = $this->getFormData();
    //     // $srv = new DigitalSignatureService();
    //     $handleSign = $srv->handle($form_data);
    //     dd($handleSign);

    //     // End DS

    //     // $input[0];
    //     // $ds  = DigitalSignatureService::handle($form_data)
    //     // Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) 

    //     // // return View::make('penetapannominatif::sk_pandu');
    //     // $pdf = PDF::loadview('penetapannominatif::sk_pandu');
    //     // return $pdf->stream();
    //     // $output = $pdf->stream();

    //     // if (Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) {
    //     //     return "berhasil";
    //     // }else{
    //     //     return "gagal";
    //     // }
    // }

    public function postCetaksktte()
    {
        cekAjax();
        $jnskgb = \Request::segment(4);
        $nip = \Request::segment(5);
        $idkgb = \Request::segment(6);

        if (App\Models\KGB\UsulanKGB::generateSK($nip, $idkgb, $jnskgb)) {
            return "berhasil";
        } else {
            return "gagal";
        }

        // $tmtkgb = Input::get('rectmtkgb');
        // $idskpd = Input::get('recidskpd');
        // $data['iscetaksk'] = Input::get('iscetaksk');

        // $pdf = PDF::loadview('penetapannominatif::sk_tte');
        // $output = $pdf->stream();

        // if (Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) {
        //     return "berhasil";
        // }else{
        //     return "gagal";
        // }

        // /*update iscetak sk*/
        // echo (\DB::table('tr_kgb')->where('tmtkgbb', $tmtkgb)->where('statussk', 1)->where('kdskpd','like',''.$idskpd. '%')->update($data))?4:"Gagal Disimpan";
    }

    function getCetaksktte()
    {
        $jnskgb = \Request::segment(4);
        $nip = \Request::segment(5);
        $idkgb = \Request::segment(6);

        // $usulan = UsulanKGB::where('idkgb',$idkgb)->where('nip', $nip)->first();

        // if(!empty($usulan)){

        //     return $usulan->generateSK($nip, $idkgb, $jnskgb)?"berhasil":"gagal";
        // }   
        if (UsulanKGB::generateSK($nip, $idkgb, $jnskgb)) {
            return 'Berhasil';
        }

        return "gagal";
        // return View::make('penetapannominatif::sk_tte');

        // $pdf = PDF::loadview('penetapannominatif::sk_tte');
        // $pdf = Pdf::set_option('isHtml5ParserEnabled', true);
        // $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = Pdf::loadHTML(View::make('penetapannominatif::sk_tte'))->setPaper('legal', 'potrait');
        $output = $pdf->stream();

        if (Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) {
            return "berhasil";
        } else {
            return "gagal";
        }
    }
    function postExcel()
    {
        return "Segera";
    }
}
