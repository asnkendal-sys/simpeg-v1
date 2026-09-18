<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverskp", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rskp')) !!}
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
                    </div>
                    <hr><b class="box-title"><i class="fa fa-fw fa-child"></i> SASARAN KINERJA PEGAWAI</b><hr>
                    <div class="form-group">
                        {!! Form::label('jen_aturan_kinerja', 'Jenis Peraturan Kinerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <select id="jen_aturan_kinerja" name="jen_aturan_kinerja" class="form-control">
                                <option value="">.: Pilihan :.</option>
                                <option value="46">PP46</option>
                                <option value="30">PP30</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('nilai', 'Nilai SKP:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! Form::text('nilai', null, array('class'=> 'form-control num score', 'placeholder'=>'00.00', 'maxlength'=> 6)) !!}
                            <br><em>(Isian Nilai 00.00 sd 100.00)</em>
                        </div>
                        <div class="col-sm-2" id="hitungSkp">    
                        </div>
                        <div class="col-sm-2" id="hasilSkp"></div>
                    </div>
                    <hr><b class="box-title"><i class="fa fa-fw fa-child"></i> PERILAKU KERJA</b><hr>
                    <div class="form-group">
                        {!! Form::label('orpel', 'Orpel:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('orpel', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('komitmen', 'Komitmen:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('komitmen', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('kerjasama', 'Kerjasama:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('kerjasama', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group integritas">
                        {!! Form::label('integritas', 'Integritas:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('integritas', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group disiplin">
                        {!! Form::label('disiplin', 'Disiplin:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('disiplin', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group instansiKerja">
                        {!! Form::label('instansiKerja', 'Instansi Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('instansiKerja', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group kepemimpinan">
                        {!! Form::label('pim', 'Kepemimpinan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('pim', null, array('class'=> 'form-control num score', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nilaiperilaku', 'Nilai Perilaku Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! Form::text('nilaiperilaku', null, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            <br><em>(Nilai rata-rata)</em>
                        </div>
                        <div class="col-sm-2" id="hitungRata">
                        </div>
                        <div class="col-sm-2" id="hasilRata"></div>
                    </div>
                    <hr>
                    <div class="form-group">
                        {!! Form::label('nilaiprestasi', 'Nilai Prestasi Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('nilaiprestasi', null, array('class'=> 'form-control num', 'placeholder'=>'1 sd 100', 'maxlength'=> 6)) !!}
                            <br><div id="hitungTotal"></div>
                            <br>
                        </div>
                    </div>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> PEJABAT PENILAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nippenilai', 'NIP Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nippenilai" class="form-control nippenilai" id="nippenilai" style="width: 100%" ></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejpenilai', 'Nama Lengkap:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejpenilai', '', array('class'=> 'form-control', 'id' => 'pejpenilai', 'placeholder'=> 'Nama Lengkap')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idgolpenilai', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idgolpenilai', '', array('class'=> 'form-control', 'id'=> 'idgolpenilai')) !!}
                                {!! Form::text('golpenilai', '', array('class'=> 'form-control', 'id'=> 'golpenilai', 'placeholder'=> 'Gol. Ruang')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabpenilai', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idjenjabpenilai', '', array('class'=> 'form-control', 'id'=> 'idjenjabpenilai')) !!}
                                {!! Form::hidden('idjabpenilai', '', array('class'=> 'form-control', 'id'=> 'idjabpenilai')) !!}
                                {!! Form::text('jabpenilai', '', array('class'=> 'form-control', 'id'=> 'jabpenilai', 'placeholder'=> 'Jabatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpdpenilai', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idskpdpenilai', '', array('class'=> 'form-control', 'id'=> 'idskpdpenilai')) !!}
                                {!! Form::text('skpdpenilai', '', array('class'=> 'form-control', 'id'=> 'skpdpenilai', 'placeholder'=> 'Unit Kerja')) !!}
                            </div>
                        </div>

                        <hr>

                        <b class="box-title"><i class="fa fa-fw fa-child"></i> ATASAN PEJABAT PENILAI</b><hr>
                        <div class="form-group">
                            {!! Form::label('nipatasan', 'NIP Atasan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nipatasan" class="form-control nipatasan" id="nipatasan" style="width: 100%" ></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejatasan', 'Nama Lengkap:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejatasan', '', array('class'=> 'form-control', 'id' => 'pejatasan', 'placeholder'=> 'Nama Lengkap')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idgolatasan', 'Gol. Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idgolatasan', '', array('class'=> 'form-control', 'id'=> 'idgolatasan')) !!}
                                {!! Form::text('golatasan', '', array('class'=> 'form-control', 'id'=> 'golatasan', 'placeholder'=> 'Gol. Ruang')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabatasan', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idjenjabatasan', '', array('class'=> 'form-control', 'id'=> 'idjenjabatasan')) !!}
                                {!! Form::hidden('idjabatasan', '', array('class'=> 'form-control', 'id'=> 'idjabatasan')) !!}
                                {!! Form::text('jabatasan', '', array('class'=> 'form-control', 'id'=> 'jabatasan', 'placeholder'=> 'Jabatan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpdatasan', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::hidden('idskpdatasan', '', array('class'=> 'form-control', 'id'=> 'idskpdatasan')) !!}
                                {!! Form::text('skpdatasan', '', array('class'=> 'form-control', 'id'=> 'skpdatasan', 'placeholder'=> 'Unit Kerja')) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> Batalkan</button>
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
    $(document).ready(function(){
        $('#jen_aturan_kinerja').on('change',function(e){
            if($('#jen_aturan_kinerja').val() == 46){
                $('#form-rskp #hitungSkp').html('X 60% = ');
                $('#form-rskp #hitungRata').html('X 40% = ');
                $('#form-rskp #hitungTotal').html('<em>(60% dari Nilai SKP) + (40% dari Nilai rata-rata)</em>');

                $('#form-rskp .integritas').show();
                $('#form-rskp .disiplin').show();

                $('#form-rskp #instansiKerja').val('');
                $('#form-rskp .instansiKerja').hide();
            }else if($('#jen_aturan_kinerja').val() == 30){
                $('#form-rskp #hitungSkp').html('X 70% = ');
                $('#form-rskp #hitungRata').html('X 30% =');
                $('#form-rskp #hitungTotal').html('<em>(70% dari Nilai SKP) + (30% dari Nilai rata-rata)</em>');

                $('#form-rskp #integritas').val('');
                $('#form-rskp .integritas').hide();

                $('#form-rskp #disiplin').val('');
                $('#form-rskp .disiplin').hide();

                $('#form-rskp .instansiKerja').show();
            }

            var idjenjab = $('#form-rskp input[type=radio][name=idjenjab]:checked').val();
            var jen_aturan_kinerja = $('#form-rskp #jen_aturan_kinerja').val();
            getScore(idjenjab, jen_aturan_kinerja);
        }).trigger('change');

        <?php if(Input::get("flag") != 2){ ?>
		$('#form-rskp #nippenilai').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp #nippenilai').val();
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
                        $('#form-rskp #nippenilai').val(ret.nip);
                        $('#form-rskp #pejpenilai').val(ret.namalengkap);
                        $('#form-rskp #idjenjabpenilai').val(ret.idjenjab);
                        $('#form-rskp #idjabpenilai').val(ret.idjab);
                        $('#form-rskp #jabpenilai').val(ret.jab);
                        $('#form-rskp #idgolpenilai').val(ret.idgolru);
                        $('#form-rskp #golpenilai').val(ret.golru);
                        $('#form-rskp #idskpdpenilai').val(ret.idskpd);
                        $('#form-rskp #skpdpenilai').val(ret.skpd);
                    }
                }
            });
        });
		

        $('#form-rskp #nipatasan').on('change', function(e){
            e.preventDefault();

            var nip = $('#form-rskp #nipatasan').val();
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
                        $('#form-rskp #nipatasan').val(ret.nip);
                        $('#form-rskp #pejatasan').val(ret.namalengkap);
                        $('#form-rskp #idjenjabatasan').val(ret.idjenjab);
                        $('#form-rskp #idjabatasan').val(ret.idjab);
                        $('#form-rskp #jabatasan').val(ret.jab);
                        $('#form-rskp #idgolatasan').val(ret.idgolru);
                        $('#form-rskp #golatasan').val(ret.golru);
                        $('#form-rskp #idskpdatasan').val(ret.idskpd);
                        $('#form-rskp #skpdatasan').val(ret.skpd);
                    }
                }
            });
        });
		<?php } ?>

        $('#form-rskp .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rskp .date").mask("99-99-9999");
        $("#form-rskp .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rskp #idpejab').on('change', function(e){
            e.preventDefault();
            $('#form-rskp #jabpenilai').val($(this).find(":selected").text());
        })

        //jobbradi
        $('input[type=radio][name=idjenjab]').change(function() {
            if (this.value == '1') {
                $('#form-rskp .kepemimpinan').show();
            }else{
                $('#form-rskp #pim').val('');
                $('#form-rskp .kepemimpinan').hide();
            }

            var idjenjab = $('#form-rskp input[type=radio][name=idjenjab]:checked').val();
            var jen_aturan_kinerja = $('#form-rskp #jen_aturan_kinerja').val();
            getScore(idjenjab, jen_aturan_kinerja);
        });

        function getScore(idjenjab, jen_aturan_kinerja){
            var idjenjab = $('#form-rskp input[type=radio][name=idjenjab]:checked').val();
            var jen_aturan_kinerja = $('#form-rskp #jen_aturan_kinerja').val();
            //
            var nilaiskp = parseFloat($("#form-rskp #nilai").val()) || 0;
            // console.log(nilaiskp);
            var nilaiorpel = parseFloat($("#form-rskp #orpel").val()) || 0;
            //console.log(nilaiorpel);
            var nilaikomitmen = parseFloat($("#form-rskp #komitmen").val()) || 0;
            // console.log(nilaikomitmen);
            var nilaikerjasama = parseFloat($("#form-rskp #kerjasama").val()) || 0;
            // console.log(nilaikerjasama);
            var nilaiintegritas = parseFloat($("#form-rskp #integritas").val()) || 0;
            // console.log(nilaiintegritas);
            var nilaidisiplin = parseFloat($("#form-rskp #disiplin").val()) || 0;
            // console.log(nilaidisiplin);
            var nilaipim = parseFloat($("#form-rskp #pim").val()) || 0;
            // console.log(nilaipim);
            var nilaiInstansiKerja = parseFloat($("#form-rskp #instansiKerja").val()) || 0;
            // console.log(nilaiInstansiKerja);

            if(idjenjab == 1){
                if(jen_aturan_kinerja == 46){
                    var nilaiperilaku  = (nilaiorpel+nilaikomitmen+nilaikerjasama+nilaiintegritas+nilaidisiplin+nilaipim)/6;
                    var nilaiRata = parseFloat(nilaiperilaku)*0.4;
                    var hasilSkp = parseFloat(nilaiskp)*0.6;
                    var nilaiprestasi = (parseFloat(nilaiskp)*0.6)+(parseFloat(nilaiperilaku)*0.4);
                }else{
                    var nilaiperilaku = (nilaiorpel+nilaikomitmen+nilaikerjasama+nilaiInstansiKerja+nilaipim)/5;
                    var nilaiRata = parseFloat(nilaiperilaku)*0.3;
                    var hasilSkp = parseFloat(nilaiskp)*0.7;
                    var nilaiprestasi = (parseFloat(nilaiskp)*0.7)+(parseFloat(nilaiperilaku)*0.3);
                }
            }else{
                if(jen_aturan_kinerja == 46){
                    var nilaiperilaku = (nilaiorpel+nilaikomitmen+nilaikerjasama+nilaiintegritas+nilaidisiplin)/5;
                    var nilaiRata = parseFloat(nilaiperilaku)*0.4;
                    var hasilSkp = parseFloat(nilaiskp)*0.6;
                    var nilaiprestasi = (parseFloat(nilaiskp)*0.6)+(parseFloat(nilaiperilaku)*0.4);
                }else{
                    var nilaiperilaku = (nilaiorpel+nilaikomitmen+nilaikerjasama+nilaiInstansiKerja)/4;
                    var nilaiRata = parseFloat(nilaiperilaku)*0.3;
                    var hasilSkp = parseFloat(nilaiskp)*0.7;
                    var nilaiprestasi = (parseFloat(nilaiskp)*0.7)+(parseFloat(nilaiperilaku)*0.3);
                }
            }
            //alert(idjenjab+' vs '+nilaiperilaku+' vs '+(parseFloat(nilaiskp)*0.7)+' vs '+(parseFloat(nilaiperilaku)*0.3));

            if(!isNaN(nilaiprestasi)){
                $('#form-rskp #nilaiperilaku').val(nilaiperilaku.toFixed(2));
                $('#form-rskp #nilaiprestasi').val(nilaiprestasi.toFixed(2));

                $('#form-rskp #hasilSkp').html(hasilSkp.toFixed(2));
                $('#form-rskp #hasilRata').html(nilaiRata.toFixed(2));
            }
        }

        $('#form-rskp .score').keyup(function(e) {
            var idjenjab = $('#form-rskp input[type=radio][name=idjenjab]:checked').val();
            var jen_aturan_kinerja = $('#form-rskp #jen_aturan_kinerja').val();
            getScore(idjenjab, jen_aturan_kinerja);
        }).trigger('keyup');

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
                            $('#form-rskp #'+attrname).val(ret[attrname]);
                            /*if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rskp #'+attrname).select2('val',ret[attrname]);
                            }*/
                            if($.inArray(attrname,arrayradio)!=-1){
                                $('#form-rskp input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true).trigger('click');
                            }
                        }

                        autoComplete3('#form-rskp #nippenilai', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nippenilai, ret.nippenilai, '');
                        autoComplete3('#form-rskp #nipatasan', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, ret.nipatasan, ret.nipatasan, '');

                        var text = ret.jabpenilai;
                        if(text.indexOf(ret.idpejab) != -1){
                            var newOption = new Option(ret.jabpenilai, ret.idpejab, false, true);
                            $('#form-rskp #idpejab').append(newOption).trigger('change');
                        }
                    }

                    if(ret.jen_aturan_kinerja == 0){
                        $('#jen_aturan_kinerja').val('');
                    }else{
                        $('#jen_aturan_kinerja').find(":selected").val();
                        if($('#jen_aturan_kinerja').find(":selected").val()==46){
                            $('#form-rskp #hitungSkp').html('X 60% ');
                            $('#form-rskp #hitungRata').html('X 40% ');
                            $('#form-rskp #hitungTotal').html('<em>(60% dari Nilai SKP) + (40% dari Nilai rata-rata)</em>');

                            $('#form-rskp .integritas').show();
                            $('#form-rskp .disiplin').show();

                            $('#form-rskp #instansiKerja').val('');
                            $('#form-rskp .instansiKerja').hide();
                        }else if($('#jen_aturan_kinerja').find(":selected").val()==30){
                            $('#form-rskp #hitungSkp').html('X 70% ');
                            $('#form-rskp #hitungRata').html('X 30% ');
                            $('#form-rskp #hitungTotal').html('<em>(70% dari Nilai SKP) + (30% dari Nilai rata-rata)</em>');

                            $('#form-rskp #integritas').val('');
                            $('#form-rskp .integritas').hide();

                            $('#form-rskp #disiplin').val('');
                            $('#form-rskp .disiplin').hide();

                            $('#form-rskp .instansiKerja').show();   
                        }
                        var idjenjab = $('#form-rskp input[type=radio][name=idjenjab]:checked').val();
                        console.log(idjenjab);
                        getScore(idjenjab, jen_aturan_kinerja);
                    }
                }
            });
        <?php } else {  ?>
        autoComplete3('#form-rskp #nippenilai', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        autoComplete3('#form-rskp #nipatasan', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        <?php } ?>
    });

</script>