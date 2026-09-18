<script type="text/javascript">
    $(document).ready(function(){
        $('#templatepetikanperpanjangan select').select2();

        delete CKEDITOR.instances[ 'template7' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#templatepetikanperpanjangan .ckeditor').ckeditor(config_pengantar);        

        $('#templatepetikanperpanjangan #form1').on('submit',function(e){
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

        $('#templatepetikanperpanjangan #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/pppk/templateskpppk/surat',
                data: {'idskpd':'all', 'jnssurat': '7', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#templatepetikanperpanjangan #template7').val(ret.template);
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
                        <input type="text" name="nama" id="nama" class="nama form-control" value="{!!TemplateskpppkModel::getTitle('all', 7)!!}">
                    </div>
                </div>

                <div class="control-group">
                    <input type="hidden" name="idskpd" id="idskpd" class="idskpd" value="all">
                    <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="7">
                </div>

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template7" class="ckeditor form-control" id="template7" placeholder="Template Petikan">
                            {!!TemplateskpppkModel::getTemplate('all', 7)!!}
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