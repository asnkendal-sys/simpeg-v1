<html>

<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Pegawai Pensiun</title>
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
            $idjenpens = Input::get('idjenpens');
            $idskpd = Input::get('idskpd');
            $bulan1 = Input::get('bulan1');
            $bulan2 = Input::get('bulan2');
            $tahun = Input::get('tahun');     

            $kategoripensiun = \DB::table('a_jenpens')->select('jenpens')->where('idjenpens','=',$idjenpens)->first();

            $where = " tb_01.idjenkedudupeg not in ('21') and tb_01.idjenkedudupeg='99' and tb_01.nip !=''";
        
            if(Input::get('idskpd') != ''){
                $where .= " and tb_01.idskpd like '".Input::get('idskpd')."%' ";
            }else{
                $where .= "";
            }
            
            /* Kondisi Tahun */
            if(Input::get('tahun') != ''){
                $where .= " and YEAR(tb_01.tmtpens)= ".Input::get('tahun')."";
            }

            /* Kondisi Bulan */
            if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
                $where .= " and MONTH(tb_01.tmtpens) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
            }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
                $where .= " and MONTH(tb_01.tmtpens)= ".Input::get('bulan1')."";
            }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
                $where .= " and MONTH(tb_01.tmtpens)= ".Input::get('bulan2')."";
            }

            $datapensiuns = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                    ->where('idjenpens','=',$idjenpens)
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
                    ->get();
        ?>

        <div align="center">
            <h3 align="center">DAFTAR PNS PENSIUN {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'KABUPATEN KENDAL')!!}</h3>
            <h3>KATEGORI {!! strtoupper($kategoripensiun->jenpens) !!}</h3>
            <h3 align="center">
                @if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')) BULAN {!!strtoupper(formatBulan(Input::get('bulan1')))!!}
                - {!!strtoupper(formatBulan(Input::get('bulan2')))!!} @elseif ((Input::get('bulan1') == '') and (Input::get('bulan2')
                != '')) BULAN {!!strtoupper(formatBulan(Input::get('bulan2')))!!} @elseif ((Input::get('bulan1') != '') and (Input::get('bulan2')
                == '')) BULAN {!!strtoupper(formatBulan(Input::get('bulan1')))!!} @endif {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
            </h3>            
        </div><br>
        <table border="1">
            <thead class="bg-primary">
                <tr>
                    <th rowspan="2" width="2%">No</th>
                    <th rowspan="2" width="15%">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                    <th rowspan="2">NIP <br> NIP LAMA <br> NIK</th>
                    <th rowspan="2" width="15%">ALAMAT</th>
                    <th rowspan="2">GOL. <br> TMT</th>
                    <!--<th rowspan="2">ESL</th>-->
                    <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA <br> TMT</th>
                    <th colspan="2">MASA KERJA</th>
                    <th colspan="2">S/D SEKARANG</th>
                    <th colspan="2">PENDIDIKAN TERAKHIR</th>
                    <th rowspan="2" width="5%">AGAMA<br>USIA</th>
                    <th rowspan="2" width="5%">TMT DAN USIA PENSIUN</th>
                </tr>
                <tr>
                    <th>THN</th>
                    <th>BLN</th>
                    <th>THN</th>
                    <th>BLN</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                </tr>
            </thead>
            <tbody>
                <?php $x = 0; ?> 
                @if(count($datapensiuns) > 0) 
                    @foreach ($datapensiuns as $datapensiun)
                        <?php $x++;?>
                        <tr>
                            <td>{!!$x!!}</td>
                            <td>{!!$datapensiun->namalengkap!!} <br> <small>{!!$datapensiun->tmlhr.", ".(($datapensiun->tglhr != '0000-00-00')?date('d-m-Y', strtotime($datapensiun->tglhr)):'-')!!}</small></td>
                            <td>{!!$datapensiun->nip!!} <br> {!!$datapensiun->niplama!!} <br> {!!$datapensiun->noktp!!}</td>
                            <td>{!!$datapensiun->alm!!} {!! ($datapensiun->almrt!='')? 'RT. '.$datapensiun->almrt.'':'' !!} {!! ($datapensiun->almrt!='' && $datapensiun->almrw!='' )? '/':'' !!} {!! ($datapensiun->almrw!='')? 'RW. '.$datapensiun->almrw.'':'' !!} <br/> {!! ($datapensiun->almdesa!='')? 'Desa/Kel. '.$datapensiun->almdesa.'':'' !!} {!! ($datapensiun->almkec!='')? 'Kec. '.$datapensiun->almkec.'':'' !!} {!! ($datapensiun->almkab!='')? 'Kab/Kota. '.$datapensiun->almkab.'':'' !!} <br/> {!! ($datapensiun->almprov!='')? 'Prov. '.$datapensiun->almprov.'':'' !!} {!! ($datapensiun->almkdpos!='')? 'Kode Pos.'.$datapensiun->almkdpos.'':'' !!}</td>
                            <td>{!!$datapensiun->golru!!} <br> {!!(($datapensiun->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($datapensiun->tmtpkt)):'')!!}</td>
                            <!--<td align="center">{!!($datapensiun->esl!='')?$datapensiun->esl:'-'!!}</td>-->
                            <td>{!!strtoupper(($datapensiun->jabatan!='')?$datapensiun->jabatan:'-')." PADA ".(($datapensiun->path_short !='-')?$datapensiun->path_short:'')."
                                <br> ".(($datapensiun->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($datapensiun->tmtjbt)):'')!!}</td>
                            <td align="right">{!!$datapensiun->mkthnpkt!!}</td>
                            <td align="right">{!!$datapensiun->mkblnpkt!!}</td>
                            <td align="right">{!!substr($datapensiun->mkskr,0,-2)!!}</td>
                            <td align="right">{!!substr($datapensiun->mkskr,-2)!!}</td>
                            <td>{!!$datapensiun->tkpendid!!}</td>
                            <td>{!!$datapensiun->jenjurusan!!} - {!!$datapensiun->pensiunnext!!}</td>
                            <td>
                                @if($datapensiun->usia!='') {!!$datapensiun->agama."
                                <br>".substr($datapensiun->usia,0,2)." thn ".substr($datapensiun->usia,2,2)." bln"!!} @else {!!$datapensiun->agama."
                                <br> 0 thn 0 bln"!!} @endif
                            </td>
                            <td align="center">
                                {!!($datapensiun->tmtpens!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($datapensiun->tmtpens))."<br>":''!!}
                                {!!$datapensiun->usiapens!!} thn
                            </td>
                        </tr>
                    @endforeach 
                @else
                    <tr>
                        <td colspan="16">Data tidak ditemukan</td>
                    </tr>
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