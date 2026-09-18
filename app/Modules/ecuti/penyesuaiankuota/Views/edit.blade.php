<section class="content-header">
    <h1>
        Edit Penyesuaiankuota<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Penyesuaiankuota</a></li>
        <li class="active">Edit Penyesuaiankuota</li>
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
        {!! Form::model($penyesuaiankuota, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('nip', 'nip:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip', null, array('class'=> 'form-control', 'placeholder'=>'nip')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('hari_kerja', 'hari_kerja:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('hari_kerja', null, array('class'=> 'form-control', 'placeholder'=>'hari_kerja')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_tahunan_n2', 'k_tahunan_n2:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_tahunan_n2', null, array('class'=> 'form-control', 'placeholder'=>'k_tahunan_n2')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_tahunan_n1', 'k_tahunan_n1:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_tahunan_n1', null, array('class'=> 'form-control', 'placeholder'=>'k_tahunan_n1')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_tahunan_n', 'k_tahunan_n:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_tahunan_n', null, array('class'=> 'form-control', 'placeholder'=>'k_tahunan_n')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_besar_bulan', 'k_besar_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_besar_bulan', null, array('class'=> 'form-control', 'placeholder'=>'k_besar_bulan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_besar_hari', 'k_besar_hari:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_besar_hari', null, array('class'=> 'form-control', 'placeholder'=>'k_besar_hari')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_sakit_tahun', 'k_sakit_tahun:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_sakit_tahun', null, array('class'=> 'form-control', 'placeholder'=>'k_sakit_tahun')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_sakit_bulan', 'k_sakit_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_sakit_bulan', null, array('class'=> 'form-control', 'placeholder'=>'k_sakit_bulan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_sakit_hari', 'k_sakit_hari:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_sakit_hari', null, array('class'=> 'form-control', 'placeholder'=>'k_sakit_hari')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_lahir_bulan', 'k_lahir_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_lahir_bulan', null, array('class'=> 'form-control', 'placeholder'=>'k_lahir_bulan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_lahir_hari', 'k_lahir_hari:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_lahir_hari', null, array('class'=> 'form-control', 'placeholder'=>'k_lahir_hari')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_penting_bulan', 'k_penting_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_penting_bulan', null, array('class'=> 'form-control', 'placeholder'=>'k_penting_bulan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_penting_hari', 'k_penting_hari:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_penting_hari', null, array('class'=> 'form-control', 'placeholder'=>'k_penting_hari')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_cltn_tahun', 'k_cltn_tahun:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_cltn_tahun', null, array('class'=> 'form-control', 'placeholder'=>'k_cltn_tahun')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_cltn_bulan', 'k_cltn_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_cltn_bulan', null, array('class'=> 'form-control', 'placeholder'=>'k_cltn_bulan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('k_cltn_hari', 'k_cltn_hari:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('k_cltn_hari', null, array('class'=> 'form-control', 'placeholder'=>'k_cltn_hari')) !!}
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
