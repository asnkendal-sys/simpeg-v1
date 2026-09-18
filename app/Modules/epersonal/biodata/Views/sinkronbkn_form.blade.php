<?php

use App\Repositories\DataUtamaRepository;
use App\Services\DataUtamaBknService;

$srv = new DataUtamaBknService(new DataUtamaRepository);

$nip = Input::get('nip');

$bkn = (object)$srv->fetchDataUtama($nip);
$rs1 = DB::table('tb_01_temp')
    ->select('tb_01_temp.*', 'a_jenkel.jenkel', 'a_stskawin.stskawin', 'a_agama.agama')
    ->leftJoin('a_jenkel', 'tb_01_temp.idjenkel', '=', 'a_jenkel.idjenkel')
    ->leftJoin('a_stskawin', 'tb_01_temp.idstskawin', '=', 'a_stskawin.idstskawin')
    ->leftJoin('a_agama', 'tb_01_temp.idagama', '=', 'a_agama.idagama')
    ->where('nip', $nip)
    ->first();

$rs2 = DB::table('tb_01')
    ->select('tb_01.*', 'a_jenkel.jenkel', 'a_stskawin.stskawin', 'a_agama.agama')
    ->leftJoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
    ->leftJoin('a_stskawin', 'tb_01.idstskawin', '=', 'a_stskawin.idstskawin')
    ->leftJoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
    ->where('nip', $nip)
    ->first();

/*catatan sinkronisasi*/
/*
     *
     Jika $idskpbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_skp yang akan dikirim sinkronisasinya
     Jika $idskpbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari bkn dan data dari r_skp simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_skpd BKN
     2. TARIK DATA KE BKN    : Untuk form preview data dari r_skpd simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>SINKRONISAI BKN</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <!--preview biodata BKN-->
                <div class="col-md-6">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan Biodata Pegawai dari BKD</li>
                            <li>Untuk melakukan sinkronisasi biodata dari BKN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                        </ul>
                    </div>
                    <div class="box-header with-border">
                        <span class="pull-left">
                            <h3 class="box-title">BIODATA PEGAWAI BKN</h3>
                        </span>
                        <span class="pull-right"><span id="skpdunit"></span></span>
                    </div>
                    {!! Form::open(array('url' => url()."/epersonal/biodata/syncdatadiri", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-biobkn')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}

                    <div class="box-body">
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Nip:</label>
                            <div class="col-sm-7">
                                <input id="nip" class="form-control" placeholder="NIP" name="nip"
                                    style="{{$bkn->nipBaru !=$rs2->nip?'border-color:red;':''}}"
                                    type="text" value="{{$bkn->nipBaru}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Nama:</label>
                            <div class="col-sm-7">
                                <input id="nama" class="form-control" placeholder="Nama"
                                    style="{{$bkn->nama != $rs2->nama?'border-color:red;':''}}"
                                    name="nama" type="text" value="{{$bkn->nama}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Gdp:</label>
                            <div class="col-sm-7">
                                <input id="gdp" class="form-control" placeholder="Gdp"
                                    style="{{$bkn->gelarDepan != $rs2->gdp?'border-color:red;':''}}"
                                    name="gdp" type="text" value="{{$bkn->gelarDepan}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Gdb:</label>
                            <div class="col-sm-7">
                                <input id="gdb" class="form-control"
                                    style="{{$bkn->gelarBelakang != $rs2->gdb?'border-color:red;':''}}"
                                    placeholder="Gdb" name="gdb" type="text" value="{{$bkn->gelarBelakang}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Agama:</label>
                            <div class="col-sm-7">
                                <input id="agama" class="form-control" placeholder="Agama"
                                    style="{{trim($bkn->agama) != trim($rs2->agama)?'border-color:red;':''}}"
                                    type="text" value="{{$bkn->agama}}" disabled>
                                <input type="hidden" name="idagama" value="{{$bkn->agamaId}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idjenkel" class="col-sm-3 control-label">Jenis Kelamin:</label>
                            <div class="col-sm-7">
                                <input id="jenkelBkn" class="form-control" placeholder="Jenis Kelamin" name="idjenkel" type="text"
                                    style="{{$bkn->jenisKelamin != $rs2->jenkel?'border-color:red;':''}}"
                                    value="{{$bkn->jenisKelamin}}" readonly>

                            </div>
                        </div>
                        <div class="form-group stskawin">
                            <label for="idstskawin" class="col-sm-3 control-label">Status Marital :</label>
                            <div class="col-sm-7">
                                <input class="form-control" placeholder="Status Maritial"
                                    style="{{$bkn->statusPerkawinan != $rs2->stskawin?'border-color:red;':''}}"
                                    name="status_maritial" type="text" value="{{$bkn->statusPerkawinan}}" readonly>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alm" class="col-sm-3 control-label">Alamat:</label>
                            <div class="col-sm-7">
                                <input id="alm" class="form-control" placeholder="Alamat"
                                    name="alm" type="text"
                                    style="{{$bkn->alamat != $rs2->alm?'border-color:red;':''}}"
                                    value="{{$bkn->alamat}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="almkdpos" class="col-sm-3 control-label">Kode POS:</label>
                            <div class="col-sm-7">
                                <input id="almkdpos" class="form-control" placeholder="Kode Pos"
                                    maxlength="6" disabled="disabled" name="kodePos" type="text"
                                    style="{{$bkn->kodePos != $rs2->almkdpos?'border-color:red;':''}}"
                                    value="{{$bkn->kodePos}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telp" class="col-sm-3 control-label">Telepon:</label>
                            <div class="col-sm-7">
                                <input id="telp" class="form-control" placeholder="Telepon"
                                    style="{{$bkn->noTelp != $rs2->telp?'border-color:red;':''}}"
                                    disabled="disabled" name="notelp" type="text" value="{{$bkn->noTelp}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hp" class="col-sm-3 control-label">HP:</label>
                            <div class="col-sm-7">
                                <input id="hp" class="form-control" placeholder="Handphone"
                                    style="{{$bkn->noHp != $rs2->hp?'border-color:red;':''}}"
                                    name="hp" type="text" value="{{$bkn->noHp}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">E-Mail:</label>
                            <div class="col-sm-7">
                                <input id="email" class="form-control" placeholder="E-Mail"
                                    style="{{$bkn->email != $rs2->email?'border-color:red;':''}}"
                                    name="email" type="text" value="{{$bkn->email}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nokarpeg" class="col-sm-3 control-label">No. Karpeg/KPE:</label>
                            <div class="col-sm-7">
                                <input id="nokarpeg" class="form-control"
                                    style="{{$bkn->noSeriKarpeg != $rs2->nokarpeg?'border-color:red;':''}}"
                                    placeholder="No. Karpeg/KPE" name="nokarpeg" type="text" value="{{$bkn->noSeriKarpeg}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="noaskes" class="col-sm-3 control-label">No. Askes:</label>
                            <div class="col-sm-7">
                                <input id="noaskes" class="form-control"
                                    style="{{$bkn->noAskes != $rs2->noaskes?'border-color:red;':''}}"
                                    placeholder="No. Askes" name="noaskes" type="text" value="{{$bkn->noAskes}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notaspen" class="col-sm-3 control-label">Taspen:</label>
                            <div class="col-sm-7">
                                <input id="notaspen" class="form-control" placeholder="Taspen"
                                    style="{{$bkn->noTaspen != $rs2->notaspen?'border-color:red;':''}}"
                                    name="notaspen" type="text" value="{{$bkn->noTaspen}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nonpwp" class="col-sm-3 control-label">NPWP:</label>
                            <div class="col-sm-7">
                                <input id="nonpwp" class="form-control" placeholder="NPWP"
                                    style="{{$bkn->noNpwp != $rs2->nonpwp?'border-color:red;':''}}"
                                    name="nonpwp" type="text" value="{{$bkn->noNpwp}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="noktp" class="col-sm-3 control-label">No. KTP:</label>
                            <div class="col-sm-7">
                                <input id="noktp" class="form-control" placeholder="No. KTP"
                                    style="{{$bkn->nik != $rs2->noktp?'border-color:red;':''}}"
                                    name="noktp" type="text" value="{{$bkn->nik}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> TARIK DATA KE SIMPEG</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> BATALKAN</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>

                <!--preview data r_skpd simpeg-->
                <div class="col-md-6">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan Biodata Pegawai dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi biodata dari SIMPEG ke BKN tekan tombol <b>SINKRONISASI DATA</b></li>
                        </ul>
                    </div>
                    <div class="box-header with-border">
                        <span class="pull-left">
                            <h3 class="box-title">BIODATA PEGAWAI SIMPEG KENDAL</h3>
                        </span>
                        <span class="pull-right"><span id="skpdunit"></span></span>
                    </div>
                    {!! Form::open(array('url' => url()."/epersonal/biodata/#", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-biosimpeg')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Nip:</label>
                            <div class="col-sm-7">
                                <input id="nip" class="form-control" placeholder="NIP" disabled="disabled"
                                    style="{{$bkn->nipBaru !=$rs2->nip?'border-color:red;':''}}"
                                    name="nip" type="text" value="<?php echo @$rs2->nip ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Nama:</label>
                            <div class="col-sm-7">
                                <input id="nama" class="form-control" placeholder="Nama" disabled="disabled"
                                    style="{{$bkn->nama != $rs2->nama?'border-color:red;':''}}"
                                    name="" type="text" value="<?php echo @$rs2->nama ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Gdp:</label>
                            <div class="col-sm-7">
                                <input id="gdp" class="form-control" placeholder="Gdp"
                                    style="{{$bkn->gelarDepan != $rs2->gdp?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->gdp ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Gdb:</label>
                            <div class="col-sm-7">
                                <input id="gdb" class="form-control" placeholder="Gdb" disabled="disabled"
                                    style="{{$bkn->gelarBelakang != $rs2->gdb?'border-color:red;':''}}"
                                    name="" type="text" value="<?php echo @$rs2->gdb ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idagama" class="col-sm-3 control-label">Agama:</label>
                            <div class="col-sm-7">
                                <input id="agama" class="form-control" placeholder="Agama"
                                    style="{{trim($bkn->agama) != trim($rs2->agama)?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->agama ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idjenkel" class="col-sm-3 control-label">Jenis Kelamin:</label>
                            <div class="col-sm-7">
                                <input id="jenkel" class="form-control" placeholder="Jenis Kelamin" disabled="disabled"
                                    style="{{$bkn->jenisKelamin != $rs2->jenkel?'border-color:red;':''}}"
                                    name="jenkel" type="text" value="<?php echo @$rs2->jenkel ?>">

                            </div>
                        </div>
                        <div class="form-group stskawin">
                            <label for="idstskawin" class="col-sm-3 control-label">Status Marital :</label>
                            <div class="col-sm-7">
                                <input class="form-control" placeholder="Status Maritial" disabled="disabled"
                                    style="{{$bkn->statusPerkawinan != $rs2->stskawin?'border-color:red;':''}}"
                                    name="" type="text" value="<?php echo @$rs2->stskawin ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alm" class="col-sm-3 control-label">Alamat:</label>
                            <div class="col-sm-7">
                                <input id="alm" class="form-control" placeholder="Alamat"
                                    style="{{$bkn->alamat !== $rs2->alm?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->alm ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="almkdpos" class="col-sm-3 control-label">Kode POS:</label>
                            <div class="col-sm-7">
                                <input id="almkdpos" class="form-control" placeholder="Kode Pos"
                                    maxlength="6" disabled="disabled" name=""
                                    style="{{$bkn->kodePos != $rs2->almkdpos?'border-color:red;':''}}"
                                    type="text" value="<?php echo @$rs2->almkdpos ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telp" class="col-sm-3 control-label">Telepon:</label>
                            <div class="col-sm-7">
                                <input id="telp" class="form-control" placeholder="Telepon"
                                    style="{{$bkn->noTelp != $rs2->telp?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->telp ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hp" class="col-sm-3 control-label">HP:</label>
                            <div class="col-sm-7">
                                <input id="hp" class="form-control" placeholder="Handphone"
                                    style="{{$bkn->noHp != $rs2->hp?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->hp ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">E-Mail:</label>
                            <div class="col-sm-7">
                                <input id="email" class="form-control" placeholder="E-Mail"
                                    style="{{$bkn->email != $rs2->email?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->email ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nokarpeg" class="col-sm-3 control-label">No. Karpeg/KPE:</label>
                            <div class="col-sm-7">
                                <input id="nokarpeg" class="form-control" placeholder="No. Karpeg/KPE"
                                    style="{{$bkn->noSeriKarpeg != $rs2->nokarpeg?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->nokarpeg ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="noaskes" class="col-sm-3 control-label">No. Askes:</label>
                            <div class="col-sm-7">
                                <input id="noaskes" class="form-control" placeholder="No. Askes"
                                    style="{{$bkn->noAskes != $rs2->noaskes?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->noaskes ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notaspen" class="col-sm-3 control-label">Taspen:</label>
                            <div class="col-sm-7">
                                <input id="notaspen" class="form-control" placeholder="Taspen"
                                    style="{{$bkn->noTaspen != $rs2->notaspen?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->notaspen ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nonpwp" class="col-sm-3 control-label">NPWP:</label>
                            <div class="col-sm-7">
                                <input id="nonpwp" class="form-control" placeholder="NPWP"
                                    style="{{$bkn->noNpwp != $rs2->nonpwp?'border-color:red;':''}}"
                                    disabled="disabled" name="" type="text" value="<?php echo @$rs2->nonpwp ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="noktp" class="col-sm-3 control-label">No. KTP:</label>
                            <div class="col-sm-7">
                                <input id="noktp" class="form-control" placeholder="No. KTP" disabled="disabled" name="" type="text"
                                    style="{{$bkn->nik != $rs2->noktp?'border-color:red;':''}}"
                                    value="<?php echo @$rs2->noktp ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">

                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.tab-content -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        changeBorderToDanger()
        $('#form-biobkn').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Sinkroniasi Data BKN ke Simpeg ?', function(a) {


                if (a == true) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        data: $this.serialize(),
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            console.log(html);
                            preloader.off();
                            if ((html == 1) || (html == 4)) {
                                notification('Data Berhasil Tersinkronisasi.', 'success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRskp();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>