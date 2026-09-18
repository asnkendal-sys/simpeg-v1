<section class="content-header">
    <h1>
        Nominatif Usulan Mutasi Dalam OPD<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Usulan Mutasi Dalam OPD</li>
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
                            <th><div class="text-center">NIP<br>NAMA LENGKAP</div></th>
                            <th><div class="text-center">GOL. RUANG</div></th>
                            <th><div class="text-center">PENDIDIKAN<br>TERAKHIR</div></th>
                            <th colspan="2"><div class="text-center">JABATAN LAMA PADA OPD</div></th>
                            <th colspan="2"><div class="text-center">JABATAN BARU PADA OPD</div></th>
                            <th><div class="text-center">STATUS</div></th>
                            <th><div class="text-center">PROSES</div></th>
                            <th width="7%"><div class="text-center">AKSI</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                        ?>
                        @foreach ($nominatifdalamskpds as $nominatifdalamskpd)
                        <?php
                        $x++;
                        $n++;
                        $arr[$n] = $nominatifdalamskpd->nousul;
                        if($arr[$n]!=$arr[$n-1]){
                            ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$nominatifdalamskpd->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($nominatifdalamskpd->tglusul))?>
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($nominatifdalamskpd->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-right">
                                        &nbsp;<a href="#" class="attrtambahus" 
                                        recnousul="{!!$nominatifdalamskpd->nousul!!}" 
                                        rectglusul="{!!$nominatifdalamskpd->tglusul!!}" 
                                        recnosuratrek="{!!$nominatifdalamskpd->no_suratrek!!}" 
                                        recsuratdari="{!!$nominatifdalamskpd->surat_dari!!}" 
                                        rectglsurat="{!!$nominatifdalamskpd->tgl_suratrek!!}"
                                        recperihalrek="{!!$nominatifdalamskpd->perihalrek!!}" 
                                        act="tambahus"><i class="fa fa-plus"> Tambah</i></a> |
                                        
                                        <!-- &nbsp;<a href="javascript:void(0)" class="attrpengantar" recnousul="{!!$nominatifdalamskpd->nousul!!}" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-file"> Pengantar</i></a> | -->

                                        &nbsp;<a href="javascript:void(0)" class="attrnominatif" recnousul="{!!$nominatifdalamskpd->nousul!!}" act="nominatif" title="Cetak Daftar Nominatif"><i class="fa fa-list"> Nominatif</i></a> |
                                        <!-- &nbsp;<a href="#" class="attrnominatifbupati" recnousul="}" act="nominatifbupati" title="Cetak Daftar  Nominatif checklsit Bupati"><i class="fa fa-list"> Lamp. Checklist</i></a> |-->

                                        &nbsp;<a href="javascript:void(0)" recnousul="{!!$nominatifdalamskpd->nousul!!}" id="usdelete" title="Delete Daftar"><i class="fa fa-trash-o"> Hapus</i></a>
                                    </div>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!! $x !!}</center></td>
                            <td>{!!$nominatifdalamskpd->nip!!}<br>{!!$nominatifdalamskpd->namalengkap!!}
                                <a title="popdetil" href="javascript:void(0)"></a><br>
                                <div class="text-right" style="position:relative">
                                    @if($nominatifdalamskpd->iscetaksk == 1)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#ffcc00;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @elseif($nominatifdalamskpd->iscetaksk == 2)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#000000;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @endif
                                </div></td>
                                <td>{!!$nominatifdalamskpd->golru!!}<br>{!!($nominatifdalamskpd->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($nominatifdalamskpd->tmtpkt)):''!!}</td>
                                <td>{!!$nominatifdalamskpd->tkpendid!!}<br>{!!$nominatifdalamskpd->jenjurusan!!}</td>
                                <td>{!!$nominatifdalamskpd->skpdlama!!}</td>

                                <td>{!!$nominatifdalamskpd->jabatan!!}<br>{!!($nominatifdalamskpd->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($nominatifdalamskpd->tmtjbt)):''!!}</td>
                                <td>{!!$nominatifdalamskpd->skpdbaru!!}</td>
                                <td>{!!$nominatifdalamskpd->jabatanbaru!!}</td>
                                <td>
                                    <div align="center">
                                        @if($nominatifdalamskpd->statususul==1)
                                        <span style="color:green">
                                            <i class="glyphicon glyphicon-ok" title="Memenuhi Syarat"/>
                                            <span>
                                                @elseif($nominatifdalamskpd->statususul==2)
                                                <span style="color:red">
                                                    <i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat"/>
                                                </span>
                                                @elseif($nominatifdalamskpd->statususul==3)
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
                                                @if($nominatifdalamskpd->statususul=='1' && $nominatifdalamskpd->statussk=='2')
                                                <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/><span>
                                                    @elseif($nominatifdalamskpd->statussk=='1')
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
                                                    <li><a href="javascript:void(0)" class="text-info editmutasi" recidusul="{!!$nominatifdalamskpd->idusul!!}" recnip="{!!$nominatifdalamskpd->nip!!}" recnousul="{!!$nominatifdalamskpd->nousul!!}"><i class="fa fa-pencil-square-o"></i>Edit Personal</a></li>
                                                    @if(session::get('role_id')!=3 || session::get('role_id')!=5)
                                                    <li><a href="javascript:void(0)" class="text-info verifikasimutasi" recidusul="{!!$nominatifdalamskpd->idusul!!}" recnip="{!!$nominatifdalamskpd->nip!!}" recnousul="{!!$nominatifdalamskpd->nousul!!}"><i class="fa fa-check"></i> Verifikasi Usulan</a></li>
                                                    @else
                                                    <li><a href="javascript:void(0)" class="text-info verifikasimutasi" recidusul="{!!$nominatifdalamskpd->idusul!!}" recnip="{!!$nominatifdalamskpd->nip!!}" recnousul="{!!$nominatifdalamskpd->nousul!!}"><i class="fa fa-search"></i> Preview Usulan</a></li>
                                                    @endif
                                                    <li><a id='hapus' href="javascript:void(0)" recidusul="{!!$nominatifdalamskpd->idusul!!}" class='text-danger'><i class='fa fa-times-circle'></i> Hapus</a></li>
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
                            </div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="col-sm-6">
                      </div>
                      <div class="col-sm-6">
                        <?php echo $nominatifdalamskpds->appends(array('idskpd' => Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
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
            claravel_modal('Edit Nominatif Mutasi Dalam OPD','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/emutasi/nominatifdalamskpd/data/editmutasi',
                data: {'idusul': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('a.verifikasimutasi').on('click', function(e){
            e.preventDefault();
            claravel_modal('Verifikasi Nominatif Mutasi Dalam OPD','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/emutasi/nominatifdalamskpd/data/verifikasi',
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
                        url : '{!!url()!!}/emutasi/nominatifdalamskpd/delete',
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

        /*Function Untuk Tambah*/
        $('.attrtambahus').on('click', function(e){
            e.preventDefault();
            $.ajax({
                // url : index_page + '/create/'+$(this).attr('rectglusul')+'/'+
                // $(this).attr('recnousul')+'/'+$(this).attr('recnosuratrek')+'/'+
                // $(this).attr('recsuratdari')+'/'+$(this).attr('rectglsurat')+,
                url : index_page + '/create',
                type : 'get',
                data: {
                    'rectglusul' : $(this).attr('rectglusul'), 
                    'recnousul' : $(this).attr('recnousul'),
                    'recnosuratrek' : $(this).attr('recnosuratrek'), 
                    'recsuratdari' : $(this).attr('recsuratdari'), 
                    'rectglsurat' : $(this).attr('rectglsurat'),
                    'recperihalrek' : $(this).attr('recperihalrek')
                },
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        })
        
        $('a#usdelete').on('click', function(e){
          e.preventDefault();
          var $this =$(this);
          var nousul =  $this.attr('recid');
          bootbox.confirm('Hapus?',function(a){
              if(a == true){
                  $.ajax({
                      url : '{!!url()!!}/emutasi/nominatifdalamskpd/usdelete',
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
                url : '{!!url()!!}/emutasi/nominatifdalamskpd/data/attrpengantar',
                data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('.attrnominatif').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Daftar Nominatif','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/emutasi/nominatifdalamskpd/data/attrnominatif',
                data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })
        $('.attrnominatifbupati').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Daftar Nominatif Checklist Bupati','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/emutasi/nominatifdalamskpd/data/attrnominatifbupati',
                data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })
    });


</script>
