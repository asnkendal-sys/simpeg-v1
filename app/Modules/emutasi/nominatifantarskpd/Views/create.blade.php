<?php
$requi="jos"; 
if(session::get('role_id')==4){
    $requi="Required";
    $required="1";
}
?>
<section class="content-header">
    <h1>
        Buat Nominatif Antar OPD Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatif Antar OPD</a></li>
        <li class="active">Buat Nominatif Antar OPD Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Isiakan tanggal usulan</li>
                        <li>Ketikkan Nama / Nip Pegawai yang akan diusulkan mutasi</li>
                        <li>Isikan antribut usulan mutasi pada list pegawai yang diusulkan</li>
                        <li>Isian Nominatif dapat lebih dari 1 orang</li>
                        <li>Klik tombol simpan untuk menyimpan usulan</li>
                    </ul>
                </div>
                
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="col-md-5">
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('tmtx', 'Tanggal Usul :', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtx', ((Input::get('rectglusul')!='')?date('d-m-Y', strtotime(Input::get('rectglusul'))):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nousulx', 'No Usulan :', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('nousulx', ((Input::get('recnousul')!='')?Input::get('recnousul'):''), array('class'=> 'form-control', 'placeholder'=>'No. Usulan Otomatis', 'readonly'=>'readonly' )) !!}
                                <input type="hidden" name="nousul" value="{!!(Input::get('recnousul')!='')?Input::get('recnousul'):''!!}" id="nousul" />
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP / Nama :', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                <select name="nip" class="form-control nip" id="nip" style="width: 100%" ></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-7">
                                {!! ClaravelHelpers::btnSave() !!}
                                &nbsp;
                                &nbsp;
                                {!! ClaravelHelpers::btnCancel() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('no_suratrek', 'No Surat Rekomendasi :', array('class' => 'col-sm-5 control-label')) !!}
                            <div class="col-sm-7">
                                <input type="text" name="no_suratrek" class="form-control" id="no_surat" 
                                value="{!!(Input::get('recnosuratrek')!='')?Input::get('recnosuratrek'):''!!}" style="width: 100%" {!! $requi !!}>
                                <!-- @if(session::get('role_id')<=3)<em><b>Harap di Kosongkan Jika Input Untuk Penyegaran</b></em>@endif -->
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('surat_dari', 'Asal Surat Rekomendasi :', array('class' => 'col-sm-5 control-label')) !!}
                            <div class="col-sm-7">
                               {!! comboAsalMutasi("surat_dari",Input::get('recsuratdari'),"",session('idskpd')) !!} 
                               <!-- <input type="text" name="surat_dari" class="form-control" id="surat_dari" value="{!!(Input::get('recsuratdari')!='')?Input::get('recsuratdari'):''!!}" style="width: 100%"> -->
                               <!-- @if(session::get('role_id')<=3)<em><b>Harap di Kosongkan Jika Input Untuk Penyegaran</b></em>@endif -->
                           </div>
                       </div>
                       <div class="form-group">
                        {!! Form::label('tgl_suratrek', 'Tanggal Surat Rekomendasi :', array('class' => 'col-sm-5 control-label')) !!}
                        <div class="col-sm-7">
                            <div class='input-group datepicker'>
                                {!! Form::text('tgl_suratrek', ((Input::get('rectglsurat')!='')?date('d-m-Y', strtotime(Input::get('rectglsurat'))):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy', $requi => '')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <!-- @if(session::get('role_id')<=3)<em><b>Harap di Kosongkan Jika Input Untuk Penyegaran</b></em>@endif -->
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('perihalrek', 'Perihal Surat Rekomendasi :', array('class' => 'col-sm-5 control-label', $requi => '')) !!}
                        <div class="col-sm-7">
                            <input type="text" name="perihalrek" class="form-control" id="perihalrek" value="{!!(Input::get('recperihalrek')!='')?Input::get('recperihalrek'):''!!}" style="width: 100%" {!! $requi !!}>
                            <!-- @if(session::get('role_id')<=3)<em><b>Harap di Kosongkan Jika Input Untuk Penyegaran</b></em>@endif -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-left: 10px">
                <div class="span12" id="daftar-usul"></div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
</section>

<script>
    function refresh_page(){
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) -1;
        unset ($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/'.$index.'";';
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
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".tgl").mask("99-99-9999");
        $("#simpan .date").mask("99-99-9999");

        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');

        $("#simpan .nip").on('change', function(e){
            e.preventDefault();
            if($("#simpan .nip").val() != ''){
                addList();
            }else{
                autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
            }
        });

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        function addList(){
            if($('#simpan .nip').val() != ''){
                if(isNaN(parseInt($('.nomi').attr('urutan')))){
                    count = 0;
                }else{
                    count = parseInt($('.nomi:last').attr('urutan'));
                }

                if(!$('#'+$('#simpan .nip').val()).html()){
                    bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                        if(r===true){
                            count += 1;
                            $.ajax({
                                url:'{!!url()!!}/emutasi/nominatifantarskpd/view/antarskpd',
                                type:'post',
                                data:{ 'nip':$('#simpan .nip').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
                                beforeSend:function(){},
                                success:function(response){
                                    $('#daftar-usul').append(response);

                                    $('.remove_item').on('click', function(ev)
                                    {
                                        if (ev.type == 'click')
                                        {
                                            $(this).parents("#daftar-usul .nomi").fadeOut();
                                            $(this).parents("#daftar-usul .nomi").remove();
                                        }
                                    });

                                    $('#simpan .nip').focus();
                                }
                            });
                        }

                        $('#simpan .nip').empty();
                        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                    });
                }else{
                    $('#simpan .nip').empty();
                    bootbox.confirm("<b>Perhatian. </b>NIP/Nama sudah ada dalam daftar usulan sementara.", function(r) {
                        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                    });
                }
            }else{
                $('#simpan .nip').empty();
                bootbox.confirm("<b>Perhatian. </b>Masukkan Nip / Nama", function(r) {
                    autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                });
            }
        }
    });
</script>
