
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
    $tmtmulai_pppk = Input::get('tmtmulaiakhir_pppk');
    $idpppk = Input::get('tahun')."".Input::get('bulan').".".Input::get('idskpd');        	
    $where = "tb_01.nip NOT IN (SELECT nip FROM tr_pppk WHERE idpppk like \"".$idpppk."%\") and tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 3 ";
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
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjabatan'),
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
        ->orderBy(\DB::raw('selisih_tahun asc, tb_01.tglhr, tb_01.idgolrupkt desc, tb_01.nama'))
        ->get();
      //   dd($rs);
?>
<br><div align="center">
<h4>NOMINATIF PERPANJANGAN KONTRAK PEGAWAI PPPK</h4>
<h4>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!((Input::get('bulan') != '')?$titlebulan:'')!!}
    {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h4>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th rowspan="2"><div class="text-center">NO</div></th>
        <th rowspan="2">STATUS<br>PENETAPAN OPD</th> <!-- <input type="checkbox" name="checkall"  id="checkall" checked> -->
        <th rowspan="2">
            <div class="text-left">NAMA</div>
            <div class="text-left">TEMPAT, TGL LAHIR</div>
        </th>
        <th rowspan="2">
            <div class="text-center">NIP</div>
            {{-- <div class="text-center">KARPEG</div> --}}
        </th>
        <th rowspan="2">
            <div class="text-center">GOL.</div>
            <div class="text-center">TMT</div>
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
        <th colspan="2">
            <div class="text-center">MASA KERJA</div>
        </th>
        <!--<th colspan="2">
            <div class="text-center">s/d SEKARANG</div>
        </th>-->
        <!--<th rowspan="2">
            <div class="text-center">DIKLAT STRUKTURAL</div>
            <div class="text-center">TAHUN</div>
        </th>-->
        <th rowspan="2">
            <div class="text-center">PENDIDIKAN TERAKHIR</div>
            <div class="text-center">TAHUN</div>
        </th>
        <th rowspan="2">
            {{-- <div class="text-center">AGAMA</div> --}}
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
        {{-- <th rowspan="2">
            <div class="text-center">BUP</div>
        </th> --}}
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
        <!--<th>
            <div class="text-center">THN</div>
        </th>
        <th>
            <div class="text-center">BLN</div>
        </th>-->
    </tr>
  </thead>
  <tbody>
	<?php
    $n = 0; $perpanjangan = 0; $pemberhentian = 0; $tidakvalid = 0; 
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
        // $tmtakhir_pppk = ($tahun_penjagaan > 0)?date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.$tahun_penjagaan.' year -1 day')):date('d-m-Y', strtotime($tmtmulai_pppk. ' + '.$item->selisih_bulankerja.' month -1 day'));        
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
                $tmtakhir_pppk = date('d-m-Y', strtotime($tmtmulai_pppk. ' +1 year -1 day'));
            }else{
                $tmtakhir_pppk = date('d-m-Y', strtotime($item->pensiunnext. ' -1 day'));
            }
        }
        
        $pensiunnext = new \Datetime($item->pensiunnext);
        $format = 'd-m-Y';

        $class = (($item->nip=='')?'disabled':'pilihnip');
        $disabled = (($item->nip=='')?'disabled':'');

        //PERHITUNGAN JARAK AKHIR KONTRAK DENGAN PENSIUN     
        $hasil = date_diff($pensiunnext,$tmtakhirakhir_pppk);

        // perhitungna sub total            
        if($tahun_penjagaan > 0){
            ($item->idjabatan != '')?$perpanjangan++:0;
        }else{
            if($item->selisih_bulankerja > 0){
                ($item->idjabatan != '')?$perpanjangan++:0;
            }else{
                ($tahun_penjagaan == 0 and $item->idjabatan != '')?$pemberhentian++:0;
                ($item->idjabatan == '')?$tidakvalid++:0;
            }
        }
	?>
    <tr>
        <td align="center">{!!$n!!}.</td>        
        <td class="text-center" width="13%">
            {{-- <input type="checkbox" name="nip[{!!$n!!}]" value="{!!$item->nip!!}" class="{!!$class!!}" {!!$disabled!!} {!!(($item->idjabatan!='')?'checked':'disabled')!!} data-toggle="tooltip" data-placement="right" data-original-title="Pilih Ditetapkan"> --}}            
            <input type="hidden" name="nip[{!!$n!!}]" value="{!!$item->nip!!}" class="{!!$class!!}">
            {{-- <label class="radio-inline"> --}}
                <input type="radio" class="status{!!$n!!} validate[required]" name="status[{!!$item->nip!!}]" value="1" recnip="{!!$item->nip!!}" data-toggle="tooltip" data-placement="top" data-original-title="Setujui Diusulkan"> Disulkan
            {{-- </label> --}}
            
            {{-- <label class="radio-inline"> --}}
                <input type="radio" class="status{!!$n!!} validate[required]" name="status[{!!$item->nip!!}]" value="2" recnip="{!!$item->nip!!}" data-toggle="tooltip" data-placement="top" data-original-title="Tidak Diusulkan"> Tidak
            {{-- </label><br>             --}}
            <span class="xstatus_keterangan{!!$n!!}"><textarea rows="4" cols="6" name="status_keterangan[{!!$item->nip!!}]" id="status_keterangan{!!$n!!}" class="form-control status_keterangan{!!$n!!}" placeholder="Keterangan Jika Tidak Diusulkan" ></textarea></span>
        </td>        
        <td width="13%">
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
            <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
        </td>
        <!--<td align="center">
            <div class="text-center">{!!$item->esl!!}</div>
            <div class="text-center">{!!($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):''!!}</div>
        </td>-->
        <td>
            <small>
                <div class="text-left">{!!($item->jabatan!='')?ucwords($item->jabatan):'-'!!}</div>
                <div class="text-left"><i>Pada</i></div>
                <div class="text-left">{!!ucwords($item->path)!!}</div>
                <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
            </small>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->mkthnakhir_pppk!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->mkblnakhir_pppk!!}</div>
        </td>
        <!--<td align="center">
            <div class="text-center">{!!$thnmkskr!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$blnmkskr!!}</div>
        </td>-->
        <!--<td>
            <div class="text-left">{!!ucwords($item->dikstru)!!}</div>
            <div class="text-left">{!!((substr($item->tgsel_dikstru,0,4)=='0000')?"":substr($item->tgsel_dikstru,0,4))!!}</div>
        </td>-->
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
        {{-- <td align="center">
            <div class="text-center">{!!($item->pensiunnext!='0000-00-00')?$pensiunnext->format($format):''!!}</div>            
        </td> --}}
        <td align="center">
            <div class="text-center">{!!$hasil->y!!} Tahun {!!($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja!!} Bulan</div>            
        </td>
    </tr>
    <tr>
        <td colspan="15">
            <table border="1" rules="rows" style="background: {!!(($tahun_penjagaan>0)?'#ececec':(($item->selisih_bulankerja>0)?'#90ee90':'#FAFAD2'))!!}">
                <tr>                    
                    <td class="text-center" rowspan="2" valign="middle" width="30%">
                        <b>
                            @if($tahun_penjagaan >= 5)
                                ATRIBUT PERPANJANGAN KONTRAK PPPK <br> {!!$tahun_penjagaan!!} TAHUN - 0 BULAN
                            @else 
                                @if($item->selisih_bulankerja >= 12)
                                    @if($item->selisih_bulankerja > 12)
                                        ATRIBUT PERPANJANGAN KONTRAK PPPK <br> {!!$tahun_penjagaan + 1!!} TAHUN - 0 BULAN
                                    @else
                                        ATRIBUT PERPANJANGAN KONTRAK PPPK <br> {!!$tahun_penjagaan!!} TAHUN - 0 BULAN
                                    @endif                                    
                                @elseif($item->selisih_bulankerja > 0)
                                    ATRIBUT PERPANJANGAN KONTRAK PPPK <br> 1 TAHUN - 0 BULAN
                                @else
                                    ATRIBUT PEMBERHENTIAN KONTRAK PPPK <br> BATAS USIA PENSIUN
                                @endif
                            @endif                            
                        </b><br>
                        <div class="alert-danger status_berkas{!!$n!!}"></div>
                    </td>
                    <td class="text-center">Golongan</td>
                    <td class="text-center" colspan="4">Masa Kerja</td>
                    <td class="text-center">Gaji PPPK</td>
                    @if($item->selisih_bulankerja > 0)
                    <td class="text-center">Perjanjian Kerja Awal</td>
                    <td class="text-center">Perjanjian Kerja Akhir</td>
                    @else
                    <td class="text-center">TMT Pemberhentian</td>
                    @endif
                    <td rowspan="2" width="5%" valign="middle">
                        <a href="javascript:void(0)" class="btn btn-primary preview{!!$n!!}" recnip="{!!$item->nip!!}" title="Lihat Berkas Layanan">Preview<br>Berkas</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">{!!$item->golru_p3k!!}</td>
                    <td class="text-center">{!!$item->mkthnakhir_pppk + $item->selisih_tahunkerja + 1!!}</td>
                    <td class="text-center">Tahun</td>
                    <td class="text-center">{!!$item->mkblnakhir_pppk!!}</td>
                    <td class="text-center">bulan</td>
                    <td class="text-center">Rp. {!!uang(getGaji($item->idgolruakhir_pppk,(($item->mkthnakhir_pppk + $item->selisih_tahunkerja + 1)),3))!!}</td>
                    @if($item->selisih_bulankerja > 0)
                    <td class="text-center">{!!$tmtmulai_pppk!!}</td>
                    <td class="text-center">{!!$tmtakhir_pppk!!}</td>
                    @else
                    <td class="text-center">{!!$pensiunnext->format($format)!!}</td>
                    @endif
                </tr>
            </table>
        </td>
    </tr>
	<?php } ?>
  </tbody>
</table>

<p>
    <h4 class="text-center">
        &nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i> TOTAL PERPANJANGAN : {!! $perpanjangan !!}
        &nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i> TOTAL PEMBERHENTIAN : {!! $pemberhentian !!}
        &nbsp;&nbsp;&nbsp;<i class="fa fa-dot-circle-o"></i> TOTAL JABATAN TIDAK SESUAI : {!! $tidakvalid !!} 
    </h4>
</p>
<p class="text-center">* Jika jabatan pegawai tidak terisi (-) harap cek kambali biodata pegawai karena jika jabatan kosong (-) sistem tidak dapat mendeteksi masa pensiun pegawai sehingga usulan perpanjangan tidak dapat diproses</p>

<script type="text/javascript">
    $(document).ready(function(){
        var n = {!!$n!!};
        for (let i = 1; i <= n; i++) {            
            $('.xstatus_keterangan'+i).hide();
            $('.status'+i).on('change', function() {
                var nip = $(this).attr('recnip');
                if ($(this).is(':checked')) {
                    let status = $(this).val();                    
                    if(status == 2){
                        $('.status_berkas'+i).html('');
                        $('.xstatus_keterangan'+i).fadeIn();
                        $('#status_keterangan'+i).addClass('validate[required]');
                        // $('#status_keterangan'+i).prop('required', true);
                    }else{                        
                        cekBerkas(nip, i);
                        $('.status_keterangan'+i).val('');
                        $('.xstatus_keterangan'+i).fadeOut();
                        $('#status_keterangan'+i).removeClass('validate[required]');
                        // $('#status_keterangan'+i).prop('required', false);
                    }
                }
            });

            $('.preview'+i).on('click', function() {                
                var nip = $(this).attr('recnip');
                claravel_modal('Preview Berkas Pepanjangan PPPK','Loading...','main_modal2');
                $.ajax({
                    url : '{{url('')}}/pppk/perpanjangankontrak/data/berkas',
                    type : 'post',
                    data : {
                        'nip': nip,
                        'sts_kontrak': 2,
                        '_token': '{!!csrf_token()!!}'
                    },
                    success:function(html){
                        $('#main_modal2 .modal-body').html(html);
                    }
                });
            });
        }
    });

    function cekBerkas(nip, urutan){
        $.ajax({
            url : '{{url('')}}/pppk/perpanjangankontrak/cekberkas',
            type : 'post',
            data : {
                'nip': nip,
                'sts_kontrak': 2,
                '_token': '{!!csrf_token()!!}'
            },
            success:function(html){
                if(html!=''){
                    $('.status'+urutan).prop('checked', false);
                    bootbox.alert('<b>Usulan tidak dapat diproses karena :</b> <br> '+html+' <br> Mohon melengkapi berkas usulan pada E-File - Menu Layanan.');
                    $('.status_berkas'+urutan).html(html);
                }else{
                    $('.status_berkas'+urutan).html('');
                }
            }
        });
    }
</script>