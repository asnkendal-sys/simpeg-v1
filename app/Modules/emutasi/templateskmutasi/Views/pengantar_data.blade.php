<script type="text/javascript">
    $(document).ready(function(){
        delete CKEDITOR.instances[ 'template' ];

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        <?php if(session('role_id') <= 3){?>
            $('#pengantarskpd #idskpd').select2();
            $('#pengantarskpd #idskpd').on('change', function(e){
                e.preventDefault();
                var idskpd = $('#pengantarskpd #idskpd').val();
                var jnssurat = $('#pengantarskpd #jnssurat').val();

                $.ajax({
                    type : 'post',
                    url : '{!!url()!!}/emutasi/templateluarkabupaten/surat',
                    data: {'idskpd':idskpd, 'jnssurat': jnssurat, '_token': '<?php echo csrf_token()?>'},
                    beforeSend:function(){
                        preloader.on();
                    },
                    success:function(response){
                        preloader.off();
                        var ret = $.parseJSON(response);
                        $('#pengantarskpd #name').val(ret.name);
                        $('#pengantarskpd #template').val(ret.template);
                    }
                });
            });
        <?php } ?>

        $('#pengantarskpd .ckeditor').ckeditor(config_pengantar);

        $('#pengantarskpd #form1').on('submit',function(e){
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

        $('#pengantarskpd #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/emutasi/templateskmutasi/surat',
                data: {'idskpd':'all', 'jnssurat': '1.2', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#pengantarskpd #template4').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/emutasi/templateskmutasi/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">
                <div class="control-group">
                    <label class="control-label" for="jnssurat">Unit Kerja</label>
                    @if(Session::get('role_id') <= 3)
                    <div class="controls">
                        {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                    </div>
                    @else
                    <div class="controls">
                        <input type='text' class='form-control' name='skpd' value="{!!getSkpd(Session::get('idskpd'))!!}" disabled style='width: 75%; display: inline;'>
                        <input type='hidden' name='idskpd' id='idskpd' value="{!!Session::get('idskpd')!!}">
                        <a href="javascript:void(0)" class="btn btn-warning" id="defaultthem"><i class="fa fa-refresh"></i> Default Template</a>
                    </div>
                    @endif
                    <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="1.1">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="jnssurat">Nama Surat</label>
                <div class="controls">
                    <input type="text" name="nama" class="nama input-xxlarge form-control" id="nama" value="<?php echo TemplateskmutasiModel::getTemplate('all', '1.1','nama')?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="template">Template</label>
                <div class="controls">
                    <textarea rows="10" cols="600" name="template" class="ckeditor" id="template" placeholder="Template Surat Pengantar">
                        <?php
                        $cek = TemplateskmutasiModel::getTemplate(session('idskpd'), '1.1','template');
                        if($cek != '0'){
                            echo TemplateskmutasiModel::getTemplate(session('idskpd'),'1.1','template');
                        }else{
                            echo  TemplateskmutasiModel::getTemplate('all', '1.1','template');
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