<?php 
if(Input::get('tipe') == 'all'){
    $rpppk = PerpanjangankontrakModel::whereRaw("sts_kontrak = 2 and MONTH(tr_pppk.tmtawal) = \"".Input::get('bulan')."\" and YEAR(tr_pppk.tmtawal) = \"".Input::get('tahun')."\"")->first();
}else if(Input::get('tipe') == 'kolektif'){
    $rpppk = PerpanjangankontrakModel::where('id', Input::get('id'))->where('sts_kontrak', 2)->first();
}
 ?>
<div>
    @if(Input::get('tipe') == 'all' or Input::get('tipe') == 'kolektif')
    <b>PERHATIAN !</b>
    <ul style="padding: 10px">
        <li>Update ini berlaku kolektif untuk tanggal dan Kode Unit kerja sesuai dengan instansi induk yang dipilih</li>
    </ul>
    @endif
</div>
<div>
    {!! Form::open(array('url' => url().'/pppk/perpanjangankontrak/simpanspinduk', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-sp-induk')) !!}
    <input type="hidden" name="tipe" value="{!! Input::get('tipe') !!}">
    @if(Input::get('tipe') == 'all')
    <input type="hidden" name="id" value="{!! @$rpppk->id !!}">
    @else
    <input type="hidden" name="id" value="{!! Input::get('id') !!}">
    @endif
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('no_sp_induk', 'Nomor SP Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="no_sp_induk" id="no_sp_induk" class="form-control" value="{!! @$rpppk->no_sp_induk !!}">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('aktif_mulai', 'Tanggal SP Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="tgl_sp_induk" name="tgl_sp_induk" class="form-control datepicker" value="{!! @$rpppk->tgl_sp_induk !!}" required/>
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

    $('#form-sp-induk').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url : '{!! url('') !!}/pppk/perpanjangankontrak/simpanspinduk',
            type : 'post',
            data: $(this).serialize(),
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                if(html=='1'){
                    notification('Berhasil Disimpan','success');
                    claravel_modal_close('main_modal')
                }else{
                    notification('Gagal Disimpan','danger');
                }
            }
        });
    });
</script>