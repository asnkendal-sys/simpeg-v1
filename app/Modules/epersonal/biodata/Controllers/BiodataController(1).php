<?php namespace App\Modules\epersonal\biodata\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SinkronisasiModel;
use App\Modules\epersonal\biodata\Models\BiodataModel;
use Input;
use View;
use Request;
use Form;
use File;
use App\Services\JabatanService;
use App\Services\SkpService;

/**
* Biodata Controller
* @var Biodata
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class BiodataController extends Controller
{
    protected $biodata;

    public function __construct(BiodataModel $biodata)
    {
        $this->biodata = $biodata;
    }

    public function getIndex()
    {
        cekAjax();
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if (session('role_id') > 3) {
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::get('idstspeg') != '')) {
            (Input::get('idstspeg')!='')?$where.=" and tb_01.idstspeg = '".Input::get('idstspeg')."'":"";
            (Input::get('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            if (session('role_id') <= 3) {
                $biodatas = $this->biodata
                    ->select(
                        'tb_01.*',
                        'a_golruang.golru','a_golruang.golru_p3k',
                        'a_skpd.path_short',
                        'a_esl.esl',
                        'a_tkpendid.tkpendid',
                        'a_jenjurusan.jenjurusan',
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),
                        'a_jenkel.jenkel',
                        'a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw("
                            CONCAT(
                                IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        -
                                        (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                        IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                    ),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        + tb_01.mkthncpn
                                    )
                                ),
                                RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                        "),
                        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                    ->paginate($_ENV['configurations']['list-limit']);
            } else {
                $biodatas = $this->biodata
                    ->select(
                        'tb_01.*',
                        'a_golruang.golru','a_golruang.golru_p3k',
                        'a_skpd.path_short',
                        'a_esl.esl',
                        'a_tkpendid.tkpendid',
                        'a_jenjurusan.jenjurusan',
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),
                        'a_jenkel.jenkel',
                        'a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw("
                                CONCAT(
                                    IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                                IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            + tb_01.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                            "),
                        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                    ->paginate($_ENV['configurations']['list-limit']);
            }
        } else {
            $biodatas = $this->biodata->all();
        }

        if (session('role_id')==5) {
            return View::make('biodata::edit', compact('biodatas'));
        } else {
            return View::make('biodata::index', compact('biodatas'));
        }
    }

    public function getCreate()
    {
        cekAjax();
        if(Input::get('view') === 'pppk') {
            return View::make('biodata::create_pppk');
        } else {
            return View::make('biodata::create');
        }
    }

    public function postCreate()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rules);
        if ($validation->passes()) {
            $arrnot = array('','_token','id');
            $keydate = array('','tglhr','tgskjbt','tmtjbt','tgskcpn','tmtcpn','tgskpns','tmtpns','tgskpkt','tmtpkt','tgskkgb','tmtkgb','tgspmtcpn','tgspmtpns','tmtspmtcpn','tmtspmtpns');

            foreach ($input as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    } else {
                        $value = '0000-00-00';
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            if(Input::get('idstspeg') == 3){
                /*data jabatan*/
                $data["pejmenjbt"] = Input::get('pejmenawal_pppk');
                $data["idjenjab"] = Input::get('idjenjabawal_pppk');
                $data["noskjbt"] = Input::get('nojanjiawal_pppk');
                $data["tgskjbt"] = date('Y-m-d', strtotime(Input::get('tgljanjiawal_pppk')));
                $data["tmtjbt"] = date('Y-m-d', strtotime(Input::get('tmtmulaiawal_pppk')));

                /*data kenaikan gaji berkala*/
                $data["pejmenkgb"] = Input::get('pejmenawal_pppk');
                $data["idgolkgb"] = Input::get('idgolruawal_pppk');
                $data["noskkgb"] = Input::get('nojanjiawal_pppk');
                $data["tgskkgb"] = date('Y-m-d', strtotime(Input::get('tgljanjiawal_pppk')));
                $data["tmtkgb"] = date('Y-m-d', strtotime(Input::get('tmtmulaiawal_pppk')));
                $data["mkgolthnkgb"] = Input::get('mkthnawal_pppk');
                $data["mkgolblnkgb"] = Input::get('mkblnawal_pppk');

                /*data kenaikan pangkat*/
                $data["pejmenpkt"] = Input::get('pejmenawal_pppk');
                $data["idgolrupkt"] = Input::get('idgolruawal_pppk');
                $data["noskpkt"] = Input::get('nojanjiawal_pppk');
                $data["tgskpkt"] = date('Y-m-d', strtotime(Input::get('tgljanjiawal_pppk')));
                $data["tmtpkt"] = date('Y-m-d', strtotime(Input::get('tmtmulaiawal_pppk')));
                $data["mkthnpkt"] = Input::get('mkthnawal_pppk');
                $data["mkblnpkt"] = Input::get('mkblnawal_pppk');

                $data["pejmenakhir_pppk"] = Input::get('pejmenawal_pppk');
                $data["noskakhir_pppk"] = Input::get('noskawal_pppk');
                $data["tgskakhir_pppk"] = date('Y-m-d', strtotime(Input::get('tgskawal_pppk')));
                $data["idgolruakhir_pppk"] = Input::get('idgolruawal_pppk');
                $data["mkthnakhir_pppk"] = Input::get('mkthnawal_pppk');
                $data["mkblnakhir_pppk"] = Input::get('mkblnawal_pppk');
                $data["gajiakhir_pppk"] = Input::get('gajiawal_pppk');
                $data["nojanjiakhir_pppk"] = Input::get('nojanjiawal_pppk');
                $data["tgljanjiakhir_pppk"] = date('Y-m-d', strtotime(Input::get('tgljanjiawal_pppk')));
                $data["tmtmulaiakhir_pppk"] = date('Y-m-d', strtotime(Input::get('tmtmulaiawal_pppk')));
                $data["tmtakhirakhir_pppk"] = date('Y-m-d', strtotime(Input::get('tmtakhirawal_pppk')));

                $data["tgskcalonawal_pppk"] = date('Y-m-d', strtotime(Input::get('tgskcalonawal_pppk')));
                $data["tgskawal_pppk"] = date('Y-m-d', strtotime(Input::get('tgskawal_pppk')));
                $data["tgljanjiawal_pppk"] = date('Y-m-d', strtotime(Input::get('tgljanjiawal_pppk')));
                $data["tmtmulaiawal_pppk"] = date('Y-m-d', strtotime(Input::get('tmtmulaiawal_pppk')));
                $data["tmtakhirawal_pppk"] = date('Y-m-d', strtotime(Input::get('tmtakhirawal_pppk')));
            }

            if ($input['password'] != '') {
                $password = $input['password'];
            } else {
                $password = 'polke';
            }
            $data['photo'] = 'default.jpg';
            $data['usiapens'] = 1;
            $data['password'] = md5($password);
            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
            echo (\DB::table('tb_01')->insert($data))?1:"Data Gagal Disimpan";

            if(Input::get('idstspeg') != 3){
                $this->saveRiwayat();
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat saat biodata created*/
    public function saveRiwayat()
    {
        cekAjax();
        /*simpan riwayat jabatan terakhir*/
        if (Input::get('idjabjbt') != '') {
            $idjab = Input::get('idjabjbt');
        } elseif (Input::get('idjabfung') != '') {
            $idjab = Input::get('idjabfung');
        } elseif (Input::get('idjabfungum') != '') {
            $idjab = Input::get('idjabfungum');
        } elseif (Input::get('idjabnonjob') != '') {
            $idjab = Input::get('idjabnonjob');
        } else {
            $idjab = '';
        }

        if ($idjab != '') {
            $data_rjab = array(
                "nip" => Input::get('nip'),
                "pejmen" => Input::get('pejmenjbt'),
                "idskpd" => Input::get('idskpd'),
                "skpd" => getAttr('a_skpd', 'idskpd', Input::get('idskpd'), 'skpd'),
                "idjenjab" => Input::get('idjenjab'),
                "idjab" => $idjab,
                "jab" => getJabatan(Input::get('idjenjab'), $idjab),
                "idesl" => Input::get('idesljbt'),
                "esl" => getAttr('a_esl', 'idesl', Input::get('idesljbt'), 'esl'),
                "nosk" => Input::get('noskjbt'),
                "tmtjab" => date('Y-m-d', strtotime(Input::get('tmtjbt'))),
                "tgsk" => date('Y-m-d', strtotime(Input::get('tgskjbt'))),
                "nopak" => Input::get('nopak'),
                "idtugasdokter" => Input::get('idtugasdokter'),
                "idtugasgurudosen" => Input::get('idtugasgurudosen'),
                "idmatkulpel" => Input::get('idmatkulpel'),
                "matkulpel" => getAttr('a_matkulpel', 'idmatkulpel', Input::get('idmatkulpel'), 'matkulpel'),
                "isdiperbantukan" => Input::get('isdiperbantukan'),
                "iddiperbantukan" => Input::get('iddiperbantukan'),
                "iddesa" => Input::get('iddesa'),
                "nmadesa" => getAttr('a_kel', 'kdkel', Input::get('iddesa'), 'kel'),
                "user_id" => \Session::get('user_id'),
                "role_id" => \Session::get('role_id'),
                "created_at" => gmdate("Y-m-d H:i", time()+60*60*7)
            );
            \DB::table('r_jab')->insert($data_rjab);
        }

        if (Input::get('idgolrucpn') != '') {
            /*simpan riwayat golongan cpns*/
            $data_rgolcpns = array(
                "nip" => Input::get('nip'),
                "idgolru" => Input::get('idgolrucpn'),
                "pejmenpkt" => Input::get('pejmencpn'),
                "nosk" => Input::get('noskcpn'),
                "tgsk" => date('Y-m-d', strtotime(Input::get('tgskcpn'))),
                "tmtpkt" => date('Y-m-d', strtotime(Input::get('tmtcpn'))),
                "gapok" => getGaji(Input::get('idgolrucpn'), Input::get('mkthncpn')),
                "thkerja" => Input::get('mkthncpn'),
                "blkerja" => Input::get('mkblncpn'),
                "user_id" => \Session::get('user_id'),
                "role_id" => \Session::get('role_id'),
                "created_at" => gmdate("Y-m-d H:i", time()+60*60*7)
            );
            \DB::table('r_gol')->insert($data_rgolcpns);
        }

        if (Input::get('idgolrucpn')."".Input::get('mkthncpn') != Input::get('idgolrupns')."".Input::get('mkthnpns')) {
            if (Input::get('idgolrupns') != '') {
                /*simpan riwayat golongan pns*/
                $data_rgolpns = array(
                    "nip" => Input::get('nip'),
                    "idgolru" => Input::get('idgolrupns'),
                    "pejmenpkt" => Input::get('pejmenpns'),
                    "nosk" => Input::get('noskpns'),
                    "tgsk" => date('Y-m-d', strtotime(Input::get('tgskpns'))),
                    "tmtpkt" => date('Y-m-d', strtotime(Input::get('tmtpns'))),
                    "gapok" => getGaji(Input::get('idgolrupns'), Input::get('mkthnpns')),
                    "thkerja" => Input::get('mkthnpns'),
                    "blkerja" => Input::get('mkblnpns'),
                    "user_id" => \Session::get('user_id'),
                    "role_id" => \Session::get('role_id'),
                    "created_at" => gmdate("Y-m-d H:i", time()+60*60*7)
                );
                \DB::table('r_gol')->insert($data_rgolpns);
            }
        }

        if (Input::get('idgolrupns')."".Input::get('mkthnpns') != Input::get('idgolrupkt')."".Input::get('mkthnpkt')) {
            if (Input::get('idgolrupkt') != '') {
                /*simpan riwayat pangkat terakhir*/
                $data_rgol = array(
                    "nip" => Input::get('nip'),
                    "idgolru" => Input::get('idgolrupkt'),
                    "pejmenpkt" => Input::get('pejmenpkt'),
                    "nosk" => Input::get('noskpkt'),
                    "tgsk" => date('Y-m-d', strtotime(Input::get('tgskpkt'))),
                    "tmtpkt" => date('Y-m-d', strtotime(Input::get('tmtpkt'))),
                    "gapok" => getGaji(Input::get('idgolrupkt'), Input::get('mkthnpkt')),
                    "thkerja" => Input::get('mkthnpkt'),
                    "blkerja" => Input::get('mkblnpkt'),
                    "user_id" => \Session::get('user_id'),
                    "role_id" => \Session::get('role_id'),
                    "created_at" => gmdate("Y-m-d H:i", time()+60*60*7)
                );
                \DB::table('r_gol')->insert($data_rgol);
            }
        }

        if (Input::get('idgolkgb') != '') {
            /*simpan riwayat kgb terakhir*/
            $data_rkgb = array(
                "nip" => Input::get('nip'),
                "noskkgb" => Input::get('noskkgb'),
                "tmtkgb" => date('Y-m-d', strtotime(Input::get('tmtkgb'))),
                "tglkgb" => date('Y-m-d', strtotime(Input::get('tgskkgb'))),
                "idgolru" => Input::get('idgolkgb'),
                "mkthn" => Input::get('mkgolthnkgb'),
                "mkbln" => Input::get('mkgolblnkgb'),
                "gaji" => getGaji(Input::get('idgolkgb'), Input::get('mkgolthnkgb')),
                "idpenetap" => Input::get('pejmenkgb')
            );
            \DB::table('r_kgb')->insert($data_rkgb);
        }

        if (Input::get('idtkpendidawal') != '') {
            /*simpan riwayat pendidikan awal*/
            $data_rpendawal = array(
                "nip" => Input::get('nip'),
                "idtkpendid" => Input::get('idtkpendidawal'),
                "idjenjurusan" => Input::get('idjenjurusanawal'),
                "jenjurusan" => getAttr('a_jenjurusan', 'idjenjurusan', Input::get('idjenjurusanawal'), 'jenjurusan'),
                "namasekolah" => Input::get('namasekolahawal'),
                "noijaz" => Input::get('noijazawal'),
                "tgijaz" => Input::get('thijazawal'),
                "tempat" => Input::get('almsekolahawal'),
                "kepsek" => Input::get('kepsekawal'),
                "isawal" => 1
            );
            \DB::table('r_pend')->insert($data_rpendawal);
        }

        if (Input::get('idtkpendidawal')."".Input::get('idjenjurusanawal') != Input::get('idtkpendid')."".Input::get('idjenjurusan')) {
            if (Input::get('idtkpendid')!='') {
                /*simpan riwayat pendidikan terakhir*/
                $data_rpendakhir = array(
                    "nip" => Input::get('nip'),
                    "idtkpendid" => Input::get('idtkpendid'),
                    "idjenjurusan" => Input::get('idjenjurusan'),
                    "jenjurusan" => getAttr('a_jenjurusan', 'idjenjurusan', Input::get('idjenjurusan'), 'jenjurusan'),
                    "namasekolah" => Input::get('namasekolah'),
                    "noijaz" => Input::get('noijaz'),
                    "tgijaz" => Input::get('thijaz'),
                    "tempat" => Input::get('almsekolah'),
                    "kepsek" => Input::get('kepsek'),
                    "isakhir" => 1
                );
                \DB::table('r_pend')->insert($data_rpendakhir);
            }
        }
    }

    //{controller-show}

    public function getEdit($id = false)
    {
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $biodata = $this->biodata->find($id);
        //if (is_null($biodata)){return \Redirect::to('epersonal/biodata/index');}
        return View::make('biodata::edit', compact('biodata'));
    }

    public function postEdit()
    {
        cekAjax();
        $id = Input::get('nip');
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rules);

        if ($validation->passes()) {
            $arrnot = array('','_token','id');
            $keydate = array('','tglhr','tgskjbt','tmtjbt','tgskcpn','tmtcpn','tgskpns','tmtpns','tgskpkt','tmtpkt','tgskkgb','tmtkgb','tgspmtcpn','tgspmtpns','tmtspmtcpn','tmtspmtpns');

            foreach ($input as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    } else {
                        $value = '0000-00-00';
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);

            if (\DB::table('tb_01')->where('nip', $id)->update($data)) {
                \DB::table('tb_01_temp')->where('nip', $id)->update(array('status'=> 1));
                echo "4";
            } else {
                echo "Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postEdittemp()
    {
        cekAjax();
        $id = Input::get('nip');
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rules);

        if ($validation->passes()) {
            $arrnot = array('','_token','id');
            $keydate = array('','tglhr','tgskjbt','tmtjbt','tgskcpn','tmtcpn','tgskpns','tmtpns','tgskpkt','tmtpkt','tgskkgb','tmtkgb','tgspmtcpn','tgspmtpns','tmtspmtcpn','tmtspmtpns');

            foreach ($input as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    } else {
                        $value = '0000-00-00';
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['status'] = 0;
            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);

            $rs = \DB::table('tb_01_temp')->where('nip', $input['nip'])->first();
            if (count($rs) > 0) {
                echo (\DB::table('tb_01_temp')->where('nip', $id)->update($data))?4:"Data Gagal Disimpan";
            } else {
                if (\DB::statement("INSERT INTO tb_01_temp SELECT *,'0','0','' FROM tb_01 WHERE nip = \"".$input['nip']."\"")) {
                    echo (\DB::table('tb_01_temp')->where('nip', $id)->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo "Data Gagal Disimpan";
                }
            }
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
                $this->biodata->find($id)->delete();
            }
            echo 'Data Berhasil Dihapus';
        } else {
            echo ($this->biodata->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function cek / validasi nip*/
    public function postCeknip()
    {
        cekAjax();
        $nip 	= Input::get('nip');
        $rs = \DB::table('tb_01')->select('nip')->where('nip', $nip)->first();

        if (strlen($nip) != 18) {
            $arr['err']  = 0;
            $arr['text'] = '<i class="fa fa-exclamation-circle" style="color: #9acd32;"> Nomor Induk Pegawai harus 18 digit.</i>';
        } else {
            if (count($rs) > 0) {
                $arr['err']  = 0;
                $arr['text'] = '<i class="fa fa-times-circle" style="color: #ff0000;"> Nomor Induk Pegawai sudah digunakan.</i>';
            } else {
                $arr['err']  = 1;
                $arr['text'] = '<i class="fa fa-check-circle" style="color: #008000"> Nomor Induk Pegawai tersedia.</i>';
            }
        }

        echo json_encode($arr);
    }

    /*function tingkat hukuman */
    public function postTkhukum()
    {
        cekAjax();
        $idjenhukum = Input::get('idjenhukum');
        $rs = \DB::table('a_jenhukum')->select('kdkategori')->where('idjenhukum', $idjenhukum)->first();
        echo "<div style='' class='' id='alert-tkhukum'>".comboTkhukum("idtkhukum", $rs->kdkategori, "readonly")."</div>";
    }

    /*function cari pegawai*/
    public function postCaripegawai()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $where = "(a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\")";
        if (session('role_id') == 4) {
            $where .= " and a.idskpd like \"".session('idskpd')."%\" and a.idjenkedudupeg not in (99,21)";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.nip',
                'a.nama',
                'a.nip as id',
                'a.nama as text',
                'a.photo',
                'b.skpd',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
            )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
            ->whereRaw($where)
            /*->where('a.nip', 'like', '%'.$keyword. '%')
            ->orwhere('a.nama', 'like', '%'.$keyword. '%')*/
            ->orderBy('a.nama', 'asc')
            ->orderBy('a.nip', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function tempat lahir*/
    public function postTempatlahir()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_kabkota')
            ->select('kdkabkota', 'kabkota', 'kabkota as id', 'kabkota as text')
            ->where('kabkota', 'like', '%'.$keyword. '%')
            ->orderBy('kabkota', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jurusan*/
    public function postJenjurusan()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_jenjurusan')
            ->select('idjenjurusan', 'jenjurusan', 'idjenjurusan as id', 'jenjurusan as text')
            ->where('idtkpendid', '=', $parent)
            ->where('jenjurusan', 'like', '%'.$keyword. '%')
            ->orderBy('jenjurusan', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari diklat fungsional*/
    public function postDikfung()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_dikfung')
            ->select('iddikfung', 'dikfung', 'iddikfung as id', 'dikfung as text')
            ->where('dikfung', 'like', '%'.$keyword. '%')
            ->orderBy('dikfung', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari pejabat*/
    public function postPejabat()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_pejabat')
            ->select('kode', 'nama', 'kode as id', 'nama as text')
            ->where('nama', 'like', '%'.$keyword. '%')
            ->orderBy('nama', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function detail pegawai*/
    public function postDetailpegawai()
    {
        cekAjax();
        $nip = Input::get('nip');
        if ($nip != '') {
            $rs1 = \DB::table('tb_01 as a')
                ->select(
                    'a.*',
                    'b.skpd',
                    'c.isguru',
                    'b.path as skpdunit',
                    // \DB::raw('IF(LENGTH(a.idskpd) > 3, CONCAT(b.skpd," ",g.skpd), g.skpd) as skpdunit'),
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,h.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap'),
                    'e.jenjurusan',
                    'f.jenjurusan as jenjurusanawal'
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as g', 'a.kdunit', '=', 'g.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as h', 'a.idjabnonjob', '=', 'h.idjabnonjob')
                ->leftjoin('a_jenjurusan as e', 'a.idjenjurusan', '=', 'e.idjenjurusan')
                ->leftjoin('a_jenjurusan as f', 'a.idjenjurusanawal', '=', 'f.idjenjurusan')
                ->where('a.nip', '=', $nip);

            $rs2 = \DB::table('tb_01_temp as a')
                ->select(
                    'a.*',
                    'b.skpd',
                    'c.isguru',
                    \DB::raw('IF(LENGTH(a.idskpd) > 3, CONCAT(b.skpd," ",g.skpd), g.skpd) as skpdunit'),
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,h.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap'),
                    'e.jenjurusan',
                    'f.jenjurusan as jenjurusanawal'
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as g', 'a.kdunit', '=', 'g.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as h', 'a.idjabnonjob', '=', 'h.idjabnonjob')
                ->leftjoin('a_jenjurusan as e', 'a.idjenjurusan', '=', 'e.idjenjurusan')
                ->leftjoin('a_jenjurusan as f', 'a.idjenjurusanawal', '=', 'f.idjenjurusan')
                ->where('a.nip', '=', $nip)
                ->where('a.status', '!=', 1);

            if ($rs2->count() > 0) {
                /*jika temporari ditemukan*/
                $ret = $rs2->first();
                $ret->ketstatus = '1';
            } else {
                /*jika temporari tidak ditemukan*/
                $ret = $rs1->first();
                $ret->ketstatus = '0';
            }
        } else {
            $ret = '';
        }

        echo json_encode($ret);
    }

    /*function detail pegawai perubhan*/
    public function postDetailpegawaiperubahan()
    {
        cekAjax();
        $nip = Input::get('nip');
        if ($nip != '') {
            $ret = \DB::table('tb_01_temp as a')
                ->select(
                    'a.*',
                    'b.skpd',
                    'c.isguru',
                    \DB::raw('IF(LENGTH(a.idskpd) > 3, CONCAT(b.skpd," ",g.skpd), g.skpd) as skpdunit'),
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,h.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap'),
                    \DB::raw('IF(a.status = 1,"Disetujui",IF(a.status = 2,"Ditolak","Belum ada tanggapan")) as stspermohonan'),
                    \DB::raw('IF(a.status = 1,"-",IF(a.status = 2,a.ketditolak,"Belum ada tanggapan")) as ketpermohonan'),
                    'e.jenjurusan',
                    'f.jenjurusan as jenjurusanawal'
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as g', 'a.kdunit', '=', 'g.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as h', 'a.idjabnonjob', '=', 'h.idjabnonjob')
                ->leftjoin('a_jenjurusan as e', 'a.idjenjurusan', '=', 'e.idjenjurusan')
                ->leftjoin('a_jenjurusan as f', 'a.idjenjurusanawal', '=', 'f.idjenjurusan')
                ->where('a.nip', '=', $nip)->first();
        } else {
            $ret = '';
        }

        echo json_encode($ret);
    }

    /*function cari skpd*/
    public function postSkpd()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_skpd')
            ->select('idskpd', 'skpd', 'path', 'idskpd as id', 'path as text')
            ->where('flag', 1)
            ->where('path', 'like', '%'.$keyword. '%')
            ->orderBy('idskpd', 'asc')
            ->orderBy('skpd', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari skpd unit*/
    public function postSkpdunit()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_skpd')
            ->select('idskpd', 'skpd', 'idskpd as id', 'skpd as text')
            ->where('flag', 1)
            ->whereRaw("left(idskpd, 2) = \"".$parent."\"")
            ->where('skpd', 'like', '%'.$keyword. '%')
            ->orderBy('idskpd', 'asc')
            ->orderBy('skpd', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function untuk menampilkan inputan jabatan*/
    public function postJenisjabatan()
    {
        cekAjax();
        $nip = Input::get('nip');
        $data['idjenjab'] = Input::get('idjenjab');

        $data['rs'] = \DB::table('tb_01 as a')
            ->select(
                'a.idjabjbt',
                'a.idjabfung',
                'a.idjabfungum',
                'a.idesljbt',
                'a.iskepsek',
                'a.idtugasgurudosen',
                'a.idtugasdokter',
                'a.isdiperbantukan',
                'a.iddiperbantukan',
                'a.idmatkulpel',
                'a.nopak',
                'b.idskpd',
                'b.skpd',
                'c.isguru',
                'b.jab',
                'c.jabfung',
                'd.jabfungum',
                'e.tugasgurudosen',
                'f.matkulpel',
                'g.idjabnonjob',
                'g.jabnonjob',
                'h.nmasekolah',
                'a.iddesa',
                'a.nmadesa',
                'a.idkepsek',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
            ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
            ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
            ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
            ->where('a.nip', '=', $nip)
            ->first();

        return View::make('biodata::jabatan', $data);
    }

    public function postJenisjabatanperubahan()
    {
        cekAjax();
        $nip = Input::get('nip');
        $data['idjenjab'] = Input::get('idjenjab');

        $data['rs'] = \DB::table('tb_01_temp as a')
            ->select(
                'a.idjabjbt',
                'a.idjabfung',
                'a.idjabfungum',
                'a.idesljbt',
                'a.iskepsek',
                'a.idtugasgurudosen',
                'a.idtugasdokter',
                'a.isdiperbantukan',
                'a.iddiperbantukan',
                'a.idmatkulpel',
                'a.nopak',
                'b.idskpd',
                'b.skpd',
                'c.isguru',
                'b.jab',
                'c.jabfung',
                'd.jabfungum',
                'e.tugasgurudosen',
                'f.matkulpel',
                'g.idjabnonjob',
                'g.jabnonjob',
                'h.nmasekolah',
                'a.iddesa',
                'a.nmadesa',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan')
            )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
            ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
            ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
            ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
            ->where('a.nip', '=', $nip)
            ->first();

        return View::make('biodata::jabatan3', $data);
    }

    /*function untuk menampilkan inputan jabatan pada modal*/
    public function postJenisjabatan2()
    {
        cekAjax();
        $nip = Input::get('nip');
        $data['idjenjab'] = Input::get('idjenjab');
        $data['idskpd'] = Input::get('idskpd');

        /*if(Input::get('flag') == 1){
            $data['rs'] = \DB::table('tb_01 as a')
                ->select(
                    'a.idjabjbt', 'a.idjabfung', 'a.idjabfungum', 'a.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd',
                    'c.isguru','b.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.nip', '=', $nip)
                ->first();
        }else if((Input::get('flag') == 2) or (Input::get('flag') == 3)){
            $data['rs'] = \DB::table('r_jab as a')
                ->select(
                    'a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd',
                    'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }else if(Input::get('flag') == ''){
            $data['rs'] = \DB::table('r_jab_temp as a')
                ->select(
                    'a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd',
                    'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }*/

        if (Input::get('tb') == 'r_jab') {
            $data['rs'] = \DB::table('r_jab as a')
                ->select(
					'a.isttb',
                    'a.idkoord',
                    'a.idjab as idjabjbt',
                    'c.idjabfung',
                    'd.idjabfungum',
                    'g.idjabnonjob',
                    'a.idesljbt',
                    'a.iskepsek',
                    'a.idtugasgurudosen',
                    'a.idtugasdokter',
                    'a.isdiperbantukan',
                    'a.iddiperbantukan',
                    'a.idmatkulpel',
                    'a.nopak',
                    'b.idskpd',
                    'b.skpd',
                    'c.isguru',
                    'a.jab',
                    'c.jabfung',
                    'd.jabfungum',
                    'e.tugasgurudosen',
                    'f.matkulpel',
                    'g.jabnonjob',
                    'h.nmasekolah',
                    'a.iddesa',
                    'a.nmadesa',
                    'i.esl',
                    'a.idkepsek',
                    'a.tmtkepsek',
                    'a.noskkepsek',
                    'a.idjenjab',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('j.skpd as kepseksekolah')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        } elseif (Input::get('tb') == 'r_jab_temp') {
            $data['rs'] = \DB::table('r_jab_temp as a')
                ->select(
					'a.isttb',
                    'a.idkoord',
                    'a.idjab as idjabjbt',
                    'c.idjabfung',
                    'd.idjabfungum',
                    'g.idjabnonjob',
                    'a.idesljbt',
                    'a.iskepsek',
                    'a.idtugasgurudosen',
                    'a.idtugasdokter',
                    'a.isdiperbantukan',
                    'a.iddiperbantukan',
                    'a.idmatkulpel',
                    'a.nopak',
                    'b.idskpd',
                    'b.skpd',
                    'c.isguru',
                    'a.jab',
                    'c.jabfung',
                    'd.jabfungum',
                    'e.tugasgurudosen',
                    'f.matkulpel',
                    'g.jabnonjob',
                    'h.nmasekolah',
                    'a.iddesa',
                    'a.nmadesa',
                    'i.esl',
                    'a.idkepsek',
                    'a.tmtkepsek',
                    'a.noskkepsek',
                    'a.idjenjab',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('j.skpd as kepseksekolah')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        } else {
            $data['rs'] = \DB::table('tb_01 as a')
                ->select(
					'a.isttb',
                    'a.idkoord',
                    'a.idjabjbt',
                    'a.idjabfung',
                    'a.idjabfungum',
                    'a.idjabnonjob',
                    'a.idesljbt',
                    'a.iskepsek',
                    'a.idtugasgurudosen',
                    'a.idtugasdokter',
                    'a.isdiperbantukan',
                    'a.iddiperbantukan',
                    'a.idmatkulpel',
                    'a.nopak',
                    'b.idskpd',
                    'b.skpd',
                    'c.isguru',
                    'b.jab',
                    'c.jabfung',
                    'd.jabfungum',
                    'e.tugasgurudosen',
                    'f.matkulpel',
                    'g.jabnonjob',
                    'h.nmasekolah',
                    'a.iddesa',
                    'a.nmadesa',
                    'i.esl',
                    'a.idkepsek',
                    'a.tmtkepsek',
                    'a.noskkepsek',
                    'a.idjenjab',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('j.skpd as kepseksekolah')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.nip', '=', 'null') //$nip
                ->first();
        }

        return View::make('biodata::jabatan2', $data);
    }

    /*function cari matkulpel*/
    public function postMatkulpel()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_matkulpel')
            ->select('idmatkulpel', 'matkulpel', 'idmatkulpel as id', 'matkulpel as text')
            ->where('idtugasgurudosen', '=', $parent)
            ->where('matkulpel', 'like', '%'.$keyword. '%')
            ->orderBy('matkulpel', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jabatan struktural*/
    public function postJabstruk()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $parent2 	= Input::get('parent2');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_skpd')
            ->select('idskpd', 'jab', 'idskpd as id', 'jab as text')
            ->where('flag', 1)
            ->where('jab_asn', '=', $parent2)
            ->where('idskpd', 'like', ''.$parent. '%')
            ->where('jab', 'like', '%'.$keyword. '%')
            ->orderBy('idskpd', 'asc')
            ->orderBy('jab', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jabatan fungsional*/
    public function postJabfung()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_jabfung')
            ->select('idjabfung', 'jabfung', 'idjabfung as id', 'jabfung as text')
            ->where('flag', 1)
            ->where('jabfung', 'like', '%'.$keyword. '%')
            ->orderBy('jabfung', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jabatan fungsional umum*/
    public function postJabfungum()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_jabfungum')
            ->select('idjabfungum', 'jabfungum', 'idjabfungum as id', 'jabfungum as text')
            ->where('flag', 1)
            ->where('jabfungum', 'like', '%'.$keyword. '%')
            ->orderBy('jabfungum', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jabatan non job*/
    public function postJabnonjob()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_jabnonjob')
            ->select('idjabnonjob', 'jabnonjob', 'idjabnonjob as id', 'jabnonjob as text')
            ->where('jabnonjob', 'like', '%'.$keyword. '%')
            ->orderBy('jabnonjob', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari sekolah swasta*/
    public function postSekolahswasta()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_sekolahswasta')
            ->select('id', 'nmasekolah', 'nmasekolah as text')
            ->where('nmasekolah', 'like', '%'.$keyword. '%')
            ->orderBy('status', 'asc')
            ->orderBy('nmasekolah', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari sekolah swasta*/
    public function postKepseksekolah()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_skpd')
            ->select('idskpd', 'skpd', 'idskpd as id', 'skpd as text')
            ->where('idskpd', '=', $parent)
            ->orderBy('skpd', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari Kelurahan*/
    public function postKelurahan()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table('a_kel')
            ->select('kdkel', 'kel', 'kdkel as id', 'kel as text')
            ->where('kel', 'like', '%'.$keyword. '%')
            ->orderBy('kel', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function view modal untuk ganti foto pegawai*/
    public function postFoto()
    {
        cekAjax();
        $nip  = Input::get('nip');
        $rs = \DB::table('tb_01_temp')->where('nip', $nip)->where('status', '=', '0')->first();
        if (count($rs) > 0) {
            $rs = \DB::table('tb_01_temp')->select('nip', 'photo')->where('nip', '=', $nip)->first();
        } else {
            $rs = \DB::table('tb_01')->select('nip', 'photo')->where('nip', '=', $nip)->first();
        }
        return View::make('biodata::foto', compact('rs'));
    }

    /*function view data atribut dari link */
    public function postData()
    {
        cekAjax();
        $data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('biodata::'.$view.'', $data);
    }

    public function postKelolafile()
    {
        cekAjax();
        $data['nip'] = Input::get('nip');
        $data['nama_jenis'] = Input::get('nama_jenis');
        $data['jenis'] = Input::get('jenis');
        $data['subjenis'] = Input::get('subjenis');
        \Input::get('subsubjenis') == '' ? $data['subsubjenis'] = 0 : $data['subsubjenis'] = \Input::get('subsubjenis');
        return View::make('biodata::kelolafile', $data);
    }

    /*function print atribut dari link */
    public function postPrint()
    {
        $view = Request::segment(4);
        return View::make('biodata::'.$view.'_print');
    }

    /*function upload foto pegawai*/
    public function postUpdatefoto()
    {
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        if (Input::hasFile('photo')) {
            $destinationPath = base_path().'/packages/upload/photo/pegawai';
            $mode = 0777;
            $recursive = false;
            $f = Input::file('photo');
            if((substr_count($f->getClientOriginalName(), '.') == 1) and (($f->getClientOriginalExtension() == 'jpg') or ($f->getClientOriginalExtension() == 'png'))){
                if ($f != '') {
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, $mode, $recursive);
                    }
                    //                die($destinationPath);
                    $tipefile = $f->getClientOriginalExtension();
                    /*$filename = str_replace(' ', '-', $f->getClientOriginalName());*/
                    $ctime = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
                    $filename = $input['nip']."_".$ctime.".".$f->getClientOriginalExtension();
                    @unlink($destinationPath.'/'.$filename);
                    $f->move($destinationPath, $filename);
                    $input['photo'] = $filename;
                }
            }else{
                echo "Ubah profil gagal. Format foto yang diijinkan hanya .jpg"; exit();
            }
        } else {
            echo "Ubah profil gagal. Format foto yang diijinkan hanya .jpg"; exit();
        }

        if (session('role_id') <= 3) {
            $biodata = $this->biodata->find($input['nip']);
            echo ($biodata->update($input))?4:"Data Gagal Disimpan";
        } else {
            $input['status'] = 0;
            $rs = \DB::table('tb_01_temp')->where('nip', $input['nip'])->first();
            if (count($rs) > 0) {
                echo (\DB::table('tb_01_temp')->where('nip', $input['nip'])->update($input))?4:"Data Gagal Disimpan";
            } else {
                if (\DB::statement("INSERT INTO tb_01_temp SELECT *,'0','0','' FROM tb_01 WHERE nip = \"".$input['nip']."\"")) {
                    echo (\DB::table('tb_01_temp')->where('nip', $input['nip'])->update($input))?4:"Data Gagal Disimpan";
                } else {
                    echo "Data Gagal Disimpan";
                }
            }
        }
    }


    /*function edit riwayat*/
    public function postEditriwayat()
    {
        cekAjax();
        $id = Input::get("id");
        $tb = Input::get("tb");
        $rs = \DB::table($tb)->where('id', $id)->first();
        echo json_encode($rs);
    }

    /*function hapus riwayat*/
    public function postDelriwayat()
    {
        cekAjax();
        $id = Input::get("id");
        $tb = Input::get("tb");
    
          // start
        // echo (\DB::table($tb)->where('id', $id)->delete()) ? 9 : 'Data Gagal Dihapus.';
        // menghapus riwayat dan sinkron siasn khusus untuk jabatan 11022025

       if ($tb == 'r_jab') {
            // mencari data riwayat
            $rs = \DB::table($tb)->where('id', $id)->first();
            $idRiwayat = $rs->idjabbkn;
            // mencari data pegawai
            $rspegawai = \DB::table('tb_01')->where('nip', $rs->nip)->first();
            $idstspeg = $rspegawai->idstspeg;
            // end data pegawai

            // jika data pppk dihapus maka tidak melakukan pengecekan siasn
            if ($idstspeg == '3') {
                echo (\DB::table($tb)->where('id', $id)->delete()) ? 9 : 'Data Gagal Dihapus.';
            } else {
                $send = accessDatadeletesiasn('jabatan/delete', $idRiwayat);
                if ($send->message == "success") {
                    echo (\DB::table($tb)->where('id', $id)->delete()) ? 9 : 'Data Gagal Dihapus.';
                } else {
                    echo 'Gagal Sinkron Data, ' . $send->message;
                }
            }
            //end
        } else {
            echo (\DB::table($tb)->where('id', $id)->delete()) ? 9 : 'Data Gagal Dihapus.';
        }
        // end
    }

    /*function untuk mendapatkan gaji*/
    public function postGaji()
    {
        cekAjax();
        $golongan = Input::get('idgolru');
        $thmasker = Input::get('mkthn');
        $ret['gaji'] = '';

        if (strlen($thmasker) < 2) {
            $thmasker = '0'.$thmasker;
        } elseif (strlen($thmasker) == 0) {
            $thmasker = '00';
        }

        $cek = \DB::table('a_gaji')->select(\DB::raw('max(msk) as mskmax'))->where('pkt', $golongan)->where('status', 1)->first();
        if (count($cek) > 0) {
            if ($thmasker > $cek->mskmax) {
                $masaker = $cek->mskmax;
            } else {
                $masaker = $thmasker;
            }

            $rsgaji = \DB::table('a_gaji')->select('gaji')->where('pkt', $golongan)->where('status', 1)->where('msk', $masaker)->first();
            if (count($rsgaji) > 0) {
                $ret['gaji'] = $rsgaji->gaji;
            }
        }

        echo json_encode($ret);
    }

    /*function untuk mendapatkan eselon*/
    public function postEselon()
    {
        cekAjax();
        $idskpd = Input::get('idjabjbt');
        $rs = \DB::table('a_skpd')->select('idesl')->where('idskpd', $idskpd)->first();
        if ($rs) {
            $ret['idesl'] = $rs->idesl;
        } else {
            $ret['idesl'] = '';
        }

        echo json_encode($ret);
    }

    /*function simpan riwayat pangkat*/
    public function postSaverpangkat()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpangkat);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgsk','tmtpkt');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    if ($value != '') {
                        $val = explode("-", $value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    }
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_gol')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_gol')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postSaverpangkattemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpangkat);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            $keydate = array('','tgsk','tmtpkt');

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

            if (($input['tb'] == 'r_gol') or ($input['tb'] == '')) {
                $rs = \DB::table('r_gol_temp')->where('id_rgol', '>', 0)->where('id_rgol', $input['id_rgol'])->get();
            } else {
                $rs = \DB::table('r_gol_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_gol') {
                    echo (\DB::table('r_gol_temp')->where('id_rgol', '>', 0)->where('id_rgol', $input['id_rgol'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_gol_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_gol_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat pangkat*/

    /*function simpan riwayat jabatan*/
    public function postSaverjab(JabatanService $srv)
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rjabatan);
        if ($validation->passes()) {

            $arrnot = array('','_token','idjnsaksi');
            if (!empty($input['tmtkepsek'])) {
                $keydate = array('','tgsk','tmtjab','tmtkepsek');
            } else {
                $keydate = array('','tgsk','tmtjab');
            }

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

			if(Input::get('isttb')==0){
	            $data['idkoord']="";
        	}

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');

            // dd($data);
//            $dataSend = $this->jabatanSerializeData($data);
//            $send = $srv->store($dataSend);
//
//            if (isset($send['success'])  && $send['success'] == true) {
//                $data['idjabbkn'] = $send['mapData']['rwJabatanId'];
//                if ($input['id'] == '') {
//                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
//                    echo (\DB::table('r_jab')->insert($data))?1:"Data Gagal Disimpan";
//                } else {
//                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
//                    echo (\DB::table('r_jab')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
//                }
//            } else {
//                echo "Gagal Mengrim data ke bkn.{$send['message']}";
//            }

            $idstspeg = \BiodataModel::getStatuspegawai(\Input::get('nip'));
            /*cek status peawai pppk integrasi bkn*/	
            if($idstspeg != 3){
                $dataSend = $this->jabatanSerializeDatasiasn($data);
               // $send = accessDatapostsiasn('jabatan/save', $dataSend);
            $send = accessDatapostsiasn('jabatan/unorjabatan/save', $dataSend);
                if (isset($send->message)  && $send->message == "success") {
                    $data['idjabbkn'] = $send->{'mapData'}->rwJabatanId;
                    if ($input['id'] == '') {
                        $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                        echo (\DB::table('r_jab')->insert($data))?1:"Data Gagal Disimpan";
                    } else {
                        $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                        echo (\DB::table('r_jab')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                    }
                } else {
                    echo "Gagal Mengrim data ke SIASN.{$send->message}";
                }
            }else{
                if ($input['id'] == '') {
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_jab')->insert($data))?1:"Data Gagal Disimpan";
                } else {
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_jab')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postSaverjabtemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rjabatan);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            if (!empty($input['tmtkepsek'])) {
                $keydate = array('','tgsk','tmtjab','tmtkepsek');
            } else {
                $keydate = array('','tgsk','tmtjab');
            }

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

			if(Input::get('isttb')==0){
                $data['idkoord']="";
            }

            if (($input['tb'] == 'r_jab') or ($input['tb'] == '')) {
                $rs = \DB::table('r_jab_temp')->where('id_rjab', '>', 0)->where('id_rjab', $input['id_rjab'])->get();
            } else {
                $rs = \DB::table('r_jab_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_jab') {
                    echo (\DB::table('r_jab_temp')->where('id_rjab', '>', 0)->where('id_rjab', $input['id_rjab'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_jab_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_jab_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat jabatan*/

    /*function simpan riwayat kgb*/
    public function postSaverkgb()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rkgb);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tmtkgb','tglkgb');

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

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_kgb')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_kgb')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postSaverkgbtemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rkgb);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            $keydate = array('','tmtkgb','tglkgb');

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

            if (($input['tb'] == 'r_kgb') or ($input['tb'] == '')) {
                $rs = \DB::table('r_kgb_temp')->where('id_rkgb', '>', 0)->where('id_rkgb', $input['id_rkgb'])->get();
            } else {
                $rs = \DB::table('r_kgb_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_kgb') {
                    echo (\DB::table('r_kgb_temp')->where('id_rkgb', '>', 0)->where('id_rkgb', $input['id_rkgb'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_kgb_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_kgb_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat kgb*/

    /*function simpan riwayat pendidikan*/
    public function postSaverpend()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpend);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgijaz');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['isawal']  = Input::get('isawal');
            $data['isakhir'] = Input::get('isakhir');
            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            /*update riwayat selain awal*/
            if ($data['isawal'] == 1) {
                \DB::table('r_pend')->where('nip', $input['nip'])->update(array('isawal'=>0));
            }
            /*update riwayat selain akhir*/
            if ($data['isakhir'] == 1) {
                \DB::table('r_pend')->where('nip', $input['nip'])->update(array('isakhir'=>0));
            }

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pend')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pend')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postSaverpendtemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpend);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            $keydate = array('','tgijaz');

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

            if (($input['tb'] == 'r_pend') or ($input['tb'] == '')) {
                $rs = \DB::table('r_pend_temp')->where('id_rpend', '>', 0)->where('id_rpend', $input['id_rpend'])->get();
            } else {
                $rs = \DB::table('r_pend_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_pend') {
                    echo (\DB::table('r_pend_temp')->where('id_rpend', '>', 0)->where('id_rpend', $input['id_rpend'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_pend_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pend_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat pendidikan*/

    /*function simpan riwayat diklat struktural*/
    public function postSaverdikstru()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->dikstruSerializeData($input); //initial submit siasn
        $validation = \Validator::make($input, BiodataModel::$rdikstru);
        if ($validation->passes()) {
            $arrnot = array('','_token');
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

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            $send = accessDatapostsiasn('diklat/save',$dataSend);
            if ($send->message == "success") {
                $data['idsapk'] = $send->{'mapData'}->rwDiklatId;
                if ($input['id'] == '') {
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_dikstru')->insert($data))?1:"Data Gagal Disimpan";
                } else {
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_dikstru')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            }else{
                echo 'Gagal Sinkron Data, '.$send->message;
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    /*function simpan riwayat dikstru pegawai simpeg to bkn*/
    private function dikstruSerializeData($data)
    {
        $sinkron = new SinkronisasiModel();
        $tahun = date('Y', strtotime($data['tgsttpdikstru']));
        $jam = $data['jamhari'];
        $dataSend  = [
            'id' => null,
            'nip' => $data['nip'],
            'tahun' => (int)$tahun,
            'latihanStrukturalId' => $sinkron->getTable('a_dikstru', 'iddikstru', $data['iddikstru'], 'idsapk'),
            'latihanStrukturalNama' => $data['dikstru'],
            'tanggal' => $data['tgsttpdikstru'],
            'tanggalSelesai' => $data['tgsel'],
            'nomor' => $data['nosttpdikstru'],
            'jumlahJam' => (int)$jam,
            'institusiPenyelenggara' => $data['penyelenggara'],
            'pnsOrangId' => $sinkron->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    public function postSaverdikstrutemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rdikstru);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
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

            if (($input['tb'] == 'r_dikstru') or ($input['tb'] == '')) {
                $rs = \DB::table('r_dikstru_temp')->where('id_rdikstru', '>', 0)->where('id_rdikstru', $input['id_rdikstru'])->get();
            } else {
                $rs = \DB::table('r_dikstru_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_dikstru') {
                    echo (\DB::table('r_dikstru_temp')->where('id_rdikstru', '>', 0)->where('id_rdikstru', $input['id_rdikstru'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_dikstru_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_dikstru_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat diklat struktural*/

    /*function simpan riwayat diklat fungsional*/
    public function postSaverdikfung()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->dikfungSerializeData($input);
        $validation = \Validator::make($input, BiodataModel::$rdikfung);
        if ($validation->passes()) {
            $arrnot = array('','_token');
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

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            $send = accessDatapostsiasn('kursus/save',$dataSend);
            if ($send->message == "success") {
                $data['idsapk'] = $send->{'mapData'}->rwKursusId;
                if ($input['id'] == '') {
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_dikfung')->insert($data))?1:"Data Gagal Disimpan";
                } else {
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_dikfung')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                echo 'Gagal Sinkron Data, '.$send->message;
            }
        } else {
            echo 'Input tidak valid';
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
            'tanggalKursus' => $data['tgsttpdikfung'],
            'tanggalSelesaiKursus' => $data['tgsel'],
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdikfung'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $sinkron->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    public function postSaverdikfungtemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rdikfung);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
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

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');

            if (($input['tb'] == 'r_dikfung') or ($input['tb'] == '')) {
                $rs = \DB::table('r_dikfung_temp')->where('id_rdikfung', '>', 0)->where('id_rdikfung', $input['id_rdikfung'])->get();
            } else {
                $rs = \DB::table('r_dikfung_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_dikfung') {
                    echo (\DB::table('r_dikfung_temp')->where('id_rdikfung', '>', 0)->where('id_rdikfung', $input['id_rdikfung'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_dikfung_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_dikfung_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat diklat fungsional*/

    /*function simpan riwayat diklat teknis*/
    public function postSaverdiktek()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->diktekSerializeData($input);
        $validation = \Validator::make($input, BiodataModel::$rdiktek);
        if ($validation->passes()) {
            $arrnot = array('','_token');
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

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            $send = accessDatapostsiasn('kursus/save',$dataSend);
            if ($send->message == "success") {
                $data['idsapk'] = $send->{'mapData'}->rwKursusId;
                if ($input['id'] == '') {
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_diktek')->insert($data))?1:"Data Gagal Disimpan";
                } else {
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_diktek')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                echo 'Gagal Sinkron Data, '.$send->message;
            }
        } else {
            echo 'Input tidak valid';
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
            'tanggalKursus' => date('d-m-Y', strtotime($data['tgsttpdiktek'])),
            'tanggalSelesaiKursus' => date('d-m-Y', strtotime($data['tgsel'])),
            'institusiPenyelenggara' => $data['penyelenggara'],
            'nomorSertipikat' => $data['nosttpdiktek'],
            'jumlahJam' => (int)$jam,
            'pnsOrangId' => $sinkron->getPnsIdSapk($data['nip']),
        ];

        return $dataSend;
    }

    public function postSaverdiktektemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rdiktek);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
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

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');

            if (($input['tb'] == 'r_diktek') or ($input['tb'] == '')) {
                $rs = \DB::table('r_diktek_temp')->where('id_rdiktek', '>', 0)->where('id_rdiktek', $input['id_rdiktek'])->get();
            } else {
                $rs = \DB::table('r_diktek_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_diktek') {
                    echo (\DB::table('r_diktek_temp')->where('id_rdiktek', '>', 0)->where('id_rdiktek', $input['id_rdiktek'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_diktek_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_diktek_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat diklat teknis*/

    /*function simpan riwayat seminar*/
    public function postSaverseminar()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->seminarSerializeData($input);
        $validation = \Validator::make($input, BiodataModel::$rseminar);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgmul','tgsel');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            $send = accessDatapostsiasn('kursus/save',$dataSend);
            if ($send->message == "success") {
                $data['idsapk'] = $send->{'mapData'}->rwKursusId;
                if ($input['id'] == '') {
                    $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_seminar')->insert($data))?1:"Data Gagal Disimpan";
                } else {
                    $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                    echo (\DB::table('r_seminar')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            }else{
                echo 'Gagal Sinkron Data, '.$send->message;
            }
        } else {
            echo 'Input tidak valid';
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
    /*end of riwayat seminar*/

    /*function simpan riwayat bahasa*/
    public function postSaverbahasa()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rbahasa);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_bahasa')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_bahasa')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat bahasa*/

    /*function simpan riwayat penghargaan*/
    public function postSaverpenghargaan()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpenghargaan);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgsk');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_tandajasa')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_tandajasa')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat penghargaan*/

    /*function simpan riwayat hukum disiplin*/
    public function postSaverhukdis()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rhukdis);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            $keydate = array('','tgsk','tgmul','tgsel');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_hukdis')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_hukdis')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postSaverhukdistemp()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rhukdis);
        if ($validation->passes()) {
            $arrnot = array('','_token','tb');
            $keydate = array('','tgsk','tgmul','tgsel');

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

            if (($input['tb'] == 'r_hukdis') or ($input['tb'] == '')) {
                $rs = \DB::table('r_hukdis_temp')->where('id_rhukdis', '>', 0)->where('id_rhukdis', $input['id_rhukdis'])->get();
            } else {
                $rs = \DB::table('r_hukdis_temp')->where('id', $input['id'])->get();
            }

            if (count($rs) > 0) {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if ($input['tb'] == 'r_hukdis') {
                    echo (\DB::table('r_hukdis_temp')->where('id_rhukdis', '>', 0)->where('id_rhukdis', $input['id_rhukdis'])->update($data))?4:"Data Gagal Disimpan";
                } else {
                    echo (\DB::table('r_hukdis_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            } else {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_hukdis_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat hukum disiplin*/

    /*function simpan sasaran kinerja pegawai*/
    public function postSaverskp(SkpService $srv)
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rskp);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['user_id'] = \Session::get('user_id');

            $dataSend = $this->skpSerializeData($data);

            unset($data['idjenjab']);

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                try {
                    $lastInsert = \DB::table('r_skp')->insertGetId($data);

                    if (!is_null($lastInsert)) {
                        $send = $srv->store($dataSend);

                        if($send['success']== true)
                        {
                        $updateIdSkpBkn = \DB::table('r_skp')->where('id', $lastInsert)
                        ->update(['idskpbkn' => $send['mapData']['rwSkpId']]);
                        echo '1';
                        }else{
                            echo $send['message'];
                        }
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    echo 'Gagal Menyimpan Data';
                }

                // if ($lastInsert) {
                //     $send = $srv->store($dataSend);
                // }
                //echo (\DB::table('r_skp')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_skp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat sasaran kinerja pegawai*/

    public function postSaverkinerjaasn(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rkinerjaasn);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            foreach($_POST as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');

            if($input['id'] == ''){
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_kinerjaasn')->insert($data))?1:"Data Gagal Disimpan";
            }else{
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_kinerjaasn')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    private function skpSerializeData($data)
    {

        $perilaku =   [floatval($data['orpel']), floatval($data['integritas']), floatval($data['komitmen']) ,floatval($data['disiplin']) ,floatval($data['kerjasama'])];
       if($data['idjenjab'] == 1) {
         array_push($perilaku, floatval($data['pim']));
       }

        $jumlahPerilaku =  array_sum($perilaku);
        $nilaiPerilaku = $jumlahPerilaku / count($perilaku);
        $dataSend = array(
          'id' => isset($data['idskpbkn'])?$data['idskpbkn']:'',
          'tahun' => (int)$data['tahun'],
          'nilaiSkp' => floatval($data['nilai']),
          'orientasiPelayanan' =>  floatval($data['orpel']),
          'integritas' =>  floatval($data['integritas']),
          'komitmen' =>  floatval($data['komitmen']),
          'disiplin' =>  floatval($data['disiplin']),
          'kerjasama' =>  floatval($data['kerjasama']),
          'nilaiPerilakuKerja' =>   $nilaiPerilaku,
          'nilaiPrestasiKerja' => floatval($data['nilaiprestasi']),

          'jumlah' =>   $jumlahPerilaku ,
          'nilairatarata' => $nilaiPerilaku,
          'atasanPejabatPenilai' => getPnsIdSapk($data['nippenilai']),
          'pejabatPenilai' =>  getPnsIdSapk($data['nipatasan']),
          'pnsDinilaiOrang' => getPnsIdSapk($data['nip']),
          'penilaiNipNrp' => $data['nippenilai'],
          'atasanPenilaiNipNrp' => $data['nipatasan'],
          'penilaiNama' => $data['pejpenilai'],
          'atasanPenilaiNama' => $data['pejatasan'],
          'penilaiUnorNama' => $data['skpdpenilai'],
          'atasanPenilaiUnorNama' => $data['skpdpenilai'],
          'penilaiJabatan' => $data['jabpenilai'],
          'atasanPenilaiJabatan' => $data['jabatasan'],
          'penilaiGolongan' => getGolru($data['idgolpenilai']),
          'atasanPenilaiGolongan' =>  getGolru($data['idgolatasan']),
          'penilaiTmtGolongan' => '',
          'atasanPenilaiTmtGolongan' => '',
          'statusPenilai' => 'PNS',
          'statusAtasanPenilai' => 'PNS',
          'jenisJabatan' => $data['idjenjab'] == 3?"4":$data['idjenjab'],
          'pnsUserId' => env('PNS_USER_ID')
      );
      if($data['idjenjab'] == 1) {
          $dataSend['kepemimpinan'] =floatval($data['pim']);

      }else{
           $dataSend['kepemimpinan'] =0;
      }


        return $dataSend;
    }
    /*function simpan angka kredit*/
    public function postSaverakredit()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rakredit);
        if ($validation->passes()) {
            $arrnot = array('','_token');
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

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_akredit')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_akredit')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat sasaran kinerja pegawai*/

    /*function simpan riwayat orang tua*/
    public function postSaverortu()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rortu);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgl_lahir');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_ortu')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_ortu')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat kinerja pegawai*/

    /*function simpan riwayat istri atau suami*/
    public function postSaverissu()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rissu);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tgnikah','tglhr');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_issu')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_issu')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat istri atau suami*/

    /*function simpan riwayat anak*/
    public function postSaveranak()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$ranak);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tglhr');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_anak')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_anak')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat anak*/

    /*function simpan saudara*/
    public function postSaversaudara()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rsaudara);
        if ($validation->passes()) {
            $arrnot = array('','_token');
            $keydate = array('','tglhr');

            foreach ($_POST as $key=>$value) {
                if (array_search($key, $keydate)!='') {
                    $val = explode("-", $value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if (array_search($key, $arrnot)=="") {
                    $data[$key] = $value;
                }
            }

            $data['role_id'] = \Session::get('role_id');
            $data['role_id'] = \Session::get('role_id');

            if ($input['id'] == '') {
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_saudarakandung')->insert($data))?1:"Data Gagal Disimpan";
            } else {
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_saudarakandung')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        } else {
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat saudara*/

    /*verifikasi perubahan biodata*/
    public function postVerbiodata()
    {
        $nip = Input::get('nip');
        $text = Input::get('text');
        $keydate = array('','tglhr','tgskjbt','tmtjbt','tgskcpn','tmtcpn','tgskpns','tmtpns','tgskpkt','tmtpkt','tgskkgb','tmtkgb','tgspmtcpn','tgspmtpns','tmtspmtcpn','tmtspmtpns');

        if (in_array($text, $keydate)) {
            $data[$text] = date('Y-m-d', strtotime(Input::get('value')));
        } else {
            $data[$text] = Input::get('value');
        }

        $data['user_id'] = \Session::get('user_id');
        $data['role_id'] = \Session::get('role_id');
        $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);

        if ((\DB::table('tb_01')->where('nip', $nip)->update($data))) {
            $cek = cekperubahanbiodata($nip);
            if ($cek > 0) {
                echo 4;
            } else {
                \DB::table('tb_01_temp')->where('nip', $nip)->update(array('status'=>1));
                echo 5;
            }
        } else {
            echo "Data Gagal Disimpan";
        }
    }

    /*function verifikasi semua perubahan biodata*/
    public function postVerbiodataall()
    {
        cekAjax();
        $id = Input::get('nipasli');
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rules);

        if ($validation->passes()) {
            if (Input::get('status') == 1) {
                $arrnot = array('','_token','id','nipasli','status','ketditolak');
            } else {
                $arrnot = array('','_token','id','nipasli');
            }
            $keydate = array('','tglhr','tgskjbt','tmtjbt','tgskcpn','tmtcpn','tgskpns','tmtpns','tgskpkt','tmtpkt','tgskkgb','tmtkgb','tgspmtcpn','tgspmtpns','tmtspmtcpn','tmtspmtpns');

            foreach ($input as $key=>$value) {
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
            $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);

            if (Input::get('status') == 1) {
                if (\DB::table('tb_01')->where('nip', $id)->update($data)) {
                    \DB::table('tb_01_temp')->where('nip', $id)->update(array('status'=>1));
                    echo "4";
                } else {
                    echo "Data Gagal Disimpan";
                }
            } else {
                if (\DB::table('tb_01_temp')->where('nip', $id)->update(array('status'=>Input::get('status'), 'ketditolak'=> Input::get('ketditolak')))) {
                    echo "5";
                } else {
                    echo "Data Gagal Disimpan";
                }
            }
        } else {
            echo 'Input tidak valid';
        }
    }

    public function postPasspegawai()
    {
        cekAjax();
        $input = Input::all();
        unset($input['_token']);

        if ($input['password_baru1'] === $input['password_baru2']) {
            if (!ctype_alnum($input['password_baru1'])) {
                die('Hanya Boleh Huruf dan Angka');
            }
            $ubah = \DB::table('tb_01')->where('nip', $input['nip'])->update(array('password'=>md5($input['password_baru1'])));
            echo ($ubah)?4:0;
        } else {
            die('Konfirmasi Password Tidak Cocok');
        }
    }

    public function getPicture()
    {
        $rs = \DB::table('tb_01')->get();
        $pict = "default.jpg";
        foreach ($rs as $item) {
            if (!file_exists("./packages/upload/photo/pegawai/".$item->photo)) {
                \DB::table('tb_01')->where('nip', $item->nip)->update(array('photo'=>$pict));
            }
        }
    }

    public function getCetakpdf()
    {
        $contents = view('biodata::pdf.cetakdokumen');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    public function postPreviewdoc()
    {
        $gambar = url().'/efile/packages/upload/files/'.substr(\Input::get('nip'), 0, 4) .'/'. \Input::get('nip') . '/' . \Input::get('filename');
        return View::make('biodata::preview', compact('gambar'));
    }

    /*function untuk cek picture*/
    public function getCekpicture()
    {
        $rs = \DB::table('tb_01_temp as a')
            ->join('tb_01 as b', 'a.nip', '=', 'b.nip')
            ->select('b.nip', 'b.nama', 'b.photo')
            #->where('a.photo', '!=', 'b.photo')
            ->whereRaw("a.photo != b.photo")
            ->get();

        /*$query = "SELECT b.nip, b.nama, b.photo FROM tb_01_temp AS a
                INNER JOIN tb_01 AS b ON a.nip = b.nip
                WHERE a.photo != b.photo";

        $rs = \DB::table(\DB::raw("($query) as tb_suspeg"))->get();*/

        $x = 0;
        foreach ($rs as $item) {
            $x++;
            if (file_exists("./packages/upload/photo/pegawai/".$item->photo)) {
                echo $x." - ".$item->nip." - ".$item->nama." - ".$item->photo."<br>";
            }
        }
    }

    /*function cetak tunjangan sperorangan*/
    public function getCetakskmptk()
    {
        $contents = view('biodata::skmptk');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    /*function cetak tunjangan sperorangan*/
    public function getCetakskmptkall()
    {
        $contents = view('biodata::skmptkall');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    /*function sinkronisasi data*/
    /*function simpan riwayat jabatan pegawai bkn to simpeg*/
    public function postSyncrjabbkn()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rjabsiasn);
        if ($validation->passes()){
            $arrnot = array('','_token');
            $keydate = array('');

            $data = array(
                'nip' => $input['nip'],
                'idjenjab' => $input['idjenjab'],
                'idjab' => getJabatanIdSapk($input['idjenjab'],$input['idjab'], 1),
                'jab' => $input['namajab'],
                'skpd' => $input['unorNama'],
                'idskpd' => getUnOrId($input['unorId'], 1),
                'idesljbt' => $input['eselonId'],
                'esl' => getIdEselon($input['eselonId'],1),
                'nosk' => $input['nosk'],
                'tgsk' => tglina($input['tgsk'], 'en'),
                'tmtjab' => tglina($input['tmtjab'], 'en'),
                'idjabbkn' => $input['idjabbkn'],
                'user_id' => \Session::get('user_id'),
                'role_id' => \Session::get('role_id'),
                'created_at' => sekarang()
            );

            $rscek = \DB::table('r_jab')->where('idjabbkn', $input['idjabbkn'])->count();
            if($rscek > 0){
                echo (\DB::table('r_jab')->where('idjabbkn', $input['idjabbkn'])->update($data))?4:"Gagal Sinkron Data";
            }else{
                echo (\DB::table('r_jab')->insert($data))?1:"Gagal Sinkron Data";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat sasaran kinerja pegawai bkn to simpeg*/

    /*function simpan riwayat jabatan pegawai simpeg to bkn*/
    private function jabatanSerializeData($data)
    {

        $idjabFung ='';
        $idjabFungUm ='';
        $eselon_id = '';

        if ($data['idjenjab'] == 1) {
            $jenisJabatan = "STRUKTURAL";
             $eselon_id =  getIdEselon($data['esl']);

            // $idjab =  $data['idskpd'];
        } elseif ($data['idjenjab'] == 2) {
            $jenisJabatan = "FUNGSIONAL_TERTENTU";
            $idjab =  $data['idjab'];
            $idjabFung =  getJabatanIdSapk($data['idjenjab'],  $data['idjab']);
             $eselon_id = 0;
        } elseif($data['idjenjab'] == 3) {
            $jenisJabatan = "FUNGSIONAL_UMUM";
            $idjabFungUm =  getJabatanIdSapk($data['idjenjab'],  $data['idjab']);
            $eselon_id = 0;
        }else{
              $jenisJabatan = "STRUKTURAL";
              $eselon_id =  getIdEselon($data['esl']);

        }

       $tglsk = explode("-",$data['tgsk']);
       $tmtjab = explode("-", $data['tmtjab']);
        $unorid =  getUnOrId($data['idskpd']);
        $dataSend  = [
            'id' => null,
            'jenisJabatan' => $jenisJabatan,
            'unorId' => $unorid,
            'eselonId' => isset($data['esl'])?$eselon_id:0,
            'instansiId' => 'A5EB03E23C52F6A0E040640A040252AD',
            'pnsId' => getPnsIdSapk($data['nip']),
            'jabatanFungsionalId' => $idjabFung,
            'jabatanFungsionalUmumId' =>  $idjabFungUm,
            'nomorSk' => $data['nosk'],
            'tanggalSk' => "$tglsk[2]-$tglsk[1]-$tglsk[0]",
            'tmtJabatan' =>"$tmtjab[2]-$tmtjab[1]-$tmtjab[0]",
            'tmtPelantikan' => "$tmtjab[2]-$tmtjab[1]-$tmtjab[0]",
            'pnsUserId' =>  env('PNS_USER_ID'),
        ];

        return $dataSend;
    }
    public function postSyncrjabsimpeg(JabatanService $srv)
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->jabatanSerializeData($input);

        $send = $srv->store($dataSend);

        if ($send['message'] == "success") {
            $update =  \DB::table('r_jab')->where('id', $input['id'])
            ->update(['idjabbkn'=>  $send['mapData']['rwJabatanId']]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data';
        }
    }
    /*end of riwayat sasaran kinerja pegawai simpeg to bkn*/
    /*end of function sinkronisasi data*/

    public function postSyncdatadiri()
    {
        $input = \Input::all();
        unset($input['_token']);
        $dataInsert = [];
        foreach ($input as $key => $value) {
            if ($input[$key] !='') {
                $dataInsert[$key] = $input[$key];
            }
        }
        $dataInsert['idjenkel'] = getTextJenkelBkn($dataInsert['idjenkel']);
        $dataInsert['idstskawin'] = getTextStatusKawinBkn($dataInsert['status_maritial']);
        unset($dataInsert['status_maritial']);
        unset($dataInsert['nip']);
        $update = \DB::table('tb_01')->where('nip', $input['nip'])->update($dataInsert);
        echo  ($update) ? '4':'Tidak ada perubahan data';
    }

    /*function sinkron data simpeg x siasn*/
    public function postSyncdatadirisiasn()
    {
        $input = \Input::all();
        unset($input['_token']);
        $dataInsert = [];
        foreach ($input as $key => $value) {
            if ($input[$key] !='') {
                $dataInsert[$key] = $input[$key];
            }
        }

        $dataInsert['pns_orang_id'] = getPnsIdSapk($input['nip']);
        unset($dataInsert['nip']);

        $send = accessDatapostsiasn('pns/data-utama-update', $dataInsert);
        if (isset($send->message)  && $send->code == "1") {
            echo 4;
        } else {
            echo "Gagal sinkron data ke SIASN.{$send->message}";
        }
    }

    public function postSyncskp(SkpService $srv)
    {
        $input = \Input::all();

        unset($input["_token"]);
        $dataSend = $this->skpSerializeData($input);

       	$save = $srv->store($dataSend);
           if($save['message'] ==true){
            $input['idskpbkn'] = $save['mapData']['rwSkpId'];
            $update = \DB::table('r_skp')->where('id', $input['id'])->update($input);
            echo 1;
        }else{
	            echo 'terjadi kesalahan';
        }

    }

    /*function untuk mendapatkan detail atasan*/
    function postAtasan(){
        cekAjax();
        $nip = Input::get('nip');
        $rs = \DB::table('tb_01 as a')
            ->select(
            'a.nip', 'a.nama', 'a.idjenjab', 'a.idjenkedudupeg', 'a.idskpd', 'b.idparent', 'b.path as skpd', 'a.idgolrupkt as idgolru',
            \DB::raw("CONCAT(f.pangkat,' (', f.golru,')') as golru"),
            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',' '),a.gdb) AS namalengkap"),
            \DB::raw("IF(a.idjenjab>4,a.idjabjbt,IF(a.idjenjab=2,d.idjabfung,IF(a.idjenjab=3,e.idjabfungum,'-'))) AS idjab"),
            \DB::raw("IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,d.jabfung,IF(a.idjenjab=3,e.jabfungum,'-'))) AS jab")
        )
            ->join('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftJoin('a_jabfung as d', 'a.idjabfung', '=', 'd.idjabfung')
            ->leftJoin('a_jabfungum as e', 'a.idjabfungum', '=', 'e.idjabfungum')
            ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=', 'f.idgolru')
            ->where('a.nip', $nip)
            ->first();

        if(count($rs) > 0){
            echo json_encode($rs);
        }else{
            $rs = array(
                'nip' => '',
                'nama' => '',
                'idjenjab' => '',
                'idjenkedudupeg' => '',
                'idskpd' => '',
                'idparent' => '',
                'skpd' => '',
                'idgolru' => '',
                'golru' => '',
                'namalengkap' => '',
                'idjab' => '',
                'jab' => ''
            );
            echo json_encode($rs);
        }
    }

    /*star simpeg pppk 07-12-2021*/
    /*function simpan riwayat pppk*/
    public function postSaverpppk(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpppk);
        if ($validation->passes()){
            $arrnot = array('','_token','idjnsaksi');
            if(!empty($input['tmtkepsek'])){
                $keydate = array('','tgsk','tmtawal','tmtakhir','tmtkepsek','tglsk_calon','tglsk_pppk');
            }else{
                $keydate = array('','tgsk','tmtesljbt','tmtawal','tmtakhir','tglsk_calon','tglsk_pppk');
            }
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
            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            if($input['id'] == ''){
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pppk')->insert($data))?1:"Data Gagal Disimpan";
            }else{
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pppk')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
    public function postSaverpppktemp(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, BiodataModel::$rpppk);
        if ($validation->passes()){
            $arrnot = array('','_token','tb');
            if(!empty($input['tmtkepsek'])){
                $keydate = array('','tgsk','tmtawal','tmtakhir','tmtkepsek','tglsk_calon','tglsk_pppk');
            }else{
                $keydate = array('','tgsk','tmtesljbt','tmtawal','tmtakhir','tglsk_calon','tglsk_pppk');
            }
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
            $data['user_id'] = \Session::get('user_id');
            $data['role_id'] = \Session::get('role_id');
            if(($input['tb'] == 'r_pppk') or ($input['tb'] == '') or ($input['tb'] == 'tb_01')){
                $rs = \DB::table('r_pppk_temp')->where('id_rpppk','>',0)->where('id_rpppk', $input['id_rpppk'])->get();
            }else{
                $rs = \DB::table('r_pppk_temp')->where('id', $input['id'])->get();
            }
            if(count($rs) > 0){
                $data['updated_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                if($input['tb'] == 'r_pppk'){
                    echo (\DB::table('r_pppk_temp')->where('id_rpppk','>',0)->where('id_rpppk', $input['id_rpppk'])->update($data))?4:"Data Gagal Disimpan";
                }else{
                    echo (\DB::table('r_pppk_temp')->where('id', $input['id'])->update($data))?4:"Data Gagal Disimpan";
                }
            }else{
                $data['created_at'] = gmdate("Y-m-d H:i", time()+60*60*7);
                echo (\DB::table('r_pppk_temp')->insert($data))?1:"Data Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
    /*end of riwayat pppk*/

    /*function untuk mendapatkan gaji pppk*/
    public function postGajipppk(){
        cekAjax();
        $golongan = Input::get('idgolru');
        //   dd($golongan);
        $thmasker = Input::get('mkthn');
        $ret['gaji'] = '';
        if(strlen($thmasker) < 2){
            $thmasker = '0'.$thmasker;
        }else if(strlen($thmasker) == 0){
            $thmasker = '00';
        }
        $cek = \DB::table('a_gaji_pppk')->select(\DB::raw('max(MSK) as mskmax'))->where('pkt',$golongan)->where('status', 1)->first();
        //   dd($cek);
        if(count($cek) > 0){
            if($thmasker > $cek->mskmax){
                $masaker = $cek->mskmax;
            }else{
                $masaker = $thmasker;
            }
            $rsgaji = \DB::table('a_gaji_pppk')->select('gaji')->where('pkt',$golongan)->where('status', 1)->where('msk', $masaker)->first();
            if(count($rsgaji) > 0){
                $ret['gaji'] = $rsgaji->gaji;
            }
        }
        echo json_encode($ret);
    }

    /*function untuk menampilkan inputan jabatan pada modal*/
    function postJenisjabatanpppk(){
        cekAjax();
        $nip = Input::get('nip');
        $data['idjenjab'] = Input::get('idjenjab');
        $data['idskpd'] = Input::get('idskpd');
        if(Input::get('tb') == 'r_jab'){
            $data['rs'] = \DB::table('r_jab as a')
                ->select(
                'a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }else if(Input::get('tb') == 'r_jab_temp'){
            $data['rs'] = \DB::table('r_jab_temp as a')
                ->select(
                'a.id_rjab','a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }else if(Input::get('tb') == 'r_pppk'){
            $data['rs'] = \DB::table('r_pppk as a')
                ->select(
                'a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesl', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesl', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }else if(Input::get('tb') == 'r_pppk_temp'){
            $data['rs'] = \DB::table('r_pppk_temp as a')
                ->select(
                'a.id_rpppk','a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesl', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesl', '=', 'i.idesl')
                ->where('a.id', '=', Input::get('id'))
                ->where('a.nip', '=', $nip)
                ->first();
        }else if(Input::get('tb') == 'tb_01'){
            $data['rs'] = \DB::table('tb_01 as a')
                ->select(
                'a.idjabjbt', 'a.idjabfung', 'a.idjabfungum', 'a.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','b.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
            //->where('a.nip', '=', 'null') //$nip
                ->where('a.nip', '=', $nip)
                ->first();
        }else{
            $data['rs'] = \DB::table('tb_01 as a')
                ->select(
                'a.idjabjbt', 'a.idjabfung', 'a.idjabfungum', 'a.idjabnonjob', 'a.idesljbt', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd','a.stsesl','a.tmtesljbt',
                'c.isguru','b.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                \DB::raw('j.skpd as kepseksekolah')
            )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjabnonjob', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesljbt', '=', 'i.idesl')
                ->where('a.nip', '=', 'null') //$nip
            //->where('a.nip', '=', $nip)
                ->first();
        }
        return View::make('biodata::jabatanpppk', $data);
    }
    /*end of simpeg pppk*/

    /*function untuk menampilkan inputan menampilkan status direktur / kepala*/


    /*function sinkron sinkronisasi siasn*/
    /*function simpan riwayat jabatan pegawai simpeg to siasn*/
    public function postSyncrjabsimpegsiasn()
    {
        cekAjax();
        $input = Input::all();
        $dataSend = $this->jabatanSerializeDatasiasn($input);
   // $send = accessDatapostsiasn('jabatan/save', $dataSend);
        $send = accessDatapostsiasn('jabatan/unorjabatan/save', $dataSend);
        if ($send->message == "success") {
            $this->saveRjabmodal($input);
            $update =  \DB::table('r_jab')->where('id', $input['id'])
                ->update(['idjabbkn'=>  $send->{'mapData'}->rwJabatanId]);
            echo '4';
        } else {
            echo 'Gagal Sinkron Data, '.$send->message;
        }
    }

    /*function simpan riwayat jabatan pegawai simpeg to siasn*/
    private function jabatanSerializeDatasiasn($data)
    {
        $idjabFung ='';
        $idjabFungUm ='';
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
        } elseif($data['idjenjab'] == 3) {
            $jenisJabatan = "4";
            $idjabFungUm =  getJabatanIdSapk($data['idjenjab'],  $data['idjab']);
            $eselon_id = 0;
        }else{
            $jenisJabatan = "1";
            $eselon_id =  getIdEselon($data['esl']);

        }

        $tglsk = explode("-",$data['tgsk']);
        $tmtjab = explode("-", $data['tmtjab']);
        $instansiid =  getUnOrId(substr($data['idskpd'],0,2));
        $unorid =  getUnOrId($data['idskpd']);
    //update 10072025
       $jenjabsiasn = \DB::table('a_jenjab')->where('idjenjab', '=', $data['idjenjab'])->first()->idsiasn;
        if (!empty($data['idtugasdokter'])) {
            $subJabatanId = \DB::table('a_tugasdokter')->where('idtugasdokter', '=', $data['idtugasdokter'])->first()->idsiasn;
        } elseif (!empty($data['idtugasgurudosen'])) {
            $subJabatanId = \DB::table('a_matkulpel')->where('idtugasgurudosen', '=', $data['idtugasgurudosen'])->first()->idsiasn;
        } else {
            $subJabatanId = '';
        }
    
    if (!empty($data['idjabbkn'])) {
            $jabbkn = $data['idjabbkn'];
        } else {
            $jabbkn = '';
        }

        // $dataSend  = [
        //     'eselonId' => (@$data['esl'] != '') ? $eselon_id : '',
        //     'id' => '',
        //     'instansiId' => ENV('INSTANSI_ID'),
        //     'jabatanFungsionalId' => $idjabFung,
        //     'jabatanFungsionalUmumId' => $idjabFungUm,
        //     'jenisJabatan' => $jenisJabatan,
        //     'nomorSk' => $data['nosk'],

        //     'pnsId' => getPnsIdSapk($data['nip']),
        //     'satuanKerjaId' => 'A5EB03E241F1F6A0E040640A040252AD', #ENV('INSTANSI_ID'), #$instansiid,
        //     'tanggalSk' => date('d-m-Y', strtotime($data['tgsk'])),
        //     'tmtJabatan' => date('d-m-Y', strtotime($data['tmtjab'])),
        //     'tmtPelantikan' => date('d-m-Y', strtotime($data['tmtjab'])),
        //     'unorId' => $unorid
        // ];

        // post riwayat jabatan 09072025
        $dataSend  = [
            'eselonId' => (@$data['esl'] != '') ? $eselon_id : '',
                'id' => $jabbkn,
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
    }

    function saveRjabmodal($input){
        $arrnot = array('','_token','idjnsaksi');
        if (!empty($input['tmtkepsek'])) {
            $keydate = array('','tgsk','tmtjab','tmtkepsek');
        } else {
            $keydate = array('','tgsk','tmtjab');
        }

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

        \DB::table('r_jab')->where('id', $input['id'])->update($data);
    }
    /*end of function sinkron sinkronisasi siasn*/

// del n sinkron siasn
    public function postDelsinkronriwayat()
    {
        cekAjax();
        $id = Input::get("id");
        $tb = Input::get("tb");
        $rs = \DB::table($tb)->where('id', $id)->first();
         $idRiwayatAngkaKredit = $rs->idsapk;
        $send = accessDatadeletesiasn('angkakredit/delete', $idRiwayatAngkaKredit);
        if ($send->message == "success") {
            echo (\DB::table($tb)->where('id', $id)->delete()) ? 9 : 'Data Gagal Dihapus.';
        } else {
            echo 'Gagal Sinkron Data, ' . $send->message;
        }
    }
}
