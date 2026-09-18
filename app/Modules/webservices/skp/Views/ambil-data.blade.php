<section class="content-header">
    <h1>
       Ambil Data Skp Dari Bkn<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Skp</a></li>
        <li class="active"> Ambil Data Skp Dari Bkn</li>
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
                        <li>Ketikkan Tahun Skp</li>
                        <li>Ketikkan Nama / Nip Pegawai</li>
                        <li>Klik tombol ambil data untuk menyimpan data skp bkn</li>
                    </ul>
                </div>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-listnominatif form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('nousul', 'Tahun :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!!comboTahun("tahun",Input::get('tahun'),"", "Tahun")!!}
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
                         <button id="save" type="submit" class="btn btn-primary" style="display: inline-block;"><i class="fa fa-floppy-o"></i>Ambil Data</button>
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
        $('#save').hide();
        $('select').select2();


        autoCompleteimg('.nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');

        $(".nip").on('change', function(e){
            e.preventDefault();
            bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                if(r===true){
                  $('#daftar-usul').empty()
                    $.ajax({
                        url:'{!!url()!!}/webservices/skp/listambilskp',
                        type:'get',
                        data:{ 'nip':$('.nip').val(), 'tahun':$('#tahun').val(),'_token' : '{!!csrf_token()!!}'},
                        beforeSend:function(){},
                        success:function(response){
                            $('#daftar-usul').append(response);


                            $("#save").show();
                            $('#simpan .nip').focus();
                        }
                    });
                }
            });

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
                       url: '{{url()}}/webservices/skp/save', //ganti biar gag nabrak
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

                        }else{
                            notification(html,'danger');
                        }
                        //bootbox.alert(html);
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
