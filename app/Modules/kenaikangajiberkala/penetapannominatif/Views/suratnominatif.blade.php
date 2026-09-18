<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Nominatif Kenaikan Gaji Berkala</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style media="all" type="text/css">
        @media print {
            @page {
                size: F4 landscape;
                margin-left: 1.5cm;
                margin-right: 1cm;
                margin-top: 1cm;
                margin-bottom: 1cm;
            }
            .page-break { display:block; page-break-before:always; }
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
            /*background-color: #ccc !important;*/
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
    $rs = \PenetapannominatifModel::getDatanominatif($idkgb, $jnskgb);

    if(!count($rs)){
        echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
        exit();
    }
?>

<div class="page-lanscape" id="F4-landscape">
    <div align="center">
        <table>
            <tr>
                <td>
                    <p><h3 align="center">NOMINATIF KENAIKAN GAJI BERKALA (KGB)</h3></p>
                    <p><h3 align="center">UNIT KERJA : {!!strtoupper(getSkpd($idskpd))!!} </h3></p>
                    <p><h3 align="center">PERIODE <?php echo strtoupper(formatTanggalPanjang($rs[0]->tmtkgbb))?></h3></p>
                </td>
            </tr>
        </table>
    </div>

    <div>
        <table class="table" border="0" cellpadding="0" width="25%" align='right'>
            <thead>
            <tr>
                <td width="28%">LAMPIRAN</td>
                <td width="2%">:</td>
                <td width="70%" colspan="3">Surat Kepala OPD</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>NOMOR</td>
                <td width="2%">:</td>
                <td width="50%">{!!$rs[0]->no_sp!!}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>TANGGAL</td>
                <td>:</td>
                <td>{!!formatTanggalPanjang($rs[0]->tgl_sp)!!}</td>
            </tr>
        </table>
    </div>

    <div>&nbsp;<br><br><br><br>
        <table class="table" border="0" cellpadding="0" width="100%">
            <thead>
            <tr>
                <th align="center" width="2%">NO</th>
                <th align="center" width="20%">NAMA <br> NIP</th>
                <th align="center" width="15%">PANGKAT GOL. RUANG</th>
                <th align="center" width="10%">TMT KGB</th>
                <th align="center" width="35%">UNIT KERJA</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $i = 0;
                foreach ($rs as $item) {
                    $i = $i+1;
            ?>
            <tr>
                <td><div align="center"><?php echo $i?>.</div></td>
                <td>
                    <?php echo $item->nama?><br>
                    <?php echo fnip($item->nip)?>
                </td>
                <td><?php echo ucword($item->golpnsskr_txt)?><br><?php echo $item->golpns_txt?></td>
                <td><div align="center"><?php echo $item->tmtkgbb_?></div></td>
                <td><div align="left"><?php echo ucword(getSkpd($item->kdskpdskr))?></div></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <table border="0" cellpadding="0" width="100%">
        <tbody>
        <tr>
            <td colspan="4" style="text-align: justify;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align: middle; width: 3%;">
                &nbsp;</td>
            <td colspan="3" style="vertical-align: middle; width: 65%;">
                &nbsp;</td>
            <td colspan="3" style="width: 35%; vertical-align: middle;">
                <div style="float: right; width: auto; margin-right: 10px; text-align: center;">
                <span style="font-size:16px;">{!!$rs[0]->jabpen_sp!!}<br />
                <br />
                <br />
                <br />
                <u>{!!$rs[0]->pejpen_sp!!}</u><br />
                &nbsp; {!!$rs[0]->golpen_sp!!}<br />
                &nbsp; NIP. {!!$rs[0]->nippen_sp!!}</span></div>
            </td>
        </tr>
        <tr>
            <td width="3%">
                &nbsp;</td>
            <td colspan="3" style="vertical-align: middle;" width="45%">
                &nbsp;</td>
            <td colspan="3" style="width: 55%; vertical-align: middle;">
                <br />
            </td>
        </tr>
        <tr>
            <td align="right" colspan="4" style="vertical-align:bottom;" width="100%;">
                &nbsp;</td>
        </tr>
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