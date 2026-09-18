
<style type='text/css'>
	table {
		font-family: 'Arial';
		font-size: 9pt;
		background: white;
		line-height:1.5;
	}

	table{
	border-collapse:collapse;
	border-width:1px;
	width:100%;
	}

	table thead tr th,table tfoot tr th{
        background-color:#337ab7;
		font-weight:bold;
		padding:4px;
	}

	table tbody tr td{
		padding:4px;
		vertical-align:top;
	}

	table.gen tbody tr td{
		/*height:40px; */
	}

	table tbody td div.r,table tfoot td div.r,table tfoot th div.r{
		text-align:right;
	}
</style>

<?php
	// $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' and tb_01.idstspeg = 3 ";
	$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' and tb_01.idstspeg = 3 ";
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
      if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
                  $where .= " and YEAR(tmtakhirakhir_pppk) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
      }else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
                  $where .= " and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun1')."";
      }else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
                  $where .= " and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
      }

      /* Kondisi Bulan */
      if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
            $titlebulan = ' and BULAN '.strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2')));
      }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')."";
            $titlebulan = ' and BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
      }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')."";
            $titlebulan = ' and BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
      }

      /* Kondisi skpd atau unit kerja */
      if(Input::get('idskpd') != ''){
            $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
      }

    $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
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
        ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
        ->get();
      //   dd($rs);
?>
<br><div align="center">
<h4>DAFTAR NOMINATIF PEGAWAI PPPK HABIS KONTRAK</h4>
<h4>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'')!!}
    {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h4>
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
            <div class="text-center">DIKLAT STRUKTURAL</div>
            <div class="text-center">TAHUN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">PENDIDIKAN TERAKHIR</div>
            <div class="text-center">TAHUN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">AGAMA</div>
            <div class="text-center">USIA</div>
        </th>
        <th rowspan="2">
            <div class="text-center">AWAL PPPK</div>     
        </th>
        <th rowspan="2">
            <div class="text-center">AWAL KONTRAK</div>     
        </th>
        <th rowspan="2">
            <div class="text-center">AKHIR KONTRAK</div>
        </th>
        <th rowspan="2">
            <div class="text-center">BUP</div>
        </th>
        <th rowspan="2">
            <div class="text-center">JARAK AKHIR KONTRAK</div>
            <div class="text-center">DENGAN PENSIUN</div>
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
            <div class="text-center">{!!$item->nokarpeg!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->golru!!}</div>
            <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->esl!!}</div>
            <!--<div class="text-center">{!!($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):''!!}</div>-->
        </td>
        <td>
            <small>
                <div class="text-left">{!!ucwords($item->jabatan)!!}</div>
                <div class="text-left"><i>Pada</i></div>
                <div class="text-left">{!!ucwords($item->path)!!}</div>
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
            <div class="text-center">{!!$thnmkskr!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$blnmkskr!!}</div>
        </td>
        <td>
            <div class="text-left">{!!ucwords($item->dikstru)!!}</div>
            <div class="text-left">{!!((substr($item->tgsel_dikstru,0,4)=='0000')?"":substr($item->tgsel_dikstru,0,4))!!}</div>
        </td>
        <td>
            <div class="text-left">{!!ucwords($item->jenjurusan)!!}</div>
            <div class="text-left">{!!$item->thijaz!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->agama!!}</div>
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
            <div class="text-center">{!!($item->pensiunnext!='0000-00-00')?$pensiunnext->format($format):''!!}</div>            
        </td>
        <td align="center">
            <div class="text-center">{!!$hasil->y!!} Tahun {!!$hasil->m!!} Bulan</div>            
        </td>
    </tr>
	<?php } ?>
  </tbody>
</table>
