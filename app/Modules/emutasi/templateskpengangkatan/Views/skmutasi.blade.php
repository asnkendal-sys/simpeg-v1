<section class="content-header">
    <h1>
        Template SK Pengangkatan Pelaksana<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK Pengangkatan Pelaksana</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/emutasi/templateskmutasi"> <i class="fa fa-fw fa-list-ul"></i> PENGANTAR OPD</a></li>
                    @if(Session::get('role_id') <= 3)
                    <li class="active"><a href="{!!url()!!}/emutasi/templateskmutasi/skmutasi"> <i class="fa fa-fw fa-list-ul"></i> SK Pengangkatan Pelaksana</a></li>
                    @endif
                </ul>

                <div class="tab-pane active"><br>

                    {!! Form::open(array('url' => url()."/emutasi/templateskpengangkatan/savetemplate", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                    <div class="box-body">
                        <input type='hidden' name='idskpd' id='idskpd' value="all">
                        <input type="hidden" name="jnssurat" class="jenis" id="jenis" value="2">

                        <div class="form-group">
                            {!! Form::label('jnsmutasi', 'Jenis Mutasi:', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-8">
                                {!!TemplateskpengangkatanModel::comboJnsmutasi('jnssurat','','')!!}
                            </div>
                            <div class="col-sm-2">
                                <a href="javascript:void(0)" class="btn btn-warning" id="defaultthem"><i class="fa fa-refresh"></i> Default Template</a>
                            </div>

                        </div>
                        <div class="form-group">
                            {!! Form::label('template', 'Template:', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                <textarea rows="10" cols="600" name="template" class="ckeditor form-control" id="template" placeholder="MUTASI">
                                    <?php
                                    $cek = TemplateskpengangkatanModel::getTemplate(session('idskpd'), 2,'template');
                                    if($cek != 0){
                                        echo TemplateskpengangkatanModel::getTemplate(session('idskpd'), 2,'template');
                                    }
                                    else{
                                        echo  TemplateskpengangkatanModel::getTemplate('all', 2,'template');
                                    }
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
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('select').select2();
        delete CKEDITOR.instances[ 'template' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '450'
        };
        $('.ckeditor').ckeditor(config_pengantar);

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if(n > 0){
            }
            else{
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

                $.ajax({
                    type: 'get',
                    url : $(this).attr('href'),
                    beforeSend: function(){
                        preloader.on();
                    },
                    success: function(data) {
                        preloader.off();
                        $('#utama').html(data);
                    }
                });
            }
        });

        $('#idskpd').on('change', function(e){
            e.preventDefault();
            if($('#idskpd').val() == ''){
                $('#idskpd').val('all');
            }else{
                var idskpd = $('#idskpd').val();
            }

            $.ajax({
                type : 'post',
                url: '{!!url()!!}/emutasi/templateskpengangkatan/template',
                data: {'idskpd':idskpd, 'jenis': $('#jenis').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#template').val(ret.template);
                }
            });
        })

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

        $('#buat').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#tabel').on('click','#hapus',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/edit',
                        type : 'get',
                        data:'id=' + $this.attr('recid'),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });
        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/delete',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            iki.find('input[type=checkbox]').each(function (t){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').fadeOut(100)                                        
                                }
                            });
                            $('#deleteall').fadeOut(300);
                        }
                    });
                }
            });            
        });
    });

    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }
</script>
