<section class="content-header">
    <h1>
        Data Usulan Kenaikan Pangkat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Data Usulan Kenaikan Pangkat</li>
    </ol>
</section>
<section class="content">
    <!-- <div class="box box-primary"> -->
        <!-- // -->
    <div class="tab-pane">
    <p>
    <div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs tab2" id="myTab">
        <li class="active"><a data-toggle="tab" href="{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat"><i class="fa fa-fw fa-dot-circle-o"></i> DATA KENAIKAN PANGKAT</a></li>
        <li><a data-toggle="tab" href="{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/rekap"><i class="fa fa-fw fa-dot-circle-o"></i> REKAP KENAIKAN PANGKAT</a></li>
    </ul>

    <div class="tab-content">
    <div class="tab-pane active">
    <p>
    <!-- // -->
        <div class="box-header with-border">
            <p>{!! ClaravelHelpers::btnCreate() !!}</p>
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'rekap-kenaikan', 'target'=>'_blank' )) !!}
                {!!csrf_field()!!}
                <table class="table">
                    <tr>
                        <td width="10%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="38%">{!! comboBulan("bulan",Input::get('bulan'),"",".: Bulan :.") !!}</td>

                        <td width="10%">Unit Kerja</td>
                        <td width="2%">:</td>
                        <td width="38%">
                            {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun</td>
                        <td>:</td>
                        <td>{!! comboTahun("tahun",Input::get('tahun'),"",".: Tahun :.") !!}</td>

                        <td>Status SK</td>
                        <td>:</td>
                        <td>{!! PenetapannominatifkpModel::comboStatussk("statussk",Input::get('statussk'),"",".: Status Proses :.")!!}</td>
                    </tr>
                    <tr>
                        <td>Jenis KP</td>
                        <td>:</td>
                        <td>{!! PenetapannominatifkpModel::comboJenisKpNominatif("idjeniskp",Input::get('idjeniskp'),"",".: Jenis KP :.") !!}</td>

                        <td>Pencarian</td>
                        <td>:</td>
                        <td><input type="text" class="form-control" name="search" id="search" value="{!! \Input::get('search')!!}"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <button class="btn btn-primary" type="button" id="pencarian"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-success" type="button" id="excel-rekap"><i class="fa fa-file-excel-o"></i> Download Excel</button>
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
                        <th><div class="text-center">No.</div></th>
                        <th>
                            <div class="text-center">NAMA</div>
                            <div class="text-center">TEMPAT, TGL LAHIR</div>
                        </th>
                        <th>
                            <div class="text-center">NIP</div>
                            <div class="text-center">KARPEG</div>
                        </th>
                        <th width="17%">
                            <div class="text-center">JABATAN </div>
                            <div class="text-center">UNIT KERJA</div>
                            <div class="text-center">TMT</div>
                        </th>
                        <th>
                            <div class="text-center">PANGKAT / GOL. PNS</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA PNS</div>
                        </th>
                        <th>
                            <div class="text-center">KENAIKAN SEKARANG</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA GOLONGAN</div>
                        </th>
                        <th>
                            <div class="text-center">JENIS KP</div>
                        </th>
                        <th>
                            <div class="text-center">STATUS <br> USULAN</div>
                        </th>

                        <th width="7%">AKSI</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($rekapusulankenaikanpangkats as $rekapusulankenaikanpangkat)
                    <?php
                        $x++;
                        $n++;
                        if($rekapusulankenaikanpangkat->issek==2){
                            $sekolah = "SD";
                        }elseif($rekapusulankenaikanpangkat->issek==3){
                            $sekolah = "SMP";
                        }else{
                            $sekolah = "";
                        }
    
                        if(substr($rekapusulankenaikanpangkat->idskpd,0,2)==04){
                            $arr[$n] = $rekapusulankenaikanpangkat->nousul."-".substr($rekapusulankenaikanpangkat->idskpd,0,2)."-".$sekolah."-".$rekapusulankenaikanpangkat->tmt;
                        }else{
                            $arr[$n] = $rekapusulankenaikanpangkat->nousul."-".substr($rekapusulankenaikanpangkat->idskpd,0,2)."-".$rekapusulankenaikanpangkat->tmt;
                        }
        
                        if($arr[$n]!=$arr[$n-1]){
                    ?>
                        <tr>
                            <th style="position:relative;" colspan="6">
                                <div class="text-left">
                                    NOMOR USULAN : {{$rekapusulankenaikanpangkat->nousul}}&nbsp;
                                    <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($rekapusulankenaikanpangkat->tmt))?>
                                    &nbsp;
                                    <?php echo "||&nbsp;".getskpdgroup(substr($rekapusulankenaikanpangkat->idskpd, 0,2)); ?>&nbsp;
                                    <?php 
                                    if(substr($rekapusulankenaikanpangkat->idskpd,0,2)==04){
                                        echo "|| &nbsp;".$sekolah;
                                    }
                                    ?>
                                    <br>
                                </div>
                            </th>
                            {{-- <th style="position:relative;" colspan="2">
                                <div class="text-right">
                                    &nbsp;<b><a href="#" class="attrpengantar" recnousul="{!!$rekapusulankenaikanpangkat->nousul!!}" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-file"> Pengantar</i></a></b>
                                    &nbsp;<b><a href="{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/cetak/nominatif/{!!$rekapusulankenaikanpangkat->nousul!!}/{!!$rekapusulankenaikanpangkat->tglusul!!}" target="_blank" recnousul="{!!$rekapusulankenaikanpangkat->nousul!!}" title="Cetak Daftar Nominatif"><i class="fa fa-list"> Nominatif</i></a></b>
                                </div>
                            </th> --}}
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-center">{!!$x!!}</td>
                        <td>
                            <div class="text-left">{!!$rekapusulankenaikanpangkat->namalengkap!!}</div>
                            <small><div class="text-left">{!!$rekapusulankenaikanpangkat->tmlhr!!}, {!!($rekapusulankenaikanpangkat->tglhr!='0000-00-00')?date('d-m-Y', strtotime($rekapusulankenaikanpangkat->tglhr)):''!!}</div></small>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!fnip($rekapusulankenaikanpangkat->nip)!!}</div>
                            <div class="text-center">{!!$rekapusulankenaikanpangkat->nokarpeg!!}</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!!$rekapusulankenaikanpangkat->jabatan!!}</div>
                                <div class="text-left"><i>Pada</i></div>
                                <div class="text-left">{!!$rekapusulankenaikanpangkat->path_short!!}</div>
                                <div class="text-left">TMT : {!!($rekapusulankenaikanpangkat->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($rekapusulankenaikanpangkat->tmtjbt)):''!!}</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!$rekapusulankenaikanpangkat->golru!!}</div>
                            <div class="text-center">{!!($rekapusulankenaikanpangkat->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($rekapusulankenaikanpangkat->tmtpkt)):''!!}</div>
                            <div class="text-center">{!!$rekapusulankenaikanpangkat->mktkp!!} tahun {!!$rekapusulankenaikanpangkat->mkbkp!!} bulan</div>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!$rekapusulankenaikanpangkat->golrubaru!!}</div>
                            <div class="text-center">{!!($rekapusulankenaikanpangkat->tmt!='0000-00-00')?date('d-m-Y', strtotime($rekapusulankenaikanpangkat->tmt)):''!!}</div>
                            <div class="text-center">{!!$rekapusulankenaikanpangkat->mktkpb!!} tahun {!!$rekapusulankenaikanpangkat->mkbkpb!!} bulan</div>
                        </td>
                        <td>{!!$rekapusulankenaikanpangkat->jenis_kp!!}</td>
                        <td class="text-center">
                            <?php
                                if($rekapusulankenaikanpangkat->statususul=='1' && $rekapusulankenaikanpangkat->statussk=='2'){
                                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                }else if($rekapusulankenaikanpangkat->statussk=='1'){
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
                                    @if($rekapusulankenaikanpangkat->statussk=='1')
                                    <li><a id="cetaksk" href="{!!url().'/kenaikanpangkat/rekapusulankenaikanpangkat/cetak/skpetikan/'.$rekapusulankenaikanpangkat->nip.'/'.$rekapusulankenaikanpangkat->nousul!!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak SK</a></li>
                                    @else
                                    <li><a id="cetaksk" href="javascript:void(0)" title="Status SK belum selesai di proses" class="text-info" style="color: red"><i class="fa fa-print"></i> Cetak SK</a></li>
                                    @endif
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
                    {!! $rekapusulankenaikanpangkats->appends(array('bulan' => Input::get('bulan'), 'tahun' => Input::get('tahun'), 'idjeniskp' => Input::get('idjeniskp'), 'idskpd' => Input::get('idskpd'), 'statussk' => Input::get('statussk'), 'search' => Input::get('search')))->render(); !!}
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

        //
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
        //

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
        // $('#cari').on('submit',function(e){
        //     e.preventDefault();
        //     $.ajax({
        //         url : $(this).attr('action'),
        //         data:$(this).serialize(),
        //         type : 'get',
        //         beforeSend: function(){
        //             preloader.on();
        //         },
        //         success:function(html){
        //             preloader.off();
        //             $('#utama').html(html);
        //         }
        //     });
        // });
        $('#pencarian').on('click', function(e){
            e.preventDefault();         
            $.ajax({
                url : '{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat',
                data:$('#rekap-kenaikan').serialize(),
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

        $('.attrpengantar').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Dokumen Pengantar','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/data/attrpengantar',
                data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('#excel-rekap').on('click', function(e){
            e.preventDefault();
            $('#rekap-kenaikan').attr("action", "{!!url()!!}/kenaikanpangkat/rekapusulankenaikanpangkat/excel/rekap");
            $('#rekap-kenaikan').submit();
        });
    });
</script>
