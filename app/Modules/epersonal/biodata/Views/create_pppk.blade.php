<section class="content-header">
    <h1>
        Buat Biodata Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Biodata</a></li>
        <li class="active">Buat Biodata Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <span class="pull-left"><h3 class="box-title">BIODATA PEGAWAI</h3></span>
                <span class="pull-right"><span id="skpdunit"></span></span>
            </div>
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            {!! Form::hidden('id', null, array('id'=>'id')) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2" align="center">
                        <div class="widget-user-image">
                            <img alt="User Image" id='propic' class="img-circle" src="{!!url()!!}/packages/upload/photo/pegawai/default.jpg" width="128" height="128">
                            <p>
                                <a href="javascript:void(0)" id="changeimage"><em><small><i class="fa fa-pencil" title="Ganti Foto Pegawai"></i>&nbsp;Ganti&nbsp;Foto</small></em></a>
                            </p>
                            <em><small>* Edit foto dilakukan setelah Biodata disimpan.</small></em>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP :', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                <!--<select name="nip" class="form-control" id="nip" style="width: 100%"></select>-->
                                {!! Form::text('nip', null, array('class'=> 'form-control num', 'placeholder'=>'Nomor Induk Pegawai', 'maxlength'=>18)) !!}
                                <span id="vernip"></span>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::text('niplama', null, array('class'=> 'form-control awal', 'id'=>'niplama', 'placeholder'=>'NIP Lama', 'maxlength'=>9)) !!}
                            </div>
                        </div>
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
                <!--<div class="pull-left">
                    <button class="btn btn-primary awal" type="submit"><i class="fa fa-print"></i> Print</button>
                </div>-->
                <div class="pull-right">
                    <button class="btn btn-success awal" type="submit" id=""><i class="fa fa-floppy-o"></i> Simpan</button>
                    &nbsp;
                    &nbsp;
                    <a class="btn btn-warning awal" href="{!!url()!!}/epersonal/biodata" id="batalkan"><i class="fa fa-times-circle-o"></i> Batalkan</a>
                </div>
            </div>
            <div class="box-footer"></div>
            <div class="box-body">
                <!--<div class="col-md-12">-->
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" style="box-shadow:none;">
                        <ul class="nav nav-tabs tab1" id="myTab">
                            <li class="active"><a data-toggle="tab" href="#biodata"> <i class="fa fa-fw fa-child"></i> BIODATA PRIBADI</a></li>
                            <li><a data-toggle="tab" href="#lokasijab"> <i class="fa fa-fw fa-map-marker"></i> STATUS & KEDUDUKAN</a></li>
                            <li><a data-toggle="tab" href="#pangkatgol"> <i class="fa fa-fw fa-paper-plane-o"></i> PPPK</a></li>
                            <li><a data-toggle="tab" href="#kgbterakhir"> <i class="fa fa-fw fa-money"></i> KGB TERAKHIR</a></li>
                            <li><a data-toggle="tab" href="#pendidikan"> <i class="fa fa-fw fa-graduation-cap"></i> PENDIDIKAN</a></li>
                            <li><a data-toggle="tab" href="#riwayat"> <i class="fa fa-fw fa-stethoscope"></i> RIWAYAT</a></li>
                            <li><a data-toggle="tab" href="#keluarga"> <i class="fa fa-fw fa-venus-mars"></i> KELUARGA</a></li>
                            <li><a data-toggle="tab" href="#datalain"> <i class="fa fa-fw fa-recycle"></i> DATA LAIN</a></li>
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
                                        <div class="form-group">
                                            {!! Form::label('idstskawin', 'Status Marital:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboStsmarital("idstskawin","","") !!}
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
                                            {!! Form::label('hp', 'HP:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('hp', null, array('class'=> 'form-control', 'placeholder'=> 'Handphone')) !!}
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
                                        <div class="form-group">
                                            {!! Form::label('email', 'Email:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('email', null, array('class'=> 'form-control', 'placeholder'=> 'Email')) !!}
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
                                        <!-- <div class="form-group">
                                            {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboSkpdunit("kdunit","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <label class="radio-inline">
                                                    <input type="radio" name="idstspeg" id="idstspeg3" value="3" checked> PPPK
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
                                    <!-- <div class="col-md-6">
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
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="pangkatgol" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6">
                                    <p>
                                        <div class="box-header with-border">
                                            <b class="box-title title1"><small>PENGANGKATAN PPPK</small></b>
                                        </div>
                                    </p>

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
                                          {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                          {!! comboSkpdunit("kdunit","","") !!}
                                          </div>
                                    </div>
                                    <div class="form-group">
                                          {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                          <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                          </div>
                                    </div>

                                        <div class="form-group">
                                            {!! Form::label('pejmenawal_pppk', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboPenetapsk("pejmenawal_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('idjenjabawal_pppk', ' Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboJenjab("idjenjabawal_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div id="xjenisjabatanawal">
                                            <div class="form-group">
                                              {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                              <div class="col-sm-7" id="jenisjabatanawal">
                                                  <select name="idjabawal_pppk" class="form-control" id="idjabawal_pppk" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                              </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title title1">&nbsp;</b>
                                        </div>
                                        </p>
                                        <div class="form-group">
                                            {!! Form::label('noskawal_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskawal_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK PPPK')) !!}
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
                                        <div class="form-group">
                                            {!! Form::label('nojanjiawal_pppk', ' NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('nojanjiawal_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Perjanjian')) !!}
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
                                                    {!! Form::text('tmtmulaiawal_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
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
                                                    {!! Form::text('tmtakhirawal_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
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
                                        <div class="form-group">
                                            {!! Form::label('noskakhir_pppk', ' NO. SK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                            <div class="col-sm-7">
                                                {!! Form::text('noskakhir_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgskakhir_pppk', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tgskakhir_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
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
                                            {!! Form::label('idjenjabakhir_pppk', ' Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                {!! comboJenjab("idjenjabakhir_pppk","","") !!}
                                            </div>
                                        </div>
                                        <div id="xjenisjabatanakhir">
                                            <div class="form-group">
                                              {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                              <div class="col-sm-7" id="jenisjabatanakhir">
                                                  <select name="jab" class="form-control" id="jab" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tmtmulaiakhir_pppk', 'Masa Perjanjian Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-3">
                                                <div class='input-group datepicker'>
                                                    {!! Form::text('tmtmulaiakhir_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
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
                                                    {!! Form::text('tmtakhirakhir_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div id="kgbterakhir" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6">
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
                                                {!! comboGolrupppk("idgolkgb","","") !!}
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
                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
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
                                        <li><a data-toggle="tab" href="#rpppk"><i class="fa fa-fw fa-dot-circle-o"></i> PPPK</a></li>
                                        <li><a data-toggle="tab" href="#rkgb"><i class="fa fa-fw fa-dot-circle-o"></i> KGB</a></li>
                                        <li><a data-toggle="tab" href="#rpend"><i class="fa fa-fw fa-dot-circle-o"></i> PENDIDIKAN</a></li>
                                        <li><a data-toggle="tab" href="#rdikstru"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT STRUKTURAL</a></li>
                                        <li><a data-toggle="tab" href="#rdikfung"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT FUNGSIONAL</a></li>
                                        <li><a data-toggle="tab" href="#rdiktek"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT TEKNIS</a></li>
                                        <li><a data-toggle="tab" href="#rseminar"><i class="fa fa-fw fa-dot-circle-o"></i> SEMINAR</a></li>
                                        <li><a data-toggle="tab" href="#rpenghargaan"><i class="fa fa-fw fa-dot-circle-o"></i> TANDA JASA</a></li>
                                        <li><a data-toggle="tab" href="#rbahasa"><i class="fa fa-fw fa-dot-circle-o"></i> PENGUASAAN BAHASA</a></li>
                                        <li><a data-toggle="tab" href="#rhukdis"><i class="fa fa-fw fa-dot-circle-o"></i> HUKUM DISIPLIN</a></li>
                                        <li><a data-toggle="tab" href="#rskp"><i class="fa fa-fw fa-dot-circle-o"></i> SKP</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="rjab" class="tab-pane active">
                                            <p>
                                                @if (\PermissionsLibrary::canAdd())
                                                    <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                                @endif
                                                <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                    <thead class="bg-primary">
                                                    <tr>
                                                        <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                                                        <th rowspan="2"><div class="text-center">NAMA JABATAN</div></th>
                                                        <!-- <th><div class="text-center">ESELON</div></th> -->
                                                        <th rowspan="2"><div class="text-center">NO. SK</div></th>
                                                        <th rowspan="2"><div class="text-center">TANGGAL SK</div></th>
                                                        <th colspan="2"><div class="text-center">PERJANJIAN MASA KERJA</div></th>
                                                        <th rowspan="2" class="xisguru"><div class="text-center">TUGAS GURU</div></th>
                                                        <th rowspan="2" class="xisguru"><div class="text-center">MATA PELAJARAN</div></th>
                                                        <th rowspan="2"><div class="text-center">PAK</div></th>
                                                        <th rowspan="2"><div class="text-center">UNIT KERJA</div></th>
                                                        <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th>
                                                    </tr>
                                                    <tr>
                                                        <th><div class="text-center">MULAI</div></th>
                                                        <th><div class="text-center">SELESAI</div></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="result"></tbody>
                                                </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                          <div id="rpppk" class="tab-pane active">
                                                <p>
                                                      @if (\PermissionsLibrary::canAdd())
                                                      <div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>
                                                      @endif
                                                      <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                      <thead class="bg-primary">
                                                      <tr>
                                                            <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                                                            <th rowspan="2"><div class="text-center">NAMA JABATAN</div></th>
                                                            <th rowspan="2"><div class="text-center">NO. SK</div></th>
                                                            <th rowspan="2"><div class="text-center">TANGGAL SK</div></th>
                                                            <th colspan="2"><div class="text-center">PERJANJIAN MASA KERJA</div></th>
                                                            <th rowspan="2" class="xisguru"><div class="text-center">TUGAS GURU</div></th>
                                                            <th rowspan="2" class="xisguru"><div class="text-center">MATA PELAJARAN</div></th>
                                                            <th rowspan="2"><div class="text-center">PAK</div></th>
                                                            <th rowspan="2"><div class="text-center">UNIT KERJA</div></th>
                                                            <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th>
                                                      </tr>
                                                      <tr>
                                                            <th><div class="text-center">MULAI</div></th>
                                                            <th><div class="text-center">SELESAI</div></th>
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
                                                            <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                                                            <th rowspan="2"><div class="text-center">NO SKKGB</div></th>
                                                            <th rowspan="2"><div class="text-center">TMT KGB</div></th>
                                                            <th rowspan="2"><div class="text-center">TGL KGB</div></th>
                                                            <th rowspan="2"><div class="text-center">GOLONGAN</div></th>
                                                            <th colspan="2"><div class="text-center">MASA KERJA</div></th>
                                                            <th rowspan="2"><div class="text-center">GAJI</div></th>
                                                            <th rowspan="2"><div class="text-center">PENETAP</div></th>
                                                            <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th>
                                                        </tr>
                                                        <tr>
                                                            <th><div class="text-center">TAHUN</div></th>
                                                            <th><div class="text-center">BULAN</div></th>
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
                                                        <th valign="2%"><div class="text-center">NO</div></th>
                                                        <th><div class="text-center">TK. PENDIDIKAN</div></th>
                                                        <th><div class="text-center">JURUSAN</div></th>
                                                        <th><div class="text-center">NAMA SEKOLAH</div></th>
                                                        <th><div class="text-center">TEMPAT</div></th>
                                                        <th><div class="text-center">NO. IJAZAH</div></th>
                                                        <th><div class="text-center">TGL. IJAZAH</div></th>
                                                        <th><div class="text-center">KEPALA SEKOLAH</div></th>
                                                        <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                        <th width="2%"><div class="text-center">NO</div></th>
                                                        <th><div class="text-center">NAMA DIKLAT</div></th>
                                                        <th><div class="text-center">TEMPAT DIKLAT</div></th>
                                                        <th><div class="text-center">PENYELENGGARA</div></th>
                                                        <th><div class="text-center">ANGKATAN</div></th>
                                                        <th><div class="text-center">TGL. MULAI</div></th>
                                                        <th><div class="text-center">TGL. SELESAI</div></th>
                                                        <th><div class="text-center">LAMA</div></th>
                                                        <th><div class="text-center">NO. STTP</div></th>
                                                        <th><div class="text-center">TGL. STTP</div></th>
                                                        <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA DIKLAT</div></th>
                                                    <th><div class="text-center">TEMPAT DIKLAT</div></th>
                                                    <th><div class="text-center">PENYELENGGARA</div></th>
                                                    <th><div class="text-center">ANGKATAN</div></th>
                                                    <th><div class="text-center">TGL. MULAI</div></th>
                                                    <th><div class="text-center">TGL. SELESAI</div></th>
                                                    <th><div class="text-center">LAMA</div></th>
                                                    <th><div class="text-center">NO. STTP</div></th>
                                                    <th><div class="text-center">TGL. STTP</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
                                                </tr>
                                                </thead>
                                                <tbody id="result"></tbody>
                                            </table>
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div id="rdiktek" class="tab-pane">
                                            <p>
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                <tr>
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA DIKLAT</div></th>
                                                    <th><div class="text-center">TEMPAT DIKLAT</div></th>
                                                    <th><div class="text-center">PENYELENGGARA</div></th>
                                                    <th><div class="text-center">ANGKATAN</div></th>
                                                    <th><div class="text-center">TGL. MULAI</div></th>
                                                    <th><div class="text-center">TGL. SELESAI</div></th>
                                                    <th><div class="text-center">LAMA</div></th>
                                                    <th><div class="text-center">NO. STTP</div></th>
                                                    <th><div class="text-center">TGL. STTP</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">SEMINAR</div></th>
                                                    <th><div class="text-center">TEMPAT SEMINAR</div></th>
                                                    <th><div class="text-center">PENYELENGGARA</div></th>
                                                    <th><div class="text-center">TANGGAL MULAI</div></th>
                                                    <th><div class="text-center">TANGGAL SELESAI</div></th>
                                                    <th><div class="text-center">NO. PIAGAM</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">TANDA JASA</div></th>
                                                    <th><div class="text-center">JENIS</div></th>
                                                    <th><div class="text-center">TAHUN</div></th>
                                                    <th><div class="text-center">PEJABAT PENETAP</div></th>
                                                    <th><div class="text-center">NO. SK</div></th>
                                                    <th><div class="text-center">TANGGAL SK</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA BAHASA</div></th>
                                                    <th><div class="text-center">JENIS BAHASA</div></th>
                                                    <th><div class="text-center">KEMAMPUAN</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">JENIS HUKUM DISIPLIN</div></th>
                                                    <th><div class="text-center">TINGKAT</div></th>
                                                    <th><div class="text-center">PEJABAT</div></th>
                                                    <th><div class="text-center">NO. SK</div></th>
                                                    <th><div class="text-center">TGL. SK</div></th>
                                                    <th><div class="text-center">TGL.&nbsp;MULAI</div></th>
                                                    <th><div class="text-center">TGL.&nbsp;SELESAI</div></th>
                                                    <th><div class="text-center">KETERANGAN</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NILAI PRESTASI KERJA</div></th>
                                                    <th><div class="text-center">TAHUN</div></th>
                                                    <th><div class="text-center">PEJABAT PENILAI</div></th>
                                                    <th><div class="text-center">JABATAN PENILAI</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA ORANG TUA</div></th>
                                                    <th><div class="text-center">STATUS</div></th>
                                                    <th><div class="text-center">TEMPAT LAHIR</div></th>
                                                    <th><div class="text-center">TANGGAL LAHIR</div></th>
                                                    <th><div class="text-center">ALAMAT</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">No</div></th>
                                                    <th><div class="text-center">NAMA ISTRI/SUAMI*</div></th>
                                                    <th><div class="text-center">TEMPAT LAHIR</div></th>
                                                    <th><div class="text-center">TGL. LAHIR</div></th>
                                                    <th><div class="text-center">NO. AKTA NIKAH</div></th>
                                                    <th><div class="text-center">TGL. NIKAH</div></th>
                                                    <th><div class="text-center">NIP/NRP</div></th>
                                                    <th><div class="text-center">PENDIDIKAN UMUM</div></th>
                                                    <th><div class="text-center">PEKERJAAN</div></th>
                                                    <th width="8div" class="text-center">AKSI</div></th>
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
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA ANAK</div></th>
                                                    <th><div class="text-center">TEMPAT LAHIR</div></th>
                                                    <th><div class="text-center">TGL. LAHIR</div></th>
                                                    <th><div class="text-center">JENIS KELAMIN</div></th>
                                                    <th><div class="text-center">STATUS KELUARGA</div></th>
                                                    <th><div class="text-center">PENDIDIKAN UMUM</div></th>
                                                    <th><div class="text-center">PEKERJAAN</div></th>
                                                    <th><div class="text-center">TUNJANGAN</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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
                                                <!--<div class="pull-right"><a class="tambah" href="javascript:void(0)" title="Tambah Riwayat"><i class="fa fa-plus"></i> Tambah Riwayat</a></div>-->
                                            @endif
                                            <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rpangkat">
                                                <thead class="bg-primary">
                                                <tr>
                                                    <th width="2%"><div class="text-center">NO</div></th>
                                                    <th><div class="text-center">NAMA</div></th>
                                                    <th><div class="text-center">TGL. LAHIR</div></th>
                                                    <th><div class="text-center">PEKERJAAN</div></th>
                                                    <th><div class="text-center">JENIS KELAMIN</div></th>
                                                    <th><div class="text-center">STATUS SAUDARA</div></th>
                                                    <th><div class="text-center">KETERANGAN</div></th>
                                                    <th width="8%"><div class="text-center">AKSI</div></th>
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

                                    <div class="col-md-6">
                                        <p>
                                        <div class="box-header with-border">
                                            <b class="box-title"><small>PASSWORD</small></b>
                                        </div>
                                        </p>

                                        <div class="form-group">
                                            {!! Form::label('password', 'Password:', array('class' => 'col-sm-3 control-label')) !!}
                                            <div class="col-sm-7">
                                                <input type="password" class="form-control password" id="password" name="password" placeholder="Password login pegawai">
                                            </div>
                                        </div>
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

<script type="text/javascript">
    var xhr = $.ajax();
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
        $('#simpan #nip').focus();
        $('#simpan select').select2();
        $('#simpan .awal').attr('disabled', true);
        $('#simpan #myTab li').addClass('disabled');
        $('#simpan #myTab li, #simpan .tab-pane').removeClass('active');
        $('#simpan #myTab li').css({ 'pointer-events': 'none'});
        $('#simpan #changeimage').fadeOut();
        $('#simpan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");
        // $('#simpan #pangkatgol #xjenisjabatanawal').hide();
        // $('#simpan #pangkatgol #xjenisjabatanakhir').hide();

        $('#simpan #myTab li a').each(function(index,item){
            var view = "{!! Input::get('view') !!}";
            $(item).click(function(){
                    switch(index){
                        case 0: break;
                        case 1: break;
                        case 2: break;
                        case 3: break;
                        case 4: break;
                        // case 5:
                        //     loadRjab();
                        //     $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                        //     $('#simpan .tab-content div').removeClass('active');

                        //     $('#simpan .tab2 li').first().addClass('active');
                        //     $('#simpan .tab-content #rjab').addClass('active');
                        // break;
                        case 5:
                            loadRpppk();
                            $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                            $('#simpan .tab-content div').removeClass('active');

                            $('#simpan .tab2 li').first().addClass('active');
                            $('#simpan .tab-content #rpppk').addClass('active');
                        break;
                        case 6:
                            loadRortu();
                            $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                            $('#simpan .tab-content div').removeClass('active');

                            $('#simpan .tab3 li').first().addClass('active');
                            $('#simpan .tab-content #rortu').addClass('active');
                        break;
                        case 7: break;
                        // case 8:
                        //     loadRjab();
                        // break;
                        case 8:
                            loadRpppk();
                        break;
                        case 9:
                            loadRkgb();
                        break;
                        case 10:
                            loadRpend();
                        break;
                        case 11:
                            loadRdikstru();
                        break;
                        case 12:
                            loadRdikfung();
                        break;
                        case 13:
                            loadRdiktek();
                        break;
                        case 14:
                            loadRseminar();
                        break;
                        case 15:
                            loadRpenghargaan();
                        break;
                        case 16:
                            loadRbahasa();
                        break;
                        case 17:
                            loadRhukdis();
                        break;
                        case 18:
                            loadRskp();
                        break;
                        case 19:
                            loadRortu();
                        break;
                        case 20:
                            loadRissu();
                        break;
                        case 21:
                            loadRanak();
                        break;
                        case 22:
                            loadRsaudara();
                        break;
                    }
            });
        });

        /*autoCompleteimg('#simpan #nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');*/
        autoComplete('#simpan #tmlhr', '{{url()}}/epersonal/biodata/tempatlahir', '.: Pilihan :.', null, '', '', '');

        $('#simpan #idtkpendidawal').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idjenjurusanawal', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #idtkpendid').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '',  $(this).val());
        });

        $('#simpan #kdunit').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idskpd', '{{url()}}/epersonal/biodata/skpdunit', '.: Pilihan :.', null, $(this).val(), $(this).find(":selected").text(),  $(this).val());
        });

        $('#simpan #idskpd').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idjabjbt', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#simpan #idtugasgurudosen').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '', '',  $(this).val());
        });

        $('#simpan #idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan',
                type:'post',
                data:{'idjenjab': $(this).val(), 'nip': $('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#simpan #jenisjabatan').html('Looading...');
                },
                success:function(respose){
                    $('#simpan #xjenisjabatan').html(respose);
                }
            })
        });

        $('#simpan #pangkatgol #idjenjabawal_pppk').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            console.log(idjenjab);
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan',
                type:'post',
                data:{'idjenjab': $(this).val(), 'nip': $('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#simpan #pangkatgol #jenisjabatanawal').html('Looading...');
                },
                success:function(respose){
                    // $('#simpan #pangkatgol xjenisjabatanawal').fadeIn();
                    $('#simpan #pangkatgol #xjenisjabatanawal').html(respose);
                }
            })
        });

        $('#simpan #pangkatgol #idjenjabakhir_pppk').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            console.log(idjenjab);
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan',
                type:'post',
                data:{'idjenjab': $(this).val(), 'nip': $('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#simpan #pangkatgol #jenisjabatanakhir').html('Looading...');
                },
                success:function(respose){
                    // $('#simpan #pangkatgol xjenisjabatanakhir').fadeIn();
                    $('#simpan #pangkatgol #xjenisjabatanakhir').html(respose);
                }
            })
        });

        $('#simpan #nip').on('keyup', function(e){
            xhr.abort();
            xhr = $.ajax({
                url  : '{!!url()!!}/epersonal/biodata/ceknip',
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
                        bootbox.confirm('<b>Perhatian!</b><br>Nomor Induk Pegawai tersedia, Lanjutkan pengisian biodata pegawai ?',function(a){
                            if (a == true){
                                $('#simpan .awal').attr('disabled', false);
                                $('#simpan #myTab li').removeClass('disabled');

                                $('#simpan .tab1 li, #simpan .tab2 li, #simpan .tab3 li').removeClass('active');
                                $('#simpan #myTab li').first().addClass('active');

                                $('#simpan .tab-content div').removeClass('active');
                                $('#simpan .tab-content #biodata').addClass('active');
                                $('#simpan #myTab li').css({ 'pointer-events': ''});
                            }else{
                                $('#simpan #nip').val('').focus();
                                $('#simpan #vernip').html('');
                            }
                        });
                    }else{
                        $('#simpan .awal').attr('disabled', true);
                        $('#simpan #myTab li').addClass('disabled');
                        $('#simpan #myTab li').css({ 'pointer-events': 'none'});
                        $('#simpan #myTab li, #simpan .tab-pane').removeClass('active');
                    }
                }
            });
        });

        /*$('#simpan #nip').on('change', function(e){
            e.preventDefault();
            var nip = $(this).val();

            $.ajax({
                url  : '{{url()}}/epersonal/biodata/detailpegawai',
                type : 'POST',
                data : {'nip': nip, '_token' : '{!!csrf_token()!!}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tglhr","tgskjbt","tmtjbt","tgskcpn","tmtcpn","tgskpns","tmtpns","tgskpkt","tmtpkt","tgskkgb","tmtkgb");
                    var arraytext = new Array("skpdunit");
                    var arrayradio = new Array("idjenkel","idstspeg");
                    var arrselect2 = new Array("idagama","idstskawin","idgoldarah","idjenkepeg","idjenkedudupeg","idskpd","kdunit","pejmenjbt","idjenjab","pejmencpn","idgolrucpn","pejmenpns","idgolrupns","pejmenpkt","idgolrupkt","idgolkgb","idgolkgb","idtkpendid","idtkpendidawal");

                    if(ret){
                        for(attrname in ret){
                            $('#simpan #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arraytext)!=-1){
                                $('#'+attrname).html('('+ret[attrname]+')');
                            }
                            if($.inArray(attrname,arrayradio)!=-1){
                                $('input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                            }
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#simpan #'+attrname).select2('val',ret[attrname]);
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#simpan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }

                        $("#simpan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/"+ret.photo+"" );
                        $('#simpan #changeimage').fadeIn();
                        $("#simpan #idskpd").data('select2').trigger('select', {
                            data: {"id":ret.idskpd,"text":ret.skpd}
                        });

                        $("#simpan #idjenjurusanawal").data('select2').trigger('select', {
                            data: {"id":ret.idjenjurusanawal,"text":ret.jenjurusanawal}
                        });

                        $("#simpan #idjenjurusan").data('select2').trigger('select', {
                            data: {"id":ret.idjenjurusan,"text":ret.jenjurusan}
                        });

                        $("#simpan #tmlhr").data('select2').trigger('select', {
                            data: {"id":ret.tmlhr,"text":ret.tmlhr}
                        });
                    }else{
                        $("#simpan").find('input:text, input:password, input:file, select, textarea').val('');
                        $("#simpan").find('#idagama, #idstskawin, #idgoldarah, #kdunit, #idjenkepeg, #idjenkedudupeg, #idjenjab, #pejmencpn, #idgolrucpn, #pejmenpns, #idgolrupns, #pejmenpkt, #idgolrupkt, #pejmenkgb, #idgolkgb, #idtkpendidawal, #idtkpendid, #idtugasgurudosen').val('').trigger('change');
                        $("#simpan").find('#idskpd, #idjabjbt, #idjabfung, #idjabfungum, #idjenjurusanawal, #idjenjurusan, #idmatkulpel').data('select2').trigger('select', {
                            data: {"id":"","text":""}
                        });
                        $('#simpan #changeimage').fadeOut();
                        $("#simpan #skpdunit").html('');
                        $("#simpan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/default.jpg" );
                        $("#simpan").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                    }
                }
            });
        });*/

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
                            if(html==1){
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

        $('#simpan').on('click','#changeimage',function(e){
            e.preventDefault();
            claravel_modal('Foto Pegawai','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/foto',
                data: {'nip': $('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });
    });

    function loadRpangkat(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rpangkat',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rpangkat #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rpangkat #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpppk(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rpppk',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rpppk #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rpppk #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRkgb(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rkgb',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rkgb #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rkgb #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpend(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rpend',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rpend #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rpend #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdikstru(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rdikstru',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rdikstru #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rdikstru #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdikfung(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rdikfung',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rdikfung #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rdikfung #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRdiktek(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rdiktek',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rdiktek #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rdiktek #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRseminar(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rseminar',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rseminar #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rseminar #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRpenghargaan(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rpenghargaan',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rpenghargaan #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rpenghargaan #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRbahasa(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rbahasa',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rbahasa #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rbahasa #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRhukdis(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rhukdis',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rhukdis #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rhukdis #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRskp(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rskp',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rskp #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rskp #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRakredit(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rakredit',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rakredit #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rakredit #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRortu(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rortu',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rortu #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rortu #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRissu(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rissu',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rissu #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rissu #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRanak(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/ranak',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#ranak #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#ranak #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }

    function loadRsaudara(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rsaudara',
            data:{ 'nip':$('#simpan #nip').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#rsaudara #result').html('Looading..');
            },
            success:function(response){
                if($('#simpan #nip').val()!=''){
                    $('#rsaudara #result').html(response);
                }else{
                    alert('Ketik NIP / Nama Harus diisi..!')
                }
            }
        });
    }
</script>
