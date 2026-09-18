<section class="content-header" style="margin-bottom:0px">
    <h1>
        Kenaikan Gaji<small> TTE</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Kenaikan Gaji</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" style="min-height: 44px;">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
            {!!csrf_field()!!}
            <table class="table">
                <tr>
                    <td width="10%">Status TTE</td>
                    <td width="2%">:</td>
                    <td width="38%">{!! comboStatusTTE('status_tte',Input::get('status_tte'),false) !!}</td>
                    <td width="10%">Status Pegawai</td>
                    <td width="2%">:</td>
                    <td width="38%">{!!comboStspns("idstspeg",Input::get('idstspeg'),"")!!}</td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td>:</td>
                    <td>{!! comboGolru("idgolru","","") !!}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </td>
                </tr>
                <tr>
                    <td>NIP / Nama</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                        <th rowspan="2" width="3%"><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua"></th>
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
                        <!-- <th rowspan="2">
                           <div class="text-center">PKT&nbsp;GOL.</div>
                           <div class="text-center">TMT</div>
                           <div class="text-center">MASA KERJA</div>
                       </th> -->
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
                        <th><div align="center">STATUS</div></th>
                        {{-- <th rowspan="2" >SK TTE</th> --}}
                        <th rowspan="2" width="7%">Act.</th>
                    </tr>
                    <tr>
                        {{-- <th><div align="center">USUL</div></th> --}}
                        {{-- <th><div align="center">SK</div> </th> --}}
                        <th><div align="center">TTE</div> </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($ttes as $tte)
                    <tr>
                        @if($tte->proses != 1)
                        <td><center>{!! ClaravelHelpers::checkPrev($tte->id); !!}</center></td>
                        <!-- <td><center>{!! ClaravelHelpers::checkPrev($tte->nip,$tte->id); !!}</center></td> -->
                        <!-- <td><center>{!! ClaravelHelpers::checkPrev($tte->idkgb); !!}</center></td> -->
                        @else
                        <td class="text-center">-</td>
                        @endif
                        <?php $x++;?>
                        <td class="center">{!! $x !!}</td>
                        <td>
                            <div class="text-left">{!! $tte->nama !!}</div>
                            <small><div class="text-left">{!! $tte->tmplahir !!}, {!! tglina($tte->tgllahir) !!}</div></small>
                        </td>
                        <td>
                            <div class="text-center">{!! $tte->nip !!}</div>
                            <div class="text-center">{!! $tte->karpeg !!}</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! ucword($tte->nmajab) !!} {!! $tte->tmpskpdskr !!}</div>
                                <div class="text-left">TMT : {!! tglina($tte->tmtjbt) !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! ($tte->idstspeg != 3)?$tte->golpnsname:$tte->golru_p3k !!} {!! ($tte->noskkgbl=='')?'&nbsp;':$tte->noskkgbl !!}</div>
                                <div class="text-left">{!! tglina($tte->tmtkgbl) !!}</div>
                                <div class="text-left">{!! $tte->mktkgbl." Tahun ".$tte->mkbkgbl." Bulan" !!}</div>
                                <div class="text-left">Rp. {!! number_format($tte->gkgbl) !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $tte->noskkgbb !!}</div>
                                <div class="text-left">{!! tglina($tte->tmtkgbb) !!}</div>
                                <div class="text-left">{!! $tte->mktkgbb." Tahun ".$tte->mkbkgbb." Bulan" !!}</div>
                                <div class="text-left">Rp. {!! number_format($tte->gkgbb) !!}</div>
                            </small>
                        </td>
                        <td class="text-center">
                            <?php
                            switch($tte->jnskgb){
                                case 1 : echo "OPD"; break;
                                case 2 : echo "BKPP"; break;
                                default: echo ""; break;
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            @if($tte->proses == 1)
                            <span style="color:green"><i class="fa fa-check-square" title="Selesai"/></span>
                            @else
                            <span style="color:red"><i class="fa fa-minus-square" title="Belum Sign"/></span>
                            @endif
                        </td>

                        <td class="center">
                            <a href="javascript:void(0)" class="btn btn-info preview_sk_tte" recstatus="{!! $tte->proses !!}" recid="{!! $tte->id !!}" recfile="{!! $tte->proses==1?asset('/efile/packages/upload/files/'.substr($tte->nip_pengusul,0,4).'/'.$tte->nip_pengusul.'/'.substr($tte->file_tte,9)):asset('storage/app/'.$tte->surat) !!}"><i class="fa fa-eye"></i> Preview</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    <!-- {!! ClaravelHelpers::btnPreviewAll() !!} -->
                    <!-- {!! ClaravelHelpers::btnDeleteAll() !!} -->

                    <button class='btn btn-success btn-sm preview_sk_all' style='display:none;' type='submit'><i class='fa fa-check-circle'></i> Preview Semua</button>
                    <!-- <button class='btn btn-warning btn-sm' style='display:none' id='preview_sk_all' type='submit'><i class='fa fa-times'></i> Preview Semuabb</button> -->
                </div>
                <div class="col-sm-6">
                    {!! $ttes->appends(array('status_tte' => Input::get('status_tte'), 'idgolru' => Input::get('idgolru'), 'idstspeg' => Input::get('idstspeg'), 'search' => Input::get('search')))->render(); !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>

<script>
var is_sending = false;

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
            $('.preview_sk_all').fadeIn(300);
        // $(".checknip").prop("checked");
        else
            $('.preview_sk_all').fadeOut(300);
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
            data: $(this).serialize(),
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
        preloader.on();
        var iki = $(this);
        claravel_modal('Preview SK TTE', 'Loading...', 'main_modal2');
        $.ajax({
            url  : '{{url('')}}/tte/kenaikangaji/modalpreviewkgb',
            type : 'get',
            data : iki.serialize(),
            success:function(response){
                preloader.off();
                $('#main_modal2 .modal-body').html(response);
            }
        });
    });


});

$('#preview_sk_all').on('click', function(e){
    e.preventDefault();

    var terpilih = new Array();
    $(":checkbox:checked").each(function() {
        terpilih.push($(this).val());
    });

    claravel_modal('Preview SK TTE','Loading...','main_modal2');
    // $('#main_modal2 .modal-body').html(terpilih);
    //
    $.ajax({
        type:'post',
        url : '{!!url()!!}/tte/kenaikangaji/data/previewkgb',
        data: {'id': terpilih, '_token' : '{!!csrf_token()!!}'},
        success:function(html){
            $('#main_modal2 .modal-body').html(html);
        }
    });

});

$('a.preview_sk_tte').on('click', function(e){
    e.preventDefault();
    claravel_modal('Preview SK TTE','Loading...','main_modal2');
    var file = $(this).attr('recfile');
    var id = $(this).attr('recid');
    var status = $(this).attr('recstatus');
    if(status == '1'){
        $('#main_modal2 .modal-body').html(
            '<embed src="'+file+'" type="application/pdf" width="100%" style="height: calc(100vh - 200px);"/>'
        );
    }else{
        $('#main_modal2 .modal-body').html(
            '<embed src="'+file+'" type="application/pdf" width="100%" style="height: calc(100vh - 200px);"/>'
                +'<div class="col-md-6  col-md-offset-3" style="text-align:center;"><input type="password" name="tte-passphrase" id="tte-passphrase" class="form-control tte-passphrase" placeholder="Passphrase" style="margin-bottom:5px; text-align:center;"/>'
                +'<a id="tte-kirim" href="#" class="btn btn-success" recid="'+id+'"><i class="fa  fa-key"></i> Tanda tangan</a></div>'
        );
    }
});

$('#main_modal2').on('click','#tte-kirim', function(e){
    e.preventDefault();
    var id = $(this).attr('recid');
    var passphrase = $('#main_modal2 #tte-passphrase').val();
    if(is_sending == false){
        is_sending = true;
        $.ajax({
            url : '{!!url()!!}/tte/kgb/sign',
            type : 'post',
            data: {'passphrase' : passphrase, 'id' : id, '_token' : '{!!csrf_token()!!}'},
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#main_modal2').modal('hide');
                $('#main_modal2 .modal-body').html('');
                if (html['code']==200) {
                    swal("Berhasil",html.message,'success');
                }else{
                    swal("Gagal",html.message,'error');
                }
                is_sending = false;
                $('#cari').trigger('submit');
            },
            complete:function(){
                is_sending = false;
            }
        });
    }
});
// $('#status_tte').on('change', function(e){
//     e.preventDefault();
//     $('#cari').trigger('submit');
// });
</script>
