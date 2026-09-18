<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CPPPK</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

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
            echo "404 Not Found.<br>";
            echo "Daftar mutasi tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.<br>";
            exit();
        }

        function cetakSurat($item = null, $i=0){
            $pegawai = $item->pegawai;

            $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',1)->first();
            $key = \TemplateluarkabupatenModel::rand_char();
            $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";

            $arrsearch = array("search",
                "[no_sk]",
                "[no_urut]",
                "[namalengkap]",
                "[tmlhr]",
                "[tglhr]",
                "[nip]",
                "[tkpendid]",
                "[pangkat]",
                "[golongan]",
                "[tmtpkt]",
                "[formasi]",
                "[gaji]",
                "[skpd]",
                "[instansi]",
                "[jablama]",
                "[jabbaru]",
                "[skpdbaru]",
                "[pendidikan]",
                "[jurusan]",
                "[kepalabkd]",
                "[nipbkd]",
                "[tmt]",
                "[jk]",
                "[pangkatkepalabkd]",
                "[qrcode]",
                "[tglmulaiselesai]",
                "[tglsurat]"
                );

            $arrreplace = array("replace",(($item->nosk_pppk!='')?$item->nosk_pppk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),
                $i,//$i cek lagi
                $pegawai->nama_lengkap,
                $pegawai->tmlhr,
                $pegawai->tanggal_lahir,
                $item->nip, #nipbaru
                $pegawai->tkpendid->tkpendid,
                '', #$item->pangkat,
                $item->golrupppk,
                $item->tmtpkt,
                $item->jab,
                uang($item->gaji),
                $item->unit_kerja,
                $item->skpd,
                ucword($item->jabatan." ".
                    NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
                ucword($item->jabatanbaru." ".
                    NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
                ucword($item->skpdbaru),$item->tkpendid,$item->jenjurusan,
                $item->kepalabkd,
                $item->nipkepalabkd,
                $item->tmtakhirawal_pppk,
                $pegawai->jenis_kelamin,
                $item->pangkatbkd,
                '<div class="qrcode" recid='.$item->id.'></div>',
                $item->tmt_awalkontrak.' s/d '.$item->tmt_akhirkontrak,
                $item->tanggal_sk
               );

            echo str_replace($arrsearch,$arrreplace,$template->template);
        }

        $i = 0;
        if($jml>1){
            foreach($item as $it){
                $i++;
                cetakSurat($it, $i);
                if($jml != $i){
                    echo '<div class="pagebreak"> </div>';
                }
            }
        }else{
            cetakSurat($item, 1);
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
                text    : "{!!url().'/dsign/cpppk/' !!}"+$(this).attr('recid')
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