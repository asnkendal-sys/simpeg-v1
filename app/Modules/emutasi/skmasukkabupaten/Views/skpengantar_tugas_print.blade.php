<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar Tugas Mutasi Masuk</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style media="all" type="text/css">
        @media print {
            @page {
                size: F4 landscape;
                margin-left: 1.5cm;
                margin-right: 1cm;
                margin-top: 1cm;
                margin-bottom: 1cm;
            }
            .page-break	{ display:block; page-break-before:always; }
        }

        html {
            font-family: 'Arial';
            font-size: 10pt;
            background: white;
            line-height:1.5em;
            padding: 0;
            margin: 0;
        }

        #F4-landscape{
            position: relative;
            width: 300mm;
            margin: auto;
        }
        table {
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            line-height:1.25em;
        }
        .table thead{
            background-color: #ccc !important;
        }
        .table thead > tr > th,
        .table tbody > tr > td{
            border: 1px solid black;
            padding: .4em;
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
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        $nousul = Request::segment(5);
        $tglusul = Request::segment(6);

        $template = \DB::table('tr_mutasi_template_sk')->where('jnssurat','=','4.5')->where('idskpd','=','all')->first();

        if(count($template) < 1){
            echo "Template belum tersedia";
            exit();
        }

        $template_skpengantarpersetujuan = $template->template;

        $where = " (statususul = 1 or statussk = 1) ";

        if($nousul!="") $where.= " and nousul = \"".$nousul."\"";
        $jumlahberkas = count(\DB::table('tr_mutasi_masuk_daerah')->select('tr_mutasi_masuk_daerah.*')->whereRaw($where)->get());

        $rs = \DB::table('tr_mutasi_masuk_daerah')
                ->select('tr_mutasi_masuk_daerah.*','a_golruang.pangkat','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                    \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
                )
                ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
                ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
                ->where('nousul','=',$nousul)
                ->whereRaw($where)
                ->first();

        if(count($rs) < 1){
            echo "404 Not Found.<br>";
            echo "Daftar mutasi tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.<br>";
            exit();
        }



        $key_rand = "<em>e-Simpeg Kab. Cilacap ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

        $arrsearch =  array("search","[tglpengantar]","[nopengantar]","[namalengkap]","[nip]","[berkaspengantar]","[kepalabkd]","[pangkatbkd]","[nipbkd]");



        $arrreplace = array("replace",(($rs->tglsk_pengantar!='0000-00-00')?formatTanggalPanjang($rs->tglsk_pengantar):formatTanggalPanjang(date('Y-m-d'))),(($rs->nosk_pengantar!='')?$rs->nosk_pengantar:'822.3/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),ucwords(strtolower($rs->namalengkap)),fnip($rs->nip),$jumlahberkas,$rs->kepalabkd,$rs->pangkatbkd,fnip($rs->nipkepalabkd));

        echo str_replace($arrsearch,$arrreplace,$template_skpengantarpersetujuan);

    ?>
</body>
</html>

<script>
    $(document).ready(function(){
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
