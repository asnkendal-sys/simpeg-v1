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
        $jnskgb = \Request::segment(4);
        if(\Request::segment(6) != ''){
            $idskpd = \Request::segment(6);
        }else{
            $idskpd = session('idskpd');
        }
        $idkgb = \Request::segment(5).".".$idskpd;
        $idstspeg = \Request::segment(7).".".$idstspeg;

        $rs = \PenetapannominatifModel::getDatanominatif($idkgb, $jnskgb, $idstspeg);

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
                        <p><h3 align="center">DAFTAR NOMINATIF KENAIKAN GAJI BERKALA (KGB)</h3></p>
                        <p><h3 align="center">UNIT KERJA : {!!strtoupper(getSkpd($idskpd))!!} </h3></p>
                        <p><h3 align="center">PERIODE <?php echo strtoupper(formatTanggalPanjang($rs[0]->tmtkgbb))?></h3></p>
                    </td>
                </tr>
            </table>
        </div>
        <table class="table" border="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th align="center" rowspan="3" width="2%">NO</th>
                    <th align="center" rowspan="3" width="15%">NAMA <br> NIP</th>
                    <th align="center" rowspan="3" width="12%">PANGKAT</th>
                    <th align="center" rowspan="3" width="5%">GOL</th>
                    <th align="center" rowspan="3" width="15%">JABATAN</th>
                    <th align="center" colspan="4" width="15%">MASA KERJA</th>
                    <th align="center" colspan="2" width="10%">GAJI POKOK</th>
                    <th align="center" rowspan="3" width="5%">TMT KGB</th>
                    <th align="center" rowspan="3" width="15%">UNIT KERJA</th>
                </tr>
                <tr>
                    <th colspan="2">LAMA</th>
                    <th colspan="2">BARU</th>
                    <th rowspan="2">LAMA</th>
                    <th rowspan="2">BARU</th>
                </tr>
                <tr>
                    <th>TH</th>
                    <th>BL</th>
                    <th>TH</th>
                    <th>BL</th>
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
                    <?php echo $item->nama?>
                    <?php echo fnip($item->nip)?>
                </td>
                <td><?php echo ucword($item->golpnsskr_txt)?></td>
                <td><div align="center"><?php echo $item->golpns_txt?></div></td>
                <td><?php echo ucword($item->nmajab)?></td>
                <td><div align="center"><?php echo $item->mktkgbl?></div></td>
                <td><div align="center"><?php echo $item->mkbkgbl?></div></td>
                <td><div align="center"><?php echo $item->mktkgbb?></div></td>
                <td><div align="center"><?php echo $item->mkbkgbb?></div></td>
                <td><div align="right"><?php echo uang($item->gkgbl)?></div></td>
                <td><div align="right"><?php echo uang($item->gkgbb)?></div></td>
                <td><div align="center"><?php echo $item->tmtkgbb_?></div></td>
                <td><div align="left"><?php echo ucword(getSkpd($item->kdskpdskr))?></div></td>
            </tr>
            <?php } ?>
            </tbody>
        </table><br>
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