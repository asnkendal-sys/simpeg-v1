<section class="content-header">
    <h1>
        Riwayat Golongan<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Riwayat Golongan</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class="{!!(Request::segment(3)=='')?'active':''!!}"><a href="{!!url()!!}/konversidata/riwayatgolongan"> <i class="fa fa-fw fa-list-ul"></i> HISTORI KONVERSI</a></li>
                    <li class="{!!(Request::segment(3)=='create')?'active':''!!}"><a href="{!!url()!!}/konversidata/riwayatgolongan/create"> <i class="fa fa-fw fa-list-ul"></i> FORMULIR KONVERSI</a></li>
                </ul>

                <div class="tab-pane active"><br>
                    <div class="box-header with-border">
                        {!! ClaravelHelpers::btnCreate() !!}&nbsp;
                        <a id="format_default" href="{{url()}}/packages/upload/excel/rgolongan/format_rgolongan.xls" target="_blank" class="btn btn-success" title="Contoh Format File Konversi"><i class="fa fa-file-excel-o"></i> Format Konversi</a>
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
                                    <th>Nama File</th>
                                    <th>Jumlah Data</th>
                                    <th>Konversi Berhasil</th>
                                    <th>Waktu</th>
                                    <th>Tanggal</th>

                                    <th width="7%">Act.</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($riwayatgolongans as $riwayatgolongan)
                                <tr>
                                    <td><center>{!! ClaravelHelpers::ckDelete($riwayatgolongan->id); !!}</center></td>
                                    <td><a href="{!!url().'/packages/upload/excel/rjabatan/'.$riwayatgolongan->filename!!}" target="_blank">{!!$riwayatgolongan->filename_original!!}</a></td>
                                    <td align="center">{!!$riwayatgolongan->jumlah_data!!}</td>
                                    <td align="center">{!!$riwayatgolongan->terkonversi!!}</td>
                                    <td align="center">{!!round($riwayatgolongan->waktu, 3)!!} Menit</td>
                                    <td align="center">{!!date('d-m-Y H:i:s',strtotime($riwayatgolongan->created_at))!!}</td>

                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                <span class="caret"></span> Aksi
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a id="upload-ulang" href="#" recid="1" class="text-danger"><i class="fa fa-arrow-circle-up"></i> Konversi Ulang</a></li>
                                                <li>{!! ClaravelHelpers::btnDelete($riwayatgolongan->id) !!}</li>
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
                          {!! ClaravelHelpers::btnDeleteAll() !!}
                        </div>
                        <div class="col-sm-6">
                          <?php echo $riwayatgolongans->appends(array('search' => Input::get('search')))->render(); ?>
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
        bootbox.alert('<b>Perhatian!</b> Mohon maaf konversi <b>RIWAYAT</b> belum dapat digunakan,<br>Kami memerlukan riset lebih lanjut untuk alur dan prosesnya. Terimakasih!');
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
