<section class="content-header">
    <h1>
        Edit Jabatan Fungsional<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Jabatan Fungsional</a></li>
        <li class="active">Edit Jabatan Fungsional</li>
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
        {!! Form::model($jabatanfungsional, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('idjabfung') !!}
        <div class="box-body">
                <div class="form-group">
                    {!! Form::label('idjabfung', 'Kode Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-2">
                        {!! Form::text('idjabfung', null, array('class'=> 'form-control', 'maxlength'=>5, 'placeholder'=>'Kode Jabatan', 'disabled'=>'disabled')) !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::text('tingkat', null, array('class'=> 'form-control', 'maxlength'=>3, 'placeholder'=>'Tingkat', 'readonly'=>'readonly', 'id'=>'tingkat')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jabfung2', 'Kelompok Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jabfung2', null, array('class'=> 'form-control', 'placeholder'=>'Nama Jabatan dan Tingkat')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jabfung', 'Jabatan Fungsional:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jabfung', null, array('class'=> 'form-control', 'placeholder'=>'Nama Jabatan Fungsional')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jenjang', 'Jenjang:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jenjang', null, array('class'=> 'form-control', 'placeholder'=>'Jenjang Jabatan')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('pens', 'Usia Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('pens', null, array('class'=> 'form-control num', 'placeholder'=>'Usia Pensiun', 'maxlength'=>2)) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('isguru', 'Kategori Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <label class="radio-inline">
                            <input type="radio" value="1" id="opt1" name="isguru" {{($jabatanfungsional->isguru==1)?'checked':''}}> Tenaga Pendidikan / Guru
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" id="opt2" name="isguru" {{($jabatanfungsional->isguru==2)?'checked':''}}> Tenaga Kesehatan
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="3" id="opt3" name="isguru" {{($jabatanfungsional->isguru==3)?'checked':''}}> Tenaga Teknis
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('flag', 'Status Aktif:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-4">
                        {!! listPublish("flag",$jabatanfungsional->flag,"") !!}
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
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#idjabfung').on('keyup', function(e){
            e.preventDefault();
            if($("#idjabfung").val().length <= 3){
                $('#tingkat').val($('#idjabfung').val());
            }
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
