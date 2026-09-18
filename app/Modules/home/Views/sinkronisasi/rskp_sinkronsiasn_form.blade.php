<?php
    use App\Models\SinkronisasiModel;
    $siasn = new SinkronisasiModel();
    //    use App\Services\SkpService;
    //    use App\Repositories\SkpRepository;

    $nip = Input::get('nip');
    $idskp = Input::get('id');
    $idbkn = Input::get('idskpbkn');

    if($idbkn != ''){
//        $srv = new SkpService(new SkpRepository);
//        $skp = $srv->fetch($nip)->filter('tahun',2021)->first();
//        $skp = accessDatapersonalsiasn('skp/id',$idbkn);

        $bkn = accessDatariwayatsiasn('pns/rw-skp',$nip);
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
        <li class="<?php echo (($idskp != '')?'':'active')?>"><a data-toggle="tab" id="xdatabkn" href="#tab_syx2"><i class="fa fa-list"></i> <b>DATA PPK SIASN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($idskp != '')
        <div id="tab_syx1" class="tab-pane active">
            <br>
            <div class="row">
                @if($idbkn != '')
                @foreach($bkn as $skp)
                @if($skp->id == $idbkn)
                    <!--preview data r_skp SIASN-->
                    <div class="col-md-6">
                        <div class="alert callout callout-success">
                            <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                            <ul style="padding-left: 15px">
                                <li>Preview data yang ditampilkan merupakan data Riwayat PPK dari SIASN</li>
                                <li>Untuk melakukan sinkronisasi data PPK dari SIASN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                                <li>Ketika proses <b>TARIK DATA</b> selesai riwayat PPK dari SIASN sudah terkoneksi dengan SIMPEG</li>
                            </ul>
                        </div>

                        {!! Form::open(array('url' => url().'/syncrskpbkn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp1')) !!}
                        {!! Form::hidden('id', $idskp, array('id'=> 'id')) !!}
                        {!! Form::hidden('idskpbkn', $idbkn, array('id'=> 'idskpbkn')) !!}
                        {!! Form::hidden('statusPenilai', $skp->statusPenilai, array('id'=> 'statusPenilai')) !!}
                        {!! Form::hidden('statusAtasanPenilai', $skp->statusAtasanPenilai, array('id'=> 'statusAtasanPenilai')) !!}
                        <?php
                            $peraturan = ''; #$skp->jenisPeraturanKinerjaKd;
                            $thskp = $skp->tahun;
                            $ppskp = ''; #$siasn->getPpskp($thskp, $peraturan);
                        ?>
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
                                    {!! Form::text('tahun', $skp->tahun, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4, 'readonly'=>'readonly')) !!}

                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('jenisJabatan', 'Jenjang Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7 idjenjabi" style="pointer-events: none;">
                                    <label class="radio-inline">
                                        <input type="radio" name="jenisJabatan" id="jenisJabatan1" value="1" {!!((getIdenisjabatanbkn($skp->jenisJabatan) == 1)?'checked':'')!!}> Struktural
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="jenisJabatan" id="jenisJabatan2" value="2" {!!((getIdenisjabatanbkn($skp->jenisJabatan) == 2)?'checked':'')!!}> Fungsional
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="jenisJabatan" id="jenisJabatan3" value="3" {!!((getIdenisjabatanbkn($skp->jenisJabatan) == 3)?'checked':'')!!}> Pelaksana
                                    </label>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                {!! Form::label('jenisPeraturanKinerjaKd', 'Jenis Peraturan kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('jenisPeraturanKinerjaKd', $ppskp, array('class'=> 'form-control', 'placeholder'=>'Jenis Peraturan kerja', 'readonly'=>'readonly')) !!}

                                </div>
                            </div><hr>-->

                            <!--<div class="form-group">
                                {!! Form::label('idskpbkn', 'ID SKP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('idskpbkn', $skp->id, array('class'=> 'form-control num', 'placeholder'=>'','readonly'=>'readonly')) !!}
                                    <br>
                                </div>
                            </div>-->
                            <div class="form-group">
                                {!! Form::label('nilaiSkp', 'Nilai SKP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nilaiSkp', $skp->nilaiSkp, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6, 'readonly'=>'readonly')) !!}
                                    <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
                                </div>
                            </div>

                            <b class="box-title"><i class="fa fa-fw fa-child"></i> PERILAKU KERJA</b><hr>
                            <div class="form-group">
                                {!! Form::label('orientasiPelayanan', 'Orpel:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('orientasiPelayanan', $skp->orientasiPelayanan, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('integritas', 'Integitas:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('integritas', $skp->integritas, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('komitmen', 'Komitmen:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('komitmen', $skp->komitmen, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            @if($ppskp == 'PP46')
                            <div class="form-group">
                                {!! Form::label('disiplin', 'Disiplin:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('disiplin', $skp->disiplin, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                {!! Form::label('kerjasama', 'Kerjasama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kerjasama', $skp->kerjasama, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            @if($ppskp != 'PP46')
                            <div class="form-group ">
                                {!! Form::label('kepemimpinan', 'Kepemimpinan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('kepemimpinan',$skp->kepemimpinan, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            @endif
                            <hr>

                            <div class="form-group">
                                {!! Form::label('jumlah', 'Jumlah Perilaku:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('jumlah', $skp->jumlah, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nilairatarata', 'Nilai Perilaku:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-3">
                                    {!! Form::text('nilairatarata', $skp->nilairatarata, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                                <div class="col-sm-1" style="padding-top: 10px;">
                                    &nbsp;
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::text('nilaiPerilakuKerja', $skp->nilaiPerilakuKerja, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                {!! Form::label('nilaiPrestasiKerja', 'Nilai Prestasi Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nilaiPrestasiKerja', $skp->nilaiPrestasiKerja, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6,'readonly'=>'readonly')) !!}
                                    <br><em>(Isian Nilai 00.00 sd 100.00), Koma menggunakan titik(.) </em>
                                </div>
                            </div>

                            <b class="box-title"><i class="fa fa-fw fa-child"></i> PEJABAT PENILAI</b><hr>
                            <div class="form-group">
                            {!! Form::label('penilaiNipNrp', 'Nip Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                 {!! Form::text('penilaiNipNrp', $skp->penilaiNipNrp, array('class'=> 'form-control', 'placeholder'=> 'Nip Penilai', 'readonly'=>'readonly')) !!}
                            </div>
                          </div>

                            <div class="form-group">
                                {!! Form::label('penilaiNama', 'Nama Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiNama', $skp->penilaiNama, array('class'=> 'form-control', 'placeholder'=> 'Nama Pejabat', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('penilaiGolongan', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiGolongan', $skp->penilaiGolongan, array('class'=> 'form-control', 'required' => 'required', 'placeholder'=> 'Gol. Ruang', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('penilaiTmtGolongan', 'TMT Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiTmtGolongan', $skp->penilaiTmtGolongan, array('class'=> 'form-control', 'placeholder'=> 'yyyy-mm-dd', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('penilaiJabatan', 'Jabatan Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiJabatan', $skp->penilaiJabatan, array('class'=> 'form-control', 'placeholder'=> 'Jabatan Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('penilaiUnorNama', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('penilaiUnorNama', $skp->penilaiUnorNama, array('class'=> 'form-control', 'required' => 'required', 'placeholder'=> 'Unit Kerja', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <hr>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> ATASAN PEJABAT PENILAI</b><hr>
                            <div class="form-group">
                            {!! Form::label('atasanPenilaiNipNrp', 'Nip Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('atasanPenilaiNipNrp', $skp->atasanPenilaiNipNrp, array('class'=> 'form-control', 'placeholder'=> 'Nip Penilai', 'readonly'=>'readonly')) !!}
                            </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('atasanPenilaiNama', 'Nama Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('atasanPenilaiNama', $skp->atasanPenilaiNama, array('class'=> 'form-control', 'placeholder'=> 'Nama Pejabat', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('atasanPenilaiGolongan', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('atasanPenilaiGolongan', $skp->atasanPenilaiGolongan, array('class'=> 'form-control', 'required' => 'required', 'placeholder'=> 'Gol. Ruang', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('atasanPenilaiTmtGolongan', 'TMT Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('atasanPenilaiTmtGolongan', $skp->atasanPenilaiTmtGolongan, array('class'=> 'form-control', 'placeholder'=> 'yyyy-mm-dd', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('atasanPenilaiJabatan', 'Jabatan Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('atasanPenilaiJabatan', $skp->atasanPenilaiJabatan, array('class'=> 'form-control', 'placeholder'=> 'Jabatan Penilai', 'readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('atasanPenilaiUnorNama', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('atasanPenilaiUnorNama', $skp->atasanPenilaiUnorNama, array('class'=> 'form-control', 'required' => 'required', 'placeholder'=> 'Unit Kerja', 'readonly'=>'readonly')) !!}
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
                @endforeach
                @endif

                @if($idskp != 'x')
                <!--preview data r_skp simpeg-->
                <div class="col-md-<?php echo (($idbkn != '')?6:12)?>">
                    <div class="alert callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat PPK dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke SIASN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada riwayat PPK SIMPEG sudah terkoneksi dengan SIASN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url().'/syncrskpsimpegsiasn', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp2')) !!}
                    <div class="box-body rskp-perubahan">
                    <b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                    <div class="form-group">
                        {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idskpbkn', null, array('id'=> 'idskpbkn')) !!}
                            {!! Form::text('nip', $nip, array('class'=> 'form-control ', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                        </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tahun', null, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4)) !!}

                            </div>
                        </div>
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
                            {!! Form::label('jenisppk', 'Jenis Peraturan Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select id="jen_aturan_kinerja" name="jen_aturan_kinerja" class="form-control">
                                    <option value="">.: Pilihan :.</option>
                                    <option value="46">PP46</option>
                                    <option value="30">PP30</option>
                                </select>
                            </div>
                        </div><hr>

                        <!--<div class="form-group">
                            {!! Form::label('nilai', 'ID SKP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('idskpbkn', (($idbkn!='')?$idbkn:'-'), array('class'=> 'form-control', 'readonly'=>'readonly')) !!}
                                <br>
                            </div>
                        </div>-->
                        <div class="form-group">
                            {!! Form::label('nilai', 'Nilai SKP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::text('nilai', null, array('class'=> 'form-control num score', 'placeholder'=>'00.00', 'maxlength'=> 6)) !!}
                            </div>
                            <div class="col-sm-1 xpr1" style="padding-top: 10px;">
                                70%
                            </div>
                            <div class="col-sm-3">
                                {!! Form::text('nilaiprestasi', null, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6, 'id'=>'nilaiprestasi', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <em>Isian Nilai 00.00 sd 100.00, Koma menggunakan titik (.)  </em>
                            </div>
                        </div>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> PERILAKU KERJA</b><hr>
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
                        <div class="form-group disiplin">
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
                            {!! Form::label('jumlah', 'Jumlah Perilaku:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('jumlah', null, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6, 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nilairatarata', 'Nilai Perilaku:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::text('nilairatarata', null, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6, 'readonly'=>'readonly')) !!}
                            </div>
                            <div class="col-sm-1 xpr2" style="padding-top: 10px;">
                                30%
                            </div>
                            <div class="col-sm-3">
                                {!! Form::text('nilaiperilaku', null, array('class'=> 'form-control num', 'placeholder'=>'00.00', 'maxlength'=> 6, 'id'=>'nilaiperilaku', 'readonly'=>'readonly')) !!}
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
                        <li>Menu ini menampilkan data riwayat PPK dari SIASN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data PPK dari SIASN ke SIMMPEG</li>
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
        loadRskpbkn();
        <?php } ?>

        $('#xdatabkn').on('click', function(){
            loadRskpbkn();
        })

        $('#form-rskp2 .rskp-perubahan #nippenilai').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp2 .rskp-perubahan #nippenilai').val();
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
                        $('#form-rskp2 .rskp-perubahan #nippenilai').val(ret.nip);
                        $('#form-rskp2 .rskp-perubahan #pejpenilai').val(ret.namalengkap);
                        $('#form-rskp2 .rskp-perubahan #idjenjabpenilai').val(ret.idjenjab);
                        $('#form-rskp2 .rskp-perubahan #idjabpenilai').val(ret.idjab);
                        $('#form-rskp2 .rskp-perubahan #jabpenilai').val(ret.jab);
                        $('#form-rskp2 .rskp-perubahan #idgolpenilai').val(ret.idgolru);
                        $('#form-rskp2 .rskp-perubahan #golpenilai').val(ret.golru);
                        $('#form-rskp2 .rskp-perubahan #tmtpktpenilai').val(ret.tmtpkt);
                        $('#form-rskp2 .rskp-perubahan #idskpdpenilai').val(ret.idskpd);
                        $('#form-rskp2 .rskp-perubahan #skpdpenilai').val(ret.skpd);
                    }
                }
            });
        });

        $('#form-rskp2 .rskp-perubahan #nipatasan').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp2 .rskp-perubahan #nipatasan').val();
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
                        $('#form-rskp2 .rskp-perubahan #nipatasan').val(ret.nip);
                        $('#form-rskp2 .rskp-perubahan #pejatasan').val(ret.namalengkap);
                        $('#form-rskp2 .rskp-perubahan #idjenjabatasan').val(ret.idjenjab);
                        $('#form-rskp2 .rskp-perubahan #idjabatasan').val(ret.idjab);
                        $('#form-rskp2 .rskp-perubahan #jabatasan').val(ret.jab);
                        $('#form-rskp2 .rskp-perubahan #idgolatasan').val(ret.idgolru);
                        $('#form-rskp2 .rskp-perubahan #golatasan').val(ret.golru);
                        $('#form-rskp2 .rskp-perubahan #tmtpktatasan').val(ret.tmtpkt);
                        $('#form-rskp2 .rskp-perubahan #idskpdatasan').val(ret.idskpd);
                        $('#form-rskp2 .rskp-perubahan #skpdatasan').val(ret.skpd);
                    }
                }
            });
        });

        $('#form-rskp2 .rskp-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rskp2 .date").mask("99-99-9999");
        $("#form-rskp2 .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rskp2 .rskp-perubahan #idpejab').on('change', function(e){
            e.preventDefault();
            $('#form-rskp2 .rskp-perubahan #jabpenilai').val($(this).find(":selected").text());
        })

        $('#form-rskp2 .rskp-perubahan input[type=radio][name=idjenjab]').change(function() {
            if (this.value == '1') {
                $('#form-rskp2 .rskp-perubahan .kepemimpinan').show();
            }else{
                $('#form-rskp2 .rskp-perubahan #pim').val('');
                $('#form-rskp2 .rskp-perubahan .kepemimpinan').hide();
            }

            var idjenjab = $('#form-rskp2 .rskp-perubahan input[type=radio][name=idjenjab]:checked').val();
            var jenisppk = $('#form-rskp2 .rskp-perubahan #jenisppk').val();
            getScore(idjenjab, jenisppk);
        });

        $('#form-rskp2 #jenisppk').change(function() {
            if (this.value == '46') {
                $('#form-rskp2 .rskp-perubahan .xintegritas').html('Integritas:');
                $('#form-rskp2 .rskp-perubahan .disiplin').show();
            }else{
                $('#form-rskp2 .rskp-perubahan .xintegritas').html('Inisiatif Kerja:');
                $('#form-rskp2 .rskp-perubahan #disiplin').val('');
                $('#form-rskp2 .rskp-perubahan .disiplin').hide();
            }

            var idjenjab = $('#form-rskp2 .rskp-perubahan input[type=radio][name=idjenjab]:checked').val();
            var jenisppk = $('#form-rskp2 .rskp-perubahan #jenisppk').val();
            getScore(idjenjab, jenisppk);
        });

        $('#form-rskp2 .score').keyup(function(e) {
            var idjenjab = $('#form-rskp2 .rskp-perubahan input[type=radio][name=idjenjab]:checked').val();
            var jenisppk = $('#form-rskp2 .rskp-perubahan #jenisppk').val();
            getScore(idjenjab, jenisppk);
        }).trigger('keyup');

        $('#form-rskp1').on('submit',function(e){

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
                                loadRskp();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rskp2').on('submit',function(e){

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
                var arrdate = new Array("tmtpktpenilai","tmtpktatasan");
                var arrayradio = new Array("idjenjab");
                if(ret){
                    for(attrname in ret){
                        $('#form-rskp2 .rskp-perubahan #'+attrname).val(ret[attrname]);
                        /*if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rskp2 .rskp-perubahan #'+attrname).select2('val',ret[attrname]);
                        }*/
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('#form-rskp2 .rskp-perubahan input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true).trigger('click');
                        }

                        if($.inArray(attrname,arrdate)!=-1){
                            if(ret[attrname] != null && ret[attrname] != ''){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rskp2 .rskp-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }else{
                                $('#form-rskp2 .rskp-perubahan #'+attrname).val(ret[attrname]);
                            }
                        }
                    }

                    autoCompleteimg('#form-rskp2 .rskp-perubahan #nippenilai', '{!!url()!!}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nippenilai, ret.nippenilai, '');
                    autoCompleteimg('#form-rskp2 .rskp-perubahan #nipatasan', '{!!url()!!}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nipatasan, ret.nipatasan, '');

                    var text = ret.jabpenilai;
                    if(text.indexOf(ret.idpejab) != -1){
                        var newOption = new Option(ret.jabpenilai, ret.idpejab, false, true);
                        $('#form-rskp2 .rskp-perubahan #idpejab').append(newOption).trigger('change');
                    }

                    $("#form-rskp2 .rskp-perubahan input[type=radio][name=idjenjab]:checked").trigger('change');
                    $('#form-rskp2 .rskp-perubahan #jenisppk').trigger('change');
                }
            }
        });
        <?php } else { ?>
        autoCompleteimg('#form-rskp2 .rskp-perubahan #nippenilai', '{!!url()!!}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        autoCompleteimg('#form-rskp2 .rskp-perubahan #nipatasan', '{!!url()!!}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        <?php } ?>
    });

    function loadRskpbkn(){
        xhr.abort();
        xhr = $.ajax({
            type:'post',
            url:'{!!url()!!}/sinkronsiasn/rskp_sinkronsiasn_data',
            data:{ 'nip': '<?php echo $nip?>', '_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                $('#xresult').html('Looading..');
            },
            success:function(response){
                $('#xresult').html(response);
            }
        });
    }

    function getScore(idjenjab, jenisppk){
        var xpr1 = '60%';
        var xpr2 = '40%';
        var nilaiskp = parseFloat($("#form-rskp2 .rskp-perubahan #nilai").val()) || 0;
        var nilaiorpel = parseFloat($("#form-rskp2 .rskp-perubahan #orpel").val()) || 0;
        var nilaiintegritas = parseFloat($("#form-rskp2 .rskp-perubahan #integritas").val()) || 0;
        var nilaikomitmen = parseFloat($("#form-rskp2 .rskp-perubahan #komitmen").val()) || 0;
        var nilaidisiplin = parseFloat($("#form-rskp2 .rskp-perubahan #disiplin").val()) || 0;
        var nilaikerjasama = parseFloat($("#form-rskp2 .rskp-perubahan #kerjasama").val()) || 0;
        var nilaipim = parseFloat($("#form-rskp2 .rskp-perubahan #pim").val()) || 0;

        if(idjenjab == 1){
            if(jenisppk == 46){
                var xpr1 = '60%';
                var xpr2 = '40%';
                var jumlah = (nilaiorpel+nilaiintegritas+nilaikomitmen+nilaidisiplin+nilaikerjasama+nilaipim);
                var nilairatarata = (jumlah/6);
                var nilaiprestasi = (parseFloat(nilaiskp)*0.6);
                var nilaiperilaku = (parseFloat(nilairatarata)*0.4);
                var nilaikinerja = nilaiprestasi+nilaiperilaku;
            }else{
                var xpr1 = '70%';
                var xpr2 = '30%';
                var jumlah = (nilaiorpel+nilaiintegritas+nilaikomitmen+nilaikerjasama+nilaipim);
                var nilairatarata = (jumlah/5);
                var nilaiprestasi = (parseFloat(nilaiskp)*0.7);
                var nilaiperilaku = (parseFloat(nilairatarata)*0.3);
                var nilaikinerja = nilaiprestasi+nilaiperilaku;
            }
        }else{
            if(jenisppk == 46){
                var xpr1 = '60%';
                var xpr2 = '40%';
                var jumlah = (nilaiorpel+nilaiintegritas+nilaikomitmen+nilaidisiplin+nilaikerjasama);
                var nilairatarata = jumlah/5;
                var nilaiprestasi = (parseFloat(nilaiskp)*0.6);
                var nilaiperilaku = (parseFloat(nilairatarata)*0.4);
                var nilaikinerja = nilaiprestasi+nilaiperilaku;
            }else{
                var xpr1 = '70%';
                var xpr2 = '30%';
                var jumlah = (nilaiorpel+nilaiintegritas+nilaikomitmen+nilaikerjasama);
                var nilairatarata = jumlah/4;
                var nilaiprestasi = (parseFloat(nilaiskp)*0.7);
                var nilaiperilaku = (parseFloat(nilairatarata)*0.3);
                var nilaikinerja = nilaiprestasi+nilaiperilaku;
            }
        }
        //alert(idjenjab+' vs '+nilairatarata+' vs '+(parseFloat(nilaiskp)*0.7)+' vs '+(parseFloat(nilairatarata)*0.3));

        $('#form-rskp2 .rskp-perubahan .xpr1').html(xpr1);
        $('#form-rskp2 .rskp-perubahan .xpr2').html(xpr2);
        if(!isNaN(nilaiprestasi)){ $('#form-rskp2 .rskp-perubahan #nilaiprestasi').val(nilaiprestasi.toFixed(2)); }
        if(!isNaN(jumlah)){ $('#form-rskp2 .rskp-perubahan #jumlah').val(jumlah.toFixed(2)); }
        if(!isNaN(nilairatarata)){ $('#form-rskp2 .rskp-perubahan #nilairatarata').val(nilairatarata.toFixed(2)); }
        if(!isNaN(nilaiperilaku)){ $('#form-rskp2 .rskp-perubahan #nilaiperilaku').val(nilaiperilaku.toFixed(2)); }
        if(!isNaN(nilaikinerja)){ $('#form-rskp2 .rskp-perubahan #nilaikinerja').val(nilaikinerja.toFixed(2)); }
    }
</script>