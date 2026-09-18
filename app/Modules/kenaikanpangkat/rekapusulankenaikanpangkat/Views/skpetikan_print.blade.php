<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keputusan Petikan</title>
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

    $template = TemplatekenaikanpangkatModel::getTemplate(session('idskpd')!=''?session('idskpd'):'all', '1');
    $where = "(tr_kenaikan_pangkat.statususul = 1 or tr_kenaikan_pangkat.statussk = 1)";
    $where .= "and tr_kenaikan_pangkat.nip =\"".\Request::segment(5)."\" and tr_kenaikan_pangkat.nousul = \"".\Request::segment(6)."\"";
    $count = \DB::table("tr_kenaikan_pangkat")->whereRaw($where)->count();


    $item = \DB::table('tr_kenaikan_pangkat')
        ->select('tr_kenaikan_pangkat.*','tb_01.tmlhr','tb_01.tglhr','a_skpd.path','a_golruang.golru','a_golruang.pangkat','a_jenjurusan.jenjurusan',
            \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
            \DB::raw("IF(tr_kenaikan_pangkat.idjenjab>=20,a_skpd.jab,IF(tr_kenaikan_pangkat.idjenjab=2,a_jabfung.jabfung,IF(tr_kenaikan_pangkat.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan"),
            \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
        )
        ->join('tb_01','tr_kenaikan_pangkat.nip','=','tb_01.nip')
        ->join('a_skpd','tr_kenaikan_pangkat.idskpd','=','a_skpd.idskpd')
        ->leftjoin('a_jenjurusan', 'tr_kenaikan_pangkat.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
        ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->whereRaw($where)
        ->first();

    if(count($item) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }

    $i = 0;
    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

    $arrsearch = array("search","[no_sk]","[no_suratrek]","[tgl_suratrek]","[namalengkap]","[nip]","[tmlhr]","[tglhr]",
        "[tkpendid]","[pangkat]","[golongan]","[tmtpkt]","[jabatan]","[mkthn]","[mkbln]","[gaji]","[skpd]","[instansi]",
        "[tmt]","[pangkatbaru]","[golonganbaru]","[mkthnbaru]","[mkblnbaru]","[gajibaru]",
        "[tglsurat]","[namasekda]","[pangkatsekda]","[nipsekda]","[kepalabkd]","[pangkatbkd]","[nipbkd]","[bupati]",
        "[copyright]","[qrcode]");
    $arrreplace = array("replace",
        $item->nosk,
        'BG-23324000896',
        formatTanggalPanjang(date('Y-m-d')),
        $item->namalengkap,
        fnip($item->nip),
        ucword($item->tmlhr),
        formatTanggalPanjang($item->tglhr),
        $item->jenjurusan,
        ucword($item->pangkat),$item->golru,$item->tmtpkt,
        ucword($item->jabatan),
        $item->mktkp,
        $item->mkbkp,
        $item->gkp,
        $item->path,
        "PEMERINTAH KAB. KENDAL",
        $item->tmt,
        $item->pangkatbaru,$item->golrubaru,
        $item->mktkpb,$item->mkbkpb,$item->gkpb,
        formatTanggalPanjang($item->tglsurat),
        $item->kepalasekda,
        $item->pangkatsekda,
        fnip($item->nipsekda),
        $item->kepalabkd,ucword($item->pangkatbkd),
        fnip($item->nipkepalabkd),
        $item->bupati,
        $key_rand,
        (($item->no_suratrek!='')?"<li style='text-align: justify;'>
           <span style='font-size:16px;'><span style='font-family:arial,helvetica,sans-serif;'>
           Surat ".ucword($item->surat_dari)." Kendal Nomor : ".$item->no_suratrek." Tanggal ".formatTanggalPanjang($item->tgl_suratrek)." Perihal : ".$item->perihalrek."</span></li>":'')
        ,'<div id="qrcode"></div>'
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