<section class="content-header">
    <h1>
        Buat Imageslider Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Imageslider</a></li>
        <li class="active">Buat Imageslider Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
					{!! Form::label('img', 'Gambar:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
                        <input type="file" name="img" id="img" title=".jpg .jpeg .png" accept="image/*" >
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('caption', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('caption', null, array('class'=> 'form-control', 'placeholder'=>'Keterangan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('order', 'Order:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-4">
						{!! Form::text('order', null, array('class'=> 'form-control num', 'placeholder'=>'Order')) !!}
					</div>
				</div>
                <div class="form-group">
                    {!! Form::label('flag', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-4">
                        {!! \listPublish("flag",'',"") !!}
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
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan').on('submit',function(e){
            var $this = $(this);
            var formData = new FormData(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        type:'POST',
                        url: $this.attr('action'),
                        data:formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        },
                        error: function(html){
                        }
                    });
                }
            });
        });

        $('#img').fileinput({
            showUpload:false,
            previewFileType:'image',
            allowedFileExtensions: ["png", "jpg", "jpeg", "PNG", "JPG", "JPEG"],
            maxFileSize: 1024 * 1 * 1 ,
            browseLabel: "",
            browseIcon: '<i class="fa fa-folder-open"></i>',
            removeLabel: " Hapus",
            removeIcon: '<i class="fa fa-times"></i>',
            layoutTemplates: {
                main1: "{preview}\n" +
                    "<div class=\'input-group {class}\'>\n" +
                    "   <div class=\'input-group-btn\'>\n" +
                    "       {browse}\n" +
                    "       {upload}\n" +
                    "       {remove}\n" +
                    "   </div>\n" +
                    "   {caption}\n" +
                    "</div>"
            }
        });
    });
</script>
