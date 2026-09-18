<section class="content-header" xmlns="http://www.w3.org/1999/html">
    <h1>
        Rekap Pensiun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Rekap Pensiun</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary" id="rekap">
        <div class="box-header with-border row">            
            <!-- <p>//{!! ClaravelHelpers::btnCreate() !!}</p> -->
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-horizontal cetak-rekap form-'.\Config::get('claravel::ajax'),'id' => 'cari' ,'target' => '_blank')) !!}
                {!!csrf_field()!!}
                <input type="hidden" name="page" id="pageno" value="{!!((Input::get('page') != '')?Input::get('page'):'')!!}">
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('tanggal1', 'TMT Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            <div class='input-group datepicker'>
                                <input type="text" name="tanggal1" id="tanggal1" class="form-control date awal" value="{!!Input::get('tanggal1')!!}" placeholder="dd-mm-yyyy">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-1" style="margin-top: 7px; width: 40px">
                            s/d
                        </div>
                        <div class="col-sm-2">
                            <div class='input-group datepicker'>
                                <input type="text" name="tanggal2" id="tanggal2" class="form-control date awal" value="{!!Input::get('tanggal2')!!}" placeholder="dd-mm-yyyy">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <!-- <input type="submit" name="cariTgl" value="Filter"> -->
                            <button class="btn btn-success" type="submit" id="cari-nominasi" name="cari-nominasi"><span class="fa fa-fw fa-filter"></span> Filter Pensiun</button>&nbsp;
                            <!-- <button class="btn btn-success" type="button" id="cetak-sk"><span class="fa fa-fw fa-print"></span> Cetak DPCP Pensiun</button>&nbsp; -->
                            <button class="btn btn-success" type="button" id="cetak-nominatif"><span class="fa fa-fw fa-print"></span> Cetak Nominatif Pensiun</button>&nbsp;
                        </div>
                    </div>
                </div>
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
                                <div class="text-center">NAMA LENGKAP</div>
                                <div class="text-center">TEMPAT,&nbsp;TGL&nbsp;LAHIR</div>
                            </th>
                            <th rowspan="2">
                                <div class="text-center">NIP</div>
                                <div class="text-center">NIP LAMA</div>
                            </th>
                            <th rowspan="2">
                                <div class="text-center">GOL.</div>
                                <div class="text-center">TMT</div>
                            </th>
                            <th rowspan="2">
                                <div class="text-center">ESL</div>                                
                            </th>
                            <th rowspan="2">
                                <div class="text-center">JABATAN </div>
                                <div class="text-center">UNIT KERJA</div>
                                <div class="text-center">TMT</div>
                            </th>
                            <th colspan="2">
                                <div class="text-center">MASA </div> 
                                <div class="text-center">KERJA </div>                            
                            </th>
                            <th colspan="2">
                                <div class="text-center">S/D</div>     
                                <div class="text-center">SEKARANG </div>                        
                            </th>
                            <th colspan="2">
                                <div class="text-center">PENDIDIKAN</div>     
                                <div class="text-center">TERAKHIR </div>                        
                            </th>
                            <th rowspan="2">
                                <div class="text-center">AGAMA</div>
                                <div class="text-center">USIA</div>                        
                            </th>
                            <th rowspan="2">
                                <div class="text-center">TMT DAN</div>
                                <div class="text-center">USIA</div>
                                <div class="text-center">PENSIUN</div>
                            </th>
                            <th rowspan="2"><div align="center">JENIS PENSIUN</div></th>
                            <th colspan="2"><div align="center">STATUS</div></th>
                            <!-- <th rowspan="2" width="7%">Act.</th> -->
                        </tr>
                        <tr>
                            <th><div align="center">THN</div></th>
                            <th><div align="center">BLN</div></th>
                            <th><div align="center">THN</div></th>
                            <th><div align="center">BLN</div></th>
                            <th><div align="center">Tingkat</div></th>
                            <th><div align="center">Jurusan</div></th>
                            <th><div align="center">USUL</div></th>
                            <th><div align="center">Proses</div> </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($rekappensiuns as $rekappensiun)
                    <?php
                        $x++;
                        $n++;
                        $arr[$n] = $rekappensiun->tmtpens.'_'.substr($rekappensiun->idskpd,0,2);
                            if($arr[$n]!=$arr[$n-1]){
                            // dd($arr);
                    ?>
                            <tr>
                                <th style="position:relative;" colspan="6" align="left">
                                    TMT PENSIUN <i class="icon-calendar"></i> <?php echo date("d-m-Y", strtotime($rekappensiun->tmtpens))?> -
                                    <?php
                                        if(Input::get('idskpd') != ''){
                                            echo getSkpd(Input::get('idskpd'));
                                        }else{
                                            if(session('role_id') == 4){
                                                if(strlen(session('idskpd')) == 2){
                                                    echo getSkpd(substr($rekappensiun->idskpd,0,2));
                                                }else{
                                                    echo getSkpd(substr($rekappensiun->idskpd,0,5));
                                                }
                                            }else{
                                                echo getSkpd(substr($rekappensiun->idskpd,0,2));
                                            }
                                        }
                                    ?>
                                </th>
                                <th style="position:relative;" colspan="11" align="right">
                                    <div class="text-right">                                       
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="false">
                                                <span class="fa fa-list"></span> Nominatif
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="{!!url()!!}/epensiun/nominatifpensiun/cetaknominatif/{!!$rekappensiun->tmtpens!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($rekappensiun->idskpd,0,2))!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Nominatif" target="_blank"><i class="fa fa-print"/></i> Data Nominatif</a></li>
                                                <li><a href="{!!url()!!}/epensiun/nominatifpensiun/cetakditerima/{!!$rekappensiun->tmtpens!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($rekappensiun->idskpd,0,2))!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Tanda Terima" target="_blank"><i class="fa fa-print"/></i> Tanda Terima</a></li>
                                            </ul>
                                        </div>
                                        <!-- &nbsp;<a href="{!!url()!!}/epensiun/nominatifpensiun/cetakskkolektif/{!!$rekappensiun->tmtpens!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($rekappensiun->idskpd,0,2))!!}" class="attrpengantar btn btn-success" act="pengantar" title="Cetak DPCP Kolektif" target="_blank"><i class="fa fa-file"/></i> DPCP Kolektif</a> -->
                                    </div>
                                </th>
                            </tr>
                    <?php } ?>
                    <tr>
                        <td>{!!$x!!}</td>
                        <td>
                            <div class="text-left">{!! $rekappensiun->namalengkap !!}</div>
                            <small><div class="text-left">{!! $rekappensiun->tmlhr !!}, {!! tglina($rekappensiun->tglhr) !!}</div></small>
                            <div class="text-right" style="position:relative">
                                <?php
                                    if($rekappensiun->iscetaksk == 1){
                                        echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak DPCP"></i></div>';
                                    }else if($rekappensiun->iscetaksk == 2){
                                        echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak DPCP"></i></div>';
                                    }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">{!! $rekappensiun->nip !!}</div>
                            <div class="text-center">{!! $rekappensiun->niplama !!}</div>
                        </td>                        
                        <td>
                            <small>
                                <div class="text-left">{!! $rekappensiun->golru !!}</div>
                                <div class="text-left">{!!(($rekappensiun->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($rekappensiun->tmtpkt)):'')!!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-center">{!!($rekappensiun->esl!='')?$rekappensiun->esl:'-'!!}</div>                                
                            </small>
                        </td>
                        <td>                            
                            <div class="text-left">{!!strtoupper(($rekappensiun->jabatan!='')?$rekappensiun->jabatan:'-')." PADA ".(($rekappensiun->path_short !='-')?$rekappensiun->path_short:'')!!}</div>
                            <div class="text-left">{!!(($rekappensiun->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($rekappensiun->tmtjbt)):'')!!}</div>                           
                        </td>
                        <td>                            
                            <div class="text-center">{!!$rekappensiun->mkthnpkt!!}</div>                                                
                        </td>
                        <td>                            
                            <div class="text-center">{!!$rekappensiun->mkblnpkt!!}</div>                                                
                        </td>
                        <td>                            
                            <div class="text-center">{!!substr($rekappensiun->mkskr,0,-2)!!}</div>                                                
                        </td>
                        <td>                            
                            <div class="text-center">{!!substr($rekappensiun->mkskr,-2)!!}</div>                                                
                        </td>
                        <td>                            
                            <div class="text-center">{!!$rekappensiun->tkpendid!!}</div>                                                
                        </td>
                        <td>                            
                            <div class="text-left">{!!$rekappensiun->jenjurusan!!}</div>                                                
                        </td>                                             
                        <td>                          
                            @if($rekappensiun->usia!='')                    
                                <div class="text-left">{!!$rekappensiun->agama!!}</div>
                                <div class="text-left">{!! substr($rekappensiun->usia,0,2)." thn ".substr($rekappensiun->usia,2,2)." bln"!!}</div>
                            @else
                                <div class="text-left">{!!$rekappensiun->agama."<br> 0 thn 0 bln"!!}</div>
                            @endif
                        </td>
                        <td>                         
                                <div class="text-left">{!!($rekappensiun->tmtpens!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($rekappensiun->tmtpens)):'' !!}</div>                                
                                <div class="text-left">{!!$rekappensiun->usiapens!!} thn</div>                                
                        </td>
                        <td>                            
                            <div class="text-left">{!!$rekappensiun->jenpens!!}</div>                                                
                        </td>
                        <td>
                            <?php
                                if($rekappensiun->statususul==1){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                }else if($rekappensiun->statususul==2){
                                    echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                }else if($rekappensiun->statususul==3){
                                    echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                }else{
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($rekappensiun->statususul=='1' && $rekappensiun->statussk=='2'){
                                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                }else if($rekappensiun->statussk=='1'){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                }else {
                                    echo '-';
                                }
                            ?>
                        </td>

                        <!-- <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <<ul class="dropdown-menu pull-right">                                   
                                    @if($rekappensiun->statussk=='1')
                                        <li><a id="cetaksk" href="{!!url()!!}/epensiun/nominatifpensiun/cetaksk/{!!$rekappensiun->nip!!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak DPCP</a></li>
                                    @else
                                        <li><a id="cetaksk" href="javascript:void(0)" title="status DPCP belum selesai di proses" class="text-info" style="color: red"><i class="fa fa-print"></i> Cetak DPCP</a></li>
                                    @endif                                        
                                </ul>>
                            </div>
                        </td> -->
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
                                <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak DPCP"/></span> Sudah Cetak DPCP<br>
                            </td>
                            <td>
                                <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak DPCP"/></span> DPCP Dibatalkan<br>
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
                <?php echo $rekappensiuns->appends(array('tanggal1' => Input::get('tanggal1'), 'tanggal2' => Input::get('tanggal2'), 'idskpd' => Input::get('idskpd')))->render(); ?>
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

    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });
        $(".datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".date").mask("99-99-9999"); 

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
                        data: {'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
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

        $('#cari-nominasi').on('click',function(e){
            e.preventDefault();

            $('#cari').attr("method", "get");
            $.ajax({
                url : '{!!url()!!}/epensiun/rekappensiun',
                data: $('#cari').serialize(),
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

        // $('#cetak-sk').on('click', function(e){
        //     e.preventDefault();
        //     alert('oh');
        // });

        $('#cetak-sk').on('click', function(e){
            e.preventDefault();

            $('.cetak-rekap').attr("method", "post");
            $('.cetak-rekap').attr("action", "{!!url()!!}/epensiun/rekappensiun/rekapsk");
            $('.cetak-rekap').submit();
        });

        $('#cetak-nominatif').on('click', function(e){
            e.preventDefault();

            $('.cetak-rekap').attr("method", "post");
            $('.cetak-rekap').attr("action", "{!!url()!!}/epensiun/rekappensiun/rekapnominatif");
            $('.cetak-rekap').submit();
        });

    });
</script>
