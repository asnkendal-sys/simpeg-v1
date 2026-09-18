<?php namespace App\Modules\webservices\apibkn\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\apibkn\Models\ApibknModel;
use App\Modules\epersonal\biodata\Models\BiodataModel;
use Input;
use View;
use Request;
use Form;
use File;
use App\Services\DataUtamaBknService;

class ApibknController extends Controller
{

    /**
     * Apibkn Repository
     *
     * @var Apibkn
     */
    protected $srv;
    protected $biodata;
    public function __construct(BiodataModel $biodata, DataUtamaBknService $srv)
    {
        $this->biodata = $biodata;
        $this->srv = $srv;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
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
                                    'a_golruang.golru',
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
                                    'a_golruang.golru',
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

        return View::make('apibkn::index', compact('biodatas'));
    }

    public function postBiodata(){
      dd(\Input::all());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        return View::make('apibkn::create');
    }

    public function getEdit($id = false)
    {
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $biodata = $this->biodata->find($id);

        $bkn = $this->srv->fetchDataUtama($biodata->nip)["data"];
        return View::make('apibkn::edit', compact('biodata', 'bkn'));
    }

// candra
public function postTelloopd()
    {
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
                try {
                    DB::table('tr_ipasn')->delete()->where('nip', $pegawai->nip);
                    // DB::table('tr_ipasn')->update([
                    //     // 'nip' => $pegawai->nip,
                    //     'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                    //     'kinerja' => $bkn->kinerja,
                    //     'hukdis' => $bkn->disiplin,
                    //     'kompetensi' => $bkn->kompetensi,
                    //     'kualifikasi' => $bkn->kualifikasi,
                    //     'subtotal' => $bkn->subtotal,
                    // ])->where('nip', $pegawai->nip);
                    // echo '1';

                    DB::table('tr_ipasn')->insert([
                        'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                try {
                    DB::table('tr_ipasn')->insert([
                        'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
                    ]);
                    // echo '1';
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            echo 'done';
            // }
        }
    }
    public function getTello()
    {

        if (session('role_id') <= 3) {
            $idskpd = '25';
        } else {
            $idskpd = session('idskpd');
        }
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
            ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->where('idstspeg', '=', 2)
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
                try {
                    DB::table('tr_ipasn')->update([
                        // 'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
                    ])->where('nip', $pegawai->nip);
                    echo '1';
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                try {
                    DB::table('tr_ipasn')->insert([
                        'nip' => $pegawai->nip,
                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                        'kinerja' => $bkn->kinerja,
                        'hukdis' => $bkn->disiplin,
                        'kompetensi' => $bkn->kompetensi,
                        'kualifikasi' => $bkn->kualifikasi,
                        'subtotal' => $bkn->subtotal,
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
public function postIpasnpersonal()
    {
        $input = Input::all();
        $nip = $input['id'];
        $bkn = accessDatariwayatsiasn('pns/nilaiipasn', $nip);
            $rscek = \DB::table('tr_ipasn')->where('nip', $nip)
                    ->count();

        if ($rscek > 0) {
            try {
                DB::table('tr_ipasn')->update([
                                        'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                    'kinerja' => $bkn->kinerja,
                    'hukdis' => $bkn->disiplin,
                    'kompetensi' => $bkn->kompetensi,
                    'kualifikasi' => $bkn->kualifikasi,
                    'subtotal' => $bkn->subtotal,
                ])->where('nip', $nip);
                echo '1';
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            try {
                DB::table('tr_ipasn')->insert([
                    'nip' => $nip,
                    'tgipasn' => date('Y-m-d', strtotime($bkn->created_at)),
                    'kinerja' => $bkn->kinerja,
                    'hukdis' => $bkn->disiplin,
                    'kompetensi' => $bkn->kompetensi,
                    'kualifikasi' => $bkn->kualifikasi,
                    'subtotal' => $bkn->subtotal,
                ]);
                echo '1';
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo 'tidak ada';
        }
    }
// end candra
}
