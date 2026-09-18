<section class="content-header">
    <h1>
        Entri Pensiun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Entri Pensiun</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <!--<div class="col-lg-3 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">
                    {!! ClaravelHelpers::btnCreate() !!}
                </div>
            </div>-->
            <!--<div class="box-tools pull-right col-lg-9 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;">&nbsp;</td>
                        <td style="padding: 5px;" width="55%">-->
                            <!--<select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan Unit Kerja :." style="width: 100%"></select>-->
                            <!--{!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                        </td>
                        <td style="padding: 5px;" width="35%">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}-->

                <div class="col-md-12">
                    <ul class="nav nav-tabs tab1" id="myTab">
                        <li class="active"><a href="{!!url()!!}/epersonal/entripensiun"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PENSIUN</a></li>
                        <li class=""><a href="{!!url()!!}/epersonal/entripensiun/datapensiun"> <i class="fa fa-fw fa-list-ul"></i> DAFTAR PENSIUN</a></li>
                    </ul>

                    <div class="tab-pane active"><br>
                        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-horizontal form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
{!! csrf_field() !!}
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))!!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idjenjab', 'Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! comboJenjab("idjenjab",Input::get('idjenjab'),"") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('bulan1', 'Bulan Antara:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-2">
                                    {!! comboBulan("bulan1",Input::get('bulan1'),"") !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! comboBulan("bulan2",Input::get('bulan2'),"") !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! comboTahun("tahun",Input::get('tahun'),"") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('search', 'Pencarian:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}" placeholder='Ketikkan NIP / Nama'>
                                </div>
                            </div>
                        </div>
                                <!--  edit candra -->
                          <div class="box-footer">
                        <!-- <div class="form-group"> -->
                        <!-- <div class="col-sm-offset-3 col-sm-7"> -->
                        <button class="btn btn-success" type="button" id="prev-nominatif"><i class="fa fa-list-ul"></i> Lihat Nominatif Pensiun</button>
                        <button type="button" class="btn btn-success" id="excel-djk">
                            <i class="fa fa-file-excel-o"></i> Download Excel
                        </button>
                        <!-- </div>
                            </div> -->

                    </div>
                                <!--  edit candra -->
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th rowspan="2" width="2%">No</th>
                        <th rowspan="2" width="15%">NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>
                        <th rowspan="2">NIP <br> NIP LAMA</th>
                        <th rowspan="2">GOL. <br> TMT</th>
                        <th rowspan="2">ESL</th>
                        <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA <br> TMT</th>
                        <th colspan="2">MASA KERJA</th>
                        <th colspan="2">S/D SEKARANG</th>
                        <th colspan="2">PENDIDIKAN TERAKHIR</th>
                        <th rowspan="2" width="10%">AGAMA<br>USIA</th>
                        <th rowspan="2" width="5%">TMT DAN USIA PENSIUN</th>
                        <th rowspan="4" width="8%">AKSI</th>
                    </tr>
                    <tr>
                        <th>THN</th>
                        <th>BLN</th>
                        <th>THN</th>
                        <th>BLN</th>
                        <th>Tingkat</th>
                        <th>Jurusan</th>
                    </tr>

                    </thead>

                    <tbody>
                    <?php $x = 0; ?>
                    @if(count($entripensiuns) > 0)
                        @foreach ($entripensiuns as $entripensiun)
                        <?php $x++;?>
                        <tr>
                            <td>{!!$x!!}</td>
                            <td>{!!$entripensiun->namalengkap!!} <br> <small>{!!$entripensiun->tmlhr.", ".(($entripensiun->tglhr != '0000-00-00')?date('d-m-Y', strtotime($entripensiun->tglhr)):'00-00-0000')!!}</small></td>
                            <td>{!!$entripensiun->nip!!} <br> {!!$entripensiun->niplama!!}</td>
                            <td>{!!$entripensiun->golru!!} <br> {!!(($entripensiun->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($entripensiun->tmtpkt)):'')!!}</td>
                            <td align="center">{!!($entripensiun->esl!='')?$entripensiun->esl:'-'!!}</td>
                            <td>{!!strtoupper(($entripensiun->jabatan!='')?$entripensiun->jabatan:'-')." PADA ".(($entripensiun->path_short !='-')?$entripensiun->path_short:'')." <br> ".(($entripensiun->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($entripensiun->tmtjbt)):'')!!}</td>
                            <td align="right">{!!$entripensiun->mkthnpkt!!}</td>
                            <td align="right">{!!$entripensiun->mkblnpkt!!}</td>
                            <td align="right">{!!substr($entripensiun->mkskr,0,-2)!!}</td>
                            <td align="right">{!!substr($entripensiun->mkskr,-2)!!}</td>
                            <td>{!!$entripensiun->tkpendid!!}</td>
                            <td>{!!$entripensiun->jenjurusan!!}</td>
                            <td>
                                @if($entripensiun->usia!='')
                                    {!!$entripensiun->agama."<br>".substr($entripensiun->usia,0,2)." thn ".substr($entripensiun->usia,2,2)." bln"!!}
                                @else
                                    {!!$entripensiun->agama."<br> 0 thn 0 bln"!!}
                                @endif
                            </td>
                            <td align="center">
                                <!--{!!($entripensiun->tmtpens!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($entripensiun->tmtpens))."<br>":''!!}
                                {!!($entripensiun->usiapens!='')?$entripensiun->usiapens:'-'!!} thn-->

                                {!!($entripensiun->pensiunnext!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($entripensiun->pensiunnext))."<br>":''!!}
                                <!--{!!($entripensiun->usiapens!='')?$entripensiun->usiapens:'-'!!}--> {!!$entripensiun->usiapens!!} thn
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a class="text-primary verify" recid="{{$entripensiun->nip}}" href="javascript:void(0)"><i class="fa fa-graduation-cap"></i> Pensiunkan</a></li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="14">Data tidak ditemukan</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <p style="height: 50px;">&nbsp;</p>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    {!! ClaravelHelpers::btnDeleteAll() !!}
                </div>
                <div class="col-sm-6">
                    @if(count($entripensiuns) > 0)
                        <?php echo $entripensiuns->appends(array('idskpd'=>Input::get('idskpd'), 'search' => Input::get('search'), 'bulan1' => Input::get('bulan1'), 'bulan2' => Input::get('bulan2'), 'tahun' => Input::get('tahun'), 'idjenjab' => Input::get('idjenjab')))->render(); ?>
                    @endif
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

        $('#tabel').on('click','.verify',function(e){
            e.preventDefault();
            claravel_modal('Penetapan Pensiun','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/entripensiun/data/pensiun',
                data: {'nip': $(this).attr('recid'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if(n > 0){
            }
            else{
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

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
            }
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
                            notification(html,'success');
                            $this.closest('tr').fadeOut(300,function(){
                                $(this).remove();
                            });
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
        // edit candra
        // $('#cari').on('submit', function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         data: $(this).serialize(),
        //         type: 'get',
        //         beforeSend: function() {
        //             preloader.on();
        //         },
        //         success: function(html) {
        //             preloader.off();
        //             $('#utama').html(html);
        //         }
        //     });
        // });

        $('#prev-nominatif').click(function() {
            $.ajax({
                url: $('#cari').attr('action'),
                data: $('#cari').serialize(),
                type: 'get',
                beforeSend: function() {
                    preloader.on();
                },
                success: function(html) {
                    preloader.off();
                    $('#utama').html(html);
                }
            });

        });


        $('#excel-djk').on('click', function(e) {
            e.preventDefault();

            // ubah action dan method form
            $('#cari').attr("action", "{!! url('epersonal/entripensiun/excel/nominatifpensiun') !!}");
            $('#cari').attr("method", "POST");

            // kirim form
            $('#cari').submit();
        });

        // end edit candra
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
