<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Riwayat Diklat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Sync SAPK</a></li>
        <li class="active">Riwayat Diklat</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row" style="margin:20px">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
            <select id="tahun" name="tahun" class="param_search col-xs-3 form-control" style="width:100px">
                <option {!! \Input::get('tahun')=="2020"?"selected ":""; !!} value="2020">2020</option>
                <option {!! \Input::get('tahun')=="2021"?"selected ":""; !!} value="2021">2021</option>
            </select>
            <select id="jenis_diklat" name="jenis_diklat" class="param_search col-xs-3 form-control" style="width:200px;margin-left: 20px;">
                <option {!! \Input::get('jenis_diklat')=="teknis"?"selected  ":""; !!}value="teknis">Teknis</option>
                <option {!! \Input::get('jenis_diklat')=="fungsional"?"selected ":""; !!}value="fungsional">Fungsional</option>
                <option {!! \Input::get('jenis_diklat')=="struktural"?"selected ":""; !!}value="struktural">Struktural</option>
            </select>         
            <div class="input-group" style="width: 400px;">
                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}" style="margin-left: 20px;">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                </span>
            </div>   
            {!!csrf_field()!!}
            {!! Form::close() !!}
        </div>
        {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <input type="hidden" name="jenis_diklat" id="jenis_diklat_data">
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th rowspan="2" width="2%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>SKPD</th>
                        <th>Tanggal</th>
                        <th>Diklat</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['diklat'] as $diklat)
                        <tr>
                            <td>
                            <center>
                                <input type="checkbox" class="checkme" name="id[]" value="{!! $diklat->id !!}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="kirim SAPK">
                            </center>
                            </td>
                            <td>{!! $diklat->nip !!}</td>
                            <td>{!! $diklat->pegawai->nama !!}</td>
                            <td>{!! $diklat->pegawai->idskpd !!}</td>
                            <td>{!! $diklat->tgmul !!}</td>
                            <td>{!! $diklat->nama_diklat!!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p style="height: 50px;">&nbsp;</p>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              <?php echo $data['diklat']->appends(array('search' => Input::get('search')))->render(); ?>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-success btn-sm pull-right" style="" id="kirimsemua" type="submit"><i class="fa fa-send"></i> Kirim ke SAPK</button>
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
        $('#kirimsemua').fadeOut();
        $('#idskpd').select2();
        $('#jenis_diklat_data').val($('#jenis_diklat').val());
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#kirimsemua').fadeIn(300);
            else if ($('.checkme:checkbox:checked').val() === undefined){
                $('#kirimsemua').fadeOut(300);
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
            bootbox.confirm('Kirim ke SAPK?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/kirimsapk',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html == 1){
                                notification("Berhasil kimim SAPK",'success');
                                refresh_page();
                            }else{
                                notification("Ada kesalahan.!",'error');
                            }
                        }
                    });
                }
            });            
        });
    });

    $('#tabel tr').on('click', function() {
        $(this).find(':checkbox').click();
    });

    $('#cari').on('change','.param_search', function(e){
        e.preventDefault();
        $('#cari').submit();
    });

    $('#jenis_diklat').on('change', function(e){
        e.preventDefault();
        $('#jenis_diklat_data').val($(this).val());
    });
</script>
