
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
	$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
    $having = '';

    /* Kondisi jabatan jabatan*/
    if(Input::get('idjenjab') != ''){
        $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."'";
    }

    /* Kondisi Tahun */
    if(Input::get('tahun') != ''){
        $having .= " YEAR(pensiunnext)= ".Input::get('tahun')."";
    }

    /* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $having .= " AND MONTH(pensiunnext) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1')).' S/D '.formatBulan(Input::get('bulan2'));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $having .= " AND MONTH(pensiunnext)= ".Input::get('bulan1')."";
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1'));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $having .= " AND MONTH(pensiunnext)= ".Input::get('bulan2')."";
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan2'));
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd') != ''){
        $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
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

        $jumdata = count($rs);

       $repo = new \App\Repositories\PpoRepository;
       $srv = new \App\Services\PpoService($repo);
       $pensiuns = $srv->fetch()->slice(0,25);
			
?>
<br><div align="center">
<h4>DAFTAR  PEGAWAI PENSIUN</h4>
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
            <div class="text-center">Lama/Baru</div>
        </th>
        <th rowspan="2">
            <div class="text-center">IDJENKEDUDUPEG</div>

        </th>
        <th rowspan="2">
            <div class="text-center">IDJENPNS</div>
        </th>
        <th rowspan="2">
            <div class="text-center">JABATAN PENETAP PNS</div>

        </th>
        <th colspan="2">
            <div class="text-center">NO SK PENSIUN</div>
        </th>
        <th colspan="2">
            <div class="text-center">TGL SK PENSIUN</div>
        </th>

    </tr>

  </thead>
  <tbody>
    <?php

        if(count($rs) != ''){
    $n = 0;
	foreach($pensiuns as $item){ $n++;

	?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td>

        </td>
        <td align="center">

            <div class="text-center">{{$item["nipBaru"]}}</div>
        </td>
        <td align="center">

        </td>
        <td align="center">

        </td>
        <td>
            <small>

            </small>
        </td>
        <td align="center">

        </td>
        <td align="center">

        </td>
        <td align="center">

        </td>
        <td align="center">

        </td>
        <td>

        </td>
        <td>

        </td>
				<td>

				</td>
				<td>

				</td>
        <td align="center">

        </td>
    </tr>
        <?php
            }} else {
        ?>
            <tr>
                <td align="center" colspan="15"><h4>Data Tidak Ditemukan</h4></td>
            </tr>
        <?php  }

        ?>
  </tbody>
</table>
