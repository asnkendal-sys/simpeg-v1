<section class="content-header">
    <h1>
        Edit Skluarkabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Skluarkabupaten</a></li>
        <li class="active">Edit Skluarkabupaten</li>
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
        {!! Form::model($skluarkabupaten, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('nousul', 'No Usul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nousul', null, array('class'=> 'form-control', 'placeholder'=>'No Usul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglusul', 'Tanggal Usul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglusul', null, array('class'=> 'form-control', 'placeholder'=>'Tanggal Usul')) !!}
					</div>
				</div>
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
					{!! Form::label('idtkpendid', 'idtkpendid:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtkpendid', null, array('class'=> 'form-control', 'placeholder'=>'idtkpendid')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjurusan', 'idjenjurusan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjurusan', null, array('class'=> 'form-control', 'placeholder'=>'idjenjurusan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('thnlulus', 'thnlulus:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('thnlulus', null, array('class'=> 'form-control', 'placeholder'=>'thnlulus')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgolrupkt', 'idgolrupkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgolrupkt', null, array('class'=> 'form-control', 'placeholder'=>'idgolrupkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjab', 'idjenjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjab', null, array('class'=> 'form-control', 'placeholder'=>'idjenjab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabjbt', 'idjabjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabjbt', null, array('class'=> 'form-control', 'placeholder'=>'idjabjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfung', 'idjabfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfung', null, array('class'=> 'form-control', 'placeholder'=>'idjabfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfungum', 'idjabfungum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfungum', null, array('class'=> 'form-control', 'placeholder'=>'idjabfungum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtpkt', 'tmtpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpkt', null, array('class'=> 'form-control', 'placeholder'=>'tmtpkt')) !!}
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
