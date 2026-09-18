<style type="text/css">table.tableheader td{padding: 5px;}</style>
<section class="content-header">
    <h1>
        Skcuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Skcuti</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables" class="tableheader">
                    <tr>
                        <td>Jenis Cuti</td>
                        <td width="1%">:</td>
                        <td>{!! comboJenisCuti('id_jenis_cuti',Input::get('id_jenis_cuti')) !!}</td>
                        <td>OPD</td>
                        <td width="1%">:</td>
                        <td>
                            {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                        </td>
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
                        <td colspan="5"></td>
                        <td class="pull-right">
                            <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table">
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
                        @foreach ($skcutis as $no => $skcuti)
                        <?php
                        $n++;
                        $arr[$n] = $skcuti->nousul;
                        if($arr[$n]!=$arr[$n-1]){
                            ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$skcuti->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($skcuti->tgl_usul))?>
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($skcuti->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <!-- <th style="position:relative;" colspan="6">
                                    <div class="text-right">

                                        &nbsp;<a href="javascript::void(0)" target="_blank" class="cetaknominatif" 
                                        recnousul="{!!$skcuti->nousul!!}" ><i class="fa fa-print"> Cetak Semua</i></a> |&nbsp;

                                    </div>
                                </th> -->
                                <th style="position:relative;" colspan="6">
                                    @if(\Session::get('role_id') == 1 || \Session::get('role_id') == 2 || \Session::get('role_id') == 4)
                                    <div class="text-right">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="false">
                                                <span class="fa fa-print"></span> Cetak Surat Keputusan
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="{!!url()!!}/ecuti/skcuti/print/skcutiall/{!!$skcuti->nousul!!}" class="cetak" title="Cetak Semua SP" target="_blank"><i class="fa fa-print"></i> Cetak Semua SK</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</center></td>
                            <td>{!!$skcuti->nip!!}<br>{!!$skcuti->namalengkap!!}</td>
                            <td>{!!$skcuti->golru!!}<br>{!!$skcuti->pangkat!!}</td>
                            <td>{!!$skcuti->jabatan!!}</td>
                            <td style="vertical-align: middle;">{!!getJenisCuti($skcuti->id_jenis_cuti)!!}</td>
                            <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($skcuti->tgl_mulai))!!}</td>
                            <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($skcuti->tgl_selesai))!!}</td>
                            <td class="text-center" style="vertical-align: middle;">{!!$skcuti->lama_cuti!!}</td>

                            <td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($skcuti->opd_status) !!}
                            </td>

                            <td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($skcuti->atasan_status) !!}</td>
                            <td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($skcuti->wewenang_status) !!}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if($skcuti->wewenang_status == 1 && $skcuti->nosk_cuti != "")
                                <a href="{!!url()!!}/ecuti/skcuti/print/skcuti/{!!$skcuti->nousul!!}/{!!$skcuti->nip!!}" target="_blank" title="Cetak SK Cuti"><i class="fa fa-print"></i></a>
                                @elseif($skcuti->wewenang_status == 1 && $skcuti->nosk_cuti == "")
                                <a href="{!!url()!!}/ecuti/skcuti/print/skcuti/{!!$skcuti->nousul!!}/{!!$skcuti->nip!!}" style="color: #f0932b;" target="_blank" title="Cetak SK Cuti Tanpa Nomor SK"><i class="fa fa-print"></i></a>
                                @else
                                <a href="javascript::void(0)" title="SK Cuti Belum Selesai Diproses" style="color: red;"><i class="fa fa-print"></i></a>
                                @endif
                            </td>
                        </tr>
                        @if($skcuti->wewenang_status == 1 && $skcuti->nosk_cuti == "")
                        <tr style="background-color: #fae29f;">
                        <td colspan="9"><span class="glyphicon glyphicon-exclamation-sign" style="color: red;" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<b>Perhatian : </b>Nomor SK Cuti Belum Terisi, Hubungi Admin OPD untuk meminta NOMOR SK CUTI</td>
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
              <?php echo $skcutis->appends(array('search' => Input::get('search')))->render(); ?>
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
    });
</script>
