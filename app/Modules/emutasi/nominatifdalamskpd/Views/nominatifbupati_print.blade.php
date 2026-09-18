<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <title>Lampiran Nominatif checklist</title>
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
  $nousul = Input::get('nousul');
  $no_sp = Input::get('no_sp');
  $berkas_sp = Input::get('berkas_sp');
  $tgl_sp = date("Y-m-d", strtotime(Input::get('tgl_sp')));

  $rs = \DB::table("tr_mutasi_dalam_skpd")
  ->select('tr_mutasi_dalam_skpd.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_golruang.pangkat'
    ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru','tb_01.tmlhr','tb_01.tglhr','skpdlama.jab',
    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

    \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_skpd.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_skpd.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

    \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_skpd.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_skpd.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

  ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_skpd.idskpd', '=', 'skpdlama.idskpd')
  ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_skpd.idskpdbaru', '=', 'skpdbaru.idskpd')
  ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
  ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
  ->leftjoin('a_golruang', 'tr_mutasi_dalam_skpd.idgolrupkt', '=', 'a_golruang.idgolru')
  ->leftjoin('tb_01', 'tr_mutasi_dalam_skpd.nip', '=', 'tb_01.nip')
  ->leftjoin('a_jabfung', 'tr_mutasi_dalam_skpd.idjabfung', '=', 'a_jabfung.idjabfung')
  ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_skpd.idjabfungum', '=', 'a_jabfungum.idjabfungum')
  ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_skpd.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
  ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_skpd.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
  ->orderby('tr_mutasi_dalam_skpd.nousul','desc')
  ->where('tr_mutasi_dalam_skpd.nousul', $nousul)
  ->get();


  $row = \DB::table('tr_mutasi_dalam_skpd')
  ->select('tr_mutasi_dalam_skpd.*')->first();
  $idskpd = ((strlen(session('idskpd'))==2) or (session('role_id') <= 3))?substr(Input::get('idskpd'),0,2):session('idskpd');

  if(count($row) < 1){
    echo "404 Not Found.<br>";
    echo "Daftar mutasi tidak tersedia.<br>";
    echo "Cek status berkas dan status SK.<br>";
    exit();
  }
  $attr = \TemplateluarkabupatenModel::attrPengantar(substr($row->idskpd,0,2));  
  ?>

  <div id="F4-landscape">
    <table border="0" cellpadding="0" width="100%">
      <tr>
        <td width="70%">&nbsp;</td>
        <td width="6%">Lampiran</td>
        <td width="2%" align="center">:</td>
        <td>Daftar Nominatif </td>
        <!-- <td>Surat {{ echasdo $asdthis->asdpublik->adsucword($attr->jabasd)?></td> -->
      </tr>
      <tr>
        <td width="70%">&nbsp;</td>
        <td width="6%">Nomor</td>
        <td width="2%" align="center">:</td>
        <td><?php echo $no_sp?></td>
      </tr>
      <tr>
        <td width="70%">&nbsp;</td>
        <td width="6%">Tanggal</td>
        <td width="2%" align="center">:</td>
        <td><?php echo formatTanggalPanjang($tgl_sp)?></td>
      </tr>
    </table>
    <br>
    <table class="table" border="1" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th align="center" rowspan="2" width="2%">NO</th>
          <th align="center" rowspan="2" width="16%">NAMA <br> NIP</th>
          <th align="center" rowspan="2" width="10%">TEMPAT,<br>TANGGAL LAHIR</th>
          <th align="center" rowspan="2" width="9%">PANGKAT GOL.RUANG</th>
          <th align="center" colspan="2" width="9%">JABATAN</th>
          <th align="center" rowspan="2" width="11%">KETERANGAN</th>
          <th align="center" rowspan="2" width="11%">STATUS DiSETUJUI</th>
        </tr>
        <tr>
          <th>LAMA</th>
          <th>BARU</th>
        </tr>
        <tr>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
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
              {!! $item->namalengkap !!}
              {!! $item->nip !!}
            </td>
            <td><div align="left">
              {!!$item->tmlhr!!}<br>
              <?php echo strtoupper(formatTanggalPanjang($item->tglhr))?>
            </div></td>
            <td align="left">{!!$item->golru!!}<br>{!!$item->tmtpkt!!}</td>
            <td><div align="left">{!! $item->jabatan !!} Pada {!! $item->skpdlama !!}</div></td>
            <td><div align="left">{!! $item->jabatanbaru !!} Pada {!! $item->skpdbaru !!}</div></td>
            <td><div align="left">{!! $item->keterangan !!}</div></td>
            <td><div align="center"><br><br><input type="checkbox"></div></td>
          </tr>
          <?php } ?>
          <tr>
          <td colspan="8"  style="text-align: right;"><b>*centang yang disetujui</b></td>
          </tr>
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
                BUPATI<br />
                KABUPATEN KENDAL<br />
                <br />
                <br />
                <br />
                <br />
                <b><u><?php echo $item->bupati?></u><br /><br /></b>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" width="50%">
                <small>
                  <em>e-Simpeg Kab. Kendal <?php echo gmdate("d-m-Y H:i", time()+60*60*7) ?></em>
                </small>
              </td>
              <td colspan="3" align="right" width="50%" style="vertical-align: middle; padding-right: 110px">
                <div id="qrcode"></div></td>
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
            text    : "{!!url().'/digitalsign/mutasi/dalamopd/nominatif/'.$item->nip.'/'.$item->nousul!!}"
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
