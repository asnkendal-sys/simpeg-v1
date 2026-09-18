<section class="content-header">
    <h1>
        Edit Rekappensiun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Rekappensiun</a></li>
        <li class="active">Edit Rekappensiun</li>
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
        {!! Form::model($rekappensiun, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
            				<div class="form-group">
					{!! Form::label('tmtpens', 'tmtpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpens', null, array('class'=> 'form-control', 'placeholder'=>'tmtpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtcpn', 'tmtcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtcpn', null, array('class'=> 'form-control', 'placeholder'=>'tmtcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkedudupeg', 'idjenkedudupeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkedudupeg', null, array('class'=> 'form-control', 'placeholder'=>'idjenkedudupeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenpens', 'idjenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenpens', null, array('class'=> 'form-control', 'placeholder'=>'idjenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskpens', 'noskpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskpens', null, array('class'=> 'form-control', 'placeholder'=>'noskpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskpens', 'tgskpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskpens', null, array('class'=> 'form-control', 'placeholder'=>'tgskpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idpejabpens', 'idpejabpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idpejabpens', null, array('class'=> 'form-control', 'placeholder'=>'idpejabpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('statussk', 'statussk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('statussk', null, array('class'=> 'form-control', 'placeholder'=>'statussk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jabpenpens', 'jabpenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jabpenpens', null, array('class'=> 'form-control', 'placeholder'=>'jabpenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejpenpens', 'pejpenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejpenpens', null, array('class'=> 'form-control', 'placeholder'=>'pejpenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nippenpens', 'nippenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nippenpens', null, array('class'=> 'form-control', 'placeholder'=>'nippenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('golrupenpens', 'golrupenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('golrupenpens', null, array('class'=> 'form-control', 'placeholder'=>'golrupenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnpktpens', 'mkthnpktpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnpktpens', null, array('class'=> 'form-control', 'placeholder'=>'mkthnpktpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnpktpens', 'mkblnpktpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnpktpens', null, array('class'=> 'form-control', 'placeholder'=>'mkblnpktpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnpens', 'mkthnpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnpens', null, array('class'=> 'form-control', 'placeholder'=>'mkthnpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnpens', 'mkblnpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnpens', null, array('class'=> 'form-control', 'placeholder'=>'mkblnpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnpnspens', 'mkthnpnspens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnpnspens', null, array('class'=> 'form-control', 'placeholder'=>'mkthnpnspens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnpnspens', 'mkblnpnspens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnpnspens', null, array('class'=> 'form-control', 'placeholder'=>'mkblnpnspens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglmasukpns', 'tglmasukpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglmasukpns', null, array('class'=> 'form-control', 'placeholder'=>'tglmasukpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almpens', 'almpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almpens', null, array('class'=> 'form-control', 'placeholder'=>'almpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almrtpens', 'almrtpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almrtpens', null, array('class'=> 'form-control', 'placeholder'=>'almrtpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almrwpens', 'almrwpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almrwpens', null, array('class'=> 'form-control', 'placeholder'=>'almrwpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almdesapens', 'almdesapens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almdesapens', null, array('class'=> 'form-control', 'placeholder'=>'almdesapens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almkecpens', 'almkecpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almkecpens', null, array('class'=> 'form-control', 'placeholder'=>'almkecpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almkabpens', 'almkabpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almkabpens', null, array('class'=> 'form-control', 'placeholder'=>'almkabpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almprovpens', 'almprovpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almprovpens', null, array('class'=> 'form-control', 'placeholder'=>'almprovpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iscetaksk', 'iscetaksk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iscetaksk', null, array('class'=> 'form-control', 'placeholder'=>'iscetaksk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('statususul', 'statususul:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('statususul', null, array('class'=> 'form-control', 'placeholder'=>'statususul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kettms', 'kettms:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kettms', null, array('class'=> 'form-control', 'placeholder'=>'kettms')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('ketbtl', 'ketbtl:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('ketbtl', null, array('class'=> 'form-control', 'placeholder'=>'ketbtl')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('user_id', 'user_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('user_id', null, array('class'=> 'form-control', 'placeholder'=>'user_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('role_id', 'role_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('role_id', null, array('class'=> 'form-control', 'placeholder'=>'role_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('created_at', 'created_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('created_at', null, array('class'=> 'form-control', 'placeholder'=>'created_at')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('updated_at', 'updated_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('updated_at', null, array('class'=> 'form-control', 'placeholder'=>'updated_at')) !!}
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
