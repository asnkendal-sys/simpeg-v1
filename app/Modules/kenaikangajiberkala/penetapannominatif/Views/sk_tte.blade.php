<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Kenaikan Gaji Berkala</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        //$jnskgb = \Request::segment(4);
        //$nip = \Request::segment(5);
        //$idkgb = \Request::segment(6);
        $idskpd = substr($idkgb,7,2);

        $item = \PenetapannominatifModel::getNominatifver($idkgb, $nip);

        if(!count($item)){
            echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
            exit();
        }

        if($item->idstspeg == 3){//p3k
            $rstemplate = \PenetapannominatifModel::getTemplateskp3k('all',6);
        
            $arrsearch = array("search","[noskkgbb]","[nama]","[nip]","[golpns_txt]","[nmajab]","[tmtmulaiawal_pppk]","[tmtakhirawal_pppk]",
            "[tmtmulaiakhir_pppk]","[tmtakhirakhir_pppk]","[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]",
            "[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]","[mktkgbb]","[mkbkgbb]","[tmtkgbb]","[tglskkgbb]","[jabpenkgbb]",
            "[pejpenkgbb]","[qrcode]","[img_logo]",'[img_logo_tte]');
        }else{
            $rstemplate = \PenetapannominatifModel::getTemplate('all',9);
            $arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
                "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
                "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[copyright]","[skpd]","[qrcode]","[img_logo]",'[img_logo_tte]');
        }

        // $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
        // $tembusan = ucword($rs->jab_utuh);
        
        // $qr_code = '<img src="'.App\Libraries\QRcode::png('Make me into an QrCode!').'">';
        // $qr_code = App\Libraries\QRcode::png(url('').'/digitalsign/'.$item->nip.'/'.$item->idkgb);
        // App\Libraries\QRcode::png(url('').'/digitalsign/'.$item->nip.'/'.$item->idkgb);
        // $qr_code = '<img src="data:image/png;base64, '.base64_encode(App\Libraries\QRcode::png(url('').'/digitalsign/'.$item->nip.'/'.$item->idkgb)).' ">';
        // echo '<img src="'.App\Libraries\QRcode::png(url('').'/digitalsign/'.$item->nip.'/'.$item->idkgbf).'" />';

        if($item->idstspeg == 3){
            $arrreplace = array("replace",$item->noskkgbb,$item->nama,$item->nip,$item->golpns_txt,$item->nmajab,formatTanggalPanjang($item->tmtmulaiawal_pppk),
            formatTanggalPanjang($item->tmtakhirawal_pppk),formatTanggalPanjang($item->tmtmulaiakhir_pppk),formatTanggalPanjang($item->tmtakhirakhir_pppk),
            $item->tmpskpdskr,uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),
            $item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,formatTanggalPanjang($item->tmtkgbb),formatTanggalPanjang($item->tglskkgbb),
            $item->jabpenkgbb,$item->pejpenkgbb,'<div id="qrcode"></div>',base_path().'/packages/tugumuda/img/logo.png',base_path().'/packages/tte/logo.png');
        }else{
            $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,fnip($item->nip),
            ucword($item->tmplahir),formatTanggalPanjang($item->tgllahir),$item->golpnsskr_txt,ucword($item->nmajab),$item->tmpskpdskr." ".(($item->iddiperbantukan != '')?'dipekerjakan pada '.ucword($item->lokdiperbantukan):''),
            uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),$item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,ucword($item->golpns_txt),formatTanggalPanjang($item->tmtkgbb),$item->jabpenkgbb,$item->pejpenkgbb,$item->golrupb,
            fnip($item->nippb),'',ucword(\PenetapannominatifModel::getSkpd($idskpd)),'<div id="qrcode"></div>',base_path().'/packages/tugumuda/img/logo.png',base_path().'/packages/tte/logo.png',);
        }
        
        echo str_replace($arrsearch,$arrreplace,$rstemplate);
    ?>
</body>
</html>