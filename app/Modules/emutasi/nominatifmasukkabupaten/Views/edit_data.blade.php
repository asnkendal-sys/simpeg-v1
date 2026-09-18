<section class="content">
    <?php
      $rpos = strrpos(\Request::path(), '/');
      $uri = substr(\Request::path(), 0, $rpos);
    ?>
    <form id="form-edit" class="form-horizontal  form-edit" method="POST" action="{!!url()!!}/emutasi/nominatifmasukkabupaten/edit" accept-charset="UTF-8">
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
                                <span id="attr-nousul"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tglusul', 'Tangal Usulan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <span id="attr-tglusul"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="nip" value="" id="nip" maxlength="18" class="form-control" type="text" placeholder="NIP">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gdp', 'Gdp:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="gdp" value="" id="gdp" class="form-control" type="text" placeholder="Gelar Depan">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="nama" value="" id="nama" class="form-control" type="text" placeholder="Nama Pegawai">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gdb', '', array('class' => 'col-sm-3 control-label')) !!}
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
                            {!! Form::label('skpdlama', 'SKPD Lama', array('class' => 'col-sm-3 control-label')) !!}
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
                            {!! Form::label('idskpdbaru', 'SKPD Baru', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                {!! comboSkpdunit('idskpdbaru','','required') !!}
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
                        <div class="form-group">
                            {!! Form::label('provinsi', 'Dari Provinsi', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="provinsi" value="" id="provinsi" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kabupaten', 'Dari Kabupaten', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="kabupaten" value="" id="kabupaten" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('instansi', 'Dari Instansi', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-8">
                                <input name="instansi" value="" id="instansi" class="form-control" type="text">
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
        $('.form-edit select').select2();

        $("#form-edit .datepicker").datetimepicker({
           format: 'DD-MM-YYYY'
        });
        $("#form-edit .date").mask("99-99-9999");

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update data?',function(a){
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
    });

</script>
