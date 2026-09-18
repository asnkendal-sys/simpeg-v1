<section class="content-header">
    <h1>
        SK Masuk Kabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Sk Masuk Kabupaten</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-lg-2 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    &nbsp; &nbsp; &nbsp;
                </div>
            </div>
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">
                        </td>
                        <td style="padding: 5px;" width="55%">
                            {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                        </td>
                        <td style="padding: 5px;" width="35%">
                            <div class="input-group" style="width: 300px;">
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
                            <!-- <th width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th> -->
                            <th rowspan="2" class="text-center" width="3%">No</th>
                            <th rowspan="2"><div class="text-center">NIP<br/>NAMA LENGKAP</div></th>
                            <th rowspan="2"><div class="text-center">GOL. RUANG</div></th>
                            <th rowspan="2"><div class="text-center">PENDIDIKAN TERAKHIR<br/>JURUSAN</div></th>
                            <th rowspan="2"><div class="text-center">JABATAN</div></th>
                            <th rowspan="2"><div class="text-center">PERMINTAAN MUTASI MASUK</div></th>
                            <th rowspan="2"><div class="text-center">STATUS</div></th>
                            <th rowspan="2"><div class="text-center">PROSES</div></th>
                            <th rowspan="2" class="text-center" width="7%">Act.</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $arr[0]= ""; $n = 0;
                            $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                        ?>
                        @foreach ($skmasukkabupatens as $skmasukkabupaten)
                        <?php
                            $jumlahverifikasi = \DB::table('tr_mutasi_masuk_daerah')->where("nousul","=",$skmasukkabupaten->nousul)->where("statususul","=","1")->orwhere("statussk","=","1")->get();
                            $x++;
                            $n++;
                            $arr[$n] = substr($skmasukkabupaten->nousul,0,9);
                            if($arr[$n]!=$arr[$n-1]){
                        ?>
                        <tr>
                            <th style="position:relative;" colspan="9" class="text-left">
                                NOMOR USULAN : {!!$skmasukkabupaten->nousul!!}
                                &nbsp;<i class="fa fa-calendar"></i> {!!tglina($skmasukkabupaten->tglusul)!!}<br/>
                            </th>
                            <!-- <th style="position:relative;" colspan="5">
                                <div class="text-right">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="fa fa-print"></span> Persetujuan
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(count($jumlahverifikasi) > 0)
                                            <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/skpengantar_persetujuan/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->tglusul!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Surat Pengantar Persetujan</a></li>
                                            <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/lampiran_skpengantar_persetujuan/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->tglusul!!}" target="_blank" class="text-info"><i class="fa fa-list"/></i> Lampiran Pengantar</a></li>
                                            @else
                                            <li><a href="#" title="Surat Pengantar Persetujuan Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-print"/></i> Surat Pengantar Persetujan</a></li>
                                            <li><a href="#" title="Lampiran Pengantar Persetujuan Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-list"/></i> Lampiran Pengantar</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="fa fa-print"></span> Surat Tugas
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(count($jumlahverifikasi) > 0)
                                            <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/skpengantar_tugas/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->tglusul!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Surat Pengantar Tugas</a></li>
                                            <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/lampiran_skpengantar_surattugas/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->tglusul!!}" target="_blank" class="text-info"><i class="fa fa-list"/></i> Lampiran Pengantar</a></li>
                                            @else
                                            <li><a href="#" title="Surat Pengantar Tugas Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-print"/></i> Surat Pengantar Tugas</a></li>
                                            <li><a href="#" title="Lampiran Pengantar Tugas Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-list"/></i> Lampiran Pengantar</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </th> -->
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!!$x!!}<!--{!! ClaravelHelpers::ckDelete($skmasukkabupaten->idusul); !!}--></center></td>
                            <td>
                                <div class="text-right" style="position:relative">
                                    <?php
                                        if($skmasukkabupaten->iscetaksk == 1){
                                            echo '<div style="position:absolute;right:-3px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }else if($skmasukkabupaten->iscetaksk == 2){
                                            echo '<div style="position:absolute;right:-3px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }
                                    ?>
                                </div>

                                {!!$skmasukkabupaten->nip!!} <br/> {!!$skmasukkabupaten->namalengkap!!}
                            </td>
                            <td>{!!$skmasukkabupaten->golru!!}</td>
                            <td>{!!$skmasukkabupaten->tkpendid!!} <br/> {!!$skmasukkabupaten->jenjurusan!!}</td>
                            <td>{!!$skmasukkabupaten->jabatan!!}</td>
                            <td>
                                {!!$skmasukkabupaten->instansi!!}.
                                {!!$skmasukkabupaten->kabupaten!!},
                                {!!$skmasukkabupaten->provinsi!!},
                                <!--{!!$skmasukkabupaten->noskpermintaan!!},-->
                                {!!(($skmasukkabupaten->tglskpermintaan != '0000-00-00')?date('d-m-Y', strtotime($skmasukkabupaten->tglskpermintaan)):'')!!}
                            </td>

                            <td>
                                <div align="center">
                                    @if($skmasukkabupaten->statususul==1)
                                        <span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>
                                    @elseif($skmasukkabupaten->statususul==2)
                                        <span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>
                                    @elseif($skmasukkabupaten->statususul==3)
                                        <span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>
                                    @else
                                        <span><i class="fa fa-minus" title="Belum Diverifikasi"/></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div align="center">
                                    @if($skmasukkabupaten->statususul==1 && $skmasukkabupaten->statussk==2)
                                        <span style="color:orange"><i class="fa fa-clock-o" title="Sedang Diproses"/><span>
                                    @elseif($skmasukkabupaten->statussk==1)
                                        <span style="color:green"><i class="fa fa-check-circle" title="Selesai Diproses"/></span>
                                    @else
                                        <span><i class="fa fa-minus" title="Belum Diproses"/></span>
                                    @endif
                                </div>
                            </td>
                            <td><center>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        @if(($skmasukkabupaten->statususul == 1) or ($skmasukkabupaten->statussk == 1))
                                        <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/suratpersetujuan/{!!$skmasukkabupaten->idusul!!}/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->nip!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Surat Persetujuan I</a></li>
                                        <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/suratpersetujuan2/{!!$skmasukkabupaten->idusul!!}/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->nip!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Surat Persetujuan II</a></li>
                                        <li><a href="{!!url()!!}/emutasi/skmasukkabupaten/cetak/surattugas/{!!$skmasukkabupaten->nousul!!}/{!!$skmasukkabupaten->nip!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Surat Tugas</a></li>
                                        @else
                                        <li><a href="#" title="Surat Persetujuan Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-print"/></i> Surat Persetujan</a></li>
                                        <li><a href="#" title="Surat Tugas Status Belum Diproses" style="color: red" class="text-info"><i class="fa fa-print"/></i> Surat Tugas</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </center></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
                    <div>
                        <table border="0" class="table">
                            <tr>
                                <td colspan="11">Keterangan :<br/></td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/></span> Memenuhi Syarat<br/>
                                </td>
                                <td>
                                    <span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> Tidak Memenuhi Syarat<br/>
                                </td>
                                <td>
                                    <span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span> Berkas Tidak Lengkap<br/>
                                </td>
                                <td>
                                    <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses<br/>
                                </td>
                                <td>
                                    <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses<br/>
                                </td>
                                <td>
                                    <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK<br/>
                                </td>
                                <td>
                                    <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak SK"/></span> SK Dibatalkan<br/>
                                </td>
                            </tr>
                        </table>
                    </div>
                <br/>
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $skmasukkabupatens->appends(array('search' => Input::get('search')))->render(); ?>
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
