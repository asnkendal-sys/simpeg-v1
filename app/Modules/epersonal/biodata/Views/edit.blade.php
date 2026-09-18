<?php
if (session('role_id') <= 3) {
    $alert = "Simpan data ?";
} else {
    $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Update Biodata ?</li></ul>";
}
?>

<section class="content-header">
    <h1>
        Edit Biodata<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Biodata</a></li>
        <li class="active">Edit Biodata</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <span class="pull-left">
                        <h3 class="box-title">BIODATA PEGAWAI</h3>
                    </span>
                    <span class="pull-right"><span id="skpdunit"></span></span>
                </div>
                {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'edit':'edittemp'), 'method'=> 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                    {!! Form::hidden('id', null, array('id'=>'id')) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2" align="center">
                                <div class="widget-user-image">
                                    <img alt="User Image" id='propic' class="img-circle" src="{!!url()!!}/packages/upload/photo/pegawai/default.jpg" width="128" height="128">
                                    <p>
                                        <a href="javascript:void(0)" id="changeimage"><em><small><i class="fa fa-pencil" title="Ganti Foto Pegawai"></i>&nbsp;Ganti&nbsp;Foto</small></em></a><br>
                                        <span align='center' class='nip-text'></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nip', 'NIP :', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-4">
                                        @if(session('role_id') == 5)
                                        <input type="text" value="{!!session('user_id')!!}" id="nip" name="nip" readonly class="form-control">
                                        @else
                                        <select name="nip" class="form-control" id="nip" style="width: 100%"></select>
                                        @endif
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::text('niplama', null, array('class'=> 'form-control awal', 'id'=>'niplama', 'placeholder'=>'NIP Lama', 'maxlength'=>9)) !!}
                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-info awal" id="xreset" type="button" title="Reset"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                                @if (session('role_id') <= 3)
                                    <div class="form-group">
                                    {!! Form::label('nama', 'Nama :', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        {!! Form::text('gdp', null, array('class'=> 'form-control awal', 'id'=>'gdp', 'placeholder'=>'Ex: Drs. ')) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::text('nama', null, array('class'=> 'form-control awal', 'placeholder'=>'Nama Lengkap')) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::text('gdb', null, array('class'=> 'form-control awal', 'id'=>'gdb', 'placeholder'=>'Ex: SE, M.Kom')) !!}
                                    </div>
                            </div>
                            @else
                            <div class="form-group">
                                {!! Form::label('nama', 'Nama :', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-2">
                                    {!! Form::text('gdp', null, array('class'=> 'form-control awal', 'id'=>'gdp', 'placeholder'=>'Ex: Drs. ', 'readonly'=>'readonly')) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::text('nama', null, array('class'=> 'form-control awal', 'placeholder'=>'Nama Lengkap', 'readonly'=>'readonly')) !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::text('gdb', null, array('class'=> 'form-control awal', 'id'=>'gdb', 'placeholder'=>'Ex: SE, M.Kom', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                {!! Form::label('tmlhr', 'Kelahiran :', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-4">
                                    <select name="tmlhr" class="form-control awal" id="tmlhr" style="width: 100%"></select>
                                </div>
                                <div class="col-sm-3">
                                    <div class='input-group datepicker'>
                                        {!! Form::text('tglhr', null, array('class'=> 'form-control date awal', 'id'=>'tglhr', 'placeholder'=>'Tanggal Lahir')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="box-footer">
                <div class="pull-left">
                    <button class="btn btn-primary awal print" type="button"><i class="fa fa-print"></i> Print</button>
                    <!--<button class="btn btn-success awal sinkprofilbkn" type="button"><i class="fa fa-repeat"></i> Sinkronisasi SAPK</button>-->
                    <button class="btn btn-success awal sinkprofilsiasn" type="button"><i class="fa fa-repeat"></i> Sinkronisasi SIASN</button>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success awal" type="submit" id=""><i class="fa fa-floppy-o"></i> Simpan</button>
                    &nbsp;
                    &nbsp;
                    @if(session('role_id') == 5)
                    <a class="btn btn-warning" href="{!!url()!!}/dashboard"><i class="fa fa-times-circle-o"></i> Batalkan</a>
                    @else
                    <a class="btn btn-warning awal" href="{!!url()!!}/epersonal/biodata" id="batalkan"><i class="fa fa-times-circle-o"></i> Batalkan</a>
                    @endif
                </div>
            </div>
            <div class="box-footer"></div>

            <div class="alert alert-warning alert-biodata" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Perhatian :</span>
                <em style="font-size: 14px">Biodata pegawai yang ditampilkan belum terverifikasi. <a href="javascript:void(0)" class="prevbiodata" recrole="{!! session('role_id') !!}" title="Lihat Perubahan Biodata">Lihat biodata asli atau perubahan biodata yang belum diverifikasi.</a></em>
            </div>

            <div class="alert alert-warning alert-jenkedudupeg" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Perhatian :</span>
                <em style="font-size: 14px">Pegawai yang ditampilkan sudah tidak aktif</em>
            </div>

            <div class="box-body">
                <!--<div class="col-md-12">-->
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom" style="box-shadow:none;">
                    <ul class="nav nav-tabs tab1" id="myTab">
                        <li class="active"><a data-toggle="tab" href="#biodata"> <i class="fa fa-fw fa-child"></i> BIODATA PRIBADI</a></li>
                        <li><a data-toggle="tab" href="#lokasijab"> <i class="fa fa-fw fa-map-marker"></i> LOKASI & JABATAN</a></li>
                        <li><a data-toggle="tab" href="#pangkatgol"> <i class="fa fa-fw fa-paper-plane-o"></i> CPNS / PNS</a></li>
                        <li><a data-toggle="tab" href="#pangkat"> <i class="fa fa-fw fa-anchor"></i> PANGKAT TERAKHIR</a></li>
                        <li><a data-toggle="tab" href="#kgbterakhir"> <i class="fa fa-fw fa-money"></i> KGB TERAKHIR</a></li>
                        <li><a data-toggle="tab" href="#pendidikan"> <i class="fa fa-fw fa-graduation-cap"></i> PENDIDIKAN</a></li>
                        <li><a data-toggle="tab" href="#riwayat"> <i class="fa fa-fw fa-stethoscope"></i> RIWAYAT</a></li>
                        <li><a data-toggle="tab" href="#keluarga"> <i class="fa fa-fw fa-venus-mars"></i> KELUARGA</a></li>
                        <li><a data-toggle="tab" href="#datalain"> <i class="fa fa-fw fa-recycle"></i> DATA LAIN</a></li>
                        <li><a data-toggle="tab" href="#edokumen"> <i class="fa fa-fw fa-book"></i> E-DOKUMEN</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="biodata" class="tab-pane active">
                            <p>
                            <div class="box-header with-border">
                                <b class="box-title"><small>BIODATA PRIBADI</small></b>
                            </div>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! comboAgama("idagama","","") !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <label class="radio-inline">
                                                <input type="radio" id="idjenkel1" value="1" name="idjenkel"> Laki-laki
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="idjenkel2" value="2" name="idjenkel"> Perempuan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group stskawin">
                                        {!! Form::label('idstskawin', 'Status Marital :', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! comboStsmarital("idstskawin","","") !!}
                                        </div>
                                    </div>
                                    <div class="form-group stsdujan">
                                        {!! Form::label('idstsdujan', 'Status Duda/Janda :', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! comboStsDujan("idstsdujan","idstsdujan","") !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('idgoldarah', 'Golongan Darah:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! comboGoldarah("idgoldarah","","") !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('alm', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('alm', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almrt', 'RT:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-3">
                                            {!! Form::text('almrt', null, array('class'=> 'form-control num', 'placeholder'=> 'RT', 'maxlength'=>3)) !!}
                                        </div>
                                        <div class="col-sm-1" style="margin-top: 7px;">
                                            <b>RW: </b>
                                        </div>
                                        <div class="col-sm-3">
                                            {!! Form::text('almrw', null, array('class'=> 'form-control num', 'id'=>'almrw', 'placeholder'=> 'RW', 'maxlength'=>3)) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almdesa', 'Desa/Kelurahan:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('almdesa', null, array('class'=> 'form-control', 'placeholder'=> 'Desa/Kelurahan')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almkec', 'Kecamatan:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('almkec', null, array('class'=> 'form-control', 'placeholder'=> 'Kecamatan')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almkab', 'Kabupaten/Kota:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('almkab', null, array('class'=> 'form-control', 'placeholder'=> 'Kabupaten')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almprov', 'Provinsi:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('almprov', null, array('class'=> 'form-control', 'placeholder'=> 'Provinsi')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('almkdpos', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('almkdpos', null, array('class'=> 'form-control', 'placeholder'=> 'Kode Pos', 'maxlength'=>6)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('telp', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('telp', null, array('class'=> 'form-control', 'placeholder'=> 'Telepon')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('hp', 'No HP:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('hp', null, array('class'=> 'form-control', 'placeholder'=> 'Handphone')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('email_dinas', 'E-Mail Gov:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('email_dinas', null, array('class'=> 'form-control', 'placeholder'=> 'E-Mail Dinas', 'readonly'=>'readonly')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('email', 'E-Mail Pribadi:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('email', null, array('class'=> 'form-control', 'placeholder'=> 'E-Mail')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nokarpeg', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('nokarpeg', null, array('class'=> 'form-control', 'placeholder'=> 'No. Karpeg/KPE')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('noaskes', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('noaskes', null, array('class'=> 'form-control', 'placeholder'=> 'No. Askes')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('notaspen', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('notaspen', null, array('class'=> 'form-control', 'placeholder'=> 'Taspen')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nokaris', ' No. Karis/Karsu:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('nokaris', null, array('class'=> 'form-control', 'placeholder'=> 'Karis/Karsu')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nonpwp', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('nonpwp', null, array('class'=> 'form-control', 'placeholder'=> 'NPWP')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('noktp', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('noktp', null, array('class'=> 'form-control', 'placeholder'=> 'No. KTP')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nobapertarum', 'Bapertarum:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('nobapertarum', null, array('class'=> 'form-control', 'placeholder'=> 'Bapertarum')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div id="lokasijab" class="tab-pane">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                    <div class="box-header with-border">
                                        <b class="box-title"><small>LOKASI KERJA</small></b>
                                    </div>
                                    </p>
                                    <div class="form-group div-disabled">
                                        {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! comboSkpdunit("kdunit","","") !!}
                                        </div>
                                    </div>
                                    <div class="form-group div-disabled">
                                        {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                        </div>
                                    </div>
                                    @if (session('role_id')!=5 && session('role_id')!=4)
                                    <div class="form-group">
                                        @else
                                        <div class="form-group  div-disabled">
                                            @endif

                                            {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <label class="radio-inline">
                                                    <input type="radio" name="idstspeg" id="idstspeg1" value="1" checked=""> CPNS
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="idstspeg" id="idstspeg2" value="2"> PNS
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="idstspeg" id="idstspeg3" value="3"> PPPK
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="idstspeg" id="idstspeg3" value="4"> PPPK PARUH WAKTU
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboJenkepeg("idjenkepeg","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboJenkedudupeg("idjenkedudupeg","","") !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>JABATAN TERAKHIR</small></b>
                                        </div>
                                        </p>
                                        <div class="form-group">
                                            {!! Form::label('pejmenjbt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenjbt","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboJenjab("idjenjab","","") !!}
                                            </div>
                                        </div>

                                        <div class="xisttb">
                                            <div class="form-group">
                                                <label for="isttb" class="col-sm-3 control-label">Menjabat Koordinator</label>
                                                <div class="col-sm-7">
                                                    <div class="checkbox">
                                                        <input type="radio" id="isttb1" name="isttb" value="1" required id="isttb1" /> Ya
                                                        <input type="radio" id="isttb0" name="isttb" value="0" required id="isttb2" /> Tidak
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('idkoord', 'Koordinator:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! comboSubkoord("idkoord","","") !!}
                                                </div>
                                            </div>

                                        </div>

                                        <div id="xjenisjabatan">
                                            <div class="form-group">
                                                {!! Form::label('idjabjbt', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7" id="jenisjabatan">
                                                    <select name="idjabjbt" class="form-control" id="idjabjbt" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('noskjbt', ' NO. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskjbt', null, array('class'=> 'form-control', 'placeholder'=> 'No. SK Jabatan')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskjbt', 'TGL. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskjbt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtjbt', 'TMT Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtjbt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="pangkatgol" class="tab-pane">
                                <!--start pangkat pppk-->
                                <div class="row" id="pengangkatanpppk">
                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title title1"><small>PENGANGKATAN PPPK</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('pejmenawal_pppk', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenawal_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noskcalonawal_pppk', ' NO. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskcalonawal_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Calon PPPK')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskcalonawal_pppk', 'TGL. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskcalonawal_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noskawal_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskawal_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskawal_pppk', 'TGL. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskawal_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('nojanjiawal_pppk', ' NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('nojanjiawal_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgljanjiawal_pppk', 'TGL. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgljanjiawal_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtmulaiawal_pppk', 'Masa Perjanjian Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-3">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtmulaiawal_pppk', null, array('class'=> 'form-control date', 'id' => 'tmtmulaiawal_pppk', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                s.d
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtakhirawal_pppk', null, array('class'=> 'form-control date', 'id' => 'tmtakhirawal_pppk', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('idgolruawal_pppk', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboGolrupppk("idgolruawal_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('mkthnawal_pppk', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::text('mkthnawal_pppk', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Tahun
                                            </div>
                                            <div class="col-sm-2">
                                                {!! Form::text('mkblnawal_pppk', null, array('class'=> 'form-control num', 'id'=> 'mkblnawal_pppk', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Bulan
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('gajiawal_pppk', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group'>
                                                    <span class="input-group-addon">Rp.</span>
                                                    {!! Form::text('gajiawal_pppk', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title title2"><small>PERPANJANGAN PPPK</small></b>
                                        </div>
                                        </p>
                                        <div class="form-group">
                                            {!! Form::label('pejmenakhir_pppk', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenakhir_pppk","","") !!}
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
                                        {!! Form::label('noskakhir_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('noskakhir_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskakhir_pppk', 'TGL. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskakhir_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                      <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                      </span>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-group">
                                            {!! Form::label('nojanjiakhir_pppk', ' NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('nojanjiakhir_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgljanjiakhir_pppk', 'TGL. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgljanjiakhir_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtmulaiakhir_pppk', 'Masa Perjanjian Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-3">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtmulaiakhir_pppk', null, array('class'=> 'form-control date', 'id' => 'tmtmulaiakhir_pppk', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                s.d
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtakhirakhir_pppk', null, array('class'=> 'form-control date', 'id' => 'tmtakhirakhir_pppk', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('idgolruakhir_pppk', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboGolrupppk("idgolruakhir_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('mkthnakhir_pppk', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::text('mkthnakhir_pppk', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Tahun
                                            </div>
                                            <div class="col-sm-2">
                                                {!! Form::text('mkblnakhir_pppk', null, array('class'=> 'form-control num', 'id'=> 'mkblnakhir_pppk', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Bulan
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('gajiakhir_pppk', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group'>
                                                    <span class="input-group-addon">Rp.</span>
                                                    {!! Form::text('gajiakhir_pppk', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--end of pangkat pppk-->

                                <!-- cpns -->
                                <div class="row" id="cpnspns">
                                    <div class="col-md-6">
                                        <div class="div-disabled">
                                            <p>
                                            <div class="box-header with-border">
                                                <b class="box-title"><small>CPNS</small></b>
                                            </div>
                                            </p>

                                            <div class="form-group">
                                                {!! Form::label('pejmencpn', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! comboPenetapsk("pejmencpn","","") !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('idgolrucpn', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! comboGolru("idgolrucpn","","") !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('noskcpn', ' NO. SK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                                <div class="col-sm-7">
                                                    {!! Form::text('noskcpn', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tgskcpn', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tgskcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tmtcpn', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('mkthncpn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-2">
                                                    {!! Form::text('mkthncpn', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                </div>
                                                <div class="col-sm-1" style="margin-top: 7px;">
                                                    Tahun
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::text('mkblncpn', null, array('class'=> 'form-control num', 'id'=> 'mkblncpn', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                </div>
                                                <div class="col-sm-1" style="margin-top: 7px;">
                                                    Bulan
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Start SPMT CPNS -->
                                            <hr>
                                            <p>
                                            <div class="box-header with-border">
                                                <b class="box-title"><small>SPMT CPNS</small></b>
                                            </div>
                                            </p>
                                            <div class="form-group">
                                                {!! Form::label('nospmtcpn', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                <div class="col-sm-7">
                                                    {!! Form::text('nospmtcpn', null, array('class'=> 'form-control', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tgspmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tmtspmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End SPMT CPNS -->
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="div-disabled">
                                            <p>
                                            <div class="box-header with-border">
                                                <b class="box-title"><small>PNS</small></b>
                                            </div>
                                            </p>
                                            <div class="form-group">
                                                {!! Form::label('pejmenpns', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! comboPenetapsk("pejmenpns","","") !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('idgolrupns', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! comboGolru("idgolrupns","","") !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('noskpns', ' NO. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! Form::text('noskpns', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tgskpns', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tgskpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tmtpns', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('mkthnpns', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-2">
                                                    {!! Form::text('mkthnpns', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                </div>
                                                <div class="col-sm-1" style="margin-top: 7px;">
                                                    Tahun
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::text('mkblnpns', null, array('class'=> 'form-control num', 'id'=> 'mkblnpns', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                </div>
                                                <div class="col-sm-1" style="margin-top: 7px;">
                                                    Bulan
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Start SPMT PNS -->
                                            <hr>
                                            <p>
                                            <div class="box-header with-border">
                                                <b class="box-title"><small>SPMT PNS</small></b>
                                            </div>
                                            </p>
                                            <div class="form-group">
                                                {!! Form::label('nospmtpns', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    {!! Form::text('nospmtpns', null, array('class'=> 'form-control', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tgspmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tmtspmtpns', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                <div class="col-sm-7">
                                                    <div class='input-group datepicker'>
                                                        {!! Form::text('tmtspmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End SPMT PNS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="pangkat" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>PANGKAT TERAKHIR</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenpkt","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idgolrupkt', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboGolru("idgolrupkt","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noskpkt', ' NO. SK Gol.:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK Gol.')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskpkt', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Gol.')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskpkt', ' TGL. SK Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskpkt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtpkt', 'TMT Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtpkt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('mkthnpkt', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::text('mkthnpkt', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Tahun
                                            </div>
                                            <div class="col-sm-2">
                                                {!! Form::text('mkblnpkt', null, array('class'=> 'form-control num', 'id'=> 'mkblnpkt', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Bulan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="kgbterakhir" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>KGB TERAKHIR</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('pejmenkgb', 'Penetap:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenkgb","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idgolkgb', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboGolru("idgolkgb","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noskkgb', 'NO. SP KGB:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskkgb', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SP KGB')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskkgb', ' TGL. SP:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskkgb', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtkgb', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtkgb', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('mkgolthnkgb', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::text('mkgolthnkgb', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Tahun
                                            </div>
                                            <div class="col-sm-2">
                                                {!! Form::text('mkgolblnkgb', null, array('class'=> 'form-control num', 'id'=> 'mkgolblnkgb', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 7px;">
                                                Bulan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="pendidikan" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>PENDIDIKAN AWAL</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('idtkpendidawal', 'Pendidikan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboTkpendidikan($id="idtkpendidawal",$sel="",$required="") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenjurusanawal', 'Jurusan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <select name="idjenjurusanawal" class="form-control" id="idjenjurusanawal" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noijazawal', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noijazawal', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Ijazah')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('thijazawal', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('thijazawal', null, array('class'=> 'form-control num', 'maxlength'=> '4', 'placeholder'=> 'Tahun Lulus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('namasekolahawal', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('namasekolahawal', null, array('class'=> 'form-control', 'placeholder'=> 'Nama Sekolah / Kampus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('almsekolahawal', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('almsekolahawal', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat Sekolah / Kampus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('kepsekawal', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('kepsekawal', null, array('class'=> 'form-control', 'placeholder'=> 'Kepala Sekolah / Rektor')) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 div-disabled">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>PENDIDIKAN AKHIR</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('idtkpendid', 'Pendidikan Terakhir:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboTkpendidikan($id="idtkpendid",$sel="",$required="") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <select name="idjenjurusan" class="form-control" id="idjenjurusan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noijaz', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Ijazah')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('thijaz', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('thijaz', null, array('class'=> 'form-control num', 'maxlength'=> '4', 'placeholder'=> 'Tahun Lulus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('namasekolah', null, array('class'=> 'form-control', 'placeholder'=> 'Nama Sekolah / Kampus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('almsekolah', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('almsekolah', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat Sekolah / Kampus')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('kepsek', null, array('class'=> 'form-control', 'placeholder'=> 'Kepala Sekolah / Rektor')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="riwayat" class="tab-pane">
                                <p>
                                <div class="nav-tabs-custom" style="box-shadow:none;">
                                    <ul class="nav nav-tabs tab2" id="myTab">
                                        <li class="active div-pns"><a data-toggle="tab" href="#rpangkat"><i class="fa fa-fw fa-dot-circle-o"></i> PANGKAT</a></li>
                                        <li class="div-pppk"><a data-toggle="tab" href="#rpppk"><i class="fa fa-fw fa-dot-circle-o"></i> PPPK</a></li>
                                        <li><a data-toggle="tab" href="#rjab"><i class="fa fa-fw fa-dot-circle-o"></i> JABATAN</a></li>
                                        <li><a data-toggle="tab" href="#rkgb"><i class="fa fa-fw fa-dot-circle-o"></i> KGB</a></li>
                                        <li><a data-toggle="tab" href="#rpend"><i class="fa fa-fw fa-dot-circle-o"></i> PENDIDIKAN</a></li>
                                        <li><a data-toggle="tab" href="#rdikstru"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT STRUKTURAL</a></li>
                                        <li><a data-toggle="tab" href="#rdikfung"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT FUNGSIONAL</a></li>
                                        <li><a data-toggle="tab" href="#rdiktek"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT TEKNIS</a></li>
                                        <li><a data-toggle="tab" href="#rseminar"><i class="fa fa-fw fa-dot-circle-o"></i> SEMINAR</a></li>
                                        <li><a data-toggle="tab" href="#rpenghargaan"><i class="fa fa-fw fa-dot-circle-o"></i> TANDA JASA</a></li>
                                        <li><a data-toggle="tab" href="#rbahasa"><i class="fa fa-fw fa-dot-circle-o"></i> PENGUASAAN BAHASA</a></li>
                                        <li><a data-toggle="tab" href="#rhukdis"><i class="fa fa-fw fa-dot-circle-o"></i> HUKUM DISIPLIN</a></li>
                                        <li><a data-toggle="tab" href="#rskp"><i class="fa fa-fw fa-dot-circle-o"></i> PPK</a></li>
                                        <li><a data-toggle="tab" href="#rkinerjaasn"><i class="fa fa-fw fa-dot-circle-o"></i> KINERJA ASN</a></li>
                                        <li class="div-pns"><a data-toggle="tab" href="#rakredit"><i class="fa fa-fw fa-dot-circle-o"></i> ANGKA KREDIT</a></li>
                                        <li><a data-toggle="tab" href="#rcuti"><i class="fa fa-fw fa-dot-circle-o"></i> CUTI</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="rpangkat" class="tab-pane active">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">GOL. RUANG</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEJABAT PENETAP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TMT SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>

                                        <div id="rpppk" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpppk">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th rowspan="2" width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NAMA JABATAN</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NO. SK</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th colspan="2">
                                                            <div class="text-center">PERJANJIAN MASA KERJA</div>
                                                        </th>
                                                        <th rowspan="2" class="xisguru">
                                                            <div class="text-center">TUGAS GURU</div>
                                                        </th>
                                                        <th rowspan="2" class="xisguru">
                                                            <div class="text-center">MATA PELAJARAN</div>
                                                        </th>
                                                        <th rowspan="2" class="xisdokter">
                                                            <div class="text-center">TUGAS DOKTER</div>
                                                        </th>
                                                        <th rowspan="2" class="xjabfung">
                                                            <div class="text-center">PAK</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">UNIT KERJA</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">VERIFIED</div>
                                                        </th>
                                                        <th rowspan="2" width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <div class="text-center">MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SELESAI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rjab" class="tab-pane">
                                            <p>

                                                @if (\PermissionsLibrary::canAdd() && session('role_id')!=5 && session('role_id')!=4)
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NOb</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA JABATAN</div>
                                                        </th>
                                                        <th class="xjabstruk">
                                                            <div class="text-center">ESELON</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TMT JABATAN</div>
                                                        </th>
                                                        <th class="xisguru">
                                                            <div class="text-center">TUGAS GURU</div>
                                                        </th>
                                                        <th class="xisguru">
                                                            <div class="text-center">MATA PELAJARAN</div>
                                                        </th>
                                                        <th class="xisdokter">
                                                            <div class="text-center">TUGAS DOKTER</div>
                                                        </th>
                                                        <th class="xjabfung">
                                                            <div class="text-center">PAK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">UNIT KERJA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rkgb" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif

                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th rowspan="2" width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NO SKKGB</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TMT KGB</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TGL KGB</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">GOLONGAN</div>
                                                        </th>
                                                        <th colspan="2">
                                                            <div class="text-center">MASA KERJA</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">GAJI</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">PENETAP</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th rowspan="2" width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <div class="text-center">TAHUN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">BULAN</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rpend" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TK. PENDIDIKAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JURUSAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA SEKOLAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. IJAZAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. IJAZAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">KEPALA SEKOLAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rdikstru" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PENYELENGGARA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">ANGKATAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. SELESAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">LAMA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rdikfung" class="tab-pane">
                                            <p>

                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PENYELENGGARA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">ANGKATAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. SELESAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">LAMA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rdiktek" class="tab-pane">
                                            <p>

                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT DIKLAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PENYELENGGARA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">ANGKATAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. SELESAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">LAMA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. STTP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rseminar" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SEMINAR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT SEMINAR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PENYELENGGARA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL SELESAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. PIAGAM</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rpenghargaan" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANDA JASA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JENIS</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TAHUN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEJABAT PENETAP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rbahasa" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA BAHASA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JENIS BAHASA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">KEMAMPUAN</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rhukdis" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JENIS HUKUM DISIPLIN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TINGKAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEJABAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. SK</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL.&nbsp;MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL.&nbsp;SELESAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">KETERANGAN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rskp" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NILASI PRESTASI KERJA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TAHUN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEJABAT PENILAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JABATAN PENILAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <div id="rkinerjaasn" class="tab-pane table-responsive">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rkinerjaasn">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TAHUN</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEJABAT PENILAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JABATAN PENILAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">CAPAIAN KINERJA ORGANISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">RATING HASIL KERJA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">RATING PERILAKU KINERJA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PREDIKAT KINERJA PEGAWAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <!--th><div class="text-center">VERIFIED</div></th-->
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rakredit" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th rowspan="2" width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">ANGKA KREDIT LAMA</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NAMA JABATAN</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NOMOR SK</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th colspan="2">
                                                            <div class="text-center">PERIODE PENILAIAN ANGKA KREDIT</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">KREDIT UTAMA BARU</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">KREDIT PENUNJANG BARU</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">KREDIT BARU TOTAL</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">SINKRONISASI</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">JML FILE</div>
                                                        </th>
                                                        <th rowspan="2" width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <div class="text-center">MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SELESAI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rcuti" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                                <!-- <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div> -->
                                                @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rcuti">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th rowspan="2" width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NO. USUL</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TANGGAL USUL</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">NOMOR SK</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">TANGGAL SK</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">JENIS CUTI</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">ALASAN CUTI</div>
                                                        </th>
                                                        <th colspan="2">
                                                            <div class="text-center">TANGGAL CUTI</div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="text-center">LAMA CUTI</div>
                                                        </th>
                                                        <!-- <th rowspan="2"><div class="text-center">JML FILE</div></th> -->
                                                        <!-- <th width="8%"><div class="text-center">AKSI</div></th> -->
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <div class="text-center">MULAI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">SELESAI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                </div>
                                </p>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="keluarga" class="tab-pane">
                                <p>
                                <div class="nav-tabs-custom" style="box-shadow:none;">
                                    <ul class="nav nav-tabs tab3" id="myTab">
                                        <li class="active"><a data-toggle="tab" href="#rortu"><i class="fa fa-fw fa-dot-circle-o"></i> ORANG TUA</a></li>
                                        <li><a data-toggle="tab" href="#rissu"><i class="fa fa-fw fa-dot-circle-o"></i> DATA ISTRI / SUAMI</a></li>
                                        <li><a data-toggle="tab" href="#ranak"><i class="fa fa-fw fa-dot-circle-o"></i> DATA ANAK</a></li>
                                        <li><a data-toggle="tab" href="#rsaudara"><i class="fa fa-fw fa-dot-circle-o"></i> SAUDARA</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="rortu" class="tab-pane active">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">NO</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA ORANG TUA</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">STATUS</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT LAHIR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TANGGAL LAHIR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">ALAMAT</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEKERJAAN</div>
                                                        </th>
                                                        <th width="8%">
                                                            <div class="text-center">AKSI</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rissu" class="tab-pane">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                            <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="2%">
                                                            <div class="text-center">No</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NAMA ISTRI/SUAMI*</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TEMPAT LAHIR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. LAHIR</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NO. AKTA NIKAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">TGL. NIKAH</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">STATUS ISTRI/SUAMI</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">NIP/NRP</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PENDIDIKAN UMUM</div>
                                                        </th>
                                                        <th>
                                                            <div class="text-center">PEKERJAAN</div>
                                                        </th>
                                                        <th width="8div" class="text-center">AKSI
                                        </div>
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody id="result"></tbody>
                                        </table>
                                        </p>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div id="ranak" class="tab-pane">
                                        <p>
                                            @if (\PermissionsLibrary::canAdd())
                                        <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                        @endif
                                        <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th width="2%">
                                                        <div class="text-center">NO</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">NAMA ANAK</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">TEMPAT LAHIR</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">TGL. LAHIR</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">UMUR</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">JENIS KELAMIN</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">STATUS KELUARGA</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">PENDIDIKAN UMUM</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">PEKERJAAN</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">TUNJANGAN</div>
                                                    </th>
                                                    <th width="8%">
                                                        <div class="text-center">AKSI</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="result"></tbody>
                                        </table>
                                        </p>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div id="rsaudara" class="tab-pane">
                                        <p>
                                            @if (\PermissionsLibrary::canAdd())
                                        <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                        @endif
                                        <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th width="2%">
                                                        <div class="text-center">NO</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">NAMA</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">TGL. LAHIR</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">PEKERJAAN</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">JENIS KELAMIN</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">STATUS SAUDARA</div>
                                                    </th>
                                                    <th>
                                                        <div class="text-center">KETERANGAN</div>
                                                    </th>
                                                    <th width="8%">
                                                        <div class="text-center">AKSI</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="result"></tbody>
                                        </table>
                                        </p>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                            </div>
                            </p>
                        </div>
                        <!-- /.tab-pane -->
                        <div id="datalain" class="tab-pane">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                    <div class="box-header with-border">
                                        <b class="box-title"><small>KETERANGAN BADAN</small></b>
                                    </div>
                                    </p>

                                    <div class="form-group">
                                        {!! Form::label('tinggi', 'Tinggi:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class='input-group'>
                                                {!! Form::text('tinggi', null, array('class'=> 'form-control num', 'placeholder'=> 'Tinggi', 'maxlength'=>3)) !!}
                                                <span class="input-group-addon">Cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('berat', 'Berat:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class='input-group'>
                                                {!! Form::text('berat', null, array('class'=> 'form-control num', 'placeholder'=> 'Berat', 'maxlength'=>3)) !!}
                                                <span class="input-group-addon">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('rambut', 'Rambut:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('rambut', null, array('class'=> 'form-control', 'placeholder'=> 'Rambut')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('muka', ' Bentuk Muka:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('muka', null, array('class'=> 'form-control', 'placeholder'=> 'Bentuk Muka')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('kulit', ' Warna Kulit:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('kulit', null, array('class'=> 'form-control', 'placeholder'=> 'Warna Kulit')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('ciri', 'Ciri Khas:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('ciri', null, array('class'=> 'form-control', 'placeholder'=> 'Ciri Khas')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('cacat', 'Cacat Tubuh:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('cacat', null, array('class'=> 'form-control', 'placeholder'=> 'Cacat Tubuh')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p>
                                    <div class="box-header with-border">
                                        <b class="box-title"><small>HOBBY</small></b>
                                    </div>
                                    </p>

                                    <div class="form-group">
                                        {!! Form::label('hobby1', 'Hobby 1:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('hobby1', null, array('class'=> 'form-control', 'placeholder'=> 'Hobby 1')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('hobby2', 'Hobby 2:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('hobby2', null, array('class'=> 'form-control', 'placeholder'=> 'Hobby 2')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('hobby3', 'Hobby 3:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            {!! Form::text('hobby3', null, array('class'=> 'form-control', 'placeholder'=> 'Hobby 3')) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- START OF REZA 09-09-2019 + Master Hari Kerja -->
                                <div class="col-md-6">
                                    <p>
                                    <div class="box-header with-border">
                                        <b class="box-title"><small>HARI KERJA </small></b>
                                    </div>
                                    </p>

                                    <div class="form-group">
                                        {!! Form::label('hari_kerja', 'HARI KERJA:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <label class="radio-inline">
                                                <input type="radio" id="hari_kerja1" value="5" name="hari_kerja"> 5 Hari
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="hari_kerja2" value="6" name="hari_kerja"> 6 Hari
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="hari_kerja3" value="7" name="hari_kerja"> 7 Hari
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF REZA 09-09-2019 -->

                                @if(session('role_id') != 5)
                                <div class="col-md-6">
                                    <p>
                                    <div class="box-header with-border">
                                        <b class="box-title"><small>PASSWORD</small></b>
                                    </div>
                                    </p>

                                    <div class="form-group">
                                        {!! Form::label('password', 'Password:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7" style="padding-top: 7px">
                                            <!--<input type="password" class="form-control password" placeholder="Password login pegawai" disabled value="123123"><br>-->
                                            <a href="javascript:void(0)" class="ubah-pass">( <i class="fa fa-pencil"></i> Ubah Password )</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div id="edokumen" class="tab-pane">
                            <div class="nav-tabs-custom" style="box-shadow:none;">
                                <ul class="nav nav-tabs tab4" id="myTab">
                                    <li><a data-toggle="tab" href="#personalfile"> <i class="fa fa-fw fa-files-o"></i> Personal File</a></li>
                                    <li><a data-toggle="tab" href="#statusfile"> <i class="fa fa-fw fa-flag"></i> Status File Pegawai</a></li>
                                    <!-- <li><a data-toggle="tab" href="#verifikasidok"> <i class="fa fa-fw fa-check-square-o"></i> Verifikasi Dokumen</a></li> -->
                                </ul>
                                <div class="tab-content">
                                    <div id="personalfile" class="tab-pane">
                                        <div id="result"></div>
                                    </div>
                                    <div id="statusfile" class="tab-pane">
                                        <div id="result"></div>
                                    </div>
                                    <!-- <div id="verifikasidok" class="tab-pane">
                                            <div id="result"></div>
                                        </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
                <!--</div>-->
                <!--</div>-->
                <div class="box-footer"> &nbsp;</div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="kelola_file" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="wadah_modal">
            <div class="modal-header bg-primary">
                <button onclick="claravel_modal_close('kelola_file')" type="button" aria-hidden="true" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i></button>
                <h4 class="modal-title"><b id="judulmodal"></b></h4>
            </div>
            <div class="modal-body">
                <div id="kontenModal2"></div>
            </div>
            <div class="modal-footer">
                <div id="footermodal">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var xhr = $.ajax();

    function refresh_page() {
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) - 1;
        unset($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/' . $index . '";';
        ?>
        $.ajax({
            url: index_page,
            type: 'GET',
            beforeSend: function() {
                preloader.on();
            },
            success: function(html) {
                preloader.off();
                $('#utama').html(html);
            }
        });
    }

    function refresh_tab(index) {
        switch (index) {
            case 0:
                break;
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            case 6:
                //loadRpangkat();
                break;
            case 7:
                loadRortu();
                break;
            case 8:
                break;
            case 9:
                loadPersonalfile();
                break;
            case 10:
                loadRpangkat();
                break;
            case 11:
                loadRpppk();
                break;
            case 12:
                loadRjab();
                break;
            case 13:
                loadRkgb();
                break;
            case 14:
                loadRpend();
                break;
            case 15:
                loadRdikstru();
                break;
            case 16:
                loadRdikfung();
                break;
            case 17:
                loadRdiktek();
                break;
            case 18:
                loadRseminar();
                break;
            case 19:
                loadRpenghargaan();
                break;
            case 20:
                loadRbahasa();
                break;
            case 21:
                loadRhukdis();
                break;
            case 22:
                loadRskp();
                break;
            case 23:
                loadRkinerjaasn();
                break;
            case 24:
                loadRakredit();
                break;
            case 25:
                loadRcuti();
                break
            case 26:
                loadRortu();
                break;
            case 27:
                loadRissu();
                break;
            case 28:
                loadRanak();
                break;
            case 29:
                loadRsaudara();
                break;
            case 30:
                loadPersonalfile();
                break;
            case 31:
                loadStatusfile();
                break;
        }
    }

    $(document).ready(function() {
        var indextab = 0;
        $('#kelola_file').on('hide.bs.modal', function(e) {
            $('#kelola_file .modal-body').html('');
            refresh_tab(indextab);
        })
        $('#simpan select').select2();
        $('.stsdujan').hide();
        $('#simpan #changeimage').fadeOut();
        $('#simpan #changeimage, #simpan .xjabstruk, #simpan .xjabfung, #simpan .xisguru, #simpan .xisdokter, #simpan .alert-biodata, #simpan .alert-jenkedudupeg').fadeOut();
        $('#simpan .div-disabled').css('pointer-events', 'none');
        $('#simpan .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color', '#ececec');
        $('#simpan .num').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");

        $('#simpan #myTab li a').each(function(index, item) {
            $(item).click(function() {
                indextab = index;
                switch (index) {
                    case 0:
                        break;
                    case 1:
                        break;
                    case 2:
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                    case 5:
                        break;
                    case 6:
                        /*loadRpangkat();
                        $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                        $('#simpan .tab-content div').removeClass('active');

                        $('#simpan .tab2 li').first().addClass('active');
                        $('#simpan .tab-content #rpangkat').addClass('active');
                        break;*/
                    case 7:
                        loadRortu();
                        $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                        $('#simpan .tab-content div').removeClass('active');

                        $('#simpan .tab3 li').first().addClass('active');
                        $('#simpan .tab-content #rortu').addClass('active');
                        break;
                    case 8:
                        break;
                    case 9:
                        loadPersonalfile();
                        $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li, #simpan .tab4 li').removeClass('active');
                        $('#simpan .tab-content div').removeClass('active');
                        $('#simpan .tab4 li').first().addClass('active');
                        $('#simpan .tab-content #personalfile').addClass('active');
                        break;
                    case 10:
                        loadRpangkat();
                        break;
                    case 11:
                        loadRpppk();
                        break;
                    case 12:
                        loadRjab();
                        break;
                    case 13:
                        loadRkgb();
                        break;
                    case 14:
                        loadRpend();
                        break;
                    case 15:
                        loadRdikstru();
                        break;
                    case 16:
                        loadRdikfung();
                        break;
                    case 17:
                        loadRdiktek();
                        break;
                    case 18:
                        loadRseminar();
                        break;
                    case 19:
                        loadRpenghargaan();
                        break;
                    case 20:
                        loadRbahasa();
                        break;
                    case 21:
                        loadRhukdis();
                        break;
                    case 22:
                        loadRskp();
                        break;
                    case 23:
                        loadRkinerjaasn();
                        break;
                    case 24:
                        loadRakredit();
                        break;
                    case 25:
                        loadRcuti();
                        break;
                    case 26:
                        loadRortu();
                        break;
                    case 27:
                        loadRissu();
                        break;
                    case 28:
                        loadRanak();
                        break;
                    case 29:
                        loadRsaudara();
                        break;
                    case 30:
                        loadPersonalfile();
                        break;
                    case 31:
                        loadStatusfile();
                        break;
                }
            });
        });

        @if(session('role_id') != 5)
        autoCompleteimg('#simpan #nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '{!!Input::get("id")!!}', '{!!Input::get("id")!!}', '');
        @endif
        autoComplete('#simpan #tmlhr', '{{url()}}/epersonal/biodata/tempatlahir', '.: Pilihan :.', null, '', '', '');

        $('#simpan #idtkpendidawal').on('change', function(e) {
            e.preventDefault();
            autoComplete('#simpan #idjenjurusanawal', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #idtkpendid').on('change', function(e) {
            e.preventDefault();
            autoComplete('#simpan #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #kdunit').on('change', function(e) {
            e.preventDefault();
            autoComplete('#simpan #idskpd', '{{url()}}/epersonal/biodata/skpdunit', '.: Pilihan :.', null, $(this).val(), $(this).find(":selected").text(), $(this).val());
        });

        $('#simpan #idskpd').on('change', function(e) {
            e.preventDefault();
            autoComplete('#simpan #idjabjbt', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #idtugasgurudosen').on('change', function(e) {
            e.preventDefault();
            autoComplete('#simpan #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #idjenjab').on('change', function(e) {
            e.preventDefault();
            var idjenjab = $(this).val();
            $.ajax({
                url: '{{url()}}/epersonal/biodata/jenisjabatan',
                type: 'post',
                data: {
                    'idjenjab': $(this).val(),
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    $('#simpan #jenisjabatan').html('Looading...');
                },
                success: function(respose) {
                    $('#simpan #xjenisjabatan').html(respose);
                }
            })
        });

        loadBiodata2();
        $('#simpan #nip').on('change', function(e) {
            e.preventDefault();
            loadBiodata2();
        });

        $('#simpan #xreset').on('click', function(e) {
            e.preventDefault();
            $("#simpan #nip").data('select2').trigger('select', {
                data: {
                    "id": '',
                    "text": ''
                }
            });
        });

        $('#batalkan,#back').on('click', function(e) {
            e.preventDefault();
            refresh_page();
        });

        $('#simpan').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('{!!$alert!!}', function(a) {
                if (a == true) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        data: $this.serialize(),
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            preloader.off();
                            if (html == 4) {
                                notification('Berhasil Disimpan', 'success');
                                /*refresh_page();*/
                                loadBiodata2();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });

        $("#idstskawin").change(function() {
            var kawin = $('#idstskawin').val();
            if (kawin == 2) {
                $('.stsdujan').show();
            } else {
                $('#idstsdujan').select2('val', '');
                $('.stsdujan').hide();

            }
        }).trigger('change');

        $('#simpan').on('click', '.print', function(e) {
            e.preventDefault();
            claravel_modal('Cetak Biodata', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/print',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('#simpan').on('click', '.sinkprofilbkn', function(e) {
            e.preventDefault();
            claravel_modal('Sinkronisasi Biodata SAPK', 'Loading...', 'main_modal2');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/sinkronbkn_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });

        $('#simpan').on('click', '.sinkprofilsiasn', function(e) {
            e.preventDefault();
            claravel_modal('Sinkronisasi Biodata SIASN', 'Loading...', 'main_modal2');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/sinkronsiasn_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });

        $('#simpan').on('click', '#changeimage', function(e) {
            e.preventDefault();
            claravel_modal('Foto Pegawai', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/foto',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('#simpan').on('click', '.ubah-pass', function(e) {
            e.preventDefault();
            claravel_modal('Ubah Password', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/password',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        /*riwayat pangkat*/
        $('#rpangkat a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Pangkat', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rpangkat_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat pangkat*/

        /*riwayat pppk*/
        $('#rpppk a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat PPPK', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rpppk_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    'tb': 'tb_01',
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat pangkat*/

        /*riwayat jabatan*/
        $('#rjab a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Jabatan', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rjab_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat jabatan*/

        /*riwayat jabatan - tambah jenis file*/
        $('#rjab a.tambahjenisfile').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Tambah Jenis File Riwayat Jabatan', 'Loading...', 'kelola_file');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {
                    'nip': $('#nip').val(),
                    'jenis': 6,
                    'rjabadd': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });
        /*end of riwayat jabatan - tambah jenis file*/

        /*riwayat kenaikan gaji berkala*/
        $('#rkgb a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Kenaikan Gaji Berkala', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rkgb_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat jabatan*/

        /*riwayat kenaikan pendidikan*/
        $('#rpend a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Pendidikan', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rpend_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat pendidikan*/

        /*riwayat diklat struktural*/
        $('#rdikstru a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Diklat Srtuktural', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rdikstru_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat diklat struktural*/

        /*riwayat diklat fungsional*/
        $('#rdikfung a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Diklat Fungsional', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rdikfung_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat diklat fungsional*/

        /*riwayat diklat teknis*/
        $('#rdiktek a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Diklat Teknis', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rdiktek_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat diklat teknis*/

        /*riwayat seminar*/
        $('#rseminar a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Seminar', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rseminar_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat seminar*/

        /*riwayat tanda jasa*/
        $('#rpenghargaan a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Penghargaan', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rpenghargaan_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat tanda jasa*/

        /*riwayat bahasa*/
        $('#rbahasa a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Bahasa', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rbahasa_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat bahasa*/

        /*riwayat sasaran hukuman disiplin*/
        $('#rhukdis a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Hukuman Disiplin', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rhukdis_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat hukuman disiplin*/

        /*riwayat sasaran kinerja pegawai*/
        $('#rskp a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Penilaian Prestasi Kerja Pegawai', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rskp_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat sasaran kinerja pegawai*/

        /*riwayat sasaran kinerja asn*/
        $('#rkinerjaasn a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Penilaian Prestasi Kerja ASN', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rkinerjaasn_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        /*riwayat angka kredit*/
        $('#rakredit a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Angka Kredit', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rakredit_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat angka kredit*/

        /*riwayat orang tua*/
        $('#rortu a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Orang Tua', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rortu_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat orang tua*/

        /*riwayat istri atau suami*/
        $('#rissu a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Istri / Suami', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rissu_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat istri atau suami*/

        /*riwayat anak*/
        $('#ranak a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Anak', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/ranak_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat anak*/

        /*riwayat saudara*/
        $('#rsaudara a.tambah').on('click', function(e) {
            e.preventDefault();
            claravel_modal('Riwayat Saudara', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/rsaudara_form',
                data: {
                    'nip': $('#simpan #nip').val(),
                    'flag': 1,
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        /*end of riwayat saudara*/

        /*function preview biodata*/
        // $('#simpan .prevbiodata').on('click', function(e){
        //     e.preventDefault(e);
        //     claravel_modal('Perubahan Biodata','Loading...','main_modal2');
        //     $.ajax({
        //         type:'post',
        //         url : '{!!url()!!}/epersonal/biodata/data/perubahan_biodata',
        //         data: {'nip': $('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
        //         success:function(html){
        //             $('#main_modal2 .modal-body').html(html);
        //         }
        //     });
        // })

        $('.prevbiodata').on('click', function(e) {
            e.preventDefault(e);
            var roleid = $(this).attr('recrole');
            if (roleid < 3) {
                var modal = 'main_modal3';
                var tujuan = 'perubahan_biodata_all';
                var judul = 'Perubahan Data';
            } else {
                var modal = 'main_modal2';
                var tujuan = 'perubahan_biodata';
                var judul = 'Perubahan Biodata';
            }
            claravel_modal(judul, 'Loading...', modal);
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/biodata/data/' + tujuan + '/biodata',
                data: {
                    'nip': $('#simpan #nip').val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#' + modal + ' .modal-body').html(html);
                }
            });
        });
    });

    function loadBiodata2() {
        @if(session('role_id') == 5)
        var nip = "{!!session('user_id')!!}";
        @else
        var nip = $('#simpan #nip').val();
        @endif

        $.ajax({
            url: '{!!url()!!}/epersonal/biodata/detailpegawai',
            type: 'POST',
            data: {
                'nip': nip,
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                preloader.on();
            },
            success: function(response) {
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tglhr", "tgskjbt", "tmtjbt", "tgskcpn", "tmtcpn", "tgspmtcpn", "tmtspmtcpn", "tgskpns", "tmtpns", "tgspmtpns", "tmtspmtpns", "tgskpkt", "tmtpkt", "tgskkgb", "tmtkgb", "tgskawal_pppk", "tmtmulaiawal_pppk", "tmtakhirawal_pppk", "tgskcalonawal_pppk", "tgljanjiawal_pppk", "tgskcalonawal_pppk", "tgljanjiawal_pppk", "tgskakhir_pppk", "tgljanjiakhir_pppk", "tmtmulaiakhir_pppk", "tmtakhirakhir_pppk");
                var arraytext = new Array("skpdunit", "nip-text");
                var arrayradio = new Array("idjenkel", "idstspeg", "hari_kerja", "isttb");
                var arrselect2 = new Array("idkoord", "idagama", "idstskawin", "idstsdujan", "idgoldarah", "idjenkepeg", "idjenkedudupeg", "idskpd", "kdunit", "pejmenjbt", "idjenjab", "pejmencpn", "idgolrucpn", "pejmenpns", "idgolrupns", "pejmenpkt", "idgolrupkt", "pejmenkgb", "idgolkgb", "idgolkgb", "idtkpendid", "idtkpendidawal", "pejmenawal_pppk", "idgolruawal_pppk", "pejmenakhir_pppk", "idgolruakhir_pppk");

                if (ret) {
                    for (attrname in ret) {
                        $('#simpan #id').val(ret.nip);
                        $('#simpan #' + attrname).val(ret[attrname]);
                        if ($.inArray(attrname, arraytext) != -1) {
                            $('#' + attrname).html('(<i class="fa fa-fw fa-map-marker"></i>' + ret[attrname] + ')');
                        }
                        if ($.inArray(attrname, arrayradio) != -1) {
                            $('input[name=' + attrname + '][value=' + ret[attrname] + ']').prop('checked', true);
                        }
                        if ($.inArray(attrname, arrselect2) != -1) {
                            $('#simpan #' + attrname).select2('val', ret[attrname]);
                        }
                        if ($.inArray(attrname, arrdate) != -1) {
                            if (ret[attrname] != null && ret[attrname] != '') {
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#simpan #' + attrname).val(res[2] + '-' + res[1] + '-' + res[0]);
                            } else {
                                $('#simpan #' + attrname).val(ret[attrname]);
                            }
                        }
                    }
                    // candra edit 15122025 penambhan status 4 pppk paruh waktu 
                    //    var sts_pegawai = ((ret.idstspeg == 1) ? 'CPNS' : (ret.idstspeg == 2) ? 'PNS' : (ret.idstspeg == 3) ? 'PPPK ' : 'PPPK PARUH WAKTU');
                    var sts_pegawai = ((ret.idstspeg == 1) ? 'CPNS' : (ret.idstspeg == 2) ? 'PNS' : 'PPPK');
                    // console.log(sts_pegawai)
                    $('#sts_pgw').html("<strong>" + sts_pegawai + "</strong>");

                    $('#pengangkatanpppk').hide();
                    $('#cpnspns').hide();
                    /* Tab CPNS / PNS diganti PPPK ketika status pegawai = 3 (PPPK) */
                    // candra edit 15122025 penambhan status 4 pppk paruh waktu 
                    if (ret.idstspeg == 3 || ret.idstspeg == 4) {
                        // if(ret.idstspeg == 3) {
                        $('#myTab li a[href="#pangkatgol"]').html('<i class="fa fa-fw fa-paper-plane-o"></i> PPPK');
                        $('#myTab li a[href="#pangkat"]').hide();
                        $('#pengangkatanpppk').show();
                    } else {
                        $('#myTab li a[href="#pangkatgol"]').html('<i class="fa fa-fw fa-paper-plane-o"></i> CPNS / PNS');
                        $('#myTab li a[href="#pangkat"]').fadeIn();
                        $('#cpnspns').show();
                    }
                    /* End of Tab CPNS / PNS diganti PPPK ketika status pegawai = 3 (PPPK) */

                    $('#simpan .awal').attr('disabled', false);
                    $('#simpan #myTab li').removeClass('disabled');

                    $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                    $('#simpan #myTab li').first().addClass('active');

                    $('#simpan .tab-content div').removeClass('active');
                    $('#simpan .tab-content #biodata').addClass('active');
                    $('#simpan #myTab li').css({
                        'pointer-events': ''
                    });

                    $("#simpan #propic").attr("src", "{!!url()!!}/packages/upload/photo/pegawai/" + ret.photo + "");
                    $('#simpan #changeimage').fadeIn();
                    $("#simpan #idskpd").data('select2').trigger('select', {
                        data: {
                            "id": ret.idskpd,
                            "text": ret.skpd
                        }
                    });

                    $("#simpan #idjenjurusanawal").data('select2').trigger('select', {
                        data: {
                            "id": ret.idjenjurusanawal,
                            "text": ret.jenjurusanawal
                        }
                    });

                    $("#simpan #idjenjurusan").data('select2').trigger('select', {
                        data: {
                            "id": ret.idjenjurusan,
                            "text": ret.jenjurusan
                        }
                    });

                    $("#simpan #tmlhr").data('select2').trigger('select', {
                        data: {
                            "id": ret.tmlhr,
                            "text": ret.tmlhr
                        }
                    });

                    if (ret.isttb == 1) {
                        $('#simpan .xisttb').fadeIn();
                    } else {
                        $('#simpan .xisttb').fadeOut();
                    }

                    if (ret.idjenjab == 1) {
                        $('#simpan .xjabstruk').fadeIn();
                    } else if (ret.idjenjab == 2) {
                        $('#simpan .xjabfung').fadeIn();
                    } else {
                        $('#simpan .xjabstruk, #simpan .xjabfung').fadeOut();
                    }

                    if (ret.isguru == 1) {
                        $('#simpan .xisguru').fadeIn();
                    } else if (ret.isguru == 2) {
                        $('#simpan .xisdokter').fadeIn();
                    } else {
                        $('#simpan .xisguru, #simpan .xisdokter').fadeOut();
                    }

                    if (ret.ketstatus == 1) {
                        $('.alert-biodata').fadeIn();
                    } else {
                        $('.alert-biodata').fadeOut();
                    }

                    if ((ret.idjenkedudupeg == 99) || (ret.idjenkedudupeg == 21) || (ret.idjenkedudupeg == 20)) {
                        $('.alert-jenkedudupeg').fadeIn();
                    } else {
                        $('.alert-jenkedudupeg').fadeOut();
                    }

                    stspeg(ret.idstspeg);
                    $(".nip-text").html(ret.nip);
                    $('#simpan .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color', '#ececec');
                } else {
                    $('#simpan .awal').attr('disabled', true);
                    $('#simpan #myTab li').addClass('disabled');
                    $('#simpan #myTab li').css({
                        'pointer-events': 'none'
                    });
                    $('#simpan #myTab li, #simpan .tab-pane').removeClass('active');

                    $("#simpan").find('input:text, input:password, input:file, select, textarea').val('');
                    $("#simpan").find('#idkoord,#idagama, #idstskawin, #idgoldarah, #kdunit, #idjenkepeg, #idjenkedudupeg, #idjenjab, #pejmencpn, #idgolrucpn, #pejmenpns, #idgolrupns, #pejmenpkt, #idgolrupkt, #pejmenkgb, #idgolkgb, #idtkpendidawal, #idtkpendid, #idtugasgurudosen').val('').trigger('change');
                    $("#simpan").find('#tmlhr, #idskpd, #idjabjbt, #idjabfung, #idjabfungum, #idjenjurusanawal, #idjenjurusan, #idmatkulpel').data('select2').trigger('select', {
                        data: {
                            "id": "",
                            "text": ""
                        }
                    });
                    $('#simpan #changeimage, #simpan .alert-biodata').fadeOut();
                    $('#simpan #changeimage, #simpan .alert-jenkedudupeg').fadeOut();
                    $("#skpdunit, .nip-text").html('');
                    $("#simpan #propic").attr("src", "{!!url()!!}/packages/upload/photo/pegawai/default.jpg");
                    $("#simpan").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                    $('#simpan .xjabstruk, #simpan .xjabfung, #simpan .xisguru, #simpan .xisdokter').fadeOut();
                }
            }
        });
    }

    function loadBiodata() {
        @if(session('role_id') == 5)
        var nip = "{!!session('user_id')!!}";
        @else
        var nip = $('#simpan #nip').val();
        @endif

        $.ajax({
            url: '{!!url()!!}/epersonal/biodata/detailpegawai',
            type: 'POST',
            data: {
                'nip': nip,
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                preloader.on();
            },
            success: function(response) {
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tglhr", "tgskjbt", "tmtjbt", "tgskcpn", "tmtcpn", "tgspmtcpn", "tmtspmtcpn", "tgskpns", "tmtpns", "tgspmtpns", "tmtspmtpns", "tgskpkt", "tmtpkt", "tgskkgb", "tmtkgb", "tgskcalonawal_pppk", "tgskawal_pppk", "tgljanjiawal_pppk", "tmtmulaiawal_pppk", "tmtakhirawal_pppk", "tgskakhir_pppk", "tgljanjiakhir_pppk", "tmtmulaiakhir_pppk", "tmtakhirakhir_pppk");
                var arraytext = new Array("skpdunit");
                var arrayradio = new Array("idjenkel", "idstspeg", "hari_kerja", "isttb");
                var arrselect2 = new Array("idkoord", "idagama", "idstskawin", "idgoldarah", "idjenkepeg", "idjenkedudupeg", "idskpd", "kdunit", "pejmenjbt", "idjenjab", "pejmencpn", "idgolrucpn", "pejmenpns", "idgolrupns", "pejmenpkt", "idgolrupkt", "pejmenkgb", "idgolkgb", "idgolkgb", "idtkpendid", "idtkpendidawal", "pejmenawal_pppk", "idgolruawal_pppk", "pejmenakhir_pppk", "idgolruakhir_pppk");

                if (ret) {
                    for (attrname in ret) {
                        $('#simpan #id').val(ret.nip);
                        $('#simpan #' + attrname).val(ret[attrname]);
                        if ($.inArray(attrname, arraytext) != -1) {
                            $('#' + attrname).html('(<i class="fa fa-fw fa-map-marker"></i>' + ret[attrname] + ')');
                        }
                        if ($.inArray(attrname, arrayradio) != -1) {
                            $('input[name=' + attrname + '][value=' + ret[attrname] + ']').prop('checked', true);
                        }
                        if ($.inArray(attrname, arrselect2) != -1) {
                            $('#simpan #' + attrname).select2('val', ret[attrname]);
                        }
                        if ($.inArray(attrname, arrdate) != -1) {
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#simpan #' + attrname).val(res[2] + '-' + res[1] + '-' + res[0]);
                        }
                    }

                    /*$('#simpan .awal').attr('disabled', false);
                    $('#simpan #myTab li').removeClass('disabled');

                    $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                    $('#simpan #myTab li').first().addClass('active');

                    $('#simpan .tab-content div').removeClass('active');
                    $('#simpan .tab-content #biodata').addClass('active');
                    $('#simpan #myTab li').css({ 'pointer-events': ''});

                    $("#simpan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/"+ret.photo+"" );
                    $('#simpan #changeimage').fadeIn();*/
                    $("#simpan #idskpd").data('select2').trigger('select', {
                        data: {
                            "id": ret.idskpd,
                            "text": ret.skpd
                        }
                    });

                    $("#simpan #idjenjurusanawal").data('select2').trigger('select', {
                        data: {
                            "id": ret.idjenjurusanawal,
                            "text": ret.jenjurusanawal
                        }
                    });

                    $("#simpan #idjenjurusan").data('select2').trigger('select', {
                        data: {
                            "id": ret.idjenjurusan,
                            "text": ret.jenjurusan
                        }
                    });

                    $("#simpan #tmlhr").data('select2').trigger('select', {
                        data: {
                            "id": ret.tmlhr,
                            "text": ret.tmlhr
                        }
                    });

                    if (ret.isttb == 1) {
                        $('#simpan .xisttb').fadeIn();
                    } else {
                        $('#simpan .xisttb').fadeOut();
                    }

                    if (ret.idjenjab == 1) {
                        $('#simpan .xjabstruk').fadeIn();
                    } else if (ret.idjenjab == 2) {
                        $('#simpan .xjabfung').fadeIn();
                    } else {
                        $('#simpan .xjabstruk, #simpan .xjabfung').fadeOut();
                    }

                    if (ret.isguru == 1) {
                        $('#simpan .xisguru').fadeIn();
                    } else if (ret.isguru == 2) {
                        $('#simpan .xisdokter').fadeIn();
                    } else {
                        $('#simpan .xisguru, #simpan .xisdokter').fadeOut();
                    }
                } else {
                    $('#simpan .awal').attr('disabled', true);
                    $('#simpan #myTab li').addClass('disabled');
                    $('#simpan #myTab li').css({
                        'pointer-events': 'none'
                    });
                    $('#simpan #myTab li, #simpan .tab-pane').removeClass('active');

                    $("#simpan").find('input:text, input:password, input:file, select, textarea').val('');
                    $("#simpan").find('#idagama, #idstskawin, #idgoldarah, #kdunit, #idjenkepeg, #idjenkedudupeg, #idjenjab, #pejmencpn, #idgolrucpn, #pejmenpns, #idgolrupns, #pejmenpkt, #idgolrupkt, #pejmenkgb, #idgolkgb, #idtkpendidawal, #idtkpendid, #idtugasgurudosen').val('').trigger('change');
                    $("#simpan").find('#tmlhr, #idskpd, #idjabjbt, #idjabfung, #idjabfungum, #idjenjurusanawal, #idjenjurusan, #idmatkulpel').data('select2').trigger('select', {
                        data: {
                            "id": "",
                            "text": ""
                        }
                    });
                    $('#simpan #changeimage').fadeOut();
                    $("#simpan #skpdunit").html('');
                    $("#simpan #propic").attr("src", "{!!url()!!}/packages/upload/photo/pegawai/default.jpg");
                    $("#simpan").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                    $('#simpan .xjabstruk, #simpan .xjabfung, #simpan .xisguru, #simpan .xisdokter').fadeOut();
                }
            }
        });
    }

    function loadRpangkat() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rpangkat',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rpangkat #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rpangkat #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpppk() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rpppk',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rpppk #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rpppk #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRjab() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rjab',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rjab #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rjab #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRkgb() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rkgb',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rkgb #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rkgb #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpend() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rpend',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rpend #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rpend #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdikstru() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rdikstru',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rdikstru #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rdikstru #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdikfung() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rdikfung',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rdikfung #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rdikfung #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdiktek() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rdiktek',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rdiktek #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rdiktek #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRseminar() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rseminar',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rseminar #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rseminar #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpenghargaan() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rpenghargaan',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rpenghargaan #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rpenghargaan #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRbahasa() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rbahasa',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rbahasa #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rbahasa #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRhukdis() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rhukdis',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rhukdis #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rhukdis #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRskp() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rskp',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rskp #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rskp #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRkinerjaasn() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rkinerjaasn',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rkinerjaasn #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rkinerjaasn #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRakredit() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rakredit',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rakredit #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rakredit #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRcuti() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rcuti',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rcuti #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rcuti #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRortu() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rortu',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rortu #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rortu #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRissu() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rissu',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rissu #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rissu #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRanak() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/ranak',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#ranak #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#ranak #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRsaudara() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rsaudara',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#rsaudara #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#rsaudara #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadPersonalfile() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/personalfile',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#personalfile #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#personalfile #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadStatusfile() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/statusfile',
            data: {
                'nip': $('#simpan #nip').val(),
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#statusfile #result').html('Looading..');
            },
            success: function(response) {
                if ($('#simpan #nip').val() != '') {
                    $('#statusfile #result').html(response);
                } else {
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function stspeg(idstspeg) {
        // candra edit 15122025 penambhan status 4 pppk paruh waktu
        if (idstspeg == 3 || idstspeg == 4) {
            $('#simpan .div-pns').fadeOut();
            $('#simpan .div-pppk').fadeIn();
        } else {
            $('#simpan .div-pns').fadeIn();
            $('#simpan .div-pppk').fadeOut();
        }
    }
</script>