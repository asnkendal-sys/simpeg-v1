<section class="content-header">
    <h1>
        Urutan Jabatan Pegawai<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Urutan Jabatan Pegawai</li>
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
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}

                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">&nbsp;</td>
                        <td style="padding: 5px;" width="35%">&nbsp;</td>
                        <td style="padding: 5px;" width="55%">
                            <div class="input-group">
                                <!--<input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">-->
                                <!--<select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan Unit Kerja :." style="width: 100%"></select>-->
                                {!!comboSkpd("idskpd",(Input::get('idskpd')!='')?Input::get('idskpd'):session('idskpd'),"",session('idskpd'))!!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search </button>
                                </span>
                            </div>
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
                        <th colspan="2" rowspan="2" width="2%" align="center">NO</th>
                        <th rowspan="2" width="20%" colspan="4">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                        <th rowspan="2">NIP <br> NIP LAMA</th>
                        <th rowspan="2">GOL. <br> TMT</th>
                        <th rowspan="2">ESL</th>
                        <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA <br> TMT</th>
                        <th colspan="2">MASA KERJA</th>
                        <th colspan="2">S/D SEKARANG</th>
                        <th colspan="2">PENDIDIKAN TERAKHIR</th>
                        <th rowspan="2" width="10%">AGAMA<br>USIA</th>
                    </tr>
                    <tr>
                        <th>THN</th>
                        <th>BLN</th>
                        <th>THN</th>
                        <th>BLN</th>
                        <th>JENJANG</th>
                        <th>JURUSAN</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $r = 0; ?>
                    <?php $x = 0; ?>
                    @foreach($urutanjabatanpegawais as $urutanjabatanpegawai)
                        <?php $r++; ?>
                        <?php $x++; ?>
                        <tr>
                            <td align="center" width="2%">{!!$x!!}</td>
                            <td align="center" width="2%" style="background-color: {!!UrutanjabatanpegawaiModel::warnajabatan($urutanjabatanpegawai->idesljbt)!!};">{!!$r!!}</td>
                            <td colspan="4">
                                <?php
                                    if(File::exists("packages/upload/photo/pegawai/".$urutanjabatanpegawai->photo)){
                                        $urlphoto = url()."/packages/upload/photo/pegawai/".$urutanjabatanpegawai->photo;
                                    }else{
                                        $urlphoto = url()."/packages/upload/photo/pegawai/default.jpg";
                                    }
                                ?>
                                <span class="col-xs-4" style="padding: 0px;"><img src="{!!$urlphoto!!}" alt="{!!$urutanjabatanpegawai->nip!!}" style="width: 100%; height: auto;"></span>
                                <span class="col-xs-8" style="padding: 0px 0px 0px 3px;">{!!$urutanjabatanpegawai->namalengkap!!} <br> <small>{!!$urutanjabatanpegawai->tmlhr.", ".(($urutanjabatanpegawai->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tglhr)):'')!!}</small></span>
                            </td>
                            <td>{!!$urutanjabatanpegawai->nip!!} <br> {!!$urutanjabatanpegawai->niplama!!}</td>
                            <td>{!!$urutanjabatanpegawai->golru!!} <br> {!!(($urutanjabatanpegawai->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tmtpkt)):'')!!}</td>
                            <td align="center">{!!($urutanjabatanpegawai->esl!='')?$urutanjabatanpegawai->esl:'-'!!}</td>
                            <td><small>{!!strtoupper(($urutanjabatanpegawai->jabatan!='')?$urutanjabatanpegawai->jabatan:'-')." PADA ".(($urutanjabatanpegawai->path_short !='-')?$urutanjabatanpegawai->path_short:'')." <br> ".(($urutanjabatanpegawai->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tmtjbt)):'')!!}</small></td>
                            <td align="right">{!!$urutanjabatanpegawai->mkthnpkt!!}</td>
                            <td align="right">{!!$urutanjabatanpegawai->mkblnpkt!!}</td>
                            <td align="right">{!!substr($urutanjabatanpegawai->mkskr,0,-2)!!}</td>
                            <td align="right">{!!substr($urutanjabatanpegawai->mkskr,-2)!!}</td>
                            <td>{!!$urutanjabatanpegawai->tkpendid!!}</td>
                            <td>{!!$urutanjabatanpegawai->jenjurusan!!}</td>
                            <td>{!!$urutanjabatanpegawai->agama."<br>".substr($urutanjabatanpegawai->usia,0,2)." thn ".substr($urutanjabatanpegawai->usia,2,2)." bln"!!}</td>
                        </tr>

                        @if($urutanjabatanpegawai->idjenjab >= 20) <!--kondisi jika struktural tingakat 1-->
                        <?php $y = 0; ?>
                        @foreach(geturutanpegawai($urutanjabatanpegawai->idskpd, $urutanjabatanpegawai->idskpd) as $urutanjabatanpegawai2)
                            <?php $y++; ?>
                            <?php $x++; ?>
                            <tr>
                                <td align="center" width="2%">{!!$x!!}</td>
                                <td>&nbsp;</td>
                                <td align="center" width="2%" style="background-color: {!!UrutanjabatanpegawaiModel::warnajabatan($urutanjabatanpegawai2->idesljbt)!!};">{!!$y!!}</td>
                                <td colspan="3">
                                    <?php
                                        if(File::exists("packages/upload/photo/pegawai/".$urutanjabatanpegawai2->photo)){
                                            $urlphoto = url()."/packages/upload/photo/pegawai/".$urutanjabatanpegawai2->photo;
                                        }else{
                                            $urlphoto = url()."/packages/upload/photo/pegawai/default.jpg";
                                        }
                                    ?>
                                    <span class="col-xs-4" style="padding: 0px;"><img src="{!!$urlphoto!!}" alt="{!!$urutanjabatanpegawai2->nip!!}" style="width: 100%; height: auto;"></span>
                                    <span class="col-xs-8" style="padding: 0px 0px 0px 3px;">{!!$urutanjabatanpegawai2->namalengkap!!} <br> <small>{!!$urutanjabatanpegawai2->tmlhr.", ".(($urutanjabatanpegawai2->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tglhr)):'')!!}</small></span>
                                </td>
                                <td>{!!$urutanjabatanpegawai2->nip!!} <br> {!!$urutanjabatanpegawai2->niplama!!}</td>
                                <td>{!!$urutanjabatanpegawai2->golru!!} <br> {!!(($urutanjabatanpegawai2->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tmtpkt)):'')!!}</td>
                                <td align="center">{!!($urutanjabatanpegawai2->esl!='')?$urutanjabatanpegawai2->esl:'-'!!}</td>
                                <td><small>{!!strtoupper(($urutanjabatanpegawai2->jabatan!='')?$urutanjabatanpegawai2->jabatan:'-')." PADA ".(($urutanjabatanpegawai2->path_short !='-')?$urutanjabatanpegawai2->path_short:'')." <br> ".(($urutanjabatanpegawai2->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tmtjbt)):'')!!}</small></td>
                                <td align="right">{!!$urutanjabatanpegawai2->mkthnpkt!!}</td>
                                <td align="right">{!!$urutanjabatanpegawai2->mkblnpkt!!}</td>
                                <td align="right">{!!substr($urutanjabatanpegawai2->mkskr,0,-2)!!}</td>
                                <td align="right">{!!substr($urutanjabatanpegawai2->mkskr,-2)!!}</td>
                                <td>{!!$urutanjabatanpegawai2->tkpendid!!}</td>
                                <td>{!!$urutanjabatanpegawai2->jenjurusan!!}</td>
                                <td>{!!$urutanjabatanpegawai2->agama."<br>".substr($urutanjabatanpegawai2->usia,0,2)." thn ".substr($urutanjabatanpegawai2->usia,2,2)." bln"!!}</td>
                            </tr>

                            @if($urutanjabatanpegawai2->idjenjab >= 20) <!--kondisi jika struktural tingakat 2-->
                            <?php $z = 0; ?>
                            @foreach(geturutanpegawai($urutanjabatanpegawai2->idskpd, $urutanjabatanpegawai2->idskpd) as $urutanjabatanpegawai3)
                                <?php $z++; ?>
                                <?php $x++; ?>
                                <tr>
                                    <td align="center" width="2%">{!!$x!!}</td>
                                    <td colspan="2">&nbsp;</td>
                                    <td align="center" width="2%" style="background-color: {!!UrutanjabatanpegawaiModel::warnajabatan($urutanjabatanpegawai3->idesljbt)!!};">{!!$z!!}</td>
                                    <td colspan="2">
                                        <?php
                                            if(File::exists("packages/upload/photo/pegawai/".$urutanjabatanpegawai3->photo)){
                                                $urlphoto = url()."/packages/upload/photo/pegawai/".$urutanjabatanpegawai3->photo;
                                            }else{
                                                $urlphoto = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }
                                        ?>
                                        <span class="col-xs-4" style="padding: 0px;"><img src="{!!$urlphoto!!}" alt="{!!$urutanjabatanpegawai3->nip!!}" style="width: 100%; height: auto;"></span>
                                        <span class="col-xs-8" style="padding: 0px 0px 0px 3px;">{!!$urutanjabatanpegawai3->namalengkap!!} <br> <small>{!!$urutanjabatanpegawai3->tmlhr.", ".(($urutanjabatanpegawai3->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tglhr)):'')!!}</small></span>
                                    </td>
                                    <td>{!!$urutanjabatanpegawai3->nip!!} <br> {!!$urutanjabatanpegawai3->niplama!!}</td>
                                    <td>{!!$urutanjabatanpegawai3->golru!!} <br> {!!(($urutanjabatanpegawai3->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tmtpkt)):'')!!}</td>
                                    <td align="center">{!!($urutanjabatanpegawai3->esl!='')?$urutanjabatanpegawai3->esl:'-'!!}</td>
                                    <td><small>{!!strtoupper(($urutanjabatanpegawai3->jabatan!='')?$urutanjabatanpegawai3->jabatan:'-')." PADA ".(($urutanjabatanpegawai3->path_short !='-')?$urutanjabatanpegawai3->path_short:'')." <br> ".(($urutanjabatanpegawai3->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tmtjbt)):'')!!}</small></td>
                                    <td align="right">{!!$urutanjabatanpegawai3->mkthnpkt!!}</td>
                                    <td align="right">{!!$urutanjabatanpegawai3->mkblnpkt!!}</td>
                                    <td align="right">{!!substr($urutanjabatanpegawai3->mkskr,0,-2)!!}</td>
                                    <td align="right">{!!substr($urutanjabatanpegawai3->mkskr,-2)!!}</td>
                                    <td>{!!$urutanjabatanpegawai3->tkpendid!!}</td>
                                    <td>{!!$urutanjabatanpegawai3->jenjurusan!!}</td>
                                    <td>{!!$urutanjabatanpegawai3->agama."<br>".substr($urutanjabatanpegawai3->usia,0,2)." thn ".substr($urutanjabatanpegawai3->usia,2,2)." bln"!!}</td>
                                </tr>

                                @if($urutanjabatanpegawai3->idjenjab >= 20) <!--kondisi jika struktural tingakat 3-->
                                <?php $q = 0; ?>
                                @foreach(geturutanpegawai($urutanjabatanpegawai3->idskpd, $urutanjabatanpegawai3->idskpd) as $urutanjabatanpegawai4)
                                    <?php $q++; ?>
                                    <?php $x++; ?>
                                    <tr>
                                        <td align="center" width="2%">{!!$x!!}</td>
                                        <td colspan="3">&nbsp;</td>
                                        <td align="center" width="2%" style="background-color: {!!UrutanjabatanpegawaiModel::warnajabatan($urutanjabatanpegawai4->idesljbt)!!};">{!!$z!!}</td>
                                        <td>{!!$urutanjabatanpegawai4->namalengkap!!} <br> <small>{!!$urutanjabatanpegawai4->tmlhr.", ".(($urutanjabatanpegawai4->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tglhr)):'')!!}</small></td>
                                        <td>{!!$urutanjabatanpegawai4->nip!!} <br> {!!$urutanjabatanpegawai4->niplama!!}</td>
                                        <td>{!!$urutanjabatanpegawai4->golru!!} <br> {!!(($urutanjabatanpegawai4->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tmtpkt)):'')!!}</td>
                                        <td align="center">{!!($urutanjabatanpegawai4->esl!='')?$urutanjabatanpegawai4->esl:'-'!!}</td>
                                        <td><small>{!!strtoupper(($urutanjabatanpegawai4->jabatan!='')?$urutanjabatanpegawai4->jabatan:'-')." PADA ".(($urutanjabatanpegawai4->path_short !='-')?$urutanjabatanpegawai4->path_short:'')." <br> ".(($urutanjabatanpegawai4->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tmtjbt)):'')!!}</small></td>
                                        <td align="right">{!!$urutanjabatanpegawai4->mkthnpkt!!}</td>
                                        <td align="right">{!!$urutanjabatanpegawai4->mkblnpkt!!}</td>
                                        <td align="right">{!!substr($urutanjabatanpegawai4->mkskr,0,-2)!!}</td>
                                        <td align="right">{!!substr($urutanjabatanpegawai4->mkskr,-2)!!}</td>
                                        <td>{!!$urutanjabatanpegawai3->tkpendid!!}</td>
                                        <td>{!!$urutanjabatanpegawai3->jenjurusan!!}</td>
                                        <td>{!!$urutanjabatanpegawai4->agama."<br>".substr($urutanjabatanpegawai4->usia,0,2)." thn ".substr($urutanjabatanpegawai4->usia,2,2)." bln"!!}</td>
                                    </tr>
                                @endforeach
                                @endif <!--endif kondisi jika struktural 1-->
                            @endforeach
                            @endif <!--endif kondisi jika struktural 2-->
                        @endforeach
                        @endif <!--endif kondisi jika struktural 3-->
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
              <?php /*echo $urutanjabatanpegawais->appends(array('idskpd' => Input::get('idskpd'), 'search' => Input::get('search')))->render(); */?>
            </div>
          </div>
            <blockquote style="font-size: 12px"><i class="fa fa-fw fa-bullhorn"></i>
                Perhatian
                <p>
                    Jika urutan jabatan tidak sesuai silahkan periksa kembali unit kerja, sub unit kerja dan jenis jabatan pegawai apakah sudah sesuai dengan kondisi sebenarnya.
                </p>
            </blockquote>
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
    });
</script>