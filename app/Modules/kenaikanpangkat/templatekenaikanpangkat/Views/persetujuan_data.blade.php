<script type="text/javascript">
    $(document).ready(function(){
        $('#persetujuan select').select2();

        delete CKEDITOR.instances[ 'template2' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#persetujuan .ckeditor').ckeditor(config_pengantar);

        $('#persetujuan #idskpd').on('change', function(e){
            e.preventDefault();
            if($('#persetujuan #idskpd').val() == ''){
                $('#persetujuan #idskpd').val('all');
            }else{
                var idskpd = $('#persetujuan #idskpd').val();
            }

            $.ajax({
                type : 'post',
                url: '{!!url()!!}/kenaikanpangkat/templatekenaikanpangkat/template',
                data: {'idskpd':idskpd, 'jnskp': $('#persetujuan #jnskp').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#persetujuan #template2').val(ret.template);
                }
            });
        })

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
                url : '{!!url()!!}/kenaikanpangkat/templatekenaikanpangkat/surat',
                data: {'idskpd':'all', 'jnskp': '1', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#persetujuan #template2').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/kenaikanpangkat/templatekenaikanpangkat/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">

                <div class="control-group">
                    <input type="hidden" name="idskpd" id="idskpd" class="idskpd" value="all">
                    <input type="hidden" name="jnskp" class="jnskp" id="jnskp" value="1">
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template2" class="ckeditor form-control" id="template2" placeholder="Template Pengantar OPD">
                            <?php
                            $cek = TemplatekenaikanpangkatModel::getTemplate(session('idskpd'), 1);
                            if($cek != '0'){
                                echo TemplatekenaikanpangkatModel::getTemplate(session('idskpd'), 1);
                            }else{
                                echo  TemplatekenaikanpangkatModel::getTemplate('all', 1);
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