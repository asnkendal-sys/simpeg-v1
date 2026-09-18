<section class="content-header">
    <h1>
        Buat Nominatif Pensiun Non BUP<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatif Pensiun Non BUP</a></li>
        <li class="active">Buat Nominatif Pensiun Non BUP</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                <ul style="padding-left: 15px">
                    <li>Ketikkan NIP / Nama pada kolom isian, Kemudian akan tampil detail pegawai</li>
                    <li>Isikan atribut pensiun APS/JADUD/UZUR/TEWAS/PDHTAPS</li>
                    <li>Isian Nominatif dapat lebih dari 1 orang</li>
                    <li>Untuk menyimpan nominatif pensiun pilih tombol simpan</li>
                </ul>

                " Penetapan pensiun NON BUP digunakan melakukan penetapan pensiun dengan ketentuan PNS yang pensiun Atas Permintaan Sendiri/Janda/Duda/Keuzuran/Tewas/Pemberhentian Dengan Hormat Tidak Atas Permintaan Sendiri "
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
                        {!! ClaravelHelpers::btnCancel() !!}
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
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
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

                    $.ajax({
                        url:'{!!url()!!}/epensiun/nominatifpensiun/ceknominatif',
                        type:'post',
                        data:{ 'nip':$('#simpan .nip').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
                        success:function(response){
                            if(response == 1){
                                bootbox.alert('Data nominasi sudah diusulkan!');
                                $('#simpan .nip').empty();
                                autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                            }else{
                                bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                                    if(r===true){
                                        count += 1;
                                        $.ajax({
                                            url:'{!!url()!!}/epensiun/nominatifpensiun/view/nonnominatif',
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
                            }
                        }
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
