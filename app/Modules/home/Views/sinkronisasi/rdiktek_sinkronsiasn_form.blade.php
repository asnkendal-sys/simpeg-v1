<?php
//    use App\Services\SkpService;
//    use App\Repositories\SkpRepository;

    $nip = Input::get('nip');
    $iddiktek = Input::get('id');
    $idbkn = Input::get('iddiktekbkn');

    if($idbkn != ''){
//        $srv = new SkpService(new SkpRepository);
//        $dikte = $srv->fetch($nip)->filter('tahun',2021)->first();
        $diktek = accessDatapersonalsiasn('kursus/id',$idbkn);
    }

    /*catatan sinkronisasi*/
    /*
     *
     Jika $idbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_diktek yang akan dikirim sinkronisasinya
     Jika $idbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari SIASN dan data dari r_diktek simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_diktek SIASN
     2. TARIK DATA KE SIASN    : Untuk form preview data dari r_diktek simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        @if($iddiktek != '')
        <li class="active"><a data-toggle="tab" href="#tab_syx1"><i class="fa fa-pencil"></i> <b>SINKRONISAI SIASN</b></a></li>
        @endif
        <li class="<?php echo (($iddiktek != '')?'':'active')?>"><a data-toggle="tab" id="xdatabkn" href="#tab_syx2"><i class="fa fa-list"></i> <b>DATA DIKLAT TEKSNI SIASN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($iddiktek != '')
        <div id="tab_syx1" class="tab-pane active">
            <br>
            <div class="row">
                @if($idbkn != '')
                    <!--preview data r_diktek SIASN-->
                    <div class="col-md-6">
                        <div class="alert callout callout-success">
                            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                            <ul style="padding-left: 15px">
                                <li>Preview data yang ditampilkan merupakan data Riwayat Diklat Teknis dari SIASN</li>
                                <li>Untuk melakukan sinkronisasi data Riwayat Diklat Teknis dari SIASN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                                <li>Ketika proses <b>TARIK DATA</b> selesai Riwayat Diklat Teknis dari SIASN sudah terkoneksi dengan SIMPEG</li>
                            </ul>
                        </div>

                        {!! Form::open(array('url' => url().'/syncrdiktekbkn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rdiktek1')) !!}
                        {!! Form::hidden('id', $iddiktek, array('id'=> 'id')) !!}
                        {!! Form::hidden('iddiktekbkn', $idbkn, array('id'=> 'iddiktekbkn')) !!}                        
                        <div class="box-body">
                            <b class="box-title"><i class="fa fa-fw fa-child"></i> DIKLAT TEKNIS PEGAWAI</b><hr>
                            <div class="form-group">
                                {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('namaKursus', 'Nama Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('namaKursus', $diktek->namaKursus, array('class'=> 'form-control', 'placeholder'=>'Nama Diklat', 'readonly'=>'readonly')) !!}
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('institusiPenyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('institusiPenyelenggara', $diktek->institusiPenyelenggara, array('class'=> 'form-control', 'placeholder'=>'Penyelenggara', 'readonly'=>'readonly')) !!}
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tahun', $diktek->tahunKursus, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4, 'readonly'=>'readonly')) !!}

                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('noSertipikat', 'Nomor Sertifikat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('noSertipikat', $diktek->noSertipikat, array('class'=> 'form-control', 'placeholder'=>'Nomor Sertifikat', 'readonly'=>'readonly')) !!}
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tanggalKursus', 'Tanggal:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tanggalKursus', $diktek->tanggalKursus, array('class'=> 'form-control', 'placeholder'=> 'dd-mm-yyyy', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('tanggalSelesaiKursus', 'Tanggal Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tanggalSelesaiKursus', $diktek->tanggalSelesaiKursus, array('class'=> 'form-control', 'placeholder'=> 'dd-mm-yyyy', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('jumlahJam', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class='input-group'>
                                        {!! Form::text('jumlahJam', $diktek->jumlahJam, array('class'=> 'form-control', 'placeholder'=>'Lama', 'readonly'=>'readonly')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="checkbox">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> TARIK DATA KE SIMPEG</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                @endif

                @if($iddiktek != 'x')
                <!--preview data r_diktek simpeg-->
                <div class="col-md-<?php echo (($idbkn != '')?6:12)?>">
                    <div class="alert callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat Diklat Teknis dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke SIASN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada Riwayat Diklat Teknis SIMPEG sudah terkoneksi dengan SIASN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url().'/syncrdikteksimpegsiasn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rdiktek2')) !!}
                    <div class="box-body rdiktek-perubahan">
                        <b class="box-title"><i class="fa fa-fw fa-child"></i> DIKLAT TEKNIS PEGAWAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                                {!! Form::hidden('iddiktekbkn', null, array('id'=> 'iddiktekbkn')) !!}
                                {!! Form::text('nip', $nip, array('class'=> 'form-control ', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nmdiktek', 'Nama Diklat Sesuai Sertifikat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nmdiktek', null, array('class'=> 'form-control', 'id'=> 'nmdiktek', 'placeholder'=>'Nama Diklat')) !!}
                                <em>*Nama Diklat tidak disingkat</em>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmdiktek', 'Tempat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tmdiktek', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Diklat')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('penyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('penyelenggara', null, array('class'=> 'form-control', 'placeholder'=>'Penyelenggara')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('angkatan', 'Angkatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('angkatan', null, array('class'=> 'form-control', 'placeholder'=>'Angkatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Mulai')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Selesai')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jamhari', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group'>
                                    {!! Form::text('jamhari', null, array('class'=> 'form-control num', 'placeholder'=>'Lama hitungan jam')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosttpdiktek', 'No. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosttpdiktek', null, array('class'=> 'form-control', 'placeholder'=>'No. STTP')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsttpdiktek', 'Tgl. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsttpdiktek', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. STTP')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>                        

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> SINKRON DATA KE SIASN</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> BATALKAN</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
                @endif
            </div>
        </div>
        @endif

        <div id="tab_syx2" class="tab-pane <?php echo (($iddiktek != '')?'':'active')?>">
            <br>
            <div class="row">
                <div class="alert callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Menu ini menampilkan data Riwayat Diklat Teknis dari SIASN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data Riwayat Diklat Teknis dari SIASN ke SIMMPEG</li>
                    </ul>
                </div>

                <table class="table table-striped table-hover table-condensed table-bordered" role="grid" id="tb-rpangkat">
                    <thead class="bg-primary">
                    <tr>
                        <th width="2%"><div class="text-center">NO</div></th>
                        <th><div class="text-center">TAHUN</div></th>
                        <th><div class="text-center">NAMA DIKLAT</div></th>
                        <th><div class="text-center">PENYELENGGARA</div></th>
                        <th><div class="text-center">TANGGAL</div></th>
                        <th><div class="text-center">LAMA</div></th>
                        <th><div class="text-center">NOMOR SERTIFIKAT</div></th>
                        <th><div class="text-center">BERKAS FILE</div></th>
                        <th width="8%"><div class="text-center">AKSI</div></th>
                    </tr>
                    </thead>
                    <tbody id="xresult">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.tab-content -->
</div>

<style type="text/css">
    /*.modal {
        overflow: auto !important;
    }*/

    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    #wadah_modal .modal-body{
        height: 80vh;
        overflow-y: auto;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){

        <?php if($iddiktek == '') { ?>
        loadRdiktekbkn();
        <?php } ?>

        $('#xdatabkn').on('click', function(){
            loadRdiktekbkn();
        })        

        $('#form-rdiktek2 .rdiktek-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('#form-rdiktek2 .rdiktek-perubahan select').select2();
        $('#form-rdiktek2 .rdiktek-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rdiktek2 .rdiktek-perubahan .date").mask("99-99-9999");
        $("#form-rdiktek2 .rdiktek-perubahan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rdiktek1').on('submit',function(e){

            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Sinkroniasi Data SIASN ke Simpeg ?',function(a){
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
                            if((html==1) || (html==4)){
                                notification('Data Berhasil Tersinkronisasi.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRdiktek();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rdiktek2').on('submit',function(e){

            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Sinkroniasi Data Simpeg ke SIASN ?',function(a){
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
                            if((html==1) || (html==4)){
                                notification('Data Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRdiktek();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

    <?php if(Input::get("flag") == 2){ ?>
        $.ajax({
            url:'{!!url()!!}/epersonal/biodata/editriwayat',
            type:'post',
            data:{'id':'{!!Input::get("id")!!}','tb':'r_diktek','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrselect2 = new Array('idjendik_SAPK');
                var arrdate = new Array('tgmul','tgsel','tgsttpdiktek');
                if(ret){
                    for(attrname in ret){
                        $('#form-rdiktek2 .rdiktek-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rdiktek2 .rdiktek-perubahan #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#form-rdiktek2 .rdiktek-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }
                }
            }
        });        
        <?php } ?>
    });

    function loadRdiktekbkn(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/sinkronsiasn/rdiktek_sinkronsiasn_data',
            data:{ 'nip': '<?php echo $nip?>', '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#xresult').html('Looading..');
            },
            success:function(response){
                $('#xresult').html(response);
            }
        });
    }    
</script>