<section class="content-header">
    <h1>
        Buat Pengumuman Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Pengumuman</a></li>
        <li class="active">Buat Pengumuman Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
					{!! Form::label('judul', 'Judul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('judul', null, array('class'=> 'form-control', 'placeholder'=>'Judul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pengumuman', 'Pengumuman:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-9">
                        {!! Form::textarea('pengumuman', null, array('class'=> 'form-control ckeditor')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
                        {!!listPublish("status","","")!!}
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
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        delete CKEDITOR.instances[ 'pengumuman' ];
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
