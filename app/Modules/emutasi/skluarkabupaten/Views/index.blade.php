<section class="content-header">
    <h1>
        SK Luar Kabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">SK Luar Kabupaten</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-lg-2 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!} &nbsp;
                </div>
            </div>
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}

                <table width="80%" id="tables" class="pull-right">
                    <tr>
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
                        <th width="3%">NO</th>
                        <th>NIP<br>NAMA LENGKAP</th>
                        <th>GOL.<br>RUANG</th>
                        <th>PENDIDIKAN<br>TERAKHIR</th>
                        <th colspan="2">JABATAN LAMA PADA SKPD</th>
                        <th>PERMINTAAN MUTASI LUAR DAERAH</th>
                        <th>STATUS</th>
                        <th>PROSES</th>
                        <th width="7%">AKSI.</th>
                    </tr>
                    </thead>

                    <tbody>                    
                    <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($skluarkabupatens as $skluarkabupaten)
                    <?php
                        $x++;
                        $n++;
                        $arr[$n] = $skluarkabupaten->nousul;
                            if($arr[$n]!=$arr[$n-1]){
                    ?>
                        <tr>
                            <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$skluarkabupaten->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($skluarkabupaten->tglusul))?>
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($skluarkabupaten->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                            <th style="position:relative;" colspan="8">
                                <div class="text-right">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="fa fa-print"></span> Cetak Nota Dinas
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(($skluarkabupaten->statususul == 1) or ($skluarkabupaten->statussk == 1))
                                            <li><a href="{!!url()!!}/emutasi/skluarkabupaten/cetak/nodin/{!!$skluarkabupaten->nousul!!}" target="_blank" title="Cetak Nota Dinas"><i class="fa fa-print"></i> Nota Dinas Permohonan Pindah</a></li>
                                            <!-- <li><a href="{!!url()!!}/emutasi/skluarkabupaten/cetak/pengantar_menghadapkan/{!!$skluarkabupaten->nousul!!}" target="_blank" title="Cetak Surat Pengantar Menghadapkan"><i class="fa fa-print"></i> Surat Pengantar Menghadapkan</a></li> -->
                                            <li><a href="{!!url()!!}/emutasi/skluarkabupaten/cetak/lampiran_menghadapkan/{!!$skluarkabupaten->nousul!!}" target="_blank" title="Cetak Lampiran Menghadapkan"><i class="fa fa-list"></i> Lampiran Nota Dinas</a></li>
                                            @else
                                            <li><a href="javascript:void(0)" style="color: red" target="_blank" title="Cetak Nota Dinas"><i class="fa fa-print"></i> Nota Dinas Permohonan Pindah</a></li>
                                            <!-- <li><a href="javascript:void(0)" style="color: red" title="Surat Pengantar Menghadapkan Sataus Belum Diproses"><i class="fa fa-print"></i> Surat Pengantar Menghadapkan</a></li> -->
                                            <li><a href="javascript:void(0)" style="color: red" title="Lampiran Menghadapkan Sataus Belum Diproses"><i class="fa fa-list"></i> Lampiran Nota Dinas</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>{!!$x!!}</td>
                        <td>
                            <div class="text-right" style="position:relative">
                                <?php
                                if($skluarkabupaten->iscetaksk == 1){
                                    echo '<div style="position:absolute;right:-3px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                }else if($skluarkabupaten->iscetaksk == 2){
                                    echo '<div style="position:absolute;right:-3px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                }
                                ?>
                            </div>
                            <?=$skluarkabupaten->nip?><br>
                            <?=$skluarkabupaten->namalengkap?>
                        </td>
                        <td><?=$skluarkabupaten->golru?><br><?=date("d-m-Y", strtotime($skluarkabupaten->tmtpkt))?></td>
                        <td><?=ucword(($skluarkabupaten->jenjurusan!='')?$skluarkabupaten->jenjurusan:$skluarkabupaten->tkpendid." ".$skluarkabupaten->jenjurusan)?></td>
                        <td><?=ucword($skluarkabupaten->jabatan)?></td>
                        <td><?=ucword($skluarkabupaten->skpd)." ".$skluarkabupaten->path."<br>".date("d-m-Y", strtotime($skluarkabupaten->tmtjbt))?></td>
                        <td>
                            <?=$skluarkabupaten->instansi?>,
                            <?=$skluarkabupaten->kabupaten?>,
                            <?=$skluarkabupaten->provinsi?>,
                            <?=date("d-m-Y", strtotime($skluarkabupaten->tglskpermintaan))?>
                        </td>
                        <td>
                            <div align="center">
                                <?php
                                if($skluarkabupaten->statususul==1){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                }else if($skluarkabupaten->statususul==2){
                                    echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                }else if($skluarkabupaten->statususul==3){
                                    echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                }else{
                                    echo '-';
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <?php
                                if($skluarkabupaten->statususul=='1' && $skluarkabupaten->statussk=='2'){
                                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                }else if($skluarkabupaten->statussk=='1'){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                }else {
                                    echo '-';
                                }
                                ?>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    @if(($skluarkabupaten->statususul == 1) or ($skluarkabupaten->statussk == 1))
                                    <li><a href="{!!url()!!}/emutasi/skluarkabupaten/cetak/persetujuan/{!!$skluarkabupaten->nousul!!}/{!!$skluarkabupaten->nip!!}" target="_blank" title="Cetak Surat Persetujuan"><i class="fa fa-print"></i> Surat Persetujuan</a></li>
                                    <li><a href="{!!url()!!}/emutasi/skluarkabupaten/cetak/menghadapkan/{!!$skluarkabupaten->nousul!!}/{!!$skluarkabupaten->nip!!}" target="_blank" title="Cetak Surat Menghadapkan"><i class="fa fa-print"></i> Surat Menghadapkan</a></li>
                                    @else
                                    <li><a href="javascript:void(0)" title="Surat Persetujuan Belum Selesai Diproses" style="color: red"><i class="fa fa-print"></i> Surat Persetujuan</a></li>
                                    <li><a href="javascript:void(0)" title="Surat Menghadapkan Belum Selesai Diproses" style="color: red"><i class="fa fa-print"></i> Surat Menghadapkan</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
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
              <?php echo $skluarkabupatens->appends(array('idskpd' => Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
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
