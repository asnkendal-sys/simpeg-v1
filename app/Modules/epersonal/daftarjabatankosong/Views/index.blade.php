<section class="content-header">
    <h1>
        Daftar Jabatan Kosong<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Daftar Jabatan Kosong</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-lg-3 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!}
                    &nbsp;
                    
                </div>
            </div>
            <div class="box-tools pull-right col-lg-9 pull-right">

                @if(session('role_id') <= 3)

                    <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">&nbsp;</td>
                        <td style="padding: 5px;" width="35%">&nbsp;</td>
                       
                        <td style="padding: 5px;" width="55%">
                         {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari', 'target'=>'_blank')) !!}
                        {!!csrf_field()!!}
                            <div class="input-group">
                                <!--<input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">-->
                                <!--<select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan Unit Kerja :." style="width: 100%"></select>-->
                                {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>

                                </span>
                            </div>
                                  {!! Form::close() !!}
                        </td>
                      
                        <td>
                            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'formExcel', 'target'=>'_blank')) !!}
 <input type="hidden" name="idskpd" id="inputIdskpd">                            
<button type="submit" class="btn btn-success" id="excel-djk">
                                <i class="fa fa-file-excel-o"></i> Download Excel
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    </table>
                    @endif



            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th><div class="text-center">NO</div></th>
                        <th>
                            <div class="text-left">OPD</div>
                        </th>
                        <th width='37%'>
                            <div class="text-left">JABATAN</div>
                        </th>
                        <th>
                            <div class="text-center">ESELON</div>
                        </th>
                        <th>
                            <div class="text-center">GOL. MINIMAL</div>
                        </th>
                        <th>
                            <div class="text-center">GOL. MAX</div>
                        </th>
                        <th>
                            <div class="text-center">PEJABAT SEMENTARA</div>
                            <div class="text-center">NIP / TMT</div>
                        </th>
                        <th align="center">AKSI</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $x=0; ?>
                    @foreach ($daftarjabatankosongs as $daftarjabatankosong)
                        @if($daftarjabatankosong->flag == 1)
                        <?php $x++; ?>
                        <tr>
                            <td align="center">{!!$x!!}</td>
                            <td>{!!$daftarjabatankosong->path_short!!}</td>
                            <td>{!!$daftarjabatankosong->jab!!}</td>
                            <td>{!!$daftarjabatankosong->esl!!}</td>
                            <td>{!!$daftarjabatankosong->golrumin!!}</td>
                            <td>{!!$daftarjabatankosong->golrumax!!}</td>
                            <td>
                                @if($daftarjabatankosong->plt_nip != '')
                                    {!!$daftarjabatankosong->namalengkap!!}<br>
                                    {!!$daftarjabatankosong->plt_nip!!}<br>
                                    TMT : {!!date('d-m-Y', strtotime($daftarjabatankosong->plt_tmt))!!}<br>
                                @else
                                    <div align="center">-</div>
                                @endif
                            </td>
                            <td align="center">
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a class="text-primary isiplt" recid="{!!$daftarjabatankosong->idskpd!!}" plt="{!!$daftarjabatankosong->plt_nip!!}" href="javascript:void(0)"><i class="fa fa-gavel"></i> {!!($daftarjabatankosong->plt_nip!='')?'Edit':''!!} Penetapan PLT</a></li>
                                        <li><a class="text-primary batalkanplt" recid="{!!$daftarjabatankosong->idskpd!!}" href="javascript:void(0)"><i class="fa fa-times-circle"></i> Batalkan PLT</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endif
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
              <?php /*echo $daftarjabatankosongs->appends(array('search' => Input::get('search')))->render(); */?>
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

        $('#tabel').on('click','.isiplt',function(e){
            e.preventDefault();
            claravel_modal('Penetapan Pejabat Pelaksana Tugas','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/daftarjabatankosong/data/formplt',
            // url : '{!!url()!!}/epersonal/daftarjabatankosong/data/jabatankosong',
                data: {'idskpd': $(this).attr('recid'), 'plt': $(this).attr('plt'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('#tabel').on('click','.batalkanplt',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Batalkan / Sudahi penetapan PLT ?',function(a){
                if(a == true){
                    $.ajax({
                        url : '{!!url()!!}/epersonal/daftarjabatankosong/batalkan',
                        type : 'post',
                        data: {'idskpd' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('PLT Berhasil Dibatalkan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
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
                            preloader.off();
                            if(html==9){
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
                data: $(this).serialize(),
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

        $('#excel-daftarjabatankosong').on('click',function(e){
	    $('#excel-daftarjabatankosong').attr('formtarget','_blank');
            e.preventDefault();
                    $.ajax({
			url : '/epersonal/daftarjabatankosong/excel/jabatankosong',
			formtarget : '_blank',
                        type : 'post',
                        data:{'_token' : '{!!csrf_token()!!}'},
                        success:function(html){
                            $('#main_modal .modal-body').html(html);                        
			}
                    });   
        });

$('#excel-djk').on('click', function(e) {
            e.preventDefault();

            $('#formExcel').attr("action", "{!!url()!!}/epersonal/daftarjabatankosong/excel/jabatankosong");
  $('#inputIdskpd').val(document.getElementById('idskpd').value);
            $('#formExcel').submit();

        });
      
    });
</script>
