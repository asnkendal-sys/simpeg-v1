<section class="content-header">
    <h1>
        Edit Template Kenaikan Pangkat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Template Kenaikan Pangkat</a></li>
        <li class="active">Edit Template Kenaikan Pangkat</li>
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
        {!! Form::model($templatekenaikanpangkat, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('nousul', 'nousul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nousul', null, array('class'=> 'form-control', 'placeholder'=>'nousul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglusul', 'tglusul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglusul', null, array('class'=> 'form-control', 'placeholder'=>'tglusul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip', 'nip:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip', null, array('class'=> 'form-control', 'placeholder'=>'nip')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjeniskp', 'idjeniskp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjeniskp', null, array('class'=> 'form-control', 'placeholder'=>'idjeniskp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('user_id', 'user_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('user_id', null, array('class'=> 'form-control', 'placeholder'=>'user_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('role_id', 'role_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('role_id', null, array('class'=> 'form-control', 'placeholder'=>'role_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('created_at', 'created_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('created_at', null, array('class'=> 'form-control', 'placeholder'=>'created_at')) !!}
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
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
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
</script>
