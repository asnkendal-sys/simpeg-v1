
<script type="text/javascript">
    $(document).ready(function(){        
        delete CKEDITOR.instances[ 'template8' ];

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#skperintah .ckeditor').ckeditor(config_pengantar);

        $("#skperintah #form1").on('submit',function(e){
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

        $('#skperintah #defaultthem').click(function(){
            $.ajax({
                type : 'post',
                url: '{!!url()!!}/emutasi/templateskpengantar/surat',
                data: {'idskpd':'all', 'jnssurat': '2.8', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#skperintah #template8').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/emutasi/templateskpengantar/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">

                <input type="hidden" name="idskpd" class="idskpd" id="idskpd" value="all">

                <div class="control-group">
                    <label class="control-label" for="jnssurat">Nama Surat</label>
                    <div class="controls">
                        <input type="text" name="nama" class="nama input-xxlarge form-control" id="nama" value="<?php echo TemplateskpengantarModel::getTemplate('all', '2.8','nama')?>">
                <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="2.8">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="template8">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template8" class="ckeditor" id="template8" placeholder="Template Surat Perintah">
                            <?php
                                if(TemplateskpengantarModel::getTemplate(session('idskpd'), '2.8','template')=='0'){
                                    echo TemplateskpengantarModel::getTemplate('all', '2.8','template');
                                }else{
                                    echo TemplateskpengantarModel::getTemplate(session('idskpd'), '2.8','template');
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