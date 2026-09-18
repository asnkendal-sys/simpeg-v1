<section class="content-header">
    <h1>
        Edit Templateluarkabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Templateluarkabupaten</a></li>
        <li class="active">Edit Templateluarkabupaten</li>
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
        {!! Form::model($templateluarkabupaten, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('jnssurat', 'jnssurat:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jnssurat', null, array('class'=> 'form-control', 'placeholder'=>'jnssurat')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idskpd', 'idskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idskpd', null, array('class'=> 'form-control', 'placeholder'=>'idskpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nama', 'nama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nama', null, array('class'=> 'form-control', 'placeholder'=>'nama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('template', 'template:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('template', null, array('class'=> 'form-control', 'placeholder'=>'template')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('author', 'author:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('author', null, array('class'=> 'form-control', 'placeholder'=>'author')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgin', 'tgin:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgin', null, array('class'=> 'form-control', 'placeholder'=>'tgin')) !!}
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
