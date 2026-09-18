<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Perintah Mutasi Dalam OPD</title>
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
    $where = "(tr_mutasi_dalam_skpd.statususul = 1 or tr_mutasi_dalam_skpd.statussk = 1)";
    $where .= "and tr_mutasi_dalam_skpd.nousul = \"".Request::segment(5)."\"";
    $item = \DB::table('tr_mutasi_dalam_skpd')
    ->select('tr_mutasi_dalam_skpd.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
        ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru','tb_01.tmlhr','tb_01.tglhr','a_golruang.pangkat',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

        \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_skpd.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_skpd.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

        \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_skpd.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_skpd.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

    ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_skpd.idskpd', '=', 'skpdlama.idskpd')
    ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_skpd.idskpdbaru', '=', 'skpdbaru.idskpd')
    ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    ->leftjoin('a_golruang', 'tr_mutasi_dalam_skpd.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('tb_01', 'tr_mutasi_dalam_skpd.nip', '=', 'tb_01.nip')
    ->leftjoin('a_jabfung', 'tr_mutasi_dalam_skpd.idjabfung', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_skpd.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_skpd.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
    ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_skpd.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
    ->orderby('tr_mutasi_dalam_skpd.nousul','desc')
    ->whereRaw($where)
    ->orderBy(\DB::raw('tr_mutasi_dalam_skpd.nousul desc,tr_mutasi_dalam_skpd.nip'))
    ->first();

    if(count($item) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }

    $i = 0;


    $idskpd = ((strlen(session('idskpd'))==2) or (session('role_id') <= 3))?substr(Input::get('idskpd'),0,2):session('idskpd');

    $template = (\TemplateluarkabupatenModel::getTemplate($idskpd, '1.2', 'template') == '0')?\TemplateluarkabupatenModel::getTemplate('all', '1.2', 'template'):\TemplateluarkabupatenModel::getTemplate($idskpd, '1.2', 'template');
    $key = \TemplateluarkabupatenModel::rand_char();

    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";

    $arrsearch = array("search","[nosk]","[nourut]","[namalengkap]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpd]","[jabbaru]",
        "[skpdbaru]","[pendidikan]","[jurusan]","[tmt]","[tglsurat]","[kepala_bkd]","[jabkepalabkd]","[pangkatbkd]","[nipkepalabkd]","[bupati]","[copyright]","[qrcode]","[dasar2]");
    $arrreplace = array("replace",(($item->nosk!='')?$item->nosk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),
        $i,$item->namalengkap,
        $item->tmlhr,
       '',
        $item->pangkat,$item->golru,ucword($item->jabatan." ".
            NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
        ucword(($idskpd))/*$item->skpd*/,
        ucword($item->jabatanbaru." ".
            NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
        ucword($item->skpdbaru),$item->tkpendid,$item->jenjurusan,
        '',
        '',$item->kepalabkd,$item->jabkepalabkd,ucword($item->pangkat),$item->nipkepalabkd,$item->bupati,$key_rand,
        '<div id="qrcode"></div>',(($item->no_suratrek!='')?"<li style='text-align: justify;'>
            <span style='font-size:14px;'>
            Surat ".ucword($item->surat_dari)." Kendal Nomor : ".$item->no_suratrek." Tanggal ".''." Perihal : ".$item->perihalrek."</span></li>":''));

    echo str_replace($arrsearch,$arrreplace,$template);
    ?>

</body>
</html>

<script>
    $(document).ready(function(){
        $("#qrcode").qrcode({
            size    : 83.149606299,
            render  : "image",
            text    : "{!!url().'/digitalsign/mutasi/dalamskpd/surattugas/'.$item->nip.'/'.$item->nousul!!}"
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