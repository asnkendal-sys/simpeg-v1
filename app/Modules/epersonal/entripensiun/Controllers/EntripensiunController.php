<?php namespace App\Modules\epersonal\entripensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\entripensiun\Models\EntripensiunModel;
use Input,View, Request, Form, File;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

/**
* Entripensiun Controller
* @var Entripensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class EntripensiunController extends Controller {
    protected $entripensiun;

    public function __construct(EntripensiunModel $entripensiun){
        $this->entripensiun = $entripensiun;
    }

        public function getIndex(){
            cekAjax();

            $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
            if (Input::has('search') or Input::has('idskpd') or Input::has('idjenjab') or Input::has('tahun') or Input::has('bulan1') or Input::has('bulan2')) {
                $having = '';

                /* Kondisi jabatan jabatan*/
                if(Input::get('idjenjab') != ''){
                    $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."'";
                }

                /* Kondisi Tahun */
                if(Input::get('tahun') != ''){
                    $having .= (($having != '')?' AND ':'')." YEAR(pensiunnext)= ".Input::get('tahun')."";
                }

                /* Kondisi Bulan */
                if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
                    $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
                }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
                    $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext)= ".Input::get('bulan1')."";
                }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
                    $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext)= ".Input::get('bulan2')."";
                }

                /* Kondisi skpd atau unit kerja */
                if(Input::get('idskpd') != ''){
                    $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
                }

                /* Kondisi search */
                if(Input::get('search') != ''){
                    $where.= "and (tb_01.nama like '%".Input::get('search')."%' or tb_01.nip like '%".Input::get('search')."%')";
                }

                if($having != ''){
                    $entripensiuns = \DB::table('tb_01')
                        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                        ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                        ->whereRaw($where)
                        ->havingRaw($having)
                        ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
                }else{
                    $entripensiuns = \DB::table('tb_01')
                        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF((tb_01.idjenjab=3) OR (tb_01.idesljbt >=31 and tb_01.idesljbt <= 52) /*OR (tb_01.idjenjab=2 AND tb_01.idgolrupkt <= 34)*/,58,60) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                        ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                        ->whereRaw($where)
                        ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
                }

                /*$page           = (Input::has('page'))?Input::get('page'):1;*/
                //$entripensiuns= $entripensiuns->skip($page - 1)->take(25)->get();
                $entripensiuns  = $entripensiuns->get();
                $perPage        = $_ENV['configurations']['list-limit'];
                //this is my array
                $pageStart      = (Input::has('page'))?Input::get('page'):1;
                $offset         = ($pageStart * $perPage) - $perPage;

                if(count($entripensiuns)> 0){
                    $data = new Paginator (
                            array_slice($entripensiuns, $offset,  $perPage, true),
                            count($entripensiuns),$perPage,Paginator::resolveCurrentPage(),
                            array('path' =>  Paginator::resolveCurrentPath())
                    );
                    $entripensiuns = $data;
                }
        }else{
            $entripensiuns = $this->entripensiun->all();
        }
        return View::make('entripensiun::index', compact('entripensiuns'));
    }

    public function getDatapensiun(){
        cekAjax();

        $where = " tb_01.idjenkedudupeg in('99','21') and tb_01.nip != '' ";
        if (Input::has('search') or Input::has('idskpd') or Input::has('tahun') or Input::has('bulan1') or Input::has('bulan2')) {
            $having = '';

            /* Kondisi jabatan jabatan*/
            if(Input::get('idjenjab') != ''){
                $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."'";
            }

            /* Kondisi Tahun */
            if(Input::get('tahun') != ''){
                $having .= (($having != '')?' AND ':'')." YEAR(tmtpens)= ".Input::get('tahun')."";
            }

            /* Kondisi Bulan */
            if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
            }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens)= ".Input::get('bulan1')."";
            }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens)= ".Input::get('bulan2')."";
            }

            /* Kondisi skpd atau unit kerja */
            if(Input::get('idskpd') != ''){
                $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
            }

            /* Kondisi jenis pensiun */
            if(Input::get('idjenpens') != ''){
                $where.= "and tb_01.idjenpens = '".Input::get('idjenpens')."'";
            }

            /* Kondisi search */
            if(Input::get('search') != ''){
                $where.= "and (tb_01.nama like '%".Input::get('search')."%' or tb_01.nip like '%".Input::get('search')."%')";
            }

            if($having != ''){
                $entripensiuns = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF((tb_01.idjenjab=3) OR (tb_01.idesljbt >=31 and tb_01.idesljbt <= 52) /*OR (tb_01.idjenjab=2 AND tb_01.idgolrupkt <= 34)*/,58,60) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                    ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                    ->whereRaw($where)
                    ->havingRaw($having)
                    ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
            }else{
                $entripensiuns = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                    ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
            }

            /*$page           = (Input::has('page'))?Input::get('page'):1;*/
            //$entripensiuns= $entripensiuns->skip($page - 1)->take(25)->get();
            $entripensiuns  = $entripensiuns->get();
            $perPage        = $_ENV['configurations']['list-limit'];
            //this is my array
            $pageStart      = (Input::has('page'))?Input::get('page'):1;
            $offset         = ($pageStart * $perPage) - $perPage;

            if(count($entripensiuns)> 0){
                $data = new Paginator (
                    array_slice($entripensiuns, $offset,  $perPage, true),
                    count($entripensiuns),$perPage,Paginator::resolveCurrentPage(),
                    array('path' =>  Paginator::resolveCurrentPath())
                );
                $entripensiuns = $data;
            }
        }else{
            $entripensiuns = $this->entripensiun->data_pensiun();
        }
        return View::make('entripensiun::index_pensiun', compact('entripensiuns'));
    }

    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $entripensiun = $this->entripensiun->find($id);
        //if (is_null($entripensiun)){return \Redirect::to('epersonal/entripensiun/index');}
        return View::make('entripensiun::edit', compact('entripensiun'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, EntripensiunModel::$rules);
        
        if ($validation->passes()){
            $entripensiun = $this->entripensiun->find($id);
            echo ($entripensiun->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


    /*function print atribut dari link */
    public function postData(){
        $view = Request::segment(4);
        return View::make('entripensiun::'.$view.'_data');
    }

    /*function penetapan pensiun */
    public function postPensiun(){
        cekAjax();
        $input = Input::all();
        $id = Input::get('nip');
        $validation = \Validator::make($input, EntripensiunModel::$rules);

        if ($validation->passes()){
            $arrnot = array('','_token','id');
            $keydate = array('','tmtpens','tglskpens');

            foreach($input as $key=>$value){
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

            $data['idjenkedudupeg'] = Input::get('idjenkedudupeg');
            $entripensiun = $this->entripensiun->find($id);
         // candra edit 
            // jika tanggal tmtpens kurang dari hari ini maka pegawai masih aktif
            // nantinya akan di pensiunkan dari dashboard atau cronjob sembarang
            $date_now = time();
            $datetmtpens   = strtotime($data['tmtpens']);

            if (Input::get('idjenkedudupeg') == '99' && $date_now < $datetmtpens) {
                $data['idjenkedudupeg'] = '1';
            }
            // candra end

            echo ($entripensiun->update($data))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }
public function postPensiunkan()
    {
        cekAjax();
echo "Akses Ditutup Sementara";
         // $having8 = " YEAR(pensiunnext)= " .  date("Y") . "";
        // $having8 .= " AND MONTH(pensiunnext)= " . date("m") . "";
        // $rs8 = \DB::table('tb_01')
        //     ->select(
        //         'nip',
        //         \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext")
        //     )
        //     ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        //     ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        //     ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        //     ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        //     ->whereRaw("tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != ''")
        //     ->havingRaw($having8)
        //     ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
        //     ->get();
        // // $tanggalpensiun = date("Y-m-d");
        // // print_r($rs8);
        // $ok = 0;
        // $failed = 0;
        // foreach ($rs8 as $id) {

        //     $data = array(
        //         'idjenkedudupeg' => '99',
        //     );
        //     if (\DB::table('tb_01')->where('nip', $id['nip'])->update($data)) {
        //         // if (\DB::table('tb_01')->whereRaw("tb_01.idjenkedudupeg ='1' and tb_01.tmtpens = '" . $tanggalpensiun . "'")->update(array('idjenkedudupeg' => '99'))) {
        //         $ok++;
        //     } else {
        //         $failed++;
        //     }
        //     echo "Data Berhasil $ok Gagal $failed";
        // }
    }
    /*function batalkan pensiun*/
    public function postBtlpensiun(){
        cekAjax();
        $nip = Input::get('id');

        $data = array(
            'tmtpens' => '',
            'idjenkedudupeg' => '1',
            'idjenpens' => '',
            'noskpens' => '',
            'tglskpens' => '',
            'jbtpenetapens' => '',
        );

        if(\DB::table('tb_01')->where('nip', $nip)->update($data)){
            echo "9";
        }else{
            echo "Pensiun Gagal Dibatalkan";
        }
    }

    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->entripensiun->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->entripensiun->find($ids)->delete())?9:0;
        }
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('entripensiun::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('entripensiun::'.$view.'_excel');
        // echo $view;
    }

}
