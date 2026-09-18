<section class="content-header">
    <h1>
        Buat Utility Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Utility</a></li>
        <li class="active">Buat Utility Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('nma_aplikasi', 'Nama Aplikasi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nma_aplikasi', null, array('class'=> 'form-control', 'placeholder'=>'Nama Aplikasi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nma_instansi', 'Nama Instansi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nma_instansi', null, array('class'=> 'form-control', 'placeholder'=>'Nama Instansi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kab_instansi', 'Kabupaten Instansi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kab_instansi', null, array('class'=> 'form-control', 'placeholder'=>'Kabupaten Instansi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('link_instansi', 'Link Instansi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('link_instansi', null, array('class'=> 'form-control', 'placeholder'=>'Link Instansi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('email_instansi', 'Email Instansi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('email_instansi', null, array('class'=> 'form-control', 'placeholder'=>'Email Instansi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('logo_instansi', 'Logo Instansi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('logo_instansi', null, array('class'=> 'form-control', 'placeholder'=>'Logo Instansi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('thn_develop', 'Tahun Pembuatan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('thn_develop', null, array('class'=> 'form-control', 'placeholder'=>'Tahun Pembuatan')) !!}
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
