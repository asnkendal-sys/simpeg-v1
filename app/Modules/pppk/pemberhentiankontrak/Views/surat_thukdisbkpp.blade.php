<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Surat Pernyataan Tidak Sedang Hukdis BKD</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: F4 portrait;
                margin-left: 0in;
                margin-right: 0in;
                margin-top: 0in;
                margin-bottom: 0in;
            // margin-bottom: 0.15in;
            }
            .page-break	{ display:block; page-break-before:auto; }
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
        $rs = \PemberhentiankontrakModel::getDatanominatifnip($bup, $idskpd, $nip);
        $rstemplate = (\NominatifpensiunModel::getTemplatesk('all', 3) == '0')?'<div align="center"><b>Perhatian!</b> Template Belum tersedia.<br><em>"Silahkan buat template pada menu Template Tidak Pernah Hukdis."</em></div>':\NominatifpensiunModel::getTemplatesk('all', 3); //ini 3 diganti
        if(count($rs) < 1){
            echo "404 Not Found.";
            exit();
        }

        $jml = count($rs);
        $i = 0;
        foreach($rs as $item){
            $arrsearch = array("search","[no_sk]","[nama_kepala]","[nip_kepala]","[pangkat_kepala]","[golongan_kepala]","[jabatan_kepala]","[nama]","[nip]","[pangkat]","[golongan]",
                "[jabatan]","[skpd]","[nomor_referensi]","[tanggal_referensi]","[tglsurat]","[jabatan_kepala_ybs]","[jabatan_kepala_ttd]","[qrcode]");

            $arrreplace = array("replace",$item->no_hukdis_bkd,$item->kepalabkd,$item->nipkepalabkd,$item->pangkatbkd,$item->golrubkd,$item->jabkepalabkd,$item->nama,$item->nip,'-',$item->golru,
                $item->jab,$item->skpd,$item->no_hukdis_opd,formatTanggalPanjang($item->tgl_hukpid_opd),formatTanggalPanjang($item->tgl_hukpid_bkd),$item->jabpen_hukpid,strtoupper($item->jabkepalabkd),'');

            echo str_replace($arrsearch,$arrreplace,$rstemplate);
    ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#barcode{!!$i!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
            $("#qrcode{!!$i!!}").qrcode({
                size    : 90,
                render  : "image",
                text	: "{!!url().'/digitalsign/'.$item->nip.'/'.$item->bup!!}"
            });
        })
    </script>

    <?php if($i != $jml){?>
    <?php }} ?>
</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        $("#barcode").JsBarcode("{!!$item->nip!!}",{width:1,height:25});

        $("#qrcode").qrcode({
            size    : 90,
            render  : "image",
            text	: "{!!url().'/digitalsign/'.$item->nip.'/'.$item->bup!!}"
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