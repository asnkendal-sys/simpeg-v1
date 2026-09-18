<section class="content-header">
    <h1>
        Template Masuk Kabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template Masuk Kabupaten</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li><a data-toggle="tab" href="{!!url()!!}/emutasi/templatemasukkabupaten"> <i class="fa fa-pencil"></i> Surat Persetujuan I</a></li>
                    <li><a data-toggle="tab" href="{!!url()!!}/emutasi/templatemasukkabupaten/persetujuanpindahprov"> <i class="fa fa-pencil"></i> Surat Persetujuan II</a></li>
                    <li class="active"><a data-toggle="tab" href="{!!url()!!}/emutasi/templatemasukkabupaten/pengantarpersetujuan"><i class="fa fa-pencil"></i> Surat Pengantar Persetujuan</a></li>
                    <li><a data-toggle="tab" href="{!!url()!!}/emutasi/templatemasukkabupaten/surattugas"><i class="fa fa-pencil"></i> Surat Tugas</a></li>
                    <li><a data-toggle="tab" href="{!!url()!!}/emutasi/templatemasukkabupaten/pengantarsurattugas"><i class="fa fa-pencil"></i> Surat Pengantar Tugas</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active">
                    {!! Form::open(array('url' => url()."/emutasi/templatemasukkabupaten/savetemplate", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                    <div class="box-body">
                        <div class="form-group">
                          <input type="hidden" name="jnssurat" class="jnssurat" id="jnssurat" value="4.3">
                          <input type="hidden" name="idskpd" class="idskpd" id="idskpd" value="all">
                        </div>
                        <div class="form-group">
        					{!! Form::label('nama', 'Nama Surat:', array('class' => 'col-sm-2 control-label')) !!}
        					<div class="col-sm-10">
        						{!! Form::text('nama', TemplatemasukkabupatenModel::getTemplate('all', 4.2, 'nama'), array('class'=> 'form-control', 'placeholder'=>'Nama Surat')) !!}
        					</div>
        				</div>
                        <div class="form-group">
                            {!! Form::label('template', 'Template:', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                <textarea rows="10" cols="600" name="template" class="ckeditor form-control" id="template3" placeholder="Template Surat Keputusan Ijin Belajar">
                                <?php
                                    /*$cek = TemplatemasukkabupatenModel::getTemplate(session('idskpd'), 4.2);
                                    if($cek != 0){
                                        echo TemplatemasukkabupatenModel::getTemplate(session('idskpd'), 4.2);
                                    }else{
                                        echo  TemplatemasukkabupatenModel::getTemplate('all', 4.2);
                                    }*/

                                    echo  TemplatemasukkabupatenModel::getTemplate('all', 4.3, 'template');
                                ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {!! ClaravelHelpers::btnSave() !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }

    $(document).ready(function(){
        $('select').select2();
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        delete CKEDITOR.instances[ 'template3' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };
        $('.ckeditor').ckeditor(config_pengantar);

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            if(n > 0){
            }
            else{
                e.preventDefault();
                e.stopImmediatePropagation();

                $.ajax({
                    type: 'get',
                    url : $(this).attr('href'),
                    beforeSend: function(){
                        $('#loading-state').fadeIn("slow");
                    },
                    success: function(data) {
                        $('#loading-state').fadeOut("slow");
                        $('#utama').html(data);
                    }
                });
            }
        });

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
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

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
    });

    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }
</script>
