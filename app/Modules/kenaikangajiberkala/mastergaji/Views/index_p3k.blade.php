<section class="content-header">
    <h1>
        Master Gaji<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Master Gaji</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <ul class="nav nav-tabs tab1" id="myTab">
            <li class=""><a href="{!!url()!!}/kenaikangajiberkala/mastergaji"> <i class="fa fa-fw fa-list-ul"></i> MASTER GAJI PNS</a></li>
            <li class="active"><a href="{!!url()!!}/kenaikangajiberkala/mastergaji/datagajip3k"> <i class="fa fa-fw fa-list-ul"></i> MASTER GAJI PPPK</a></li>
        </ul><br>
        <div class="box-header with-border">
            <a id="buat" href="{!!url()!!}/kenaikangajiberkala/mastergaji/createp3k" class="btn btn-primary {!! \Config::get('claravel::ajax') !!}"><i class='fa fa-plus-square'></i> Buat Baru</a>
            <a id="ubahtahun" href="javascript:void(0)" class="btn btn-success"><i class="fa fa-pencil"></i> Master Gaji Aktif <b>{!!MastergajiModel::getTahunKgbP3k()!!}</b></a>
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
        {!! Form::open(array('url' => \Request::path().'/deletep3k', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>
                        <th>Golongan</th>
<!--                        <th>Pangkat</th>-->
                        <th>Masa Kerja</th>
                        <th>Gaji</th>
                        <th>Dasar Hukum</th>
                        <th>Tahun</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th width="7%">Act.</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($gajip3ks as $mastergaji)
                    <tr>
                        <td><center>
                        <input type="checkbox" class="checkme" name="id[]" value="{!!$mastergaji->id!!}" data-toggle="tooltip" data-placement="bottom" title="Pilih untuk dihapus">
                        </center></td>
                        <td>{!!$mastergaji->golru_p3k!!}</td>
<!--                        <td>{!!$mastergaji->pangkat!!}</td>-->
                        <td>{!!$mastergaji->msk!!}</td>
                        <td>{!!uang($mastergaji->gaji)!!}</td>
                        <td>{!!$mastergaji->dasarhukum!!}</td>
                        <td>{!!$mastergaji->tahun!!}</td>
                        <td>{!!$mastergaji->ket!!}</td>
                        <td class="text-center">{!!($mastergaji->status==1)?'<i class="glyphicon glyphicon-ok-circle"></i>':'<i class="glyphicon glyphicon-remove-circle"></i>'!!}</td>

                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a id="edit" href="{!!url()!!}/kenaikangajiberkala/mastergaji/editp3k" recid={!!$mastergaji->id!!} class="text-info"><i class='fa fa-pencil-square-o'></i> Edit</a>
                                    </li>
                                    <li>
                                        <a id="hapus" href="{!!url()!!}/kenaikangajiberkala/mastergaji/deletep3k" recid={!!$mastergaji->id!!} class='text-danger'><i class='fa fa-times-circle'></i> Hapus</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              <button class='btn btn-warning btn-sm' style='display:none' id='deleteall' type='submit'><i class='fa fa-times'></i>Hapus yang ditandai</button>
            </div>
            <div class="col-sm-6">
              <?php echo $gajip3ks->appends(array('search' => Input::get('search')))->render(); ?>
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

        $('#ubahtahun').on('click', function(e){
            e.preventDefault();
            claravel_modal('Ubah Master Gaji','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/mastergaji/data/ubahmaster',
                data: {'_token' : '{!!csrf_token()!!}'},
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

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#tabel').on('click','#hapus',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : '{!!url()!!}/kenaikangajiberkala/mastergaji/deletep3k',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            // alert(html);
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
                        url : '{!!url()!!}/kenaikangajiberkala/mastergaji/editp3k',
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
                    // alert(iki.serialize());
                    $.ajax({
                        url : '{!!url()!!}/kenaikangajiberkala/mastergaji/deletep3k',
                        type : 'post',
                        data: iki.serialize(),
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