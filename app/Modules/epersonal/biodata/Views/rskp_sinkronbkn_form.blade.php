<?php
  use App\Services\SkpService;
  use App\Repositories\SkpRepository;
    $nip = Input::get('nip');
    $idskp = Input::get('id');
    $idskpbkn = Input::get('idskpbkn');
  
    $srv = new SkpService(new SkpRepository);
    $skp = $srv->fetch($nip)->filter('tahun',2021)->first();
  
    /*catatan sinkronisasi*/
    /*
     *
     Jika $idskpbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_skp yang akan dikirim sinkronisasinya
     Jika $idskpbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari bkn dan data dari r_skp simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_skp BKN
     2. TARIK DATA KE BKN    : Untuk form preview data dari r_skp simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        @if($idskp != '')
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>SINKRONISAI BKN</b></a></li>
        @endif
        <li class="<?php echo (($idskp != '')?'':'active')?>"><a data-toggle="tab" id="xdatabkn" href="#tab_2"><i class="fa fa-list"></i> <b>DATA PPK BKN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($idskp != '')
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                @if($idskpbkn != '')
                    <!--preview data r_skp BKN-->
                    <div class="col-md-6">
                        <div class="callout callout-success">
                            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                            <ul style="padding-left: 15px">
                                <li>Preview data yang ditampilkan merupakan data Riwayat PPK dari BKD</li>
                                <li>Untuk melakukan sinkronisasi data PPK dari BKN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                                <li>Ketika proses <b>TARIK DATA</b> selesai riwayat PPK dari BKD sudah terkoneksi dengan SIMPEG</li>
                            </ul>
                        </div>

                        {!! Form::open(array('url' => url().'/webservices/skp/save', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp')) !!}
                        {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                        <div class="box-body">
                            
                            <div class="form-group">
                                {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('tahun', $skp['tahun'], array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4, 'readonly'=>'readonly')) !!}

                                </div>
                            </div>

                            <b class="box-title"><i class="fa fa-fw fa-child"></i> PEJABAT PENILAI</b><hr>
                            <div class="form-group">
                            {!! Form::label('penilai', 'Nip Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                 {!! Form::text('nippenilai', $skp['penilaiNipNrp'], array('class'=> 'form-control', 'id'=> 'nippenilai', 'placeholder'=> 'Nip Penilai', 'readonly'=>'readonly')) !!}
                            </div>
                          </div>

                            <div class="form-group">
                                {!! Form::label('pejpenilai', 'Nama Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('pejpenilai', $skp['penilaiNama'], array('class'=> 'form-control', 'placeholder'=> 'Nama Pejabat', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('idgolpenilai', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('golpenilai', $skp['penilaiGolongan'], array('class'=> 'form-control', 'required' => 'required', 'id'=> 'golpenilai', 'placeholder'=> 'Gol. Ruang', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('jabpenilai', 'Jabatan Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('jabpenilai', $skp['penilaiJabatan'], array('class'=> 'form-control', 'id'=> 'jabpenilai', 'placeholder'=> 'Jabatan Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('skpdpenilai', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('skpdpenilai', $skp['penilaiUnorNama'], array('class'=> 'form-control', 'required' => 'required', 'id'=> 'skpdpenilai', 'placeholder'=> 'Unit Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> ATASAN PEJABAT PENILAI</b><hr>
                            <div class="form-group">
                            {!! Form::label('penilai', 'Nip Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nipatasan', $skp['atasanPenilaiNipNrp'], array('class'=> 'form-control', 'id'=> 'nipatasan', 'placeholder'=> 'Nip Penilai', 'readonly'=>'readonly')) !!}
                            </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('pejpenilai', 'Nama Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('pejatasan', $skp['atasanPenilaiNama'], array('class'=> 'form-control', 'id'=>'pejatasan', 'placeholder'=> 'Nama Pejabat', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('idgolpenilai', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('golpenilai', $skp['atasanPenilaiGolongan'], array('class'=> 'form-control', 'required' => 'required', 'id'=> 'golpenilai', 'placeholder'=> 'Gol. Ruang', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('jabpenilai', 'Jabatan Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('jabatasan', $skp['atasanPenilaiJabatan'], array('class'=> 'form-control', 'id'=>'jabatasan', 'placeholder'=> 'Jabatan Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('skpdpenilai', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('skpdpenilai', $skp['atasanPenilaiUnorNama'], array('class'=> 'form-control', 'required' => 'required', 'id'=> 'skpdpenilai', 'placeholder'=> 'Unit Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                {!! Form::label('idjenjab', 'Jenjang Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7 idjenjabi">
                                    <label class="radio-inline">
                                        <input type="radio" name="idjenjab" id="idjenjab1" value="1" {!!(($skp['jenisJabatan'] == 1)?'checked':'')!!}> Struktural
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="idjenjab" id="idjenjab2" value="2" {!!(($skp['jenisJabatan'] == 2)?'checked':'')!!}> Fungsional
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="idjenjab" id="idjenjab3" value="3" {!!(($skp['jenisJabatan'] == 3)?'checked':'')!!}> Pelaksana
                                    </label>
                                </div>
                            </div>
                             <div class="form-group">
                                {!! Form::label('nilai', 'ID SKP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('idskpbkn', $skp['id'], array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nilai', 'Nilai SKP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nilaiSkp', $skp['nilaiSkp'], array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6, 'readonly'=>'readonly')) !!}
                                    <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('orpel', 'Orpel:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('orientasiPelayanan', $skp['orientasiPelayanan'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('integritas', 'Integitas:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('integritass', $skp['integritas'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('komitmen', 'Komitmen:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('komitmens', $skp['komitmen'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('disiplin', 'Disiplin:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('disiplins', $skp['disiplin'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('kerjasama', 'Kerjasama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kerjasamas', $skp['kerjasama'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                {!! Form::label('Kepemimpinan', 'Kepemimpinan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kepemimpinans',$skp['kepemimpinan'], array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                {!! Form::label('nilaikinerja', 'Nilai Prestasi Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nilaikinerja', $skp['nilaiPrestasiKerja'], array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                    <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
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

                <!--preview data r_skp simpeg-->
                <div class="col-md-<?php echo (($idskpbkn != '')?6:12)?>">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat PPK dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke BKN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada riwayat PPK SIMPEG sudah terkoneksi dengan BKN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url().'/epersonal/biodata/syncskp', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp')) !!}
                    {!! Form::hidden('id', Input::get('id'), array('id'=> 'id')) !!}
                    <div class="box-body rskp-perubahan">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control ', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tahun', null, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4)) !!}

                            </div>
                        </div>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> PEJABAT PENILAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nippenilai', 'NIP Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nippenilai" class="form-control nippenilai" id="nippenilai" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejpenilai', 'Nama Lengkap:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejpenilai', '', array('class'=> 'form-control', 'required' => 'required', 'id' => 'pejpenilai', 'placeholder'=> 'Nama Lengkap')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idgolpenilai', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idgolpenilai', '', array('class'=> 'form-control', 'id'=> 'idgolpenilai')) !!}
                              
                                {!! Form::text('golpenilai', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'golpenilai', 'placeholder'=> 'Gol. Ruang')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabpenilai', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idjenjabpenilai', '', array('class'=> 'form-control', 'id'=> 'idjenjabpenilai')) !!}
                                {!! Form::hidden('idjabpenilai', '', array('class'=> 'form-control', 'id'=> 'idjabpenilai')) !!}
                                {!! Form::text('jabpenilai', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'jabpenilai', 'placeholder'=> 'Jabatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpdpenilai', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idskpdpenilai', '', array('class'=> 'form-control', 'id'=> 'idskpdpenilai')) !!}
                                {!! Form::text('skpdpenilai', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'skpdpenilai', 'placeholder'=> 'Unit Kerja')) !!}
                            </div>
                        </div>

                        <hr>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> ATASAN PEJABAT PENILAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nipatasan', 'NIP Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nipatasan" class="form-control nipatasan" id="nipatasan" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejatasan', 'Nama Lengkap:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejatasan', '', array('class'=> 'form-control', 'required' => 'required', 'id' => 'pejatasan', 'placeholder'=> 'Nama Lengkap')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idgolatasan', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idgolatasan', '', array('class'=> 'form-control', 'id'=> 'idgolatasan')) !!}
                                {!! Form::text('golatasan', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'golatasan', 'placeholder'=> 'Gol. Ruang')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabatasan', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idjenjabatasan', '', array('class'=> 'form-control', 'id'=> 'idjenjabatasan')) !!}
                                {!! Form::hidden('idjabatasan', '', array('class'=> 'form-control', 'id'=> 'idjabatasan')) !!}
                                {!! Form::text('jabatasan', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'jabatasan', 'placeholder'=> 'Jabatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpdatasan', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idskpdatasan', '', array('class'=> 'form-control', 'id'=> 'idskpdatasan')) !!}
                                {!! Form::text('skpdatasan', '', array('class'=> 'form-control', 'required' => 'required', 'id'=> 'skpdatasan', 'placeholder'=> 'Unit Kerja')) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('idjenjab', 'Jenjang Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7 idjenjabi">
                                <label class="radio-inline">
                                    <input type="radio" name="idjenjab" id="idjenjab1" value="1" checked=""> Struktural
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="idjenjab" id="idjenjab2" value="2"> Fungsional
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="idjenjab" id="idjenjab3" value="3"> Pelaksana
                                </label>
                            </div>
                        </div>
                          <div class="form-group">
                                {!! Form::label('nilai', 'ID SKP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('idskpbkn', $idskpbkn , array('class'=> 'form-control')) !!}
                                    <br>
                                </div>
                            </div>
                        <div class="form-group">
                            {!! Form::label('nilai', 'Nilai SKP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nilai', null, array('class'=> 'form-control num score', 'placeholder'=>'00.00', 'maxlength'=> 6)) !!}
                                <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('orpel', 'Orpel:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('orpel', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('integritas', 'Integitas:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('integritas', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('komitmen', 'Komitmen:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('komitmen', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('disiplin', 'Disiplin:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('disiplin', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kerjasama', 'Kerjasama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kerjasama', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <div class="form-group kepemimpinan">
                            {!! Form::label('pim', 'Kepemimpinan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pim', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('nilaikinerja', 'Nilai Prestasi Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nilaikinerja', null, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6)) !!}
                                <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> SINKRON DATA KE BKN</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> BATALKAN</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endif

        <div id="tab_2" class="tab-pane <?php echo (($idskp != '')?'':'active')?>">
            <div class="row">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Menu ini menampilkan data riwayat PPK dari BKN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data PPK dari BKN ke SIMMPEG</li>
                    </ul>
                </div>

                <table class="table table-striped table-hover table-condensed table-bordered" role="grid" id="tb-rpangkat">
                    <thead class="bg-primary">
                    <tr>
                        <th width="2%"><div class="text-center">NO</div></th>
                        <th><div class="text-center">NILASI PRESTASI KERJA</div></th>
                        <th><div class="text-center">TAHUN</div></th>
                        <th><div class="text-center">PEJABAT PENILAI</div></th>
                        <th><div class="text-center">JABATAN PENILAI</div></th>
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

<script type="text/javascript">
    $(document).ready(function(){
         
        <?php if($idskp == '') { ?>
        loadRskpbkn();
        <?php } ?>

        $('#xdatabkn').on('click', function(){
            loadRskpbkn();
        })

        $('#form-rskp .rskp-perubahan #nippenilai').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp .rskp-perubahan #nippenilai').val();
            $.ajax({
                url  : '{!!url()!!}/epersonal/biodata/atasan',
                type : 'POST',
                data : {'nip': nip, '_token': '{!!csrf_token()!!}'},
                beforeSend: function(){
                    $('#loading-state').fadeIn("slow");
                },
                success:function(response){
                    var ret = $.parseJSON(response);
                    $('#loading-state').fadeOut("slow");
                    if(ret){
                        $('#form-rskp .rskp-perubahan #nippenilai').val(ret.nip);
                        $('#form-rskp .rskp-perubahan #pejpenilai').val(ret.namalengkap);
                        $('#form-rskp .rskp-perubahan #idjenjabpenilai').val(ret.idjenjab);
                        $('#form-rskp .rskp-perubahan #idjabpenilai').val(ret.idjab);
                        $('#form-rskp .rskp-perubahan #jabpenilai').val(ret.jab);
                        $('#form-rskp .rskp-perubahan #idgolpenilai').val(ret.idgolru);
                        $('#form-rskp .rskp-perubahan #golpenilai').val(ret.golru);
                        $('#form-rskp .rskp-perubahan #idskpdpenilai').val(ret.idskpd);
                        $('#form-rskp .rskp-perubahan #skpdpenilai').val(ret.skpd);
                    }
                }
            });
        });

        $('#form-rskp .rskp-perubahan #nipatasan').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp .rskp-perubahan #nipatasan').val();
            $.ajax({
                url  : '{!!url()!!}/epersonal/biodata/atasan',
                type : 'POST',
                data : {'nip': nip, '_token': '{!!csrf_token()!!}'},
                beforeSend: function(){
                    $('#loading-state').fadeIn("slow");
                },
                success:function(response){
                    var ret = $.parseJSON(response);
                    $('#loading-state').fadeOut("slow");
                    if(ret){
                        $('#form-rskp .rskp-perubahan #nipatasan').val(ret.nip);
                        $('#form-rskp .rskp-perubahan #pejatasan').val(ret.namalengkap);
                        $('#form-rskp .rskp-perubahan #idjenjabatasan').val(ret.idjenjab);
                        $('#form-rskp .rskp-perubahan #idjabatasan').val(ret.idjab);
                        $('#form-rskp .rskp-perubahan #jabatasan').val(ret.jab);
                        $('#form-rskp .rskp-perubahan #idgolatasan').val(ret.idgolru);
                        $('#form-rskp .rskp-perubahan #golatasan').val(ret.golru);
                        $('#form-rskp .rskp-perubahan #idskpdatasan').val(ret.idskpd);
                        $('#form-rskp .rskp-perubahan #skpdatasan').val(ret.skpd);
                    }
                }
            });
        });

        $('#form-rskp .rskp-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rskp .date").mask("99-99-9999");
        $("#form-rskp .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rskp .rskp-perubahan #idpejab').on('change', function(e){
            e.preventDefault();
            $('#form-rskp .rskp-perubahan #jabpenilai').val($(this).find(":selected").text());
        })

        //jobbradi
        $('input[type=radio][name=idjenjab]').change(function() {
            if (this.value == '1') {
                $('#form-rskp .rskp-perubahan .kepemimpinan').show();
            }else{
                $('#form-rskp .rskp-perubahan #pim').val('');
                $('#form-rskp .rskp-perubahan .kepemimpinan').hide();
            }
        });

        $('#form-rskp .rskp-perubahan .score').click(function(e) {
            var nilaiskp = $("#form-rskp #nilai").val();
            var nilaiorpel = $("#form-rskp #orpel").val();
            var nilaiintegritas = $("#form-rskp #integritas").val();
            var nilaikomitmen = $("#form-rskp #komitmen").val();
            var nilaidisiplin = $("#form-rskp #disiplin").val();
            var nilaikerjasama = $("#form-rskp #kerjasama").val();
            var nilaipim = $("#form-rskp #pim").val();

            if($('#form-rskp .rskp-perubahan #pim').val() != '') {
                var nilaiperilaku = (parseFloat(nilaiorpel)+parseFloat(nilaiintegritas)+parseFloat(nilaikomitmen)+parseFloat(nilaidisiplin)+parseFloat(nilaikerjasama)+parseFloat(nilaipim))/6;
            } else {
                var nilaiperilaku = (parseFloat(nilaiorpel)+parseFloat(nilaiintegritas)+parseFloat(nilaikomitmen)+parseFloat(nilaidisiplin)+parseFloat(nilaikerjasama))/5;
            }

            var nilaikinerja = (parseFloat(nilaiskp)*0.6)+(parseFloat(nilaiperilaku)*0.4);
            console.log(nilaiperilaku);

            if(!isNaN(nilaikinerja)){
                $('#form-rskp .rskp-perubahan #nilaikinerja').val(nilaikinerja.toFixed(2));
            }

        }).trigger('click');
        //end jobbradi

        $('#form-rskp').on('submit',function(e){
            
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
                            if((html==1) || (html==4)){
                                notification('Data Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');
                                loadRskp();
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_skp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                //var arrselect2 = new Array('idpejab');
                var arrayradio = new Array("idjenjab");
                if(ret){
                    for(attrname in ret){
                        $('#form-rskp .rskp-perubahan #'+attrname).val(ret[attrname]);
                        /*if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rskp .rskp-perubahan #'+attrname).select2('val',ret[attrname]);
                        }*/
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('#form-rskp .rskp-perubahan input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true).trigger('click');
                        }
                    }

                    autoCompleteimg('#form-rskp .rskp-perubahan #nippenilai', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nippenilai, ret.nippenilai, '');
                    autoCompleteimg('#form-rskp .rskp-perubahan #nipatasan', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nipatasan, ret.nipatasan, '');

                    var text = ret.jabpenilai;
                    if(text.indexOf(ret.idpejab) != -1){
                        var newOption = new Option(ret.jabpenilai, ret.idpejab, false, true);
                        $('#form-rskp .rskp-perubahan #idpejab').append(newOption).trigger('change');
                    }
                }
            }
        });
        <?php } else { ?>
        autoCompleteimg('#form-rskp .rskp-perubahan #nippenilai', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        autoCompleteimg('#form-rskp .rskp-perubahan #nipatasan', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        <?php } ?>
    });

    function loadRskpbkn(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/epersonal/biodata/data/rskp_sinkronbkn_data',
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