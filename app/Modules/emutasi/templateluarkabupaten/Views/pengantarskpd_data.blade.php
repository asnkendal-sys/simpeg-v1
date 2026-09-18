<script type="text/javascript">
    $(document).ready(function(){
        delete CKEDITOR.instances[ 'template' ];

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

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

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
                url : '{!!url()!!}/emutasi/templateluarkabupaten/surat',
                data: {'idskpd':'all', 'jnssurat': '3.1', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#pengantarskpd #template').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/emutasi/templateluarkabupaten/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">
                <div class="control-group">
                    <label class="control-label" for="jnssurat">Unit Kerja</label>
                    <div class="controls">
                        <?php
                            if(session('role_id') <= 3){
                                echo comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'))."&nbsp;";
                            }else{
                                echo "<input type='text' class='input-xxlarge form-control' name='skpd' value=\"".getSkpd(session('idskpd'))."\" disabled style='width: 75%; display: inline;'></span>";
                                echo "<input type='hidden' name='idskpd' id='idskpd' value=\"".session('idskpd')."\">&nbsp;";
                                echo '<a href="javascript:void(0)" class="btn btn-warning" id="defaultthem"><i class="fa fa-refresh"></i> Default Template</a>';
                            }
                        ?>
                        <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="3.1">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="jnssurat">Nama Surat</label>
                    <div class="controls">
                        <input type="text" name="nama" class="nama input-xxlarge form-control" id="nama" value="<?php echo TemplateluarkabupatenModel::getTemplate('all', '3.1','nama')?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template" class="ckeditor" id="template" placeholder="Template Surat Perintah">
                            <?php
                                if(TemplateluarkabupatenModel::getTemplate(session('idskpd'), '3.1','template')=='0'){
                                    echo TemplateluarkabupatenModel::getTemplate('all', '3.1','template');
                                }else{
                                    echo TemplateluarkabupatenModel::getTemplate(session('idskpd'), '3.1','template');
                                }
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <br><button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
            <div id="result"></div>
        </div>
    </form>

</div>