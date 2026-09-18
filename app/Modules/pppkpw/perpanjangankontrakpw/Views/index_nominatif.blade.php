<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Perpanjangan Kontrak<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Perpanjangan Kontrak</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/pppkpw/perpanjangankontrakpw"> <i class="fa fa-fw fa-list-ul"></i> PENJAGAAN PERPANJANGAN PPPK</a></li>                    
                    <li class="active"><a href="{!!url()!!}/pppkpw/perpanjangankontrakpw/indexnominatif"> <i class="fa fa-fw fa-list-ul"></i> PENETAPAN PERPANJANGAN PPPK</a></li>                    
                </ul>

                <div class="box-header with-border">
                    <p>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                <span class="caret"></span> Buat Baru
                            </button>
                            <ul class="dropdown-menu pull-left">
                                <li><a href="{!! url('pppkpw/perpanjangankontrakpw/create') !!}" id="buat"><i class='fa fa-plus-square'></i> Nominatif</a></li>                                
                                <li><a href="{!! url('pppkpw/perpanjangankontrakpw/createaps') !!}" id="buataps"><i class='fa fa-plus-square'></i> Non Nominatif</a></li>                                
                            </ul>
                        </div>
                    </p>                       

                    <div class="col-md-12">
                        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                        {!!csrf_field()!!}
                        <input type="hidden" name="page" id="pageno" value="{!!((Input::get('page') != '')?Input::get('page'):'')!!}">
                        <table class="table">
                            <tr>
                                <td width="10%">Bulan TMT Baru</td>
                                <td width="2%">:</td>
                                <td width="38%">{!! comboBulan("bulan",Input::get('bulan'),"",".: Bulan :.") !!}</td>

                                <td width="10%">Unit Kerja</td>
                                <td width="2%">:</td>
                                <td width="38%">
                                    {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                                </td>
                            </tr>
                            <tr>
                                <td>Tahun TMT Baru</td>
                                <td>:</td>
                                <td>{!! comboTahun("tahun",Input::get('tahun'),"",".: Tahun :.") !!}</td>

                                <td>Status Usulan</td>
                                <td>:</td>
                                <td>{!! PerpanjangankontrakpwModel::comboStatususulan("status",Input::get('status'),"",".: Status Usulan :.")!!}</td>                                
                            </tr>
                            <tr>
                                <td>TTE</td>
                                <td>:</td>
                                <td>
                                    {!! comboStatusTTE('status_tte',Input::get('status_tte')) !!}
                                </td>

                                <td>Status Proses</td>
                                <td>:</td>
                                <td>{!! PenetapannominatifModel::comboStatussk("statussk",Input::get('statussk'),"",".: Status Proses :.")!!}</td>
                            </tr>
                            <tr>
                                <td>Pencarian</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" name="search" id="search" value="{!! \Input::get('search')!!}">
                                </td>

                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>                                    
                                    @if(count($rpppk) > 0)
                                        @if(Input::get('bulan') != '' && Input::get('tahun') != '')
                                            <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download</button>
                                            {{-- <a class="btn btn-warning" href="javascript:void(0)" id="edit-sp-induk-all" tipe="all" rectahun="{!! Input::get('tahun') !!}" recbulan="{!! Input::get('bulan') !!}"><i class="fa fa-pencil"></i> SP Induk</a>
                                            <a class="btn btn-warning" href="javascript:void(0)" id="edit-spk-induk-all" tipe="all" rectahun="{!! Input::get('tahun') !!}" recbulan="{!! Input::get('bulan') !!}"><i class="fa fa-pencil"></i> SPK Induk</a> --}}
                                        @endif
                                    @endif
                                    @if(count($rpppk) > 0)
                                        @if(Input::get('bulan') != '' && Input::get('tahun') != '' && Input::get('idskpd') == '' && Input::get('statussk') == '' && Input::get('pencarian') == '' && Input::get('status_tte') == '')
                                            @if(PerpanjangankontrakpwModel::cekSkinduk(Input::get('bulan'), Input::get('tahun')) > 0)
                                            <a class="btn btn-warning" href="javascript:void(0)" disabled onclick="bootbox.alert('Input Nomor SK Induk belum dapat dilakukan karena masih ada usulan yang belum dilakukan verifikasi. Semua usulan harus dilakukan verifikasi sebelum melakukan input Nomor SK Induk.')"><i class="fa fa-pencil"></i> SK Induk</a>
                                            @else
                                            <a class="btn btn-warning" href="javascript:void(0)" id="edit-sk-induk-all" tipe="all" rectahun="{!! Input::get('tahun') !!}" recbulan="{!! Input::get('bulan') !!}"><i class="fa fa-pencil"></i> SK Induk</a>
                                            @endif
                                            <a class="btn btn-warning" href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/nominatifsk/all/{!! Input::get('bulan') !!}/{!! Input::get('tahun') !!}" target="_blank" title="Cetak CPPPK"><i class="fa fa-print"></i> Cetak Nominatif</a>
                                            {{-- <a class="btn btn-success" href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/sp/all/{!! Input::get('bulan') !!}/{!! Input::get('tahun') !!}" target="_blank" title="Cetak SP"><i class="fa fa-print"></i> Cetak SP</a>
                                            <a class="btn btn-success" href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/spk/all/{!! Input::get('bulan') !!}/{!! Input::get('tahun') !!}" target="_blank" title="Cetak SPK"><i class="fa fa-print"></i> Cetak SPK</a> --}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr> --}}
                        </table>
                        {!! Form::close() !!}
                    </div>                    
                </div>
                {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
                <div class="table-responsive">
                    <div class="box-body no-padding">
                        <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                            <thead class="bg-primary">
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2" width="15%">NIP<br>NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>                                
                                <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA </th>
                                <th colspan="2">PENDIDIKAN TERAKHIR</th>
                                <th rowspan="2">GOL.</th>
                                <th colspan="2">MASA KERJA</th>
                                <th colspan="2">RENCANA KONTRAK</th>
                                <th colspan="2">RENCANA PERJANJIAN</th>
                                <th rowspan="2" width="10%">USIA</th>
                                <th colspan="4">STATUS</th>
                                <th rowspan="2" width="8%">AKSI</th>
                            </tr>
                            <tr>
                                <th>JENJANG</th>
                                <th>JURUSAN</th>
                                <th>THN</th>
                                <th>BLN</th>
                                <th>THN</th>
                                <th>BLN</th>
                                <th>MULAI</th>
                                <th>SELESAI</th>                                
                                <th>USUL</th>
                                <th>PROS</th>
                                <th>SK</th>
                                <th>TTE</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                                    $arr[0]= "";
                                    $n = 0;
                                    $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                                ?>
                                @foreach ($rpppk as $pppk)
                                <?php
                                    $x++;
                                    $n++;
                                    $arr[$n] = substr($pppk->idskpd, 0,2).'_'.$pppk->tmtawal;

                                    if($arr[$n]!=$arr[$n-1]){
                                ?>
                                        <tr>
                                            <th style="position:relative;" colspan="9">
                                                <div class="text-left">
                                                    {{-- NOMOR USULAN : {{$nominatifdalamskpd->nousul}}&nbsp; --}}
                                                    <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($pppk->tmtawal))?>
                                                    &nbsp;
                                                    <?php echo "||&nbsp;".getskpdgroup(substr($pppk->idskpd, 0,2)); ?>&nbsp;
                                                    <br>
                                                </div>
                                            </th>
                                            <th style="position:relative;" colspan="9">
                                                <div class="text-right">
                                                        {{-- <div class="btn-group">                                                            
                                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                                <i class="fa fa-list"></i> Nominatif
                                                            </button>
                                                            <ul class="dropdown-menu pull-right">
                                                                <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/pengantarsk/kolektif/{!! $pppk->kdunit !!}/{!! $pppk->tmtawal !!}" target="_blank" title="Cetak Pengantar"><i class="fa fa-print"></i> Pengantar</a></li>
                                                                <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/nominatifsk/kolektif/{!! $pppk->kdunit !!}/{!! $pppk->tmtawal !!}" target="_blank" title="Cetak Nominatif"><i class="fa fa-print"></i> Nominatif</a></li>                                                                    
                                                            </ul>
                                                        </div> --}}
                                                                                                                
                                                        <a href="javascript:void(0)" class="btn btn-default attrpengantaropd" rectmtawal="{!!$pppk->tmtawal!!}" recidskpd="{!!$pppk->kdunit!!}" title="Input Surat Pengantar"><i class="fa fa-list"></i> Pengantar OPD</a>                                                        

                                                        <div class="btn-group">                                                            
                                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                                <i class="fa fa-print"></i> Cetak Kolektif
                                                            </button>
                                                            <ul class="dropdown-menu pull-right">
                                                                <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/nominatifsk/kolektif/{!! $pppk->kdunit !!}/{!! $pppk->tmtawal !!}" target="_blank" title="Cetak CPPPK"><i class="fa fa-print"></i> Cetak Nominatif</a></li>
                                                                {{-- <li><a href="{!! url('') !!}/pppk/perpanjangankontrak/cetak/sp/kolektif/{!! $pppk->kdunit !!}/{!! $pppk->tmtawal !!}" target="_blank" title="Cetak SP"><i class="fa fa-print"></i> Cetak SP</a></li>
                                                                <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/spk/kolektif/{!! $pppk->kdunit !!}/{!! $pppk->tmtawal !!}" target="_blank" title="Cetak SPK"><i class="fa fa-print"></i> Cetak SPK</a></li> --}}
                                                            </ul>
                                                        </div>
                                                        &nbsp;
                                                        @if(session('idskpd') <= 2)                                                        
                                                        {{-- <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                                <span class="fa fa-pencil"></span> Input SP & SPK
                                                            </button>
                                                            <ul class="dropdown-menu pull-right">                                                            
                                                                <li><a href="javascript:void(0)" class="edit-sp-induk" tipe="kolektif" recid="{!! $pppk->id !!}"><i class="fa fa-pencil"></i> SP Induk</a></li>
                                                                <li><a href="javascript:void(0)" class="edit-spk-induk" tipe="kolektif" recid="{!! $pppk->id !!}"><i class="fa fa-pencil"></i> SPK Induk</a></li>                                                            
                                                            </ul>                  
                                                        </div> --}}
                                                        @endif
                                                </div>
                                            </th>
                                        </tr>
                                    <?php } ?>
                                <tr>
                                    <td class="text-center">{!! $x !!}</td>
                                    <td>
                                        <b>{!!$pppk->nip!!}</b> <br>
                                        <b>{!!$pppk->nama !!}</b> <br>
                                        <small>{!!$pppk->tmlhr.", ".(($pppk->tglhr != '0000-00-00')?date('d-m-Y', strtotime($pppk->tglhr)):'')!!}</small>
                                        <div class="text-right" style="position:relative">
                                            <?php
                                            if($pppk->iscetaksk == 1){
                                                echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                            }else if($pppk->iscetaksk == 2){
                                                echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                            }
                                            ?>
                                        </div>
                                    </td>                                    
                                    <td><small>{!! $pppk->jab." PADA ".$pppk->skpd!!}</small></td>
                                    <td align="left">{!! $pppk->tkpendid !!}</td>
                                    <td align="left">{!! $pppk->jenjurusan !!}</td>
                                    <td class="text-center">{!!$pppk->golru!!}</td>
                                    <td class="text-center">{!!$pppk->thkerja!!}</td>
                                    <td class="text-center">{!!$pppk->blkerja!!}</td>
                                    @if($pppk->status==1)
                                    <td align="center">{!! $pppk->perpanjangan !!}</td>
                                    <td align="center">{!! $pppk->perpanjangan_bulan !!}</td>
                                    <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtawal)) !!}</td>
                                    <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtakhir)) !!}</td>                                    
                                    @else
                                    <td colspan="4"><b>Tidak Diusulkan</b> <br>{!! $pppk->status_keterangan !!}</td>
                                    @endif
                                    <td class="text-center">{!!substr($pppk->usia,0,2)." thn ".substr($pppk->usia,2,2)." bln"!!}</td>
                                    <td class="text-center">
                                        <?php 
                                            if($pppk->status==1){
                                                echo '<span style="color:green"><i class="fa fa-check-circle" title="Diusulkan"/><span>';
                                            }else{
                                                echo '<span style="color:red"><i class="fa fa-minus-circle" title="Tidak Diusulkan"/></span>';
                                            }    
                                        ?>
                                    </td>                                    
                                    <td class="text-center">
                                        <?php
                                            if($pppk->statususul==1){
                                                echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                            }else if($pppk->statususul==2){
                                                echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                            }else if($pppk->statususul==3){
                                                echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                            }else{
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if($pppk->statususul=='1' && $pppk->statussk=='2'){
                                                echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                            }else if($pppk->statussk=='1'){
                                                echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                            }else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        @if($pppk->sts_kontrak == 2)
                                            <?php  //$proses_tte = $pppk->statusTTE(); ?>

                                            @if($pppk->proses === '1') {{-- $proses_tte == "Selesai" --}}
                                                <span style="color:green"><i class="fa fa-check-square" title="Selesai"/></span>
                                            @elseif($pppk->proses === '0') {{-- $proses_tte == "Mengusulkan" --}}
                                                <span style="color:blue"><i class="fa  fa-caret-square-o-up" title="Mengusulkan"/></span>
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </td>                                    
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                <span class="caret"></span> Aksi
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                @if($pppk->nosk_pengantar != '' and session('idskpd') >= 2)
                                                    <li><a href="javascript:void(0)" class="text-info" disabled onclick="bootbox.alert('Usulan tidak dapat diedit karena sudah proses diajukan.')"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                                @elseif($pppk->statussk == 0)
                                                    <li><a href="javascript:void(0)" class="text-info edit-pppk" recidpppk="{!!$pppk->idpppk!!}" recnip="{!!$pppk->nip!!}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                                @endif
                                                {{-- @if($pppk->status == 1) --}}
                                                <li><a href="javascript:void(0)" class="text-info verifikasi-pppk" recidpppk="{!!$pppk->idpppk!!}" recnip="{!!$pppk->nip!!}"><i class="{!!(session('role_id') < 3)?'fa fa-check-square-o':'fa fa-search'!!}"></i> {!!(session('role_id') < 3)?'Verifikasi':'Preview'!!}</a></li>
                                                {{-- @endif --}}
                                                @if($pppk->statussk == 1)
                                                    @if($pppk->no_urut != 0)
                                                        <li><a href="javascript:void(0)" recid="{!!$pppk->idpppk!!}" recnip="{!!$pppk->nip!!}" class="text-info ajukantte" target="_blank"><i class="fa fa-pencil"></i> Ajukan TTE</a></li>
                                                    @else
                                                        <li><a href="javascript:void(0)" class="text-info" onclick="bootbox.alert('Tidak dapat melakukan ajuan TTE karena SK Induk usulan perpanjangan PPPK belum ditetapkan.')"><i class="fa fa-info"></i> Ajukan TTE</a></li>
                                                    @endif
                                                @endif
                                                @if($pppk->statussk == 0)
                                                    <li><a id="hapus-pppk" href="javascript:void(0)" recidpppk="{!!$pppk->idpppk!!}" recnip="{!!$pppk->nip!!}" class="text-danger"><i class="fa fa-times-circle"></i> Hapus</a></li>
                                                @else
                                                    {{-- <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/sp/{!! $pppk->id !!}/{!! $pppk->nip !!}" target="_blank" title="Cetak SP"><i class="fa fa-print"></i> Cetak SP</a></li>
                                                    <li><a href="{!! url('') !!}/pppkpw/perpanjangankontrakpw/cetak/spk/{!! $pppk->id !!}/{!! $pppk->nip !!}" target="_blank" title="Cetak SPK"><i class="fa fa-print"></i> Cetak SPK</a></li> --}}
                                                @endif
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <br>
                        <div>
                            <table border="0" class="table">
                                <tr>
                                    <td colspan="11">Keterangan :<br></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/></span> Memenuhi Syarat<br>
                                    </td>
                                    <td>
                                        <span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> Tidak Memenuhi Syarat<br>
                                    </td>
                                    <td>
                                        <span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span> Berkas Tidak Lengkap<br>
                                    </td>
                                    <td>
                                        <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses<br>
                                    </td>
                                    <td>
                                        <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses<br>
                                    </td>
                                    <td>
                                        <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK<br>
                                    </td>
                                    <td>
                                        <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak SK"/></span> SK Dibatalkan<br>
                                    </td>
                                </tr>
                            </table>
                        </div><br>

                        <div class="box-footer clearfix">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <?php echo $rpppk->appends(array('bulan' => Input::get('bulan'), 'status_tte' => Input::get('status_tte'), 'tahun' => Input::get('tahun'), 'idskpd' => Input::get('idskpd'), 'statussk' => Input::get('statussk'), 'status' => Input::get('status'), 'search' => Input::get('search')))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <p style="height: 50px;">&nbsp;</p>
                </div>
                <div class="box-footer clearfix">
                  <div class="row">
                    <div class="col-sm-6">
                      {!! ClaravelHelpers::btnDeleteAll() !!}
                    </div>
                    <div class="col-sm-6">
                    </div>
                  </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>         

<script>    
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            data : $('#cari').serialize(),
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }
    
    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if(n > 0){
            }
            else{
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

                $.ajax({
                    type: 'get',
                    url : $(this).attr('href'),
                    beforeSend: function(){
                        preloader.on();
                    },
                    success: function(data) {
                        preloader.off();
                        $('#utama').html(data);
                    }
                });
            }
        });

        $('#edit-sk-induk-all').on('click', function(e){
            e.preventDefault();
            var tipe = $(this).attr('tipe');
            var tahun = $(this).attr('rectahun');
            var bulan = $(this).attr('recbulan');
            claravel_modal('Edit No. SK Induk PPPK PW','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pppkpw/perpanjangankontrakpw/editskinduk',
                type : 'get',
                data: {
                    'tipe': tipe,                     
                    'bulan': bulan,
                    'tahun': tahun,
                    '_token': '{!! csrf_token() !!}' 
                },
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#edit-sp-induk-all').on('click', function(e){
            e.preventDefault();
            var tipe = $(this).attr('tipe');
            var tahun = $(this).attr('rectahun');
            var bulan = $(this).attr('recbulan');
            claravel_modal('Edit No. SP Induk','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pppkpw/perpanjangankontrakpw/editspinduk',
                type : 'get',
                data: { 
                    'tipe': tipe,
                    'bulan': bulan,
                    'tahun': tahun,
                    '_token': '{!! csrf_token() !!}' 
                },
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#edit-spk-induk-all').on('click', function(e){
            e.preventDefault();
            var tipe = $(this).attr('tipe');
            var tahun = $(this).attr('rectahun');
            var bulan = $(this).attr('recbulan');
            claravel_modal('Edit No. SPK Induk','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pppkpw/perpanjangankontrakpw/editspkinduk',
                type : 'get',
                data: { 
                    'tipe': tipe,
                    'bulan': bulan,
                    'tahun': tahun,
                    '_token': '{!! csrf_token() !!}' 
                },
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('.edit-sp-induk').on('click', function(e){
            e.preventDefault();
            var tipe = $(this).attr('tipe');
            var id = $(this).attr('recid');
            claravel_modal('Edit No. SP Induk PPPK PW','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pppkpw/perpanjangankontrakpw/editspinduk',
                type : 'get',
                data: { 
                    'tipe': tipe,
                    'id': id,
                    '_token': '{!! csrf_token() !!}' 
                },
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('.edit-spk-induk').on('click', function(e){
            e.preventDefault();
            var tipe = $(this).attr('tipe');
            var id = $(this).attr('recid');
            claravel_modal('Edit No. SPK Induk','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pppkpw/perpanjangankontrakpw/editspkinduk',
                type : 'get',
                data: { 
                    'tipe': tipe,
                    'id': id,
                    '_token': '{!! csrf_token() !!}' 
                },
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('.attrpengantaropd').on('click', function(e){
            e.preventDefault();
            claravel_modal('Atribut Surat Pengantar OPD','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/data/suratpengantar',
                data: {'tmtawal': $(this).attr('rectmtawal'), 'idskpd': $(this).attr('recidskpd'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#buat').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#buataps').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),                
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#tabel').on('click','#hapus-pppk',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus Usulan Perpanjangan PPPK ?',function(a){
                if(a == true){
                    $.ajax({
                        url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recidpppk'),'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/edit',
                        type : 'get',
                        data:'id=' + $this.attr('recid'),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });
        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/delete',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            iki.find('input[type=checkbox]').each(function (t){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').fadeOut(100)                                        
                                }
                            });
                            $('#deleteall').fadeOut(300);
                        }
                    });
                }
            });            
        });

        $('a.edit-pppk').on('click', function(e){
            e.preventDefault();
            claravel_modal('Edit Perpanjangan PPPK','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/data/edit',
                data: {'idpppk': $(this).attr('recidpppk'), 'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });

        $('a.verifikasi-pppk').on('click', function(e){
            e.preventDefault();
            claravel_modal('Verifikasi Perpanjangan PPPK','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/data/verifikasi',
                data: {'idpppk': $(this).attr('recidpppk'), 'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });

        $('#tabel').on('click','.ajukantte', function(e){
            e.preventDefault();
            var $this = $(this);
            bootbox.confirm('Ajukan TTE ?',function(r){
                if(r){ 
                    $.ajax({
                        url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/ajukantte',
                        type : 'post',
                        data: {'idpppk' : $this.attr('recid'), 'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==1){
                                notification("TTE PPPK berhasil diajukan!",'success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            }); 
        });

        $('#excel-nominatif').on('click', function(e){
            e.preventDefault();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            if(bulan != '' && tahun !=''){
                let form = $('#cari');
                let url = '{!!url()!!}/pppkpw/perpanjangankontrakpw/excel/rekapusulan';

                // Buat form baru
                let newForm = $('<form>', {
                    action: url,
                    method: 'POST',
                    target: '_blank'
                });

                // Tambahkan CSRF token
                let token = $('meta[name="csrf-token"]').attr('content');
                newForm.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: token
                }));

                // Salin nilai input dari form lama ke form baru
                form.find('input, select, textarea').each(function() {
                    let input = $(this);
                    let type = input.attr('type');
                    
                    // Hanya salin jika bukan tombol
                    if(type !== 'button' && type !== 'submit' && type !== 'reset'){
                        newForm.append($('<input>', {
                            type: 'hidden',
                            name: input.attr('name'),
                            value: input.val()
                        }));
                    }
                });

                // Tambahkan ke body dan submit
                $('body').append(newForm);
                newForm.submit();
                newForm.remove();
            } else {
                bootbox.alert('<b>Perhatian!</b> Periode bulan dan tahun harus diisi.');
            }
        });
    });
</script>
