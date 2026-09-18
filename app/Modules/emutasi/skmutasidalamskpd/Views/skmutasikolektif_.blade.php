
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>SK Mutasi Kolektif</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
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
</head>
<body>

<div class="print"></div>
<?php
    date_default_timezone_set("Asia/Jakarta");

    $nousul = \Request::segment(4);

    $rs = \DB::table('tr_mutasi_dalam_skpd')->where('nousul', $nousul)->get();
    $rstemplate = (\TemplateskmutasiModel::getTemplate('all',1.2) == '0')?'<div align="center"><b>Perhatian!</b> Template Surat Pengantar Belum tersedia.<br><em>"Silahkan buat template pada menu Template Surat Cuti."</em></div>':\TemplateskmutasiModel::getTemplate('all',1.2);


    if(count($rs) > 0){
        /*$arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
        "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
        "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[copyright]","[skpd]","[tembusan_skpd]");*/

        /*kondisi tembusan untuk sekda dan sekwan*/
        /*if(substr($item->kdskpdskr,0,2) == '03'){
        if(strlen($item->kdskpdskr) > 8){
            $rs = \DB::table('master_tskpd')->where('Kd_Skpd', substr($item->kdskpdskr,0,9))->first();
            $tembusan = ucword($rs->Nm_Skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
        }else{
            $rs = \DB::table('master_tskpd')->where('Kd_Skpd', substr($item->kdskpdskr,0,3))->first();
            $tembusan = ucword($rs->Nm_Skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
        }
    }else if(substr($item->kdskpdskr, 0, 2) == '04'){
        if(strlen($item->kdskpdskr) > 5){
            $rs = \DB::table('master_tskpd')->where('Kd_Skpd', substr($item->kdskpdskr,0,6))->first();
            $tembusan = ucword($rs->Nm_Skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
        }else{
            $rs = \DB::table('master_tskpd')->where('Kd_Skpd', substr($item->kdskpdskr,0,3))->first();
            $tembusan = ucword($rs->Nm_Skpd)." ".ucword(\PenetapannominatifModel::getSkpd($idskpd));
        }
    }else{
        $rs = \DB::table('master_tskpd')->where('Kd_Skpd', substr($item->kdskpdskr,0,3))->first();
        $tembusan = "Sekretaris ".ucword($rs->Nm_Skpd);
    }

    $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,$item->nip,
        ucword($item->tmplahir),$item->tgllahir_,ucword($item->golpns_txt),ucword($item->nmajab),ucword($item->tmpskpdskr),
        uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),date('d-m-Y', strtotime($item->tglskkgbl)),$item->noskkgbl,date('d-m-Y', strtotime($item->tmtkgbl)),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
        $item->mktkgbb,$item->mkbkgbb,$item->golpnsskr_txt,$item->tmtkgbb_,$item->jabpenkgbb,$item->pejpenkgbb,ucword($item->golrupb),
        $item->nippb,'',ucword(\PenetapannominatifModel::getSkpd($idskpd)),$tembusan);*/

        //echo str_replace($arrsearch,$arrreplace,$rstemplate);
        foreach ($rs as $item) {
            echo $rstemplate.'<div class="page-break"></div>';
        }

    }else{
        echo "Data Mutasi tidak ditemukan.";
    }
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