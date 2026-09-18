<section class="content-header">
    <h1>
        Buat Manajemen User<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Manajemen User</a></li>
        <li class="active">Buat Manajemen User</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
					{!! Form::label('name', 'Name:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('name', null, array('class'=> 'form-control', 'placeholder'=>'Name')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('username', 'Username:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('username', null, array('class'=> 'form-control', 'placeholder'=>'Username')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('email', 'Email:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('email', null, array('class'=> 'form-control', 'placeholder'=>'Email')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('Password', 'password:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
                        {!! Form::password('password', array('class'=> 'form-control', 'placeholder'=>'Password')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('role_id', 'Role:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
                        {!! comboRole("role_id","","") !!}
					</div>
				</div>
                <div id="xmenu"></div>
				<div class="form-group">
					{!! Form::label('idskpd', 'Skpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!!comboSkpd2("idskpd","","")!!}
					</div>
				</div>
                <div class="form-group">
                    {!! Form::label('aktif_mulai', 'Tanggal Aktif:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' id="datetime1" name="aktif_mulai" class="form-control datetime" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('aktif_selesai', 'Tanggal Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' id="datetime2" name="aktif_selesai" class="form-control datetime" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('keterangan', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::textarea('keterangan', null, array('class'=> 'form-control', 'rows'=>'5', 'placeholder'=>'Keterangan sebagai notifikasi ketika login..')) !!}
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
        $('#datetimepicker1').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $('#datetimepicker2').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $(".datetime").mask("9999-99-99 99:99:99");
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#role_id').on('change', function(e){
            e.preventDefault();
            var role_id = $(this).val();
            $.ajax({
                url  : '{!!url()!!}/administrator/manajemenuser/data/menu',
                type : 'POST',
                data : {'role_id': role_id, 'context_id': '1', '_token': '{!!csrf_token()!!}' },
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#xmenu').html(html);
                }
            });
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
