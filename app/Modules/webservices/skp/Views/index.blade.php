<section class="content-header">
    <h1>
        Skp Pegawai <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Skp Pegawai</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="callout callout-success">
          <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
          <ul style="padding-left: 15px">
              <!-- <li>Isiakan tanggal usulan</li> -->
              <li>Pilih Tahun/Skpd/Nip untuk menamplikan data secara spesifik</li>

              <li>Klik tombol ambil data skp untuk mengambil data skp dari bkn</li>
              <li>Klik tombol aksi kemudian klik preview untuk menamplikan data skp yang siap untuk dikirim ke bkn</li>
          </ul>
      </div>
        <div class="box-header with-border row">

            <!-- <div class="col-lg-2 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">

                </div>
            </div> -->
            <div class="col-lg-10 pull-left">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">
                          <?php
                            $tahun = Input::get('tahun')?:date("Y");

                          ?>
                            {!!comboTahun("tahun",Input::get('tahun'),"", "Tahun")!!}
                        </td>
                        <td style="padding: 5px;" width="55%">
                            <!--<select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan Unit Kerja :." style="width: 100%"></select>-->
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

        <div class="btn-group">
            <a href="{{url('/webservices/skp/ambildata')}}"  id="ambil-data" class="btn btn-primary">Ambil Data Skp</a>
        </div>

        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>

                        <th rowspan="2" width="15%">NAMA LENGKAP<br>JABATAN<br>UNIT KERJA</th>
                        <th rowspan="2"  width="10%">NIP <br> NIP LAMA</th>
                        <th rowspan="3" width="10%">NILAI SKP<br>TAHUN</th>
                        <th rowspan="4" width="8%">AKSI</th>
                    </tr>


                    </thead>

                    <tbody>
                    @foreach ($skps as $skp)
                    <tr>

                        <td>
                          {!!$skp->namalengkap!!} <br>
                          <small>{!!strtoupper(($skp->jabatan!='')?$skp->jabatan:'-')." PADA ".(($skp->path_short !='-')?$skp->path_short:'')." <br> ".(($skp->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($skp->tmtjbt)):'')!!}</small>
                        </td>
                        <td>{!!$skp->nip!!} <br> {!!$skp->niplama!!}</td>
                        <td>
                          <center>
                            {{$skp->nilai}}<br>
                            {{$skp->tahun}}
                          </center>
                        </td>


                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                  <li><a id="preview"
                                    href="{{url('webservices/skp/preview')}}"
                                    recid="{{$skp->nip}}" rectahun="{{$skp->tahun}}"class="text-info">
                                    <i class="fa fa-pencil-square-o">
                                    </i>Preview</a>
                                  </li>
                                  
                                </ul>
                            </div>

                        </td>
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

            </div>
            <div class="col-sm-6">
              <?php echo $skps->appends(array('idskpd'=>Input::get('idskpd'), 'idstspeg' => Input::get('idstspeg'), 'search' => Input::get('search')))->render(); ?>
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
        //autoComplete('#tables #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, '{!! \Input::get('idskpd')!!}', '{!! getAttr("a_skpd", "idskpd", \Input::get("idskpd"), "path")!!}', '');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('#ambil-data').on('click',function(e){
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

        $('#tabel').on('click','.print',function(e){
            e.preventDefault();
            claravel_modal('Cetak Biodata','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/print',
                data: {'nip': $(this).attr('recid'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

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
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                preloader.off();
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

        $('#tabel').on('click','#preview',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Preview ?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/preview',
                        type : 'get',
                        data:{ 'nip' : $this.attr('recid'),
                               'tahun' :  $this.attr('rectahun')
                              },
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
