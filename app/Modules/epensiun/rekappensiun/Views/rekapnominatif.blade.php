<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Tanda Terima Pensiun</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style media="all" type="text/css">
        @media print {
            @page {
                size: F4 landscape;
                margin-left: 1.5cm;
                margin-right: 1cm;
                margin-top: 1cm;
                margin-bottom: 1cm;
            }
            .page-break { display:block; page-break-before:always; }
        }

        html {
            font-family: 'Arial';
            font-size: 10pt;
            background: white;
            line-height:1.5em;
            padding: 0;
            margin: 0;
        }

        #F4-landscape{
            position: relative;
            width: 300mm;
            margin: auto;
        }
        table {
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            line-height:1.25em;
        }
        .table thead{
            background-color: #ccc !important;
        }
        .table thead > tr > th,
        .table tbody > tr > td{
            border: 1px solid black;
            padding: .4em;
        }

        div.print{
            background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
            width:110px;
            height:110px;
            top:20;
            right:50;
            position:fixed;
            opacity:0.1;
            cursor:pointer;
            right: 5px;
        }

        div.print:hover{
            opacity:1;
        }

        .subtitle tr{
            border: 1px solid black;
            height: 25px;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php       
        $idskpd = Input::get('idskpd');
        $tanggal1 = Input::get('tanggal1');
        $tanggal2 = Input::get('tanggal2');

        $where = "a.nip != ''";        
        $where.= ((Input::get('tanggal1') != '') and Input::get('tanggal2') != '')?" and a.tmtpens >= \"".tglFormat(Input::get('tanggal1'))."\" and a.tmtpens <= \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= ((Input::get('tanggal1') != '') and Input::get('tanggal2') == '')?" and a.tmtpens = \"".tglFormat(Input::get('tanggal1'))."\"":"";
        $where.= ((Input::get('tanggal1') == '') and Input::get('tanggal2') != '')?" and a.tmtpens = \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= (Input::get('idskpd') != '')?" and f.idskpd like '$idskpd%'":"";
    
        $rs = \DB::table('tr_pensiun as a')
        ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
        ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
        ->whereRaw($where)->get();
        // dd($rs); 

        $rsdata4 = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a.noskpens"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("DATE_FORMAT(a.tgskpens,'%d-%m-%Y') AS tgskpens_"),
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where.' and left(f.idgolrupkt,1) = 4')
            ->get();
            // dd($rsdata4);

    $rsdata3 = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a.noskpens"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("DATE_FORMAT(a.tgskpens,'%d-%m-%Y') AS tgskpens_"),               
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where.' and left(f.idgolrupkt,1) = 3')
            ->get();
            // dd($rsdata3);

    $rsdata2 = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a.noskpens"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"), 
                \DB::raw("DATE_FORMAT(a.tgskpens,'%d-%m-%Y') AS tgskpens_"),               
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where.' and left(f.idgolrupkt,1) = 2')
            ->get();
            // dd($rsdata2);

    $rsdata1 = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a.noskpens"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"), 
                \DB::raw("DATE_FORMAT(a.tgskpens,'%d-%m-%Y') AS tgskpens_"),               
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where.' and left(f.idgolrupkt,1) = 1')
            ->get();
            // dd($rsdata1);

        if(!count($rs)){
            echo "Data Pensiun tidak ditemukan.";
            exit();
        }
    ?>

    <div class="page-lanscape" id="F4-landscape">
        <table width="100%">
            <tr>
                <td width="10%"><img src="{!!asset('/packages/tugumuda/img/logo.png')!!}"></td>
                <td width="80%">
                    <h2 align="center">DAFTAR PERMOHONAN PROSES PENSIUN</h2>
                </td>
                <td width="10%">&nbsp;</td>
            </tr>
        </table>

        <table class="subtitle" width="100%">
            <tr>
                <td width="10%">Unit Kerja</td>
                <td width="1%"> : </td>
                <td width="89%">
                    <?php
                        if(Input::get('idskpd') != ''){
                            echo getSkpd(Input::get('idskpd'));
                        }else{
                            echo "-";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="10%">Tanggal Cetak</td>
                <td width="1%"> : </td>
                <td width="89%">
                    <?php
                        if(($tanggal1 != '') and ($tanggal2 != '')){
                            echo $tanggal1." sd ".$tanggal2;
                        }

                        if(($tanggal1 != '') and ($tanggal2 == '')){
                            echo $tanggal1;
                        }

                        if(($tanggal2 == '') and ($tanggal2 != '')){
                            echo $tanggal2;
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="10%">Jumlah Data</td>
                <td width="1%"> : </td>
                <td width="89%">{!!count($rs)!!}</td>
            </tr>
        </table><br>

        @if(count($rsdata4) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan IV : {!!count($rsdata4)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th align="center" width="2%">NO</th>
                    <th align="center" width="15%">NAMA / NIP</th>
                    <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                    <th align="center" width="8%">TTD</th>
                    <th align="center" width="5%">TMT</th>
                    <th align="center" width="5%">NO SK</th>
                    <th align="center" width="5%">TGL SK</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 0;
                foreach ($rsdata4 as $item) {
                    $i = $i+1;
            ?>
            <tr>
                <td rowspan="2"><div align="center"><?php echo $i?>.</div></td>
                <td><?php echo $item->nama?></td>
                <td><?php echo ucword($item->jabatan)?></td>
                <td rowspan="2">&nbsp;</td>
                <td rowspan="2"><div align="center"><?php echo $item->tmtpens_?></div></td>
                <td rowspan="2"><div align="center"><?php echo substr($item->noskpens,6,4)?></div></td>
                <td rowspan="2"><div align="center"><?php echo $item->tgskpens_?></div></td>
            </tr>
            <tr>
                <td><?php echo fnip($item->nip)?></td>
                <td><?php echo getSkpd($item->idskpd)?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata3) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan III : {!!count($rsdata3)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
            <tr>
                <th align="center" width="2%">NO</th>
                <th align="center" width="15%">NAMA / NIP</th>
                <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                <th align="center" width="8%">TTD</th>
                <th align="center" width="5%">TMT</th>
                <th align="center" width="5%">NO SK</th>
                <th align="center" width="5%">TGL SK</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($rsdata3 as $item) {
                $i = $i+1;
                ?>
            <tr>
                <td rowspan="2"><div align="center"><?php echo $i?>.</div></td>
                <td><?php echo $item->nama?></td>
                <td><?php echo ucword($item->jabatan)?></td>
                <td rowspan="2">&nbsp;</td>
                <td rowspan="2"><div align="center"><?php echo $item->tmtpens_?></div></td>
                <td rowspan="2"><div align="center"><?php echo substr($item->noskpens,6,4)?></div></td>
                <td rowspan="2"><div align="center"><?php echo $item->tgskpens_?></div></td>
            </tr>
            <tr>
                <td><?php echo fnip($item->nip)?></td>
                <td><?php echo ucword(getSkpd($item->idskpd))?></td>
            </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata2) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan II : {!!count($rsdata2)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
            <tr>
                <th align="center" width="2%">NO</th>
                <th align="center" width="15%">NAMA / NIP</th>
                <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                <th align="center" width="8%">TTD</th>
                <th align="center" width="5%">TMT</th>
                <th align="center" width="5%">NO SK</th>
                <th align="center" width="5%">TGL SK</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($rsdata2 as $item) {
                $i = $i+1;
                ?>
            <tr>
                <td rowspan="2"><div align="center"><?php echo $i?>.</div></td>
                <td><?php echo $item->nama?></td>
                <td><?php echo ucword($item->jabatan)?></td>
                <td rowspan="2">&nbsp;</td>
                <td rowspan="2"><div align="center"><?php echo $item->tmtpens_?></div></td>
                <td rowspan="2"><div align="center"><?php echo substr($item->noskpens,6,4)?></div></td>
                <td rowspan="2"><div align="center"><?php echo $item->tgskpens_?></div></td>
            </tr>
            <tr>
                <td><?php echo fnip($item->nip)?></td>
                <td><?php echo ucword(getSkpd($item->idskpd))?></td>
            </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata1) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan I : {!!count($rsdata1)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
            <tr>
                <th align="center" width="2%">NO</th>
                <th align="center" width="15%">NAMA / NIP</th>
                <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                <th align="center" width="8%">TTD</th>
                <th align="center" width="5%">TMT</th>
                <th align="center" width="5%">NO SK</th>
                <th align="center" width="5%">TGL SK</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($rsdata1 as $item) {
                $i = $i+1;
                ?>
            <tr>
                <td rowspan="2"><div align="center"><?php echo $i?>.</div></td>
                <td><?php echo $item->nama?></td>
                <td><?php echo ucword($item->jabatan)?></td>
                <td rowspan="2">&nbsp;</td>
                <td rowspan="2"><div align="center"><?php echo $item->tmtpens_?></div></td>
                <td rowspan="2"><div align="center"><?php echo substr($item->noskpens,6,4)?></div></td>
                <td rowspan="2"><div align="center"><?php echo $item->tgskpens_?></div></td>
            </tr>
            <tr>
                <td><?php echo fnip($item->nip)?></td>
                <td><?php echo ucword(getSkpd($item->idskpd))?></td>
            </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif
    </div>

</body>
</html>

    <script>
        $(document).ready(function(){
            //alert(window.orientation);
            $('div.print').click(function(){
                $(this).hide();
                window.print();
                /*
                    setTimeout(function() {
                        window.close();
                    }, 1);
                   */
            });

            $('img').each(function(index,item){
                $(item).error(function(){

                    $(item).attr('src','no_image.jpg');
                });
            });


            $(document).on('mouseover',function(){
                $('div.print').show();
            });

        });

    </script>