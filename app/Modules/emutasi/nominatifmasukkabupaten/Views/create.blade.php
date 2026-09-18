<section class="content-header">
    <h1>
        Buat Nominatif Masuk Kabupaten Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatif Masuk Kabupaten</a></li>
        <li class="active">Buat Nominatif Masuk Kabupaten Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            <div class="callout callout-success">
               <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
               <ul style="padding-left: 15px">
                   <li>Isiakan tanggal usulan</li>
                   <li>Ketikkan Nip Pegawai yang akan diusulkan mutasi</li>
                   <li>Isikan antribut usulan mutasi pada list pegawai yang diusulkan</li>
                   <li>Isian Nominatif dapat lebih dari 1 orang</li>
                   <li>Klik tombol simpan untuk menyimpan usulan</li>
               </ul>
            </div>
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
					{!! Form::label('nousul', 'Nomor Usulan:', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-4">
						{!! Form::text('nousulx', (Request::segment(4)!='')?Request::segment(4):'', array('class'=> 'form-control', 'placeholder'=>'No. Usulan Otomatis', 'readonly'=>'readonly')) !!}
                        {!! Form::hidden('nousul', (Request::segment(4)!='')?Request::segment(4):'', array('class'=> 'form-control', 'placeholder'=>'nousul')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglusul', 'Tanggal Usulan:', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-4">
                     <div class='input-group datepicker'>
                         {!! Form::text('tglusul', ((Request::segment(5)!='')?date('d-m-Y', strtotime(Request::segment(5))):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                         <span class="input-group-addon">
                             <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                     </div>
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nip', 'Nip Pegawai:', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-4">
                        {!! Form::text('nip', null, array('class'=> 'form-control num', 'placeholder'=>'Nomor Induk Pegawai', 'maxlength'=>18)) !!}
                        <span id="vernip"></span>
					</div>
				</div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-7">
                        {!! ClaravelHelpers::btnSave() !!}
                        &nbsp;
                        &nbsp;
                        {!! ClaravelHelpers::btnCancel() !!}
                    </div>
                </div>
            </div>

            <div class="row" style="padding-left: 12px">
                <div class="col-md-12" id="daftar-usul"></div>
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
        $("#simpan .datepicker").datetimepicker({
           format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");

        $('#simpan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('#simpan #nip').on('keyup', function(e){
            e.preventDefault();
            xhr.abort();
            xhr = $.ajax({
                url  : '{!!url()!!}/emutasi/nominatifmasukkabupaten/ceknip',
                type : 'POST',
                data : {'nip': $(this).val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend: function(){
                    preloader.on();
                    $('#simpan #vernip').html('Looading..');
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    $('#simpan #vernip').html(ret.text);
                    if(ret.err == 1){
                        //jika nip tersedia
                        addList();
                    }else{
                        //jika nip kembar / sudah digunakan
                    }
                }
            });
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

    function addList(){
        if($('#simpan #nip').val() != ''){
            if(isNaN(parseInt($('.nomi').attr('urutan')))){
                count = 0;
            }else{
                count = parseInt($('.nomi:last').attr('urutan'));
            }
            if(!$('#'+$('#nip').val()).html()){
                bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                    if(r===true){
                        count += 1;
                        $.ajax({
                            url  : '{!!url()!!}/emutasi/nominatifmasukkabupaten/data/usulan',
                            type:'post',
                            data:{ 'nip':$('#nip').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
                            beforeSend:function(){},
                            success:function(response){
                                $('#daftar-usul').append(response);
                                $('.remove_item').on('click', function(ev)
                                {
                                    if (ev.type == 'click')
                                    {
                                        $(this).parents("#daftar-usul .nomi").fadeOut();
                                        $(this).parents("#daftar-usul .nomi").remove();
                                    }
                                });

                                $('#simpan #nip').focus();
                                $('#simpan #nip').val('');
                            }
                        });
                    }
                });
            }else{
                bootbox.alert('Nomor Induk Pegawai sudah ada dalam daftar usulan sementara.');
            }
        }else{
            bootbox.alert('Masukkan Nomor Induk Pegawai');
        }
    }
</script>
