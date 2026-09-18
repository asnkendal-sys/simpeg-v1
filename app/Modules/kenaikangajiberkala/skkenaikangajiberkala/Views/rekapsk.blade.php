
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>SK Kenaikan Gaji Berkala Kolektif</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: F4 potrait;
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

        $jnskgb = Input::get('jnskgb');
        $idskpd = Input::get('idskpd');
        $tanggal1 = Input::get('tanggal1');
        $tanggal2 = Input::get('tanggal2');

        $where = "jnskgb != ''";
        $where.= (Input::get('jnskgb') != '')?" and a.jnskgb = \"".Input::get('jnskgb')."\"":"";
        $where.= ((Input::get('tanggal1') != '') and (Input::get('tanggal2') != ''))?" and a.tglskkgbb >= \"".tglFormat(Input::get('tanggal1'))."\" and a.tglskkgbb <= \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= ((Input::get('tanggal1') != '') and (Input::get('tanggal2') == ''))?" and a.tglskkgbb = \"".tglFormat(Input::get('tanggal1'))."\"":"";
        $where.= ((Input::get('tanggal1') == '') and (Input::get('tanggal2') != ''))?" and a.tglskkgbb = \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= (Input::get('idskpd') != '')?" and MID(a.idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'":"";

        $rs = \DB::table("tr_kgb as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
            )
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->whereRaw($where)
            ->get();

        if(count($rs) > 0){
            $jml = count($rs);
            $i = 0;
            foreach($rs as $item){
                $i++;
                $arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
                    "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
                    "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[copyright]","[skpd]","[tembusan_skpd]","[qrcode]");

                /*kondisi tembusan untuk sekda dan sekwan*/
                /*if(substr($item->kdskpdskr,0,2) == '01'){
                    if(strlen($item->kdskpdskr) > 8){
                        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,8))->first();
                        $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd(substr($item->kdskpdskr,0,2)));
                    }else{
                        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                        $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd(substr($item->kdskpdskr,0,2)));
                    }
                }else if(substr($item->kdskpdskr, 0, 2) == '02'){
                    if(strlen($item->kdskpdskr) > 5){
                        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,5))->first();
                        $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd(substr($item->kdskpdskr,0,2)));
                    }else{
                        $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                        $tembusan = ucword($rs->skpd)." ".ucword(\PenetapannominatifModel::getSkpd(substr($item->kdskpdskr,0,2)));
                    }
                }else{
                    $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                    $tembusan = "Sekretaris ".ucword($rs->skpd);
                }*/

                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->kdskpdskr,0,2))->first();
                $tembusan = ucword($rs->jab_utuh);

                $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,fnip($item->nip),
                    ucword($item->tmplahir),formatTanggalPanjang($item->tgllahir),$item->golpnsskr_txt,ucword($item->nmajab),$item->tmpskpdskr." ".(($item->iddiperbantukan != '')?'dipekerjakan pada '.ucword($item->lokdiperbantukan):''),
                    uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),$item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
                    $item->mktkgbb,$item->mkbkgbb,ucword($item->golpns_txt),formatTanggalPanjang($item->tmtkgbb),$item->jabpenkgbb,$item->pejpenkgbb,$item->golrupb,
                    fnip($item->nippb),'',ucword(\PenetapannominatifModel::getSkpd($idskpd)),$tembusan,'<div id="qrcode'.$i.'"></div>');

                $rstemplate = (\PenetapannominatifModel::getTemplatesk(substr($item->kdskpdskr,0,2),$jnskgb,$item->golpnsskr) == '0')?'<div align="center"><b>Perhatian!</b> Template SK KGB Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\PenetapannominatifModel::getTemplatesk(substr($item->kdskpdskr,0,2),$jnskgb,$item->golpnsskr);
                /*$rstemplate = (\PenetapannominatifModel::getTemplate(substr($item->kdskpdskr,0,2),$jnskgb) == '0')?'<div align="center"><b>Perhatian!</b> Template SK KGB Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\PenetapannominatifModel::getTemplate(substr($item->kdskpdskr,0,2),$jnskgb);*/

                echo str_replace($arrsearch,$arrreplace,$rstemplate);
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#barcode{!!$i!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
                    $("#qrcode{!!$i!!}").qrcode({
                        size    : 125,
                        render  : "image",
                        text	: "{!!url().'/digitalsign/'.$item->nip.'/'.$item->idkgb!!}"
                    });
                })
            </script>
        <?php
                if($i != $jml){
                    echo '<div class="page-break"></div>';
                }
            }
        }else{
            echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
            exit();
        }

        ?>

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