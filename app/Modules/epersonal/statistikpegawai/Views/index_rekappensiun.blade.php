<section class="content-header">
    <h1>
        Statistik Pegawai<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Statistik Pegawai</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/epersonal/statistikpegawai"> <i class="fa fa-fw fa-list-ul"></i> STATISTIK PEGAWAI</a></li>
                    @if(session('role_id') < 4) 
                    <li class=""><a href="{!!url()!!}/epersonal/statistikpegawai/rekappegawai"> <i class="fa fa-fw fa-list-ul"></i> REKAP PEGAWAI</a></li>
                    <li class="active"><a href="{!!url()!!}/epersonal/statistikpegawai/rekappensiun"> <i class="fa fa-fw fa-list-ul"></i> REKAP PENSIUN</a></li>
<li class=""><a href="{!!url()!!}/epersonal/statistikpegawai/statistikabk"> <i class="fa fa-fw fa-list-ul"></i> STATISTIK ABK</a></li>
                    @endif
                </ul>

                <div class="tab-pane active"><br> {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-horizontal form-'.\Config::get('claravel::ajax'),'id'
                    => 'cari_rekappensiun', 'target'=>'_blank' )) !!} {!!csrf_field()!!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!!comboSkpd("idskpd",session('idskpd'),"",session('idskpd'))!!}
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            {!! Form::label('idjenpens', 'Jenis Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                {!! comboJenpens("idjenpens","","") !!}
                            </div>
                        </div> --}}
                        <div class="form-group">
                            {!! Form::label('bulan1', 'Bulan Antara:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-2">
                                {!! comboBulan("bulan1",Input::get('bulan1'),"") !!}
                            </div>
                            <div class="col-sm-2">
                                {!! comboBulan("bulan2",Input::get('bulan2'),"") !!}
                            </div>
                            <div class="col-sm-2">
                                {!! comboTahun("tahun",Input::get('tahun'),"") !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-7">
                                <button class="btn btn-success" type="button" id="prev-statistik"><i class="fa fa-bar-chart"></i> Lihat Statistik</button>                         &nbsp;&nbsp;
                                <button class="btn btn-success" type="button" id="cetak-statistik"><i class="fa fa-print"></i> Cetak Statistik</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-12">
                <div id="result"></div>
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

    var xhr = $.ajax();
    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('#prev-statistik').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url:'{{url()}}/epersonal/statistikpegawai/data/statistikrekappensiun',
                type:'post',
                data:{ 'idskpd':$('#idskpd').val(),'bulan1':$('#bulan1').val(),'bulan2':$('#bulan2').val(),'tahun':$('#tahun').val(),'_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Looading..');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });

        $('#cetak-statistik').on('click', function(e){
            e.preventDefault();
            $('#cari_rekappensiun').attr("action", "{!!url()!!}/epersonal/statistikpegawai/print/statistikrekappensiun");
            $('#cari_rekappensiun').submit();
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
                            notification(html,'success');
                            $this.closest('tr').fadeOut(300,function(){
                                $(this).remove();
                            });
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