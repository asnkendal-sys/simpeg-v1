<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lampiran Pengantar Persetujuan Mutasi</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style media="all" type="text/css">
        @media print {
            @page {
                size: F4 landscape;
                margin-left: 1.5cm;
                margin-right: 1cm;
                margin-top: 1cm;
                margin-bottom: 1cm;
            }
            .page-break	{ display:block; page-break-before:always; }
        }

        html {
            font-family: 'Arial';
            font-size: 10pt;
            background: white;
            line-height:1.5em;
            padding: 0;
            margin: 0;
        }

        #F4-landscape{
            position: relative;
            width: 300mm;
            margin: auto;
        }
        table {
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            line-height:1.25em;
        }
        .table thead{
            background-color: #ccc !important;
        }
        .table thead > tr > th,
        .table tbody > tr > td{
            border: 1px solid black;
            padding: .4em;
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
            right: 5px;
        }

        div.print:hover{
            opacity:1;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
</head>
<body>
    <div class="print"></div>

    <?php
    $nousul = Request::segment(5);
    $tglusul = Request::segment(6);

    $where = " (tr_mutasi_masuk_daerah.statususul = 1 or tr_mutasi_masuk_daerah.statussk = 1) ";


    if($nousul!="") $where.= " and tr_mutasi_masuk_daerah.nousul = \"".$nousul."\"";

    $getdata = \DB::table('tr_mutasi_masuk_daerah')
            ->select('tr_mutasi_masuk_daerah.*','a_golruang.pangkat','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
            )
            ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
            ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
            ->whereRaw($where);

    $rs = $getdata->get();
    $row = $getdata->first();

    if(count($rs) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar lampiran mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }
    ?>

    <div id="F4-landscape">
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Lampiran</td>
                <td width="2%" align="center">:</td>
                <td colspan="3">Surat Kepala Badan Kepegawaian Daerah Kabupaten Kendal</td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Nomor</td>
                <td width="2%" align="center">:</td>
                <td><?php echo (($row->nosk_persetujuan!='')?$row->nosk_persetujuan:'822.3/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y'))?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Tanggal</td>
                <td align="center">:</td>
                <td><?php echo (($row->tglsk_persetujuan!='0000-00-00')?formatTanggalPanjang($row->tglsk_persetujuan):formatTanggalPanjang(date('Y-m-d')))?></td>
            </tr>
        </table>
        <br>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
            <tr>
                <th rowspan="2" width="2%">NO</th>
                <th rowspan="2" width="20%">NAMA / NIP</th>
                <th rowspan="2" width="15%">TEMPAT TGL LAHIR</th>
                <th rowspan="2" width="15%">PANGKAT GOL. RUANG</th>
                <th colspan="2" width="30%">UNIT KERJA DAN JABATAN</th>
                <th rowspan="2" width="15%">KETERANGAN</th>
            </tr>
            <tr>
                <th width="15%">LAMA</th>
                <th width="15%">BARU</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td align="center"><b><i>1</i></b></td>
                <td align="center"><b><i>2</i></b></td>
                <td align="center"><b><i>3</i></b></td>
                <td align="center"><b><i>4</i></b></td>
                <td align="center"><b><i>5</i></b></td>
                <td align="center"><b><i>6</i></b></td>
                <td align="center"><b><i>7</i></b></td>
            </tr>
            <?php
                $i=0;
                foreach($rs as $item){
                    $i++;
            ?>
            <tr>
                <td><div align="center">{!!$i!!}.</div></td>
                <td>{!! $item->namalengkap!!}<br>{!! fnip($item->nip) !!}</td>
                <td>{!! ucword($item->tmlhr) !!}, {!! date("d-m-Y", strtotime($item->tglhr)) !!}</td>
                <td>{!! ucword($item->pangkat)." (".$item->golru.")" !!}</td>
                <td>{!! ucword($item->jabatanlama) !!} Pada {!! ucword($item->instansi) !!}</td>
                <td>{!! ucword($item->jabatan)." ".$item->path_short !!}</td>
                <td>
                    <ol style="list-style-type: lower-alpha; margin: 0px;  padding-left: 1.5em">
                        <li>{!! ucword($item->jenjurusan) !!}</li>
                        <li>PNSD</li>
                    </ol>
                </td>
            </tr>
            <?php } ?>

            </tbody>
        </table>
        <br>

        <table border="0" cellpadding="0" width="100%">
            <tbody>
            <tr>
                <td colspan="3" width="50%">
                    &nbsp;</td>
                <td align="center" width="50%">
                    <div style="float: right; width: 50%; margin-right: 1em;">
                        <br>
                        <br />
                        KEPALA BADAN KEPEGAWAIAN DAERAH<br />
                        KABUPATEN KENDAL<br />
                        <br />
                        <br />
                        <br />
                        <u><b>{!! $row->kepalabkd !!}</b></u><br />
                        <b>{!! $row->pangkatbkd !!}</b><br />
                        <b>{!! $row->nipkepalabkd !!}</b><br />
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="vertical-align: middle;" width="50%">
                    <p>
                        &nbsp;</p>
                </td>
                <td align="right" colspan="1" style="vertical-align:bottom;" width="50%">
                    <em>e-Simpeg Kab. Kendal <?php echo gmdate("d-m-Y H:i", time()+60*60*7) ?></em>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br />

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
