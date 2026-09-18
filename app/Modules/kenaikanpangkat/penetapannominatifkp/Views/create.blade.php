<section class="content-header">
    <h1>
        Buat Penetapan Nominatif KP Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Penetapan Nominatif KP</a></li>
        <li class="active">Buat Penetapan Nominatif KP Baru</li>
    </ol>
</section>
<section class="content">
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai')) !!}
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Pilih nama skpd dan isikan bulan dan tahun Kenaikan Pangkat</li>
                        <li>Pilih tombol filter untuk melihat daftar nominatif Kenaikan Pangkat</li>
                        <li>Untuk menyimpan nominatif Kenaikan Pangkat pilih tombol simpan</li>
                    </ul>
                    " Penetapan nominatif digunakan melakukan penetapan Kenaikan Pangkat dengan ketentuan PNS yang akan naik pangkat berkalanya sudah ada di daftar nominatif "
                </div>

                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idjeniskp', 'Jenis KP:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! PenetapannominatifkpModel::comboJenisKpNominatif("idjeniskp","","") !!}
                        </div>
                    </div>
                    <div class="form-group" id="tampil_nopak">
                        {!! Form::label('nopak', 'PAK:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="filter_nopak" id="filter_nopak" placeholder="PAK" value="250">
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('bulan', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            <?php $rs = \DB::table('tr_kenaikan_pangkat_jadwal')->whereRaw("NOW() BETWEEN mulai AND selesai")->get(); ?>
                            @if(\Session::get('role_id')==1)
                            {!! PenetapannominatifkpModel::comboKp("bulan",$rs[0]->bulan,"") !!}
                            @else
                            {!! PenetapannominatifkpModel::comboCreateKp("bulan",$rs[0]->bulan,"") !!}
                            @endif
                        </div>
                        <div class="col-sm-2">
                            @if(\Session::get('role_id')==1)
                            {!! comboTahun("tahun",$rs[0]->tahun,"") !!}
                            @else
                            {!! PenetapannominatifkpModel::comboCreateTahun("tahun",$rs[0]->tahun,"") !!}
                            @endif
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
                        <li><a href="#" id="back"> Penetapan Nominatif KP</a></li>
                        <li>
                            {!! ClaravelHelpers::btnSave() !!}
                            {!! ClaravelHelpers::btnCancel() !!}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12">
                <div id="result" class="table-responsive"></div>
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

        $(".datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#nominatif-pegawai').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/create',
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

        $('#prev-nominatif').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/kenaikanpangkat/penetapannominatifkp/nominatif',
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

        $('#idjeniskp').on('change',function(e){
            e.preventDefault();
            if($('#idjeniskp').val() == 3){
                $('#tampil_nopak').show();
            }else{
                $('#tampil_nopak').hide();
            }
        }).trigger('change');
    });
</script>
