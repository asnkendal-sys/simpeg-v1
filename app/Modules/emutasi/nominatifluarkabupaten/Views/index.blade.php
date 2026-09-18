<section class="content-header">
    <h1>
        Nominatif Luar Kabupaten <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Luar Kabupaten</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-lg-2 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!} &nbsp;
                </div>
            </div>
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}

                <table width="80%" id="tables" class="pull-right">
                    <tr>
                        <td style="padding: 5px;" width="55%">
                            {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                        </td>
                        <td style="padding: 5px;" width="35%">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </td>
                    </tr>
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
                            <th width="3%">NO</th>
                            <th>NIP<br>NAMA LENGKAP</th>
                            <th>GOL.<br>RUANG</th>
                            <th>PENDIDIKAN<br>TERAKHIR</th>
                            <th colspan="2">JABATAN LAMA PADA SKPD</th>
                            <th>PERMINTAAN MUTASI LUAR DAERAH</th>
                            <th>STATUS</th>
                            <th>PROSES</th>
                            <th width="7%">AKSI.</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                        ?>
                        @foreach ($nominatifluarkabupatens as $nominatifluarkabupaten)
                        <?php
                        $x++;
                        $n++;
                        $arr[$n] = $nominatifluarkabupaten->nousul;
                        if($arr[$n]!=$arr[$n-1]){
                            ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$nominatifluarkabupaten->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($nominatifluarkabupaten->tglusul))?>
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($nominatifluarkabupaten->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <th style="position:relative;" colspan="8">
                                    <div class="text-right">
                                        &nbsp;<a href="javascript:void(0)" class="addusulan" title="Tambah Nominatif" recid="<?=$nominatifluarkabupaten->nousul?>"><i class="fa fa-plus"> Tambah</i></a> |
                                        &nbsp;<a href="javascript:void(0)" class="attrpengantar" recid="<?=$nominatifluarkabupaten->nousul?>" title="Cetak Surat Permohonan"><i class="fa fa-file-o"> Permohonan</i></a> |
                                        &nbsp;<a href="javascript:void(0)" class="usdelete" title="Hapus Semua Nominatif" recid="<?=$nominatifluarkabupaten->nousul?>"><i class="fa fa-trash-o"> Hapus</i></a>
                                    </div>
                                </th>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>{!!$x!!}</td>
                                <td>
                                    <div class="text-right" style="position:relative">
                                        <?php
                                        if($nominatifluarkabupaten->iscetaksk == 1){
                                            echo '<div style="position:absolute;right:-3px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }else if($nominatifluarkabupaten->iscetaksk == 2){
                                            echo '<div style="position:absolute;right:-3px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }
                                        ?>
                                    </div>
                                    <?=$nominatifluarkabupaten->nip?><br>
                                    <?=$nominatifluarkabupaten->namalengkap?>                            
                                </td>
                                <td><?=$nominatifluarkabupaten->golru?><br><?=date("d-m-Y", strtotime($nominatifluarkabupaten->tmtpkt))?></td>
                                <td><?=ucword(($nominatifluarkabupaten->jenjurusan!='')?$nominatifluarkabupaten->jenjurusan:$nominatifluarkabupaten->tkpendid." ".$nominatifluarkabupaten->jenjurusan)?></td>
                                <td><?=ucword($nominatifluarkabupaten->jabatan)?></td>
                                <td><?=ucword($nominatifluarkabupaten->skpd)." ".$nominatifluarkabupaten->path."<br>".date("d-m-Y", strtotime($nominatifluarkabupaten->tmtjbt))?></td>
                                <td>
                                {!!($nominatifluarkabupaten->instansi!="")?$nominatifluarkabupaten->instansi.". ":""!!}
                                {!!$nominatifluarkabupaten->kabupaten!!},
                                {!!$nominatifluarkabupaten->provinsi!!},
                                <!--{!!$nominatifluarkabupaten->noskpermintaan!!},-->
                                {!!(($nominatifluarkabupaten->tglskpermintaan != '0000-00-00')?date('d-m-Y', strtotime($nominatifluarkabupaten->tglskpermintaan)):'')!!}
                            </td>
                                <td>
                                    <div align="center">
                                        <?php
                                        if($nominatifluarkabupaten->statususul==1){
                                            echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                        }else if($nominatifluarkabupaten->statususul==2){
                                            echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                        }else if($nominatifluarkabupaten->statususul==3){
                                            echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div align="center">
                                        <?php
                                        if($nominatifluarkabupaten->statususul=='1' && $nominatifluarkabupaten->statussk=='2'){
                                            echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                        }else if($nominatifluarkabupaten->statussk=='1'){
                                            echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                        }else {
                                            echo '-';
                                        }
                                        ?>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="caret"></span> Aksi
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a id="edit" href="javascript:void(0)" recid="{!!$nominatifluarkabupaten->idusul!!}" recnip="{!!$nominatifluarkabupaten->nip!!}" class="text-info"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                            @if(session('role_id') <= 3)
                                            <li><a id="verifikasi" href="javascript:void(0)" recid="{!!$nominatifluarkabupaten->idusul!!}" recnip="{!!$nominatifluarkabupaten->nip!!}" class="text-info"><i class="fa fa-check-square-o"></i> Verifikasi</a></li>
                                            @else
                                            <li><a id="verifikasi" href="javascript:void(0)" recid="{!!$nominatifluarkabupaten->idusul!!}" recnip="{!!$nominatifluarkabupaten->nip!!}" class="text-info"><i class="fa fa-search"></i> Preview Usulan</a></li>
                                            @endif
                                            <li>{!! ClaravelHelpers::btnDelete($nominatifluarkabupaten->idusul) !!}</li>
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
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-6">
                        {!! ClaravelHelpers::btnDeleteAll() !!}
                    </div>
                    <div class="col-sm-6">
                        <?php echo $nominatifluarkabupatens->appends(array('idskpd' => Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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

            <?php
            echo 'var index_page=laravel_base + "/'.\Request::path().'";';
            ?>

            $('#tabel').on('click','#hapus',function(e){
                e.preventDefault();
                var $this =$(this);
                bootbox.confirm('Hapus Personal Nominatif ?',function(a){
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

            $('.attrpengantar').on('click',function(e){
                e.preventDefault();
                claravel_modal('Atribut Surat Permohonan','Loading...','main_modal');
                $.ajax({
                    type:'post',
                    url : '{!!url()!!}/emutasi/nominatifluarkabupaten/data/attrpengantar',
                    data: {'id': $(this).attr('recid'), '_token' : '{!!csrf_token()!!}'},
                    success:function(html){
                        $('#main_modal .modal-body').html(html);
                    }
                });
            });

            $('#tabel').on('click','#edit',function(e){
                e.preventDefault();
                claravel_modal('Edit Mutasi Luar Kabupaten','Loading...','main_modal2');
                $.ajax({
                    type:'post',
                    url : '{!!url()!!}/emutasi/nominatifluarkabupaten/data/edit',
                    data: {'id': $(this).attr('recid'), 'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                    success:function(html){
                        $('#main_modal2 .modal-body').html(html);
                    }
                });
            });

            $('#tabel').on('click','#verifikasi',function(e){
                e.preventDefault();
                claravel_modal('Verifikasi Mutasi Luar Kabupaten','Loading...','main_modal2');
                $.ajax({
                    type:'post',
                    url : '{!!url()!!}/emutasi/nominatifluarkabupaten/data/verifikasi',
                    data: {'id': $(this).attr('recid'), 'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                    success:function(html){
                        $('#main_modal2 .modal-body').html(html);
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

            $('.addusulan').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url : index_page + '/create/'+$(this).attr('recid'),
                    type : 'get',
                    beforeSend: function(){
                        preloader.on();
                    },
                    success:function(html){
                        preloader.off();
                        $('#utama').html(html);
                    }
                });
            })

            $('.usdelete').on('click', function(e){
                e.preventDefault();
                var nousul = $(this).attr('recid');
                bootbox.confirm('Hapus Semua Nominatif?',function(a){
                    if(a == true){
                        $.ajax({
                            url : index_page + '/usdelete',
                            type : 'post',
                            data : {'nousul': nousul, '_token' : '{!!csrf_token()!!}'},
                            beforeSend: function(){
                                preloader.on();
                            },
                            success:function(html){
                                preloader.off();
                                if(html=='9'){
                                    notification('Berhasil Dihapus','success');
                                    refresh_page();
                                }else{
                                    notification(html,'danger');
                                }
                            }
                        });
                    }
                });
            })

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
        });
    </script>
