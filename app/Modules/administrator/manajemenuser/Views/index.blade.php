<section class="content-header">
    <h1>
        Manajemen User<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Manajemen User</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <?php $rspgw = \DB::table('tb_01')->first();?>
            {!! ClaravelHelpers::btnCreate() !!}
            <a id="setjadwal" href="javascript::void(0)" class="btn btn-warning"><i class="glyphicon glyphicon-time"></i> Setting Jadwal</a>
            <a id="setuserpeg" href="javascript::void(0)" actval='{!!$rspgw->usiapens!!}' class="btn btn-{!!($rspgw->usiapens==1)?'success':'danger'!!}"><i class="glyphicon glyphicon-{!!($rspgw->usiapens==1)?'ok':'lock'!!}"></i> User Pegawai {!!($rspgw->usiapens==1)?'Aktif':'Non Aktif'!!}</a>
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
                        <th width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>email</th>
                        <th>Role</th>
                        <th>Skpd</th>

                        <th width="7%">Act.</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($manajemenusers as $manajemenuser)
                    <tr style="background-color: {!!($manajemenuser->aktif==0)?'yellow':''!!}">
                        <td><center>{!! ClaravelHelpers::ckDelete($manajemenuser->id); !!}</center></td>
                        <td>{!!$manajemenuser->name!!}</td>
                        <td>{!!$manajemenuser->username!!}</td>
                        <td>{!!$manajemenuser->email!!}</td>
                        <td>{!!$manajemenuser->rolename!!}</td>
                        <td>{!!$manajemenuser->skpd!!}</td>

                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>{!! ClaravelHelpers::btnEdit($manajemenuser->id) !!}</li>
                                    <li>{!! ClaravelHelpers::btnDelete($manajemenuser->id) !!}</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <td><span style="width: 20px; height: 20px; background-color: #ffff00;" class="pull-left"></span></td>
                        <td colspan="6">User Non Aktif</td>
                    </tr>
                </table>
                <div style="height: 50px; width: 100%;">

                </div>
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $manajemenusers->appends(array('search' => Input::get('search')))->render(); ?>
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

        $('#setjadwal').on('click', function(e){
            e.preventDefault();
            e.preventDefault();
            claravel_modal('Setting Jadwal Pengguna','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/administrator/manajemenuser/setting',
                type : 'get',
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('#setuserpeg').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('actval');
            if(id == 1){
                var text = 'Non aktifkan user pegawai ?';
                var val  = 0;
            }else{
                var text = 'Aktifkan user pegawai ?';
                var val  = 1;
            }

            bootbox.confirm(text,function(a){
                if(a == true){
                    $.ajax({
                        url : '{{url()}}/administrator/manajemenuser/settingpegawai',
                        type : 'post',
                        data : {'usiapens': val, '_token' : '{!!csrf_token()!!}'},
                        success:function(html){
                            preloader.off();
                            if(html==4){
                                notification('Aktifasi user pegawai berhasil diubah','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })

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
