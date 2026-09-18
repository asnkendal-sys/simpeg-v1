<section class="content-header">
    <h1>
        Buat Tingkat Pendidikan Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Tingkatpendidikan</a></li>
        <li class="active">Buat Tingkatpendidikan Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('idtkpendid', 'Kode Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-2">
                        {!! Form::text('idtkpendid', null, array('class'=> 'form-control','placeholder'=>'Kode Tk Pendidikan')) !!}
                    </div>
                </div>
                <div class="form-group">
					{!! Form::label('tkpendid', 'Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-3">
						{!! Form::text('tkpendid', null, array('class'=> 'form-control','placeholder'=>'Tingkat Pendidikan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('maxgol', 'Golongan Maksimal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-4">
                        {!! comboGolru("maxgol","","") !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('singkatan', 'singkatan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-5">
						{!! Form::text('singkatan', null, array('class'=> 'form-control', 'placeholder'=>'Singkatan')) !!}
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
        $('select').select2();
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
