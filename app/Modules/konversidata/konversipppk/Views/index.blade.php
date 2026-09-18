<section class="content-header">
    <h1>
        Konversi PPPK<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Konversi PPPK</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class="{!!(Request::segment(3)=='')?'active':''!!}"><a href="{!!url()!!}/konversidata/konversipppk"> <i class="fa fa-fw fa-list-ul"></i> HISTORI KONVERSI</a></li>
                    <li class="{!!(Request::segment(3)=='create')?'active':''!!}"><a href="{!!url()!!}/konversidata/konversipppk/create"> <i class="fa fa-fw fa-list-ul"></i> FORMULIR KONVERSI</a></li>
                </ul>

                <div class="tab-pane active"><br>
                    <div class="box-header with-border">
                        {!! ClaravelHelpers::btnCreate() !!}&nbsp;
                        <a id="format_default" href="{{url()}}/packages/upload/excel/format_konversi_pppk.xlsx" target="_blank" class="btn btn-success" title="Contoh Format File Konversi"><i class="fa fa-file-excel-o"></i> Format Konversi</a>
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
                                    <th>No.</th>
                                    <th>Nama File</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Data</th>
                                    <th>Berhasil</th>
                                    <th>Gagal</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                    $list_excel = $pppk_excel; #->unique('excel_2');
                                ?>
                                <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*50):0;?>
                                @foreach ($list_excel as $excel)
                                <?php
                                    $x++;
//                                    $pppk = $pppk_excel->where('excel_2',$excel->excel_2);
//                                    $pppk_0 = $pppk->where('status',0)->count();
//                                    $pppk_1 = $pppk->where('status',1)->count();
//                                    $pppk_2 = $pppk->where('status',2)->count();
//                                    $pppk_3 = $pppk->where('status',3)->count();
                                 ?>
                                <tr>
                                    <td align="center">{!! $x !!}</td>
                                    <td>{!! $excel->excel !!}</td>
                                    <td align="center">{!! tanggal($excel->updated_at) !!}</td>
                                    <td align="center">{!! $excel->jml !!}</td> <!--$pppk->count()-->
                                    <td align="center">{!! $excel->berhasil !!}</td> <!--$pppk_3-->
                                    <td align="center">{!! $excel->gagal !!}</td> <!--$pppk_0 + $pppk_1 + $pppk_2-->
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                      <div class="row">
                        <div class="col-sm-6">
                          {!! ClaravelHelpers::btnDeleteAll() !!}
                        </div>
                        <div class="col-sm-6">
                            <?php echo $list_excel->appends(array('search' => Input::get('search')))->render(); ?>
                        </div>
                      </div>
                    </div>
                    {!! Form::close() !!}
                </div>
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

        $('a.detail-konversi').on('click',function(e){
            e.preventDefault();
            claravel_modal('Detail Konversi','Loading...','main_modal2');
            var file = $(this).attr('file');
            var status = $(this).attr('status');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/konversidata/konversipppk/data/konversipppk',
                data: {'file': file, 'status': status, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
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
