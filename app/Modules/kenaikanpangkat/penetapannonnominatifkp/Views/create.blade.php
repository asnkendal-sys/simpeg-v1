<section class="content-header">
    <h1>
        Buat Penetapan Non Nominatif KP Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Penetapan Non Nominatif KP</a></li>
        <li class="active">Buat Penetapan Non Nominatif KP Baru</li>
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
                        <li>Isikan atribut Kenaikan Pangkat</li>
                        <li>Untuk menyimpan nominatif Kenaikan Pangkat pilih tombol simpan</li>
                    </ul>

                    " Penetapan non nominatif digunakan melakukan penetapan Kenaikan Pangkat dengan ketentuan PNS yang akan naik pangkatnya tidak ada di daftar nominatif atau non kenaikan pangkat reguler"
                </div>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('tmtx', 'TMT KP:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-3">
                            <?php
                            $rs = \DB::table('tr_kenaikan_pangkat_jadwal')->whereRaw("NOW() BETWEEN mulai AND selesai")->get();
                            $tmtx = "01-".$rs[0]->bulan."-".$rs[0]->tahun;
                            ?>
                            <input type="text" id="tmtx" name="tmtx" value="<?php echo $tmtx; ?>" class="form-control date" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idjeniskp', 'Jenis KP :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!!PenetapannonnominatifkpModel::comboJeniskp('idjeniskp','','required','idjeniskp',Input::get('n'))!!}
                        </div>
                    </div>
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
        //
        $('#idjeniskp').on('change',function(e){
            var idjeniskp=$(this).val();
            if(idjeniskp==3){
                autoCompleteimg('#simpan .nip', '{{url()}}/kenaikanpangkat/penetapannonnominatifkp/carifungsional', 'Ketikkan NIP atau Nama', null, '', '', '');
            }else{
                autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
            }
            
        });            
        //


        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");

        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', ''); //di header

        $("#simpan .nip").on('change', function(e){
            e.preventDefault();
            if($("#simpan .nip").val() != ''){
                addList();
            }else{
                autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
            }
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#idgolrupktb, #mktkpb').on('change',function(e){
            e.preventDefault();
            $.ajax({
                url  : '<?php echo url()?>/kenaikanpangkat/penetapannonnominatifkp/gaji',
                type : 'POST',
                data : {'idgolrupktb': $('#idgolrupktb').val(), 'mktkpb': $('#mktkpb').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#gkpb').val(html);
                }
            });
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
                    url:'{!!url()!!}/kenaikanpangkat/penetapannonnominatifkp/ceknominatif',
                    type:'post',
                    data:{ 'nip':$('#simpan .nip').val(), 'tmtx': $('#simpan #tmtx').val(), 'idjeniskp': $('#simpan #idjeniskp').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
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
                                        url:'{!!url()!!}/kenaikanpangkat/penetapannonnominatifkp/view/nonnominatif',
                                        type:'post',
                                        data:{ 'nip':$('#simpan .nip').val(), 'tmtx': $('#simpan #tmtx').val(), 'idjeniskp': $('#simpan #idjeniskp').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
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
                                $('#idjeniskp').trigger('change');
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
</script>
