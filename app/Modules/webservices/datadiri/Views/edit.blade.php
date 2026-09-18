<?php
if (session('role_id') <= 3) {
    $alert = "Simpan data ?";
} else {
    $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Update Biodata ?</li></ul>";
}
?>

<section class="content-header">
    <h1>
        Data Diri<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Biodata</a></li>
        <li class="active">Data Diri</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row" >
        <div class="col-md-12">
          <div class="callout callout-success">
              <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
              <ul style="padding-left: 15px">
                  <!-- <li>Isiakan tanggal usulan</li> -->
                  <li>Sebalah kiri merupakan data diri dari simpeg kendal</li>

                  <li>Sebalah kanan merupakan data diri dari bkn</li>
                  <li>Klik tombol Sinkron Data untuk meng update data diri simpeg kendal, data diri simpeg kendal akan terupdate  sesuai dengan form data diri bkn </li>
              </ul>
          </div>
            <div class="box-header with-border">
                {{-- <span class="pull-left"><h3 class="box-title">BIODATA PEGAWAI</h3></span> --}}
                <span class="pull-right"><span id="skpdunit"></span></span>
            </div>

            {!! Form::open(array('url' => url().'/webservices/datadiri/save','method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            {!! Form::hidden('id', null, array('id'=>'id')) !!}
            {!! Form::hidden('nip', \Input::get('id'), array('id'=>'nip')) !!}

            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-primary awal" type="submit"><i class="fa fa-floppy-o"></i> Sinkron Data</button>
                    &nbsp;
                    &nbsp;
                    @if(session('role_id') == 5)
                    <a class="btn btn-warning" href="{!!url()!!}/dashboard"><i class="fa fa-times-circle-o"></i> Batalkan</a>
                    @else
                    <a class="btn btn-warning awal" href="{!!url()!!}/epersonal/biodata" id="batalkan"><i class="fa fa-times-circle-o"></i> Batalkan</a>
                    @endif
                </div>
            </div>


            <div class="box-body">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="box-header with-border">
                            <span class="pull-left"><h3 class="box-title">Data Diri Simpeg Kendal</h3></span>
                            <span class="pull-right"><span id="skpdunit"></span></span>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Nip:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('idagama', $biodata->nip, array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Nama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('idagama', $biodata->nama, array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Gdp:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('idagama', $biodata->gdp, array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Gdb:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('idagama', $biodata->gdb, array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                          <div class="form-group">
                              {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('idagama', getTextAgama($biodata->idagama), array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                                  {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('idagama', getTextJenkel($biodata->idjenkel), array('id'=>'idagama','class'=> 'form-control', 'placeholder'=> 'Jenis Kelamin', 'disabled'=>'disabled')) !!}

                              </div>
                          </div>
                          <div class="form-group stskawin">
                              {!! Form::label('idstskawin', 'Status Marital :', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                {!! Form::text('', getTextStatusKawin($biodata->idstskawin), array('class'=> 'form-control', 'placeholder'=> 'Status Maritial', 'disabled'=>'disabled')) !!}

                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('alm', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->alm, array('id'=>'alm','class'=> 'form-control', 'placeholder'=> 'Alamat', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>



                          <div class="form-group">
                              {!! Form::label('almkdpos', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('',  $biodata->almkdpos, array('id'=>'almkdpos','class'=> 'form-control', 'placeholder'=> 'Kode Pos', 'maxlength'=>6, 'disabled'=>'disabled')) !!}
                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('telp', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->telp, array('id'=>'telp','class'=> 'form-control', 'placeholder'=> 'Telepon', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('hp', 'HP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->hp, array('id'=>'hp','class'=> 'form-control', 'placeholder'=> 'Handphone', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('email', 'E-Mail:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->email, array('id'=>'email','class'=> 'form-control', 'placeholder'=> 'E-Mail', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('nokarpeg', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->nokarpeg, array('id'=>'nokarpeg','class'=> 'form-control', 'placeholder'=> 'No. Karpeg/KPE', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('noaskes', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->noaskes, array('id'=>'noaskes','class'=> 'form-control', 'placeholder'=> 'No. Askes', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('notaspen', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->notaspen, array('id'=>'notaspen','class'=> 'form-control', 'placeholder'=> 'Taspen', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('nonpwp', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->nonpwp, array('id'=>'nonpwp','class'=> 'form-control', 'placeholder'=> 'NPWP', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('noktp', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('', $biodata->noktp, array('id'=>'noktp','class'=> 'form-control', 'placeholder'=> 'No. KTP', 'disabled'=>'disabled')) !!}
                              </div>
                          </div>

                      </div>
                      <div class="col-md-6">
                        <div class="box-header with-border">
                            <span class="pull-left"><h3 class="box-title">Data Diri BKN</h3></span>
                            <span class="pull-right"><span id="skpdunit"></span></span>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Nip:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">

                                  <input type="text" value="{!!$bkn["nipBaru"]!!}"  name="nip" readonly class="form-control">

                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Nama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                  <input type="text" value="{!!$bkn["nama"]!!}"  name="nama" readonly class="form-control">
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idagama', 'Gdp:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                  <input type="text" value="{!!$bkn["gelarDepan"]!!}"  name="gdp" readonly class="form-control">
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('idagama', 'Gdb:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                  <input type="text" value="{!!$bkn["gelarBelakang"]!!}"  name="gdp" readonly class="form-control">
                                {{-- {!! comboAgama2("idagama","idagama[0]","") !!} --}}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">

                                <input type="text" value="{!!$bkn["agama"]!!}"  name="idagama" id='agama' readonly class="form-control border border-warning">

                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <input type="text" value="{!!$bkn["jenisKelamin"]!!}"  name="idjenkel" id="jenkel" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group stskawin">
                            {!! Form::label('', 'Status Marital :', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                    <input type="text" value="{!!$bkn["statusPerkawinan"]!!}" name="idstskawin" id="maritial" readonly class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <input type="text" value="{!!$bkn["alamat"]!!}" name="alm" id="alamat" readonly class="form-control">
                            </div>
                        </div>



                        <div class="form-group">
                            {!! Form::label('', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                              <input type="text" value="{{$bkn["kodePos"]}}" name="almkdpos" id="kodePos" readonly class="form-control">
                            </div>
                        </div>
                          <div class="form-group">
                              {!! Form::label('', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                <input type="text" value="{{$bkn["noTelp"]}}" name="telp" id="noTelp" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'HP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                <input type="text" value="{{$bkn["noHp"]}}" name="hp" id="noHp" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'E-Mail:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  <input type="text" value="{{$bkn["email"]}}"  name="email" id="emailbkn" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  <input type="text" value="{{$bkn["noSeriKarpeg"]}}" name="nokarpeg" id="karpeg" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                    <input type="text" value="{{$bkn["noAskes"]}}" name="noaskes" id="askes" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                    <input type="text" value="{{$bkn["noTaspen"]}}" name="notaspen" id="taspen" readonly class="form-control">
                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  <input type="text" value="{{$bkn["noNpwp"]}}" name="nonpwp" id="npwp" readonly class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  <input type="text" value="{{$bkn["nik"]}}"  name="noktp" id="nik" readonly class="form-control">
                              </div>
                          </div>
                      </div>



              </div>

            </div>
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
    function refresh_page(){
        <?php
$index_page = explode('/', \Request::path());
$jum = count($index_page) - 1;
unset($index_page[$jum]);
$index = join('/', $index_page);
echo 'var index_page=laravel_base + "/' . $index . '";';
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
        var indextab = 0;

        $('#simpan select').select2();
        $('.stsdujan').hide();
        $('#simpan #changeimage').fadeOut();
        $('#simpan #changeimage, #simpan .xjabstruk, #simpan .xjabfung, #simpan .xisguru, #simpan .xisdokter, #simpan .alert-biodata, #simpan .alert-jenkedudupeg').fadeOut();
        $('#simpan .div-disabled').css('pointer-events','none');
        $('#simpan .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color','#ececec');
        $('#simpan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });




        // loadBiodata2();

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#simpan').on('submit',function(e){

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
                                refresh_page();
                                // loadBiodata2();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        //  $("#idstskawin").change(function(){
        //     var kawin = $('#idstskawin').val();
        //     if(kawin == 2){
        //         $('.stsdujan').show();
        //     }else{
        //         $('#idstsdujan').select2('val','');
        //         $('.stsdujan').hide();
        //
        //     }
        // }).trigger('change');
    });


    function changeBorderToDanger(){
      let agama = $("#idagama").val();
      let maritial = $("#idstskawin").select2('data');
      let maritialbkn = $("#maritial");
      let agamabkn = $("#agama");
      let jenkel = $("input[name='idjenkel']:checked").parent().text().trim();
      let jenkelbkn = $("#jenkel");
      let alamat = $("#alm");
      let alamatbkn = $("#alamat");
      let kodePos = $("#almkdpos");
      let kodePosbkn = $("#kodePos");
      let telp = $("#telp");
      let telpbkn = $("#noTelp");
      let hp =$("#hp");
      let hpbkn =$("#noHp");
      let email = $("#email");
      let emailbkn = $("#emailbkn");
      let karpeg = $("#noKarpeg");
      let karpegbkn = $("#karpeg");
      let askes = $("#noaskes");
      let askesbkn = $("#askes");
      let taspen = $("#notaspen");
      let taspenbkn = $("#taspen");
      let npwp = $("#nonpwp");
      let npwpbkn = $("#npwp");
      let nik = $("#noktp");
      let nikbkn = $("#nik")

      if(agama[0].text.trim() !== agamabkn.val()){
            $("#agama").css("border-color", "red");
      }
      if(jenkel !== jenkelbkn.val()){
        jenkelbkn.css("border-color", "red");
      }

      if(maritial[0].text.trim() !== maritialbkn.val()){
            maritialbkn.css("border-color", "red");
      }
      if(alamat.val() !== alamatbkn.val()){
            alamatbkn.css("border-color", "red");
      }

      if(kodePos.val() !== kodePosbkn.val()){
             kodePosbkn.css("border-color", "red");
      }
      if(telp.val() !== telpbkn.val()){
            telpbkn.css("border-color", "red");
      }
      if(hp.val() !== hpbkn.val()){
            hpbkn.css("border-color", "red");
      }
      if(email.val() !== emailbkn.val()){
            emailbkn.css("border-color", "red");
      }
      if(karpeg.val() !== karpegbkn.val()){
            karpegbkn.css("border-color", "red");
      }
      if(askes.val() !== askesbkn.val()){
            askesbkn.css("border-color", "red");
      }
      if(taspen.val() !== taspenbkn.val()){
            taspenbkn.css("border-color", "red");
      }
      if(npwp.val() !== npwpbkn.val()){
            npwpbkn.css("border-color", "red");
      }

      if(nik.val() !== nikbkn.val()){
            nikbkn.css("border-color", "red");
      }

    }

</script>
