<script type="text/javascript">
    $(document).ready(function(){
        delete CKEDITOR.instances[ 'templatecuti2' ];

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };
        <?php if(\Session::get('role_id') <= 3){?>
            $('#izinsementara #idskpd').select2();
            $('#izinsementara #idskpd').on('change', function(e){
                e.preventDefault();
                var idskpd = $('#izinsementara #idskpd').val();
                var jnssurat = $('#izinsementara #jnssurat').val();

                $.ajax({
                    type : 'post',
                    url : '{!!url()!!}/ecuti/templateizinsementara/surat',
                    data: {'idskpd':idskpd, 'jnssurat': jnssurat, '_token': '<?php echo csrf_token()?>'},
                    beforeSend:function(){
                        preloader.on();
                    },
                    success:function(response){
                        preloader.off();
                        var ret = $.parseJSON(response);
                        $('#izinsementara #name').val(ret.name);
                        $('#izinsementara #template').val(ret.template);
                    }
                });
            });
        <?php } ?>

        $('#izinsementara .ckeditor').ckeditor(config_pengantar);

        $('#izinsementara #form2').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan template data ..?',function(a){
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
                            if(html=='4'){
                                notification('Berhasil Disimpan','success');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#izinsementara #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/ecuti/templateizinsementara/surat',
                data: {'idskpd':'all', 'jnssurat': '1.2', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#izinsementara #templatecuti2').val(ret.template);
                }
            });
        });
    });
</script>
<div class="row-fluid">
    <form id="form2" name="form2" class="form-horizontal" action="{!!url()!!}/ecuti/templateskcuti/savetemplatecuti" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">
                <div class="control-group">
                    <label class="control-label" for="jnssurat">Unit Kerja</label>
                    @if(\Session::get('role_id') <= 3)
                    <div class="controls">
                        {!!comboSkpd("idskpd","","",\Session::get('idskpd'))!!}
                    </div>
                    @else
                    <div class="controls">
                        <input type='text' class='form-control' name='skpd' value="{!!getSkpd(\Session::get('idskpd'))!!}" disabled style='width: 75%; display: inline;'>
                        <input type='hidden' name='idskpd' id='idskpd' value="{!!\Session::get('idskpd')!!}">
                        <a href="javascript:void(0)" class="btn btn-warning" id="defaultthem"><i class="fa fa-refresh"></i> Default Template</a>
                    </div>
                    @endif
                    <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="1.2">
                </div>

                <div class="control-group">
                    <label class="control-label" for="jnssurat">Nama Surat</label>
                    <div class="controls">
                        <input type="text" name="nama" class="nama input-xxlarge form-control" id="nama" value="<?php echo TemplateskcutiModel::getTemplatecuti('all', '1.2','nama')?>"> </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="templatecuti2">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="templatecuti2" class="ckeditor" id="templatecuti2" placeholder="Template Formulir Permintaan Dan Pemberian Cuti">
                          <?php
                          if(TemplateskcutiModel::getTemplatecuti(\Session::get('idskpd'), '1.2','template')=='0'){
                            echo TemplateskcutiModel::getTemplatecuti('all', '1.2','template');
                        }else{
                            echo TemplateskcutiModel::getTemplatecuti(\Session::get('idskpd'), '1.2','template');
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
        <div id="result"></div>
    </div>
</form>

</div>