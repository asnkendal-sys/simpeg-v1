<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Surat Pengantar Permohonan Pensiun</title>
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
            font-size: 12pt;
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
    $item = \NominatifpensiunModel::getDatapengantar($tmtpens, $idskpdpens);
    // dd($item[0]->jenpens);
    $rstemplate = (\NominatifpensiunModel::getTemplatesk($idskpdpens,5) == '0')?'<div align="center"><b>Perhatian!</b> Template Pengantar OPD Belum tersedia.<br><em>"Silahkan buat template pada menu Template Pengantar OPD."</em></div>':\NominatifpensiunModel::getTemplatesk($idskpdpens,5);
    // dd($idskpdpens); exit();
    if(count($item) < 1){
        echo "404 Not Found.";
        exit();
    }
    
    $arrsearch = array("search","[no_sp]","[dkk]","[nama_opd]","[nama_pns]","[nip]","[berkas_sp]","[jenpens]","[tgl_surat]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
        "[nip_penetap]");
    $arrreplace = array("replace",$item[0]->no_sp,(($item[0]->berkas_sp>1)?'dkk.':''),ucword(getSkpdgroup($idskpdpens)),$item[0]->namalengkap,$item[0]->nip,$item[0]->berkas_sp,$item[0]->jenpens,formatTanggalPanjang($item[0]->tgl_sp),
        $item[0]->jabpen_sp,$item[0]->pejpen_sp,$item[0]->golpen_sp,$item[0]->nippen_sp);
    
    echo str_replace($arrsearch,$arrreplace,$rstemplate);
?>

</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        $("#barcode").JsBarcode("{!!$item[0]->nip!!}",{width:1,height:25});

        $("#qrcode").qrcode({
            size    : 90,
            render  : "image",
            text	: "{!!url().'/digitalsign/'.$item[0]->nip.'/'.$item[0]->tmtpens!!}"
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