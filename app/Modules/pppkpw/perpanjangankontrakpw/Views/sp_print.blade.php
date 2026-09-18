<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SP</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="bkpsdm">

    <style type="text/css">
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
    .pagebreak { page-break-before: always; }

    div.print:hover{
        opacity:1;
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
        $jml = count($item);
        if($jml < 1){
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }

        function cetakSurat($item = null, $i=0){            
            $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();

            $template = \App\Models\PPPKPW\TemplateSurat::where('jnssurat','=',2)->first();
            $key = \TemplateluarkabupatenModel::rand_char();
            $key_rand = "<em>Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";

            $arrsearch = array("search",
                "[nosk_keputusan]",
                "[no_urut]",
                "[namalengkap_sekda]",
                '[nip_sekda]',
                "[pangkat_sekda]",
                "[golongan_sekda]",
                "[jabatan_sekda]",
                "[tglsurat]",
                "[namalengkap]",
                "[tmlhr]",
                "[tglhr]",
                "[nip]",
                "[tkpendid]",
                "[pangkat]",
                "[golongan]",
                "[qrcode]",
                "[tglsk_keputusan]",
                "[tahun]",
                "[jabatan]",
                "[unitkerja]",
                "[skpdbaru]",
                );
            $arrreplace = array("replace",
                (($item->nosk!='')?$item->nosk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),
                0,//$i,
                $item->kepalasekda,
                $item->nipsekda,
                $item->pangkatsekda,
                empty($sekda)?'':$sekda->golongan,
                $item->jabkepalasekda,
                formatTanggalPanjang($item->tgsk),
                $item->nama,
                $item->tmlhr,
                formatTanggalPanjang($item->tglhr),
                $item->nip,
                $item->jenjurusan,
                $item->pangkat,
                $item->golru, 
                '<div class="qrcode" recid='.$item->id.'></div>',
                formatTanggalPanjang($item->tgsk),
                date('Y', strtotime($item->tgsk)),
                $item->jab,
                $item->skpd,
                $item->skpd,
            );

            echo str_replace($arrsearch,$arrreplace,$template->template);
        }

        $i = 0;
        if($jml>1){
            foreach($item as $it){
                if($it->statususul == 1){
                    $i++;
                    cetakSurat($it, $i);
                    if($jml != $i){
                        echo '<div class="pagebreak"> </div>';
                    }
                }
            }
        }else{            
            if($item[0]->statususul == 1){
                $i++;
                cetakSurat($item[0], 1);
            }
        }

        if($i == 0){
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }
     ?>
</body>
</html>
<script>
    $(document).ready(function(){
        $('.qrcode').each(function() {
            $(this).qrcode({
                size    : 83.149606299,
                render  : "image",
                text    : "{!!url().'/dsign/sp/' !!}"+$(this).attr('recid')
            });
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
