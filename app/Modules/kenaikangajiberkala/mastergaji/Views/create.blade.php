<section class="content-header">
    <h1>
        Buat Master Gaji Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Master Gaji</a></li>
        <li class="active">Buat Master Gaji Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('pkt', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! comboGolru("pkt","","") !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('msk', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! MastergajiModel::masakerja('msk','','') !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('gaji', 'Gaji:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            {!! Form::text('gaji', null, array('class'=> 'form-control num', 'placeholder'=>'Gaji', 'maxlength'=> 9)) !!}
                        </div>
                        <em>* Diisi angka desimal tanpa tanda titik</em>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('dasarhukum', 'Dasar Hukum:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('dasarhukum', null, array('class'=> 'form-control', 'placeholder'=>'Dasar Hukum')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('tahun', null, array('class'=> 'form-control num', 'placeholder'=>'Tahun', 'maxlength'=>4)) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('ket', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('ket', null, array('class'=> 'form-control', 'placeholder'=>'Keterangan')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status Aktif:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! comboYesno("status","","") !!}
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
