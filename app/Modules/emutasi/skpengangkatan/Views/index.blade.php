
<section class="content-header">
    <h1>
        SK Pengangkatan Pelaksana<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">skpengangkatan</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <p>&nbsp;</p>
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables" class="pull-right">
                    <tr>
                        <td style="padding: 5px;" width="40%">{!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}</td>
                        <td style="padding: 5px;" width="20%">
                            <select id="statususul" name="statususul" class="input-large form-control">
                                <option value="" {!!((Input::get('statususul')=='')?'selected':'')!!}>.: Status Berkas :.</option>
                                <option value="1" {!!((Input::get('statususul')==1)?'selected':'')!!}>Memenuhi Syarat</option>
                                <option value="2" {!!((Input::get('statususul')==2)?'selected':'')!!}>Tidak Memenuhi Syarat</option>
                                <option value="3" {!!((Input::get('statususul')==3)?'selected':'')!!}>Berkas Tidak Lengkap</option>
                            </select>
                        </td>
                        <td style="padding: 5px;" width="20%">
                            <select id="statussk" name="statussk" class="input-large form-control">
                                <option value="" {!!((Input::get('statussk')=='')?'selected':'')!!}>.: Status SK :.</option>
                                <option value="2" {!!((Input::get('statussk')==2)?'selected':'')!!}>Dalam Proses</option>
                                <option value="1" {!!((Input::get('statussk')==1)?'selected':'')!!}>Proses Selesai</option>
                            </select>
                        </td>
                        <td style="padding: 5px;" width="20%">
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
        <div class="">
            <div class="box-body">
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
                            <th width="5%"><div class="text-center">AKSI</div></th>
                        </tr>
                    </thead>   

                    <tbody>
                        <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                        ?>
                        @foreach ($skpengangkatans as $skpengangkatan)
                        <?php
                        $x++;
                        $n++;
                        $arr[$n] = $skpengangkatan->nousul;
                        if($arr[$n]!=$arr[$n-1]){
                            ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$skpengangkatan->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($skpengangkatan->tglusul))?> 
                                        &nbsp;
                                        <?php echo "||&nbsp;".getskpdgroup(substr($skpengangkatan->idskpd, 0,2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-right">
                                        @if(session::get('role_id')<=2)

                                            
                                                 <a href="javascript::void(0)" target="_blank" class="btn btn-default nokolektif" recnousul="{!!$skpengangkatan->nousul!!}" act="nokolektif" title="No Kolektif"><span class="fa fa-pencil"></span> No Kolektif</a>
                                            

                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                <span class="fa fa-print"></span> Cetak Kolektif/Petikan
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#" class="attrnominatif" recnousul="{!!$skpengangkatan->nousul!!}" act="nominatif" title="Cetak Lampiran Nominatif"><i class="fa fa-list"> Nominatif</i></a></li>
                                                <li><a href="javascript:void(0)" class="attrskkolektif" recnousul="{!!$skpengangkatan->nousul!!}" act="skperintahkolektif" title="SKKolektif"><i class="fa fa-print"> SK Kolektif</i></a></li>
                                                <li><a href="javascript:void(0)" class="attrskpetikan" recnousul="{!!$skpengangkatan->nousul!!}" act="skpetikan" title="SK Petikan"><i class="fa fa-print"> SK Petikan</i></a></li>
                                                <li><a href="javascript:void(0)" class="attrexcelskpetikan" recnousul="{!!$skpengangkatan->nousul!!}" act="excelskpetikan" title="Download Excel"><i class="fa fa-print"> Download Excel</i></a></li>
                                                

                                            </ul>
                                            @endif
                                        </div>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><center>{!! $x !!}</center></td>
                            <td>{!!$skpengangkatan->nip!!}<br>{!!$skpengangkatan->namalengkap!!}
                                <a title="popdetil" href="javascript:void(0)"></a><br>
                                <div class="text-right" style="position:relative">
                                    @if($skpengangkatan->iscetaksk == 1)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#ffcc00;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @elseif($skpengangkatan->iscetaksk == 2)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#000000;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @endif
                                </div></td>
                                <td>{!!$skpengangkatan->golru!!}<br>{!!$skpengangkatan->tmtpkt!!}</td>
                                <td>{!!$skpengangkatan->tkpendid!!}<br>{!!$skpengangkatan->jenjurusan!!}</td>
                                <td><?php echo getskpd($skpengangkatan->idskpd); ?></td>

                                <td>{!!$skpengangkatan->jabatan!!}<br>{!!$skpengangkatan->tmtjbt!!}</td>
                                <td><?php echo getskpd($skpengangkatan->idskpdbaru); ?></td>
                                <td>{!!$skpengangkatan->jabatanbaru!!}</td>
                                <td>
                                    <div align="center">
                                        @if($skpengangkatan->statususul==1)
                                        <span style="color:green">
                                            <i class="glyphicon glyphicon-ok" title="Memenuhi Syarat"/>
                                            <span>
                                                @elseif($skpengangkatan->statususul==2)
                                                <span style="color:red">
                                                    <i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat"/>
                                                </span>
                                                @elseif($skpengangkatan->statususul==3)
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
                                                @if($skpengangkatan->statususul=='1' && $skpengangkatan->statussk=='2')
                                                <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/><span>
                                                    @elseif($skpengangkatan->statussk=='1')
                                                    <span style="color:green"><i class="glyphicon glyphicon-ok" title="Selesai diproses"/></span>
                                                    @else
                                                    -
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if(($skpengangkatan->statususul == 1) and ($skpengangkatan->statussk == 1))
                                                <a href="<?php echo url()."/emutasi/skpengangkatan/cetak/skperintah/".$skpengangkatan->nousul."/".$skpengangkatan->nip?>" target="blank" title="Cetak Surat Perintah"><i class="fa fa-print"></i></a>
                                                @else
                                                <a href="javascript:void(0)" title="SK Perintah Belum Selesai Diproses" style="color: red"><i class="fa fa-print"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                          <div class="row">
                              <div class="col-sm-6">&nbsp;</div>
                              <div class="col-sm-6">
                                  <?php echo $skpengangkatans->appends(array('search' => Input::get('search'), 'statususul' => Input::get('statususul'), 'statussk' => Input::get('statussk'), 'idskpd' => Input::get('idskpd')))->render(); ?>
                              </div>
                          </div>
                      </div>
                      {!! Form::close() !!}
                  </div>
                  <div>
                    <table border="0" width="100%">
                        <tr>
                            <td colspan="11">Keterangan :<br></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color:green"><i class="glyphicon glyphicon-ok" title="Memenuhi Syarat"/></span> Memenuhi Syarat<br>
                            </td>
                            <td>
                                <span style="color:red"><i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat"/></span> Tidak Memenuhi Syarat<br>
                            </td>
                            <td>
                                <span style="color:orange"><i class="glyphicon glyphicon-exclamation-sign" title="Berkas Tidak Lengkap"/></span> Berkas Tidak Lengkap<br>
                            </td>
                            <td>
                                <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/></span> Sedang Diproses<br>
                            </td>
                            <td>
                                <span style="color:green"><i class="glyphicon glyphicon-ok" title="Selesai diproses"/></span> Selesai diproses<br>
                            </td>
                            <td>
                                <span style="color:#ffcc00"><i class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK<br>
                            </td>
                            <td>
                                <span style="color:#000000"><i class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> SK Dibatalkan<br>
                            </td>
                        </tr>
                    </table>
                </div><br>
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


                    $('.nokolektif').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('Atribut Dokumen SK Kolektif','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/nokolektif',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })

                    $('.attrpengantar').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('Atribut Dokumen','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/attrpengantar',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })

                    $('.attrnominatif').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('Nominatif','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/attrnominatif',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })

                    $('.attrskkolektif').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('SK Kolektif','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/attrskkolektif',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })

                    $('.attrskpetikan').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('SK Petikan','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/attrskpetikan',
                            data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })

                    $('.attrexcelskpetikan').on('click', function(e){
                        e.preventDefault();

                        claravel_modal('SK Petikan','Loading...','main_modal');
                        $.ajax({
                            type: 'post',
                            url : '{!!url()!!}/emutasi/skpengangkatan/data/attrexcelskpetikan',
                            data: {'idskpd': $(this).attr('idskpd'),'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
                            success:function(html){
                                $('#main_modal .modal-body').html(html);
                            }
                        });
                    })


                });
            </script>
