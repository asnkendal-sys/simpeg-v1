<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar Pengangkatan Pelaksana</title>
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

    $idskpd = ((strlen(session('idskpd'))==2) or (session('idskpd') == ''))?substr(Input::get('idskpd'),0,2):session('idskpd');
    if ($idskpd == "") {
        $idskpd = "25";
    }

    /*update ke sk*/
    $dt['nousul'] = Input::get('nousul');
    $data['no_sp'] = Input::get('no_sp');
    $data['berkas_sp'] = Input::get('berkas_sp');
    $data['tgl_sp'] = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    \DB::table('tr_mutasi_pengangkatan')->where($dt)->update($data);    

    $template = (\TemplateskpengangkatanModel::getTemplate($idskpd,'5.3','template') == '0')?\TemplateskpengangkatanModel::getTemplate('all','5.3','template'):\TemplateskpengangkatanModel::getTemplate($idskpd, '5.3', 'template');

    $item = \DB::table('tr_mutasi_pengangkatan')
    ->select('tr_mutasi_pengangkatan.*','tb_01.tmlhr','tb_01.tglhr','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
        \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
        \DB::raw("IF(tr_mutasi_pengangkatan.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
    )
    ->leftJoin('tb_01','tr_mutasi_pengangkatan.nip','=','tb_01.nip')
    ->leftJoin('a_tkpendid','tr_mutasi_pengangkatan.idtkpendid','=','a_tkpendid.idtkpendid')
    ->leftJoin('a_jenjurusan','tr_mutasi_pengangkatan.idjenjurusan','=','a_jenjurusan.idjenjurusan')
    ->leftJoin('a_skpd','tr_mutasi_pengangkatan.idskpd','=','a_skpd.idskpd')
    ->leftJoin('a_jabfung','tr_mutasi_pengangkatan.idjabfung','=','a_jabfung.idjabfung')
    ->leftJoin('a_jabfungum','tr_mutasi_pengangkatan.idjabfungum','=','a_jabfungum.idjabfungum')
    ->leftJoin('a_golruang','tr_mutasi_pengangkatan.idgolrupkt','=','a_golruang.idgolru')
    ->orderBy(\DB::raw('tr_mutasi_pengangkatan.idusul'))
    ->orderby('tr_mutasi_pengangkatan.idusul','asc')
    ->where($dt)
    ->first();

    /*akses mod jika admin*/
    $attr = \NominatifpengangkatanModel::attrPengantar($idskpd);
    if(count($item) < 1){
        echo "404 Not Found.";
        exit();
    }


    $key = \TemplateskpengangkatanModel::rand_char();            

    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

    $arrsearch = array("search","[nosk]","[dkk]","[skpd]","[namalengkap]","[nip]","[berkas_sp]","[tgl_surat]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
            "[nip_penetap]","[copyright]","[qrcode]");
        $arrreplace = array("replace",$item->no_sp,(($item->berkas_sp>1)?'dkk.':''),getSkpdgroup($idskpd),$item->namalengkap,$item->nip,$item->berkas_sp,formatTanggalPanjang($item->tgl_sp),
            strtoupper(@$attr->jab),@$attr->nama,ucword(@$attr->pangkat),@$attr->nip,$key_rand,'<div id="qrcode"></div>');

    echo str_replace($arrsearch,$arrreplace,$template);
    ?>
</body>
</html>

<script>
    $(document).ready(function(){
     $("#qrcode").qrcode({
        size    : 90,
        render  : "image",
        text    : "{!!url().'/digitalsign/mutasi/pengangkatanpelaksana/pengantar/'.$item->nip.'/'.$item->nousul!!}"
    });
        //alert(window.orientation);
        $('div.print').click(function(){
            $(this).hide();
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

