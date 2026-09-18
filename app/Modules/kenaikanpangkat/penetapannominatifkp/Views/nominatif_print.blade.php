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
      margin-left: 1cm;
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

  #tablex.table tbody > tr > td{
      border: none;
      padding: .4em;
  }

  div.print{
    background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
    width:110px;
    height:110px;
    top:10;
    right:10;
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
    $idskpd = Input::get('idskpd');
    $tgl_sp = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    $where = "tr_kenaikan_pangkat.nousul = \"".$nousul."\"";
    if(session('role_id') > 3){
        $idskpd = session('idskpd');
        $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
    }
    $skpd = \App\Models\Master\Skpd::where('idskpd','=',$idskpd)->first();

    $rs =  \DB::table('tr_kenaikan_pangkat')
            ->select('tr_kenaikan_pangkat.*','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','tb_01.tmlhr','tb_01.tglhr','a_golruang.pangkat','a_golruang.golru',
            'tb_01.nopak as nopaklama', 'a_golruangbaru.golru as golrubaru', 'a_golruangbaru.pangkat as pangkatbaru',
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,58))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
        ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tr_kenaikan_pangkat.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tr_kenaikan_pangkat.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
        ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->whereRaw($where)
        ->get();

  ?>

  <div id="">
    <table border="0" cellpadding="0" width="100%">
      <tr>
        <td><p><h3 align="center">DAFTAR NOMINATIF KENAIKAN PANGKAT</h3></p>
          <p><h3 align="center">{!! strtoupper($skpd->path_short) !!} PERIODE <?php echo strtoupper(formatTanggalPanjang($rs[0]->tmt))?></h3></p>
        </td> 
      </tr>
    </table>
    <table border="0" class="teble" cellpadding="0" width="20%" id="tablex">
        <tbody>
            <tr>
                <td width="40%">Nomor Usul</td><td>: {!! $no_sp !!}</td>
            </tr>
            <tr>
                <td width="40%">Tanggal Usul</td><td>: {!! formatTanggalPanjang($tgl_sp) !!}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table" border="1" cellpadding="0" width="100%" style="font-size:8pt">
        <thead>
            <tr>
                <th align="center" rowspan="2" width="1%">NO</th>
                <th align="center" rowspan="2" width="16%">NAMA LENGKAP<br>TEMPAT, TGL. LAHIR</th>
                <th align="center" rowspan="2" width="10%">NIP</th>
                <th align="center" colspan="4" >Lama</th>
                <th align="center" colspan="4" >Baru</th>
                <th align="center" rowspan="2" width="10%">Unit Kerja</th>
                <th align="center" colspan="4">Atasan Langsung</th>
            </tr>
            <tr>
                <th align="center" width="8%">Pangkat<br>Gol/Ruang<br>TMT</th>
                <th align="center" width="8%">Masa Kerja Gol<br>Gaji Pokok</th>
                <th align="center" width="8%">Pendidikan<br>Tahun Lulus</th>
                <th align="center" width="8%">Jabatan<br>TMT<br>Jumlah AK</th>
                <th align="center" width="8%">Pangkat<br>Gol/Ruang<br>TMT</th>
                <th align="center" width="8%">Masa Kerja Gol<br>Gaji Pokok</th>
                <th align="center" width="8%">Pendidikan<br>Tahun Lulus</th>
                <th align="center" width="8%">Jabatan<br>TMT<br>Jumlah AK</th>
                <th align="center" width="8%">Nama<br>NIP</th>
                <th align="center" width="8%">Pangkat, Gol/Ruang<!--<br>TMT--></th>
                <th align="center" width="8%">Jabatan<!--<br>TMT--></th>
                <th align="center" width="8%">TandaTangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $x=0; ?>
            @foreach($rs as $row)
            <tr>
                <td>{!! ++$x !!}</td>
                <td>{!! $row->namalengkap !!}<br><small>{!! $row->tmlhr !!}, {!!($row->tglhr!='0000-00-00')?date('d-m-Y', strtotime($row->tglhr)):''!!}</small></td>
                <td>{!! $row->nip !!}</td>
                <td align="center">{!! $row->pangkat !!}<br>{!! $row->golru !!}<br>{!! tglina($row->tmtpkt) !!}</td>
                <td>{!! $row->mktkp." Thn ".$row->mkbkp." Bln" !!} <br> {!!uang($row->gkp)!!}</td>
                <td>{!! $row->tkpendid."<br>".$row->jenjurusan !!}</td>
                <td>{!! $row->jabatan !!}<br>{!! tglina($row->tmtjbt) !!}<br>{!! $row->nopaklama !!}</td> 
                <td>{!! $row->pangkatbaru !!}<br>{!! $row->golrubaru !!}<br>{!! tglina($row->tmt) !!}</td>
                <td>{!! $row->mktkpb." Thn ".$row->mkbkpb." Bln" !!} <br> {!!uang($row->gkpb)!!}</td>
                <td>{!! $row->tkpendid."<br>".$row->jenjurusan !!}</td>
                <td>{!! $row->jabatan !!}<br>{!! $row->nopak !!}</td>
                <td>{!! $row->path_short !!}</td>
                <td>{!! $row->atasan_nip !!} <br> {!! $row->atasan_nama !!}</td>
                <td>{!! $row->atasan_pkt!!} <br> {!! $row->atasan_gol!!}<!--<br>{!! tglina($row->tmtpkt) !!}--></td>
                <td>{!! $row->atasan_jab!!}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    </div>
    <br />

  </body>
  </html>

  <script>
    $(document).ready(function(){
     $("#qrcode").qrcode({
      size    : 90,
      render  : "image",
      text    : ""
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