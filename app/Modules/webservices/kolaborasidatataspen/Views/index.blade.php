<section class="content-header">
    <h1>
        Kolaborasi Data Taspen<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Kolaborasi Data Taspen</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="callout callout-success">
            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
            <ul style="padding-left: 15px">
                <li>Kolaborasi data simpeg dengan taspen dapat dilakukan satu persatu atau secara kolektif :</li>
                <li>Pilih <b>Menu Aksi</b> kemudian pilih <b>Sinkronisasi</b> untuk melakukan sinkronisasi data secara satu persatu</li>
                <li>Pilih <b>Kolom Ceklist</b> data pegawai yang akan disinronisasikan kemudian pilih tombol <b>Sinkron All</b> untuk sinkronisai data kolektif</li>
                <li>Data pegawai yang ditampilkan merupakan data pegawai yang belum tersinkronisasi data terbarunya dengan Taspen</li>
                <li>Data Pegawai yang ditampilkan dapat difilter berdasarkan status sinkronisasi sesuai kebutuhan pencarian data.</li>
            </ul>
        </div>

        <div class="box-header with-border">
            @if(session('role_id') <= 3)
            <!--{!! ClaravelHelpers::btnCreate() !!}--> <br>&nbsp;
            @endif &nbsp;
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">
                            {!!\KolaborasidatataspenModel::comboStskolaborasi("stskolab",Input::get('stskolab'),"")!!}
                        </td>
                        <td style="padding: 5px;">
                            {!!comboStspns("idstspeg",Input::get('idstspeg'),"")!!}
                        </td>
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
                        <td>
                            <button type="button" class="btn btn-primary" id="sinkall"><i class="fa fa-link"></i> Sinkron All</a></button>
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
                            <th rowspan="2" width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>
                            <th rowspan="2" width="2%">NO</th>
                            <th rowspan="2" width="15%">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                            <th rowspan="2">NIP <br> NIP LAMA</th>
                            <th rowspan="2">GOL. <br> TMT</th>
                            <th rowspan="2">ESL</th>
                            <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA <br> TMT</th>
                            <th colspan="2">MASA KERJA</th>
                            <th colspan="2">S/D SEKARANG</th>
                            <th colspan="2">PENDIDIKAN TERAKHIR</th>
                            <th rowspan="2" width="10%">AGAMA<br>USIA</th>
                            <th rowspan="4" width="8%">AKSI</th>
                        </tr>
                        <tr>
                            <th>THN</th>
                            <th>BLN</th>
                            <th>THN</th>
                            <th>BLN</th>
                            <th>JENJANG</th>
                            <th>JURUSAN</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;?>
                    @foreach ($kolaborasidatataspens as $kolaborasidatataspen)
                    <?php $x++; ?>
                    <tr>
                        <td><center>{!! ClaravelHelpers::ckDelete($kolaborasidatataspen->nip); !!}</center></td>
                        <td><center>{!! $x !!}.</td>
                        <td>{!!$kolaborasidatataspen->namalengkap!!} <br> <small>{!!$kolaborasidatataspen->tmlhr.", ".(($kolaborasidatataspen->tglhr != '0000-00-00')?date('d-m-Y', strtotime($kolaborasidatataspen->tglhr)):'')!!}</small></td>
                        <td>{!!$kolaborasidatataspen->nip!!} <br> {!!$kolaborasidatataspen->niplama!!}</td>
                        <td>{!!$kolaborasidatataspen->golru!!} <br> {!!(($kolaborasidatataspen->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($kolaborasidatataspen->tmtpkt)):'')!!}</td>
                        <td align="center">{!!($kolaborasidatataspen->esl!='')?$kolaborasidatataspen->esl:'-'!!}</td>
                        <td><small>{!!strtoupper(($kolaborasidatataspen->jabatan!='')?$kolaborasidatataspen->jabatan:'-')." PADA ".(($kolaborasidatataspen->path_short !='-')?$kolaborasidatataspen->path_short:'')." <br> ".(($kolaborasidatataspen->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($kolaborasidatataspen->tmtjbt)):'')!!}</small></td>
                        <td align="right">{!!$kolaborasidatataspen->mkthnpkt!!}</td>
                        <td align="right">{!!$kolaborasidatataspen->mkblnpkt!!}</td>
                        <td align="right">{!!substr($kolaborasidatataspen->mkskr,0,-2)!!}</td>
                        <td align="right">{!!substr($kolaborasidatataspen->mkskr,-2)!!}</td>
                        <td align="right">{!!$kolaborasidatataspen->tkpendid!!}</td>
                        <td align="right">{!!$kolaborasidatataspen->jenjurusan!!}</td>
                        <td>{!!$kolaborasidatataspen->agama."<br>".substr($kolaborasidatataspen->usia,0,2)." thn ".substr($kolaborasidatataspen->usia,2,2)." bln"!!}</td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a class="text-primary sinkolab" recid="{{$kolaborasidatataspen->nip}}" href="javascript:void(0)"><i class="fa fa-link"></i> Sinkronisasi</a></li>
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
                    &nbsp;
                </div>
                <div class="col-sm-6">
                    <?php echo $kolaborasidatataspens->appends(array('idskpd'=>Input::get('idskpd'), 'idstspeg' => Input::get('idstspeg'), 'stskolab' => Input::get('stskolab'), 'search' => Input::get('search')))->render(); ?>
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
        $('#sinkall').hide();
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#sinkall').fadeIn(300);
            else
                $('#sinkall').fadeOut(300);
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

        $("#sinkall").click(function(e) {
            e.preventDefault();
            var iki = $('#data');
            bootbox.confirm("Sinkronisasi semua kolaborasi data Taspen ?", function(confirmed) {
                if(confirmed){
                    $.ajax({
                        url : index_page + '/sinkall',
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
                                    //$(this).closest('tr').fadeOut(100);
                                    $(this).closest('tr').remove();
                                }
                            });
                            $('#sinkall').fadeOut(300);
                        }
                    });
                }
            });
        });

        $("a.sinkolab").click(function(e) {
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm("Sinkronisasi kolaborasi data Taspen ?", function(confirmed) {
                if(confirmed){
                    $.ajax({
                        url : index_page + '/sinkall',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
                                notification('Data berhasil sinkronisasi','success');
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
    });
</script>
