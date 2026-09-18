<section class="content-header">
    <h1>
        Edit Nominatifcuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatifcuti</a></li>
        <li class="active">Edit Nominatifcuti</li>
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
        {!! Form::model($nominatifcuti, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('nousul', 'nousul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nousul', null, array('class'=> 'form-control', 'placeholder'=>'nousul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgl_usul', 'tgl_usul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgl_usul', null, array('class'=> 'form-control', 'placeholder'=>'tgl_usul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip', 'nip:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip', null, array('class'=> 'form-control', 'placeholder'=>'nip')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nama', 'nama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nama', null, array('class'=> 'form-control', 'placeholder'=>'nama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjab', 'idjenjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjab', null, array('class'=> 'form-control', 'placeholder'=>'idjenjab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjab', 'idjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjab', null, array('class'=> 'form-control', 'placeholder'=>'idjab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jab', 'jab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jab', null, array('class'=> 'form-control', 'placeholder'=>'jab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idskpd', 'idskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idskpd', null, array('class'=> 'form-control', 'placeholder'=>'idskpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('skpd', 'skpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('skpd', null, array('class'=> 'form-control', 'placeholder'=>'skpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('msk_thn', 'msk_thn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('msk_thn', null, array('class'=> 'form-control', 'placeholder'=>'msk_thn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('msk_bln', 'msk_bln:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('msk_bln', null, array('class'=> 'form-control', 'placeholder'=>'msk_bln')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('id_jenis_cuti', 'id_jenis_cuti:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('id_jenis_cuti', null, array('class'=> 'form-control', 'placeholder'=>'id_jenis_cuti')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('alasan', 'alasan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('alasan', null, array('class'=> 'form-control', 'placeholder'=>'alasan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgl_mulai', 'tgl_mulai:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgl_mulai', null, array('class'=> 'form-control', 'placeholder'=>'tgl_mulai')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgl_selesai', 'tgl_selesai:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgl_selesai', null, array('class'=> 'form-control', 'placeholder'=>'tgl_selesai')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('lama_cuti', 'lama_cuti:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('lama_cuti', null, array('class'=> 'form-control', 'placeholder'=>'lama_cuti')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('alamat_cuti', 'alamat_cuti:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('alamat_cuti', null, array('class'=> 'form-control', 'placeholder'=>'alamat_cuti')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('telepon', 'telepon:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('telepon', null, array('class'=> 'form-control', 'placeholder'=>'telepon')) !!}
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
                            if(html==4){
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
