<?php 
$rpppk = App\Models\PPPK\RPPPK::find(Input::get('id'));
 ?>
<div>
    @if(Input::get('tipe') == 'kolektif')
    <b>PERHATIAN !</b>
    <ul style="padding: 10px">
        <li>Update ini berlaku kolektif untuk tanggal dan Kode Unit tertentu</li>
    </ul>
    @endif
</div>
<div>
    {!! Form::open(array('url' => url().'/pppk/pengangkatankontrak/simpanspkinduk', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-spk-induk')) !!}
    <input type="hidden" name="tipe" value="{!! Input::get('tipe') !!}">
    <input type="hidden" name="id" value="{!! Input::get('id') !!}">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('no_spk_induk', 'Nomor SPK Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="no_spk_induk" id="no_spk_induk" class="form-control" value="{!! @$rpppk->no_spk_induk !!}">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('aktif_mulai', 'Tanggal SPK Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="tgl_spk_induk" name="tgl_spk_induk" class="form-control datepicker" value="{!! @$rpppk->tgl_spk_induk !!}" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#datetimepicker1').datetimepicker({format: 'YYYY-MM-DD'});
        $(".datepicker").mask("9999-99-99");
    });

    $('#form-spk-induk').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url : '{!! url('') !!}/pppk/pengangkatankontrak/simpanspkinduk',
            type : 'post',
            data: $(this).serialize(),
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                if(html=='1'){
                    notification('Berhasil Disimpan','success');
                    $this.closest('tr').fadeOut(300,function(){
                        $(this).remove();
                    });
                }else{
                    notification('Gagal Disimpan','danger');
                }
            }
        });
    });
</script>