<div id="biodata" class="tab-pane active">
    <p>
    <div class="box-header with-border">

        <b class="box-title col-sm-6"><small>BIODATA PRIBADI SIMPEG</small></b>
          <b class="box-title col-sm-6"><small>BIODATA PRIBADI BKN</small></b>

    </div>
    </p>
    <div class="row">
        <div class="col-md-6">
          {!! Form::open(array('url' => url()."/apibkn/biodata", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan-biodata')) !!}
          {!! Form::hidden('id', null, array('id'=>'id')) !!}
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
                {!! Form::label('email', 'E-Mail:', array('class' => 'col-sm-3 control-label')) !!}
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
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">

                  <input type="text" value="{!!$bkn["agama"]!!}"  id='agama' readonly class="form-control border border-warning">

              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                  <input type="text" value="{!!$bkn["jenisKelamin"]!!}"  id="jenkel" readonly class="form-control">
              </div>
          </div>
          <div class="form-group stskawin">
              {!! Form::label('', 'Status Marital :', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                      <input type="text" value="{!!$bkn["statusPerkawinan"]!!}" id="maritial" readonly class="form-control">
              </div>
          </div>
          <!-- <div class="form-group stsdujan">
              {!! Form::label('', 'Golongan Darah:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                    <input type="text" value="tidak tersedia"  readonly class="form-control">
              </div>
          </div> -->
          <div class="form-group">
              {!! Form::label('', 'Golongan Darah:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                    <input type="text" value="tidak tersedia" style="border-color:red;" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                  <input type="text" value="{!!$bkn["alamat"]!!}" id="alamat" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'RT:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-3">

                  <input type="text" value="tidak tersedia" style="border-color:red;" readonly class="form-control">
              </div>
              <div class="col-sm-1" style="margin-top: 7px;">
                  <b>RW: </b>
              </div>
              <div class="col-sm-3">
                  <input type="text" value="tidak tersedia"  style="border-color:red;" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Desa/Kelurahan:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                <input type="text" value="tidak tersedia" style="border-color:red;" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Kecamatan:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                  <input type="text" value="tidak tersedia" style="border-color:red;"  readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Kabupaten/Kota:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                    <input type="text" value="tidak tersedia"  style="border-color:red;" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Provinsi:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                    <input type="text" value="tidak tersedia" style="border-color:red;" readonly class="form-control">
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
              <div class="col-sm-7">
                <input type="text" value="{{$bkn["kodePos"]}}"  id="kodePos" readonly class="form-control">
              </div>
          </div>
            <div class="form-group">
                {!! Form::label('', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                  <input type="text" value="{{$bkn["noTelp"]}}" id="noTelp" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'HP:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                  <input type="text" value="{{$bkn["noHp"]}}" id="noHp" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'E-Mail:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <input type="text" value="{{$bkn["email"]}}"  id="emailbkn" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <input type="text" value="{{$bkn["noSeriKarpeg"]}}" id="karpeg" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                      <input type="text" value="{{$bkn["noAskes"]}}" id="askes" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                      <input type="text" value="{{$bkn["noTaspen"]}}" id="taspen" readonly class="form-control">
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('', 'No. Karis/Karsu:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <input type="text" value="tidak tersedia" style="border-color:red;" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <input type="text" value="{{$bkn["noNpwp"]}}" id="npwp" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <input type="text" value="{{$bkn["nik"]}}"  id="nik" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', 'Bapertarum:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                      <input type="text" value="tidak tersedia"  style="border-color:red;" readonly class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">simpan</button>
            {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#simpan-biodata').on('submit',function(e){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm('{!!$alert!!}',function(a){
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
                        if(html=='4'){
                            notification('Berhasil Disimpan','success');
                            /*refresh_page();*/
                            loadBiodata2();
                        }else{
                            notification(html,'danger');
                        }
                    }
                });
            }
        });
    });
  })
</script>
