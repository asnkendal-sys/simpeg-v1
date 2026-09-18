<section class="content-header">
    <h1>
        Perubahan Riwayat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
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
                        {!!View::make('perubahanriwayat::menutab')!!}

                        <div class="tab-content">
                            <div id="rpend" class="tab-pane active">
                                <p>
                                <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpend">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th width="2%"><div class="text-center">NO</div></th>
                                        <th><div class="text-center">TK. PENDIDIKAN</div></th>
                                        <th><div class="text-center">JURUSAN</div></th>
                                        <th><div class="text-center">NAMA SEKOLAH</div></th>
                                        <th><div class="text-center">TEMPAT</div></th>
                                        <th><div class="text-center">NO. IJAZAH</div></th>
                                        <th><div class="text-center">TGL. IJAZAH</div></th>
                                        <th><div class="text-center">KEPALA SEKOLAH</div></th>
                                        <th width="8%"><div class="text-center">AKSI</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0; ?>
                                    @foreach ($rpends as $rpend)
                                    <?php $x++; ?>
                                    <tr>
                                        <td rowspan="2"align="center">{!!$x!!}</td>
                                        <td>{!!$rpend->tkpendid!!}</td>
                                        <td>{!!$rpend->jenjurusan!!}</td>
                                        <td>{!!$rpend->namasekolah!!}</td>
                                        <td>{!!$rpend->tempat!!}</td>
                                        <td>{!!$rpend->noijaz!!}</td>
                                        <td>{!!date('d-m-Y', strtotime($rpend->tgijaz))!!}</td>
                                        <td>{!!$rpend->kepsek!!}</td>
                                        <td rowspan="2" align="right">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span> Aksi
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a class="text-info prevperubahan" recrole="{!! session('role_id') !!}" recid="{!!$rpend->id!!}" recnip="{!!$rpend->nip!!}" recflag="{!!$rpend->idjnsaksi!!}" href="javascript:void(0)" ><i class="{!!(session('role_id') <= 3)?'fa fa-check':'fa fa-search'!!}"></i> {!!(session('role_id') <= 3)?'Verifikasi':'Preview'!!}</a></li>
                                                    <li><a class="text-danger btlperubahan" recid="{!!$rpend->id!!}" recnip="{!!$rpend->nip!!}" recflag="{!!$rpend->idjnsaksi!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Batalkan</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><em><small>{!!$rpend->nip."<br>".$rpend->namalengkap!!}</small></em></td>
                                        <td colspan="2"><em><small>{!!$rpend->path!!}</small></em></td>
                                        <td colspan="4" class="{!!($rpend->status == 2)?'alert-danger':''!!}">
                                            <em><small>{!!getKetaksi($rpend->idjnsaksi)!!}</small></em><br>
                                            <em><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keterangan : {!!($rpend->ketditolak!='')?$rpend->ketditolak:'Belum ada tanggapan.'!!}</small></em>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </p>
                            </div>
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
                <?php echo $rpends->appends(array('idskpd'=>Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
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
            } else{
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

        /*function preview perubahan data*/
        $('.prevperubahan').on('click', function(e){
            e.preventDefault(e);
            var roleid = $(this).attr('recrole');
            if(roleid < 3){
               var tipe = 'get';
               var alamat = '{!!url()!!}/epersonal/perubahanriwayat/rpenddetail/rpend';
               var modal = 'main_modal3';
               var judul = 'Perubahan Data';
            }else{
               var tipe = 'post';
               var alamat = '{!!url()!!}/epersonal/perubahanriwayat/data/rpend_perubahan';
               var modal = 'main_modal2';
               var judul = 'Perubahan Riwayat Pendidikan';
            }
            claravel_modal(judul,'Loading...',modal);
            $.ajax({
                type: tipe,
                url : alamat,
                data: {'id': $(this).attr('recid'), 'nip': $(this).attr('recnip'), 'flag': $(this).attr('recflag'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#'+modal+' .modal-body').html(html);
                }
            });
        });

        /*function delete perubahan data*/
        $('.btlperubahan').on('click', function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Batalkan perubahan data ?',function(a){
                if(a == true){
                    $.ajax({
                        url : '{!!url()!!}/epersonal/perubahanriwayat/btlperubahan',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), 'tb':'r_pend_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dibatalkan','success');
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
