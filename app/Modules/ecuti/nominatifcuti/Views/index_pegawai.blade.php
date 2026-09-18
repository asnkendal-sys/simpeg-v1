<style type="text/css">table.tableheader td{padding: 5px;}</style>
<section class="content-header">
    <h1>
        Nominatif Cuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatifcuti</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
            {!!csrf_field()!!}
            <table width="100%" id="tables" class="tableheader">
                <tr>
                    <td>Jenis Cuti</td>
                    <td width="1%">:</td>
                    <td>{!! comboJenisCuti('id_jenis_cuti',Input::get('id_jenis_cuti')) !!}</td>
                    <!-- <td>OPD</td>
                    <td width="1%">:</td>
                    <td>
                        {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                    </td> -->
                </tr>
                <tr>
                    <td>Bulan</td>
                    <td width="1%">:</td>
                    <td>{!! comboBulan("bulan",Input::get('bulan'),"",".: Bulan :.") !!}</td>
                    <td>Cari</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>{!! ClaravelHelpers::btnCreate() !!}</td>
                    <td colspan="2"></td>
                    <td class="pull-right">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </td>
                </tr>
            </table>
            {!! Form::close() !!}
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2" width="3%">NO</th>
                            <th style="vertical-align: middle;" rowspan="2"><div class="text-center">NIP<br>NAMA LENGKAP</div></th>
                            <th style="vertical-align: middle;" rowspan="2"><div class="text-center">GOL.<br>PANGKAT</div></th>
                            <th style="vertical-align: middle;" rowspan="2"><div class="text-center">JABATAN</div></th>
                            <th style="vertical-align: middle;" rowspan="2"><div class="text-center">JENIS CUTI</div></th>
                            <th style="vertical-align: middle;" colspan="3"><div class="text-center">TANGGAL</div></th>
                            <th style="vertical-align: middle;" colspan="3"><div class="text-center">STATUS</div></th>
                            <th style="vertical-align: middle;" rowspan="2" width="7%"><div class="text-center">AKSI</div></th>
                        </tr>
                        <tr>
                            <th><div class="text-center">MULAI</div></th>
                            <th><div class="text-center">SELESAI</div></th>
                            <th><div class="text-center">LAMA</div></th>

                            <th><div class="text-center">USULAN</div></th>
                            <th><div class="text-center">ATASAN</div></th>
                            <th><div class="text-center">WEWENANG</div></th>
                        </tr>
                    </thead>   
                    
                    <tbody>
                        <?php
                        $arr[0]= "";
                        $n = 0;
                        ?>
                        @foreach ($nominatifcutis as $no => $nominatifcuti)
                        <?php
                        $n++;
                        $arr[$n] = $nominatifcuti->nousul;
                        if($arr[$n]!=$arr[$n-1]){
                            ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$nominatifcuti->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($nominatifcuti->tgl_usul))?>
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($nominatifcuti->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-right">
                                    </div>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</center></td>
                            <td>{!!$nominatifcuti->nip!!}<br>{!!$nominatifcuti->namalengkap!!}</td>
                            <td>{!!$nominatifcuti->golru!!}<br>{!!$nominatifcuti->pangkat!!}</td>
                            <td style="vertical-align: middle;">{!!$nominatifcuti->jabatan!!}</td>
                            <td style="vertical-align: middle;">{!!getJenisCuti($nominatifcuti->id_jenis_cuti)!!}</td>
                            <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($nominatifcuti->tgl_mulai))!!}</td>
                            <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($nominatifcuti->tgl_selesai))!!}</td>
                            <td style="vertical-align: middle;" class="text-center">{!!$nominatifcuti->lama_cuti!!}</td>
                            <td style="vertical-align: middle;" class="text-center editusulan detailcutiz" recidusul="{!!$nominatifcuti->id!!}" 
                                recnip="{!!$nominatifcuti->nip!!}" 
                                recnousul="{!!$nominatifcuti->nousul!!}">{!! getStatusCuti($nominatifcuti->opd_status) !!}
                            </td>
                            <td style="vertical-align: middle;" class="text-center detailcuti" recidusul="{!!$nominatifcuti->id!!}" 
                                recnip="{!!$nominatifcuti->nip!!}" 
                                recnousul="{!!$nominatifcuti->nousul!!}">{!! getStatusCuti($nominatifcuti->atasan_status) !!}</td>
                                <td style="vertical-align: middle;" class="text-center detailcuti" recidusul="{!!$nominatifcuti->id!!}" 
                                    recnip="{!!$nominatifcuti->nip!!}" 
                                    recnousul="{!!$nominatifcuti->nousul!!}">{!! getStatusCuti($nominatifcuti->wewenang_status) !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                               <span class="caret"></span> Aksi
                                           </button>
                                           <ul class="dropdown-menu pull-right">
                                            <li>
                                                @if($nominatifcuti->atasan_status !=1 || $nominatifcuti->wewenang_status !=1)
                                                <!-- <a href="javascript:void(0)" class="text-info editusulan"
                                                recidusul="{!!$nominatifcuti->id!!}" 
                                                recnip="{!!$nominatifcuti->nip!!}" 
                                                recnousul="{!!$nominatifcuti->nousul!!}">
                                                <i class="fa fa-pencil-square-o"></i>Edit</a> -->
                                                @else
                                                <a href="javascript:void(0)" class="text-info sudahver" style="color: red;">
                                                    <i class="fa fa-pencil-square-o"></i>Edit
                                                </a>
                                                @endif
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="text-info detailcuti"
                                                recidusul="{!!$nominatifcuti->id!!}" 
                                                recnip="{!!$nominatifcuti->nip!!}" 
                                                recnousul="{!!$nominatifcuti->nousul!!}">
                                                <i class="fa fa-search"></i>Preview Detail
                                            </a>
                                        </li>
                                        <li>
                                            @if($nominatifcuti->atasan_status !=1 || $nominatifcuti->wewenang_status !=1)
                                            {!! ClaravelHelpers::btnDelete($nominatifcuti->id) !!}
                                            @else
                                            <a href="javascript:void(0)" class="text-info sudahver" style="color: red;">
                                                <i class="fa fa-times-circle"></i>Hapus
                                            </a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @if($nominatifcuti->opd_alasan != "")
                        <tr style="background-color: #fae29f;">
                            <td colspan="3"><span class="glyphicon glyphicon-exclamation-sign" style="color: red;" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<b>Status Usulan : </b>{!! getStatusUsulan($nominatifcuti->opd_status) !!}</td>
                            <td colspan="9"><b>Catatan OPD :</b> {!! $nominatifcuti->opd_alasan !!}</td>
                        </tr>
                        @endif
                        @if($nominatifcuti->atasan_alasan != "")
                        <tr style="background-color: #fae29f;">
                            <td colspan="3"><span class="glyphicon glyphicon-exclamation-sign" style="color: red;" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Status Usulan : {!! getStatusUsulan($nominatifcuti->atasan_status) !!}</td>
                            <td colspan="9"><b>Catatan Atasan :</b> {!! $nominatifcuti->atasan_alasan !!}</td>
                        </tr>
                        @endif
                        @if($nominatifcuti->wewenang_alasan != "")
                        <tr style="background-color: #fae29f;">
                            <td colspan="3"><span class="glyphicon glyphicon-exclamation-sign" style="color: red;" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Status Usulan : {!! getStatusUsulan($nominatifcuti->wewenang_status) !!}</td>
                            <td colspan="9"><b>Catatan Wewenang :</b> {!! $nominatifcuti->wewenang_alasan !!}</td>
                        </tr>
                        @endif 
                        @endforeach
                    </tbody>
                </table>
                <table border="0" class="table">
                    <tr>
                        <td colspan="11">Keterangan :<br></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <span style="color:green;"><i class="fa fa-check-circle" title="Selesai diproses"/></span> - Disetujui
                        </td>
                        <td>
                            <span style="color:orange;"><i class="fa fa-pencil-square-o" title="Perubahan"/></span> - Perubahan
                        </td>
                        <td>
                            <span style="color:red;"><i class="fa fa-clock-o" title="Ditangguhkan"/></span> - Ditangguhkan
                        </td>
                        <td>
                            <span style="color:red;"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> - Tidak Disetujui
                        </td>
                        <td>
                            <span style="color:orange;"><i class="fa fa-clock-o" title="Sedang diproses"/></span> - Sedang Diproses
                        </td>
                        <td>
                            <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> - Sudah Cetak SK
                        </td>
                        <td>
                            <span style="color:#000000"><i class="fa fa-star" title="SK Dibatalkan"/></span> - SK Dibatalkan
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
          </div>
          <div class="col-sm-6">
              <?php echo $nominatifcutis->appends(array('search' => Input::get('search')))->render(); ?>
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

        $('.detailcuti').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview Usulan Cuti','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/ecuti/nominatifcuti/modal/previewdetail',
                data: {'id': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
        $('.sudahver').on('click', function(e){
            e.preventDefault();
            bootbox.alert("Data Sudah Diverifikasi");
        });
        
        $('.editusulan').on('click', function(e){
            e.preventDefault();
            claravel_modal('Edit Nominatif Usulan Cuti','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/ecuti/nominatifcuti/modal/editusulanopd',
                data: {'id': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
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
                            if(html==9){
                                notification('Berhasil Dihapus','success');
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                                refresh_page();
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
