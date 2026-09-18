<section class="content-header">
    <h1>
        Buat Pemberhentianpppk Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Pemberhentianpppk</a></li>
        <li class="active">Buat Pemberhentianpppk Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('no_urut', 'no_urut:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('no_urut', null, array('class'=> 'form-control', 'placeholder'=>'no_urut')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('no_spk', 'no_spk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('no_spk', null, array('class'=> 'form-control', 'placeholder'=>'no_spk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip', 'nip:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nip', null, array('class'=> 'form-control', 'placeholder'=>'nip')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('niplama', 'niplama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('niplama', null, array('class'=> 'form-control', 'placeholder'=>'niplama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nipbaru', 'nipbaru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nipbaru', null, array('class'=> 'form-control', 'placeholder'=>'nipbaru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosk_calon', 'nosk_calon:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosk_calon', null, array('class'=> 'form-control', 'placeholder'=>'nosk_calon')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglsk_calon', 'tglsk_calon:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglsk_calon', null, array('class'=> 'form-control', 'placeholder'=>'tglsk_calon')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosk_pppk', 'nosk_pppk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosk_pppk', null, array('class'=> 'form-control', 'placeholder'=>'nosk_pppk')) !!}
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
