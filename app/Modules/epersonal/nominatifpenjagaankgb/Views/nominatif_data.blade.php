
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
    $where = " tb_01.idjenkedudupeg not in('99','21') ";
    $having = "";

    /* Kondisi bulan kgb */
    if(Input::get('bulan') != ''){
        $having .= "MONTH(tmtkgbnext)='".Input::get('bulan')."'";
    }

    /* Kondisi tahun kpr */
    if(Input::get('tahun') != ''){
        $having .= "AND YEAR(tmtkgbnext)='".Input::get('tahun')."'";
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd')!=''){
        //$where .= " and left(tb_01.idskpd,2)='".Input::get('idskpd')."'";
        $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    /* Kondisi status pegawai */
    $idstspeg = Input::get('idstspeg');
    if($idstspeg != ''){
        $x = 0;
        $data = '';
        foreach ($idstspeg as $item) {
            $x++;
            $data .= $item.((count($idstspeg) == $x)?'':',');
        }
        $where.= " and tb_01.idstspeg in (".$data.")";
    }

    $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_golruang.golru_p3k','a_golruang.pangkat','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
            \DB::raw('DATE_ADD(tb_01.tmtkgb, INTERVAL 2 YEAR) AS tmtkgbnext'),
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
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
            \DB::raw("a_golruangcpn.golru as golrucpn,a_golruangcpn.pangkat as pangkatcpn, a_golruangpns.golru as golrupns,a_golruangpns.pangkat as pangkatpns")
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
        ->leftjoin('a_golruang as a_golruangcpn', 'tb_01.idgolrucpn', '=', 'a_golruangcpn.idgolru')
        ->leftjoin('a_golruang as a_golruangpns', 'tb_01.idgolrupns', '=', 'a_golruangpns.idgolru')
        ->whereRaw($where)
        ->havingRaw($having)
        ->orderBy(\DB::raw('tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
        ->get();
?>
<br><div align="center">
    <h4>DAFTAR NOMINATIF KENAIKAN GAJI BERKALA</h4>
    <h4>
        <?php
            echo (Input::get('idskpd')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'');
            echo ' '.strtoupper(formatBulan(Input::get('bulan')));
            echo (Input::get('tahun')!='')?' '.Input::get('tahun'):'';
        ?>
    </h4>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th><div class="text-center">NO</div></th>
        <th>
            <div class="text-center">NAMA</div>
            <div class="text-center">TEMPAT, TGL LAHIR</div>
        </th>
        <th>
            <div class="text-center">NIP</div>
            <div class="text-center">KARPEG</div>
        </th>
        <th>
            <div class="text-center">JABATAN </div>
            <div class="text-center">UNIT KERJA</div>
            <div class="text-center">TMT</div>
        </th>
        <th>
            <div class="text-center">ESELON</div>
            <div class="text-center">TMT</div>
        </th>
        <th>
            <div class="text-center">PANGKAT / GOL. CPNS</div>
            <div class="text-center">TMT</div>
            <div class="text-center">MASA KERJA CPNS</div>
        </th>
        <th>
            <div class="text-center">PANGKAT / GOL. PNS</div>
            <div class="text-center">TMT</div>
        </th>
        <th>
            <div class="text-center">KENAIKAN PANGKAT<br>(GOL. SEKARANG)</div>
            <div class="text-center">TMT</div>
            <div class="text-center">MASA KERJA GOLONGAN</div>
        </th>
        <th>
            <div class="text-center">KGB TERKAHIR</div>
            <div class="text-center">NO. SK KGB</div>
            <div class="text-center">TANGGAL</div>
            <div class="text-center">TMT</div>
            <div class="text-center">MASA KERJA</div>
            <div class="text-center">GAJI</div>
        </th>
        <th>
            <div class="text-center">KGB BARU</div>
            <div class="text-center">TMT</div>
            <div class="text-center">MASA KERJA</div>
            <div class="text-center">GAJI</div>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
        $n = 0;
        foreach($rs as $item){
            /*cek yang ampir pensiun*/
            $date1 = date(strtotime($item->tmtkgbnext));
            $date2 = date(strtotime($item->pensiunnext));
    
            $difference = $date2 - $date1;
            $months = floor($difference / 86400 / 30 );
            if($months > 0){
    
                $n++;
                if($item->tmtpkt > $item->tmtkgb){
                    $thmker = $item->mkthnpkt;
                }else{
                    $thmker = $item->mkgolthnkgb;
                }
    
                if (strlen($thmker)==1) $thmker="0".$thmker;
                $thmker2 = intval($thmker)+2;
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;
    
                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
    
                if(getgaji($item->idgolrupkt,$thmker2) == getgaji($item->idgolrupkt,$thmker)){
                    $style = 'style="background-color:#f3f99a;"';
                }
            ?>
        <tr {!!$style!!}>
            <td align="center">{!!$n!!}.</td>
            <td>
                <div class="text-left">{!!$item->namalengkap!!}</div>
                <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
            </td>
            <td align="center">
                <div class="text-center">{!!fnip($item->nip)!!}</div>
                <div class="text-center">{!!$item->nokarpeg!!}</div>
            </td>
            <td align="center">
                <small>
                    <div class="text-left">{!!$item->jabatan!!}</div>
                    <div class="text-left"><i>Pada</i></div>
                    <div class="text-left">{!!$item->path_short!!}</div>
                    <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
                </small>
            </td>
            <td align="center">
                <div class="text-center">{!!$item->esl!!}</div>
                <div class="text-center">{!!($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):''!!}</div>
            </td>
            <td>
                <small>
                    <div class="text-left">{!!$item->golrucpn." - ".$item->pangkatcpn!!}</div>
                    <div class="text-left">{!!($item->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item->tmtcpn)):''!!}</div>
                    <div class="text-left">{!!$item->mkthncpn." Tahun ".$item->mkblncpn." Bulan"!!}</div>
                </small>
            </td>
            <td>
                <small>
                    <div class="text-left">{!!$item->golrupns." - ".$item->pangkatpns!!}</div>
                    <div class="text-left">{!!($item->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpns)):''!!}</div>
                </small>
            </td>
            <td>
                <small>
                    <div class="text-left">{!!$item->golru." - ".$item->pangkat!!}</div>
                    <div class="text-left">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
                    <div class="text-left">{!!$item->mkthnpkt." Tahun ".$item->mkblnpkt." Bulan"!!}</div>
                </small>
            </td>
            <td>
                <small>
                    <div class="text-left">{!!($item->noskkgb=='')?'&nbsp;':$item->noskkgb!!}</div>
                    <div class="text-left">{!!($item->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgb)):''!!}</div>
                    <div class="text-left">{!!$item->mkgolthnkgb." Tahun ".$item->mkgolblnkgb." Bulan"!!}</div>
                    <div class="text-left">Rp. {!!number_format(getgaji($item->idgolrupkt,$thmker))!!}</div>
                </small>
            </td>
            <td>
                <small>
                    <div class="text-left">&nbsp;</div>
                    <div class="text-left">{!!($item->tmtkgbnext!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgbnext)):''!!}</div>
                    <div class="text-left">{!!$thmker2." Tahun ".$item->mkgolblnkgb." Bulan"!!}</div>
                    <div class="text-left">Rp. {!!number_format(getgaji($item->idgolrupkt,$thmker2))!!}</div>
                </small>
            </td>
        </tr>
    <?php } } ?>
    </tbody>
</table>
