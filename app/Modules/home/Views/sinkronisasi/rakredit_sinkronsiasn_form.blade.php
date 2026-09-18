<?php
//    use App\Services\SkpService;
//    use App\Repositories\SkpRepository;

    $nip = Input::get('nip');
    $idakredit = Input::get('id');
    $idbkn = Input::get('idakreditbkn');

    if($idbkn != ''){
//        $srv = new SkpService(new SkpRepository);
//        $akredit = $srv->fetch($nip)->filter('tahun',2021)->first();
        $akredit = accessDatapersonalsiasn('angkakredit/id',$idbkn);
    }

    /*catatan sinkronisasi*/
    /*
     *
     Jika $idbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_akredit yang akan dikirim sinkronisasinya
     Jika $idbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari SIASN dan data dari r_akredit simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_akredit SIASN
     2. TARIK DATA KE SIASN    : Untuk form preview data dari r_akredit simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        @if($idakredit != '')
        <li class="active"><a data-toggle="tab" href="#tab_syx1"><i class="fa fa-pencil"></i> <b>SINKRONISAI SIASN</b></a></li>
        @endif
        <li class="<?php echo (($idakredit != '')?'':'active')?>"><a data-toggle="tab" id="xdatabkn" href="#tab_syx2"><i class="fa fa-list"></i> <b>DATA ANGKA KREDIT SIASN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($idakredit != '')
        <div id="tab_syx1" class="tab-pane active">
            <br>
            <div class="row">
                @if($idbkn != '')
                    <!--preview data r_akredit SIASN-->
                    <div class="col-md-6">
                        <div class="alert callout callout-success">
                            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                            <ul style="padding-left: 15px">
                                <li>Preview data yang ditampilkan merupakan data Riwayat Angka Kredit dari SIASN</li>
                                <li>Untuk melakukan sinkronisasi data Riwayat Angka Kredit dari SIASN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                                <li>Ketika proses <b>TARIK DATA</b> selesai Riwayat Angka Kredit dari SIASN sudah terkoneksi dengan SIMPEG</li>
                            </ul>
                        </div>

                        {!! Form::open(array('url' => url().'/syncrakreditbkn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rakredit1')) !!}
                        {!! Form::hidden('id', $idakredit, array('id'=> 'id')) !!}
                        {!! Form::hidden('idakreditbkn', $idbkn, array('id'=> 'idakreditbkn')) !!}
                        <div class="box-body">
                            <b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                            <div class="form-group">
                                {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>   
                                 <div class="form-group">
                            {!! Form::label('jabfung', 'JABATAN:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('jabfung',  $akredit->namaJabatan, array('class'=> 'form-control','placeholder'=>'JABATAN', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>

                            <div class="form-group">
                                {!! Form::label('nomorSk', 'No. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nomorSk', $akredit->nomorSk, array('class'=> 'form-control', 'placeholder'=>'Tanggal SK', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tanggalSk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tanggalSk', $akredit->tanggalSk, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                               
                            <div class="form-group">
                                {!! Form::label('tahunMulaiPenailan', 'Periode Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tahunMulaiPenailan', '01-'.$akredit->bulanMulaiPenailan.'-'.$akredit->tahunMulaiPenailan, array('class'=> 'form-control', 'placeholder'=>'Periode Mulai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tahunSelesaiPenailan', 'Periode Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tahunSelesaiPenailan', '30-'.$akredit->bulanSelesaiPenailan.'-'.$akredit->tahunSelesaiPenailan, array('class'=> 'form-control', 'placeholder'=>'Periode Selesai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('kreditUtamaBaru', 'Kredit Utama Baru:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kreditUtamaBaru', $akredit->kreditUtamaBaru, array('class'=> 'form-control', 'placeholder'=>'Kredit Utama Baru', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('kreditPenunjangBaru', 'Kredit Penunjang Baru:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kreditPenunjangBaru', $akredit->kreditPenunjangBaru, array('class'=> 'form-control', 'placeholder'=>'Kredit Penunjang Baru', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('kreditBaruTotal', 'Kredit Baru Total:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kreditBaruTotal', $akredit->kreditBaruTotal, array('class'=> 'form-control', 'placeholder'=>'Kredit Baru Total', 'readonly'=>'readonly')) !!}
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

                @if($idakredit != 'x')
                <!--preview data r_akredit simpeg-->
                <div class="col-md-<?php echo (($idbkn != '')?6:12)?>">
                    <div class="alert callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat Angka Kredit dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke SIASN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada Riwayat Angka Kredit SIMPEG sudah terkoneksi dengan SIASN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url().'/syncrakreditsimpegsiasn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rakredit2')) !!}
                    <div class="box-body rakredit-perubahan">
                        <b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                                {!! Form::hidden('idakreditbkn', null, array('id'=> 'idakreditbkn')) !!}
                                {!! Form::text('nip', $nip, array('class'=> 'form-control ', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjabfung', 'Jabatan Fungsional:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="idjabfung" class="form-control" id="idjabfung" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                {!! Form::hidden('jabfung', null, array('class'=> 'form-control', 'id'=> 'jabfung')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pak', 'Jumlah Angka Kredit Lama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pak', null, array('class'=> 'form-control num pak', 'placeholder'=>'000.000')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosk', 'No. SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'No. SK')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                                     <div class="form-group">
                            {!! Form::label('jenisakred', 'Jenis Akreditasi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred1" value="1" checked=""> Pertama
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred2" value="2"> Integrasi
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred3" value="3"> Konversi
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('periodemulai', 'Periode Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('periodemulai', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('periodeselesai', 'Periode Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('periodeselesai', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kubaru', 'Kredit Utama Baru:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kubaru', null, array('class'=> 'form-control num hitung', 'placeholder'=>'000.000')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kpbaru', 'Kredit Penunjang Baru:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kpbaru', null, array('class'=> 'form-control num hitung', 'placeholder'=>'000.000')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kbtotal', 'Kredit Baru Total:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kbtotal', null, array('class'=> 'form-control num', 'placeholder'=>'000.000', 'readonly'=> '')) !!}
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

        <div id="tab_syx2" class="tab-pane <?php echo (($idakredit != '')?'':'active')?>">
            <br>
            <div class="row">
                <div class="alert callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Menu ini menampilkan data Riwayat Angka Kredit dari SIASN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data Riwayat Angka Kredit dari SIASN ke SIMMPEG</li>
                    </ul>
                </div>

                <table class="table table-striped table-hover table-condensed table-bordered" role="grid" id="tb-rpangkat">
                    <thead class="bg-primary">
                    <tr>
                        <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                        <th rowspan="2"><div class="text-center">NOMOR SK</div></th>
                        <th rowspan="2"><div class="text-center">TANGGAL SK</div></th>
                        <th colspan="2"><div class="text-center">PERIODE PENILAIAN ANGKA KREDIT</div></th>
                        <th rowspan="2"><div class="text-center">KREDIT UTAMA BARU</div></th>
                        <th rowspan="2"><div class="text-center">KREDIT PENUNJANG BARU</div></th>
                        <th rowspan="2"><div class="text-center">KREDIT BARU TOTAL</div></th>
                        <th rowspan="2"><div class="text-center">BERKAS FILE</div></th>
                        <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th>
                    </tr>
                    <tr>
                        <th><div class="text-center">MULAI</div></th>
                        <th><div class="text-center">SELESAI</div></th>
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

        <?php if($idakredit == '') { ?>
        loadRakreditbkn();
        <?php } ?>

        $('#xdatabkn').on('click', function(){
            loadRakreditbkn();
        })

        $('#form-rakredit2 .rakredit-perubahan select').select2();
        autoComplete('#form-rakredit2 .rakredit-perubahan #idjabfung', '{!!url()!!}/getjabfung', '.: Pilihan :.', null, '', '', '');
        $('#form-rakredit2 .rakredit-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rakredit2 .rakredit-perubahan .date").mask("99-99-9999");
        $("#form-rakredit2 .rakredit-perubahan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rakredit2 .rakredit-perubahan .hitung').keyup(function(e){
            e.preventDefault();
            var kubaru = parseFloat($('.rakredit-perubahan #kubaru').val()) || 0;
            var kpbaru = parseFloat($('.rakredit-perubahan #kpbaru').val()) || 0;

            var kbtotal = parseFloat(kubaru) + parseFloat(kpbaru);

            $('.rakredit-perubahan #kbtotal').val(kbtotal.toFixed(3));
        });

        $('#form-rakredit2 .rakredit-perubahan #idjabfung').on('change', function(e){
            e.preventDefault();
            $('#form-rakredit2 .rakredit-perubahan #jabfung').val($(this).find(":selected").text());
        })

        $('#form-rakredit2 .rakredit-perubahan .pak').on('change', function(e){
            e.preventDefault();
            var pak = parseFloat($(this).val()) || 0;
            var koma = '0.000'
            var pak_ = parseFloat(pak) + parseFloat(koma);

            $('.rakredit-perubahan .pak').val(pak_.toFixed(3));
        });

        $('#form-rakredit1').on('submit',function(e){

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
                            if((html=='1') || (html=='4')){
                                notification('Data Berhasil Tersinkronisasi.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRakredit();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rakredit2').on('submit',function(e){

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
                            if((html=='1') || (html=='4')){
                                notification('Data Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRakredit();
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_akredit','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array('tgsk','periodemulai','periodeselesai');
                var arrselect2 = new Array('');
             var arrayradio = new Array("jenisakred");
                if(ret){
                    for(attrname in ret){
                        $('#form-rakredit2 .rakredit-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rakredit2 .rakredit-perubahan #'+attrname).val(ret[attrname]).trigger('change.select2');
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#form-rakredit2 .rakredit-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    if ($.inArray(attrname, arrayradio) != -1) {
                                $('input[name=' + attrname + '][value=' + ret[attrname] + ']').prop('checked', true);
                            }
                    }

                    $("#form-rakredit2 .rakredit-perubahan #idjabfung").data('select2').trigger('select', {
                        data: {"id":ret.idjabfung,"text":ret.jabfung}
                    });
                }
            }
        });        
        <?php } ?>
    });

    function loadRakreditbkn(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/sinkronsiasn/rakredit_sinkronsiasn_data',
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