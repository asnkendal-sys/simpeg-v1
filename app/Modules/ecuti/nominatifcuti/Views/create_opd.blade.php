<section class="content-header">
    <h1>
        Buat Nominatif Cuti Baruuu<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatif Cuti OPD</a></li>
        <li class="active">Buat Nominatif Cuti OPD Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <!-- <li>Isiakan tanggal usulan</li> -->
                        <li>Ketikkan Nama / Nip Pegawai yang akan diusulkan cuti</li>
                        <li>Isikan antribut usulan cuti pada list pegawai yang diusulkan</li>
                        <li>Isian Nominatif dapat lebih dari 1 orang</li>
                        <li>Tekan NIP untuk melihat kuota dan riwayat cuti pegawai yang di usulkan</li>
                        <li>Klik tombol simpan untuk menyimpan usulan</li>
                    </ul>
                </div>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-listnominatif form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('tgl_usul', 'Tanggal Usul :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-3">
                            <div class='input-group datepicker'>
                                {!! Form::text('tgl_usul', ((Input::get('rectglusul')!='')?date('d-m-Y', strtotime(Input::get('rectglusul'))):date('d-m-Y')), array('class'=> 'form-control tgl_usul date', 'placeholder'=>'dd-mm-yyyy',((Input::get('rectglusul')!='')?'readonly':''))) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nousul', 'No Usulan :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!! Form::text('nousul', ((Input::get('recnousul')!='')?Input::get('recnousul'):''), array('class'=> 'form-control nousul', 'placeholder'=>'No. Usulan Otomatis', 'readonly'=>'readonly' )) !!}
                            <!-- <input type="hidden" name="nousul" value="{!!(Input::get('recnousul')!='')?Input::get('recnousul'):''!!}" id="nousul" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nip', 'NIP / Nama :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            <select name="nip" class="form-control nip" id="nip" style="width: 100%"></select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
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
    var adaNipTerpilih = 0;
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
            format: 'DD-MM-YYYY',
            locale: 'id'
        });
        $("#simpan .date").mask("99-99-9999");

        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');

        $("#simpan .nip").on('change', function(e){
            e.preventDefault();
            if($("#simpan .nip").val() != ''){
                $.ajax({
                 url:'{!!url()!!}/ecuti/nominatifcuti/ceknippadanousul',
                 type : 'POST',
                 data:{ 
                  'nousul'  :$('#simpan .nousul').val(),
                  'nip'  :$('#simpan .nip').val(),
                  '_token'  : '{!!csrf_token()!!}' },
                  beforeSend:function(){
                   preloader.on();
               },
               success:function(response){
                   preloader.off();
                   var ret = $.parseJSON(response);
                   adaNipTerpilih = ret.ceknip;

                   if (adaNipTerpilih == 0){
                    addList();
                }else{
                    alert("NIP Yang dipilih sudah ada pada daftar usulan sementara");
                    $('#simpan .nip').empty();
                    autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                }
            }
        });   
            }else{
                autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
            }
        });

        $('.form-listnominatif').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    if ($(".unvalid")[0]){
                        bootbox.alert("<center><b>.: PERHATIAN :.</b> <br>Periksa Ulang Usulan Nominatif Cuti <i class='glyphicon glyphicon-exclamation-sign kedip' style='color:red;' title='Tidak Dapat Disimpan'></i></center>");
                    }else{
                        $.ajax({
                       url: '{{url()}}/ecuti/nominatifcuti/simpannominatif', //ganti biar gag nabrak
                       type : 'POST',
                       data : $this.serialize(),
                       beforeSend: function(){
                        preloader.on();
                    },
                    success:function(html){
                        preloader.off();
                        if(html==1){
                            notification('Berhasil Disimpan','success');
                            refresh_page();
                        }else if(html!=1 && html!=0){
                            notification(html,'danger');
                            refresh_page();
                        }else if(html== 0){
                            notification(html,'danger');
                        }
                        // bootbox.alert(html);
                    }
                });
                    }
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
                                url:'{!!url()!!}/ecuti/nominatifcuti/view/listnominatif',
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
