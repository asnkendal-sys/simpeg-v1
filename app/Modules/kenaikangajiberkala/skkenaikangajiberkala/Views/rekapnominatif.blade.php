<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Tanda Terima Kenaikan Gaji Berkala</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style media="all" type="text/css">
        @media print {
            @page {
                size: F4 landscape;
                margin-left: 1.5cm;
                margin-right: 1cm;
                margin-top: 1cm;
                margin-bottom: 1cm;
            }

            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        html {
            font-family: 'Arial';
            font-size: 10pt;
            background: white;
            line-height: 1.5em;
            padding: 0;
            margin: 0;
        }

        #F4-landscape {
            position: relative;
            width: 300mm;
            margin: auto;
        }

        table {
            border-collapse: collapse;
        }

        table tbody>tr>td {
            vertical-align: top;
            line-height: 1.25em;
        }

        .table thead {
            background-color: #ccc !important;
        }

        .table thead>tr>th,
        .table tbody>tr>td {
            border: 1px solid black;
            padding: .4em;
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
            right: 5px;
        }

        div.print:hover {
            opacity: 1;
        }

        .subtitle tr {
            border: 1px solid black;
            height: 25px;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
</head>

<body>
    <div class="print"></div>
    <?php
    $jnskgb = Input::get('jnskgb');
    $idskpd = Input::get('idskpd');
    $tanggal1 = Input::get('tanggal1');
    $tanggal2 = Input::get('tanggal2');
    // candra tambahan tmtkgb
    $tmt1 = Input::get('tmt1');
    $tmt2 = Input::get('tmt2');
    // candra tambahan tmtkgb


    $where = "jnskgb != ''";
    $where .= (Input::get('jnskgb') != '') ? " and a.jnskgb = \"" . Input::get('jnskgb') . "\"" : "";
    $where .= ((Input::get('tanggal1') != '') and Input::get('tanggal2') != '') ? " and a.tglskkgbb >= \"" . tglFormat(Input::get('tanggal1')) . "\" and a.tglskkgbb <= \"" . tglFormat(Input::get('tanggal2')) . "\"" : "";
    $where .= ((Input::get('tanggal1') != '') and Input::get('tanggal2') == '') ? " and a.tglskkgbb = \"" . tglFormat(Input::get('tanggal1')) . "\"" : "";
    $where .= ((Input::get('tanggal1') == '') and Input::get('tanggal2') != '') ? " and a.tglskkgbb = \"" . tglFormat(Input::get('tanggal2')) . "\"" : "";
    // candra tambahan tmtkgb
    $where .= ((Input::get('tmt1') != '') and Input::get('tmt2') != '') ? " and a.tmtkgbb >= \"" . tglFormat(Input::get('tmt1')) . "\" and a.tmtkgbb <= \"" . tglFormat(Input::get('tmt2')) . "\"" : "";
    $where .= ((Input::get('tmt1') != '') and Input::get('tmt2') == '') ? " and a.tmtkgbb = \"" . tglFormat(Input::get('tmt1')) . "\"" : "";
    $where .= ((Input::get('tmt1') == '') and Input::get('tmt2') != '') ? " and a.tmtkgbb = \"" . tglFormat(Input::get('tmt2')) . "\"" : "";
    // candra tambahan tmtkgb
    $where .= (Input::get('idskpd') != '') ? " and MID(a.idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'" : "";

    $rs = \DB::table('tr_kgb as a')->whereRaw($where)->get();

    $rsdata4 = \DB::table("tr_kgb as a")
        ->select(
            'a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_")
        )
        ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
        ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
        ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
        ->whereRaw($where . ' and left(a.golpnsskr,1) = 4')
        /*->orderBy(\DB::raw('a.golpnsskr desc, mid(noskkgbb,6,4)'))*/
        ->orderBy('a.noskkgbb', 'asc')
        ->get();

    $rsdata3 = \DB::table("tr_kgb as a")
        ->select(
            'a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_")
        )
        ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
        ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
        ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
        ->whereRaw($where . ' and left(a.golpnsskr,1) = 3')
        /*->orderBy(\DB::raw('a.golpnsskr desc, mid(noskkgbb,6,4)'))*/
        ->orderBy('a.noskkgbb', 'asc')
        ->get();

    $rsdata2 = \DB::table("tr_kgb as a")
        ->select(
            'a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_")
        )
        ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
        ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
        ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
        ->whereRaw($where . ' and left(a.golpnsskr,1) = 2')
        /*->orderBy(\DB::raw('a.golpnsskr desc, mid(noskkgbb,6,4)'))*/
        ->orderBy('a.noskkgbb', 'asc')
        ->get();

    $rsdata1 = \DB::table("tr_kgb as a")
        ->select(
            'a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_")
        )
        ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
        ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
        ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
        ->whereRaw($where . ' and left(a.golpnsskr,1) = 1')
        /*->orderBy(\DB::raw('a.golpnsskr desc, mid(noskkgbb,6,4)'))*/
        ->orderBy('a.noskkgbb', 'asc')
        ->get();


    if (!count($rs)) {
        echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
        exit();
    }
    ?>

    <div class="page-lanscape" id="F4-landscape">
        <table width="100%">
            <tr>
                <td width="10%"><img src="{!!asset('/packages/tugumuda/img/logo.png')!!}"></td>
                <td width="80%">
                    <h2 align="center">DAFTAR PERMOHONAN PROSES KENAIKAN GAJI BERKALA (KGB)</h2>
                </td>
                <td width="10%">&nbsp;</td>
            </tr>
        </table>

        <table class="subtitle" width="100%">
            <tr>
                <td width="10%">Unit Kerja</td>
                <td width="1%"> : </td>
                <td width="89%"></td>
            </tr>
            <tr>
                <td width="10%">Tanggal Cetak</td>
                <td width="1%"> : </td>
                <td width="89%">
                    <?php
                    if (($tanggal1 != '') and ($tanggal2 != '')) {
                        echo $tanggal1 . " sd " . $tanggal2;
                    }

                    if (($tanggal1 != '') and ($tanggal2 == '')) {
                        echo $tanggal1;
                    }

                    if (($tanggal2 == '') and ($tanggal2 != '')) {
                        echo $tanggal2;
                    }
                    ?>
                </td>
            </tr>
            <!-- candra tambahan tmtkgb -->
            <tr>
                <td width="10%">TMT SK</td>
                <td width="1%"> : </td>
                <td width="89%">
                    <?php
                    if (($tmt1 != '') and ($tmt2 != '')) {
                        echo $tmt1 . " sd " . $tmt2;
                    }

                    if (($tmt1 != '') and ($tmt2 == '')) {
                        echo $tmt1;
                    }

                    if (($tmt2 == '') and ($tmt2 != '')) {
                        echo $tmt2;
                    }
                    ?>
                </td>
            </tr>
            <!-- candra tambahan tmtkgb -->
            <tr>
                <td width="10%">Jumlah Data</td>
                <td width="1%"> : </td>
                <td width="89%">{!!count($rs)!!}</td>
            </tr>
        </table><br>

        @if(count($rsdata4) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan IV : {!!count($rsdata4)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th align="center" width="2%">NO</th>
                    <th align="center" width="15%">NAMA / NIP</th>
                    <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                    <th align="center" width="8%">MASA KERJA BARU</th>
                    <th align="center" width="8%">GAJI POKOK BARU</th>
                    <th align="center" width="5%">TMT</th>
                    <th align="center" width="5%">NO SK</th>
                    <th align="center" width="5%">TGL SK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($rsdata4 as $item) {
                    $i = $i + 1;
                ?>
                    <tr>
                        <td rowspan="2">
                            <div align="center"><?php echo $i ?>.</div>
                        </td>
                        <td><?php echo $item->nama ?></td>
                        <td><?php echo ucword($item->nmajab) ?></td>
                        <td rowspan="2"><?php echo $item->mktkgbb ?> tahun <?php echo ($item->mkbkgbb == "00" ? "" : $item->mkbkgbb . " bulan") ?> </td>
                        <td rowspan="2"><?php echo "Rp" . uang($item->gkgbb) ?></td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tmtkgbb_ ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->noskkgbb ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tglskkgbb_ ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo fnip($item->nip) ?></td>
                        <td><?php echo getSkpd($item->kdskpdskr) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata3) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan III : {!!count($rsdata3)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th align="center" width="2%">NO</th>
                    <th align="center" width="15%">NAMA / NIP</th>
                    <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                    <th align="center" width="8%">MASA KERJA BARU</th>
                    <th align="center" width="8%">GAJI POKOK BARU</th>
                    <th align="center" width="5%">TMT</th>
                    <th align="center" width="5%">NO SK</th>
                    <th align="center" width="5%">TGL SK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($rsdata3 as $item) {
                    $i = $i + 1;
                ?>
                    <tr>
                        <td rowspan="2">
                            <div align="center"><?php echo $i ?>.</div>
                        </td>
                        <td><?php echo $item->nama ?></td>
                        <td><?php echo ucword($item->nmajab) ?></td>
                        <td rowspan="2"><?php echo $item->mktkgbb ?> tahun <?php echo ($item->mkbkgbb == "00" ? "" : $item->mkbkgbb . " bulan") ?> </td>
                        <td rowspan="2"><?php echo "Rp" . uang($item->gkgbb) ?></td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tmtkgbb_ ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->noskkgbb ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tglskkgbb_ ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo fnip($item->nip) ?></td>
                        <td><?php echo ucword(getSkpd($item->kdskpdskr)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata2) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan II : {!!count($rsdata2)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th align="center" width="2%">NO</th>
                    <th align="center" width="15%">NAMA / NIP</th>
                    <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                    <th align="center" width="8%">MASA KERJA BARU</th>
                    <th align="center" width="8%">GAJI POKOK BARU</th>
                    <th align="center" width="5%">TMT</th>
                    <th align="center" width="5%">NO SK</th>
                    <th align="center" width="5%">TGL SK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($rsdata2 as $item) {
                    $i = $i + 1;
                ?>
                    <tr>
                        <td rowspan="2">
                            <div align="center"><?php echo $i ?>.</div>
                        </td>
                        <td><?php echo $item->nama ?></td>
                        <td><?php echo ucword($item->nmajab) ?></td>
                        <td rowspan="2"><?php echo $item->mktkgbb ?> tahun <?php echo ($item->mkbkgbb == "00" ? "" : $item->mkbkgbb . " bulan") ?> </td>
                        <td rowspan="2"><?php echo "Rp" . uang($item->gkgbb) ?></td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tmtkgbb_ ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->noskkgbb ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tglskkgbb_ ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo fnip($item->nip) ?></td>
                        <td><?php echo ucword(getSkpd($item->kdskpdskr)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif

        @if(count($rsdata1) > 0)
        <table class="subtitle" width="100%">
            <tr style="border-bottom: none">
                <td width="10%">Jumlah Golongan I : {!!count($rsdata1)!!}</td>
            </tr>
        </table>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th align="center" width="2%">NO</th>
                    <th align="center" width="15%">NAMA / NIP</th>
                    <th align="center" width="30%">JABATAN / UNIT KERJA</th>
                    <th align="center" width="8%">MASA KERJA BARU</th>
                    <th align="center" width="8%">GAJI POKOK BARU</th>
                    <th align="center" width="5%">TMT</th>
                    <th align="center" width="5%">NO SK</th>
                    <th align="center" width="5%">TGL SK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($rsdata1 as $item) {
                    $i = $i + 1;
                ?>
                    <tr>
                        <td rowspan="2">
                            <div align="center"><?php echo $i ?>.</div>
                        </td>
                        <td><?php echo $item->nama ?></td>
                        <td><?php echo ucword($item->nmajab) ?></td>
                        <td rowspan="2"><?php echo $item->mktkgbb ?> tahun <?php echo ($item->mkbkgbb == "00" ? "" : $item->mkbkgbb . " bulan") ?> </td>
                        <td rowspan="2"><?php echo "Rp" . uang($item->gkgbb) ?></td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tmtkgbb_ ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->noskkgbb ?></div>
                        </td>
                        <td rowspan="2">
                            <div align="center"><?php echo $item->tglskkgbb_ ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo fnip($item->nip) ?></td>
                        <td><?php echo ucword(getSkpd($item->kdskpdskr)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table><br>
        @endif
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