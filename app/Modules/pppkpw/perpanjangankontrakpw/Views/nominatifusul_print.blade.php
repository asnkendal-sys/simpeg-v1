<html>
<head>
<title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Nominatif Penjagaan PPPK</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
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
    $tmtmulai_pppk = Input::get('tmtmulaiakhir_pppk');
    $idpppk = Input::get('tahun')."".Input::get('bulan').".".Input::get('idskpd');        	
    $where = "tb_01.nip NOT IN (SELECT nip FROM tr_pppkpw WHERE idpppk like \"".$idpppk."%\") and tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 4 ";
    // $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 3 ";
    $having = '';

    /* Kondisi jabatan jabatan*/
    if(Input::get('idjenjab') != ''){
        $where.= " and tb_01.idjenjab = '".Input::get('idjenjab')."'";
    }    

    /* Kondisi Tahun Perpanjangan*/
    if((Input::get('tahunperpanjangan') != '')){
        // $having .= " and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
        $having .= " pensiunnext > tmtakhirakhir_pppk + interval '".Input::get('tahunperpanjangan')."' YEAR";
    }

    /* Kondisi Tahun */
    if(Input::get('tahun') != ''){
        $where .= " and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun')."";
        $titletahun = ' TAHUN '.Input::get('tahun');
    }

    /* Kondisi Bulan */
    if(Input::get('bulan') != ''){
        $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan')."";
        $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan')));
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd') != ''){
        $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru','a_golruang.golru_p3k',
            \DB::raw("TIMESTAMPDIFF(YEAR, tmtmulaiakhir_pppk, tmtakhirakhir_pppk) AS selisih_tahunkerja"),
            \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_bulankerja"),
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw("
                  CONCAT(
                        IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              -
                              (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                              IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                    IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                        ),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              + tb_01.mkthncpn
                        )
                        ),
                        RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0, 2)) AS mkskr
            "),
            \DB::raw("TIMESTAMPDIFF(YEAR, tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_tahun"),
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
        // ->havingRaw($having)
        ->orderBy(\DB::raw('selisih_tahun asc, tb_01.tglhr, tb_01.idgolrupkt, tb_01.nama'))
        ->get();
?>
<div align="center">
<h3>NOMINATIF PERPANJANGAN KONTRAK PEGAWAI PPPK PW</h3>
<h3>    
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!((Input::get('bulan') != '')?$titlebulan:'')!!}
    {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h3>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th rowspan="2"><div class="text-center">NO</div></th>
        <th rowspan="2">
            <div class="text-left">NAMA</div>
            <div class="text-left">TEMPAT, TGL LAHIR</div>
        </th>
        <th rowspan="2">
            <div class="text-center">NIP</div>
            {{-- <div class="text-center">KARPEG</div> --}}
        </th>
        <th rowspan="2">
            <div class="text-center">GOLONGAN</div>
            <!--<div class="text-center">TMT</div>-->
        </th>
        <!--<th rowspan="2">
            <div class="text-center">ESELON</div>
            <div class="text-center">TMT</div>
        </th>-->
        <th rowspan="2">
            <div class="text-center">JABATAN</div>
            <div class="text-center">UNIT KERJA</div>
            <div class="text-center">TMT</div>
        </th>
        {{-- <th colspan="2">
            <div class="text-center">MASA KERJA</div>
        </th> --}}
        <th colspan="2">
            <div class="text-center">MASA&nbsp;KERJA<br>SAMPAI SEKARANG</div>
        </th>        
        <th rowspan="2">
            <div class="text-center">PENDIDIKAN TERAKHIR</div>
            <div class="text-center">TAHUN</div>
        </th>
        <th rowspan="2">
            {{-- <div class="text-center">AGAMA</div> --}}
            <div class="text-center">USIA</div>
        </th>
        <th colspan="3">PERJANJIAN KONTRAK TERKHIR</th>        
        <th rowspan="2">
            <div class="text-center">JARAK AKHIR KONTRAK</div>
            <div class="text-center">DENGAN PENSIUN</div>
        </th>
        <th colspan="2">RENCANA KONTRAK</th>
        <th colspan="2">PERJANJIAN KERJA</th>
    </tr>
    <tr>
        {{-- <th>
            <div class="text-center">THN</div>
        </th>
        <th>
            <div class="text-center">BLN</div>
        </th> --}}
        <th>
            <div class="text-center">THN</div>
        </th>
        <th>
            <div class="text-center">BLN</div>
        </th>
        <th>
            <div class="text-center">PENGANKATAN</div>     
        </th>
        <th>
            <div class="text-center">AWAL</div>     
        </th>
        <th>
            <div class="text-center">AKHIR</div>
        </th>
        <th>
            <div class="text-center">TAHUN</div>     
        </th>
        <th>
            <div class="text-center">BULAN</div>     
        </th>
        <th>
            <div class="text-center">AWAL</div>     
        </th>
        <th>
            <div class="text-center">AKHIR</div>
        </th>
    </tr>
  </thead>
  <tbody>
	<?php
    $n = 0;
	foreach($rs as $item){ $n++;
        /*masa kerja*/
        $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
        if($mkbln > 12){
            $thnmkskr = substr($item->mkskr,0,-2)+1;
            $blnmkskr = "0".($mkbln-12);
        }else{
            $thnmkskr = substr($item->mkskr,0,-2);
            $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
        }

      $tmtmulaiawal_pppk = new \Datetime($item->tmtmulaiawal_pppk);
      $tmtmulaiakhir_pppk = new \Datetime($item->tmtmulaiakhir_pppk);
      $tmtakhirakhir_pppk = new \Datetime($item->tmtakhirakhir_pppk);
      $tahun_penjagaan = ($item->selisih_tahun > Input::get('tahunperpanjangan'))?Input::get('tahunperpanjangan'):$item->selisih_tahun;
    //   $tmtakhir_pppk = ($tahun_penjagaan > 0)?date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.$tahun_penjagaan.' year -1 day')):date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.$item->selisih_bulankerja.' month -1 day'));
        $tmtakhir_pppk = '';
        if($tahun_penjagaan >= 5){
            $tmtakhir_pppk = date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.$tahun_penjagaan.' year -1 day'));
        }else{ 
            if($item->selisih_bulankerja >= 12){
                if($item->selisih_bulankerja > 12){
                    $tmtakhir_pppk = date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.($tahun_penjagaan + 1).' year -1 day'));
                }else{
                    $tmtakhir_pppk = date('d-m-Y', strtotime($tmtmulai_pppk. ' -1 day'));                    
                }                
            }else if($item->selisih_bulankerja > 0){
                $tmtakhir_pppk = date('d-m-Y', strtotime($tmtmulai_pppk. ' + 1 year -1 day'));
            }else{
                $tmtakhir_pppk = date('d-m-Y', strtotime($item->pensiunnext. ' -1 day'));
            }
        }
      $pensiunnext = new \Datetime($item->pensiunnext);
      $format = 'd-m-Y';

      //PERHITUNGAN JARAK AKHIR KONTRAK DENGAN PENSIUN     
      $hasil = date_diff($pensiunnext,$tmtakhirakhir_pppk);
	?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td>
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
            <small>TMT Pensiun : {!!$pensiunnext->format($format)!!}</small>
        </td>
        <td align="center">
            <div class="text-center">{!!fnip($item->nip)!!}</div>
            {{-- <div class="text-center">{!!$item->nokarpeg!!}</div> --}}
        </td>
        <td align="center">
            <div class="text-center">{!!$item->golru_p3k!!}</div>
            {{-- <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div> --}}
        </td>
        <!--<td align="center">
            <div class="text-center">{!!$item->esl!!}</div>
            <div class="text-center">{!!($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):''!!}</div>
        </td>-->
        <td>
            <small>
                <div class="text-left">{!!ucwords($item->jabatan)!!}</div>
                <div class="text-left"><i>Pada</i></div>
                <div class="text-left">{!!ucwords($item->path)!!}</div>
                <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
            </small>
        </td>
        {{-- <td align="center">
            <div class="text-center">{!!$item->mkthnpkt!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->mkblnpkt!!}</div>
        </td> --}}
        <td align="center">
            <div class="text-center">{!!$thnmkskr!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$blnmkskr!!}</div>
        </td>        
        <td>
            <div class="text-left">{!!ucwords($item->jenjurusan)!!}</div>
            <div class="text-left">{!!$item->thijaz!!}</div>
        </td>
        <td align="center">
            {{-- <div class="text-center">{!!$item->agama!!}</div> --}}
            <div class="text-center">{!!substr($item->usia,0,2)!!} thn {!!substr($item->usia,2,2)!!} bln</div>
        </td>
        <td align="center">
            <div class="text-center">{!!($item->tmtmulaiawal_pppk!='0000-00-00')?$tmtmulaiawal_pppk->format($format):''!!}</div>          
        </td>
        <td align="center">
            <div class="text-center">{!!($item->tmtmulaiakhir_pppk!='0000-00-00')?$tmtmulaiakhir_pppk->format($format):''!!}</div>          
        </td>
        <td align="center">
            <div class="text-center">{!!($item->tmtakhirakhir_pppk!='0000-00-00')?$tmtakhirakhir_pppk->format($format):''!!}</div>            
        </td>        
        <td align="center">
            <div class="text-center">{!!$hasil->y!!} Tahun {!!($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja!!} Bulan</div>
            <?php 
                // echo "<pre>";
                //     print_r($hasil);
                // echo "</td>";
            ?>
        </td>
        @if($item->selisih_bulankerja>0)
            <td align="center">
                @if($tahun_penjagaan >= 5)
                    {!!$tahun_penjagaan!!}
                @else 
                    @if($item->selisih_bulankerja >= 12)
                        @if($item->selisih_bulankerja > 12)
                            {!!$tahun_penjagaan + 1!!}
                        @else
                            {!!$tahun_penjagaan!!}
                        @endif
                    @elseif($item->selisih_bulankerja > 0)
                        1
                    @else
                        0
                    @endif
                @endif 
            </td>
            <td align="center">                
                @if($tahun_penjagaan >= 5)
                    0
                @else 
                    @if($item->selisih_bulankerja >= 12)
                        0
                    @elseif($item->selisih_bulankerja > 0)
                        0
                    @else
                        0
                    @endif
                @endif 
            </td>
            <td align="center">
                <div class="text-center">{!!$tmtmulai_pppk!!}</div>          
            </td>
            <td align="center">
                <div class="text-center">{!!$tmtakhir_pppk!!}</div>            
            </td>
        @else
        <td colspan="4" width="10%">Diusulkan untuk pemberhentian Batas Usia Pensiun</td>
        @endif
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
