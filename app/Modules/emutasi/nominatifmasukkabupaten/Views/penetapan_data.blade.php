<section class="content">
    <?php
    $rpos = strrpos(\Request::path(), '/');
    $uri = substr(\Request::path(), 0, $rpos);
    ?>
    <form id="form-penetapan" class="form-horizontal form-penetapan" method="POST" action="{!!url()!!}/emutasi/nominatifmasukkabupaten/verifikasi" accept-charset="UTF-8">
        {!!csrf_field()!!}
        <div class="col-md-6">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI </h3>
            </div>
            <div class="box box-warning">
                <div class="box-body">
                    <div class="col-md-12 data-pribadi">
                        <input type="hidden" name="nousul" id="nousul" value="{!!Input::get('nousul')!!}">
                        <input type="hidden" name="idusul" id="idusul" value="{!!Input::get('idusul')!!}">
                        <div class="form-group">
                            {!! Form::label('nousul', 'Nomor Usulan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <span id="attr-nousul" class="form-control" disabled></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tglusul', 'Tangal Usulan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <span id="attr-tglusul" class="form-control" disabled></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="nip" value="" id="nip" maxlength="18" class="form-control" type="text" placeholder="NIP">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gdp', 'Nama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="gdp" value="" id="gdp" class="form-control" type="text" placeholder="Gelar Depan">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="nama" value="" id="nama" class="form-control" type="text" placeholder="Nama Pegawai">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="gdb" value="" id="gdb" class="form-control" type="text" placeholder="Gelar Belakang">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmlhr', 'Tempat Lahir', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="tmlhr" value="" id="tmlhr" class="form-control" type="text" placeholder="Tempat Lahir">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tglhr', 'Tanggal Lahir', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <div class='input-group datepicker'>
                                    <input name="tglhr" value="" id="tglhr" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboAgama("idagama","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboJenkel("idjenkel","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idstskawin', 'Status Marital:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboStsmaritalmutasi('idstskawin','','idstskawin','','') !!}
                            </div>
                        </div>
                        <div class="form-group stsdujan">
                            {!! Form::label('idstsdujan', 'Status Duda/Janda:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboStsDujan('idstsdujan','','required') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('alm', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('alm', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almrt', 'RT:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::text('almrt', null, array('class'=> 'form-control num', 'placeholder'=> 'RT', 'maxlength'=>3)) !!}
                            </div>
                            <div class="col-sm-2" style="margin-top: 7px;">
                                <b>RW: </b>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::text('almrw', null, array('class'=> 'form-control num', 'id'=>'almrw', 'placeholder'=> 'RW', 'maxlength'=>3)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almdesa', 'Desa/Kelurahan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('almdesa', null, array('class'=> 'form-control', 'placeholder'=> 'Desa/Kelurahan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almkec', 'Kecamatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('almkec', null, array('class'=> 'form-control', 'placeholder'=> 'Kecamatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almkab', 'Kabupaten/Kota:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('almkab', null, array('class'=> 'form-control', 'placeholder'=> 'Kabupaten')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almprov', 'Provinsi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('almprov', null, array('class'=> 'form-control', 'placeholder'=> 'Provinsi')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('almkdpos', 'Kode Pos:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('almkdpos', null, array('class'=> 'form-control', 'placeholder'=> 'Kode Pos', 'maxlength'=>6)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('telp', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('telp', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Telepon')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('hp', 'HP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('hp', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Hp')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> CEKLIST BERKAS </h3>
            </div>
            <div class="box box-warning">
                <div class="box-body">
                    <div class="col-md-12 data-ceklist">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ceklist Berkas</label>
                            <div class="col-sm-7">
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="ispengantar" id="ispengantar" value="1"> Surat Permohonan Pindah dari Prov. Jateng</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="ispermohonan" id="ispermohonan" value="1"> Surat Permohonan YBS </label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskcpns" id="isskcpns" value="1"> SK CPNS</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskpns" id="isskpns" value="1"> SK PNS</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskpkt" id="isskpkt" value="1"> SK Pangkat Terakhir</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="iskarpeg" id="iskarpeg" value="1"> Karpeg</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isdhr" id="isdhr" value="1"> DHR</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isspskpd" id="isspskpd" value="1"> DP/OPD</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isijazah" id="isijazah" value="1"> Ijazah Terakhir</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="issnikah" id="issnikah" value="1"> Surat Nikah (Bagi yang ikut suami)</label>
                                <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="ispernyataan" id="ispernyataan" value="1"> Surat Pernyataan Sanggup Ditempatkan di Wilayah Kab. Kendal</label>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI </h3>
            </div>
            <div class="box box-warning">
                <div class="box-body">
                    <div class="col-md-12 data-pribadi">
                        <div class="form-group">
                            {!! Form::label('idtkpendid', 'Pendidikan Terakhir', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboTkpendidikanmutasi("idtkpendid","","idtkpendid","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenjurusan', 'Jurusan', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <span id="xjur">
                                   <select name="idjenjurusanx" id="idjenjurusanx" class="idjenjurusan form-control" style="width: 100%;">
                                       <option value="">.: Pilihan :.</option>
                                   </select>
                               </span>
                               <span id="xjur1">
                                   <select type="hidden" id="idjenjurusan" class="idjenjurusan form-control" name="idjenjurusan" style="width: 100%">
                                   </select>
                               </span>
                           </div>
                       </div>

                       <div class="form-group">
                        {!! Form::label('thnlulus', 'Tahun Lulus', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            <input name="thnlulus" value="" id="thnlulus" class="form-control" type="text" placeholder="Tahun Lulus">
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idgolrupkt', 'Gol Ruang', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            {!! comboGolru('idgolrupkt','','required') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('jabatanlama', 'Jabatan Lama', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            <input name="jabatanlama" value="" id="jabatanlama" class="form-control" type="text" placeholder="Jabatan Lama">
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('skpdlama', 'OPD Lama', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            <input name="skpdlama" value="" id="skpdlama" class="form-control" type="text" placeholder="SKPD Lama">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> PENEMPATAN PINDAH MASUK </h3>
        </div>
        <div class="box box-warning">
            <div class="box-body">
                <div class="col-md-12 data-mutasi">
                    <div class="form-group">
                        {!! Form::label('idjenjabbaru', 'Jenis Jabatan', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            {!! comboJenjabmutasi("idjenjabbaru","","idjenjabbaru","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('namajabatan', 'Nama Jabatan', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            <span id="xjab">
                                <select name="idjabjbtbarux" id="idjabjbtbarux" class="idjabjbtbaru form-control" style="width: 100%;">
                                    <option value="">.: Pilihan :.</option>
                                </select>
                            </span>
                            <span id="xjab1">
                                <select type="hidden" id="idjabjbtbaru" class="idjabjbtbaru form-control" name="idjabjbtbaru" style="width: 100%">
                                </select>
                            </span>
                            <span id="xjab2">
                                <select type="hidden" id="idjabfungbaru" class="idjabfungbaru form-control" name="idjabfungbaru" style="width: 100%"/>
                            </select>
                        </span>
                        <span id="xjab3">
                            <select type="hidden" id="idjabfungumbaru" class="idjabfungumbaru form-control" name="idjabfungumbaru" style="width: 100%"/>
                        </select>
                    </span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idskpdbaru', 'OPD Baru', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    {!! comboSkpdunit('idskpdbaru','','') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> MUTASI PINDAH MASUK DARI- </h3>
</div>
<div class="box box-warning">
    <div class="box-body">
        <div class="col-md-12 data-mutasi">


            <!-- WORKING AREA -->
            <div class="form-group">
                <label class="col-sm-3 control-label">Kementarian/Lembaga/Daerah (K/L/D)</label>
                <div class="col-sm-8">
                    {!!NominatifmasukkabupatenModel::comboPemerintah("idpemerintah","","")!!}
                </div>
            </div>

            <div id="fpilpem">
                <div class="form-group">
                    {!! Form::label('provinsi', 'Dari Provinsi', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <input name="provinsi" value="" id="provinsi" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('kabupaten', 'Dari Kabupaten / Kota', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <input name="kabupaten" value="" id="kabupaten" class="form-control" type="text">
                </div>
            </div>
            <div id="fpilpemx">
                <div class="form-group">
                    {!! Form::label('instansi', 'Dari Instansi', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <input name="instansi" value="" id="instansi" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('noskpermintaan', 'No Rujukan', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <input name="noskpermintaan" value="" id="noskpermintaan" class="form-control" type="text">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tglskpermintaan', 'Tanggal Rujukan', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <div class='input-group datepicker'>
                       <input name="tglskpermintaan" value="" id="tglskpermintaan" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                       <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class="form-group">
            {!! Form::label('keterangan', 'Keterangan', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input name="keterangan" value="" id="keterangan" class="form-control" type="text">
            </div>
        </div>
    </div>
</div>
</div>
<div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> STATUS PENETAPAN </h3>
</div>
<div class="box box-warning">
    <div class="box-body">
        <div class="col-md-12 data-penetapan">
            <div class="form-group">
                {!! Form::label('statususul', 'Status Berkas', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <select id="statususul" name="statususul" class="input-large form-control" required>
                        <option value="0">.: Status Usulan :.</option>
                        <option value="1">Memenuhi Syarat</option>
                        <option value="2">Tidak Memenuhi Syarat</option>
                        <option value="3">Berkas Tidak Lengkap</option>
                    </select>
                </div>
            </div>
            <div id='ftampil1'>
                <div class="form-group">
                    {!! Form::label('statussk', 'Status Proses', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <select id="statussk" name="statussk" class="input-large form-control" required>
                            <option value="0">.: Status Proses :.</option>
                            <option value="2">Dalam Proses</option>
                            <option value="1">Proses Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id='ftampil2'>
                <div class="form-group">
                    {!! Form::label('kettms', 'Keterangan', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <textarea rows="6" cols="6" name="kettms" id="kettms" class="form-control" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>
                    </div>
                </div>
            </div>
            <div id='ftampil3'>
                <div class="form-group">
                    {!! Form::label('ketbtl', 'Keterangan', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <textarea rows="6" cols="6" name="ketbtl" id="ketbtl" class="form-control" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>
                    </div>
                </div>
            </div>

            <div id='ftampil11'>
                <div class="form-group">
                    {!! Form::label('nosk', 'Nomor Surat Tugas', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <input type="text" value="" name="nosk" id="nosk" class="form-control" placeholder="Nomor Surat Tugas">
                    </div><!-- Persetujuan I -->
                </div>
                <div class="form-group">
                    {!! Form::label('tglsurat', 'Tanggal Surat Tugas', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-8">
                        <div class='input-group datepicker'>
                           <input name="tglsurat" value="" id="tglsurat" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                           <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                {!! Form::label('tmt', 'Tanggal Berlaku', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <div class='input-group datepicker'>
                       <input name="tmt" value="" id="tmt" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                       <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class="head-line">
            <h3>Penetap Bupati</h3> <em style="font-size: 11px"></em>
        </div></br>
        <div class="form-group">
            {!! Form::label('bupati', 'Nama Bupati', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="bupati" id="bupati" class="form-control" placeholder="Nama Bupati">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('jabbupati', 'Jabatan', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="jabbupati" id="jabbupati" class="form-control" placeholder="Jabatan">
            </div>
        </div>
        <div class="head-line">
            <h3>Penetap Kepala BKPP</h3> <em style="font-size: 11px"></em>
        </div></br>
        <div class="form-group">
            {!! Form::label('kepalabkd', 'Kepala BKPP', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="kepalabkd" id="kepalabkd" class="form-control" placeholder="Nama Kepala BKD">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('jabkepalabkd', 'Jabatan', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="jabkepalabkd" id="jabkepalabkd" class="form-control" placeholder="Jabatan">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('nipkepalabkd', 'NIP Kepala BKPP', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="nipkepalabkd" id="nipkepalabkd" class="form-control" placeholder="NIP Kepala BKD">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('pangkatbkd', 'Pangkat Kepala BKPP', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="pangkatbkd" id="pangkatbkd" class="form-control" placeholder="Pangkat Kepala BKD">
            </div>
        </div>
        <div class="head-line">
            <h3>Penetap Sekretaris Daerah</h3> <em style="font-size: 11px"></em>
        </div></br>
        <div class="form-group">
            {!! Form::label('kepalasekda', 'Sekretaris Daerah', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="kepalasekda" id="kepalasekda" class="form-control" placeholder="Sekretaris Daerah">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('jabkepalasekda', 'Jabatan', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="jabkepalasekda" id="jabkepalasekda" class="form-control" placeholder="Jabatan">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('nipsekda', 'NIP', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="nipsekda" id="nipsekda" class="form-control" placeholder="NIP Sekretaris Daerah">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('pangkatsekda', 'Pangkat', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="pangkatsekda" id="pangkatsekda" class="form-control" placeholder="Pangkat Sekretaris Daerah">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('tembusan', 'Tembusan :', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <textarea name="tembusan" class="form-control initembusan" id="initembusanid" cols="5" rows="4"></textarea>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('statussk', 'Status SK', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <label class="radio">
                    <input type="radio" name="iscetaksk" id="iscetaksk0" value="0" checked> Belum Cetak SK
                </label>
                <label class="radio">
                    <input type="radio" name="iscetaksk" id="iscetaksk1" value="1"> Sudah Cetak SK
                </label>
                <label class="radio">
                    <input type="radio" name="iscetaksk" id="iscetaksk2" value="2"> Pembatalan Cetak SK
                </label>
            </div>
        </div>
    </div>

    <div id='ftampil12'>
        <div class="head-line">
            <h3>Surat Persetujuan</h3> <em style="font-size: 11px">(* Kosongkan jika belum diproses.)</em>
        </div></br>
<!--     <div class="form-group">
        {!! Form::label('nosk_persetujuan', 'No Pengantar Persetujuan', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-8">
            <input type="text" value="" name="nosk_persetujuan" id="nosk_persetujuan" class="form-control" placeholder="Nomor SK Pengantar Persetujuan">
        </div>
    </div> -->
    <div class="form-group">
        {!! Form::label('nosk_persetujuan', 'Nomor Surat Persetujuan I', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-8">
            <input type="text" value="" name="nosk_persetujuan" id="nosk_persetujuan" class="form-control" placeholder="Nomor SK Persetujuan I">
        </div><!-- Persetujuan I -->
    </div>
    <div class="form-group">
        {!! Form::label('nosk_persetujuan2', 'Nomor Surat Persetujuan II', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-8">
            <input type="text" value="" name="nosk_persetujuan2" id="nosk_persetujuan2" class="form-control" placeholder="Nomor SK Persetujuan II">
        </div><!-- Surat Persetujuan II -->
    </div>
    <div class="form-group">
        {!! Form::label('tglsk_persetujuan', 'Tanggal Surat Persetujuan', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-8">
            <div class='input-group datepicker'>
               <input name="tglsk_persetujuan" value="" id="tglsk_persetujuan" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
               <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
      </div>
  </div>
  <div class="form-group">
    {!! Form::label('tgl_kajian', 'Tanggal Kajian', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-8">
        <div class='input-group datepicker'>
           <input name="tgl_kajian" value="" id="tgl_kajian" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
           <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
          </span>
      </div>
  </div>
</div>
<div class="head-line">
    <h3>SK Mutasi</h3> <em style="font-size: 11px">(* Kosongkan jika SK belum diproses.)</em>
</div></br>
<div class="form-group">
    {!! Form::label('penetapsk_kanreg', 'Pejabat Penetap SK', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-8">
        <!-- <input type="text" value="" name="penetapsk_kanreg" id="penetapsk_kanreg" class="form-control" placeholder="Ex: Kepala Kanreg i Badan Kepegawaian Negara "> -->
        {!!comboPenMutLuar("penetapsk_kanreg","","")!!}
    </div><!-- Dibuat Menu Pilihan -->
</div>
<div class="form-group">
    {!! Form::label('nosk_kanreg', 'Nomor SK', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-8">
        <input type="text" value="" name="nosk_kanreg" id="nosk_kanreg" class="form-control" placeholder="Nomor SK Kanreg">
    </div>
</div>

<div class="form-group">
    {!! Form::label('tglsk_kanreg', 'Tanggal SK', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-8">
        <div class='input-group datepicker'>
           <input name="tglsk_kanreg" value="" id="tglsk_kanreg" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
           <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
          </span>
      </div>
  </div>
</div>



<!-- <div class="form-group">
    {!! Form::label('tmt_berlaku', 'TMT Berlaku', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-8">
        <div class='input-group datepicker'>
           <input name="tmt_berlaku" value="" id="tmt_berlaku" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
           <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
          </span>
      </div>
  </div>
</div> -->
</div>
</div>
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            {!! ClaravelHelpers::btnSave() !!}
            &nbsp;
            &nbsp;
            <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Batalkan</button>
        </div>
    </div>
</div>
</div>
</div>
</form>
</section>

<script>
    $(document).ready(function() {

        // $('#initembusanid').keypress(function(evt){
        //     $('#initembusanid').html(nl2br($('#initembusanid').val())); 
        //     $('.initembusan').html($('#initembusanid').val()); 
        // });

        delete CKEDITOR.instances[ 'initembusanid' ];
        var config_pengantar = {
            toolbar : 'Basic',
            height: '100'
        };
        $('.initembusan').ckeditor(config_pengantar);

        $('.form-penetapan select').select2();

        $("#form-penetapan .datepicker").datetimepicker({
           format: 'DD-MM-YYYY'
       });
        $("#form-penetapan .date").mask("99-99-9999");

        $('#form-penetapan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                claravel_modal_close('main_modal2');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $.ajax({
            url:'{!!url()!!}/emutasi/nominatifmasukkabupaten/datanominatifmutasi',
            data: { 'idusul': "{!!Input::get('idusul')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);
                $('.data-pribadi #attr-nousul').html(ret.nousul);
                var str1 = ret.tglusul;
                var res1 = str1.split("-");
                $('.data-pribadi #attr-tglusul').html(res1[2]+'-'+res1[1]+'-'+res1[0]);

                $('.data-pribadi #nip').val(ret.nip);
                $('.data-pribadi #gdp').val(ret.gdp);
                $('.data-pribadi #nama').val(ret.nama);
                $('.data-pribadi #gdb').val(ret.gdb);
                $('.data-pribadi #tmlhr').val(ret.tmlhr);

                var str2 = ret.tglhr;
                var res2 = str2.split("-");
                $('.data-pribadi #tglhr').val(res2[2]+'-'+res2[1]+'-'+res2[0]);

                $('.data-pribadi #idstskawin').select2('val',ret.idstskawin);
                $('.data-pribadi #idstsdujan').select2('val',ret.idstsdujan);
                $('.data-pribadi #idagama').select2('val',ret.idagama);
                $('.data-pribadi #idjenkel').select2('val',ret.idjenkel);
                $('.data-pribadi #alm').val(ret.alm);
                $('.data-pribadi #almrt').val(ret.almrt);
                $('.data-pribadi #almrw').val(ret.almrw);
                $('.data-pribadi #almdesa').val(ret.almdesa);
                $('.data-pribadi #almkec').val(ret.almkec);
                $('.data-pribadi #almkab').val(ret.almkab);
                $('.data-pribadi #almprov').val(ret.almprov);
                $('.data-pribadi #almkdpos').val(ret.almkdpos);
                $('.data-pribadi #telp').val(ret.telp);
                $('.data-pribadi #hp').val(ret.hp);

                $('.data-pribadi #idtkpendid').select2('val',ret.idtkpendid);
                $('.data-pribadi #idjenjurusan').select2('val',ret.idjenjurusan);
                $('.data-pribadi #thnlulus').val(ret.thnlulus);
                $('.data-pribadi #idgolrupkt').select2('val',ret.idgolrupkt);
                $('.data-pribadi #jabatanlama').val(ret.jabatanlama);
                $('.data-pribadi #skpdlama').val(ret.skpdlama);

                $('.data-mutasi #idjenjabbaru').select2('val',ret.idjenjabbaru);
                $('.data-mutasi #idskpdbaru').select2('val',ret.idskpdbaru);
                $('.data-mutasi #provinsi').val(ret.provinsi);
                $('.data-mutasi #kabupaten').val(ret.kabupaten);
                $('.data-mutasi #instansi').val(ret.instansi);
                $('.data-mutasi #noskpermintaan').val(ret.noskpermintaan);

                $('.data-mutasi #idpemerintah').select2('val',ret.idpemerintah);
                $('.data-mutasi #idpemerintah').trigger('change');

                var str3 = ret.tglskpermintaan;
                var res3 = str3.split("-");
                $('.data-mutasi #tglskpermintaan').val(res3[2]+'-'+res3[1]+'-'+res3[0]);

                $('.data-mutasi #keterangan').val(ret.keterangan);

                $('.data-pribadi #idstskawin').trigger('change');
                $('.data-pribadi #idjenjurusan').trigger('change');
                $('.data-mutasi #idjenjabbaru').trigger('change');

                if(ret.idjenjabbaru == 2){
                    autoComplete(".data-mutasi #idjabfungbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfung2', 'Jabatan Fungsional ..', null, ret.idjabfungbaru, ret.jabatan);
                }
                else if(ret.idjenjabbaru == 3){
                    autoComplete(".data-mutasi #idjabfungumbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfungum2', 'Jabatan Fungsional Umum..', null, ret.idjabfungumbaru, ret.jabatan);
                }
                else if(ret.idjenjabbaru >= 20){
                    autoComplete(".data-mutasi #idjabjbtbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabstruk2', 'Jabatan Struktural ..', null, ret.idjabjbtbaru, ret.jabatan);
                }

                if(ret.idjenjurusan != ''){
                    autoComplete(".data-pribadi #idjenjurusan", '{{url()}}/emutasi/nominatifmasukkabupaten/jenjurusan', 'Jurusan Pendidikan ..', null, ret.idjenjurusan, ret.jenjurusan);
                }

                $('.data-ceklist #ispengantar').attr('checked',((ret.ispengantar==1)?true:false));
                $('.data-ceklist #ispermohonan').attr('checked',((ret.ispermohonan==1)?true:false));
                $('.data-ceklist #isskcpns').attr('checked',((ret.isskcpns==1)?true:false));
                $('.data-ceklist #isskpns').attr('checked',((ret.isskpns==1)?true:false));
                $('.data-ceklist #isskpkt').attr('checked',((ret.isskpkt==1)?true:false));
                $('.data-ceklist #iskarpeg').attr('checked',((ret.iskarpeg==1)?true:false));
                $('.data-ceklist #isdhr').attr('checked',((ret.isdhr==1)?true:false));
                $('.data-ceklist #isspskpd').attr('checked',((ret.isspskpd==1)?true:false));
                $('.data-ceklist #isijazah').attr('checked',((ret.isijazah==1)?true:false));
                $('.data-ceklist #issnikah').attr('checked',((ret.issnikah==1)?true:false));
                $('.data-ceklist #ispernyataan').attr('checked',((ret.ispernyataan==1)?true:false));

                $('.data-penetapan #statususul').select2('val',ret.statususul);
                $('.data-penetapan #statususul').trigger('change');

                $('.data-penetapan #statussk').select2('val',ret.statussk);
                $('.data-penetapan #statussk').trigger('change');

                $('.data-penetapan #kettms').val(ret.kettms);
                $('.data-penetapan #ketbtl').val(ret.ketbtl);

                $('.data-penetapan #nosk').val(ret.nosk);
                $('.data-penetapan #nosk2').val(ret.nosk2);

                var str4 = ret.tglsurat;
                var res4 = str4.split("-");
                $('.data-penetapan #tglsurat').val(res4[2]+'-'+res4[1]+'-'+res4[0]);

                var str5 = ret.tmt;
                var res5 = str5.split("-");
                $('.data-penetapan #tmt').val(res5[2]+'-'+res5[1]+'-'+res5[0]);
                $('.data-penetapan input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);

                $('.data-penetapan #kepalabkd').val(ret.kepalabkd);
                $('.data-penetapan #jabkepalabkd').val(ret.jabkepalabkd);
                $('.data-penetapan #nipkepalabkd').val(ret.nipkepalabkd);
                $('.data-penetapan #pangkatbkd').val(ret.pangkatbkd);
                $('.data-penetapan #bupati').val(ret.bupati);
                $('.data-penetapan #jabbupati').val(ret.jabbupati);
                $('.data-penetapan #kepalasekda').val(ret.kepalasekda);
                $('.data-penetapan #jabkepalasekda').val(ret.jabkepalasekda);
                $('.data-penetapan #nipsekda').val(ret.nipsekda);
                $('.data-penetapan #pangkatsekda').val(ret.pangkatsekda);

                $('.data-penetapan #pengantar_persetujuan').val(ret.pengantar_persetujuan);
                $('.data-penetapan #nosk_persetujuan').val(ret.nosk_persetujuan);
                $('.data-penetapan #nosk_persetujuan2').val(ret.nosk_persetujuan2);
                var str6 = ret.tglsk_persetujuan;
                var res6 = str6.split("-");
                $('.data-penetapan #tglsk_persetujuan').val(res6[2]+'-'+res6[1]+'-'+res6[0]);

                $('.data-penetapan #nosk_pengantar').val(ret.nosk_pengantar);
                var str7 = ret.tglsk_pengantar;
                var res7 = str7.split("-");
                $('.data-penetapan #tglsk_pengantar').val(res7[2]+'-'+res7[1]+'-'+res7[0]);

                // $('.data-penetapan #penetapsk_kanreg').val(ret.penetapsk_kanreg);
                $('.data-penetapan #penetapsk_kanreg').select2('val',ret.penetapsk_kanreg);
                $('.data-penetapan #nosk_kanreg').val(ret.nosk_kanreg);
                var str8 = ret.tglsk_kanreg;
                var res8 = str8.split("-");
                $('.data-penetapan #tglsk_kanreg').val(res8[2]+'-'+res8[1]+'-'+res8[0]);

                var str9 = ret.tgl_kajian;
                var res9 = str9.split("-");
                $('.data-penetapan #tgl_kajian').val(res9[2]+'-'+res9[1]+'-'+res9[0]);

                $('.data-penetapan #initembusanid').val(ret.tembusan);

            }
        });

$('.data-pribadi .stsdujan').hide();
$('.data-pribadi #xjur1').hide();
$('.data-mutasi #xjab1').hide();
$('.data-mutasi #xjab2').hide();
$('.data-mutasi #xjab3').hide();
$('.data-mutasi #idjenjabbaru').change(function(e){
    e.preventDefault();
    var idjenjab = $('.data-mutasi #idjenjabbaru').val();

    if(idjenjab == 1){
        $(".data-mutasi #xjab").hide();
        $(".data-mutasi #xjab1").show();
        $(".data-mutasi #xjab2").hide();
        $(".data-mutasi #xjab3").hide();
    }else if(idjenjab == 2){
        $(".data-mutasi #xjab").hide();
        $(".data-mutasi #xjab1").hide();
        $(".data-mutasi #xjab2").show();
        $(".data-mutasi #xjab3").hide();
    }else if(idjenjab == 3){
        $(".data-mutasi #xjab").hide();
        $(".data-mutasi #xjab1").hide();
        $(".data-mutasi #xjab2").hide();
        $(".data-mutasi #xjab3").show();
    }else{
        $(".data-mutasi #xjab").show();
        $(".data-mutasi #xjab1").hide();
        $(".data-mutasi #xjab2").hide();
        $(".data-mutasi #xjab3").hide();
    }
}).trigger('change');

autoComplete(".data-mutasi #idjabfungbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfung2', 'Jabatan Fungsional ..', null, '', '');
autoComplete(".data-mutasi #idjabfungumbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfungum2', 'Jabatan Fungsional Umum..', null, '', '');
autoComplete(".data-mutasi #idjabjbtbaru", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabstruk2', 'Jabatan Struktural ..', null, '', '');

$('.data-pribadi #idtkpendid').change(function(e){
    e.preventDefault();
    var tkpendid = $('.data-pribadi #idtkpendid').val();

    if(tkpendid != ''){
        $(".data-pribadi #xjur").hide();
        $(".data-pribadi #xjur1").show();
    }else{
        $(".data-pribadi #xjur").show();
        $(".data-pribadi #xjur1").hide();
    }

    autoComplete("#idjenjurusan", '{{url()}}/emutasi/nominatifmasukkabupaten/jenjurusan?idtkpendid=' + tkpendid, 'Jurusan Pendidikan ..', null, '', '');

}).trigger('change');

$('.data-pribadi #idstskawin').on('change', function(e){
   e.preventDefault();
   var kawin = $('.data-pribadi #idstskawin').val();

   if(kawin == 2){
    $('.stsdujan').show();
}else{
    $('.stsdujan').hide();

}
}).trigger('change');

$('.data-penetapan #ftampil1').hide();
$('.data-penetapan #ftampil2').hide();
$('.data-penetapan #ftampil3').hide();
$('.data-penetapan #ftampil11').hide();

$('.data-penetapan #statususul').change(function(){
    if($('.data-penetapan #statususul').val() == 1){
        $('.data-penetapan #ftampil1').show();
        $('.data-penetapan #ftampil2').hide();
        $('.data-penetapan #ftampil3').hide();

        $('.data-penetapan #statussk').change(function(){
            if($('.data-penetapan #statussk').val() == 1){
                $('.data-penetapan #ftampil11').show();
                $('.data-penetapan #ftampil12').hide();
            }else if($('.data-penetapan #statussk').val() == 2){
                $('.data-penetapan #ftampil11').hide();
                $('.data-penetapan #ftampil12').show();
            }else{
                $('.data-penetapan #ftampil11').hide();
                $('.data-penetapan #ftampil12').hide();
            }
        }).trigger('change');
    }else if($('.data-penetapan #statususul').val() == 2){
        $('.data-penetapan #ftampil1').hide();
        $('.data-penetapan #ftampil2').show();
        $('.data-penetapan #ftampil3').hide();
        $('.data-penetapan #ftampil11').hide();
        $('.data-penetapan #ftampil12').hide();
    }else if($('.data-penetapan #statususul').val() == 3){
        $('.data-penetapan #ftampil1').hide();
        $('.data-penetapan #ftampil2').hide();
        $('.data-penetapan #ftampil3').show();
        $('.data-penetapan #ftampil11').hide();
        $('.data-penetapan #ftampil12').hide();
    }else{
        $('.data-penetapan #ftampil1').hide();
        $('.data-penetapan #ftampil2').hide();
        $('.data-penetapan #ftampil3').hide();
        $('.data-penetapan #ftampil11').hide();
        $('.data-penetapan #ftampil12').hide();
    }
}).trigger('change');

$('.data-mutasi #fpilpem').hide();
$('.data-mutasi #fpilpemx').hide();

$('.data-mutasi #idpemerintah').change(function(){
    var jos = $('.data-mutasi #idpemerintah').val();
    if(jos == 1 ||  jos == 2 || jos == 3){
        $('.data-mutasi #fpilpem').show();
        $('.data-mutasi #fpilpemx').hide();
    }else{
        $('.data-mutasi #fpilpem').hide();
        $('.data-mutasi #fpilpemx').show();
    }
}).trigger('change');

});
function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

</script>
