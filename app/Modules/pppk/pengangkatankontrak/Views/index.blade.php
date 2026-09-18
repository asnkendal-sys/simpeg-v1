<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Pengangkatan Kontrak<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Pengangkatan Kontrak</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" style="min-height: 22px;">
            <div class="row">
                <div class="col col-md-3">
                    <a href="#" id="btn-konversipppk" class="btn btn-primary">Konversi PPPK</a>
                    <a href="#" id="btn-tambahpppk" class="btn btn-success"><i class='fa fa-plus-square'></i> Buat Baru</a>                    
                </div>
                <div class="col col-md-9">
                    <div class="box-toolz pull-rightz">
                        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                        {!!csrf_field()!!}
                        <table width="100%">
                            <tr>
                                <td width="60%">{!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}</td>
                                <td width="25%"><input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}"></td>
                                <td width="5%"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button></td>
                            </tr>
                        </table>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        {{-- <th rowspan="2" width="2%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th> --}}
                        <th rowspan="2">NO</th>
                        <th rowspan="2" width="15%">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                        <th rowspan="2">NIP <br> NIP LAMA</th>
                        <th rowspan="2">GOL. <br> TMT</th>
                        <th rowspan="2">ESL</th>
                        <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA <br> TMT</th>
                        <th colspan="2">PERJANDIAN MASA KERJA</th>
                        {{-- <th colspan="2">S/D SEKARANG</th> --}}
                        <th colspan="2">PENDIDIKAN TERAKHIR</th>
                        <th rowspan="2" width="10%">AGAMA<br>USIA</th>
                        <th rowspan="4" width="8%">AKSI</th>
                    </tr>
                    <tr>
                        <th>MULAI</th>
                        <th>SELESAI</th>
                        {{-- <th>THN</th> --}}
                        {{-- <th>BLN</th> --}}
                        <th>JENJANG</th>
                        <th>JURUSAN</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $idskpd[0]= "";$tmtawal[0]= "";$idskpd_induk[0]= ""; $n = 0;
                            $file_excel[0] = "";
                            $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*10):0;
                        ?>
                        @foreach ($rpppk as $r)
                        <?php
                            $n++; $x++;
                            $p = $r->pegawai;
                            $idskpd_induk[$n] = substr($r->idskpd, 0,2);
                            $tmtawal[$n] = $r->tmtawal;
                            $file_excel[$n] = $r->file_excel;
                            if(($idskpd_induk[$n]!=$idskpd_induk[$n-1]) or ($tmtawal[$n]!=$tmtawal[$n-1]) or ($file_excel[$n]!=$file_excel[$n-1])){
                        ?>
                                <tr>
                                    <th style="position:relative;" colspan="6">
                                        <div class="text-left">
                                            {{-- NOMOR USULAN : {{$nominatifdalamskpd->nousul}}&nbsp; --}}
                                            <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($r->tmtawal))?>
                                            &nbsp;
                                            <?php echo "||&nbsp;".getskpdgroup($idskpd_induk[$n]); ?>&nbsp;
                                            ||&nbsp;{!! $r->file_excel !!}&nbsp;
                                            <br>
                                        </div>
                                    </th>
                                    <th style="position:relative;" colspan="6">
                                        <div class="text-right">
                                                <a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false" style="cursor: pointer">
                                                    <i class="fa fa-print"></i> Cetak
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/cpppk/kolektif/{!! $idskpd_induk[$n] !!}/{!! $r->tmtawal !!}" target="_blank" title="Cetak CPPPK"><i class="fa fa-print"></i> CPPPK</a></li>
                                                    <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/sp/kolektif/{!! $idskpd_induk[$n] !!}/{!! $r->tmtawal !!}" target="_blank" title="Cetak SP"><i class="fa fa-print"></i> SP</a></li>
                                                    <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/spk/kolektif/{!! $idskpd_induk[$n] !!}/{!! $r->tmtawal !!}" target="_blank" title="Cetak SPK"><i class="fa fa-print"></i> SPK</a></li>
                                                </ul>
                                                &nbsp;
                                                <a href="#" class="edit-sp-induk" tipe="kolektif" recid="{!! $r->id !!}">
                                                    <i class="fa fa-pencil"></i> SP Induk
                                                </a>
                                                &nbsp;
                                                <a href="#" class="edit-spk-induk" tipe="kolektif" recid="{!! $r->id !!}">
                                                    <i class="fa fa-pencil"></i> SPK Induk
                                                </a>
                                            &nbsp;
                                            {{-- <a href="#" class="attrtambahus" 
                                            recnousul="{!!$nominatifdalamskpd->nousul!!}" 
                                            rectglusul="{!!$nominatifdalamskpd->tglusul!!}" 
                                            recnosuratrek="{!!$nominatifdalamskpd->no_suratrek!!}" 
                                            recsuratdari="{!!$nominatifdalamskpd->surat_dari!!}" 
                                            rectglsurat="{!!$nominatifdalamskpd->tgl_suratrek!!}"
                                            recperihalrek="{!!$nominatifdalamskpd->perihalrek!!}" 
                                            act="tambahus"><i class="fa fa-plus"> Tambah</i></a> | --}}
                                            
                                            <!-- &nbsp;<a href="javascript:void(0)" class="attrpengantar" recnousul="$nominatifdalamskpd->nousul" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-file"> Pengantar</i></a> | -->

                                            {{-- &nbsp;<a href="javascript:void(0)" class="attrnominatif" recnousul="{!!$nominatifdalamskpd->nousul!!}" act="nominatif" title="Cetak Daftar Nominatif"><i class="fa fa-list"> Nominatif</i></a> | --}}
                                            <!-- &nbsp;<a href="#" class="attrnominatifbupati" recnousul="}" act="nominatifbupati" title="Cetak Daftar  Nominatif checklsit Bupati"><i class="fa fa-list"> Lamp. Checklist</i></a> |-->

                                            {{-- &nbsp;<a href="javascript:void(0)" recnousul="{!!$nominatifdalamskpd->nousul!!}" id="usdelete" title="Delete Daftar"><i class="fa fa-trash-o"> Hapus</i></a> --}}
                                        </div>
                                    </th>
                                </tr>
                            <?php } ?>
                        <tr>
                            {{-- <td><center>{!! ClaravelHelpers::ckDelete($p->niplama); !!}</center></td> --}}
                            <td><center>{!! $x !!}</center></td>
                            <td><b>{!!$p?$p->namaLengkap():'' !!}</b> <br>
                                @if($p)
                                    <small>{!!$p->tmlhr.", ".(($p->tglhr != '0000-00-00')?date('d-m-Y', strtotime($p->tglhr)):'')!!}</small>
                                @endif
                            </td>
                            <td><b>{!!$r->nip!!}</b> <br> {!!$r->niplama!!}</td>
                            <td>{!!$r->golru!!} <br> {!!(($p->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($p->tmtpkt)):'')!!}</td>
                            <td align="center">-</td>
                            <td><small>{!! ($p?$p->jabatan():'')." PADA ".$p->skpd->path_short." <br> ".(($p->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($p->tmtjbt)):'')!!}</small></td>
                            <td align="center">{!! date('d-m-Y', strtotime($r->tmtawal)) !!}</td>
                            <td align="center">{!! date('d-m-Y', strtotime($r->tmtakhir)) !!}</td>
                            {{-- <td align="center">{!! $p->mkthnpkt !!}</td> --}}
                            {{-- <td align="center">{!! $p->mkblnpkt !!}</td> --}}
                            {{-- <td align="center">{!!substr($p->masaKerjaSekarang(),0,-2)!!}</td> --}}
                            {{-- <td align="center">{!!substr($p->masaKerjaSekarang(),-2)!!}</td> --}}
                            <td align="left">{!! ($p?$p->pTkpendid():'') !!}</td>
                            <td align="left">{!! ($p?$p->pJenjurusan():'') !!}</td>
                            <td>{!! ($p?$p->pAgama():'')."<br>"!!}{!!  ($p?$p->usia():'') !!}</td>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/cpppk/{!! $r->id !!}" target="_blank" title="Cetak CPPPK"><i class="fa fa-print"></i> Cetak CPPPK</a></li>
                                        <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/sp/{!! $r->id !!}" target="_blank" title="Cetak SP"><i class="fa fa-print"></i> Cetak SP</a></li>
                                        <li><a href="{!! url('') !!}/pppk/pengangkatankontrak/cetak/spk/{!! $r->id !!}" target="_blank" title="Cetak SPK"><i class="fa fa-print"></i> Cetak SPK</a></li>
                                        <li>
                                            <a href="#" class="edit-sp-induk" tipe="personal" recid="{!! $r->id !!}">
                                                <i class="fa fa-pencil"></i> SP Induk
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="edit-spk-induk" tipe="personal" recid="{!! $r->id !!}">
                                                <i class="fa fa-pencil"></i> SPK Induk
                                            </a>
                                        </li>
                                        {{-- <li>{!! ClaravelHelpers::btnEdit($p->nip) !!}</li>
                                        <li>{!! ClaravelHelpers::btnDelete($p->nip) !!}</li>
                                        <li><a class="text-primary print" recid="{{$p->nip}}" href="javascript:void(0)"><i class="fa fa-print"></i> Print</a></li>
                                        <li><a id="cetakskmptk" href="{!!url()!!}/epersonal/p/cetakskmptk/{!! $p->nip !!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak SKMPTK</a></li> --}}
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <p style="height: 50px;">&nbsp;</p>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $rpppk->appends(array('search' => Input::get('search'), 'idskpd' => Input::get('idskpd')))->render(); ?>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>         
<script>
    var index_page= '{!! url() !!}/{!! \Request::path() !!}';

    $('#idskpd').select2();
    $('.edit-sp-induk').on('click', function(e){
        e.preventDefault();
        var tipe = $(this).attr('tipe');
        var id = $(this).attr('recid');
        claravel_modal('Edit No. SP Induk','Loading...','main_modal');
        $.ajax({
            url : '{{url()}}/pppk/pengangkatankontrak/editspinduk',
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
            url : '{{url()}}/pppk/pengangkatankontrak/editspkinduk',
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

    $(document).ready(function(){
        $('.pagination').addClass('pagination-sm no-margin pull-right');
    });

    $('#btn-konversipppk').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url : "{!! url('konversidata/konversipppk') !!}",
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    });

    $('#btn-tambahpppk').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url : "{!! url('epersonal/biodata/create') !!}",
            type : 'GET',
            data: { 'view': 'pppk', '_token': '{!! csrf_token() !!}' },
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    });

    $('.checkme,.checkall').on('change',function(){
        if($(this).is(':checked')){
            $('#deleteall').fadeIn(300);
        }
        else{
            $('#deleteall').fadeOut(300);
        }
    });

    $('#buat').on('click',function(e){
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

    $('#tabel').on('click','#hapus',function(e){
        e.preventDefault();
        var $this =$(this);
        bootbox.confirm('Hapus?',function(a){
            if(a == true){
                $.ajax({
                    url : index_page + '/delete',
                    type : 'post',
                    data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
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
</script>
