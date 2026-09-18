<section class="content-header">
    <h1>
        Buat Kontrakpppk Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Kontrakpppk</a></li>
        <li class="active">Buat Kontrakpppk Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('jenis', 'jenis:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jenis', null, array('class'=> 'form-control', 'placeholder'=>'jenis')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('file_awal', 'file_awal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('file_awal', null, array('class'=> 'form-control', 'placeholder'=>'file_awal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('file_tte', 'file_tte:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('file_tte', null, array('class'=> 'form-control', 'placeholder'=>'file_tte')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('id_sk', 'id_sk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('id_sk', null, array('class'=> 'form-control', 'placeholder'=>'id_sk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nik_pejabat', 'nik_pejabat:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nik_pejabat', null, array('class'=> 'form-control', 'placeholder'=>'nik_pejabat')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip_pengusul', 'nip_pengusul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip_pengusul', null, array('class'=> 'form-control', 'placeholder'=>'nip_pengusul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip_pejabat', 'nip_pejabat:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip_pejabat', null, array('class'=> 'form-control', 'placeholder'=>'nip_pejabat')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('proses', 'proses:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('proses', null, array('class'=> 'form-control', 'placeholder'=>'proses')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('id_tte', 'id_tte:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('id_tte', null, array('class'=> 'form-control', 'placeholder'=>'id_tte')) !!}
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
