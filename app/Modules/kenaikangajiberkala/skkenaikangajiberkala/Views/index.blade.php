<section class="content-header">
    <h1>
        SK Kenaikan Gaji Berkala<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">SK Kenaikan Gaji Berkala</li>
    </ol>
</section>
<section class="content">
    <!--<div class="box box-primary">-->
    <div id="rekap" class="tab-pane">
    <p>
        <div class="nav-tabs-custom" style="box-shadow:none;">
        <ul class="nav nav-tabs tab2" id="myTab">
            <li class="active"><a data-toggle="tab" href="{!!url()!!}/kenaikangajiberkala/skkenaikangajiberkala"><i class="fa fa-fw fa-dot-circle-o"></i> DATA KGB</a></li>
            <li><a data-toggle="tab" href="{!!url()!!}/kenaikangajiberkala/skkenaikangajiberkala/rekap"><i class="fa fa-fw fa-dot-circle-o"></i> REKAP KGB</a></li>
        </ul>

        <div class="tab-content">
            <div id="profesikeb" class="tab-pane active">
            <p>

                <div class="box-header with-border">
                    <p>{!! ClaravelHelpers::btnCreate() !!}</p>
                    <div class="col-md-12">
                        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                        {!!csrf_field()!!}
                        <input type="hidden" name="page" id="pageno" value="{!!((Input::get('page') != '')?Input::get('page'):'')!!}">

                        <table class="table">
                            <tr>
                                <td width="10%">TMT SK</td>
                                <td width="2%">:</td>
                                <td width="38%">
			        	<div class='input-group datepicker'>
                                    	{!! Form::text('tglawal', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal Awal')) !!}
                                    	<span class="input-group-addon">
                                        	<span class="glyphicon glyphicon-calendar"></span>
                                    	</span>
                                	</div>
				</td>


                                <td>Status Pegawai</td>
                                <td>:</td>
                                <td>{!!comboStspns("idstspeg",Input::get('idstspeg'),"")!!}</td>
                            </tr>
                            <tr>
                                <td>s.d</td>
                                <td>:</td>
                                <td>
					<div class='input-group datepicker'>
                                    	{!! Form::text('tglakhir', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal Akhir')) !!}
                                    	<span class="input-group-addon">
                                        	<span class="glyphicon glyphicon-calendar"></span>
                                    	</span>
                                	</div>

				</td>

                                <td width="10%">Unit Kerja</td>
                                <td width="2%">:</td>
                                <td width="38%">
                                    {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                                </td>
                            </tr>
                            <tr>
                                <td>Proses</td>
                                <td>:</td>
                                <td>{!! PenetapannominatifModel::comboJeniskgb("jnskgb",Input::get('jnskgb'),"",".: Proses :.") !!}</td>

                                <td>Status SK</td>
                                <td>:</td>
                                <td>{!! PenetapannominatifModel::comboStatussk("statussk",Input::get('statussk'),"",".: Status Proses :.")!!}</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
				    <button class="btn btn-success" formtarget="_blank" id="excel"><i class="fa fa-file-excel-o"></i> Download Excel</button>
                                </td>

                                <td>Pencarian</td>
                                <td>:</td>
                                <td>
				    <input type="text" class="form-control" name="search" id="search" value="{!! \Input::get('search')!!}"></td>
 				</td>

                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
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
                                <th rowspan="2"><div class="text-center">No</div></th>
                                <th rowspan="2">
                                    <div class="text-center">NAMA</div>
                                    <div class="text-center">TEMPAT,&nbsp;TGL&nbsp;LAHIR</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">NIP</div>
                                    <div class="text-center">KARPEG</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">JABATAN </div>
                                    <div class="text-center">UNIT KERJA</div>
                                    <div class="text-center">TMT</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">PKT&nbsp;GOL.&nbsp;CPNS</div>
                                    <div class="text-center">TMT</div>
                                    <div class="text-center">MASA KERJA</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">PKT&nbsp;GOL.&nbsp;PNS</div>
                                    <div class="text-center">TMT</div>
                                    <div class="text-center">MASA KERJA</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">PKT&nbsp;GOL.&nbsp;SEKARANG</div>
                                    <div class="text-center">TMT</div>
                                    <div class="text-center">MASA KERJA</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">KGB&nbsp;TERKAHIR</div>
                                    <div class="text-center">TMT</div>
                                    <div class="text-center">MASA KERJA</div>
                                    <div class="text-center">GAJI</div>
                                </th>
                                <th rowspan="2">
                                    <div class="text-center">KGB&nbsp;BARU</div>
                                    <div class="text-center">TMT</div>
                                    <div class="text-center">MASA&nbsp;KERJA</div>
                                    <div class="text-center">GAJI</div>
                                </th>
                                <th rowspan="2"><div align="center">PROSES</div></th>
                                <th colspan="2"><div align="center">STATUS</div></th>
                                <th rowspan="2" width="7%">Act.</th>
                            </tr>
                            <tr>
                                <th><div align="center">USUL</div></th>
                                <th><div align="center">SK</div> </th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                                $arr[0]= ""; $n = 0;
                                $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                            ?>
                            @foreach ($skkenaikangajiberkalas as $skkenaikangajiberkala)
                            <?php
                                $x++;
                                $n++;
                                $arr[$n] = substr($skkenaikangajiberkala->idkgb,0,9);
                                    if($arr[$n]!=$arr[$n-1]){
                            ?>
                                <tr>
                                    <th style="position:relative;" colspan="6" align="left">
                                        TMT KGB <i class="icon-calendar"></i> <?php echo date("d-m-Y", strtotime($skkenaikangajiberkala->tmtkgbb))?> -
                                        <?php
                                            if(Input::get('idskpd') != ''){
                                                echo getSkpd(Input::get('idskpd'));
                                            }else{
                                                if(session('role_id') == 4){
                                                    if(strlen(session('idskpd')) == 2){
                                                        echo getSkpd(substr($skkenaikangajiberkala->kdskpd,0,2));
                                                    }else{
                                                        echo getSkpd(substr($skkenaikangajiberkala->kdskpd,0,5));
                                                    }
                                                }else{
                                                    echo getSkpd(substr($skkenaikangajiberkala->kdskpd,0,2));
                                                }
                                            }
                                        ?>
                                    </th>
                                    <th style="position:relative;" colspan="6" align="right">
                                        <div class="text-right">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="fa fa-list"></span> Nominatif
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a href="{!!url()!!}/kenaikangajiberkala/penetapannominatif/cetaknominatif/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($skkenaikangajiberkala->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($skkenaikangajiberkala->kdskpd,0,2))!!}/{!!$skkenaikangajiberkala->idstspeg!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Nominatif" target="_blank"><i class="fa fa-print"/></i> Data Nominatif</a></li>
                                                    <li><a href="{!!url()!!}/kenaikangajiberkala/penetapannominatif/cetakditerima/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($skkenaikangajiberkala->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($skkenaikangajiberkala->kdskpd,0,2))!!}/{!!$skkenaikangajiberkala->idstspeg!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Tanda Terima" target="_blank"><i class="fa fa-print"/></i> Tanda Terima</a></li>
                                                </ul>
                                            </div>
                                            &nbsp;<a href="{!!url()!!}/kenaikangajiberkala/penetapannominatif/cetakskkolektif/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($skkenaikangajiberkala->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($skkenaikangajiberkala->kdskpd,0,2))!!}/{!!$skkenaikangajiberkala->idstspeg!!}" class="attrpengantar btn btn-success" act="pengantar" title="Cetak SK Kolektif" target="_blank"><i class="fa fa-file"/></i> SK Kolektif</a>
                                        </div>
                                    </th>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>{!!$x!!}</td>
                                <td>
                                    <div class="text-left">{!! $skkenaikangajiberkala->nama !!}</div>
                                    <small><div class="text-left">{!! $skkenaikangajiberkala->tmplahir !!}, {!! tglina($skkenaikangajiberkala->tgllahir) !!}</div></small>
                                    <div class="text-right" style="position:relative">
                                        <?php
                                        if($skkenaikangajiberkala->iscetaksk == 1){
                                            echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }else if($skkenaikangajiberkala->iscetaksk == 2){
                                            echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">{!! $skkenaikangajiberkala->nip !!}</div>
                                    <div class="text-center">{!! $skkenaikangajiberkala->karpeg !!}</div>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! ucword($skkenaikangajiberkala->nmajab) !!} {!! $skkenaikangajiberkala->tmpskpdskr !!}</div>
                                        <div class="text-left">TMT : {!! tglina($skkenaikangajiberkala->tmtjbt) !!}</div>
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! $skkenaikangajiberkala->golrucpn." - ".ucword($skkenaikangajiberkala->pangkatcpn) !!}</div>
                                        <div class="text-left">{!! tglina($skkenaikangajiberkala->tmtcpn) !!}</div>
                                        <div class="text-left">{!! $skkenaikangajiberkala->mkthncpn." Tahun ".$skkenaikangajiberkala->mkblncpn." Bulan" !!}</div>
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! $skkenaikangajiberkala->golrupns." - ".ucword($skkenaikangajiberkala->pangkatpns) !!}</div>
                                        <div class="text-left">{!! tglina($skkenaikangajiberkala->tmtpns) !!}</div>
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! $skkenaikangajiberkala->golru." - ".ucword($skkenaikangajiberkala->pangkat) !!}</div>
                                        <div class="text-left">{!! tglina($skkenaikangajiberkala->tmtgollama) !!}</div>
                                        <div class="text-left">{!! $skkenaikangajiberkala->mkthn." Tahun ".$skkenaikangajiberkala->mkbln." Bulan" !!}</div>
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! $skkenaikangajiberkala->golru !!} {!! ($skkenaikangajiberkala->noskkgbl=='')?'&nbsp;':$skkenaikangajiberkala->noskkgbl !!}</div>
                                        <div class="text-left">{!! tglina($skkenaikangajiberkala->tmtkgbl) !!}</div>
                                        <div class="text-left">{!! $skkenaikangajiberkala->mktkgbl." Tahun ".$skkenaikangajiberkala->mkbkgbl." Bulan" !!}</div>
                                        <div class="text-left">Rp. {!! number_format($skkenaikangajiberkala->gkgbl) !!}</div>
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <div class="text-left">{!! $skkenaikangajiberkala->noskkgbb !!}</div>
                                        <div class="text-left">{!! tglina($skkenaikangajiberkala->tmtkgbb) !!}</div>
                                        <div class="text-left">{!! $skkenaikangajiberkala->mktkgbb." Tahun ".$skkenaikangajiberkala->mkbkgbb." Bulan" !!}</div>
                                        <div class="text-left">Rp. {!! number_format($skkenaikangajiberkala->gkgbb) !!}</div>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <?php
                                        switch($skkenaikangajiberkala->jnskgb){
                                            case 1 : echo "OPD"; break;
                                            case 2 : echo "BKPP"; break;
                                            default: echo ""; break;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($skkenaikangajiberkala->statususul==1){
                                        echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                    }else if($skkenaikangajiberkala->statususul==2){
                                        echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                    }else if($skkenaikangajiberkala->statususul==3){
                                        echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($skkenaikangajiberkala->statususul=='1' && $skkenaikangajiberkala->statussk=='2'){
                                        echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                    }else if($skkenaikangajiberkala->statussk=='1'){
                                        echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                    }else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="caret"></span> Aksi
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if($skkenaikangajiberkala->statussk=='1')
                                            <li><a id="cetaksk" href="{!!url()!!}/kenaikangajiberkala/penetapannominatif/cetaksk/{!!$skkenaikangajiberkala->jnskgb.'/'.$skkenaikangajiberkala->nip.'/'.$skkenaikangajiberkala->idkgb!!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak SK</a></li>
                                            @else
                                            <li><a id="cetaksk" href="javascript:void(0)" title="Status SK belum selesai di proses" class="text-info" style="color: red"><i class="fa fa-print"></i> Cetak SK</a></li>
                                            @endif
                                            <li>{!! ClaravelHelpers::btnEdit($skkenaikangajiberkala->nip) !!}</li>
                                            <li>{!! ClaravelHelpers::btnDelete($skkenaikangajiberkala->nip) !!}</li>
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
                      <?php echo $skkenaikangajiberkalas->appends(array('bulan' => Input::get('bulan'), 'tahun' => Input::get('tahun'), 'jnskgb' => Input::get('jnskgb'), 'idskpd' => Input::get('idskpd'), 'statussk' => Input::get('statussk'), 'search' => Input::get('search')))->render(); ?>
                    </div>
                  </div>
                </div>
                {!! Form::close() !!}
            </p>
            </div>
            <!-- /.tab-pane -->
        </div>
    </div>
    </p>
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
            data : $('#cari').serialize(),
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }
    //$('#excel').formtarget = "_blank";
    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

	$(".date").mask("99-99-9999");
        $(".datepicker").datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('ul#myTab').on('click','a',function(e){
            $.ajax({
                type: 'get',
                url : $(this).attr('href'),
                beforeSend: function(){
                    preloader.on();
                },
                success: function(data) {
                    preloader.off();
                    $('#utama').html(data);
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

    $('#excel').on('click', function(e){
	e.preventDefault();
        var $this = $(this); 
	window.location = '{!!url()!!}/kenaikangajiberkala/skkenaikangajiberkala/excel';
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