<section class="content-header">
    <h1>
        Rekap Usulan Kenaikan Pangkat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Rekap Usulan Kenaikan Pangkat</li>
    </ol>
</section>
<section class="content">
<div id="rekap" class="tab-pane">
<p>
<div class="nav-tabs-custom" style="box-shadow:none;">
<ul class="nav nav-tabs tab2" id="myTab">
    <li><a data-toggle="tab" href="{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat"><i class="fa fa-fw fa-dot-circle-o"></i> DATA KENAIKAN PANGKAT</a></li>
    <li class="active"><a data-toggle="tab" href="{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/rekap"><i class="fa fa-fw fa-dot-circle-o"></i> REKAP KENAIKAN PANGKAT</a></li>
</ul>

<div class="tab-content">
<div id="profesikeb" class="tab-pane active">
<p>

<div class="box-header with-border row">
    <div class="col-md-12">
        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-horizontal cetak-rekap form-'.\Config::get('claravel::ajax'),'id' => 'cari', 'target' => '_blank')) !!}
        {!!csrf_field()!!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idjeniskp', 'Jenis KP:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-5">
                    {!! PenetapannominatifkpModel::comboJenisKpNominatif("idjeniskp",Input::get('idjeniskp'),"",".: Jenis KP :.") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tanggal1', 'TMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-2">
                    <div class='input-group datepicker'>
                        <input type="text" name="tanggal1" id="tanggal1" class="form-control date awal" value="{!!Input::get('tanggal1')!!}" placeholder="dd-mm-yyyy">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-1" style="margin-top: 7px; width: 55px">
                    s/d
                </div>
                <div class="col-sm-2">
                    <div class='input-group datepicker'>
                        <input type="text" name="tanggal2" id="tanggal2" class="form-control date awal" value="{!!Input::get('tanggal2')!!}" placeholder="dd-mm-yyyy">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button class="btn btn-success" type="submit" id="cari-nominasi"><span class="fa fa-fw fa-filter"></span> Filter Kenaikan Pangkat</button>&nbsp;
                    <button class="btn btn-success" type="button" id="cetak-sk"><span class="fa fa-fw fa-print"></span> Cetak SK Kenaikan Pangkat</button>&nbsp;
                    <button class="btn btn-success" type="button" id="cetak-nominatif"><span class="fa fa-fw fa-print"></span> Cetak Nominatif</button>&nbsp;
                </div>
            </div>
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
                <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA UNIT KERJA</th>
                <th colspan="2">PERIODE</th>
                <th rowspan="2" style="vertical-align : middle;text-align:center;">JUMLAH USULAN</th>
                <th colspan="3">STATUS USULAN</th>
                <th colspan="3">STATUS PROSES</th>
            </tr>
            <tr>
                <th>BULAN</th>
                <th>TAHUN</th>
                <th>MEMENUHI SYARAT</th>
                <th>TIDAK MEMENUHI</th>
                <th>BERKAS TIDAK LENGKAP</th>
                <th>BELUM PROSES</th>
                <th>DALAM PROSES</th>
                <th>PROSES SELESAI</th>
            </tr>
            </thead>
            <!-- // -->

            <tbody>
            <?php
            $arr[0]= "";
            $n = 0;
            ?>
            @foreach ($rekapusulankenaikanpangkats as $rekapusulankenaikanpangkat)            
            <?php $n++; ?>                        
            <tr>
                <td>{!!$n!!}</td>
                <td>
                    <div class="text-left"><?php echo getskpdgroup(substr($rekapusulankenaikanpangkat->idskpd, 0,2)); ?></div>
                </td>
                <td>
                    <div class="text-left">{!!formatBulan($rekapusulankenaikanpangkat->bulan)!!}</div>
                </td>
                <td>
                    <div class="text-left">{!!$rekapusulankenaikanpangkat->tahun!!}</div>
                </td>
                <td>
                    <div class="text-left">{!!$rekapusulankenaikanpangkat->jmlusulan!!}</div>
                </td>
                <td>{!!$rekapusulankenaikanpangkat->ms!!}</td>
                <td>{!!$rekapusulankenaikanpangkat->tms!!}</td>
                <td>{!!$rekapusulankenaikanpangkat->bts!!}</td>
                <td>{!!$rekapusulankenaikanpangkat->bp!!}</td>
                <td>{!!$rekapusulankenaikanpangkat->dp!!}</td>
                <td>{!!$rekapusulankenaikanpangkat->ps!!}</td>
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
            <?php echo $rekapusulankenaikanpangkats->appends(array('tanggal1' => Input::get('tanggal1'), 'tanggal2' => Input::get('tanggal2'), 'idskpd' => Input::get('idskpd'), 'idjeniskp' => Input::get('idjeniskp')))->render(); ?>
        </div>
    </div>
</div>
{!! Form::close() !!}
</p>
</div>
<!-- /.tab-pane -->
</div>
</div>
</p>
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

        $(".datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".date").mask("99-99-9999");

        $('ul#myTab').on('click','a',function(e){
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
        $('#cari-nominasi').on('click',function(e){
            e.preventDefault();

            $('#cari').attr("method", "get");
            $.ajax({
                url : '{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/rekap',
                data: $('#cari').serialize(),
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

        $('#cetak-sk').on('click', function(e){
            e.preventDefault();
            $('.cetak-rekap').attr("method", "post");
            $('.cetak-rekap').attr("action", "{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/rekapsk");
            $('.cetak-rekap').submit();
        });

        $('#cetak-nominatif').on('click', function(e){
            e.preventDefault();
            $('.cetak-rekap').attr("method", "post");
            $('.cetak-rekap').attr("action", "{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/rekapnominatif");
            $('.cetak-rekap').submit();
        });
    });
</script>
