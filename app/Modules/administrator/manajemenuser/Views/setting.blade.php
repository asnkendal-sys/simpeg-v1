<script>
    
    $(document).ready(function(){
        $('select').select2();
        $('#datetimepicker1').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $('#datetimepicker2').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $(".datetime").mask("9999-99-99 99:99:99");

        $('#batalkan').on('click',function(e){
            e.preventDefault();
            claravel_modal_close('main_modal');
        });
        $('#form_setting').validationEngine();
        $('#form_setting').validationEngine('validate');
        $('#form_setting').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
                bootbox.confirm('Update Setting Jadwal ?',function(a){
                    if (a == true){
                        $.ajax({
                            url : $this.attr('action'),
                            type : 'POST',
                            data : $this.serialize(),
                            success:function(html){
                                if(html == '4'){
                                    notification('Setting Jadwal Berhasil');
                                    claravel_modal_close('main_modal');
                                    refresh_page();
                                }
                            }
                        });
                    }
                });

            }
        });
    });
</script>
<div>
    <b>PERHATIAN !</b>
    <ul style="padding: 10px">
        <li>Update ini berlaku kolektif untuk semua role</li>
        <li>Dan untuk unit kerja tertentu saja</li>
    </ul>
</div>
<div>
    {!! Form::open(array('url' => url().'/administrator/manajemenuser/savesetting', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_setting')) !!}
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('idskpd', 'Data Pengguna:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!ManajemenuserModel::comboPengguna("username")!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('aktif_mulai', 'Tanggal Aktif:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="datetime1" name="aktif_mulai" class="form-control datetime" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('aktif_selesai', 'Tanggal Selesai:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' id="datetime2" name="aktif_selesai" class="form-control datetime" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('keterangan', 'Keterangan:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!! Form::textarea('keterangan', 'Mohon maaf sessi login saat ini sudah ditutup. Login akan dibuka kembali sesuai jadwal oleh Admin. Terimakasih !', array('class'=> 'form-control', 'rows'=>'5', 'placeholder'=>'Keterangan sebagai notifikasi ketika login..', 'required'=>'required')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('', '', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!! ClaravelHelpers::btnSave() !!}
            </div>
        </div>

        <div style="height: 50px;"></div>
    </div>
    <hr>
    <div class="col-sm-offset-3 col-sm-7">

    </div>
    {!! Form::close() !!}
</div>
