<section class="content-header">
    <h1>
        Buat Sistem Notifikasi Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Sistem Notifikasi</a></li>
        <li class="active">Buat Sistem Notifikasi Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('title', 'Judul:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('title', null, array('class'=> 'form-control', 'placeholder'=>'Judul')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('notification', 'Notifikasi:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::textarea('notification', null, array('class'=> 'form-control ckeditor', 'placeholder'=>'Notifikasi')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('tgl_publish', 'Rencana Publish:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class='input-group date' id='datetimepicker1'>
                                {!! Form::text('tgl_publish', null, array('class'=> 'form-control datetime', 'placeholder'=>'Tanggal publish')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<script>
    function refresh_page(){
    <?php
    $index_page = explode('/', \Request::path());
    $jum = count($index_page) -1;
    unset ($index_page[$jum]);
    $index = join('/', $index_page);
    echo 'var index_page=laravel_base + "/'.$index.'";';
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
        $('#datetimepicker1').datetimepicker({format: 'DD-MM-YYYY HH:mm:ss'});
        $(".datetime").mask("99-99-9999 99:99:99");

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        delete CKEDITOR.instances[ 'notification' ];
        var config_pengantar = {
            toolbar : 'MyToolbar',
            height: '350'
        };
        $('.ckeditor').ckeditor(config_pengantar);

        $('#simpan').on('submit',function(e){
            CKupdate();
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
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
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
