<section class="content-header">
    <h1>
        Buat Perpanjangan Non Nominatif<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Perpanjangan Non Nominatif</a></li>
        <li class="active">Buat Perpanjangan Non Nominatif</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs tab1" id="myTab">
                <li class=""><a href="{!!url()!!}/pppk/perpanjangankontrak"> <i class="fa fa-fw fa-list-ul"></i> PENJAGAAN PERPANJANGAN PPPK</a></li>                
                <li class="active"><a href="{!!url()!!}/pppk/perpanjangankontrak/indexnominatif"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PERPANJANGAN PPPK</a></li>                
            </ul>

            <div class="callout callout-success">
                <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                <ul style="padding-left: 15px">
                    <li>Ketikkan NIP / Nama pada kolom isian, Kemudian akan tampil detail pegawai</li>
                    <li>Isikan atribut tanggal perpajangan awal dan akhir</li>
                    <li>Isian Nominatif dapat lebih dari 1 orang</li>
                    <li>Untuk menyimpan nominatif perpanjangan pilih tombol simpan</li>
                </ul>

                " Perpanjangan Non Nominatif digunakan melakukan penetapan perpanjangan kontrak pegawai PPPK diluar nominatif atau kondiis tertentu "
            </div>

            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <!--<div class="form-group">
                    <div class="col-sm-4">
                        {!! Form::hidden('tmtx', ((Input::get('rectglusul')!='')?date('d-m-Y', strtotime(Input::get('rectglusul'))):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                    </div>
                </div>-->
                <div class="form-group">
                    {!! Form::label('nip', 'NIP / Nama:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
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
                        <a id="batalkan" href="{!!url()!!}/pppk/perpanjangankontrak/indexnominatif" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</a>
                    </div>
                </div>
            </div>

            <div class="row" style="padding-left: 10px">
                <div class="span12" id="daftar-usul"></div>
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

        $('#batalkan,#back').on('click',function(e){
            var $this = $(this);
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/pppk/perpanjangankontrak/indexnominatif',
                type : 'GET',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");

        autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');

        $("#simpan .nip").on('change', function(e){
            e.preventDefault();
            if($("#simpan .nip").val() != ''){
                addList();
            }else{
                autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
            }
        });

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
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
                                    $('#batalkan,#back').trigger('click');
                                }else{
                                    notification(html,'danger');
                                }
                            }
                        });
                    }
                });
            }
        });

        function addList(){
            if($('#simpan .nip').val() != ''){
                if(isNaN(parseInt($('.nomi').attr('urutan')))){
                    count = 0;
                }else{
                    count = parseInt($('.nomi:last').attr('urutan'));
                }

                if(!$('#'+$('#simpan .nip').val()).html()){

                    $.ajax({
                        url:'{!!url()!!}/pppk/perpanjangankontrak/ceknominatif',
                        type:'post',
                        data:{ 'nip':$('#simpan .nip').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
                        success:function(response){
                            if(response == 1){
                                bootbox.alert('Data nominasi sudah diusulkan!');
                                $('#simpan .nip').empty();
                                autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                            }else{
                                bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                                    if(r===true){
                                        count += 1;
                                        $.ajax({
                                            url:'{!!url()!!}/pppk/perpanjangankontrak/view/nonnominatif',
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
                                    autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                                });
                            }
                        }
                    });
                }else{
                    $('#simpan .nip').empty();
                    bootbox.confirm("<b>Perhatian. </b>NIP/Nama sudah ada dalam daftar usulan sementara.", function(r) {
                        autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                    });
                }
            }else{
                $('#simpan .nip').empty();
                bootbox.confirm("<b>Perhatian. </b>Masukkan Nip / Nama", function(r) {
                    autoCompleteimg('#simpan .nip', '{{url()}}/pppk/pemberhentiankontrak/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                });
            }
        }
    });

    function cekBerkas(nip, urutan){
        $.ajax({
            url : '{{url('')}}/pppk/perpanjangankontrak/cekberkas',
            type : 'post',
            data : {
                'nip': nip,
                'sts_kontrak': 2,
                '_token': '{!!csrf_token()!!}'
            },
            success:function(html){
                if(html!=''){
                    $('.status'+urutan).prop('checked', false);
                    bootbox.alert('<b>Usulan tidak dapat diproses karena :</b> <br> '+html+' <br> Mohon melengkapi berkas usulan pada E-File - Menu Layanan.');
                    $('.status_berkas'+urutan).html(html);
                }else{
                    $('.status_berkas'+urutan).html('');
                }
            }
        });
    }
</script>
