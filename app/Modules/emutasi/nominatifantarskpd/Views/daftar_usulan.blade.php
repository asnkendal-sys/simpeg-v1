<section class="content-header">
    <h1>
        Nominatif Usulan Mutasi Dalam SKPD<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Usulan Mutasi Dalam SKPD</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li><a data-toggle="tab" href="{!!url()!!}/emutasi/nominatifantarskpd
                        "> <i class="fa fa-fw fa-pencil"></i> NOMINATIF MUTASI DALAM SKPD</a></li>
                        <li class="active"><a data-toggle="tab" href="{!!url()!!}/emutasi/nominatifantarskpd/daftarusulan"><i class="fa fa-fw fa-list-ul"></i> DAFTAR USUL MUTASI DALAM SKPD</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active">
                            <p>
                                <div class="box-header with-border">
                                    <div style="height: 35px">&nbsp;</div>
                                    <div class="box-tools pull-right col-md-12">
                                        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                                        {!!csrf_field()!!}
                                        <table class="table">
                                            <tr>
                                                <td width="10%"><a id="buat" href="{!!url()!!}/emutasi/nominatifantarskpd/create" class="btn btn-primary {!! \Config::get('claravel::ajax') !!}">
                                                  <i class='fa fa-plus-square'></i> Buat Baru</a></td>
                                                  <td width="50%">{!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}</td>
                                                  <td width="20%">
                                                    <div class="input-group" style="width: 200px;">
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
                                                    <th><div class="text-center">NIP<br>NAMA LENGKAP</div></th>
                                                    <th><div class="text-center">GOL. RUANG</div></th>
                                                    <th><div class="text-center">PENDIDIKAN<br>TERAKHIR</div></th>
                                                    <th colspan="2"><div class="text-center">JABATAN LAMA PADA SKPD</div></th>
                                                    <th colspan="2"><div class="text-center">JABATAN BARU PADA SKPD</div></th>
                                                    <th><div class="text-center">STATUS</div></th>
                                                    <th><div class="text-center">PROSES</div></th>
                                                    <th width="7%"><div class="text-center">AKSI</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $arr[0]= "";
                                                $n = 0;
                                                ?>
                                                @foreach ($nominatifantarskpds as $nominatifantarskpd)
                                                <?php
                                                $n++;
                                                $arr[$n] = $nominatifantarskpd->nousul;
                                                if($arr[$n]!=$arr[$n-1]){
                                                    ?>
                                                    <tr>
                                                        <th style="position:relative;" colspan="5">
                                                            <div class="text-left">
                                                                NOMOR USULAN : {{$nominatifantarskpd->nousul}}&nbsp;
                                                                <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($nominatifantarskpd->tglusul))?><br>
                                                            </div>
                                                        </th>
                                                        <th style="position:relative;" colspan="6">
                                                            <div class="text-right">
                &nbsp;<a href="{!!url()!!}/emutasi/nominatifantarskpd/create/{!!$nominatifantarskpd->nousul!!}/{!!$nominatifantarskpd->tglusul!!}" id="addusulan" class="addusulan" title="Tambah Nominasi"><i class="fa fa-plus"> Tambah</i></a> |
                                                                &nbsp;<a href="#" class="attrpengantar" recnousul="{!!$nominatifantarskpd->nousul!!}" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-file"> Pengantar</i></a> |
&nbsp;<a target="_blank" href="{!!url()!!}/emutasi/nominatifantarskpd/cetaknominatif/{!!$nominatifantarskpd->nousul!!}" class="attrnominatif" act="nominatif" title="Cetak Daftar Nominatif"><i class="fa fa-list"> Nominatif</i></a> |
                                                                &nbsp;<a href="javascript:void(0)" recnousul="{!!$nominatifantarskpd->nousul!!}" id="usdelete" title="Delete Daftar"><i class="fa fa-trash-o"> Hapus</i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td><center>{!! $n !!}</center></td>
                                                        <td>{!!$nominatifantarskpd->nip!!}<br>{!!$nominatifantarskpd->namalengkap!!}
                                                            <a title="popdetil" href="javascript:void(0)"></a><br>
                                                            <div class="text-right" style="position:relative">
                                                                @if($nominatifantarskpd->iscetaksk == 1)
                                                                <div style="position:absolute;right:-3px;top:-6px;color:#ffcc00;">
                                                                    <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                                                </div>
                                                                @elseif($nominatifantarskpd->iscetaksk == 2)
                                                                <div style="position:absolute;right:-3px;top:-6px;color:#000000;">
                                                                    <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                                                </div>
                                                                @endif
                                                            </div></td>
                                                            <td>{!!$nominatifantarskpd->golru!!}<br>{!!$nominatifantarskpd->tmtpkt!!}</td>
                                                            <td>{!!$nominatifantarskpd->tkpendid!!}<br>{!!$nominatifantarskpd->jenjurusan!!}</td>
                                                            <td>{!!$nominatifantarskpd->skpdlama!!}</td>

                                                            <td>{!!$nominatifantarskpd->jabatan!!}<br>{!!$nominatifantarskpd->tmtjbt!!}</td>
                                                            <td>{!!$nominatifantarskpd->skpdbaru!!}</td>
                                                            <td>{!!$nominatifantarskpd->jabatanbaru!!}</td>
                                                            <td>
                                                                <div align="center">
                                                                    @if($nominatifantarskpd->statususul==1)
                                                                    <span style="color:green">
                                                                        <i class="glyphicon glyphicon-ok" title="Memenuhi Syarat"/>
                                                                        <span>
                                                                            @elseif($nominatifantarskpd->statususul==2)
                                                                            <span style="color:red">
                                                                                <i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat"/>
                                                                            </span>
                                                                            @elseif($nominatifantarskpd->statususul==3)
                                                                            <span style="color:orange">
                                                                                <i class="glyphicon glyphicon-exclamation-sign" title="Berkas Tidak Lengkap"/>
                                                                            </span>
                                                                            @else
                                                                            -
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div align="center">
                                                                            @if($nominatifantarskpd->statususul=='1' && $nominatifantarskpd->statussk=='2')
                                                                            <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/><span>
                                                                                @elseif($nominatifantarskpd->statussk=='1')
                                                                                <span style="color:green"><i class="glyphicon glyphicon-ok" title="Selesai diproses"/></span>
                                                                                @else
                                                                                -
                                                                                @endif
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                          <div class="btn-group">
                                                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                                                <span class="caret"></span> Aksi
                                                                            </button>
                                                                            <ul class="dropdown-menu pull-right">
<li><a href="javascript:void(0)" class="text-info editmutasi" recidusul="{!!$nominatifantarskpd->idusul!!}" recnip="{!!$nominatifantarskpd->nip!!}" recnousul="{!!$nominatifantarskpd->nousul!!}"><i class="fa fa-pencil-square-o"></i>Edit Personal</a></li>
        <li><a href="javascript:void(0)" class="text-info verifikasimutasi" recidusul="{!!$nominatifantarskpd->idusul!!}" recnip="{!!$nominatifantarskpd->nip!!}" recnousul="{!!$nominatifantarskpd->nousul!!}"><i class="fa fa-check"></i> Verifikasi Usulan</a></li>

                                                                                <li><a id='hapus' href="javascript:void(0)" recidusul="{!!$nominatifantarskpd->idusul!!}" class='text-danger'><i class='fa fa-times-circle'></i> Hapus</a></li>
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
                                                    <p style="height: 50px;">&nbsp;</p>
                                                </div>
                                                <div class="box-footer clearfix">
                                                  <div class="row">
                                                    <div class="col-sm-6">
                                                      {!! ClaravelHelpers::btnDeleteAll() !!}
                                                  </div>
                                              </div>
                                          </div>
                                          {!! Form::close() !!}
                                      </p>
                                  </div>
                                  <!-- /.tab-pane -->
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
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
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

                    $('ul#myTab').on('click','a',function(e){
                        var str = $(this).attr('href');
                        var n = str.search("dashboard");
                        if(n > 0){
                        }
                        else{
                            e.preventDefault();
                            e.stopImmediatePropagation();

                            $.ajax({
                                type: 'get',
                                url : $(this).attr('href'),
                                beforeSend: function(){
                                    $('#loading-state').fadeIn("slow");
                                },
                                success: function(data) {
                                    $('#loading-state').fadeOut("slow");
                                    $('#utama').html(data);
                                }
                            });
                        }
                    });

                    $('#buat').on('click',function(e){
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

                    <?php
                    echo 'var index_page=laravel_base + "/'.\Request::path().'";';
                    ?>

                    $('a.editmutasi').on('click', function(e){
                        e.preventDefault();
                        claravel_modal('Edit Nominatif Mutasi Dalam SKPD','Loading...','main_modal2');
                        $.ajax({
                            type:'post',
                            url : '{!!url()!!}/emutasi/nominatifantarskpd/data/editmutasi',
                            data: {'idusul': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal2 .modal-body').html(html);
                            }
                        });
                    });

                    $('a.verifikasimutasi').on('click', function(e){
                        e.preventDefault();
                        claravel_modal('Verifikasi Nominatif Mutasi Dalam SKPD','Loading...','main_modal2');
                        $.ajax({
                            type:'post',
                            url : '{!!url()!!}/emutasi/nominatifantarskpd/data/verifikasi',
                            data: {'idusul': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal2 .modal-body').html(html);
                            }
                        });
                    });


                    $('#tabel').on('click','#hapus',function(e){
                        e.preventDefault();
                        var $this =$(this);
                        bootbox.confirm('Hapus?',function(a){
                            if(a == true){
                                $.ajax({
                                    url : '{!!url()!!}/emutasi/nominatifantarskpd/delete',
                                    type : 'post',
                                    data: {'idusul' : $this.attr('recidusul'), '_token' : '{!!csrf_token()!!}'},
                                    beforeSend: function(){
                            // preloader.on();
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            // preloader.off();
                            $('#loading-state').fadeOut("slow");
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

                    $('a#usdelete').on('click', function(e){
                      e.preventDefault();
                      var $this =$(this);
                      var nousul =  $this.attr('recid');
                      bootbox.confirm('Hapus?',function(a){
                          if(a == true){
                              $.ajax({
                                  url : '{!!url()!!}/emutasi/nominatifantarskpd/usdelete',
                                  type : 'post',
                                  data: {'nousul' : $this.attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
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

                    $('#tabel').on('click','#edit',function(e){
                        e.preventDefault();
                        var $this = $(this);
                        bootbox.confirm('Edit?',function(a){
                            if(a == true){
                                $.ajax({
                                    url : index_page + '/edit',
                                    type : 'get',
                                    data:'id=' + $this.attr('recid'),
                                    beforeSend: function(){
                                        $('#loading-state').fadeIn("slow");
                                    },
                                    success:function(html){
                                        $('#loading-state').fadeOut("slow");
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

                    $('a.prevfile').on('click', function(e){
                        e.preventDefault();
                        claravel_modal('Upload Dokumen Pendukung','Loading...','main_modal2');
                        preview($(this).attr('recid'), $(this).attr('recnip'), $(this).attr('recnousul'), $(this).attr('rectglusul'));
                    });

                    $('.attrpengantar').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('Atribut Dokumen Pengantar','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/nominatifantarskpd/data/attrpengantar',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })
                });


            </script>
