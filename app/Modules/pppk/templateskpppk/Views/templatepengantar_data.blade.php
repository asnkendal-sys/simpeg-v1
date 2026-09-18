<script type="text/javascript">
    $(document).ready(function(){
        $('#templatepengantar select').select2();

        <?php if(session('role_id') <= 3){?>
            $('#templatepengantar #idskpd').select2();
            $('#templatepengantar #idskpd').on('change', function(e){
                e.preventDefault();
                var idskpd = $('#templatepengantar #idskpd').val();
                var jnssurat = $('#templatepengantar #jnssurat').val();

                $.ajax({
                    type : 'post',                    
                    url : '{!!url()!!}/pppk/templateskpppk/surat',
                    data: {'idskpd':idskpd, 'jnssurat': jnssurat, '_token': '<?php echo csrf_token()?>'},
                    beforeSend:function(){
                        preloader.on();
                    },
                    success:function(response){
                        preloader.off();
                        var ret = $.parseJSON(response);
                        $('#templatepengantar #name').val(ret.name);                        
                        $('#templatepengantar #template6').val(ret.template);
                    }
                });
            });
        <?php } ?>

        delete CKEDITOR.instances[ 'template6' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };

        $('#templatepengantar .ckeditor').ckeditor(config_pengantar);        

        $('#templatepengantar #form1').on('submit',function(e){
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

        $('#templatepengantar #defaultthem').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type : 'post',
                url : '{!!url()!!}/pppk/templateskpppk/surat',
                data: {'idskpd':'all', 'jnssurat': '6', '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#templatepengantar #template6').val(ret.template);
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
                        <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="6">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="nama">Judul</label>
                    <div class="controls">
                        <input type="text" name="nama" id="nama" class="nama form-control" value="{!!TemplateskpppkModel::getTitle('all', 6)!!}">
                    </div>
                </div>                

                <div class="control-group">
                    <label class="control-label" for="template">Template</label>
                    <div class="controls">
                        <textarea rows="10" cols="600" name="template6" class="ckeditor form-control" id="template6" placeholder="Template Pengantar OPD">                            
                            <?php
                                if(TemplateskpppkModel::getTemplate(session('idskpd'), 6)=='0'){
                                    echo TemplateskpppkModel::getTemplate('all', 6);
                                }else{
                                    echo TemplateskpppkModel::getTemplate(session('idskpd'), 6);
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