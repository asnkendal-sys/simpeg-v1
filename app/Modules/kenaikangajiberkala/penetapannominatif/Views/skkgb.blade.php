
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>SK Kenaikan Gaji Berkala</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: A4 potrait;
                margin-left: 0in;
                margin-right: 0in;
                margin-top: 0in;
                margin-bottom: 0.15in;
            }
            .page-break	{ display:block; page-break-before:always; }
        }

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

    <div class="print"></div>
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

        if($item->idstspeg == 3){
            $rstemplate = (\PenetapannominatifModel::getTemplateskp3k('all',5) == '0')?'<div align="center"><b>Perhatian!</b> Template SK KGB Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\PenetapannominatifModel::getTemplateskp3k('all',5);
        
            $arrsearch = array("search","[noskkgbb]","[nama]","[nip]","[golpns_txt]","[nmajab]","[tmtmulaiawal_pppk]","[tmtakhirawal_pppk]",
            "[tmtmulaiakhir_pppk]","[tmtakhirakhir_pppk]","[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]",
            "[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]","[mktkgbb]","[mkbkgbb]","[tmtkgbb]","[tglskkgbb]","[jabpenkgbb]",
            "[pejpenkgbb]","[qrcode]","[img_logo]");
        }else{
            $rstemplate = (\PenetapannominatifModel::getTemplatesk($idskpd,$jnskgb,$item->golpnsskr) == '0')?'<div align="center"><b>Perhatian!</b> Template SK KGB Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\PenetapannominatifModel::getTemplatesk($idskpd,$jnskgb,$item->golpnsskr);
            
            $arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
            "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
            "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[copyright]","[skpd]","[tembusan_skpd]","[qrcode]");
        }

        /*kondisi tembusan untuk sekda dan sekwan*/
        /*if(substr($item->kdskpdskr,0,2) == '01'){
            if(strlen($item->kdskpdskr) > 8){
                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,8))->first();
                $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
            }else{
                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
            }
        }else if(substr($item->kdskpdskr, 0, 2) == '02'){
            if(strlen($item->kdskpdskr) > 5){
                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,5))->first();
                $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
            }else{
                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
            }
        }else{
            $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
            $tembusan = "Sekretaris ".ucword($rs->skpd);
        }*/

        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
        $tembusan = ucword($rs->jab_utuh);

        if($item->idstspeg == 3){
            $arrreplace = array("replace",$item->noskkgbb,$item->nama,$item->nip,$item->golpns_txt,$item->nmajab,formatTanggalPanjang($item->tmtmulaiawal_pppk),
            formatTanggalPanjang($item->tmtakhirawal_pppk),formatTanggalPanjang($item->tmtmulaiakhir_pppk),formatTanggalPanjang($item->tmtakhirakhir_pppk),
            $item->tmpskpdskr,uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),
            $item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,formatTanggalPanjang($item->tmtkgbb),formatTanggalPanjang($item->tglskkgbb),
            $item->jabpenkgbb,$item->pejpenkgbb,'<div id="qrcode"></div>',asset('/packages/tugumuda/img/logo.png'));
        }else{
            $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,fnip($item->nip),
            ucword($item->tmplahir),formatTanggalPanjang($item->tgllahir),$item->golpnsskr_txt,ucword($item->nmajab),$item->tmpskpdskr." ".(($item->iddiperbantukan != '')?'dipekerjakan pada '.ucword($item->lokdiperbantukan):''),
            uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),$item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,ucword($item->golpns_txt),formatTanggalPanjang($item->tmtkgbb),$item->jabpenkgbb,$item->pejpenkgbb,$item->golrupb,
            fnip($item->nippb),'',ucword(\PenetapannominatifModel::getSkpd($idskpd)),$tembusan,'<div id="qrcode"></div>');
        }

        echo str_replace($arrsearch,$arrreplace,$rstemplate);
    ?>

</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        $("#barcode").JsBarcode("{!!$item->nip!!}",{width:1,height:25});

        $("#qrcode").qrcode({
            size    : 90,
            render  : "image",
            text	: "{!!url().'/digitalsign/'.$item->nip.'/'.$item->idkgb!!}"
        });

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