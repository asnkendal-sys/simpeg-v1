<style type="text/css">
    .form-button-custom{
        top: 56px !important;
    }
</style>
<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Pemberhentian Kontrak PPPK<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Pemberhentian Kontrak PPPK</a></li>
        <li class="active">Buat Pemberhentian Kontrak PPPK Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/pppk/pemberhentiankontrak"> <i class="fa fa-fw fa-list-ul"></i> PENJAGAAN PEMBERHENTIAN PPPK</a></li>                    
                    <li class="active"><a href="{!!url()!!}/pppk/pemberhentiankontrak/indexnominatif"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PEMBERHENTIAN PPPK</a></li>                    
                </ul>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai')) !!}
                <div class="box box-primary">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-success">
                                <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                                <ul style="padding-left: 15px">
                                    <li>Pilih nama skpd dan isikan tahun Pemberhentian Kontrak</li>
                                    <li>Pilih tombol filter untuk melihat daftar nominatif Pemberhentian Kontrak</li>
                                    <li>Untuk menyimpan nominatif Pemberhentian Kontrak pilih tombol simpan</li>
                                </ul>
                                "Penetapan nominatif digunakan melakukan Pemberhentian Kontrak dengan ketentuan ASN yang akan Pemberhentian Kontrak, sudah memenuhi syarat pemberhentian."
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('bulan', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        {!! comboBulan("bulan",date('m'),"") !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! comboTahun("tahun",date('Y'),"") !!}
                                    </div>
                                </div>                                
                            </div>

                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-7">
                                        <button class="btn btn-success" type="button" id="prev-nominatif"><i class="fa fa-list-ul"></i> Filter Data</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-button-custom">
                                <ul class="breadcrumb pull-right">
                                    <li><a href="{!!url()!!}"> Dashboard</a></li>
                                    <li><a href="#" id="back"> Pemberhentian Kontrak PPPK</a></li>
                                    <li>
                                        {!! ClaravelHelpers::btnSave() !!}
                                        <a id="batalkan" href="{!!url()!!}/pppk/pemberhentiankontrak/indexnominatif" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</a>
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
                url : '{!!url()!!}/pppk/pemberhentiankontrak/indexnominatif',
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
                            url : '{!!url()!!}/pppk/pemberhentiankontrak/create',
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
            $.ajax({
                url : '{!!url()!!}/pppk/pemberhentiankontrak/data/nominatif_pemberhentian',
                type : 'post',
                data : $('#nominatif-pegawai').serialize(),
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Loading...');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });
    });
</script>
