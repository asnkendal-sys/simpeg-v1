<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Nominatif DUK</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: A4 landscape;
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
    $where = " tb_01.idjenkedudupeg not in('21','99') ";
    $idskpd = Input::get('idskpd');

    if($idskpd!="") $where .= " and tb_01.idskpd LIKE '".$idskpd."%'";
    $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_golruang.golru_p3k','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','tb_01.jamhari_dikstru','tb_01.tgsttp_dikstru',
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
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
            \DB::raw("IFNULL(a_dikstru.dikstru,'') AS dikstru")
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
        ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
        ->get();
?>
<div align="center">
    <h4>DAFTAR URUT KEPANGKATAN</h4>
    <h4>PNS DI {!!strtoupper(getSkpd($idskpd))!!}</h4>
    <h4>GOLONGAN RUANG : I/a SAMPAI DENGAN IV/e</h4>
    <h4>KEADAAN : {!!strtoupper(formatTanggalPanjang(date('Y-m-d')))!!}</h4>
    <h4>TOTAL PNS : {!!count($rs)!!} ORANG</h4>
</div>
<table border="1" width="100%">
  <thead class="breadcrumb">
  <tr>
      <th colspan="2"><div class="text-center">NO URUT</div></th>
      <th rowspan="2">
          <div class="text-center">NAMA PEGAWAI</div>
          <div class="text-center">NOMOR INDUK PEGAWAI</div>
      </th>
      <th>
          <div class="text-center">PANGKAT</div>
      </th>
      <th>
          <div class="text-center">JABATAN</div>
      </th>
      <th colspan="2">
          <div class="text-center">MKER</div>
      </th>
      <th colspan="2">
          <div class="text-center">LAT. JABATAN</div>
      </th>
      <th colspan="3">
          <div class="text-center">PENDIDIKAN</div>
      </th>
      <th rowspan="2">
          <div class="text-center">TEM LAHIR</div>
          <div class="text-center">TGL LAHIR</div>
      </th>
      <th rowspan="2">
          <div class="text-center">CAT MUT KEPEG</div>
      </th>
      <th rowspan="2">
          <div class="text-center">UNIT KERJA</div>
      </th>
  </tr>
  <tr>
      <th>
          <div class="text-center">PEG</div>
      </th>
      <th>
          <div class="text-center">PKT</div>
      </th>
      <th>
          <div class="text-center">G/R AKHIR <br> TMT</div>
      </th>
      <th>
          <div class="text-center">NAMA JABATAN <br> TMT</div>
      </th>
      <th>
          <div class="text-center">TH</div>
      </th>
      <th>
          <div class="text-center">BL</div>
      </th>
      <th>
          <div class="text-center">NAMA <br> TGL LULUS</div>
      </th>
      <th>
          <div class="text-center">JAM</div>
      </th>
      <th>
         <div class="text-center">TINGKAT <br> PENDIDIKAN</div>
      </th>
      <th>
          <div class="text-center">JURUSAN <br> PENDIDIKAN</div>
      </th>
      <th>
          <div class="text-center">TH LLS</div>
      </th>
  </tr>
  </thead>
  <tbody>
	<?php
        error_reporting(0);
        $n = 0;
        $m = 1;
        foreach($rs as $item){ $n++;
            $gol1[] = $item->idgolrupkt;
            $gol2[] = $item->idgolrupkt;

            if($gol1[$n-1] == $gol2[$n-2]){
                $m++;
            }else{
                $m=1;
            }

            /*masa kerja*/
            $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
            if($mkbln > 12){
                $thnmkskr = substr($item->mkskr,0,-2)+1;
                $blnmkskr = "0".($mkbln-12);
            }else{
                $thnmkskr = substr($item->mkskr,0,-2);
                $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
            }
	?>
    <tr>
        <td align="center">{!!$n!!}</td>
        <td align="center">{!!$m!!}</td>
        <td>
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <span class="text-left">NIP : {!!$item->nip!!}</span>
        </td>
        <td align="center">
            <div class="text-center">{!!($item->idstspeg=='3')?$item->golru_p3k:$item->golru!!}</div>
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->jabatan!!}</div>
            <div class="text-left">{!!date('d-m-Y', strtotime($item->tmtjbt))!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$thnmkskr!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$blnmkskr!!}</div>
        </td>
        <td>
            @if($item->idjenjab == 1)
            <div class="text-left">{!!strtoupper($item->dikstru)!!}</div>
            <div class="text-left">{!!(($item->tgsttp_dikstru=='0000-00-00')?"":substr($item->tgsttp_dikstru,0,4))!!}</div>
            @endif
        </td>
        <td>
            @if($item->idjenjab == 1)
            <div class="text-left">{!!($item->jamhari_dikstru==0)?'':$item->jamhari_dikstru!!}</div>
            @endif
        </td>
        <td>
            <div class="text-left">{!!strtoupper($item->tkpendid)!!}</div>
        </td>
        <td>
            <div class="text-left">{!!strtoupper($item->jenjurusan)!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->thijaz!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->tmlhr!!}</div>
            <div class="text-left">{!!date('d-m-Y', strtotime($item->tglhr))!!}</div>
        </td>
        <td align="center">
            <div class="text-left">&nbsp;</div>
        </td>
        <td>
            <div class="text-left">{!!$item->path_short!!}</div>
        </td>
    </tr>
	<?php } ?>
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