<html>
<head>
<title>Nominatif Perpanjangan PPPK</title>
<link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
<link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: A4 landscape;
                margin-left: 0.4in;
                margin-right: 0.4in;
                margin-top: 0.4in;
                margin-bottom: 0.4in;
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
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>
<body>
<div class="print"></div>
<div id="F4-landscape">

    <?php
        $jml = count($item);
        if($jml < 1){
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }   
    ?>    
    <div align="center">
    <h3>NOMINATIF PERPANJANGAN KONTRAK PPPK</h3>    
    @if($id == 'all')
        <h3>{!!(($kode != '')?'PERIODE '.strtoupper(getBulan(date('Y').'-'.$kode.'-01')):'')!!} {!!(($tmtawal != '')?'TAHUN '.$tmtawal:'')!!}</h3>
    @elseif($id == 'kolektif')
        <h3>{!!(($kode != '')?'PADA '.strtoupper(getSkpd($kode)):'')!!}</h3>
        <h3>{!!(($tmtawal != '')?'PERIODE '.strtoupper(getBulan($tmtawal)).' TAHUN '.date('Y', strtotime($tmtawal)):'')!!}</h3>
    @endif
    </div><br>
    
    <?php 
        $pengantar_jabatan = @$item[0]->jabpen_sp;
        $pengantar_nosk = @$item[0]->nosk_pengantar;
        $pengantar_tanggal = formatTanggalPanjang(@$item[0]->tgl_skpengantar);
        $pengantar_nama = @$item[0]->pejpen_sp;
        $pengantar_pangkat = @$item[0]->golpen_sp;
        $pengantar_nip = @$item[0]->nippen_sp;
    ?>
    <table border="0" cellpadding="0" width="100%">
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Lampiran</td>
            <td width="2%" align="center">:</td>
            <td>Surat {!! $pengantar_jabatan !!} </td>
        </tr>
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Nomor</td>
            <td width="2%" align="center">:</td>
            <td>{!! $pengantar_nosk !!}</td>
        </tr>
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Tanggal</td>
            <td width="2%" align="center">:</td>
            <td>{!! $pengantar_tanggal !!}</td>
        </tr>
    </table>
    <br>

    <table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
        <thead class="bg-primary">
        <tr>
            <th rowspan="2" width="3%"><div class="text-center">NO</div></th>
            <th rowspan="2" width="15%">
                <div class="text-left">NAMA</div>
                <div class="text-left">NIP PPPK</div>
            </th>
            <th rowspan="2" width="10%">
                <div class="text-center">TEMPAT</div>
                <div class="text-center">TANGGAL LAHIR</div>
            </th>
            <th rowspan="2" width="15%">
                <div class="text-center">PENDIDIKAN</div>            
            </th>        
            <th rowspan="2" width="20%">
                <div class="text-center">JABATAN</div>                
            </th>                    
            <th rowspan="2" width="22%">
                <div class="text-center">UNIT KERJA</div>                
            </th>
            <th colspan="2" width="10%">RENCANA KONTRAK</th>            
            <th colspan="3" width="15%">RENCANA PERJANJIAN</th>            
        </tr>
        <tr>
            <th width="5%">TAHUN</th>
            <th width="5%">BULAN</th>
            <th width="5%">AWAL</th>
            <th width="5%">AKHIR</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><div align="center">1</div></td>
            <td><div align="center">2</div></td>
            <td><div align="center">3</div></td>
            <td><div align="center">4</div></td>
            <td><div align="center">5</div></td>
            <td><div align="center">6</div></td>
            <td><div align="center">7</div></td>
            <td><div align="center">8</div></td> 
            <td><div align="center">9</div></td> 
            <td><div align="center">10</div></td> 
        </tr>
        <?php $n = 0; ?>
        @foreach($item as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>
                <div class="text-left">{!!$item->nama!!}</div>                                
                <div class="text-left">{!!$item->nip!!}</div>                                
            </td>
            <td>
                <div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div>
            </td>
            <td>
                <div class="text-left">{!!ucwords($item->jenjurusan)!!}</div>
            </td>
            <td>                
                <div class="text-left">{!!ucwords($item->jab)!!}</div>                                
            </td>                          
            <td>
                <div class="text-left">{!!strtoupper($item->skpd)!!}</div>
            </td>
            @if($item->status==1)
                @if($item->sts_kontrak==2)
                    <td>
                        <div align="center">{!! $item->perpanjangan !!}</div>                
                    </td>
                    <td>
                        <div align="center">{!! $item->perpanjangan_bulan !!}</div>                
                    </td>
                    <td>
                        <div align="center">{!! date('d-m-Y', strtotime($item->tmtawal)) !!}</div>                
                    </td>
                    <td>
                        <div align="center">{!! date('d-m-Y', strtotime($item->tmtakhir)) !!}</div>                
                    </td>
                @elseif($item->sts_kontrak==3)
                    <td colspan="4"><b>Diusulkan Pensiun</b> <br>{!! $item->keterangan !!} <br> TMT {!! date('d-m-Y', strtotime($item->bup)) !!}</td>
                @else
                    <td colspan="4">-</td>
                @endif
            @else
                <td colspan="4"><b>Tidak Diusulkan</b> <br>{!! $item->status_keterangan !!}</td>
            @endif            
        </tr>
        @endforeach
        
    </tbody>
    </table>

    <table border="0" cellpadding="0" width="100%">
        <tbody>
        <tr>
            <td colspan="3" width="50%">
                &nbsp;</td>
            <td align="left" width="50%">
                <div style="float: right; width: 50%; margin-right: 1em;">
                    <br>
                    {!! strtoupper(getKepskpd($kode, 'jab')) !!}<br />
                    KABUPATEN KENDAL<br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <b>                                                                            
                        <u>{!! $pengantar_nama !!}</u><br />
                        {!! $pengantar_pangkat !!}<br />
                        NIP. {!! $pengantar_nip !!}</b>
                </div>
            </td>
        </tr>        
        </tbody>
    </table>

    <div class="page-break"> </div>
    {{-- Tidak diusulkan / pensiun --}}

    <div align="center">
    <h3>NOMINATIF TIDAK DIUSULKAN PERPANJANGAN KONTRAK PPPK</h3>    
    @if($id == 'all')
        <h3>{!!(($kode != '')?'PERIODE '.strtoupper(getBulan(date('Y').'-'.$kode.'-01')):'')!!} {!!(($tmtawal != '')?'TAHUN '.$tmtawal:'')!!}</h3>
    @elseif($id == 'kolektif')
        <h3>{!!(($kode != '')?'PADA '.strtoupper(getSkpd($kode)):'')!!}</h3>
        <h3>{!!(($tmtawal != '')?'PERIODE '.strtoupper(getBulan($tmtawal)).' TAHUN '.date('Y', strtotime($tmtawal)):'')!!}</h3>
    @endif
    </div><br>
    
    <table border="0" cellpadding="0" width="100%">
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Lampiran</td>
            <td width="2%" align="center">:</td>
            <td>Surat {!! $pengantar_jabatan !!} </td>
        </tr>
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Nomor</td>
            <td width="2%" align="center">:</td>
            <td>{!! $pengantar_nosk !!}</td>
        </tr>
        <tr>
            <td width="70%">&nbsp;</td>
            <td width="6%">Tanggal</td>
            <td width="2%" align="center">:</td>
            <td>{!! $pengantar_tanggal !!}</td>
        </tr>
    </table>
    <br>

    <table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
        <thead class="bg-primary">
        <tr>
            <th width="3%"><div class="text-center">NO</div></th>
            <th width="15%">
                <div class="text-left">NAMA</div>
                <div class="text-left">NIP PPPK</div>
            </th>
            <th width="10%">
                <div class="text-center">TEMPAT</div>
                <div class="text-center">TANGGAL LAHIR</div>
            </th>
            <th width="15%">
                <div class="text-center">PENDIDIKAN</div>            
            </th>        
            <th width="20%">
                <div class="text-center">JABATAN</div>                
            </th>                    
            <th width="22%">
                <div class="text-center">UNIT KERJA</div>                
            </th>
            <th width="15%">KETERANGAN</th>            
        </tr>        
    </thead>
    <tbody>
        <tr>
            <td><div align="center">1</div></td>
            <td><div align="center">2</div></td>
            <td><div align="center">3</div></td>
            <td><div align="center">4</div></td>
            <td><div align="center">5</div></td>
            <td><div align="center">6</div></td>
            <td><div align="center">7</div></td>
        </tr>
        <?php $n = 0; ?>
        @foreach($item2 as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>
                <div class="text-left">{!!$item->nama!!}</div>                                
                <div class="text-left">{!!$item->nip!!}</div>                                
            </td>
            <td>
                <div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div>
            </td>
            <td>
                <div class="text-left">{!!ucwords($item->jenjurusan)!!}</div>
            </td>
            <td>                
                <div class="text-left">{!!ucwords($item->jab)!!}</div>                                
            </td>                          
            <td>
                <div class="text-left">{!!strtoupper($item->skpd)!!}</div>
            </td>
            @if($item->status==1)
                @if($item->sts_kontrak==3)
                    <td colspan="3"><b>Diusulkan Pensiun</b> <br>{!! $item->keterangan !!} <br> TMT {!! date('d-m-Y', strtotime($item->bup)) !!}</td>
                @else
                    <td colspan="3">-</td>
                @endif
            @else
                <td colspan="3"><b>Tidak Diusulkan</b> <br>{!! $item->status_keterangan !!}</td>
            @endif            
        </tr>
        @endforeach
        
    </tbody>
    </table>
    <table border="0" cellpadding="0" width="100%">
        <tbody>
        <tr>
            <td colspan="3" width="50%">
                &nbsp;</td>
            <td align="left" width="50%">
                <div style="float: right; width: 50%; margin-right: 1em;">
                    <br>
                    {!! strtoupper(getKepskpd($kode, 'jab')) !!}<br />
                    KABUPATEN KENDAL<br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <b>                                                                            
                        <u>{!! $pengantar_nama !!}</u><br />
                        {!! $pengantar_pangkat !!}<br />
                        NIP. {!! $pengantar_nip !!}</b>
                </div>
            </td>
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
