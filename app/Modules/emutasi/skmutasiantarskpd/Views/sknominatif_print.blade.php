<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lampiran Pengantar Mutasi</title>
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
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
    <div class="print"></div>

    <?php
    $where = "(tr_mutasi_dalam_daerah.statususul = 1 or tr_mutasi_dalam_daerah.statussk = 1)";
    $where .= "and tr_mutasi_dalam_daerah.nousul = \"".\Request::segment(5)."\"";

    $rs = \DB::table('tr_mutasi_dalam_daerah')
    ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru','tb_01.tmlhr','tb_01.tglhr',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
        \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))
    ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
    ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
    ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
    ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
    ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
    ->whereRaw($where)
    ->orderBy(\DB::raw("tr_mutasi_dalam_daerah.idskpdbaru,tb_01.idesljbt,tr_mutasi_dalam_daerah.idgolrupkt, tb_01.nip"))
    ->get();

    $row = \DB::table("tr_mutasi_dalam_daerah")->whereRaw($where)->first();
    
    if(count($rs) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar lampiran mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }
    ?>

    <div id="F4-landscape">
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Lampiran</td>
                <td width="2%" align="center">:</td>
                <td>Surat Kepala Badan Kepegawaian Daerah Kabupaten Kendal</td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Nomor</td>
                <td width="2%" align="center">:</td>
                <td><?php echo (($row->nosk_pengantar!='')?$row->nosk_pengantar:'822.3/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y'))?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Tanggal</td>
                <td width="2%" align="center">:</td>
                <td><?php echo (($row->tgl_skpengantar!='0000-00-00')?formatTanggalPanjang($row->tgl_skpengantar):formatTanggalPanjang(date('Y-m-d')))?></td>
            </tr>
        </table>
        <br>
        <table class="table" border="0" cellpadding="0" width="100%" style="border-top: 2px solid black">
            <thead>
                <tr>
                    <th rowspan="2" width="2%">NO</th>
                    <th rowspan="2" width="20%">NAMA / NIP</th>
                    <th rowspan="2" width="13%">TEMPAT<br>TGL LAHIR</th>
                    <th rowspan="2" width="12%">PANGKAT<br>GOL. RUANG</th>
                    <th colspan="2" width="38">JABATAN</th>
                    <th rowspan="2" width="15%">KETERANGAN</th>
                </tr>
                <tr>
                    <th width="19%">LAMA</th>
                    <th width="19%">BARU</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><b><i>1</i></b></td>
                    <td align="center"><b><i>2</i></b></td>
                    <td align="center"><b><i>3</i></b></td>
                    <td align="center"><b><i>4</i></b></td>
                    <td align="center"><b><i>5</i></b></td>
                    <td align="center"><b><i>6</i></b></td>
                    <td align="center"><b><i>7</i></b></td>
                </tr>
                <?php
                $i=0;
                foreach($rs as $item){
                    $i++;
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $i?>.</div></td>
                        <td><?php echo $item->namalengkap?><br><?=fnip($item->nip)?></td>
                        <td><?php echo ucword($item->tmlhr)?>,<br> <?php echo date("d-m-Y", strtotime($item->tglhr))?></td>
                        <td><?php echo ucword($item->pangkat)." (".$item->golru.")";?><br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td></td>
                        <td><div align="left">{!! $item->jabatan !!} Pada {!! $item->skpdlama !!}</div></td>
                        <td><div align="left">{!! $item->jabatanbaru !!} Pada {!! $item->skpdbaru !!}</div></td>
                        <td>
                            <?php echo $item->keterangan ?>
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <br>

            <table border="0" cellpadding="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" width="50%">
                        &nbsp;</td>
                        <td align="center" width="50%">
                            <div style="float: right; width: 50%; margin-right: 1em;">
                                <br>
                                KEPALA BADAN KEPEGAWAIAN DAERAH<br />
                                KABUPATEN KENDAL<br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <b><u><?php echo $row->kepalabkd?></u><br />
                                    <?php echo $row->pangkatbkd?><br>
                                    <?php echo $row->nipkepalabkd?></b>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle;" width="50%">
                                <small><em>e-Simpeg Kab. Kendal <?php echo gmdate("d-m-Y H:i", time()+60*60*7) ?></em></small>
                            </td>
                            <td colspan="3" align="right" width="50%" style="padding-right: 110px">
                              <!--<div id="qrcode">--></td>
                              <td align="right" colspan="1" style="vertical-align:bottom;" width="50%">
                                &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />

        </body>
        </html>

        <script>
            $(document).ready(function(){
               $("#qrcode").qrcode({
                size    : 83.149606299,
                render  : "image",
                text    : "{!!url().'/digitalsign/mutasi/antaropd/sknominatif/'.$item->nip.'/'.$item->nousul!!}"
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