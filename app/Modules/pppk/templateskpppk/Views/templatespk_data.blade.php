<script type="text/javascript">
    $(document).ready(function(){
        $('#templatespk select').select2();

        delete CKEDITOR.instances[ 'template3' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#templatespk .ckeditor').ckeditor(config_pengantar);        

        $('#templatespk #form1').on('submit',function(e){
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

        $('#templatespk #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/pppk/templateskpppk/surat',
                data: {'idskpd':'all', 'jnssurat': '3', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#templatespk #template3').val(ret.template);
                }
            });
        });
    });
</script>

<div class="row-fluid">
    <form id="form1" name="form1" class="form-horizontal" action="{!!url()!!}/pppk/templateskpppk/savetemplate" method="post">
        {!!csrf_field()!!}
        <div class="span12">
            <div class="accordion-heading">

                <div class="control-group">
                    <label class="control-label" for="nama">Judul</label>
                    <div class="controls">
                        <input type="text" name="nama" id="nama" class="nama form-control" value="{!!TemplateskpppkModel::getTitle('all', 3)!!}">
                    </div>
                </div>

                <div class="control-group">
                    <input type="hidden" name="idskpd" id="idskpd" class="idskpd" value="all">
                    <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="3">
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template3" class="ckeditor form-control" id="template3" placeholder="Template SPK">
                            {!!TemplateskpppkModel::getTemplate('all', 3)!!}
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