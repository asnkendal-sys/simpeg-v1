<section class="content-header">
    <h1>
        Buat Penjadwalan KP<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Penjadwalan KP</a></li>
        <li class="active">Buat Penjadwalan KP</li>
    </ol>
</section>
<section class="content">
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'jadwal-kp')) !!}
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <!-- content -->
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('tahun', 'Periode Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            {!! comboTahun("tahun",date('Y'),"") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('bulan', 'Periode Bulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            {!! PenetapannominatifkpModel::comboKp("bulan","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('mulai', 'Awal Pengusulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            <div class='input-group datetimepicker'>
                                {!! Form::text('mulai', null, array('class'=> 'form-control datetime', 'placeholder'=>'Awal Pengusulan')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('selesai', 'Akhir Pengusulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            <div class='input-group datetimepicker'>
                                {!! Form::text('selesai', null, array('class'=> 'form-control datetime', 'placeholder'=>'Akhir Pengusulan')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('keterangan', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            {!! Form::text('keterangan', null, array('class'=> 'form-control', 'placeholder'=>'Keterangan')) !!}
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            <!-- <button class="btn btn-success" type="submit" id=""><i class="fa fa-list-ul"></i> Simpan</button> -->
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>

<script>
    $(document).ready(function(){
        $("#jadwal-kp .datetime").mask("9999-99-99 99:99:99");
        $("#jadwal-kp .datetimepicker").datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#jadwal-kp').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : '{!!url()!!}/kenaikanpangkat/penjadwalankp/create',
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
</script>
