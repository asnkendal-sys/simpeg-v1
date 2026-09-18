
<html>
<head>
<title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Pendidikan Formal</title>
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
            .page-break	{ display:block; page-break-before:always; }
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
        }

        div.print:hover{
            opacity:1;
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

<?php
    $where = " tb_01.idjenkedudupeg not in (99,21) ";
    $skpd = getSkpd(Input::get('idskpd'));
    $golru = getAttr('a_golruang', 'idgolru', Input::get('idgolru'), 'golru');
    $tahun = Input::get('tahun');

    switch(Input::get('idskpd')){
        case "":
            $where .= "";
            break;
        default:
            $where .= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
            break;
    }

    switch(Input::get('idgolru')){
        case "notnull":
            $where .= " and tb_01.idgolrupkt between '11' and '45' ";
            $titleadd = strtoupper($skpd)." SEMUA GOLONGAN ";
            break;
        case "null":
            $where .= " and tb_01.idgolrupkt='' ";
            $titleadd = strtoupper($skpd)." YANG GOLONGANNYA KOSONG ";
            break;
        default:
            $where .= " and tb_01.idgolrupkt='".Input::get('idgolru')."'";
            $titleadd = strtoupper($skpd)." GOLONGAN ".strtoupper($golru);
            break;
    }

	$having = " usia = '".$tahun."' ";

    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
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
        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y')+0 AS usia")
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
    ->havingRaw($having)
    ->orderBy('tb_01.idjenjab', 'asc')
    ->orderBy('tb_01.idgolrupkt', 'desc')
    ->orderBy('tb_01.tmtpkt', 'asc');

?>
<div align="center">
    <h3>DAFTAR PEGAWAI PADA  {!!$titleadd!!}</h3>
    <h3>BERDASARKAN USIA {!!$tahun!!}</h3>
</div><br>
    <table border="1">
        <thead class="breadcrumb">
        <tr>
            <th rowspan="2">
                <div class="text-center">NO.</div>
            </th>
            <th rowspan="2">
                <div class="text-left">NAMA</div>
                <div class="text-left">TEMPAT, TGL LAHIR</div>
            </th>
            <th rowspan="2">
                <div class="text-center">NIP</div>
                <div class="text-center">KARPEG</div>
            </th>
            <th rowspan="2">
                <div class="text-center">GOL.</div>
                <div class="text-center">TMT</div>
            </th>
            <th rowspan="2">
                <div class="text-center">ESELON</div>
                <div class="text-center">TMT</div>
            </th>
            <th rowspan="2">
                <div class="text-center">JABATAN</div>
                <div class="text-center">UNIT KERJA</div>
                <div class="text-center">TMT</div>
            </th>
            <th colspan="2">
                <div class="text-center">MASA KERJA</div>
            </th>
            <th colspan="2">
                <div class="text-center">s/d SEKARANG</div>
            </th>
            <th rowspan="2">
                <div class="text-center">PENDIDIKAN TERAKHIR</div>
                <div class="text-center">TAHUN</div>
            </th>
            <th rowspan="2">
                <div class="text-center">AGAMA</div>
                <div class="text-center">USIA</div>
            </th>
        </tr>
        <tr>
            <th>
                <div class="text-center">THN</div>
            </th>
            <th>
                <div class="text-center">BLN</div>
            </th>
            <th>
                <div class="text-center">THN</div>
            </th>
            <th>
                <div class="text-center">BLN</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @if(count($rs->get()) > 0)
        <?php $n = 0; ?>
        @foreach($rs->get() as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>
                <div class="text-left">{!!$item->nama!!}</div>
                <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
            </td>
            <td align="center">
                <div class="text-center">{!!fnip($item->nip)!!}</div>
                <div class="text-center">{!!$item->nokarpeg!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!$item->golru!!}</div>
                <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!($item->esl!='')?$item->esl:'-'!!}</div>
            </td>
            <td>
                <small>
                    <div class="text-left">{!!$item->jabatan!!}</div>
                    <div class="text-left"><i>Pada</i></div>
                    <div class="text-left">{!!$item->path!!}</div>
                    <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
                </small>
            </td>
            <td align="center">
                <div class="text-center">{!!$item->mkthnpkt!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!$item->mkblnpkt!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!substr($item->mkskr,0,-2)!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!substr($item->mkskr,-2)!!}</div>
            </td>
            <td>
                <div class="text-left">{!!ucwords(strtolower($item->jenjurusan))!!}</div>
                <div class="text-left">{!!$item->thijaz!!}</div>
            </td>
            <td align="center">
                <div class="text-center">{!!$item->agama!!}</div>
                <div class="text-center">{!!substr($item->usia,0,2)!!} thn {!!substr($item->usia,2,2)!!} bln</div>
            </td>
        </tr>
        @endforeach
        @else
        <tr><td colspan="12">Daftar Pegawai tidak tersedia.</td></tr>
        @endif
        </tbody>
    </table>
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