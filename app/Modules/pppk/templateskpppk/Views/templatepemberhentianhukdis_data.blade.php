<script type="text/javascript">
    $(document).ready(function(){
        $('#templatepemberhentianhukdis select').select2();

        delete CKEDITOR.instances[ 'template11' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#templatepemberhentianhukdis .ckeditor').ckeditor(config_pengantar);        

        $('#templatepemberhentianhukdis #form1').on('submit',function(e){
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

        $('#templatepemberhentianhukdis #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/pppk/templateskpppk/surat',
                data: {'idskpd':'all', 'jnssurat': '11', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#templatepemberhentianhukdis #template11').val(ret.template);
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
                        <input type="text" name="nama" id="nama" class="nama form-control" value="{!!TemplateskpppkModel::getTitle('all', 11)!!}">
                    </div>
                </div>

                <div class="control-group">
                    <input type="hidden" name="idskpd" id="idskpd" class="idskpd" value="all">
                    <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="11">
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template11" class="ckeditor form-control" id="template11" placeholder="Template Petikan">
                            {!!TemplateskpppkModel::getTemplate('all', 11)!!}
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