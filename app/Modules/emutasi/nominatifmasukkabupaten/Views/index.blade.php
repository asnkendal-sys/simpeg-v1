<section class="content-header">
    <h1>
        Nominatif Masuk Kabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Masuk Kabupaten</li>
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
                        <!--<th width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>-->
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
                        @foreach ($nominatifmasukkabupatens as $nominatifmasukkabupaten)
                        <?php
                            $x++;
                            $n++;
                            $arr[$n] = substr($nominatifmasukkabupaten->nousul,0,9);
                            if($arr[$n]!=$arr[$n-1]){
                        ?>
                        <tr>
                            <th style="position:relative;" colspan="4" class="text-left">
                                NOMOR USULAN : {!!$nominatifmasukkabupaten->nousul!!}
                                &nbsp;<i class="fa fa-calendar"></i> {!!tglina($nominatifmasukkabupaten->tglusul)!!}<br/>
                            </th>
                            <th style="position:relative;" colspan="5">
                                <div class="text-right">
                                    &nbsp;<a href="{!!url()!!}/emutasi/nominatifmasukkabupaten/create/{!!$nominatifmasukkabupaten->nousul!!}/{!!$nominatifmasukkabupaten->tglusul!!}" id="addusulan" class="addusulan" title="Tambah Nominasi"><i class="fa fa-plus"> Tambah</i></a> |
                                    &nbsp;<a href="#" recnousul="{!!$nominatifmasukkabupaten->nousul!!}" recid="all" class="attrpermohonan" act="permohonanall" title="Cetak Surat Permohonan" ><i class="fa fa-print"/></i> Permohonan</a> |
                                    &nbsp;<a href="javascript:void(0)" recid="{!!$nominatifmasukkabupaten->nousul!!}" id="deletenominatif" title="Delete Daftar"><i class="fa fa-trash-o"> Hapus</i></a>
                                </div>
                            </th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!!$x!!}<!--{!! ClaravelHelpers::ckDelete($nominatifmasukkabupaten->idusul); !!}--></center></td>
              					<td>
                                    <div class="text-right" style="position:relative">
                                        <?php
                                            if($nominatifmasukkabupaten->iscetaksk == 1){
                                                echo '<div style="position:absolute;right:-3px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                            }else if($nominatifmasukkabupaten->iscetaksk == 2){
                                                echo '<div style="position:absolute;right:-3px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                            }
                                        ?>
                                    </div>
                                    {!!$nominatifmasukkabupaten->nip!!} <br/> {!!$nominatifmasukkabupaten->namalengkap!!}
                                </td>
              					<td>{!!$nominatifmasukkabupaten->golru!!}</td>
              					<td>{!!$nominatifmasukkabupaten->tkpendid!!} <br/> {!!$nominatifmasukkabupaten->jenjurusan!!}</td>
              					<td>{!!$nominatifmasukkabupaten->jabatan!!}</td>
              					<td>
                                {!!$nominatifmasukkabupaten->instansi!!}.
                                {!!$nominatifmasukkabupaten->kabupaten!!},
                                {!!$nominatifmasukkabupaten->provinsi!!},
                                <!--{!!$nominatifmasukkabupaten->noskpermintaan!!},-->
                                {!!(($nominatifmasukkabupaten->tglskpermintaan != '0000-00-00')?date('d-m-Y', strtotime($nominatifmasukkabupaten->tglskpermintaan)):'')!!}
                            </td>

                            <td>
                                <div align="center">
                                    @if($nominatifmasukkabupaten->statususul==1)
                                        <span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>
                                    @elseif($nominatifmasukkabupaten->statususul==2)
                                        <span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>
                                    @elseif($nominatifmasukkabupaten->statususul==3)
                                        <span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>
                                    @else
                                        <span><i class="fa fa-minus" title="Belum Diverifikasi"/></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div align="center">
                                    @if($nominatifmasukkabupaten->statususul==1 && $nominatifmasukkabupaten->statussk==2)
                                        <span style="color:orange"><i class="fa fa-clock-o" title="Sedang Diproses"/><span>
                                    @elseif($nominatifmasukkabupaten->statussk==1)
                                        <span style="color:green"><i class="fa fa-check-circle" title="Selesai Diproses"/></span>
                                    @else
                                        <span><i class="fa fa-minus" title="Belum Diproses"/></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#" recnousul="{!!$nominatifmasukkabupaten->nousul!!}" recidusul="{!!$nominatifmasukkabupaten->idusul!!}" class="edit" act="edit" title="Edit Mutasi" ><i class="fa fa-pencil-square-o"/></i> Edit Mutasi</a></li>
                                        <li><a href="#" recnousul="{!!$nominatifmasukkabupaten->nousul!!}" recidusul="{!!$nominatifmasukkabupaten->idusul!!}" class="penetapan" act="penetapan" title="Penetapan Keputusan" ><i class="fa fa-check-square-o"/></i> Verifikasi</a></li>
                                        <li><a href="{!!url()!!}/emutasi/nominatifmasukkabupaten/cetak/suratpermohonan/{!!$nominatifmasukkabupaten->idusul!!}/{!!$nominatifmasukkabupaten->nousul!!}/{!!$nominatifmasukkabupaten->nip!!}" target="_blank" class="text-info"><i class="fa fa-print"/></i> Permohonan</a></li>
                                        <li>{!! ClaravelHelpers::btnDelete($nominatifmasukkabupaten->idusul) !!}</li>
                                    </ul>
                                </div>
                            </td>
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
            <p style="height: 50px;">&nbsp;</p>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $nominatifmasukkabupatens->appends(array('search' => Input::get('search')))->render(); ?>
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

         $('.edit').on('click', function(e){
            e.preventDefault();
            claravel_modal('Edit Mutasi Masuk Kabupaten','Loading...','main_modal2');
            $.ajax({
               type:'post',
               url : '{!!url()!!}/emutasi/nominatifmasukkabupaten/data/edit',
               data: {'nousul': $(this).attr('recnousul'), 'idusul': $(this).attr('recidusul'), '_token' : '{!!csrf_token()!!}'},
               success:function(html){
                   $('#main_modal2 .modal-body').html(html);
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

        $('.addusulan').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    $('#loading-state').fadeIn("slow");
                },
                success:function(html){
                    $('#loading-state').fadeOut("slow");
                    $('#utama').html(html);
                }
            });
        });

        $('a#deletenominatif').on('click', function(e){
            e.preventDefault();
            var $this =$(this);
            var nousul =  $this.attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                      url : '{!!url()!!}/emutasi/nominatifmasukkabupaten/deletenominatif',
                      type : 'post',
                      data: {'nousul' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                      beforeSend: function(){
                          // preloader.on();
                          $('#loading-state').fadeIn("slow");
                      },
                      success:function(html){
                            //preloader.off();
                            //$('#loading-state').fadeOut("slow");
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                refresh_page();
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

        $('.attrpermohonan').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Surat Permohonan','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/emutasi/nominatifmasukkabupaten/data/attrpermohonan',
                data: {'nousul': $(this).attr('recnousul'), 'id': $(this).attr('recid'), 'act':$(this).attr('act'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('.penetapan').on('click', function(e){
           e.preventDefault();
           claravel_modal('Verifikasi Mutasi Masuk Kabupaten','Loading...','main_modal2');
           $.ajax({
              type:'post',
              url : '{!!url()!!}/emutasi/nominatifmasukkabupaten/data/penetapan',
              data: {'nousul': $(this).attr('recnousul'), 'idusul': $(this).attr('recidusul'), '_token' : '{!!csrf_token()!!}'},
              success:function(html){
                  $('#main_modal2 .modal-body').html(html);
              }
           });
       });
    });
</script>
