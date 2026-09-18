<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Menghadapkan Mutasi Luar</title>
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

    $nousul = Request::segment(5);
    $nip = Request::segment(6);
    $template = \TemplateluarkabupatenModel::getTemplate('all','3.4','template');

    $where = "(tr_mutasi_luar_daerah.statususul = 1 or tr_mutasi_luar_daerah.statussk = 1)";
    $where .= "and tr_mutasi_luar_daerah.nip = \"".$nip."\" AND tr_mutasi_luar_daerah.nousul = \"".$nousul."\"";

    $item = \DB::table('tr_mutasi_luar_daerah')
    ->select('tr_mutasi_luar_daerah.*','tb_01.tmlhr','tb_01.tglhr','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path_short','a_golruang.golru','a_golruang.pangkat',
        \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),'tr_mutasi_jenis_pemerintah.pemerintah','tr_mutasi_jenis_pemerintah.pejabat','kepopd.jab',
        \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
    )
    ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
    ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
    ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
    ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
    ->leftJoin('a_skpd as kepopd',\DB::raw('left(tr_mutasi_luar_daerah.idskpd,2)'),'=','kepopd.idskpd')
    ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
    ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
    ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
    ->leftJoin('tr_mutasi_jenis_pemerintah','tr_mutasi_luar_daerah.idpemerintah','=','tr_mutasi_jenis_pemerintah.id')
    ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc, tr_mutasi_luar_daerah.idgolrupkt,tr_mutasi_luar_daerah.nip'))
    ->whereRaw($where)
    ->first();

    if(count($item) < 1){
        echo "404 Not Found.";
        exit();
    }
    $instansi_tujuan ='';
    $tujuan_pem ='';
    $kabinstansi_tujuan = (($item->pemerintah!='')?$item->pemerintah.' ':'').$item->kabupaten;
    $kabinstansi = $item->kabupaten;
    if($item->idpemerintah <= 3)
    {
        $instansi_tujuan = $item->pejabat." ".$item->kabupaten;
        if($item->idpemerintah == 1)
        {
            $tujuan_pem = "Pemerintah Kota ".$item->kabupaten;
        }else if($item->idpemerintah == 2)
        {
            $tujuan_pem = "Pemerintah Kabupaten ".$item->kabupaten;
        }else if($item->idpemerintah == 3)
        {
            $tujuan_pem = "Pemerintah Provinsi ".$item->kabupaten;
        }
    }
    else if($item->idpemerintah > 3)
    {
        $instansi_tujuan = $item->pejabat." ".$item->instansi;
        $kabinstansi_tujuan = $item->kabupaten;
        $kabinstansi = $item->kabupaten; 
        if($item->idpemerintah == 4){
            $tujuan_pem = $item->pemerintah." ".$item->instansi; 
        }else{
            $tujuan_pem = $item->instansi;
        }
    }

    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

    $arrsearch = array("search","[nosk]","[kepada]","[lokasi]","[namalengkap]","[nip]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpdlama]",
        "[pendidikan]","[jurusan]","[tmt]","[tglsurat]","[bupati]","[copyright]","[skpd]","[sekda]","[nipsekda]","[pangkatsekda]",
        "[penetapsk_kanreg]","[nosk_kanreg]","[tglsk_kanreg]","[qrcode]",
        "[kabinstansi]",
        "[tujuan_pem]",
        "[instansi_tujuan]",
        "[kabinstansi_tujuan]",

        "[kepala_instansi]","[kepalabkd]","[pangkatbkd]","[nipkepalabkd]","[nomenghadapkan]","[tmt_berlaku]");

    $arrreplace = array("replace",(($item->nosk!='')?$item->nosk:'800/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),
        ucword($item->ditujukan_kepada),strtoupper($item->lokasi_ditujukan),$item->namalengkap,fnip($item->nip),$item->tmlhr,formatTanggalPanjang($item->tglhr),ucword($item->pangkat),$item->golru,ucword($item->jabatan),ucword($item->path_short),
        ucword($item->tkpendid),ucword($item->jenjurusan),formatTanggalPanjang($item->tmt),(($item->tglsurat!='0000-00-00')?formatTanggalPanjang($item->tglsurat):''),$item->bupati,$key_rand,ucword($item->path_short),
        \TemplateluarkabupatenModel::getPenetap('069', 'namalengkap'), fnip(\TemplateluarkabupatenModel::getPenetap('069', 'nip')), \TemplateluarkabupatenModel::getPenetap('069', 'pangkat'),
        $item->penetapsk_kanreg,$item->nosk_kanreg,(($item->tglsk_kanreg!='0000-00-00')?formatTanggalPanjang($item->tglsk_kanreg):formatTanggalPanjang(date('Y-m-d'))),'<div id="qrcode"></div>',
        $kabinstansi,
        $tujuan_pem,
        $instansi_tujuan,
        $kabinstansi_tujuan,
        $item->jab,
        $item->kepalabkd,
        $item->pangkatbkd,
        $item->nipkepalabkd,
        $item->nosk_pengantar,
        formatTanggalPanjang($item->tmt_berlaku));

    echo str_replace($arrsearch,$arrreplace,$template);
    ?>
</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        $("#qrcode").qrcode({
            size    : 83.149606299,
            render  : "image",
            text    : "{!!url().'/digitalsignature/mutasi/luarkabupaten/menghadapkan/'.$item->nousul.'/'.$item->nip!!}"
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