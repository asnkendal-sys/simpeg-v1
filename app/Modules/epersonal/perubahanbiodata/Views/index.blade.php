<section class="content-header">
    <h1>
        Perubahan Biodata <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Perubahan Biodata</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-lg-3 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!}&nbsp;
                </div>
            </div>
            <div class="box-tools pull-right col-lg-9 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">&nbsp;</td>
                            @if(session('role_id') <= 3)
                        <td style="padding: 5px;" width="30%">
                                {!!combo_status("status",Input::get('status'),"",session('status'))!!}
                        </td>
                        <td style="padding: 5px;" width="40%">
                                <!--<select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan Unit Kerja :." style="width: 100%"></select>-->
                                {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                            @endif
                        </td>
                        <td style="padding: 5px;" width="30%">
                            @if(session('role_id') != 5)
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                            @endif
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
                        <th rowspan="2" width="2%">NO</th>
                        <th rowspan="2" width="15%">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                        <th rowspan="2">NIP <br> NIP LAMA</th>
                        <th rowspan="2">GOL. <br> TMT</th>
                        <th rowspan="2">ESL</th>
                        <th rowspan="3" width="20%">JABATAN <br> UUNIT KERJA <br> TMT</th>
                        <th colspan="2">MASA KERJA</th>
                        <th colspan="2">S/D SEKARANG</th>
                        <th rowspan="2" width="18%">KETERANGAN</th>
                        <th rowspan="4" width="8%">AKSI</th>
                    </tr>
                    <tr>
                        <th>THN</th>
                        <th>BLN</th>
                        <th>THN</th>
                        <th>BLN</th>
                    </tr>

                    </thead>

                    <tbody>
                    <?php $x = 0;?>
                    @foreach ($perubahanbiodatas as $perubahanbiodata)
                    <?php $x++;?>
                    <tr>
                        <td align="center">{!!$x!!}</td>
                        <td>{!!$perubahanbiodata->namalengkap!!} <br> <small>{!!$perubahanbiodata->tmlhr.", ".(($perubahanbiodata->tglhr != '0000-00-00')?date('d-m-Y', strtotime($perubahanbiodata->tglhr)):'')!!}</small></td>
                        <td>{!!$perubahanbiodata->nip!!} <br> {!!$perubahanbiodata->niplama!!}</td>
                        <td>{!!$perubahanbiodata->golru!!} <br> {!!(($perubahanbiodata->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($perubahanbiodata->tmtpkt)):'')!!}</td>
                        <td align="center">{!!($perubahanbiodata->esl!='')?$perubahanbiodata->esl:'-'!!}</td>
                        <td><small>{!!strtoupper(($perubahanbiodata->jabatan!='')?$perubahanbiodata->jabatan:'-')." PADA ".(($perubahanbiodata->path !='-')?$perubahanbiodata->path:'')." <br> ".(($perubahanbiodata->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($perubahanbiodata->tmtjbt)):'')!!}</small></td>
                        <td align="right">{!!$perubahanbiodata->mkthnpkt!!}</td>
                        <td align="right">{!!$perubahanbiodata->mkblnpkt!!}</td>
                        <td align="right">{!!substr($perubahanbiodata->mkskr,0,-2)!!}</td>
                        <td align="right">{!!substr($perubahanbiodata->mkskr,-2)!!}</td>
                        <td align="left" class="{!!($perubahanbiodata->status == 2)?'alert-danger':''!!}">
                            <?php
                                if($perubahanbiodata->status == 1){
                                    echo "<i class='fa fa-check-circle-o'></i>";
                                }else if($perubahanbiodata->status == 2){
                                    echo "<i class='fa fa-times-circle-o'></i>";
                                }else{
                                    echo "-";
                                }
                            ?>

                            <?php
                                if($perubahanbiodata->status == 1){
                                    echo ($perubahanbiodata->ketditolak!='')?$perubahanbiodata->ketditolak:'-';
                                }else if($perubahanbiodata->status == 2){
                                    echo ($perubahanbiodata->ketditolak!='')?$perubahanbiodata->ketditolak:'-';
                                }else{
                                    echo 'Belum ada tanggapan.';
                                }
                            ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a class="text-primary prevbiodata" recrole="{!! session('role_id') !!}" recid="{{$perubahanbiodata->nip}}" href="javascript:void(0)"><i class="{!!(session('role_id') <= 3)?'fa fa-check':'fa fa-search'!!}"></i> {!!(session('role_id') <= 3)?'Verifikasi':'Preview'!!}</a></li>
                                    <li><a class="text-primary btlbiodata" recid="{{$perubahanbiodata->nip}}" href="javascript:void(0)"><i class='fa fa-times-circle-o'></i> Batalkan</a></li>
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
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $perubahanbiodatas->appends(array('status' => Input::get('status'), 'idskpd'=>Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
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

        /*function batalkan perubahan biodata*/
        $('.btlbiodata').on('click', function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Batalkan perubahan data ?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/btlbiodata',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dibatalkan','success');
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

        /*function preview biodata*/
        $('.prevbiodata').on('click', function(e){
            e.preventDefault(e);
            var roleid = $(this).attr('recrole');
            if(roleid < 3){
               var modal = 'main_modal3';
               var tujuan = 'perubahan_biodata_all';
               var judul = 'Perubahan Data';
            }else{
               var modal = 'main_modal2';
               var tujuan = 'perubahan_biodata';
               var judul = 'Perubahan Biodata';
            }
            claravel_modal(judul,'Loading...',modal);
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/'+tujuan+'/biodata',
                data: {'nip': $(this).attr('recid'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#'+modal+' .modal-body').html(html);
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
