<section class="content-header">
    <h1>
        Perubahan Riwayat <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}/dashboard"> Dashboard</a></li>
        <li class="active">Perubahan Riwayat</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-lg-3 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!}&nbsp;
                </div>
            </div>
            <div class="box-tools pull-right col-lg-9 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">&nbsp;</td>
                        <td style="padding: 5px;" width="55%">
                            @if(session('role_id') <= 3)
                            {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                            @endif
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

                <div id="riwayat" class="tab-pane">
                    <p>
                    <div class="nav-tabs-custom" style="box-shadow:none;">
                        <ul class="nav nav-tabs tab2" id="myTab">
                            <li class="active"><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rpangkat"><i class="fa fa-fw fa-dot-circle-o"></i> PANGKAT</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rjab"><i class="fa fa-fw fa-dot-circle-o"></i> JABATAN</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rkgb"><i class="fa fa-fw fa-dot-circle-o"></i> KGB</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rpend"><i class="fa fa-fw fa-dot-circle-o"></i> PENDIDIKAN</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rdikstru"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT STRUKTURAL</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rdikfung"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT FUNGSIONAL</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rdiktek"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT TEKNIS</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rhukdis"><i class="fa fa-fw fa-dot-circle-o"></i> HUKUM DISIPLIN</a></li>
                            <li><a data-toggle="tab" href="{!!url()!!}/epersonal/perubahanriwayat/rpppk"><i class="fa fa-fw fa-dot-circle-o"></i> PPPK</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="rpangkat" class="tab-pane active">
                                <p>
                                <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th width="2%"><div class="text-center">NO</div></th>
                                        <th><div class="text-center">GOL. RUANG</div></th>
                                        <th><div class="text-center">PEJABAT PENETAP</div></th>
                                        <th><div class="text-center">NO. SK</div></th>
                                        <th><div class="text-center">TANGGAL SK</div></th>
                                        <th><div class="text-center">TMT SK</div></th>
                                        <th width="8%"><div class="text-center">AKSI</div></th>
                                    </tr>
                                    </thead>
                                    <tbody id="result"></tbody>
                                </table>
                                </p>
                            </div>

                        <!-- /.tab-pane -->
                        </div>
                    </div>
                </p>
            </div>
            <!-- /.tab-pane -->

            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              &nbsp;
            </div>
            <div class="col-sm-6">
              &nbsp;
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

        $('ul#myTab li.active a').trigger('click');

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
                            if(html==9){
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
