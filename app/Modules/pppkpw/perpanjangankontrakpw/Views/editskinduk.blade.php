<?php 
    $rpppk = PerpanjangankontrakpwModel::whereRaw("status = 1 and sts_kontrak = 2 and MONTH(tr_pppkpw.tmtawal) = \"".Input::get('bulan')."\" and YEAR(tr_pppkpw.tmtawal) = \"".Input::get('tahun')."\"")->first();
 ?>
<div class="callout callout-success">
    <h4><i class="fa fa-info-circle"></i> PERHATIAN !</h4>
    <ul style="padding-left: 15px">
        <li>Update ini berlaku kolektif untuk tanggal dan tahun periode perpanjangan PPPK yang dipilih.</li>
        <li>Pastikan semua data pada periode perpanjangan sudah semuanya diusulkan</li>
        <li>Simpan Nomor SK Induk akan sekaligus melakukan generate nomor urut SK per pegawai yang diusulkan</li>
    </ul>    
</div>

<div>
    {!! Form::open(array('url' => url().'/pppkpw/perpanjangankontrakpw/simpanskinduk', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-sk-induk')) !!}    
    <input type="hidden" name="tipe" value="{!! Input::get('tipe') !!}">    
    <input type="hidden" name="id" value="{!! @$rpppk->id !!}">    
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('nosk', 'Nomor SK Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="nosk" id="nosk" class="form-control" placeholder="Nomor SK Induk" required value="{!! @$rpppk->nosk !!}">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('tgsk', 'Tanggal SK Induk:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="tgsk" name="tgsk" class="form-control datepicker" placeholder="yyyy-mm-dd" value="{!! @$rpppk->tgsk !!}" required/>
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

    $('#form-sk-induk').on('submit',function(e){
        e.preventDefault();
        var $this =$(this);
        bootbox.confirm('Simpan dan Generate Nomor Urut SK Induk?',function(a){
            if(a == true){
                $.ajax({
                    url : '{!! url('') !!}/pppkpw/perpanjangankontrakpw/simpanskinduk',
                    type : 'post',
                    data: $this.serialize(),
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
            }
        });
    });
</script>
