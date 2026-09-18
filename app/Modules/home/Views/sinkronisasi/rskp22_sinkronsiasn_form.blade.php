<?php
//    use App\Services\SkpService;
//    use App\Repositories\SkpRepository;

    $nip = Input::get('nip');
    $idskp = Input::get('id');
    $idbkn = Input::get('idskpbkn');

    if($idbkn != ''){
//        $srv = new SkpService(new SkpRepository);
//        $skp = $srv->fetch($nip)->filter('tahun',2021)->first();
        $skp = accessDatapersonalsiasn('skp22/id',$idbkn);

//        echo "<pre>";
//            print_r($skp);
//        echo "</pre>";
//        exit();
    }

    /*catatan sinkronisasi*/
    /*
     *
     Jika $idbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_skp yang akan dikirim sinkronisasinya
     Jika $idbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari SIASN dan data dari r_skp simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_skp SIASN
     2. TARIK DATA KE SIASN    : Untuk form preview data dari r_skp simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        @if($idskp != '')
        <li class="active"><a data-toggle="tab" href="#tab_syx1"><i class="fa fa-pencil"></i> <b>SINKRONISAI SIASN</b></a></li>
        @endif
        <li class="<?php echo (($idskp != '')?'':'active')?>"><a data-toggle="tab" id="xdatabkn" href="#tab_syx2"><i class="fa fa-list"></i> <b>DATA SKP 22 SIASN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($idskp != '')
        <div id="tab_syx1" class="tab-pane active">
            <br>
            <div class="row">
                @if($idbkn != '')
                    <!--preview data r_skp SIASN-->
                    <div class="col-md-6">
                        <div class="alert callout callout-success">
                            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                            <ul style="padding-left: 15px">
                                <li>Preview data yang ditampilkan merupakan data Riwayat SKP 22 dari SIASN</li>
                                <li>Untuk melakukan sinkronisasi data SKP 22 dari SIASN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                                <li>Ketika proses <b>TARIK DATA</b> selesai riwayat SKP 22 dari SIASN sudah terkoneksi dengan SIMPEG</li>
                            </ul>
                        </div>

                        {!! Form::open(array('url' => url().'/syncrskp22bkn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp221')) !!}
                        {!! Form::hidden('id', $idskp, array('id'=> 'id')) !!}
                        {!! Form::hidden('idskpbkn', $idbkn, array('id'=> 'idskpbkn')) !!}
                        {!! Form::hidden('penilaiGolonganId', $skp->penilaiGolonganId, array('id'=> 'penilaiGolonganId')) !!}
                        <div class="box-body">
                            <b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                            <div class="form-group">
                                {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tahun', $skp->tahun, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                            <b class="box-title"><i class="fa fa-fw fa-child"></i> KINERJA</b><hr>

                            <div class="form-group">
                                {!! Form::label('hasilKinerja', 'Rating Hasil Kinerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::hidden('hasilKinerjatext', $skp->hasilKinerja, array('id'=> 'hasilKinerjatext')) !!}
                                    {!! Form::hidden('hasilKinerjaNilai', $skp->hasilKinerjaNilai, array('id'=> 'hasilKinerjaNilai')) !!}
                                    {!! Form::text('hasilKinerja', $skp->hasilKinerjaNilai." | ".$skp->hasilKinerja, array('class'=> 'form-control', 'placeholder'=>'Rating Hasil Kinerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('perilakuKerja', 'Rating Perilaku Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">

                                    {!! Form::hidden('perilakuKerjatext', $skp->perilakuKerja, array('id'=> 'PerilakuKerjatext')) !!}
                                    {!! Form::hidden('PerilakuKerjaNilai', $skp->PerilakuKerjaNilai, array('id'=> 'PerilakuKerjaNilai')) !!}
                                    {!! Form::text('perilakuKerja', $skp->PerilakuKerjaNilai." | ".$skp->perilakuKerja, array('class'=> 'form-control', 'placeholder'=>'Rating Perilaku Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                {!! Form::label('kuadranKinerja', 'Kuadran Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::hidden('kuadranKinerjatext', $skp->kuadranKinerja, array('id'=> 'KuadranKinerjatext')) !!}
                                    {!! Form::hidden('KuadranKinerjaNilai', $skp->KuadranKinerjaNilai, array('id'=> 'KuadranKinerjaNilai')) !!}
                                    {!! Form::text('kuadranKinerja', $skp->KuadranKinerjaNilai." | ".$skp->kuadranKinerja, array('class'=> 'form-control', 'placeholder'=>'Kuadran Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                            <b class="box-title"><i class="fa fa-fw fa-child"></i> PEJABAT PENILAI</b><hr>
                            <div class="form-group">
                                {!! Form::label('statusPenilai', 'Status Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('statusPenilai', $skp->statusPenilai, array('class'=> 'form-control', 'placeholder'=>'Status Pejabat Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group nonasn">
                                {!! Form::label('nipNrpPenilai', 'NIP Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nipNrpPenilai', $skp->nipNrpPenilai, array('class'=> 'form-control', 'placeholder'=>'NIP Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group non">
                                {!! Form::label('namaPenilai', 'Nama Lengkap:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('namaPenilai', $skp->namaPenilai, array('class'=> 'form-control', 'placeholder'=>'Nama Lengkap', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('penilaiJabatanNm', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiJabatanNm', $skp->penilaiJabatanNm, array('class'=> 'form-control', 'placeholder'=>'Jabatan ', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group nonasn">
                                {!! Form::label('penilaiUnorNm', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiUnorNm', $skp->penilaiUnorNm, array('class'=> 'form-control', 'placeholder'=>'Unit Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

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

                @if($idskp != 'x')
                <!--preview data r_skp simpeg-->
                <div class="col-md-<?php echo (($idbkn != '')?6:12)?>">
                    <div class="alert callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat SKP 22 dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke SIASN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada riwayat SKP 22 SIMPEG sudah terkoneksi dengan SIASN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url().'/syncrskp22simpegsiasn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp222')) !!}
                    <div class="box-body rskp-perubahan">
                        <b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                                {!! Form::hidden('idskpbkn', null, array('id'=> 'idskpbkn')) !!}
                                {!! Form::text('tahun', null, array('class'=> 'form-control num', 'placeholder'=>'Tahun', 'maxlength'=> 4, 'required'=>'required')) !!}

                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('nippenilai', 'NIP Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nippenilai" class="form-control nippenilai" id="nippenilai" style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejpenilai', 'Nama Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejpenilai', null, array('class'=> 'form-control', 'placeholder'=>'Nama Pejabat Penilai')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabpenilai', 'Jab Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('jabpenilai', null, array('class'=> 'form-control', 'placeholder'=>'Jab Pejabat Penilai')) !!}
                                <!-- LIST INPUT TYPE HIDDEN -->
                                <!-- <input class="idjenjabpenilai" name="idjenjabpenilai" type="text">
                                <input class="idjabpenilai" name="idjabpenilai" type="text"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpd', 'OPD:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <input id="idskpdpenilai" name="idskpdpenilai" type="hidden">
                                {!! Form::text('skpd', null, array('class'=> 'form-control', 'placeholder'=>'OPD')) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('capaiankinerja', 'Capaian Kinerja Organisasi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!!combo_capaianKinerja("capaiankinerja","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ratinghasil', 'Rating Hasil Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!!combo_ratingHasil("ratinghasil","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ratingperilaku', 'Rating Perilaku Kinerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!!combo_ratingPerilaku("ratingperilaku","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('predikatkinerja', 'Predikat Kinerja Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!!combo_predikatKinerja("predikatkinerja","","")!!}
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

        <div id="tab_syx2" class="tab-pane <?php echo (($idskp != '')?'':'active')?>">
            <br>
            <div class="row">
                <div class="alert callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Menu ini menampilkan data riwayat SKP 22 dari SIASN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data SKP 22 dari SIASN ke SIMMPEG</li>
                    </ul>
                </div>

                <table class="table table-striped table-hover table-condensed table-bordered" role="grid" id="tb-rpangkat">
                    <thead class="bg-primary">
                    <tr>
                        <th width="2%"><div class="text-center">NO</div></th>
                        <th><div class="text-center">TAHUN</div></th>
                        <th><div class="text-center">RATING HASIL KERJA</div></th>
                        <th><div class="text-center">RATING PERILAKU KERJA</div></th>
                        <th><div class="text-center">KUADRAN KERJA</div></th>
                        <th><div class="text-center">JABATAN PENILAI</div></th>
                        <th><div class="text-center">JABATAN PENILAI</div></th>
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

        <?php if($idskp == '') { ?>
        loadRskp22bkn();
        <?php } ?>

        $('#xdatabkn').on('click', function(){
            loadRskp22bkn();
        })

        $("#form-rskp222 .rskp-perubahan .nippenilai").on('change', function(e){
            e.preventDefault();
            var nippenilai = $("#form-rskp222 .rskp-perubahan .nippenilai").val();
            if (nippenilai != null) {
                $.ajax({
                    url: '{{url('')}}/ecuti/nominatifcuti/detailpegawai',
                    type: 'post',
                    data: { 'nip':nippenilai,'_token':'{!!csrf_token()!!}'},
                    success:function(response){
                        var ret = $.parseJSON(response);
                        $("#form-rskp222 .rskp-perubahan #pejpenilai").val(ret.nama);
                        $("#form-rskp222 .rskp-perubahan #jabpenilai").val(ret.jab);
                        $("#form-rskp222 .rskp-perubahan #skpd").val(ret.skpd);

                        $("#form-rskp222 .rskp-perubahan #idjenjabpenilai").val(ret.idjenjab);
                        $("#form-rskp222 .rskp-perubahan #idjabpenilai").val(ret.idjab);
                        $("#form-rskp222 .rskp-perubahan #idskpdpenilai").val(ret.idskpd);
                    }
                });
            }else{
                $("#form-rskp222 .rskp-perubahan #pejpenilai").val('');
                $("#form-rskp222 .rskp-perubahan #jabpenilai").val('');
                $("#form-rskp222 .rskp-perubahan #skpd").val('');

                $("#form-rskp222 .rskp-perubahan #idjenjabpenilai").val('');
                $("#form-rskp222 .rskp-perubahan #idjabpenilai").val('');
                $("#form-rskp222 .rskp-perubahan #idskpdpenilai").val('');
            }
        }).trigger('change');

        $('#form-rskp221').on('submit',function(e){

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
                                loadKinerjaasn();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rskp222').on('submit',function(e){

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
                                loadKinerjaasn();
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_kinerjaasn','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrselect2 = new Array("capaiankinerja","ratinghasil","ratingperilaku","predikatkinerja");
                if(ret){
                    for(attrname in ret){
                        $('#form-rskp222 .rskp-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rskp222 .rskp-perubahan #'+attrname).val(ret[attrname]).trigger('change.select2');
                        }
                    }

                    autoComplete2('#form-rskp222 .rskp-perubahan .nippenilai', '{{url('')}}/ecuti/nominatifcuti/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nippenilai, ret.nippenilai, '');
                }
            }
        });
        <?php } else { ?>
            autoComplete2('#form-rskp222 .rskp-perubahan .nippenilai', '{{url('')}}/ecuti/nominatifcuti/caripegawai', 'Ketikkan NIP atau Nama', null, '{!!Input::get("id")!!}', '{!!Input::get("id")!!}', '');
        <?php } ?>
    });

    function loadRskp22bkn(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/sinkronsiasn/rskp22_sinkronsiasn_data',
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