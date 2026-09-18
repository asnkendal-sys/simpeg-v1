<section class="content-header">
    <h1>
        Sistem Notifikasi<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Sistem Notifikasi</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! ClaravelHelpers::btnCreate() !!}
            <div class="box-tools pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <div class="input-group" style="width: 200px;">
                    <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </span>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th rowspan="2" width="3%">NO</th>
                        <th rowspan="2">JUDUL</th>
                        <th rowspan="2">NOTIFIKASI</th>
                        <th colspan="2">TANGGAL PUBLISH</th>
                        <th rowspan="2">STATUS</th>

                        <th rowspan="2" width="7%">AKSI</th>
                    </tr>
                    <tr>
                        <th>RENCANA PUBLISH</th>
                        <th>PELAKSANAAN PUBLIH</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;?>
                    @foreach ($sistemnotifikasis as $sistemnotifikasi)
                    <?php $x++; ?>
                    <tr>
                        <td rowspan="2" class="text-center">{!!$x!!}</td>
                        <td>{!!$sistemnotifikasi->title!!}</td>
                        <td>{!!$sistemnotifikasi->notification!!}</td>
                        <td>{!!$sistemnotifikasi->tgl_publish!!}</td>
                        <td>{!!$sistemnotifikasi->publish_at!!}</td>
                        <td class="text-center">
                            @if($sistemnotifikasi->flag==1)
                            <a href="javascript:void(0)" recid="{!!$sistemnotifikasi->id!!}" recval="{!!$sistemnotifikasi->flag!!}" class="btn btn-success act-kirim"><i class='fa fa-check-circle-o' title='Status Ditampilkan'></i> Sudah Dikirim</a>
                            @else
                            <a href="javascript:void(0)" recid="{!!$sistemnotifikasi->id!!}" recval="{!!$sistemnotifikasi->flag!!}" class="btn btn-warning act-kirim"><i class='fa fa-info-circle' title='Status Ditampilkan'></i> Belum Dikirim</a>
                            @endif
                        </td>

                        <td rowspan="2">
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0)" recid="{!!$sistemnotifikasi->id!!}" class="text-info act-penerima"><i class="fa fa-plus-square-o"></i> Penerima</a></li>
                                    <li>{!! ClaravelHelpers::btnEdit($sistemnotifikasi->id) !!}</li>
                                    <li>{!! ClaravelHelpers::btnDelete($sistemnotifikasi->id) !!}</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Penerima : </b></td>
                        <td colspan="3">{!!SistemnotifikasiModel::getPenerima($sistemnotifikasi->id)!!}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="height: 75px">&nbsp;</div>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    {!! ClaravelHelpers::btnDeleteAll() !!}
                </div>
                <div class="col-sm-6">
                    <?php echo $sistemnotifikasis->appends(array('search' => Input::get('search')))->render(); ?>
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
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('.act-penerima').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            claravel_modal('Penerima Notifikasi','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/administrator/sistemnotifikasi/data/notifikasi_penerima',
                data: {'id': id, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('.act-kirim').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var val = $(this).attr('recval');
            if(val == 1){
                bootbox.confirm('Kirim Ulang Notifikasi ..?',function(a){
                    if(a == true){
                        claravel_modal('Kirim Notifikasi','Loading...','main_modal');
                        $.ajax({
                            type:'post',
                            url : '{!!url()!!}/administrator/sistemnotifikasi/data/notifikasi_kirim',
                            data: {'id': id, '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    }
                });
            }else{
                claravel_modal('Kirim Notifikasi','Loading...','main_modal');
                $.ajax({
                    type:'post',
                    url : '{!!url()!!}/administrator/sistemnotifikasi/data/notifikasi_kirim',
                    data: {'id': id, '_token' : '{!!csrf_token()!!}'},
                    success:function(html){
                        $('#main_modal .modal-body').html(html);
                    }
                });
            }
        })

        $('.pen-remove').on('click', function(e){
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('recid');
            var txt = $this.attr('rectxt');

            bootbox.confirm('Hapus Penerima dari "'+txt+'"...?',function(a){
                if(a == true){
                    $.ajax({
                        url: '{!!url()!!}/administrator/sistemnotifikasi/deletepenerima',
                        type : 'post',
                        data: {'id' : id, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.remove();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })

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
    });
</script>
