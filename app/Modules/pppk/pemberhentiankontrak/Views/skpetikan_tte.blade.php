<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Petikan Pemberhentian Kontrak PPPK</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Jakarta");
        $idskpd = substr($idpppk,7,2);

        $item = \PemberhentiankontrakModel::getNominatifver($idpppk, $nip);
        
        if(!count($item)){
            echo "Data Pemberhentian Kontrak tidak ditemukan.";
            exit();
        }
        
        $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();
        
        switch ($item->idjenpens) {
            case 1: $jnssurat = 8; break; //bup
            case 3: $jnssurat = 4; break; //aps
            case 5: $jnssurat = 11; break; //diberhentikan / hukdis 
            case 7: $jnssurat = 10; break; //keuzuran
            case 8: $jnssurat = 9; break; //meninggal
            default: $jnssurat = 8; break;
        }        
        $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',$jnssurat)->first();

        $arrsearch = array("search",
                "[nosk_keputusan]",
                "[no_urut]",
                "[unit_kerja]",
                "[no_dasar]",
                "[tgl_dasar]",
                "[tmt_dasar]",
                "[pernjanjian_akhir]",
                "[usia]",
                "[usia_nominal]",
                "[bup]",
                "[tmtpensiun]",
                "[nosk_awal]",
                "[tglsk_awal]",
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
                "[alamat]",
                "[kepala_unitkerja]",
                );

        // $tglpensiun = date('Y', strtotime($item->bup)).date('-m-d', strtotime($item->tglhr));
                
        // $tglhr = new DateTime($item->tglhr);
        // $tglpensiun2 = new DateTime($tglpensiun);
        // $selisih = $tglhr->diff($tglpensiun2);
        // $usia = $selisih->y;

        $birthday = date_create($item->tglhr);
        $today = date_create($item->bup);
        $diff = date_diff($birthday, $today);
        $usia = date_interval_format($diff, "%y");
        
        $interval = new DateInterval('P'.$usia.'Y');
        $tglpensiun = $birthday->add($interval);

        $arrreplace = array("replace",
            (($item->nosk!='')?$item->nosk:'813/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),
            $item->no_urut,//$i,
            getSkpd($item->kdunit),
            $item->no_dasar,
            formatTanggalPanjang($item->tgl_dasar),
            formatTanggalPanjang($item->tmt_dasar),
            formatTanggalPanjang($item->tmtakhirl),
            $usia,
            terbilang($usia),
            formatTanggalPanjang($tglpensiun->format('Y-m-d')),
            formatTanggalPanjang($item->bup),
            $item->nosk_pppk,
            formatTanggalPanjang($item->tglsk_pppk),
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
            $item->tmlhr,
            formatTanggalPanjang($item->tglhr),
            ((substr($item->nip, 14, 1) == 1)?'Pria': 'Wanita'),
            $item->nip,
            $item->jenjurusan,
            $item->pangkat,
            $item->golru,
            $item->thkerja,
            $item->blkerja,
            "Rp. ".uang($item->gaji),
            '<div class="qrcode" recid='.$item->id.'></div>',
            formatTanggalPanjang($item->tgsk),
            date('Y', strtotime($item->tgsk)),
            $item->jab,
            $item->skpd,
            $item->skpd,
            $item->bupati,
            '',
            base_path().'/packages/tte/logo.png',
            base_path().'/packages/tugumuda/img/garuda.jpg',
            $item->alm.(($item->almrt!='')? ' RT. '.$item->almrt.'':'').(($item->almrt!='' && $item->almrw!='' )? ' / ':'').(($item->almrw!='')? ' RW. '.$item->almrw.'':'').(($item->almdesa!='')? ' Desa/Kel. '.$item->almdesa.'':'').(($item->almkec!='')? ' Kec. '.$item->almkec.'':'').(($item->almkab!='')? ' Kab/Kota. '.$item->almkab.'':'').(($item->almprov!='')? ' Prov. '.$item->almprov.'':'').(($item->almkdpos!='')? ' Kode Pos.'.$item->almkdpos.'':''),
            getKepskpd($item->kdunit,'jab'),
        );

        echo str_replace($arrsearch,$arrreplace,$template->template);
    ?>
</body>
</html>