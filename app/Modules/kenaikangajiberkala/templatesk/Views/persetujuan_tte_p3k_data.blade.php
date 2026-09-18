<script type="text/javascript">
    $(document).ready(function(){
        $('#persetujuan select').select2();

        delete CKEDITOR.instances[ 'template2' ];
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
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/kenaikangajiberkala/templatesk/savetemplate" method="post" target="_blank">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">
                <input type="hidden" name="idskpd" value="all">
                <input type="hidden" name="jnskgb" value="5">

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template2" class="ckeditor form-control" id="template2" placeholder="Template SK KGB PPPK">
                            <?php
                            echo TemplateskModel::getTemplate('all', 5);
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