<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keputusan Mutasi Perintah</title>
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

    div.print:hover{
        opacity:1;
    }
</style>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
<!-- <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script> -->
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php
    date_default_timezone_set("Asia/Jakarta");

    $template = TemplateskpengantarModel::getTemplate(session('idskpd')!=''?session('idskpd'):'all', '2.8', 'template');
    $where = "(tr_mutasi_dalam_daerah.statususul = 1 or tr_mutasi_dalam_daerah.statussk = 1)";
    $where .= "and tr_mutasi_dalam_daerah.nip =\"".\Request::segment(6)."\" and tr_mutasi_dalam_daerah.nousul = \"".\Request::segment(5)."\"";
    $count = \DB::table("tr_mutasi_dalam_daerah")->whereRaw($where)->count();


    $item = \DB::table('tr_mutasi_dalam_daerah')
    ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','tb_01.tmlhr','tb_01.tglhr',
        \DB::raw('IF(LEFT(skpdlama.idskpd,2)=05 OR LEFT(skpdlama.idskpd,2)=04 OR LEFT(skpdlama.idskpd,2)=26,skpdlama.path,CONCAT(skpdlama.path_short)) as skpdlama'),
        \DB::raw('IF(LEFT(skpdbaru.idskpd,2)=05 OR LEFT(skpdlama.idskpd,2)=04 OR LEFT(skpdlama.idskpd,2)=26,skpdbaru.path,CONCAT(skpdbaru.path_short)) as skpdbaru'),
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
        \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))
    ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
    ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
    ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
    ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
    ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
    ->whereRaw($where)  
    ->first();

    // dd($item);
    // exit();

    if(count($item) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }

    $i = 0;    
    $key = TemplateskpengantarModel::rand_char();    
    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />
    <span class='kode bolditalic'>".$key."</span>";

    if ($item->idskpd=="") {
        $skpd_lama_tampil =  "-";
        $getSkpdgroupjab = "-";
        $tembusanantaropd = getTembusanAntarOPDJikaCPNS($item->idskpdbaru);
    }else{
        $skpd_lama_tampil = ucword($item->skpdlama)." Kabupaten Kendal";
        $getSkpdgroupjab = ucword(getSkpdgroupjab(substr($item->idskpd,0,2)));
        $tembusanantaropd =  getTembusanAntarOPD($item->idskpd,$item->idskpdbaru);
    }

    $arrsearch = array("search","[no_suratrek]","[surat_dari]","[tgl_suratrek]","[perihalrek]","[nosk]","[namalengkap]","[nip]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpdlama]","[jabbaru]",
        "[skpdbaru]","[tgl_sp]","[jurusan]","[tmt]","[tglsurat]","[namasekda]","[pangkatsekda]","[nipsekda]","[kepalabkd]","[pangkatbkd]","[nipbkd]","[bupati]","[tembusan_skpd_baru]","[tembusan_skpd_lama]","[copyright]","[tgl_berlaku]","[dasar2]","[qrcode]","[tembusan]");
    $arrreplace = array("replace",
        $item->no_suratrek,
        $item->surat_dari,
        formatTanggalPanjang($item->tgl_suratrek),
        $item->perihalrek,
        $item->nosk,
        $item->namalengkap,
        fnip($item->nip),
        ucword($item->tmlhr),
        formatTanggalPanjang($item->tglhr),
        ucword($item->pangkat),$item->golru,
        ucword($item->jabatan." ".NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungum)),
        
        $skpd_lama_tampil,
        
        ucword($item->jabatanbaru." ".NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
        $item->skpdbaru,
        formatTanggalPanjang($item->tgl_sp),ucword($item->jenjurusan),
        formatTanggalPanjang($item->tmtpkt),
        formatTanggalPanjang($item->tglsurat),
        $item->kepalasekda,
        $item->pangkatsekda,
        fnip($item->nipsekda),
        $item->kepalabkd,ucword($item->pangkatbkd),fnip($item->nipkepalabkd),$item->bupati,ucword(getSkpdgroupjab($item->idskpdbaru)),

        $getSkpdgroupjab,

        $key_rand,formatTanggalPanjang($item->tmt),
        
        
        (($item->no_suratrek!='')?"<li style='text-align: justify;'>
           <span style='font-size:16px;'><span style='font-family:arial,helvetica,sans-serif;'>
           Surat ".ucword($item->surat_dari)." Kendal Nomor : ".$item->no_suratrek." Tanggal ".formatTanggalPanjang($item->tgl_suratrek)." Perihal : ".$item->perihalrek."</span></li>":'')
        ,'<div id="qrcode"></div>',
        $tembusanantaropd
    );

    echo str_replace($arrsearch,$arrreplace,$template);

    ?>
</body>
</html>
<!-- <li>
    <span style="font-size:16px;"><span style="font-family:arial,helvetica,sans-serif;"><span style="line-height: 14.76px; margin-left: 0px;">[tembusan_uptd]</span>
</span>
</span> -->
</li>
<script>
    $(document).ready(function(){
        $("#qrcode").qrcode({
            render      : "canvas",
            width       : 105.82677165, 
            height      : 105.82677165,
            text        : "{!!url().'/digitalsignature/mutasi/antarskpd/surattugas/'.$item->nousul.'/'.$item->nip!!}",
            src         : "{!!url()!!}/packages/tugumuda/img/logo_qr_terpakai.png"
        });

        // $("#qrcode").qrcode({
        //     render      : "canvas", 
        //     width       : 94.488188976, 
        //     height      : 94.488188976,
        //     background  : "#ffffff", 
        //     foreground  : "#000000", 
        //     src         : "{!!url()!!}/packages/tugumuda/img/logo_qr_terpakai_make_4.png",
        //     imgWidth    : 40,
        //     imgHeight   : 40,
        //     text        : "{!!url().'/digitalsignature/mutasi/antarskpd/surattugas/'.$item->nousul.'/'.$item->nip!!}"
        // });

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