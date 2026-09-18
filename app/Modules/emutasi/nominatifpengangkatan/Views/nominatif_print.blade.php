<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lampiran SK Pengangkatan</title>
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
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
    <div class="print"></div>

    <?php
    $tgl_sp = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    $where = "tr_mutasi_pengangkatan.nousul = \"".Input::get('nousul')."\"";
    $item = \DB::table("tr_mutasi_pengangkatan")
      ->select('tr_mutasi_pengangkatan.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_golruang.pangkat'
        ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru','tb_01.tmlhr','tb_01.tglhr','skpdlama.jab',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

        \DB::raw('IF(tr_mutasi_pengangkatan.idjenjab>4,skpdlama.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

        \DB::raw('IF(tr_mutasi_pengangkatan.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_pengangkatan.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_pengangkatan.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

      ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_pengangkatan.idskpd', '=', 'skpdlama.idskpd')
      ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_pengangkatan.idskpdbaru', '=', 'skpdbaru.idskpd')
      ->leftjoin('a_tkpendid', 'tr_mutasi_pengangkatan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
      ->leftjoin('a_jenjurusan', 'tr_mutasi_pengangkatan.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
      ->leftjoin('a_golruang', 'tr_mutasi_pengangkatan.idgolrupkt', '=', 'a_golruang.idgolru')
      ->leftjoin('tb_01', 'tr_mutasi_pengangkatan.nip', '=', 'tb_01.nip')
      ->leftjoin('a_jabfung', 'tr_mutasi_pengangkatan.idjabfung', '=', 'a_jabfung.idjabfung')
      ->leftjoin('a_jabfungum', 'tr_mutasi_pengangkatan.idjabfungum', '=', 'a_jabfungum.idjabfungum')
      ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_pengangkatan.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
      ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_pengangkatan.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
      ->whereRaw($where)
      ->orderby('tr_mutasi_pengangkatan.idusul','asc')
      ->get();

    $row = \DB::table('tr_mutasi_pengangkatan')
    ->select('tr_mutasi_pengangkatan.*')->whereRaw($where)->first();
    $idskpd = ((strlen(session('idskpd'))==2) or (session('idskpd') == ''))?substr(Input::get('idskpd'),0,2):session('idskpd');
    if ($idskpd == "") {
        $idskpd = "25";
    }

    $attr = \NominatifpengangkatanModel::attrPengantar($idskpd);

    if(count($row) < 1){
        echo "404 Not Found.<br>";
        echo "Daftar mutasi tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }
    
    ?>

    <div id="F4-landscape">
        <!-- <table border="0" cellpadding="0" width="100%">
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Lampiran</td>
                <td width="2%" align="center">:</td>
                <td>Surat <?php echo getSkpdgroupMutdalam(substr($row->idskpd,0,2))?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Nomor</td>
                <td width="2%" align="center">:</td>
                <td><?php echo ($row->nosk!='')?$row->nosk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;</td>
                <td width="6%">Tanggal</td>
                <td width="2%" align="center">:</td>
                <td><?php echo formatTanggalPanjang($tgl_sp)?></td>
            </tr>
        </table>
        <br> -->
        <table border="0" cellpadding="0" width="100%">
          <tr>
            <td><p><h3 align="center">DAFTAR NOMINATIF USULAN PENYESUAIAN DALAM NOMENKLATUR JABATAN PELAKSANA</h3></p>
              <p><h3 align="center"><?php echo strtoupper(getSkpdgroup($idskpd))?></h3></p>
            </td> 
          </tr>
        </table>
        <br>
        <table class="table" border="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th rowspan="2" width="2%">NO</th>
                    <th rowspan="2" width="20%">NAMA / NIP</th>
                    <th rowspan="2" width="20%">TEMPAT TGL LAHIR</th>
                    <th colspan="2" width="30%">USULAN JABATAN</th>
                    <th rowspan="2" width="15%">KETERANGAN</th>
                </tr>
                <tr>
                    <th width="15%">JABATAN</th>
                    <th width="15%">UNIT KERJA</th>
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
                </tr>
                <?php
                $i=0;
                foreach($item as $item){
                    $i++;
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $i?>.</div></td>
                        <td><?php echo $item->namalengkap?><br><?=fnip($item->nip)?></td>
                        <td><?php echo ucword($item->tmlhr)?>, <?php echo date("d-m-Y", strtotime($item->tglhr))?></td>
                        <td><div align="left">{!! $item->jabatanbaru !!}</div></td>
                        <td><div align="left">{!! $item->skpdbaru !!}</div></td>
                        <td><?php echo $item->keterangan; ?></td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <br>

            <table border="0" cellpadding="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" width="50%" style="padding-top: 100px;">
                        &nbsp;</td>
                        <td align="center" width="50%">
                            <div style="float: right; width: 50%; margin-right: 1em;">
                                Kendal, <?php echo formatTanggalPanjang($tgl_sp) ?>
                                <br>
                                <?php echo strtoupper(@$attr->jab)?><br />
                                KABUPATEN KENDAL<br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <b><u><?php echo @$attr->nama?></u><br />
                                    <?php echo ucword(@$attr->pangkat)?><br />
                                    <?php echo "NIP. ".@$attr->nip?></b>
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
                <br />

            </body>
            </html>
            <script>
                $(document).ready(function(){
                    $("#qrcode").qrcode({
                        size    : 90,
                        render  : "image",
                        text    : "{!!url().'/digitalsign/mutasi/dalamopd/nominatif/'.$item->nip.'/'.$item->nousul!!}"
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