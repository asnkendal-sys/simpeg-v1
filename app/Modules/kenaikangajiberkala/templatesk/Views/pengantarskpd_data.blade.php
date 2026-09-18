<script type="text/javascript">
    $(document).ready(function(){
        delete CKEDITOR.instances[ 'template' ];

        <?php if(session('role_id') <= 3){?>
            $('#persetujuan #idskpd').select2();
            $('#persetujuan #idskpd').on('change', function(e){
                e.preventDefault();
                var idskpd = $('#persetujuan #idskpd').val();
                var jnskgb = $('#persetujuan #jnskgb').val();

                $.ajax({
                    type : 'post',
                    url : '{!!url()!!}/kenaikangajiberkala/templatesk/surat',
                    data: {'idskpd':idskpd, 'jnskgb': jnskgb, '_token': '<?php echo csrf_token()?>'},
                    beforeSend:function(){
                        preloader.on();
                    },
                    success:function(response){
                        preloader.off();
                        var ret = $.parseJSON(response);
                        $('#persetujuan #name').val(ret.name);
                        $('#persetujuan #template').val(ret.template);
                    }
                });
            });
        <?php } ?>

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#persetujuan .ckeditor').ckeditor(config_pengantar);

        $('#persetujuan #form1').on('submit',function(e){
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
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#persetujuan #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/kenaikangajiberkala/templatesk/surat',
                data: {'idskpd':'all', 'jnskgb': '3', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#persetujuan #template').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/kenaikangajiberkala/templatesk/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">
                <div class="control-group">
                    <label class="control-label" >Unit Kerja</label>
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
                        <input type="hidden" name="jnskgb" class="jnskgb" id="jnskgb" value="3">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template" class="ckeditor" id="template" placeholder="Template Surat Perintah">
                            <?php
                                if(TemplateskModel::getTemplate(session('idskpd'), '3','template')=='0'){
                                    echo TemplateskModel::getTemplate('all', '3','template');
                                }else{
                                    echo TemplateskModel::getTemplate(session('idskpd'), '3','template');
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