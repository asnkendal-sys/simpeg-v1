@if(Request::segment(3) == 'print')
<html>

<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Profil ASN</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: A4 potrait;
                margin-left: 0.4in;
                margin-right: 0.4in;
                margin-top: 0.4in;
                margin-bottom: 0.4in;
            }

            /*p.breakhere { page-break-after: always; }*/
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        div.print {
            background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
            width: 110px;
            height: 110px;
            top: 20;
            right: 50;
            position: fixed;
            opacity: 0.1;
            cursor: pointer;
        }

        div.print:hover {
            opacity: 1;
        }

        hr {
            border: 1px dotted #000000;
            border-bottom: none;
            border-right: none;
            border-left: none;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>

<body>
    <div class="print"></div>
    <div class="page">
        @else
        <style>
            .link {
                cursor: pointer;
            }
        </style>
        @endif

        <script>
            $(document).ready(function() {
                $('#tb-statistik .link').click(function() {
                    var viddata = $(this).attr("data");
                    var vidjenkel = $(this).attr("ed1");
                    var vidgolrupkt = $(this).attr("ed2");
                    var vidjenkel2 = $(this).attr("ed3");
                    var vidtkpendid = $(this).attr("ed4");
                    var vidjenkel3 = $(this).attr("ed5");
                    var videsl = $(this).attr("ed6");
                    var vidjenkel4 = $(this).attr("ed7");
                    var vidissek = $(this).attr("ed8");
                    var vidjenkel5 = $(this).attr("ed9");
                    var vidtingkat = $(this).attr("ed10");
                    var vidjenkel6 = $(this).attr("ed11");
                    var vidtingkat2 = $(this).attr("ed12");
                    var viddikstru = $(this).attr("ed13");
                    var vidjenkel7 = $(this).attr("ed14");
                    var vidkategori = $(this).attr("ed15");
                    var vidjenjab = $(this).attr("ed16");
                    var vidjenkedudupeg = $(this).attr("ed17");
                    var vidstspeg = $(this).attr("ed18");
                    var vidasn = $(this).attr("ed19");

                    $('#form-print #iddata').val(viddata);
                    $('#form-print #idjenkel').val(vidjenkel);
                    $('#form-print #idgolru').val(vidgolrupkt);
                    $('#form-print #idjenkel2').val(vidjenkel2);
                    $('#form-print #idtkpendid').val(vidtkpendid);
                    $('#form-print #idjenkel3').val(vidjenkel3);
                    $('#form-print #idesl').val(videsl);
                    $('#form-print #idjenkel4').val(vidjenkel4);
                    $('#form-print #idissek').val(vidissek);
                    $('#form-print #idjenkel5').val(vidjenkel5);
                    $('#form-print #idtingkat').val(vidtingkat);
                    $('#form-print #idjenkel6').val(vidjenkel6);
                    $('#form-print #idtingkat2').val(vidtingkat2);
                    $('#form-print #iddikstru').val(viddikstru);
                    $('#form-print #idjenkel7').val(vidjenkel7);
                    $('#form-print #kategoriumur').val(vidkategori);
                    $('#form-print #idjenjab').val(vidjenjab);
                    $('#form-print #idjenkedudupeg').val(vidjenkedudupeg);
                    $('#form-print #idstspeg').val(vidstspeg);
                    $('#form-print #idasn').val(vidasn);
                    $('#form-print').submit();

                });
            });
        </script>

        <form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistikrekap_profil_pns" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
            {!!csrf_field()!!}
            <input type="hidden" id="iddata" name="iddata" value="" />
            <input type="hidden" id="idjenkel" name="idjenkel" value="" />
            <input type="hidden" id="idgolru" name="idgolru" value="" />
            <input type="hidden" id="idjenkel2" name="idjenkel2" value="" />
            <input type="hidden" id="idtkpendid" name="idtkpendid" value="" />
            <input type="hidden" id="idjenkel3" name="idjenkel3" value="" />
            <input type="hidden" id="idesl" name="idesl" value="" />
            <input type="hidden" id="idjenkel4" name="idjenkel4" value="" />
            <input type="hidden" id="idissek" name="idissek" value="" />
            <input type="hidden" id="idjenkel5" name="idjenkel5" value="" />
            <input type="hidden" id="idtingkat" name="idtingkat" value="" />
            <input type="hidden" id="idjenkel6" name="idjenkel6" value="" />
            <input type="hidden" id="idtingkat2" name="idtingkat2" value="" />
            <input type="hidden" id="iddikstru" name="iddikstru" value="" />
            <input type="hidden" id="idjenkel7" name="idjenkel7" value="" />
            <input type="hidden" id="kategoriumur" name="kategoriumur" value="" />
            <input type="hidden" id="idjenjab" name="idjenjab" value="" />
            <input type="hidden" id="idjenkedudupeg" name="idjenkedudupeg" value="" />
            <input type="hidden" id="idstspeg" name="idstspeg" value="" />
            <input type="hidden" id="idasn" name="idasn" value="" />
        </form>
        <h4 align="center">PROFIL ASN PEMERINTAH KABUPATEN KENDAL PERIODE - {{strtoupper(formatBulan(date('m')))}} {{ date('Y')}}</h4><br>
        <table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
            <thead class="bg-primary">
                <tr>
                    <th rowspan="2" style="width:10px;">
                        <div class="text-center">NO</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">JENIS DATA</div>
                    </th>
                    <th colspan="2">
                        <div class="text-center">PNS</div>
                    </th>
                    <th colspan="2">
                        <div class="text-center">PPPK</div>
                    </th>
                    <th colspan="2">
                        <div class="text-center">PPPK PW</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">JUMLAH</div>
                    </th>
                </tr>
                <tr>
                    <th>
                        <div class="text-center">PRIA</div>
                    </th>
                    <th>
                        <div class="text-center">WANITA</div>
                    </th>
                    <th>
                        <div class="text-center">PRIA</div>
                    </th>
                    <th>
                        <div class="text-center">WANITA</div>
                    </th>
                    <th>
                        <div class="text-center">PRIA</div>
                    </th>
                    <th>
                        <div class="text-center">WANITA</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- menurut golongan  -->
                <?php
                $where = " a.idjenkedudupeg not in('21','99')";
                if (Input::get('idskpd') != '') {
                    $where .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where .= "";
                }

                $rs = \DB::table('tb_01 as a')
                    ->select(
                        'a.idgolrupkt',
                        'b.idgolru',
                        'a.idjenkel',
                        'a.idstspeg',
                        \DB::raw("
                        IF(LEFT(a.idgolrupkt,1)=1 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan I',
                        IF(a.idgolrupkt=11 && IF(idstspeg = 3,1,0),'PPPK - Golongan I',
                        IF(LEFT(a.idgolrupkt,1)=2 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan II',
                        IF(a.idgolrupkt=21 && IF(idstspeg = 3,1,0),'PPPK - Golongan V',
                        IF(a.idgolrupkt=23 && IF(idstspeg = 3,1,0),'PPPK - Golongan VII',
                        IF(LEFT(a.idgolrupkt,1)=3 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan III',
                        IF(a.idgolrupkt=31 && IF(idstspeg = 3,1,0),'PPPK - Golongan IX',
                        IF(a.idgolrupkt=32 && IF(idstspeg = 3,1,0),'PPPK - Golongan X',
                        IF(a.idgolrupkt=33 && IF(idstspeg = 3,1,0),'PPPK - Golongan XI',
                        IF(a.idgolrupkt=34 && IF(idstspeg = 3,1,0),'PPPK - Golongan XII',
                        IF(LEFT(a.idgolrupkt,1)=4 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan IV',
                        IF(LEFT(a.idgolrupkt,1)=4 && IF(idstspeg = 3,1,0),'PPPK - Golongan XIII - XVII',
                        '- Golongan Kosong')))))))))))) as golongan"),
                        \DB::raw("COUNT(*) AS 'totalgol'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg<3,1,0)) AS 'pria'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg<3,1,0)) AS 'wanita'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=3,1,0)) AS 'priapppk'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=3,1,0)) AS 'wanitapppk'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=4,1,0)) AS 'priapppkpw'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=4,1,0)) AS 'wanitapppkpw'")
                    )
                    ->join('a_golruang as b', \DB::raw("a.idgolrupkt"), '=', 'b.idgolru')
                    ->whereRaw($where)
                    ->groupBy(\DB::raw("LEFT(b.idgolru,1),golongan"))
                    ->orderBy('idstspeg', 'asc')
                    ->orderBy('idgolrupkt', 'asc')
                    ->get();

                $n = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">1</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Golongan</div>
                    </td>
                </tr>
                @if(count($rs) > 0)
                @foreach($rs as $item)
                <?php
                $n++;
                $totalgol[] = $item->totalgol;
                $pria[] = $item->pria;
                $wanita[] = $item->wanita;
                $priapppk[] = $item->priapppk;
                $wanitapppk[] = $item->wanitapppk;
                $priapppkpw[] = $item->priapppkpw;
                $wanitapppkpw[] = $item->wanitapppkpw;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{{$n}}.&nbsp{!!$item->golongan!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="1" ed2="{!!$item->idgolrupkt!!}" ed18="2" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->pria!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="2" ed2="{!!$item->idgolrupkt!!}" ed18="2" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->wanita!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="1" ed2="{!!$item->idgolrupkt!!}" ed18="3" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->priapppk!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="2" ed2="{!!$item->idgolrupkt!!}" ed18="3" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->wanitapppk!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="1" ed2="{!!$item->idgolrupkt!!}" ed18="4" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->priapppkpw!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="2" ed2="{!!$item->idgolrupkt!!}" ed18="4" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->wanitapppkpw!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="1" ed1="0" ed2="{!!$item->idgolrupkt!!}" ed18="0" ed19="{!!(($n>5)?0:(($n==1)?2:1))!!}">{!!$item->totalgol!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppk)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppk)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppkpw)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppkpw)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalgol)!!}</b></div>
                    </td>
                </tr>
                <!-- end of menurut golongan   -->

                <!--  menurut jenjang pendidikan-->
                <?php
                $where2 = " a.idjenkedudupeg not in('21','99')";
                if (Input::get('idskpd') != '') {
                    $where2 .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where2 .= "";
                }

                $rs2 = \DB::table('tb_01 as a')
                    ->select(
                        'a.idtkpendid',
                        'b.tkpendid',
                        \DB::raw("COUNT(*) AS 'totalpendid'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg<3,1,0)) AS 'pria2'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg<3,1,0)) AS 'wanita2'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=3,1,0)) AS 'priapppk2'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=3,1,0)) AS 'wanitapppk2'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=4,1,0)) AS 'priapppkpw2'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=4,1,0)) AS 'wanitapppkpw2'")
                    )
                    ->join('a_tkpendid as b', \DB::raw("a.idtkpendid"), '=', 'b.idtkpendid')
                    ->whereRaw($where2)
                    ->groupBy('a.idtkpendid')
                    ->get();

                $n2 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">2</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Jenjang Pendidikan</div>
                    </td>
                </tr>
                @if(count($rs2) > 0)
                @foreach($rs2 as $item)
                <?php
                $n2++;
                $totalpendid[] = $item->totalpendid;
                $pria2[] = $item->pria2;
                $wanita2[] = $item->wanita2;
                $priapppk2[] = $item->priapppk2;
                $wanitapppk2[] = $item->wanitapppk2;
                $priapppkpw2[] = $item->priapppkpw2;
                $wanitapppkpw2[] = $item->wanitapppkpw2;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{{$n2}}.&nbsp{!!$item->tkpendid!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="1" ed4="{!!$item->idtkpendid!!}" ed18="2">{!!$item->pria2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="2" ed4="{!!$item->idtkpendid!!}" ed18="2">{!!$item->wanita2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="1" ed4="{!!$item->idtkpendid!!}" ed18="3">{!!$item->priapppk2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="2" ed4="{!!$item->idtkpendid!!}" ed18="3">{!!$item->wanitapppk2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="1" ed4="{!!$item->idtkpendid!!}" ed18="4">{!!$item->priapppkpw2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="2" ed3="2" ed4="{!!$item->idtkpendid!!}" ed18="4">{!!$item->wanitapppkpw2!!}</div>
                    </td>

                    <td>
                        <div class="link text-center" data="2" ed3="0" ed4="{!!$item->idtkpendid!!}" ed18="0">{!!$item->totalpendid!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppk2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppk2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppkpw2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppkpw2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalpendid)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jenjang pendidikan-->

                <!--  menurut jabatan struktural-->
                <?php
                $where3 = " a.idjenkedudupeg not in('21','99') and a.idjenjab >= '20'";
                if (Input::get('idskpd') != '') {
                    $where3 .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where3 .= "";
                }

                $rs3 = \DB::table('tb_01 as a')
                    ->select(
                        'a.idesljbt',
                        'b.esl',
                        \DB::raw("COUNT(*) AS 'totaleslstruk'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria3'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita3'"),
                        \DB::raw("SUM(IF(idjenkel=1 and LEFT(a.idesljbt,1)='2',1,0)) AS 'pria3esl2'"),
                        \DB::raw("SUM(IF(idjenkel=2 and LEFT(a.idesljbt,1)='2',1,0)) AS 'wanita3esl2'"),
                        \DB::raw("SUM(IF(LEFT(a.idesljbt,1)='2',1,0)) AS 'total3esl2'"),
                        \DB::raw("SUM(IF(idjenkel=1 and LEFT(a.idesljbt,1)='3',1,0)) AS 'pria3esl3'"),
                        \DB::raw("SUM(IF(idjenkel=2 and LEFT(a.idesljbt,1)='3',1,0)) AS 'wanita3esl3'"),
                        \DB::raw("SUM(IF(LEFT(a.idesljbt,1)='3',1,0)) AS 'total3esl3'"),
                        \DB::raw("SUM(IF(idjenkel=1 and LEFT(a.idesljbt,1)='4',1,0)) AS 'pria3esl4'"),
                        \DB::raw("SUM(IF(idjenkel=2 and LEFT(a.idesljbt,1)='4',1,0)) AS 'wanita3esl4'"),
                        \DB::raw("SUM(IF(LEFT(a.idesljbt,1)='4',1,0)) AS 'total3esl4'"),
                        \DB::raw("SUM(IF(idjenkel=1 and LEFT(a.idesljbt,1)='5',1,0)) AS 'pria3esl5'"),
                        \DB::raw("SUM(IF(idjenkel=2 and LEFT(a.idesljbt,1)='5',1,0)) AS 'wanita3esl5'"),
                        \DB::raw("SUM(IF(LEFT(a.idesljbt,1)='5',1,0)) AS 'total3esl5'")
                    )
                    ->join('a_esl as b', \DB::raw("a.idesljbt"), '=', 'b.idesl')
                    ->whereRaw($where3)
                    ->groupBy('a.idesljbt')
                    ->get();

                $n3 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">3</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Jabatan Struktural</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @if(count($rs3) > 0)
                @foreach($rs3 as $item)
                <?php
                $n3++;
                $totaleslstruk[] = $item->totaleslstruk;
                $pria3[] = $item->pria3;
                $wanita3[] = $item->wanita3;
                $pria3esl2[] = $item->pria3esl2;
                $wanita3esl2[] = $item->wanita3esl2;
                $total3esl2[] = $item->total3esl2;
                $pria3esl3[] = $item->pria3esl3;
                $wanita3esl3[] = $item->wanita3esl3;
                $total3esl3[] = $item->total3esl3;
                $pria3esl4[] = $item->pria3esl4;
                $wanita3esl4[] = $item->wanita3esl4;
                $total3esl4[] = $item->total3esl4;
                $pria3esl5[] = $item->pria3esl5;
                $wanita3esl5[] = $item->wanita3esl5;
                $total3esl5[] = $item->total3esl5;
                ?>
                @if($n3=='1')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>1. Eselon II</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                @elseif($n3=='2')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>2. Eselon III</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @elseif($n3=='4')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>3. Eselon IV</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @elseif($n3=='7')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>4. Eselon IV</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">&nbsp &nbsp Eselon - {!!$item->esl!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="3" ed5="1" ed6="{!!$item->idesljbt!!}">{!!$item->pria3!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="3" ed5="2" ed6="{!!$item->idesljbt!!}">{!!$item->wanita3!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="3" ed5="0" ed6="{!!$item->idesljbt!!}">{!!$item->totaleslstruk!!}</div>
                    </td>
                </tr>
                @if($n3=='1')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td><b>Jumlah Eselon II</b></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria3esl2)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita3esl2)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($total3esl2)!!}</b></div>
                    </td>
                </tr>
                @elseif($n3=='3')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td><b>Jumlah Eselon III</b></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria3esl3)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita3esl3)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($total3esl3)!!}</b></div>
                    </td>
                </tr>
                @elseif($n3=='5')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td><b>Jumlah Eselon IV</b></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria3esl4)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita3esl4)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($total3esl4)!!}</b></div>
                    </td>
                </tr>
                @elseif($n3=='6')
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td><b>Jumlah Eselon V</b></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria3esl5)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita3esl5)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($total3esl5)!!}</b></div>
                    </td>
                </tr>
                @endif
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria3)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita3)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totaleslstruk)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jabatan struktural-->

                <!--  menurut jabatan fungsional khusus guru -->
                <?php
                $where4 = " a.idjenkedudupeg not in('21','99') and a.idjenjab = 2 and LEFT(a.idjabfung,3) = '300'";
                if (Input::get('idskpd') != '') {
                    $where4 .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where4 .= "";
                }

                $rs4 = \DB::table('tb_01 as a')
                    ->select(
                        'b.issek',
                        \DB::raw("IF(b.issek=1,'TK',IF(b.issek=2,'SD',IF(b.issek=3,'SMP',IF(b.issek=4,'DPK',IF(b.issek=5,'SMA/SMK','Bidang Pembinaan Ketenagaan'))))) as jenjang"),
                        \DB::raw("COUNT(*) AS 'totalguru'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria4'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita4'")
                    )
                    ->join('a_skpd as b', \DB::raw("a.idskpd"), '=', 'b.idskpd')
                    ->whereRaw($where4)
                    ->groupBy('b.issek')
                    ->get();

                $n4 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">4</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Jabatan Fungsional Khusus</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left">4a</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Tenaga Pendidikan (Guru)</div>
                    </td>
                </tr>
                @if(count($rs4) > 0)
                @foreach($rs4 as $item)
                <?php
                $n4++;
                $totalguru[] = $item->totalguru;
                $pria4[] = $item->pria4;
                $wanita4[] = $item->wanita4;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{!!$item->jenjang!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="4" ed7="1" ed8="{!!$item->issek!!}">{!!$item->pria4!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="4" ed7="2" ed8="{!!$item->issek!!}">{!!$item->wanita4!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="4" ed7="0" ed8="{!!$item->issek!!}">{!!$item->totalguru!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria4)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita4)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalguru)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jabatan fungsional khusus guru -->

                <!--  menurut jabatan fungsional khusus kesehatan -->
                <?php
                $where5 = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND a.isguru = '2'";
                if (Input::get('idskpd') != '') {
                    $where5 .= " and b.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where5 .= "";
                }

                $rs5 = \DB::table('a_jabfung as a')
                    ->select(
                        'a.idjabfung',
                        'a.jabfung2',
                        'a.tingkat',
                        \DB::raw("COUNT(*) AS 'totalkesehatan'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria5'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita5'")
                    )
                    ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
                    ->whereRaw($where5)
                    ->groupBy('a.tingkat')
                    ->get();

                $n5 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">4b</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Tenaga Kesehatan</div>
                    </td>
                </tr>
                @if(count($rs5) > 0)
                @foreach($rs5 as $item)
                <?php
                $n5++;
                $totalkesehatan[] = $item->totalkesehatan;
                $pria5[] = $item->pria5;
                $wanita5[] = $item->wanita5;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{!!$item->jabfung2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="5" ed9="1" ed10="{!!$item->tingkat!!}">{!!$item->pria5!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="5" ed9="2" ed10="{!!$item->tingkat!!}">{!!$item->wanita5!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="5" ed9="0" ed10="{!!$item->tingkat!!}">{!!$item->totalkesehatan!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria5)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita5)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalkesehatan)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jabatan fungsional khusus kesehatan -->

                <!--  end of jabatan fungsional khusus teknis -->
                <?php
                $where6 = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND a.isguru = '3'";
                if (Input::get('idskpd') != '') {
                    $where6 .= " and b.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where6 .= "";
                }

                $rs6 = \DB::table('a_jabfung as a')
                    ->select(
                        'a.idjabfung',
                        'a.jabfung2',
                        'a.tingkat',
                        \DB::raw("COUNT(*) AS 'totalteknis'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria6'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita6'")
                    )
                    ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
                    ->whereRaw($where6)
                    ->groupBy('a.tingkat')
                    ->get();

                $n6 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">4c</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Tenaga Teknis</div>
                    </td>
                </tr>
                @if(count($rs6) > 0)
                @foreach($rs6 as $item)
                <?php
                $n6++;
                $totalteknis[] = $item->totalteknis;
                $pria6[] = $item->pria6;
                $wanita6[] = $item->wanita6;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{!!$item->jabfung2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="6" ed11="1" ed12="{!!$item->tingkat!!}">{!!$item->pria6!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="6" ed11="2" ed12="{!!$item->tingkat!!}">{!!$item->wanita6!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="6" ed11="0" ed12="{!!$item->tingkat!!}">{!!$item->totalteknis!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($pria6)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanita6)!!}</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalteknis)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jabatan fungsional khusus teknis -->

                <!--  menurut diklat struktural -->
                <?php
                $where7 = " b.idjenkedudupeg not in('21','99')";
                if (Input::get('idskpd') != '') {
                    $where7 .= " and b.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where7 .= "";
                }

                $rs7 = \DB::table('a_dikstru as a')
                    ->select(
                        'a.iddikstru',
                        'a.dikstru',
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg<3,1,0)) AS 'lpnsdikstru'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg<3,1,0)) AS 'ppnsdikstru'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=3,1,0)) AS 'priapppkdikstru'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=3,1,0)) AS 'wanitapppkdikstru'"),
                        \DB::raw("SUM(IF(idjenkel=1,1,0) && IF(idstspeg=4,1,0)) AS 'priapppkpwdikstru'"),
                        \DB::raw("SUM(IF(idjenkel=2,1,0) && IF(idstspeg=4,1,0)) AS 'wanitapppkpwdikstru'"),
                        \DB::raw("COUNT(*) AS 'totaldikstru'")
                    )
                    ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
                    ->whereRaw($where7)
                    ->groupBy('a.iddikstru')
                    ->get();

                $n7 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">5</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Diklat Struktural</div>
                    </td>
                </tr>
                @if(count($rs7) > 0)
                @foreach($rs7 as $item)
                <?php
                $n7++;
                $totaldikstru[] = $item->totaldikstru;
                $lpnsdikstru[] = $item->lpnsdikstru;
                $ppnsdikstru[] = $item->ppnsdikstru;
                $priapppkdikstru[] = $item->priapppkdikstru;
                $wanitapppkdikstru[] = $item->wanitapppkdikstru;
                $priapppkpwdikstru[] = $item->priapppkpwdikstru;
                $wanitapppkpwdikstru[] = $item->wanitapppkpwdikstru;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{!!$item->dikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lpnsdikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->ppnsdikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->priapppkdikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->wanitapppkdikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->priapppkpwdikstru!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->wanitapppkpwdikstru!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="7" ed13="{!!$item->iddikstru!!}">{!!$item->totaldikstru!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($lpnsdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($ppnsdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppkdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppkdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($priapppkpwdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($wanitapppkpwdikstru)!!}</b></div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totaldikstru)!!}</b></div>
                    </td>
                </tr>
                <!--  end of diklat struktural -->

                <!--  menurut jenis kelamin -->
                <?php
                $where8 = " b.idjenkedudupeg not in('21','99')";
                if (Input::get('idskpd') != '') {
                    $where8 .= " and b.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where8 .= "";
                }

                $rs8 = \DB::table('a_jenkel as a')
                    ->select(
                        'a.idjenkel',
                        'a.jenkel',
                        \DB::raw("SUM(IF(b.idjenkel=1,1,0) && IF(b.idstspeg<3,1,0)) AS 'priapnsgender'"),
                        \DB::raw("SUM(IF(b.idjenkel=2,1,0) && IF(b.idstspeg<3,1,0)) AS 'wanitapnsgender'"),
                        \DB::raw("SUM(IF(b.idjenkel=1,1,0) && IF(b.idstspeg=3,1,0)) AS 'priapppkgender'"),
                        \DB::raw("SUM(IF(b.idjenkel=2,1,0) && IF(b.idstspeg=3,1,0)) AS 'wanitapppkgender'"),
                        \DB::raw("SUM(IF(b.idjenkel=1,1,0) && IF(b.idstspeg=4,1,0)) AS 'priapppkpwgender'"),
                        \DB::raw("SUM(IF(b.idjenkel=2,1,0) && IF(b.idstspeg=4,1,0)) AS 'wanitapppkpwgender'"),
                        \DB::raw("COUNT(*) AS 'totaljenkel'")
                    )
                    ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
                    ->whereRaw($where8)
                    ->groupBy('a.idjenkel')
                    ->get();

                $n8 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">6</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Jenis Kelamin</div>
                    </td>
                </tr>
                @if(count($rs8) > 0)
                @foreach($rs8 as $item)
                <?php
                $n8++;
                $totaljenkel[] = $item->totaljenkel;
                $priapnsgender[] = $item->priapnsgender;
                $wanitapnsgender[] = $item->wanitapnsgender;
                $priapppkgender[] = $item->priapppkgender;
                $wanitapppkgender[] = $item->wanitapppkgender;
                $priapppkpwgender[] = $item->priapppkpwgender;
                $wanitapppkpwgender[] = $item->wanitapppkpwgender;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">{{$n8}} . &nbsp{!!$item->jenkel!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2!=0)?$item->priapnsgender:'-')!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2==0)?$item->wanitapnsgender:'-')!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2!=0)?$item->priapppkgender:'-')!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2==0)?$item->wanitapppkgender:'-')!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2!=0)?$item->priapppkpwgender:'-')!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!(($n8%2==0)?$item->wanitapppkpwgender:'-')!!}</div>
                    </td>

                    <td>
                        <div class="link text-center" data="8" ed14="{!!$item->idjenkel!!}">{!!$item->totaljenkel!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td colspan="3">
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totaljenkel)!!}</b></div>
                    </td>
                </tr>
                <!--  end of jenis kelamin -->

                <!--  menurut umur/usia -->
                <?php
                $where9 = " a.idjenkedudupeg not in('21','99')";
                if (Input::get('idskpd') != '') {
                    $where9 .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where9 .= "";
                }

                $rs9 = \DB::table('tb_01 as a')
                    ->select(
                        'a.tglhr',
                        // \DB::raw("COUNT(*) AS 'totalusia'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 != '',1,0)) AS 'totalusia'"),


                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpwlusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpwpusia1'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2100',1,0)) AS 'usia1'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia2'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '2600',1,0)) AS 'usia2'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia3'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3100',1,0)) AS 'usia3'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia4'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '3600',1,0)) AS 'usia4'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia5'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4100',1,0)) AS 'usia5'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia6'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '4600',1,0)) AS 'usia6'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia7'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5100',1,0)) AS 'usia7'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia8'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '5600',1,0)) AS 'usia8'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia9'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '6100',1,0)) AS 'usia9'"),

                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 1,1,0) && IF(a.idstspeg<3,1,0)) AS 'lusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 2,1,0) && IF(a.idstspeg<3,1,0)) AS 'pusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 1,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppklusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 2,1,0) && IF(a.idstspeg=3,1,0)) AS 'pppkpusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 1,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwlusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000' and a.idjenkel = 2,1,0) && IF(a.idstspeg=4,1,0)) AS 'pppkpwpusia10'"),
                        \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '6100'
                      AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 < '10000',1,0)) AS 'usia10'")
                    )
                    ->whereRaw($where9)
                    ->get();

                $n9 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">7</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut Umur/Usia</div>
                    </td>
                </tr>
                @if(count($rs9) > 0)
                @foreach($rs9 as $item)
                <?php
                $n9++;
                $totalusia[] = $item->totalusia;
                $totallusia[] = $item->lusia1 + $item->lusia2 + $item->lusia3 + $item->lusia4 + $item->lusia5 + $item->lusia6 + $item->lusia7 + $item->lusia8 + $item->lusia9 + $item->lusia10;
                $totalpusia[] = $item->pusia1 + $item->pusia2 + $item->pusia3 + $item->pusia4 + $item->pusia5 + $item->pusia6 + $item->pusia7 + $item->pusia8 + $item->pusia9 + $item->pusia10;
                $totalpppklusia[] = $item->pppklusia1 + $item->pppklusia2 + $item->pppklusia3 + $item->pppklusia4 + $item->pppklusia5 + $item->pppklusia6 + $item->pppklusia7 + $item->pppklusia8 + $item->pppklusia9 + $item->pppklusia10;
                $totalpppkpusia[] = $item->pppkpusia1 + $item->pppkpusia2 + $item->pppkpusia3 + $item->pppkpusia4 + $item->pppkpusia5 + $item->pppkpusia6 + $item->pppkpusia7 + $item->pppkpusia8 + $item->pppkpusia9 + $item->pppkpusia10;
                $totalpppkpwlusia[] = $item->pppkpwlusia1 + $item->pppkpwlusia2 + $item->pppkpwlusia3 + $item->pppkpwlusia4 + $item->pppkpwlusia5 + $item->pppkpwlusia6 + $item->pppkpwlusia7 + $item->pppkpwlusia8 + $item->pppkpwlusia9 + $item->pppkpwlusia10;
                $totalpppkpwpusia[] = $item->pppkpwpusia1 + $item->pppkpwpusia2 + $item->pppkpwpusia3 + $item->pppkpwpusia4 + $item->pppkpwpusia5 + $item->pppkpwpusia6 + $item->pppkpwpusia7 + $item->pppkpwpusia8 + $item->pppkpwpusia9 + $item->pppkpwpusia10;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">1. Usia 18 - 20</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia1!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia1!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia1!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia1!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia1!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia1!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="1">{!!$item->usia1!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">2. Usia 21 - 25</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia2!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia2!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia2!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia2!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia2!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia2!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="2">{!!$item->usia2!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">3. Usia 26 - 30</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia3!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia3!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia3!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia3!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia3!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia3!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="3">{!!$item->usia3!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">4. Usia 31 - 35</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia4!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia4!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia4!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia4!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia4!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia4!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="4">{!!$item->usia4!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">5. Usia 36 - 40</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia5!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia5!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia5!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia5!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia5!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia5!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="5">{!!$item->usia5!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">6. Usia 41 - 45</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia6!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia6!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia6!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia6!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia6!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia6!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="6">{!!$item->usia6!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">7. Usia 46 - 50</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia7!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia7!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia7!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia7!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia7!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia7!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="7">{!!$item->usia7!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">8. Usia 51 - 55</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia8!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia8!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia8!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia8!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia8!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia8!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="8">{!!$item->usia8!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">9. Usia 56 - 60</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia9!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia9!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia9!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia9!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia9!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia9!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="9">{!!$item->usia9!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">9. Usia > 60</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lusia10!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pusia10!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppklusia10!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpusia10!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwlusia10!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->pppkpwpusia10!!}</div>
                    </td>
                    <td>
                        <div class="link text-center" data="9" ed15="10">{!!$item->usia10!!}</div>
                    </td>
                </tr>


                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totallusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalpusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalpppklusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalpppkpusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalpppkpwlusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalpppkpwpusia)!!}</div>
                    </td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalusia)!!}</b></div>
                    </td>
                </tr>
                <!--  end of umur/usia -->

                <!--  menurut pensiun -->
                <?php
                $where10 = " a.idjenkedudupeg not in ('21') and a.idjenkedudupeg='99'";
                if (Input::get('idskpd') != '') {
                    $where10 .= " and a.idskpd like '" . Input::get('idskpd') . "%' ";
                } else {
                    $where10 .= "";
                }

                $rs10 = \DB::table('tb_01 as a')
                    ->select(
                        'a.idjenjab',
                        'a.idjenkedudupeg',
                        // \DB::raw("COUNT(*) AS 'totalusia'"),
                        \DB::raw("SUM(IF(a.idjenkedudupeg='99',1,0)) AS 'totalpensiun'"),
                        \DB::raw("SUM(IF(a.idjenjab>='20' and idjenkel = 1,1,0)) AS 'lpensiunstruk'"),
                        \DB::raw("SUM(IF(a.idjenjab>='20' and idjenkel = 2,1,0)) AS 'ppensiunstruk'"),
                        \DB::raw("SUM(IF(a.idjenjab>='20',1,0)) AS 'pensiunstruk'"),
                        \DB::raw("SUM(IF(a.idjenjab='2' and idjenkel = 1,1,0)) AS 'lpensiunfung'"),
                        \DB::raw("SUM(IF(a.idjenjab='2' and idjenkel = 2,1,0)) AS 'ppensiunfung'"),
                        \DB::raw("SUM(IF(a.idjenjab='2',1,0)) AS 'pensiunfung'"),
                        \DB::raw("SUM(IF(a.idjenjab='3' and idjenkel = 1,1,0)) AS 'lpensiunfungum'"),
                        \DB::raw("SUM(IF(a.idjenjab='3' and idjenkel = 2,1,0)) AS 'ppensiunfungum'"),
                        \DB::raw("SUM(IF(a.idjenjab='3',1,0)) AS 'pensiunfungum'")
                    )
                    ->whereRaw($where10)
                    ->get();

                $n10 = 0;
                ?>
                <tr>
                    <td>
                        <div class="text-left">8</div>
                    </td>
                    <td colspan="4">
                        <div class="text-left">Menurut PNS yang Sudah Pensiun Sejak Migrasi 2017</div>
                    </td>
                </tr>
                @if(count($rs10) > 0)
                @foreach($rs10 as $item)
                <?php
                $n10++;
                $totalpensiun[] = $item->totalpensiun;
                $totallpensiun[] = $item->lpensiunfungum + $item->lpensiunfung + $item->lpensiunstruk;
                $totalppensiun[] = $item->ppensiunfungum + $item->ppensiunfung + $item->ppensiunstruk;
                ?>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">1. Staf</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lpensiunfungum!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->ppensiunfungum!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="10" ed16="3" ed17="{!!$item->idjenkedudupeg!!}">{!!$item->pensiunfungum!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">2. Fungsional</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lpensiunfung!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->ppensiunfung!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="10" ed16="2" ed17="{!!$item->idjenkedudupeg!!}">{!!$item->pensiunfung!!}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-left">3. Struktural</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->lpensiunstruk!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!$item->ppensiunstruk!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="link text-center" data="10" ed16="20" ed17="{!!$item->idjenkedudupeg!!}">{!!$item->pensiunstruk!!}</div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="20">Data tidak ditemukan.</td>
                </tr>
                @endif
                <tr>
                    <td>
                        <div class="text-left"></div>
                    </td>
                    <td>
                        <div class="text-center"><b>Total</b></div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totallpensiun)!!}</div>
                    </td>
                    <td>
                        <div class="text-center">{!!array_sum($totalppensiun)!!}</div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="text-center"><b>{!!array_sum($totalpensiun)!!}</b></div>
                    </td>
                </tr>
                <!--  end of pensiun -->
            </tbody>
        </table>

        @if(Request::segment(3) == 'print')
</body>

</html>
<script>
    $(document).ready(function() {
        //alert(window.orientation);
        $('div.print').click(function() {
            $(this).hide();
            window.print();
            /*
               setTimeout(function() {
                   window.close();
               }, 1);
               */
        });

        $('img').each(function(index, item) {
            $(item).error(function() {

                $(item).attr('src', 'no_image.jpg');
            });
        });

        $(document).on('mouseover', function() {
            $('div.print').show();
        });

    });
</script>
@endif