
<script type="text/javascript">
    $(document).ready(function(){
        delete CKEDITOR.instances[ 'template3' ];

        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#pengantarbkd .ckeditor').ckeditor(config_pengantar);

        $("#pengantarbkd #form1").on('submit',function(e){
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

        $('#pengantarbkd #defaultthem').click(function(){
            $.ajax({
                type : 'post',
                url: '{!!url()!!}/emutasi/templateskpengantar/surat',
                data: {'idskpd':'all', 'jnssurat': '2.3', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#pengantarbkd #template3').val(ret.template);
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
                <div class="control-group">
                    <label class="control-label" for="jnssurat">Nama Surat</label>
                    <div class="controls">
                        <input type="text" name="nama" class="nama input-xxlarge form-control" id="nama" value="<?php echo TemplateskpengantarModel::getTemplate('all', '2.3','nama')?>">
                        <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="2.3">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="template3">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template3" class="ckeditor" id="template3" placeholder="Template Surat Perintah">
                            <?php
                            if(TemplateskpengantarModel::getTemplate(session('idskpd'), '2.3','template')=='0'){
                                echo TemplateskpengantarModel::getTemplate('all', '2.3','template');
                            }else{
                                echo TemplateskpengantarModel::getTemplate(session('idskpd'), '2.3','template');
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