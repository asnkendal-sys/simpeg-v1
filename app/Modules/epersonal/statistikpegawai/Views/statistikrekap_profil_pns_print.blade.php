<html>

<head>
  <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Jabatan Struktural Dan Golongan</title>
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
  <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>

</head>

<body>
  <div class="print"></div>
  <div class="page">

    <?php
    if (Input::get('iddata') == '1') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and left(tb_01.idgolrupkt,1)='" . substr(Input::get('idgolru'), 0, 1) . "'";
      $title = "MENURUT GOLONGAN";
      if (Input::get('idjenkel') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel') . "'";
      } else {
        $where .= '';
      }

      if (Input::get('idasn') == '1') {
        if (Input::get('idstspeg') == '2' or Input::get('idstspeg') == '0') {
          $where .= " and tb_01.idstspeg in (1,2)";
        } else {
          $where .= " and tb_01.idstspeg = 'x'";
        }
      } else if (Input::get('idasn') == '2') {
        if (Input::get('idstspeg') != '0') {
          $where .= " and tb_01.idstspeg='" . Input::get('idstspeg') . "'";
        }
      } else {
        if (Input::get('idstspeg') == '0') {
          $where .= " and tb_01.idstspeg in (3,4)";
        } else if (Input::get('idstspeg') == '3') {
          $where .= " and tb_01.idstspeg = 3";
        } else if (Input::get('idstspeg') == '4') {
          $where .= " and tb_01.idstspeg = 4";
        } else {
          $where .= " and tb_01.idstspeg = 'x'";
        }
      }
    } else if (Input::get('iddata') == '2') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and tb_01.idtkpendid='" . Input::get('idtkpendid') . "'";
      $title = "MENURUT JENJANG PENDIDIKAN";
      if (Input::get('idjenkel2') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel2') . "'";
      } else {
        $where .= '';
      }

      if (Input::get('idstspeg') == '2') {
        $where .= " and tb_01.idstspeg in (1,2)";
      } else if (Input::get('idstspeg') == '3') {
        $where .= " and tb_01.idstspeg = 3";
      } else if (Input::get('idstspeg') == '4') {
        $where .= " and tb_01.idstspeg = 4";
      }
    } else if (Input::get('iddata') == '3') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and tb_01.idesljbt='" . Input::get('idesl') . "'";
      $title = "MENURUT JABATAN STRUKTURAL";
      if (Input::get('idjenkel3') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel3') . "'";
      } else {
        $where .= '';
      }
    } else if (Input::get('iddata') == '4') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and tb_01.idjenjab = 2 and LEFT(tb_01.idjabfung,3) = '300'";
      $title = "MENURUT JABATAN FUNGSIONAL TENAGA PENDIDIKAN (GURU)";
      if (Input::get('idjenkel4') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel4') . "'";
        if (Input::get('idissek') != '') {
          $where .= " and a_skpd.issek='" . Input::get('idissek') . "'";
        }
      } else {
        $where .= '';
        if (Input::get('idissek') != '') {
          $where .= " and a_skpd.issek='" . Input::get('idissek') . "'";
        }
      }
    } else if (Input::get('iddata') == '5') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and tb_01.idjenjab = 2 and a_jabfung.isguru = '2'";
      $title = "MENURUT JABATAN FUNGSIONAL TENAGA KESEHATAN";
      if (Input::get('idjenkel5') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel5') . "'";
        if (Input::get('idtingkat') != '') {
          $where .= " and a_jabfung.tingkat='" . Input::get('idtingkat') . "'";
        }
      } else {
        $where .= '';
        if (Input::get('idtingkat') != '') {
          $where .= " and a_jabfung.tingkat='" . Input::get('idtingkat') . "'";
        }
      }
    } else if (Input::get('iddata') == '6') {
      $where = " tb_01.idjenkedudupeg not in (99,21) and tb_01.idjenjab = 2 and a_jabfung.isguru = '3'";
      $title = "MENURUT JABATAN FUNGSIONAL TENAGA TEKNIS";
      if (Input::get('idjenkel6') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel6') . "'";
        if (Input::get('idtingkat2') != '') {
          $where .= " and a_jabfung.tingkat='" . Input::get('idtingkat2') . "'";
        }
      } else {
        $where .= '';
        if (Input::get('idtingkat2') != '') {
          $where .= " and a_jabfung.tingkat='" . Input::get('idtingkat2') . "'";
        }
      }
    } else if (Input::get('iddata') == '7') {
      $where = " tb_01.idjenkedudupeg not in (99,21)";
      $title = "MENURUT DIKLAT STRUKTURAL";
      if (Input::get('iddikstru') != '0') {
        $where .= " and tb_01.iddikstru='" . Input::get('iddikstru') . "'";
      } else {
        $where .= " and tb_01.iddikstru=''";
      }
    } else if (Input::get('iddata') == '8') {
      $where = " tb_01.idjenkedudupeg not in (99,21)";
      $title = "MENURUT JENIS KELAMIN";
      if (Input::get('idjenkel7') != '0') {
        $where .= " and tb_01.idjenkel='" . Input::get('idjenkel7') . "'";
      } else {
        $where .= "";
      }
    } else if (Input::get('iddata') == '9') {
      $where = " tb_01.idjenkedudupeg not in (99,21)";
      $title = "MENURUT UMUR / USIA";
      if (Input::get('kategoriumur') == '1') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '1800'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '2100'";
      } else if (Input::get('kategoriumur') == '2') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '2100'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '2600'";
      } else if (Input::get('kategoriumur') == '3') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '2600'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '3100'";
      } else if (Input::get('kategoriumur') == '4') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '3100'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '3600'";
      } else if (Input::get('kategoriumur') == '5') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '3600'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '4100'";
      } else if (Input::get('kategoriumur') == '6') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '4100'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '4600'";
      } else if (Input::get('kategoriumur') == '7') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '4600'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '5100'";
      } else if (Input::get('kategoriumur') == '8') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '5100'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '5600'";
      } else if (Input::get('kategoriumur') == '9') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '5600'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 < '6100'";
      } else if (Input::get('kategoriumur') == '10') {
        $where .= " and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 >= '6100'
                    and DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 <= '10000'";
      } else {
        $where .= "";
      }
    } else if (Input::get('iddata') == '10') {
      $where = " tb_01.idjenkedudupeg not in ('21') and tb_01.idjenkedudupeg = '99'";
      $title = "MENURUT PENSIUN PNS";
      if (Input::get('idjenjab') >= '4') {
        $where .= " and tb_01.idjenjab>='" . Input::get('idjenjab') . "'";
      } else if (Input::get('idjenjab') == '2') {
        $where .= " and tb_01.idjenjab='" . Input::get('idjenjab') . "'";
      } else if (Input::get('idjenjab') == '3') {
        $where .= " and tb_01.idjenjab='" . Input::get('idjenjab') . "'";
      } else {
        $where .= "";
      }
    }


    $rs = \DB::table('tb_01')
      ->select(
        'tb_01.*',
        'a_golruang.golru',
        'a_golruang.golru_p3k',
        'a_skpd.path_short',
        'a_esl.esl',
        'a_tkpendid.tkpendid',
        'a_jenjurusan.jenjurusan',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        'a_jenkel.jenkel',
        'a_agama.agama',
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
      ->orderBy('tb_01.idgolrupkt', 'desc')
      ->orderBy('tb_01.tmtpkt', 'asc');
    ?>

    <div align="center">
      <h3>PROFIL PEGAWAI NEGERI SIPIL PEMERINTAH KABUPATEN KENDAL PERIODE - {{strtoupper(formatBulan(date('m')))}} {{ date('Y')}}</h3></br>
      <h3>{{$title}}</h3>
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
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <small>
              <div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div>
            </small>
          </td>
          <td align="center">
            <div class="text-center">{!!fnip($item->nip)!!}</div>
            <div class="text-center">{!!$item->nokarpeg!!}</div>
          </td>
          <td align="center">
            <div class="text-center">{!!(($item->idstspeg > 2)?$item->golru_p3k:$item->golru)!!}</div>
            <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
          </td>
          <td align="center">
            <div class="text-center">{!!($item->esl!='')?$item->esl:'-'!!}</div>
          </td>
          <td>
            <small>
              <div class="text-left">{!!$item->jabatan!!}</div>
              <div class="text-left"><i>Pada</i></div>
              <div class="text-left">{!!$item->path_short!!}</div>
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
        <tr>
          <td colspan="12">Daftar Pegawai tidak tersedia.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>

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