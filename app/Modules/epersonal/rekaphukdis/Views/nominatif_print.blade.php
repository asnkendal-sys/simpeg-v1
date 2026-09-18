<html>
<head>
<title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Nominatif Hukuman Disiplin</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: A4 landscape;
                margin-left: 0.6in;
                margin-right: 0.6in;
                margin-top: 0.6in;
                margin-bottom: 0.6in;
            }
            /*p.breakhere { page-break-after: always; }*/
            .page-break	{ display:block; page-break-before:always; }
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
        }

        div.print:hover{
            opacity:1;
        }

        hr {
            border: 1px dotted #000000;
            border-bottom: none;
            border-right: none;
            border-left: none;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>
<body>
<div class="print"></div>
<div class="page">

<?php
    /* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1')).' S/D '.formatBulan(Input::get('bulan2'));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1'));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan2'));
    }
?>
<div align="center">
<h3>DAFTAR NOMINATIF HUKUMAN DISIPLIN</h3>
<h3>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'')!!}
    {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h3>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th rowspan="2"><div class="text-center">NO</div></th>
        <th rowspan="2">
            <div class="text-center">NIP</div>
        </th>
        <th rowspan="2">
            <div class="text-left">NAMA</div>
            <div class="text-left">TEMPAT, TGL LAHIR</div>
        </th>
        <th rowspan="2">
            <div class="text-center">JENIS HUKUM DISIPLIN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">TINGKAT</div>
        </th>
        <th rowspan="2">
            <div class="text-center">PEJABAT</div>
        </th>
        <th rowspan="2">
            <div class="text-center">NO. SK</div>
        </th>
        <th rowspan="2">
            <div class="text-center">TGL. SK</div>
        </th>
        <th colspan="2">
            <div class="text-center">LAMA HUKUMAN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">KETERANGAN</div>
        </th>
        <!-- <th rowspan="2">
            <div class="text-center">AGAMA</div>
            <div class="text-center">USIA</div>
        </th> -->
    </tr>
    <tr>
        <th>
            <div class="text-center">TGL. MULAI</div>
        </th>
        <th>
            <div class="text-center">TGL. SELESAI</div>
        </th>
    </tr>
  </thead>
  <tbody>
    <?php

    if(count($rs) != ''){
    $n = 0;
  foreach($rs as $item){ $n++;
  ?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td align="center">
            <div class="text-center">{!!fnip($item->nip)!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->jenhukum!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->kathukdis!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->namapejab!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->nosk!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->tgsk!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tgmul))!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tgsel))!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->ket!!}</div>
        </td>
    </tr>
        <?php
            }} else {
        ?>
            <tr>
                <td align="center" colspan="15"><h4>Data Tidak Ditemukan</h4></td>
            </tr>
        <?php  }

        ?>
  </tbody>
</table>
</div>
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
