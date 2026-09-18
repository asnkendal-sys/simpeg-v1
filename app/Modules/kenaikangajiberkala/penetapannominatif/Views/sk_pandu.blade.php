<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head></head>
<body>
    <h1>Test</h1>
=======
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>SK Kenaikan Gaji Berkala</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        *{
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        html {
            font-family: 'Arial';
            font-size: 11pt;
            background: white;
            line-height:1.5;
            padding: 0;
            margin: 0;
        }

        body{
            position: relative;
        }

        table{
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            padding: 0;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        $jnskgb = \Request::segment(4);
        $nip = \Request::segment(5);
        $idkgb = \Request::segment(6);
        $idskpd = substr($idkgb,7,2);

        $item = \PenetapannominatifModel::getNominatifver($idkgb, $nip);

        if(!count($item)){
            echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
            exit();
        }

        $rstemplate = (\PenetapannominatifModel::getTemplatesk($idskpd,$jnskgb,$item->golpnsskr) == '0')?'<div align="center"><b>Perhatian!</b> Template SK KGB Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\PenetapannominatifModel::getTemplatesk($idskpd,$jnskgb,$item->golpnsskr);
        $arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
            "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
            "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[copyright]","[skpd]","[tembusan_skpd]","[qrcode]");

        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
        $tembusan = ucword($rs->jab_utuh);

        $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,fnip($item->nip),
            ucword($item->tmplahir),formatTanggalPanjang($item->tgllahir),$item->golpnsskr_txt,ucword($item->nmajab),$item->tmpskpdskr." ".(($item->iddiperbantukan != '')?'dipekerjakan pada '.ucword($item->lokdiperbantukan):''),
            uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),$item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,ucword($item->golpns_txt),formatTanggalPanjang($item->tmtkgbb),$item->jabpenkgbb,$item->pejpenkgbb,$item->golrupb,
            fnip($item->nippb),'',ucword(\PenetapannominatifModel::getSkpd($idskpd)),$tembusan,'<div id="qrcode"></div>');

        echo str_replace($arrsearch,$arrreplace,$rstemplate);
    ?>

>>>>>>> bd394c9269e6547df9a47a553adf25fad0401a86
</body>
</html>