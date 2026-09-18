<?php
    $where = " tb_01.idjenkedudupeg not in('99','21')";

    /* Kondisi golongan */
    if(Input::get('opt') == ''){
        $where .= " and tb_01.idgolrupkt = '".Input::get('idgolru')."'";
    }else if(Input::get('opt') != ''){
        if(Input::get('opt') == '1'){
            $where .= " and tb_01.idgolrupkt > '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '2'){
            $where .= " and tb_01.idgolrupkt < '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '3'){
            $where .= " and tb_01.idgolrupkt between '".Input::get('idgolru')."' and '".Input::get('idgolru2')."'";
        }
    }

    /* Kondisi eselon */
    if(Input::get('idesl') != ''){
        $where .= " and tb_01.idesljbt = '".Input::get('idesl')."'";
    }

    /* Kondisi jenjang kedudukan pegawai */
    if(Input::get('idjenkedudupeg') != ''){
        $where .= " and tb_01.idjenkedudupeg = '".Input::get('idjenkedudupeg')."'";
    }

    /* Kondisi diklat */
    if(Input::get('iddikstru') != ''){
        $where .= " and tb_01.iddikstru = '".Input::get('iddikstru')."'";
    }

    /* Kondisi jenis kelamin */
    if(Input::get('idjenkel') != ''){
        $where .= " and tb_01.idjenkel = '".Input::get('idjenkel')."'";
    }

    /* Kondisi agama */
    if(Input::get('idagama') != ''){
        $where .= " and tb_01.idagama = '".Input::get('idagama')."'";
    }

    /* Kondisi pendidikan */
    if(Input::get('idtkpendid') != ''){
        $where .= " and tb_01.idtkpendid = '".Input::get('idtkpendid')."'";
    }

    /* Kondisi jenis jabatan */
    if(Input::get('idjenjab') != ''){
        $where .= " and tb_01.idjenjab = '".Input::get('idjenjab')."'";

        if(Input::get('idjenjab') == 2){
            /*Kondisi jika jabatan fungsional umum*/
            if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }else if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') == '')){
                $where .= " and tb_01.idjabfung like '".Input::get('idtkjabfung')."%'";
            }else if((Input::get('idtkjabfung') == '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }
        }else if(Input::get('idjenjab') == 3){
            /*Kondisi jika jabatan fungsional tertentu*/
            if(Input::get('idjabfungum') != ''){
                $where .= " and tb_01.idjabfungum = '".Input::get('idjabfungum')."'";
            }
        }
    }

    /* Kondisi status pegawai */
    if(Input::get('idstspeg') != ''){
        $where .= " and tb_01.idstspeg = '".Input::get('idstspeg')."'";
    }

    /* Kondisi skpd atau unit kerja */
    switch(Input::get('idskpd')){
        case "":
            $where .= " ";
            break;
        default:
            $where .= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
            break;
    }

    /* Kondisi urut data */
    $order = (Input::get('order')=='')?'':Input::get('order');
    switch(Input::get('urutan')){
        case "1":
            $urutan = "tb_01.idgolrupkt $order, tmtpkt, tb_01.iddikstru, tb_01.nama";
            break;
        case "2":
            $urutan = "tb_01.nip $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        case "3":
            $urutan = "tb_01.nama $order, tb_01.idgolrupkt, tmtpkt, tb_01.nip";
            break;
        case "4":
            $urutan = "tb_01.tglhr $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        default:
            $urutan = "tb_01.idgolrupkt $order, tmtpkt, tb_01.nama, tb_01.tglhr";
            break;
    }

    if(Input::get('idjenjab') != '' || Input::get('idskpd') != '')
    {
    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab',
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
        ->whereRaw($where)
        ->orderBy(\DB::raw($urutan))
        ->get();

    }else{
        $rs = [];
    }
    
    $jumdata = count($rs);
?>

<div align="center">
<h4>DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</h4>
<h4>{!!(Input::get('idskpd')!='')?'PADA '.getSkpd(Input::get('idskpd')):''!!}</h4>
</div>
<table border="0" width="100%" class="table table-striped table-hover table-condensed table-bordered">
  <thead class="bg-primary">
    <tr>
        <th><div class="text-center">No</div></th>
        <th><div class="text-left">NAMA</div></th>
        <th><div class="text-center">NIP</div></th>

        @if(Input::get('idagama2') != '')
        <th><div class="text-left">AGAMA</div></th>
        @endif

        @if(Input::get('idjenjab2') != '')
        <th><div class="text-center">JENIS JABATAN</div></th>
        @endif

        @if(Input::get('idesljbt2') != '')
        <th><div class="text-center">ESELON</div></th>
        @endif

        @if(Input::get('idgolrupkt2') != '')
        <th><div class="text-center">GOL.</div></th>
        @endif

        @if(Input::get('tmtpkt2') != '')
        <th><div class="text-center">TMT GOL</div></th>
        @endif

        @if(Input::get('idjenkel2') != '')
        <th><div class="text-left">JENIS KELAMAIN</div></th>
        @endif

        @if(Input::get('idsekolah2') != '')
        <!--<th><div class="text-center">SEKOLAH DASAR</div></th>-->
        @endif

        @if(Input::get('idtkpendid2') != '')
        <th><div class="text-left">TINGKAT PENDIDIKAN</div></th>
        @endif

        @if(Input::get('idjenjurusan2') != '')
        <th><div class="text-left">JURUSAN</div></th>
        @endif

        @if(Input::get('sekolah2') != '')
        <th><div class="text-left">NAMA SEKOLAH</div></th>
        @endif

        @if(Input::get('thijaz2') != '')
        <th><div class="text-left">TAHUN LULUS</div></th>
        @endif

        <th><div class="text-left">JABATAN</div></th>
        <th><div class="text-left">UNIT KERJA</div></th>
        <th><div class="text-left">SUB UNIT KERJA</div></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    if($jumdata != ''){
    $n = 0; 
    ?>
    @foreach ($rs as $item)
    <?php $n++; ?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td><div class="text-left">{!!$item->namalengkap!!}</div></td>
        <td><div class="text-left">{!!$item->nip!!}</div></td>
        <!-- <td><div class="text-left">{!!fnip($item->nip)!!}</div></td> -->

        @if(Input::get('idagama2') != '')
        <td><div class="text-left">{!!$item->agama!!}</div></td>
        @endif

        @if(Input::get('idjenjab2') != '')
        <td><div class="text-center">{!!$item->jenjab!!}</div></td>
        @endif

        @if(Input::get('idesljbt2') != '')
        <td align="center"><div class="text-center">{!!($item->esl!='')?$item->esl:'-'!!}</div></td>
        @endif

        @if(Input::get('idgolrupkt2') != '')
        <td align="center"><div class="text-center">{!!$item->golru!!}</div></td>
        @endif

        @if(Input::get('tmtpkt2') != '')
        <td><div class="text-center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</div></td>
        @endif

        @if(Input::get('idjenkel2') != '')
        <td><div class="text-left">{!!$item->jenkel!!}</div></td>
        @endif

        @if(Input::get('idsekolah2') != '')
        <!--<td><div class="text-center">SEKOLAH DASAR</div></td>-->
        @endif

        @if(Input::get('idtkpendid2') != '')
        <td><div class="text-left">{!!$item->tkpendid!!}</div></td>
        @endif

        @if(Input::get('idjenjurusan2') != '')
        <td><div class="text-left">{!!$item->jenjurusan!!}</div></td>
        @endif

        @if(Input::get('sekolah2') != '')
        <td><div class="text-left">{!!$item->namasekolah!!}</div></td>
        @endif

        @if(Input::get('thijaz2') != '')
        <td><div class="text-left">{!!$item->thijaz!!}</div></td>
        @endif

        <td><div class="text-left">{!!ucwords($item->jabatan)!!}</div></td>
        <td><div class="text-left">{!!ucwords(($item->kdunit!=$item->idskpd)?getSkpd($item->kdunit):getSkpd($item->idskpd))!!}</div></td>
        <td><div class="text-left">{!!ucwords($item->path_short)!!}</div></td>
    </tr>
    @endforeach
    <?php 
    }else 
    {
     ?>
    <tr>
        <td colspan="6"><div class="text-center">Data yang anda cari tidak ditemukan . . .</div></td>
    </tr>
    <?php } ?>
  </tbody> 
</table>