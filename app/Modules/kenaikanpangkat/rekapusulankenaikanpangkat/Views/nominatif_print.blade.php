<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Lampiran Surat Pengantar</title>
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
            /*border: 1px solid black;*/
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
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
<div class="print"></div>
<?php
    $where = "tr_kenaikan_pangkat.nousul = \"".Request::segment(5)."\"";

    $rs = \DB::table('tr_kenaikan_pangkat')
        ->select('tr_kenaikan_pangkat.*','tb_01.tmlhr','tb_01.tglhr','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat',
            \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
            \DB::raw("IF(tr_kenaikan_pangkat.idjenjab>=20,a_skpd.jab,IF(tr_kenaikan_pangkat.idjenjab=2,a_jabfung.jabfung,IF(tr_kenaikan_pangkat.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan"),
            \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
        )
        ->join('tb_01','tr_kenaikan_pangkat.nip','=','tb_01.nip')
        ->join('a_skpd','tr_kenaikan_pangkat.idskpd','=','a_skpd.idskpd')
        ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
        ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->orderBy(\DB::raw('tr_kenaikan_pangkat.idusul'))
        ->whereRaw($where)
        ->orderby('tr_kenaikan_pangkat.idusul','desc')
        ->get();


    $row = \DB::table('tr_kenaikan_pangkat')->select('tr_kenaikan_pangkat.*')->first();
    $idskpd = ((strlen(session('idskpd'))==2) or (session('role_id') <= 3))?substr(Input::get('idskpd'),0,2):session('idskpd');

    if(count($row) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }
    $attr = \RekapusulankenaikanpangkatModel::attrPengantar(substr($row->idskpd,0,2));
    ?>

    <div id="F4-landscape">
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Lampiran</td>
                <td width="2%" align="center">:</td>
                <td>Surat {!! $rs[0]->jabkepalabkd !!} </td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Nomor</td>
                <td width="2%" align="center">:</td>
                <td><?php echo $rs[0]->no_sp?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Tanggal</td>
                <td width="2%" align="center">:</td>
                <td><?php echo formatTanggalPanjang($rs[0]->tgl_sp)?></td>
            </tr>
        </table>
        <br>
        <table class="table" border="1" cellpadding="0" width="100%">
            <thead>
            <tr>
                <th align="center" rowspan="2" width="2%">NO</th>
                <th align="center" rowspan="2" width="16%">NAMA <br> NIP</th>
                <th align="center" rowspan="2" width="10%">TEMPAT,<br>TANGGAL LAHIR</th>
                <th align="center" rowspan="2" width="16%">UNIT KERJA DAN JABATAN</th>
                <th align="center" colspan="2" width="16%">PANGKAT GOL.RUANG</th>
            </tr>
            <tr>
                <th width="16%">LAMA</th>
                <th width="16%">BARU</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
            </tr>
            </thead>
            <?php if (count($rs)!=''){ ?>
            <tbody>
                <?php
                $i = 0;
                foreach ($rs as $item) {
                    $i = $i+1;
                    ?>
                <tr>
                    <td><div align="center">{!! $i !!}.</div></td>
                    <td>
                        {!! $item->namalengkap !!}<br>
                        {!! $item->nip !!}
                    </td>
                    <td><div align="left">
                        {!!$item->tmlhr!!},<br>
                        {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}
                    </div></td>
                    <td>
                        <div class="text-left">{!!$item->jabatan!!}</div>
                        <div class="text-left"><i>Pada</i></div>
                        <div class="text-left">{!!$item->path_short!!}</div>
                    </td>
                    <td align="left"><?php echo ucword($item->pangkat)." (".$item->golru.")";?><br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td>
                    <td align="left"><?php echo ucword($item->pangkatbaru)." (".$item->golrubaru.")";?><br>{!!($item->tmt!='0000-00-00')?date('d-m-Y', strtotime($item->tmt)):''!!}</td>
                </tr>
                    <?php } ?>
            </tbody>
            <?php }
        else{  ?>
            <tbody>
            <tr>
                <td colspan="9"> Data tidak ditemukan</td>
            </tr>
            </tbody>
            <?php } ?>
        </table><br>
        <table border="0" cellpadding="0" width="100%">
            <tbody>
            <tr>
                <td colspan="3" width="50%" style="padding-top: 100px;">
                    &nbsp;</td>
                <td align="center" width="50%">
                    <div style="float: right; width: 50%; margin-right: 1em;">
                        <br>
                        <?php echo strtoupper($rs[0]->jabkepalabkd)?><br />
                        KABUPATEN KENDAL<br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <b><u><?php echo $rs[0]->kepalabkd?></u><br />
                            <?php echo ucword($rs[0]->pangkatbkd)?><br />
                            <?php echo $rs[0]->nipkepalabkd?></b>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" width="50%">
                    <small><em>e-Simpeg Kab. Kendal <?php echo gmdate("d-m-Y H:i", time()+60*60*7) ?></em></small>
                </td>
                <td colspan="3" align="right" width="50%" style="vertical-align: middle; padding-right: 110px">
                    <!--<div id="qrcode"></div>--></td>
                <td align="right" colspan="1" style="vertical-align:bottom; height:100px" width="50%">
                    &nbsp;
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</body>
</html>

<script>
    $(document).ready(function(){
        $("#qrcode").qrcode({
            size    : 90,
            render  : "image",
            text    : "{!!url().'/digitalsign/kenaikanpangkat/nominatif/'.$item->nip.'/'.$item->nousul!!}"
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
