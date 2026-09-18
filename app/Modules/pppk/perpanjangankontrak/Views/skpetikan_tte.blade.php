<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Petikan Perpanjangan Kontrak PPPK</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Jakarta");
        $idskpd = substr($idpppk,7,2);

        $item = \PerpanjangankontrakModel::getNominatifver($idpppk, $nip);
        
        if(!count($item)){
            echo "Data Perpanjangan Kontrak tidak ditemukan.";
            exit();
        }
        
        $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();
        $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',7)->first();

        $arrsearch = array("search",
                "[nosk_keputusan]",
                "[no_urut]",
                "[unit_kerja]",
                "[namalengkap_sekda]",
                '[nip_sekda]',
                "[pangkat_sekda]",
                "[golongan_sekda]",
                "[jabatan_sekda]",                
                "[namalengkap_bkpp]",
                '[nip_bkpp]',
                "[pangkat_bkpp]",
                "[golongan_bkpp]",
                "[jabatan_bkpp]",
                "[tglsurat]",
                "[tmtawal]",
                "[tmtakhir]",
                "[namalengkap]",
                "[tmlhr]",
                "[tglhr]",
                "[jenkel]",
                "[nip]",
                "[tkpendid]",
                "[pangkat]",
                "[golongan]",
                "[mkgolthn]",
                "[mkgolbln]",
                "[gaji]",
                "[qrcode]",
                "[tglsk_keputusan]",
                "[tahun]",
                "[jabatan]",
                "[unitkerja]",
                "[skpdbaru]",
                "[bupati]",
                "[copyright]",
                "[logo_tte]",
                "[logo_garuda]",
                "[kepala_unitkerja]",
                );
        $arrreplace = array("replace",
            (($item->nosk!='')?$item->nosk:'813/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),
            $item->no_urut,//$i,
            getSkpd($item->kdunit),
            $item->kepalasekda,
            $item->nipsekda,
            $item->pangkatsekda,
            empty($sekda)?'':$sekda->golongan,            
            strtoupper($item->jabkepalasekda),
            $item->kepalabkd,
            $item->nipkepalabkd,
            $item->pangkatbkd,
            $sekda->golrubkd,            
            strtoupper($item->jabkepalabkd),
            formatTanggalPanjang($item->tgsk),
            formatTanggalPanjang($item->tmtawal),
            formatTanggalPanjang($item->tmtakhir),
            $item->nama,
            ucword($item->tmlhr),
            formatTanggalPanjang($item->tglhr),
            ((substr($item->nip, 14, 1) == 1)?'Pria': 'Wanita'),
            $item->nip,
            ucword($item->jenjurusan),
            $item->pangkat,
            $item->golru,
            $item->thkerja,
            $item->blkerja,
            "Rp. ".uang($item->gaji),
            '<div class="qrcode" recid='.$item->id.'></div>',
            formatTanggalPanjang($item->tgsk),
            date('Y', strtotime($item->tgsk)),
            ucword($item->jab),
            ucword($item->skpd),
            ucword($item->skpd),
            $item->bupati,
            '',
            base_path().'/packages/tte/logo.png',
            base_path().'/packages/tugumuda/img/garuda.jpg',
            getKepskpd($item->kdunit,'jab'),
        );

        echo str_replace($arrsearch,$arrreplace,$template->template);
    ?>
</body>
</html>