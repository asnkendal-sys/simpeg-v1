<section class="content-header">
    <h1>
        Penetapan Nominatif KP<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Penetapan Nominatif KP</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <?php 
            $rs = \DB::table('tr_kenaikan_pangkat_jadwal')->whereRaw("NOW() BETWEEN mulai AND selesai")->get();
            // dd($rs); die();
            if(\Session::get('role_id')==1){
                echo ClaravelHelpers::btnCreate();
            }else{
                if(count($rs)>0){
                    if( (date("Y-m-d H:i:s") >= $rs[0]->mulai) &&  (date("Y-m-d H:i:s") <= $rs[0]->selesai) ){
                        echo ClaravelHelpers::btnCreate();
                    }else{
                        $mulai_date = date('d-m-Y  H:i:s', strtotime($rs[0]->mulai)); 
                        $selesai_date = date('d-m-Y  H:i:s', strtotime($rs[0]->selesai));
                        echo "
                        <div class='callout callout-success'>
                            <h4><i class='fa fa-info-circle'></i> PERHATIAN</h4>
                            <b>Pengusulan KP hanya dapat dilakukan pada ".$mulai_date." sampai ".$selesai_date."</b>
                        </div>
                        ";
                    }
                }else{
                    echo "
                        <div class='callout callout-success'>
                            <h4><i class='fa fa-info-circle'></i> PERHATIAN</h4>
                            <b>Pengusulan KP belum dibuka</b>
                        </div>
                        ";
                }
            }
            ?>
            <!-- <p>{!! ClaravelHelpers::btnCreate() !!}</p> -->
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table class="table">
                    <tr>
                        <td width="10%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="38%">{!! PenetapannominatifkpModel::comboKp("bulan","","") !!}</td>

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

                        <td>Status Berkas</td>
                        <td>:</td>
                        <td>{!! PenetapannominatifkpModel::comboStatusBerkas("statususul",Input::get('statususul'),"",".: Status Berkas :.")!!}</td>
                    </tr>
                    <tr>
                        <td>Pencarian</td>
                        <td>:</td>
                        <td><input type="text" class="form-control" name="search" id="search" value="{!! \Input::get('search')!!}"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                        <?php 
                        $idskpd = session('idskpd'); 
                        $role_id = session('role_id'); ?>
                        @if($idskpd != 04 and $role_id == 4)
                        <div class="text-right">
                            <a href="#" class="allpengantar"><button class="btn btn-warning"> Pengantar</button></a>
                            <a href="#" class="allnominatif"><button class="btn btn-success"> Nominatif</button></a>
                        </div>
                        @endif
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
                    @foreach ($penetapannominatifkps as $penetapannominatifkp)
                    <?php
                    $x++;
                    $n++;
                    if($penetapannominatifkp->issek==2){
                        $sekolah = "SD";
                    }elseif($penetapannominatifkp->issek==3){
                        $sekolah = "SMP";
                    }else{
                        $sekolah = "";
                    }

                    if(substr($penetapannominatifkp->idskpd,0,2)==04){
                        $arr[$n] = $penetapannominatifkp->nousul."-".substr($penetapannominatifkp->idskpd,0,2)."-".$sekolah."-".$penetapannominatifkp->tmt;
                    }else{
                        $arr[$n] = $penetapannominatifkp->nousul."-".substr($penetapannominatifkp->idskpd,0,2)."-".$penetapannominatifkp->tmt;
                    }
    
                    if($arr[$n]!=$arr[$n-1]){
                    ?>
                        <tr>
                            <th style="position:relative;" colspan="5">
                                <div class="text-left">
                                    NOMOR USULAN : {{$penetapannominatifkp->nousul}}&nbsp;
                                    <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($penetapannominatifkp->tmt))?>
                                    &nbsp;
                                    <?php echo "||&nbsp;".getskpdgroup(substr($penetapannominatifkp->idskpd, 0,2)); ?>&nbsp;
                                    &nbsp;
                                    <?php 
                                    if(substr($penetapannominatifkp->idskpd,0,2)==04){
                                        echo "|| &nbsp;".$sekolah;
                                    }
                                    ?>
                                    <br>
                                </div>
                            </th>
                            <th style="position:relative;" colspan="3">
                                <div class="text-right">
                                    &nbsp;<b><a href="#" class="attrpengantar" recnousul="{!!$penetapannominatifkp->nousul!!}" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-file"> Pengantar</i></a></b>
                                    &nbsp;<b><a class="attrnominatif" 
                                        recnousul="{!!$penetapannominatifkp->nousul!!}" 
                                        rectglusul="{!!$penetapannominatifkp->tglusul!!}"
                                        href="#" title="Cetak Daftar Nominatif"><i class="fa fa-list"> Nominatif</i></a></b>
                                    @if(Session::get('role_id') <= 3)
                                    &nbsp;<b><a href="javascript:void(0)" class="verif_semua" recnousul="{!!$penetapannominatifkp->nousul!!}"><i class="fa fa-check"> Verifikasi</i></a></b>
                                    @endif
                                </div>
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-center">{!!$x!!}</td>
                        <td>
                            <div class="text-left">{!!$penetapannominatifkp->namalengkap!!}</div>
                            <small><div class="text-left">{!!$penetapannominatifkp->tmlhr!!}, {!!($penetapannominatifkp->tglhr!='0000-00-00')?date('d-m-Y', strtotime($penetapannominatifkp->tglhr)):''!!}</div></small>
                            <div class="text-right" style="position:relative">
                                <?php
                                    if($penetapannominatifkp->iscetaksk == 1){
                                        echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                    }else if($penetapannominatifkp->iscetaksk == 2){
                                        echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="SK Dibatalkan"></i></div>';
                                    }
                                ?>
                            </div>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!fnip($penetapannominatifkp->nip)!!}</div>
                            <div class="text-center">{!!$penetapannominatifkp->nokarpeg!!}</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!!$penetapannominatifkp->jabatan!!}</div>
                                <div class="text-left"><i>Pada</i></div>
                                <div class="text-left">{!!$penetapannominatifkp->path_short!!}</div>
                                <div class="text-left">TMT : {!!($penetapannominatifkp->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($penetapannominatifkp->tmtjbt)):''!!}</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!$penetapannominatifkp->golru!!}</div>
                            <div class="text-center">{!!($penetapannominatifkp->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($penetapannominatifkp->tmtpkt)):''!!}</div>
                        </td>
                        <td align="center">
                            <div class="text-center">{!!$penetapannominatifkp->golrubaru!!}</div>
                            <div class="text-center">{!!($penetapannominatifkp->tmt!='0000-00-00')?date('d-m-Y', strtotime($penetapannominatifkp->tmt)):''!!}</div>
                        </td>
                        <td>{!!$penetapannominatifkp->jenis_kp!!}</td>
                        <td class="text-center">
                            <?php
                                if($penetapannominatifkp->statususul=='1' && $penetapannominatifkp->statussk=='2'){
                                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                }else if($penetapannominatifkp->statussk=='1'){
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
                                    <li><a href="javascript:void(0)" class="text-info editnominatif" recidusul="{!!$penetapannominatifkp->idusul!!}" recnip="{!!$penetapannominatifkp->nip!!}" recnousul="{!!$penetapannominatifkp->nousul!!}" recidskpd="{!!$penetapannominatifkp->idskpd!!}"><i class="fa fa-pencil-square-o"></i>Edit Personal</a></li>
                                    @if(Session::get('role_id') <= 3)
                                    <li><a href="javascript:void(0)" class="text-info verifikasinominatif" recidusul="{!!$penetapannominatifkp->idusul!!}" recnip="{!!$penetapannominatifkp->nip!!}" recnousul="{!!$penetapannominatifkp->nousul!!}"><i class="fa fa-check"></i> Verifikasi Usulan</a></li>
                                    @else
                                    <li><a href="javascript:void(0)" class="text-info verifikasinominatif" recidusul="{!!$penetapannominatifkp->idusul!!}" recnip="{!!$penetapannominatifkp->nip!!}" recnousul="{!!$penetapannominatifkp->nousul!!}"><i class="fa fa-search"></i> Preview Usulan</a></li>
                                    @endif
                                    <li>{!! ClaravelHelpers::btnDelete($penetapannominatifkp->idusul) !!}</li>
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
                    {!! $penetapannominatifkps->appends(array('bulan' => Input::get('bulan'), 'tahun' => Input::get('tahun'), 'idjeniskp' => Input::get('idjeniskp'), 'idskpd' => Input::get('idskpd'), 'statussk' => Input::get('statussk'), 'search' => Input::get('search')))->render(); !!}
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

        $('a.editnominatif').on('click', function(e){
            e.preventDefault();
            claravel_modal('Edit Nominatif Kenaikan Pangkat','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/edit',
                data: {'idusul': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), 'idskpd': $(this).attr('recidskpd'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('a.verifikasinominatif').on('click', function(e){
            e.preventDefault();
            claravel_modal('Verifikasi Nominatif Kenaikan Pangkat','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/verifikasi',
                data: {'idusul': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('a.verif_semua').on('click', function(e){
            e.preventDefault();
            claravel_modal('Verifikasi Nominatif','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/verifSemua',
                data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
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

        //
        $('.allpengantar').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Dokumen Pengantar','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/pengantarall',
                data: {'bulan': $('select[id=bulan] option').filter(':selected').val(),'tahun': $('select[id=tahun] option').filter(':selected').val(), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    // alert($('select[id=tahun] option').filter(':selected').val());
                    if($('#bulan').val() != '' && $('#tahun').val() != ''){
                        $('#main_modal .modal-body').html(html);
                    }else{
                        bootbox.alert('Pilihan bulan dan tahun harus diisi !');
                    }
                }
            });
        })

        $('.allnominatif').on('click', function(e){
            e.preventDefault();

            claravel_modal('Atribut Daftar Nominatif','Loading...','main_modal');
            $.ajax({
                type: 'post',
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/nominatifall',
                data: {'bulan': $('select[id=bulan] option').filter(':selected').val(),'tahun': $('select[id=tahun] option').filter(':selected').val(), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    // alert($('select[id=tahun] option').filter(':selected').val());
                    if($('#bulan').val() != '' && $('#tahun').val() != ''){
                        $('#main_modal .modal-body').html(html);
                    }else{
                        bootbox.alert('Pilihan bulan dan tahun harus diisi !');
                    }
                }
            });
        })

    });


    $('.attrnominatif').on('click', function(e){
        e.preventDefault();

        claravel_modal('Atribut Daftar Nominatif','Loading...','main_modal');
        $.ajax({
            type: 'post',
            url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/data/attrnominatif',
            data: {
                'nousul': $(this).attr('recnousul'),
                'tglusul': $(this).attr('rectglusul'),
                '_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    });
    
    $('.attrnominatifdsad').on('click', function(e){
        e.preventDefault();

        claravel_modal('Atribut Daftar Nominatif','Loading...','main_modal');
        $.ajax({
            type: 'post',
            url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/cetak/nominatif',
            data: {
                'nousul': $(this).attr('recnousul'),
                '_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    })
</script>
