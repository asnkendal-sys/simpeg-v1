<section class="content-header">
    <h1>
        Edit Sistem Notifikasi<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Sistem Notifikasi</a></li>
        <li class="active">Edit Sistem Notifikasi</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <?php
        $rpos = strrpos(\Request::path(), '/');
        $uri = substr(\Request::path(), 0, $rpos);
        ?>
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($sistemnotifikasi, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
                {!! Form::hidden('id') !!}
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
                            {!! Form::textarea('notification', $sistemnotifikasi->notification, array('class'=> 'form-control ckeditor', 'placeholder'=>'Notifikasi')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('tgl_publish', 'Tanggal publish:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class='input-group date' id='datetimepicker1'>
                                {!! Form::text('tgl_publish', date('d-m-Y H:i:s', strtotime($sistemnotifikasi->tgl_publish)), array('class'=> 'form-control datetime', 'placeholder'=>'Tanggal publish')) !!}
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
                            {!! ClaravelHelpers::btnCancelEdit() !!}
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
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action') + '/edit' ,
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
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
