{!! Form::open(array('url' => url()."/kenaikangajiberkala/mastergaji/mastergaji", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan_mastergaji')) !!}
<div class="box-body">
    <div class="form-group">
        <input type = "hidden" name = "idstspeg" value = "<?php echo Input::get('idstspeg'); ?>" />
        {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-7">
            @if(Input::get('idstspeg')==2)
                {!! \MastergajiModel::comboMastergaji("tahun",\MastergajiModel::getTahunkgb(),"") !!}
            @else
                {!! \MastergajiModel::comboMasterGajiP3k("tahun",\MastergajiModel::getTahunkgb(),"") !!}
            @endif
        </div>
    </div>

</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <button id="mastergaji" type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
            &nbsp;
            &nbsp;
            <a id="batalkan_mastergaji" href="javascript:void(0)" class="btn btn-warning " onclick="claravel_modal_close('main_modal')"><i class="fa fa-times-circle-o"></i> Batalkan</a>
        </div>
    </div>
</div>
{!! Form::close() !!}


<script>
    $(document).ready(function(){
        $('#batalkan_mastergaji').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan_mastergaji').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Ubah Master Gaji ?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action') ,
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
                                notification('Berhasil Disimpan','success');
                                claravel_modal_close('main_modal')
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