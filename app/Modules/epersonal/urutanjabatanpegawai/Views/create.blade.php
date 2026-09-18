<section class="content-header">
    <h1>
        Buat Daftar Susunan Pegawai Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Daftar Susunan Pegawai</a></li>
        <li class="active">Buat Daftar Susunan Pegawai Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('nama', 'nama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nama', null, array('class'=> 'form-control', 'placeholder'=>'nama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gdp', 'gdp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gdp', null, array('class'=> 'form-control', 'placeholder'=>'gdp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gdb', 'gdb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gdb', null, array('class'=> 'form-control', 'placeholder'=>'gdb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmlhr', 'tmlhr:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmlhr', null, array('class'=> 'form-control', 'placeholder'=>'tmlhr')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglhr', 'tglhr:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglhr', null, array('class'=> 'form-control', 'placeholder'=>'tglhr')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkel', 'idjenkel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkel', null, array('class'=> 'form-control', 'placeholder'=>'idjenkel')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idagama', 'idagama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idagama', null, array('class'=> 'form-control', 'placeholder'=>'idagama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idstspeg', 'idstspeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idstspeg', null, array('class'=> 'form-control', 'placeholder'=>'idstspeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkepeg', 'idjenkepeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkepeg', null, array('class'=> 'form-control', 'placeholder'=>'idjenkepeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkedudupeg', 'idjenkedudupeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkedudupeg', null, array('class'=> 'form-control', 'placeholder'=>'idjenkedudupeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idstskawin', 'idstskawin:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idstskawin', null, array('class'=> 'form-control', 'placeholder'=>'idstskawin')) !!}
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
