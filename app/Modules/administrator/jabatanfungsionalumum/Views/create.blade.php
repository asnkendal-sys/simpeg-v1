<section class="content-header">
    <h1>
        Buat Jabatan Fungsional Umum Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Jabatan Fungsional Umum</a></li>
        <li class="active">Buat Jabatan Fungsional Umum Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
					{!! Form::label('idjabfungum', 'Kode Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-3">
						{!! Form::text('idjabfungum', null, array('class'=> 'form-control', 'maxlength'=>7, 'placeholder'=>'Kode Jabatan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jabfungum', 'Jabatan Fungsional Umum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jabfungum', null, array('class'=> 'form-control','placeholder'=>'Nama Jabatan Fungsional Umum')) !!}
					</div>
				</div>
                <div class="form-group">
                    {!! Form::label('pens', 'Usia Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('pens', null, array('class'=> 'form-control num', 'placeholder'=>'Usia Pensiun', 'maxlength'=>2)) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('flag', 'Status Aktif:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-4">
                        {!! listPublish("flag","","") !!}
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
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
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
