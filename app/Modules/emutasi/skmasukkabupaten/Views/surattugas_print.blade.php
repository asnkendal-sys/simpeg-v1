<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Tugas Mutasi Masuk</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style type="text/css">
    @media print {
        @page {
            size: F4 potrait;
            margin-left: 0in;
            margin-right: 0in;
            margin-top: 0in;
            margin-bottom: 0.15in;
        }
        .page-break	{ display:block; page-break-before:always; }
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

    $nousul = Request::segment(5);
    $nip = Request::segment(6);

    $template = \DB::table('tr_mutasi_template_sk')->where('jnssurat','=','4.4')->where('idskpd','=','all')->first();

    if(count($template) < 1){
        echo "Template belum tersedia";
        exit();
    }

    $template_stugas = $template->template;

    $rs = \DB::table('tr_mutasi_masuk_daerah')
    ->select('tr_mutasi_masuk_daerah.*','a_golruang.pangkat','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
        'tr_mutasi_jenis_pemerintah.pejabat','tr_mutasi_jenis_pemerintah.pemerintah',
        \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
    )
    ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
    ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
    ->leftjoin('tr_mutasi_jenis_pemerintah', 'tr_mutasi_masuk_daerah.idpemerintah', '=', 'tr_mutasi_jenis_pemerintah.id')
    ->where('nousul','=',$nousul)
    ->where('nip','=',$nip)
    ->first();


    if(count($rs) < 1){
        echo "Daftar Mutasi belum tersedia";
        exit();
    }

    $instansi = ucwords(strtolower($rs->instansi));
    $kld = $rs->pemerintah;
    $jab_kld = $rs->pejabat;
    if($rs->idpemerintah <= 3)
    {
        if($rs->idpemerintah == 1)
        {
            $instansi = "Pemerintah Kota ".$rs->kabupaten;
        }else if($rs->idpemerintah == 2)
        {
            $instansi = "Pemerintah Kabupaten ".$rs->kabupaten;
        }else if($rs->idpemerintah == 3)
        {
            $instansi = "Pemerintah Provinsi ".$rs->kabupaten;
        }
    }
    else if($rs->idpemerintah > 3)
    {
        $instansi_tujuan = $rs->pejabat." ".$rs->instansi;
        $kabinstansi_tujuan = $rs->kabupaten;
        $kabinstansi = $rs->kabupaten; 
        if($rs->idpemerintah == 4){
            $instansi = $rs->pemerintah." ".$rs->instansi; 
        }else{
            $instansi = $rs->instansi;
        }
    }

    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

    $arrsearch = array("search","[namalengkap]","[tmlhr]","[tglhr]","[nip]","[tkpendidakhir]","[pangkat]","[golongan]","[jabatanlama]","[skpdlama]","[instansi]","[tanggal_sk_mutasi]","[tmt]","[jabatanbaru]","[skpdbaru]","[tglsurat]","[namasekda]","[pangkatsekda]","[nipsekda]","[kabupaten]",
        "[provinsi]","[kabupaten]",
        "[jab_kld]","[kld]",
        "[qrcode]","[copyright]","[no_st]","[penetapsk_kanreg]","[nosk_kanreg]","[tglsk_kanreg]","[tgl_berlaku]");

    $arrreplace = array("replace",$rs->namalengkap,ucwords(strtolower($rs->tmlhr)),formatTanggalPanjang($rs->tglhr),fnip($rs->nip),ucword(strtolower($rs->tkpendid)),$rs->pangkat,$rs->golru,ucwords(strtolower($rs->jabatanlama)),ucwords($rs->skpdlama),ucwords(strtolower($instansi)),formatTanggalPanjang($rs->tmt),formatTanggalPanjang($rs->tmt),ucwords(strtolower($rs->jabatan)),ucwords(strtolower($rs->path_short)),formatTanggalPanjang($rs->tglsurat),$rs->kepalasekda,$rs->pangkatsekda,fnip($rs->nipsekda),ucwords(strtolower($rs->kabupaten)),ucwords(strtolower($rs->provinsi)),ucwords(strtolower($rs->kabupaten)),$jab_kld,$kld,'<div id="qrcode"></div>','copyright',$rs->nosk,$rs->penetapsk_kanreg,$rs->nosk_kanreg,formatTanggalPanjang($rs->tglsk_kanreg),formatTanggalPanjang($rs->tglsurat),
);

    echo str_replace($arrsearch,$arrreplace,$template_stugas);

    ?>
</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        //$("#barcode").JsBarcode("{!!$rs->nip!!}",{width:1,height:25});
        $("#qrcode").qrcode({
            size    : 90,
            render  : "image",
            text	: "{!!url().'/digitalsignature/mutasi/masukkabupaten/surattugas/'.$rs->nousul.'/'.$rs->nip!!}"
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
