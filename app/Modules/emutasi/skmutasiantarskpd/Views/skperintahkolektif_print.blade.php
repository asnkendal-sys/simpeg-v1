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
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php
    date_default_timezone_set("Asia/Jakarta");

    $template = TemplateskpengantarModel::getTemplate(session('idskpd')!=''?session('idskpd'):'all', '2.6', 'template');
    $where = "(tr_mutasi_dalam_daerah.statususul = 1 or tr_mutasi_dalam_daerah.statussk = 1)";
    $where .= "and tr_mutasi_dalam_daerah.nousul = \"".\Request::segment(5)."\"";
    $count = \DB::table("tr_mutasi_dalam_daerah")->whereRaw($where)->count();


    $rs = $item = \DB::table('tr_mutasi_dalam_daerah')
    ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru','tb_01.tmlhr','tb_01.tglhr',
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

    $arrsearch = array("search","[nosk]","[namalengkap]","[nip]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpdlama]","[jabbaru]",
        "[skpdbaru]","[pendidikan]","[tgl_sp]","[jurusan]","[tmt]","[tglsurat]","[namasekda]","[pangkatsekda]","[nipsekda]","[kepalabkd]","[pangkatbkd]","[nipbkd]","[bupati]","[tembusan_skpd_baru]","[tembusan_skpd_lama]","[copyright]","[qrcode]");
    $arrreplace = array("replace",$item->nosk,$item->namalengkap,fnip($item->nip),ucword($item->tmlhr),formatTanggalPanjang($item->tglhr),ucword($item->pangkat),$item->golru,ucword($item->jabatan." ".NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungum)),ucword($item->skpdlama." ".((strlen($item->idskpd)>2)?getSkpdgroup(substr($item->idskpd,0,2)):'')),ucword($item->jabatanbaru." ".NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
        ucword($item->skpdbaru." ".((strlen($item->idskpdbaru)>2)?getSkpdgroup(substr($item->idskpdbaru,0,2)):'')),ucword($item->tkpendid),formatTanggalPanjang($item->tgl_sp),ucword($item->jenjurusan),
        formatTanggalPanjang($item->tmt),
        formatTanggalPanjang($item->tglsurat),
        $rs->kepalasekda,
        $rs->pangkatsekda,
        fnip($rs->nipsekda),
        $item->kepalabkd,ucword($item->pangkatbkd),fnip($item->nipkepalabkd),$item->bupati,"Kepala ".ucword(getSkpdgroup(substr($item->idskpdbaru,0,2))),"Kepala ".ucword(getSkpdgroup(substr($item->idskpd,0,2))),$key_rand,'<div id="qrcode"></div>');

    echo str_replace($arrsearch,$arrreplace,$template);

    ?>
</body>
</html>

<script>
    $(document).ready(function(){
        $("#qrcode").qrcode({
            size    : 83.149606299,
            render  : "image",
            text    : "{!!url().'/digitalsignature/mutasi/antarskpd/surattugas/'.$item->nousul.'/'.$item->nip!!}"
        });
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