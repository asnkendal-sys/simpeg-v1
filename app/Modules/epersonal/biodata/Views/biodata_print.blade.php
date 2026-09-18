<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Profil Pegawai</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: F4 potrait;
                margin-left: 0.4in;
                margin-right: 0.4in;
                margin-top: 0.4in;
                margin-bottom: 0.4in;
            }
            /*p.breakhere { page-break-after: always; }*/
            .page-break	{ display:block; page-break-before:always; }
        }

        body{
            position: relative;
            width: 215mm;
            height: 960mm;
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

        table tr, td{
            font-size: 10px;
            padding: 2px;
        }

        table tbody tr td {
            padding:2px;
            vertical-align:top;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>
<body>
<div class="print"></div>
<div class="page">
<?php
    $nip = Input::get('nip');
    $item = getDetailpegawai($nip);

    $in   = 0;
    $time = '0000-00-00';

    $tek  = \DB::table('r_diktek')->where('nip', $nip)->orderBy('tgmul', 'desc')->first();
    $stru = \DB::table('r_dikstru')->where('nip', $nip)->orderBy('tgmul', 'desc')->first();
    $fung = \DB::table('r_dikfung')->where('nip', $nip)->orderBy('tgmul', 'desc')->first();

    if(count($tek) > 0) { $time = $tek->tgmul; $in = 1; $dik_nm = $tek->nmdiktek; $dik_tmp = $tek->tmdiktek; $dik_tgl = $tek->tgsttpdiktek; $dik_no = $tek->nosttpdiktek; }
    if(count($stru) > 0) { if($stru->tgmul > $time) $time = $stru->tgmul; $in = 2; $dik_nm = $stru->dikstru; $dik_tmp = $stru->tmdikstru; $dik_tgl = $stru->tgsttpdikstru; $dik_no = $stru->nosttpdikstru; }
    if(count($fung) > 0) { if($fung->tgmul > $time) $time = $fung->tgmul; $in = 3; $dik_nm = $fung->dikfung; $dik_tmp = $fung->tmdikfung; $dik_tgl = $fung->tgsttpdikfung; $dik_no = $fung->nosttpdikfung; }

    switch ($in) {
        case '1' : $dt_dik = $tek; break;
        case '2' : $dt_dik = $stru; break;
        case '3' : $dt_dik = $fung; break;
    }

    $pict = "default.jpg";
    if(file_exists("./packages/upload/photo/pegawai/".$item->photo)){
        $pict = $item->photo;
    }else {
        $pict = "default.jpg";
    }
?>

@if(count($item) > 0)
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
    <td colspan="4" align="center">
        <table border="0" cellpadding="0" width="100%">
            <tr valign="top">
                <td width='15%' valign="middle" align="center"><img src="{{url()}}/packages/tugumuda/img/logo.png" width="75"></td>
                <td width="70%" valign="top" align="center">
                    <div style="font-weight: bold; font-size: 15px; padding: 2px; letter-spacing:2px;">
                        PEMERINTAH {!!strtoupper(getUtility('kab_instansi'))!!}
                    </div>
                    <div style="font-weight: bold; font-size: 15px; padding-bottom: 2px; letter-spacing:2px;">
                        {!!strtoupper(getUtility('nma_instansi'))!!}
                    </div>
                    <div style="font-weight: bold;">
                        {!!getUtility('alm_instansi')!!} Telp. {!!getUtility('telp_instansi')!!}, Fax. {!!getUtility('fax_instansi')!!}<br>
                        WEBSITE : {!!getUtility('link_instansi')!!}  E-MAIL : {!!getUtility('email_instansi')!!}<br>
                    </div>
                </td>
                <td width="15%">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="4">
        <div style="border-top: 2px solid #000000; margin-bottom: 2px;"></div>
        <div style="border-top: 1px solid #000000;"></div>
    </td>
</tr>
<tr>
    <td colspan="4" align="center">
        <br><h3><b>BIODATA PEGAWAI</b></h3><br>
    </td>
</tr>
<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">LOKASI KERJA</div></td></tr>
<tr>
    <td width="">UNIT KERJA</td>
    <td width="">:</td>
    <td width="">{!!$item->unit!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">SUB UNIT KERJA</td>
    <td width="">:</td>
    <td width="">{!!$item->skpd!!}</td>
    <td>&nbsp;</td>
</tr>
<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">IDENTITAS PEGAWAI</div></td></tr>
<tr>
    <td width="250">NIP</td>
    <td width="5">:</td>
    <td width="">{!!$item->nip!!}</td>
    <td width="150" rowspan="8"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}" width="130" height="170"></td>
</tr>
<tr>
    <td width="">NAMA</td>
    <td width="">:</td>
    <td width="">{!!$item->namalengkap!!}</td>
</tr>
<tr>
    <td width="">TEMPAT LAHIR</td>
    <td width="">:</td>
    <td width="">{!!$item->tmlhr!!}</td>
</tr>
<tr>
    <td width="">TANGGAL LAHIR</td>
    <td width="">:</td>
    <td width="">{!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
</tr>
<tr>
    <td width="">JENIS KELAMIN</td>
    <td width="">:</td>
    <td width="">{!!$item->jenkel!!}</td>
</tr>
<tr>
    <td width="">AGAMA</td>
    <td width="">:</td>
    <td width="">{!!$item->agama!!}</td>
</tr>
<tr>
    <td width="">STATUS PEGAWAI</td>
    <td width="">:</td>
    <td width="">{!!$item->stspeg!!}</td>
</tr>
<tr>
    <td width="">JENIS KEPEGAWAIAN</td>
    <td width="">:</td>
    <td width="">{!!$item->jenkepeg!!}</td>
</tr>
<tr>
    <td width="">STATUS PERKAWINAN</td>
    <td width="">:</td>
    <td width="">{!!$item->stskawin!!}</td>
</tr>
<tr>
    <td width="">KEDUDUKAN PEGAWAI</td>
    <td width="">:</td>
    <td width="">{!!$item->jenkedudupeg!!}</td>
</tr>

<tr>
    <td width="">ALAMAT</td>
    <td width="">:</td>
    <td width="">
        {!!$item->alm!!} {!! ($item->almrt!='')? 'RT. '.$item->almrt.'':'' !!} {!! ($item->almrt!='' && $item->almrw!='' )? '/':'' !!} {!! ($item->almrw!='')? 'RW. '.$item->almrw.'':'' !!} <br/> {!! ($item->almdesa!='')? 'Desa/Kel. '.$item->almdesa.'':'' !!} {!! ($item->almkec!='')? 'Kec. '.$item->almkec.'':'' !!} {!! ($item->almkab!='')? 'Kab/Kota. '.$item->almkab.'':'' !!} <br/> {!! ($item->almprov!='')? 'Prov. '.$item->almprov.'':'' !!} {!! ($item->almkdpos!='')? 'Kode Pos.'.$item->almkdpos.'':'' !!}
    </td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4">&nbsp;</td></tr>

<tr>
    <td width="">TELEPON</td>
    <td width="">:</td>
    <td width="">{!!$item->telp!!}</td>
    <td>&nbsp;</td>
</tr>

<tr>
    <td width="">NO KARPEG</td>
    <td width="">:</td>
    <td width="">{!!$item->nokarpeg!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">NO KARTU ASKES</td>
    <td width="">:</td>
    <td width="">{!!$item->noaskes!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">KARTU TASPEN</td>
    <td width="">:</td>
    <td width="">{!!$item->notaspen!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">KARTU KARIS/KARSU</td>
    <td width="">:</td>
    <td width="">{!!$item->nokaris!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">NPWP</td>
    <td width="">:</td>
    <td width="">{!!$item->nonpwp!!}</td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">PENGANGKATAN SEBAGAI CPNS</div></td></tr>

<tr>
    <td width="">NO SK CPNS</td>
    <td width="">:</td>
    <td width="">{!!$item->noskcpn!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL SK CPNS</td>
    <td width="">:</td>
    <td width="">{!!date('d-m-Y', strtotime($item->tgskcpn))!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">PANGKAT CPNS</td>
    <td width="">:</td>
    <td width="">{!!$item->golrucpn." ".$item->pangkatcpn!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TMT CPNS</td>
    <td width="">:</td>
    <td width="">{!!date('d-m-Y', strtotime($item->tmtcpn))!!}</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">MASA KERJA</td>
    <td width="">:</td>
    <td width="">{!!$item->mkthncpn." tahun ".$item->mkblncpn." bulan"!!}</td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">PENGANGKATAN SEBAGAI PNS</div></td></tr>

<tr>
    <td width="">NO SK PNS</td>
    <td width="">:</td>
    <td width=""><?=$item->noskpns?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL SK PNS</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tgskpns))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">PANGKAT PNS</td>
    <td width="">:</td>
    <td width=""><?=$item->golrupns." ".$item->pangkatpns?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TMT PNS</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tmtpns))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">MASA KERJA</td>
    <td width="">:</td>
    <td width=""><?=$item->mkthnpns." tahun ".$item->mkblnpns." bulan"?></td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">KENAIKAN PANGKAT TERAKHIR</div></td></tr>

<tr>
    <td width="">NO SK</td>
    <td width="">:</td>
    <td width=""><?=$item->noskpkt?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL SK</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tgskpkt))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">PANGKAT</td>
    <td width="">:</td>
    <td width=""><?=$item->golrupkt." ".$item->pangkatpkt?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TMT</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tmtpkt))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">MASA KERJA</td>
    <td width="">:</td>
    <td width=""><?=$item->mkthnpkt." tahun ".$item->mkblnpkt." bulan"?></td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">KENAIKAN GAJI BERKALA (KGB) TERAKHIR</div></td></tr>

<tr>
    <td width="">NO SK</td>
    <td width="">:</td>
    <td width=""><?=$item->noskkgb?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL SK</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tgskkgb))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TMT</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tmtkgb))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">MASA KERJA</td>
    <td width="">:</td>
    <td width=""><?=$item->mkgolthnkgb." tahun ".$item->mkgolblnkgb." bulan"?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">GAJI POKOK</td>
    <td width="">:</td>
    <td width=""><?='Rp. '.$item->gaji?></td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">PENDIDIKAN UMUM TERAKHIR</div></td></tr>

<tr>
    <td width="">NO IJAZAH</td>
    <td width="">:</td>
    <td width=""><?=$item->noijaz?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL IJAZAH</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->thijaz))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TINGKAT PENDIDIKAN</td>
    <td width="">:</td>
    <td width=""><?=$item->tkpendid?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">JURUSAN PENDIDIKAN</td>
    <td width="">:</td>
    <td width=""><?=$item->jenjurusan?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">SEKOLAH / UNIVERSITAS</td>
    <td width="">:</td>
    <td width=""><?=$item->namasekolah?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TEMPAT</td>
    <td width="">:</td>
    <td width=""><?=$item->almsekolah?></td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">DIKLAT STRUKTURAL TERAKHIR</div></td></tr>

<tr>
    <td width="">STTP NO</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?$stru->nosttpdikstru:''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">STTP TANGGAL</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?date('d-m-Y', strtotime($stru->tgsttpdikstru)):''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">NAMA DIKLAT</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?$stru->dikstru:''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TEMPAT</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?$stru->tmdikstru:''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">PENYELENGGARA</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?$stru->penyelenggara:''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TANGGAL MULAI</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?(date('d-m-Y', strtotime($stru->tgmul))):''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TANGGAL SELESAI</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?(date('d-m-Y', strtotime($stru->tgsel))):''?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">JUMLAH JAM</td>
    <td width="">:</td>
    <td width=""><?php echo (count($stru) > 0)?$stru->jamhari:''?></td>
    <td>&nbsp;</td>
</tr>

<tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">JABATAN STRUKTURAL/FUNGSIONAL TERAKHIR</div></td></tr>

<tr>
    <td width="">NO SK</td>
    <td width="">:</td>
    <td width=""><?=$item->noskjbt?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TGL SK</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tgskjbt))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">TMT</td>
    <td width="">:</td>
    <td width=""><?=date('d-m-Y', strtotime($item->tmtjbt))?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">ESELON</td>
    <td width="">:</td>
    <td width=""><?=$item->esl?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="">NAMA JABATAN</td>
    <td width="">:</td>
    <td width=""><?=$item->jabatan?></td>
    <td>&nbsp;</td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>

</table>

    <?php if(Input::get('p1') || Input::get('p2') || Input::get('p3') || Input::get('p4') || Input::get('p5') || Input::get('p6') || Input::get('p7') || Input::get('p8') || Input::get('p9') || Input::get('p10') || Input::get('p11') || Input::get('p12') || Input::get('p13') || Input::get('p14') || Input::get('p15') || Input::get('p16') || Input::get('p17')) {  ?>
    <div align="center">
        <h3><b>DAFTAR RIWAYAT</b></h3><br>
    </div>
        <?php } ?>

    @if(Input::get('p1'))
    <b>A. Riwayat Jabatan</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <?php $cek = \DB::table('tb_01 as a')->select('a.idjenjab', 'b.isguru')->leftjoin('a_jabfung as b', 'a.idjabfung', '=', 'b.idjabfung')->where('nip', $nip)->first();?>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA JABATAN</div></th>
            @if($cek->idjenjab == 1)
            <th><div class="text-center">ESELON</div></th>
            @endif
            <th><div class="text-center">NO. SK</div></th>
            <th><div class="text-center">TANGGAL SK</div></th>
            <th><div class="text-center">TMT JABATAN</div></th>
            @if($cek->isguru == 1)
            <th><div class="text-center">TUGAS GURU</div></th>
            <th><div class="text-center">MATA PELAJARAN</div></th>
            @elseif($cek->isguru == 2)
            <th><div class="text-center">TUGAS DOKTER</div></th>
            @endif
            @if($cek->idjenjab == 2)
            <th><div class="text-center">PAK</div></th>
            @endif
            <th><div class="text-center">UNIT KERJA</div></th>
        </tr>
        </thead>
        <tbody>
            <?php
                $n  = 0;
                $rs = BiodataModel::getRjab($nip);
            ?>

            @if(count($rs->get()) > 0)
                @foreach($rs->get() as $item)
                    <?php $n++; ?>
                    <tr>
                        <td align="center">{!!$n!!}</td>
                        <td>{!!$item->jab!!}</td>
                        @if($cek->idjenjab == 1)
                        <td>{!!$item->esl!!}</td>
                        @endif
                        <td>{!!$item->nosk!!}</td>
                        <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
                        <td align="center">{!!date('d-m-Y', strtotime($item->tmtjab))!!}</td>
                        @if($cek->isguru == 1)
                        <td>{!!$item->tugasgurudosen!!}</td>
                        <td>{!!$item->matkulpel!!}</td>
                        @elseif($cek->isguru == 2)
                        <td>{!!$item->tugasdokter!!}</td>
                        @endif
                        @if($cek->idjenjab == 2)
                        <td>{!!($item->nopak=='')?'':$item->nopak!!}</td>
                        @endif
                        <td>{!!$item->skpd!!}</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="12">Riwayat Jabatan belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p2'))
    <b>B. Riwayat Pangkat</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">GOL. RUANG</div></th>
            <th><div class="text-center">PEJABAT PENETAP</div></th>
            <th><div class="text-center">NO. SK</div></th>
            <th><div class="text-center">TANGGAL SK</div></th>
            <th><div class="text-center">TMT SK</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRpangkat($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
                <tr>
                    <td align="center">{!!$n!!}</td>
                    <td>{!!$item->golru." - ".$item->pangkat!!}</td>
                    <td>{!!$item->jabatan!!}</td>
                    <td>{!!$item->nosk!!}</td>
                    <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
                    <td align="center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="6">Riwayat Pangkat belum tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p3'))
    <b>C. Riwayat Pendidikan</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th valign="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">TK. PENDIDIKAN</div></th>
            <th><div class="text-center">JURUSAN</div></th>
            <th><div class="text-center">NAMA SEKOLAH</div></th>
            <th><div class="text-center">TEMPAT</div></th>
            <th><div class="text-center">NO. IJAZAH</div></th>
            <th><div class="text-center">TGL. IJAZAH</div></th>
            <th><div class="text-center">KEPALA SEKOLAH</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRpend($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
                <tr>
                    <td align="center">{!!$n!!}.</td>
                    <td>{!!$item->tkpendid!!}</td>
                    <td>{!!$item->jenjurusan!!}</td>
                    <td>{!!$item->namasekolah!!}</td>
                    <td>{!!$item->tempat!!}</td>
                    <td>{!!$item->noijaz!!}</td>
                    <td>{!!date('d-m-Y', strtotime($item->tgijaz))!!}</td>
                    <td>{!!$item->kepsek!!}</td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="8">Riwayat Pendidikan belum tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p4'))
    <b>D. Riwayat Diklat Struktural</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA DIKLAT</div></th>
            <th><div class="text-center">TEMPAT DIKLAT</div></th>
            <th><div class="text-center">PENYELENGGARA</div></th>
            <th><div class="text-center">ANGKATAN</div></th>
            <th><div class="text-center">TGL. MULAI</div></th>
            <th><div class="text-center">TGL. SELESAI</div></th>
            <th><div class="text-center">LAMA</div></th>
            <th><div class="text-center">NO. STTP</div></th>
            <th><div class="text-center">TGL. STTP</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRdikstru($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->dikstru!!}</td>
                <td>{!!$item->tmdikstru!!}</td>
                <td>{!!$item->penyelenggara!!}</td>
                <td>{!!$item->angkatan!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                <td>{!!$item->jamhari!!} Jam </td>
                <td>{!!$item->nosttpdikstru!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsttpdikstru))!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">Riwayat Diklat Struktural belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p5'))
    <b>E. Riwayat Diklat Fungsional</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA DIKLAT</div></th>
            <th><div class="text-center">TEMPAT DIKLAT</div></th>
            <th><div class="text-center">PENYELENGGARA</div></th>
            <th><div class="text-center">ANGKATAN</div></th>
            <th><div class="text-center">TGL. MULAI</div></th>
            <th><div class="text-center">TGL. SELESAI</div></th>
            <th><div class="text-center">LAMA</div></th>
            <th><div class="text-center">NO. STTP</div></th>
            <th><div class="text-center">TGL. STTP</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRdikfung($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->dikfung!!}</td>
                <td>{!!$item->tmdikfung!!}</td>
                <td>{!!$item->penyelenggara!!}</td>
                <td>{!!$item->angkatan!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                <td>{!!$item->jamhari!!} Jam</td>
                <td>{!!$item->nosttpdikfung!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsttpdikfung))!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">Riwayat Diklat Fungsional belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p6'))
    <b>F. Riwayat Diklat Teknis</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA DIKLAT</div></th>
            <th><div class="text-center">TEMPAT DIKLAT</div></th>
            <th><div class="text-center">PENYELENGGARA</div></th>
            <th><div class="text-center">ANGKATAN</div></th>
            <th><div class="text-center">TGL. MULAI</div></th>
            <th><div class="text-center">TGL. SELESAI</div></th>
            <th><div class="text-center">LAMA</div></th>
            <th><div class="text-center">NO. STTP</div></th>
            <th><div class="text-center">TGL. STTP</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRdiktek($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nmdiktek!!}</td>
                <td>{!!$item->tmdiktek!!}</td>
                <td>{!!$item->penyelenggara!!}</td>
                <td>{!!$item->angkatan!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                <td>{!!$item->jamhari!!} Jam</td>
                <td>{!!$item->nosttpdiktek!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsttpdiktek))!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">Riwayat Diklat Teknis belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p7'))
    <b>G. Riwayat Seminar</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">SEMINAR</div></th>
            <th><div class="text-center">TEMPAT SEMINAR</div></th>
            <th><div class="text-center">PENYELENGGARA</div></th>
            <th><div class="text-center">TANGGAL MULAI</div></th>
            <th><div class="text-center">TANGGAL SELESAI</div></th>
            <th><div class="text-center">NO. PIAGAM</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRseminar($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nmseminar!!}</td>
                <td>{!!$item->tmseminar!!}</td>
                <td>{!!$item->penyelenggara!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                <td>{!!$item->nopiagam!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">Riwayat Seminar belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p8'))
    <b>H. Riwayat Penghargaan</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">TANDA JASA</div></th>
            <th><div class="text-center">JENIS</div></th>
            <th><div class="text-center">TAHUN</div></th>
            <th><div class="text-center">PEJABAT PENETAP</div></th>
            <th><div class="text-center">NO. SK</div></th>
            <th><div class="text-center">TANGGAL SK</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRpenghargaan($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->tandajasa!!}</td>
                <td>{!!$item->namatandajasa!!}</td>
                <td align="center">{!!$item->thn!!}</td>
                <td>{!!$item->nama!!}</td>
                <td>{!!$item->nosk!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">Riwayat Tanda Jasa belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p9'))
    <b>I. Riwayat Penguasaan Bahasa</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA BAHASA</div></th>
            <th><div class="text-center">JENIS BAHASA</div></th>
            <th><div class="text-center">KEMAMPUAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRbahasa($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nama_bahasa!!}</td>
                <td>{!!$item->jenis_bahasa!!}</div></td>
                <td>{!!$item->kemampuan!!}</div></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">Riwayat Bahasa belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p10'))
    <b>J. Riwayat Hukum Disiplin</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">JENIS HUKUM DISIPLIN</div></th>
            <th><div class="text-center">TINGKAT</div></th>
            <th><div class="text-center">PEJABAT</div></th>
            <th><div class="text-center">NO. SK</div></th>
            <th><div class="text-center">TGL. SK</div></th>
            <th><div class="text-center">TGL.&nbsp;MULAI</div></th>
            <th><div class="text-center">TGL.&nbsp;SELESAI</div></th>
            <th><div class="text-center">KETERANGAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRhukdis($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->jenhukum!!}</td>
                <td>{!!$item->kathukdis!!}</td>
                <td>{!!$item->jabatan!!}</td>
                <td>{!!$item->nosk!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsk))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
                <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                <td>{!!$item->ket!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">Riwayat Hukuman Disiplin belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p11'))
    <b>K. Riwayat Sasaran Kerja Pegawai</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NILASI PRESTASI KERJA</div></th>
            <th><div class="text-center">TAHUN</div></th>
            <th><div class="text-center">PEJABAT PENILAI</div></th>
            <th><div class="text-center">JABATAN PENILAI</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRskp($nip);

            function getNilai($nilai){
                $nhuruf = '';
                if(($nilai >= 91) and ($nilai <= 100)){
                    $nhuruf = 'Sangat baik';
                }else if(($nilai >= 76) and ($nilai <= 90)){
                    $nhuruf = 'Baik';
                }else if(($nilai >= 61) and ($nilai <= 75)){
                    $nhuruf = 'Cukup';
                }else if(($nilai >= 51) and ($nilai <= 60)){
                    $nhuruf = 'Kurang';
                }else if($nilai < 50){
                    $nhuruf = 'Buruk';
                }

                return $nhuruf;
            }
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nilai." (".getNilai($item->nilai).")"!!}</td>
                <td>{!!$item->tahun!!}</td>
                <td>{!!$item->pejpenilai!!}</td>
                <td>{!!$item->jabpenilai!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">Riwayat Sasaran Kinerja Pegawai belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p12'))
    <b>L. Riwayat Kenaikan Gaji Berkala</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
            <th rowspan="2"><div class="text-center">NO SKKGB</div></th>
            <th rowspan="2"><div class="text-center">TMT KGB</div></th>
            <th rowspan="2"><div class="text-center">TGL KGB</div></th>
            <th rowspan="2"><div class="text-center">GOLONGAN</div></th>
            <th colspan="2"><div class="text-center">MASA KERJA</div></th>
            <th rowspan="2"><div class="text-center">GAJI</div></th>
            <th rowspan="2"><div class="text-center">PENETAP</div></th>
        </tr>
        <tr>
            <th><div class="text-center">TAHUN</div></th>
            <th><div class="text-center">BULAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRkgb($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}</td>
                <td>{!!$item->noskkgb!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tmtkgb))!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tglkgb))!!}</td>
                <td>{!!$item->golru." - ".$item->pangkat!!}</td>
                <td align="center">{!!$item->mkthn!!}</td>
                <td align="center">{!!$item->mkbln!!}</td>
                <td>{!!"Rp. ".number_format($item->gaji)!!}</td>
                <td>{!!$item->jabatan!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">Riwayat Kenaikan Gaji Berkala belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p13'))
    <b>M. Riwayat Angka Kredit</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
            <th rowspan="2"><div class="text-center">ANGKA KREDIT LAMA</div></th>
            <th rowspan="2"><div class="text-center">NAMA JABATAN</div></th>
            <th rowspan="2"><div class="text-center">NOMOR SK</div></th>
            <th rowspan="2"><div class="text-center">TANGGAL SK</div></th>
            <th colspan="2"><div class="text-center">PERIODE PENILAIAN ANGKA KREDIT</div></th>
            <th rowspan="2"><div class="text-center">KREDIT UTAMA BARU</div></th>
            <th rowspan="2"><div class="text-center">KREDIT PENUNJANG BARU</div></th>
            <th rowspan="2"><div class="text-center">KREDIT BARU TOTAL</div></th>
        </tr>
        <tr>
            <th><div class="text-center">MULAI</div></th>
            <th><div class="text-center">SELESAI</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n  = 0;
        $rs = BiodataModel::getRakredit($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->pak!!}</td>
                <td>{!!$item->jabfung!!}</td>
                <td>{!!$item->nosk!!}</td>
                <td align="center">{!!date("d-m-Y", strtotime($item->tgsk))!!}</td>
                <td align="center">{!!date("d-m-Y", strtotime($item->periodemulai))!!}</td>
                <td align="center">{!!date("d-m-Y", strtotime($item->periodemulai))!!}</td>
                <td>{!!$item->kubaru!!}</td>
                <td>{!!$item->kpbaru!!}</td>
                <td>{!!$item->kbtotal!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">Riwayat Angka Kredit belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p14'))
    <b>N. Riwayat Data Anak</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA ANAK</div></th>
            <th><div class="text-center">TEMPAT LAHIR</div></th>
            <th><div class="text-center">TGL. LAHIR</div></th>
            <th><div class="text-center">JENIS KELAMIN</div></th>
            <th><div class="text-center">STATUS KELUARGA</div></th>
            <th><div class="text-center">PENDIDIKAN UMUM</div></th>
            <th><div class="text-center">PEKERJAAN</div></th>
            <th><div class="text-center">TUNJANGAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n  = 0;
        $rs = BiodataModel::getRanak($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nmanak!!}</td>
                <td>{!!$item->tmlhr!!}</td>
                <td>{!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
                <td align="center">{!!$item->jenkel!!}</td>
                <td align="center">{!!$item->stskeluarga!!}</td>
                <td>{!!$item->pendidum!!}</td>
                <td>{!!$item->peker!!}</td>
                <td>{!!$item->tunjang!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">Riwayat Anak belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p15'))
    <b>O. Riwayat Data Istri/Suami</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">No</div></th>
            <th><div class="text-center">NAMA ISTRI/SUAMI*</div></th>
            <th><div class="text-center">TEMPAT LAHIR</div></th>
            <th><div class="text-center">TGL. LAHIR</div></th>
            <th><div class="text-center">NO. AKTA NIKAH</div></th>
            <th><div class="text-center">TGL. NIKAH</div></th>
            <th><div class="text-center">NIP/NRP</div></th>
            <th><div class="text-center">PENDIDIKAN UMUM</div></th>
            <th><div class="text-center">PEKERJAAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRissu($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nmissu!!}</td>
                <td>{!!$item->tmlhr!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
                <td>{!!$item->noaktanikah!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tgnikah))!!}</td>
                <td>{!!$item->nipnrp!!}</td>
                <td>{!!$item->pendidum!!}</td>
                <td>{!!($item->peker==1)?"PNS":"Non PNS"!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">Riwayat Istri / Suami belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p16'))
    <b>P. Riwayat Data Saudara</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA</div></th>
            <th><div class="text-center">TGL. LAHIR</div></th>
            <th><div class="text-center">PEKERJAAN</div></th>
            <th><div class="text-center">JENIS KELAMIN</div></th>
            <th><div class="text-center">STATUS SAUDARA</div></th>
            <th><div class="text-center">KETERANGAN</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $n  = 0;
            $rs = BiodataModel::getRsaudara($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nama!!}</td>
                <td align="center">{!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
                <td>{!!$item->peker!!}</td>
                <td>{!!$item->jenkel!!}</td>
                <td>{!!$item->stssaudara!!}</td>
                <td>{!!$item->ket!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">Riwayat Saudara belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
    @endif

    @if(Input::get('p17'))
    <b>Q. Riwayat Data Orang Tua</b>
    <table id="tb-rjab" class="table table-hovered table-bordered" border="1">
        <thead>
        <tr>
            <th width="2%"><div class="text-center">NO</div></th>
            <th><div class="text-center">NAMA ORANG TUA</div></th>
            <th><div class="text-center">STATUS</div></th>
            <th><div class="text-center">TEMPAT LAHIR</div></th>
            <th><div class="text-center">TANGGAL LAHIR</div></th>
            <th><div class="text-center">ALAMAT</div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n  = 0;
        $rs = BiodataModel::getRortu($nip);
        ?>

        @if(count($rs->get()) > 0)
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>{!!$item->nama_ortu!!}</td>
                <td>{!!$item->stat!!}</td>
                <td>{!!$item->tempat_lahir!!}</td>
                <td>{!!date('d-m-Y', strtotime($item->tgl_lahir))!!}</td>
                <td>{!!$item->alamat!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">Riwayat Orang Tua belum tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table><br>
             <table style="width: 100%; margin-top: 50px;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <?php
                $item = getDetailpegawai($nip);
                function tgl_indo($tanggal)
                {
                    $bulan = array(
                        1 =>   'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    $pecahkan = explode('-', $tanggal);
                    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
                }


                ?>
                <p>Kendal, <?= tgl_indo(date('Y-m-d')); ?> </p>
                <div style="height: 80px;">
                    <!-- Ruang Kosong untuk Tanda Tangan -->
                </div>
                <p>{!!$item->namalengkap!!}</p>
            </td>
            <td style="width: 50%; text-align: center;">


            </td>
        </tr>
    </table>
    @endif

@else
    Data tidak ditemukan.
@endif
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
