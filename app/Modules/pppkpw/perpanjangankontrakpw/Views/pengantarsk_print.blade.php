<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar</title>
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
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }        

        function cetakSurat($item = null, $i=0, $kode = null){            
            $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();

            $template = \App\Models\PPPKPW\TemplateSurat::where('jnssurat','=',6)->where('idskpd','=',$kode)->first();
            $key = \TemplateluarkabupatenModel::rand_char();
            $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";

            $arrsearch = array("search",
                "[tgl_surat]",
                "[no_sp]",
                "[berkas_sp]",
                "[hurufberkas_sp]",
                "[status_kontrak]",
                '[nama_opd]',
                "[nama_pns]",
                "[jab_penetap]",
                "[nama_pejabat]",
                "[pangkat_penetap]",
                "[nip_penetap]",                
                );
            $arrreplace = array("replace",                
                formatTanggalPanjang($item[0]->tgl_skpengantar),
                $item[0]->nosk_pengantar,
                count($item),
                terbilang(count($item)),
                ($item[0]->sts_kontrak == 2)?'Perpanjangan':'Pemberhentian',
                getKepskpd($kode, 'skpd'),
                $item[0]->nama,
                strtoupper($item[0]->jabpen_sp), //strtoupper(getKepskpd($kode, 'jab')),
                $item[0]->pejpen_sp, //getKepskpd($kode, 'nama'),
                $item[0]->golpen_sp, //getKepskpd($kode, 'pangkat'),
                $item[0]->nippen_sp, //getKepskpd($kode, 'nip'),
            );

            
            if($template){
                echo str_replace($arrsearch,$arrreplace,$template->template);
            }else{

                echo "<div align='center'>";
                echo "Template Surat Pengantar belum tersedia<br>";
                echo "Silahkan update template surat pengantar melalui menu Template Surat.";
                echo "</div>";
                exit();
            }       
            
            // print_r($kode);
        }
        
        cetakSurat($item, 1, $kode);
        
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
