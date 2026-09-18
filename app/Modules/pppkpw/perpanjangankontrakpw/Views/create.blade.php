<style type="text/css">
    .form-button-custom{
        top: 56px !important;
    }
</style>
<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Perpanjangan Kontrak PPPK PW<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Perpanjangan Kontrak PPPK</a></li>
        <li class="active">Buat Perpanjangan Kontrak PPPK Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/pppkpw/perpanjangankontrak"> <i class="fa fa-fw fa-list-ul"></i> PENJAGAAN PERPANJANGAN PPPK</a></li>                    
                    <li class="active"><a href="{!!url()!!}/pppkpw/perpanjangankontrak/indexnominatif"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PERPANJANGAN PPPK</a></li>                    
                </ul>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai')) !!}
                <div class="box box-primary">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-success">
                                <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                                <ul style="padding-left: 15px">
                                    <li>Pilih Nama Unit Kerja dan isikan Maksimal Tahun Perpanjangan Kontrak</li>
                                    <li>Pilih tombol Filter Data untuk melihat daftar nominatif Perpanjangan Kontrak</li>
                                    <li>Pada list data nominatif pilih data yang ingin diajukan perpanjangan atau tidak</li>
                                    <li>Pastikan data nominatif yang akan diusulkan sudah memiliki berkas PPPK PW dan Kinerja triwulan 1 dan  triwulan 2 tahun terakhir</li>
                                    <li>Untuk menyimpan nominatif Perpanjangan Kontrak pilih tombol Simpan</li>
                                </ul>
                                "Penetapan nominatif digunakan melakukan Perpanjangan Kontrak dengan ketentuan ASN yang akan Perpanjangan Kontrak, sudah memenuhi syarat perpanjangan."
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('bulan', 'TMT Akhir:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        {!! comboBulan("bulan",date('m'),"") !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! comboTahun("tahun",date('Y'),"") !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tahunperpanjangan', 'Maksimal Perpanjangan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        <!-- {!! comboTambahangka("tahunperpanjangan",1,"") !!} -->
                                    <input type="text" id="tahunperpanjangan" name="tahunperpanjangan" value="1" class="form-control" readonly>
                                    </div>
                                </div>
                                <div id="xperiode">
                                    <div class="form-group">
                                        <label for="tmtmulaiakhir_pppk" class="col-sm-3 control-label">TMT Perjanjian Kerja:</label>
                                        <div class="col-sm-2">
                                            <div class="input-group datepicker">
                                                <input class="form-control date" id="tmtmulaiakhir_pppk" placeholder="dd-mm-yyyy" name="tmtmulaiakhir_pppk" type="text">
                                                  <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-2">
                                            <div class="input-group datepicker">
                                                <input class="form-control date" id="tmtakhirakhir_pppk" placeholder="dd-mm-yyyy" name="tmtakhirakhir_pppk" type="text">
                                                  <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-7">
                                        <button class="btn btn-success" type="button" id="prev-nominatif"><i class="fa fa-list-ul"></i> Filter Data</button>
                                        &nbsp;&nbsp;
                                        <button class="btn btn-success" type="button" id="cetak-nominatif"><i class="fa fa-print"></i> Cetak Nominatif</button>
                                        &nbsp;&nbsp;
                                        <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download Excel</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-button-custom">
                                <ul class="breadcrumb pull-right">
                                    <li><a href="{!!url()!!}"> Dashboard</a></li>
                                    <li><a href="#" id="back"> Perpanjangan Kontrak PPPK</a></li>
                                    <li>
                                        {!! ClaravelHelpers::btnSave() !!}
                                        <a id="batalkan" href="{!!url()!!}/pppkpw/perpanjangankontrakpw/indexnominatif" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="result" class="table-responsive"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>

<style type="text/css">
    .form-button-custom {
        float: right;
        position: fixed;
        right: 0px;
        top: 155px;
        z-index : 2;
    }

    header, table, p {
        position : relative;
        z-index : 1;
    }
</style>

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
        $('select').select2();
        $('.date').mask("99-99-9999");
        $('#xperiode').hide();

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

        $('#bulan, #tahun, #tahunperpanjangan').on('change', function(e){
            e.preventDefault();
            var bulan = parseInt($('#bulan').val());
            var tahun = parseInt($('#tahun').val());
            var tahunperpanjangan = parseInt($('#tahunperpanjangan').val());
            var bulanperiode = bulan + 1;

            if(bulanperiode > 12){
                var bulanperpanjangan = ''+(bulanperiode - 12);
                var tahun = tahun + 1;
            }else if(bulanperiode < 10){
                var bulanperpanjangan = '0'+bulanperiode;
            }else{
                var bulanperpanjangan = ''+bulanperiode;
            }

            var bulanstr = parseInt(bulanperpanjangan.length);
            if($('#bulan').val() != '' && $('#tahun').val() != '' && $('#tahunperpanjangan').val() != ''){
                $('#xperiode').fadeIn();
                $('#tmtmulaiakhir_pppk').val('01-'+((bulanstr == 2)?bulanperpanjangan:'0'+bulanperpanjangan)+'-'+tahun);
                $('#tmtakhirakhir_pppk').val('01-'+((bulanstr == 2)?bulanperpanjangan:'0'+bulanperpanjangan)+'-'+(tahun+tahunperpanjangan));
            }else{
                $('#tmtmulaiakhir_pppk').val('');
                $('#tmtakhirakhir_pppk').val('');
                $('#xperiode').fadeOut();
            }
        })
        $('#batalkan,#back').on('click',function(e){
            var $this = $(this);
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/indexnominatif',
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
        $('#nominatif-pegawai').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
                bootbox.confirm('Simpan data?',function(a){
                    if (a == true){
                        $.ajax({
                            url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/create',
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

        $('#prev-nominatif').on('click', function(e){
            e.preventDefault();
            var tahun = $('#tahunperpanjangan').val();
            if(tahun){
                $.ajax({
                    url : '{!!url()!!}/pppkpw/perpanjangankontrakpw/data/nominatif_perpanjangan',
                    type : 'post',
                    data : $('#nominatif-pegawai').serialize(),
                    beforeSend:function(){
                        $('#result').html('<i class="fa fa-spinner"></i> Loading...');
                    },
                    success:function(response){
                        $('#result').html(response);
                    }
                });
            }else{
                bootbox.alert('<b>Perhatian!</b> Perpanjangan Tahun harus diisi.');
            }
        });

        $('#cetak-nominatif').on('click', function(e){            
            e.preventDefault();
            var tahun = $('#tahunperpanjangan').val();
            if(tahun){
                let form = $('#nominatif-pegawai');
                let url = '{!!url()!!}/pppkpw/perpanjangankontrakpw/print/nominatifusul';

                // Buat form baru
                let newForm = $('<form>', {
                    action: url,
                    method: 'POST',
                    target: '_blank'
                });

                // Tambahkan CSRF token
                let token = $('meta[name="csrf-token"]').attr('content');
                newForm.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: token
                }));

                // Salin nilai input dari form lama ke form baru
                form.find('input, select, textarea').each(function() {
                    let input = $(this);
                    let type = input.attr('type');
                    
                    // Hanya salin jika bukan tombol
                    if(type !== 'button' && type !== 'submit' && type !== 'reset'){
                        newForm.append($('<input>', {
                            type: 'hidden',
                            name: input.attr('name'),
                            value: input.val()
                        }));
                    }
                });

                // Tambahkan ke body dan submit
                $('body').append(newForm);
                newForm.submit();
                newForm.remove();
            } else {
                bootbox.alert('<b>Perhatian!</b> Perpanjangan Tahun harus diisi.');
            }
        });

        $('#excel-nominatif').on('click', function(e){
            e.preventDefault();
            var tahun = $('#tahunperpanjangan').val();
            if(tahun){
                let form = $('#nominatif-pegawai');
                let url = '{!!url()!!}/pppkpw/perpanjangankontrakpw/excel/nominatifusul';

                // Buat form baru
                let newForm = $('<form>', {
                    action: url,
                    method: 'POST',
                    target: '_blank'
                });

                // Tambahkan CSRF token
                let token = $('meta[name="csrf-token"]').attr('content');
                newForm.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: token
                }));

                // Salin nilai input dari form lama ke form baru
                form.find('input, select, textarea').each(function() {
                    let input = $(this);
                    let type = input.attr('type');
                    
                    // Hanya salin jika bukan tombol
                    if(type !== 'button' && type !== 'submit' && type !== 'reset'){
                        newForm.append($('<input>', {
                            type: 'hidden',
                            name: input.attr('name'),
                            value: input.val()
                        }));
                    }
                });

                // Tambahkan ke body dan submit
                $('body').append(newForm);
                newForm.submit();
                newForm.remove();
            } else {
                bootbox.alert('<b>Perhatian!</b> Perpanjangan Tahun harus diisi.');
            }
        });
    });
</script>
