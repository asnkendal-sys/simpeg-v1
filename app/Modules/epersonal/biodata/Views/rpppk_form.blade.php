<?php
    if(session('role_id') <= 3){
        $alert = "<strong>Perhatian!</strong><ul><li>Riwayat PPPK yang berstatus perpanjangan dan ada perubahan nip baru akan merubah data NIP Pegawai secara keseluruhan.</li><li>Simpan data ?</li>";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKPP terlebih dahulu.</li><li>Riwayat PPPK yang berstatus perpanjangan akan merubah data NIP Pegawai secara keseluruhan.</li><li>Riwayat PPPK yang memiliki tmt Pengangkatan / Perpanjangan terbaru akan langsung terupdate ke biodata.</li></ul>";
    }
?>

<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                  {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverpppk':'saverpppktemp'), 'method' => 'POST', 'files' => true, 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rpppk')) !!}
                  @if(session('role_id') <= 3)
                      {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                      {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                  @else
                      {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                      @if((Input::get('tb') == 'r_pppk') or (Input::get('tb') == '') or (Input::get('tb') == 'tb_01'))
                          {!! Form::hidden('id_rpppk', null, array('id'=> 'id')) !!}
                          {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                      @else
                          {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                          {!! Form::hidden('id_rpppk', null, array('id'=> 'id_rpppk')) !!}
                          {!! Form::hidden('idjnsaksi', null, array('id'=> 'idjnsaksi')) !!}
                      @endif
                  @endif
                  <div class="box-body">
                      <div class="form-group">
                          {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                          </div>
                      </div>
                     
                      <div class="form-group">
                          {!! Form::label('idskpd','Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                              {!! Form::hidden('skpd', '', array('class'=> 'form-control', 'id'=>'skpd')) !!}
                              <em><small>(* Isian Unit Kerja isi dengan sub unit kerja terkecil.)</small></em>
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
                              {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7" id="jenisjabatan">
                                  <select name="jab" class="form-control" id="jab" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('pejmen', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              {!! comboPenetapsk("pejmen","","") !!}
                          </div>
                      </div>

                      <div id="xpengangkatan">
                          <div class="form-group">
                              {!! Form::label('nosk_calon', ' NO. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('nosk_calon', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Calon PPPK')) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              {!! Form::label('tglsk_calon', 'TGL. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  <div class='input-group datepicker'>
                                      {!! Form::text('tglsk_calon', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                              </div>
                          </div>
                      </div>

                        <div id="xnoskpppk">
                              <div class="form-group">
                                    {!! Form::label('nosk_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                          {!! Form::text('nosk_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK PPPK')) !!}
                                    </div>
                              </div>
                              <div class="form-group">
                                    {!! Form::label('tglsk_pppk', 'TGL. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                          <div class='input-group datepicker'>
                                          {!! Form::text('tglsk_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                          </div>
                                    </div>
                              </div>
                        </div>

                      <div class="form-group">
                          {!! Form::label('nosk', 'NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              {!! Form::text('nosk', null, array('class'=> 'form-control tambah-rpppk', 'placeholder'=>'Nomor SK Perjanjian','id'=>'nosk', 'required'=>'required')) !!}
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('tgsk', 'TGL. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group datepicker'>
                                  {!! Form::text('tgsk', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'Tanggal SK Perjanjian','id'=>'tgsk', 'required'=>'required')) !!}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>


                      <div class="form-group">
                          {!! Form::label('tmtawal', 'TMT Mulai PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group datepicker'>
                                  {!! Form::text('tmtawal', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Awal','id'=>'tmtawal', 'required'=>'required')) !!}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          {!! Form::label('tmtakhir', 'TMT Akhir PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group datepicker'>
                                  {!! Form::text('tmtakhir', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Akhir','id'=>'tmtakhir', 'required'=>'required')) !!}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              {!! comboGolrupppk("idgolru","","") !!}
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-2">
                              {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                          </div>
                          <div class="col-sm-1" style="margin-top: 7px;">
                              Tahun
                          </div>
                          <div class="col-sm-2">
                              {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                          </div>
                          <div class="col-sm-1" style="margin-top: 7px;">
                              Bulan
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('gaji', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group'>
                                  <span class="input-group-addon">Rp.</span>
                                  {!! Form::text('gaji', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                              </div>
                          </div>
                      </div>
                      
                      <!--<div class="form-group">
                          {!! Form::label('noskmutasi', 'Nomor SK Mutasi:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              {!! Form::text('noskmutasi', null, array('class'=> 'form-control tambah-rpppk', 'placeholder'=>'Nomor SK Mutasi','id'=>'noskmutasi')) !!}
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('tglskmutasi', 'Tanggal SK Mutasi:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group datepicker'>
                                  {!! Form::text('tglskmutasi', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'Tanggal SK Mutasi','id'=>'tglskmutasi')) !!}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          {!! Form::label('tmtmutasi', 'TMT SK Mutasi:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class='input-group datepicker'>
                                  {!! Form::text('tmtmutasi', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT SK Mutasi','id'=>'tmtmutasi')) !!}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>-->
                                  
                                  
                                <div class="form-group">
                                    {!! Form::label('dokumen_pendukung', 'Upload Dokumen:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {{-- Menggunakan Form::file() untuk input file --}}
                                        {!! Form::file('dokumen_pendukung', array('class'=> 'form-control')) !!}
                                        <p class="help-block">Maksimal ukuran file: 2MB (PDF)</p>
                                    </div>
                                </div>
                      <div class="form-group">
                          {!! Form::label('sts_kontrak', 'Status PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <label class="radio-inline">
                                  <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio1" value="1" required> Pengangkatan
                              </label>
                              <label class="radio-inline">
                                  <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio2" value="2" required> Perpanjangan
                              </label>
                              <p><em><small>(* Status Riwayat PPPK Perpanjangan akan merubah data NIP Keseluruhan data pegawai.)</small></em></p>
                          </div>
                      </div>

                      
                      <div id="xperpanjangan">
                          <div class="form-group">
                              {!! Form::label('nipbaru', 'NIP Baru:', array('class' => 'col-sm-3 control-label')) !!}
                              <div class="col-sm-7">
                                  {!! Form::text('nipbaru', null, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai Baru')) !!}
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                          <div class="col-sm-7">
                              <div class="checkbox">
                                  @if(Input::get('flag') == 1)
                                      <button class="btn btn-info awal" id="xreset" type="button" title="Reset"><i class="fa fa-refresh"></i> Reset</button>
                                      <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                  @elseif(Input::get('flag') == 2)
                                      <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> Update</button>
                                  @elseif(Input::get('flag') == 3)
                                      <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Hapus</button>
                                  @endif
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
        $('#form-rpppk select').select2();
        $('#form-rpppk #skpd').val($('#simpan #idskpd').find(":selected").text());
        autoComplete('#form-rpppk #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');
        $('#form-rpppk #idskpd').on('change', function(e){
            e.preventDefault();
            $('#form-rpppk #skpd').val($(this).find(":selected").text());
            /*$("#form-rpppk #idjab, #form-rpppk #idesljbt").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });*/
        });

        $('#form-rpppk .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rpppk .date").mask("99-99-9999");
        $("#form-rpppk .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#xpengangkatan, #xperpanjangan').hide();
        $('input[name=sts_kontrak]').on('change', function(){
            var sts_kontrak = $('input[name="sts_kontrak"]:checked').val();
            if(sts_kontrak == 1){
                $('#xpengangkatan').fadeIn();
                $('#xnoskpppk').fadeIn();
                $('#xperpanjangan').fadeOut();
            }else if(sts_kontrak == 2){
                $('#xpengangkatan').fadeOut();
                $('#xnoskpppk').fadeOut();
                $('#xperpanjangan').fadeIn();
            }
        });

        $('#form-rpppk').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            // bootbox.confirm('{!!$alert!!}',function(a){
            //     if (a == true){
            //         $.ajax({
            //             url : $this.attr('action'),
            //             type : 'POST',
            //             data : $this.serialize(),
            //             beforeSend: function(){
            //                 preloader.on();
            //             },
            //             success:function(html){
            //                 preloader.off();
            //                 if((html=='1') || (html=='4')){
            //                     notification('Data Berhasil Disimpan.','success');
            //                     $('.modal-close').trigger('click');
            //                     claravel_modal_close('main_modal');
            //                     loadBiodata();
            //                     loadRdikstru();
            //                 }else{
            //                     notification(html,'danger');
            //                 }
            //             }
            //         });
            //     }
            // });

            bootbox.confirm('{!!$alert!!}', function(a) {
                if (a == true) {
                    // Ambil elemen FORM secara langsung untuk membuat FormData
                    // Asumsi '$this' adalah objek jQuery yang mereferensikan form
                    var form = $this[0]; // Ambil elemen DOM mentah dari objek jQuery
                    var formData = new FormData(form); // Buat objek FormData

                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        // Ganti data: $this.serialize()
                        data: formData,

                        // **PENTING UNTUK FILE UPLOAD DENGAN JQUERY AJAX:**
                        // 1. Matikan pemrosesan data oleh jQuery (agar FormData tidak diubah menjadi string)
                        processData: false,
                        // 2. Matikan pengaturan header Content-Type (agar browser yang menanganinya, termasuk boundary multipart)
                        contentType: false,

                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            preloader.off();
                            // Respons server harus dalam format string '1' atau '4' (sesuai logika Anda)
                            if ((html == '1') || (html == '4')) {
                                notification('Data Berhasil Disimpan.', 'success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');
                                // Asumsi fungsi-fungsi ini untuk me-reload data
                                loadBiodata();
                                loadRpend();
                            } else {
                                // Jika server mengembalikan pesan error (HTML/teks)
                                notification(html, 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Tambahkan penanganan error AJAX jika koneksi gagal atau error 500
                            preloader.off();
                            notification('Terjadi kesalahan server atau koneksi: ' + error, 'danger');
                        }
                    });
                }
            });
        });

      

        <?php if(Input::get("flag") == 1){ ?>
          $.ajax({
            url:'{!!url()!!}/epersonal/biodata/tambahriwayatjab',
            type:'post',
            data:{'nip':$('#form-rpppk  #nip').val(),'tb':'tb_01','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);

                $('#form-rpppk #nosk_calon').val(ret.noskcalonawal_pppk);
                $('#form-rpppk #nosk_pppk').val(ret.noskawal_pppk);
                $('#form-rpppk #idskpd').select2('val',ret.idskpd);
                $('#form-rpppk #idjenjab').select2('val',ret.idjenjab);
                $('#form-rpppk #pejmen').select2('val',ret.pejmenjbt);

                $('#form-rpppk #idgolru').select2('val',ret.idgolruakhir_pppk);
                $('#form-rpppk #nosk').val(ret.noskjbt);
                $('#form-rpppk #gaji').val(ret.gaji);
                $('#form-rpppk #tmtawal').val(ret.tmtmulaiakhir_pppk);
                $('#form-rpppk #tmtakhir').val(ret.tmtakhirakhir_pppk);

                var tgskcalonawal_pppk = ret.tgskcalonawal_pppk;
                var res_tgskcalonawal_pppk = tgskcalonawal_pppk.split("-");
                $('#form-rpppk #tglsk_calon').val(res_tgskcalonawal_pppk[2]+'-'+res_tgskcalonawal_pppk[1]+'-'+res_tgskcalonawal_pppk[0]);

                var tglsk_pppk = ret.tgskawal_pppk;
                var res_tglsk_pppk = tglsk_pppk.split("-");
                $('#form-rpppk #tglsk_pppk').val(res_tglsk_pppk[2]+'-'+res_tglsk_pppk[1]+'-'+res_tglsk_pppk[0]);

                var tgsk = ret.tgskjbt;
                var res_tgsk = tgsk.split("-");
                $('#form-rpppk #tgsk').val(res_tgsk[2]+'-'+res_tgsk[1]+'-'+res_tgsk[0]);

                var tmtawal = ret.tmtmulaiawal_pppk;
                var res_tmtawal = tmtawal.split("-");
                $('#form-rpppk #tmtawal').val(res_tmtawal[2]+'-'+res_tmtawal[1]+'-'+res_tmtawal[0]);

                var tmtakhir = ret.tmtakhirawal_pppk;
                var res_tmtakhir = tmtakhir.split("-");
                $('#form-rpppk #tmtakhir').val(res_tmtakhir[2]+'-'+res_tmtakhir[1]+'-'+res_tmtakhir[0]);

            }

          });

        $('#idgolru').on('change', function(e){
            e.preventDefault();
            getgaji();
        });

        $('#thkerja').on('keyup', function(e){
            e.preventDefault();
            getgaji();
        });
        
        <?php }else if(Input::get("flag") > 1){ ?>
        $.ajax({
            url:'{!!url()!!}/epersonal/biodata/editriwayat',
            type:'post',
            data:{'id':'{!!Input::get("id")!!}','tb':'{!!Input::get("tb")!!}','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk","tmtawal","tmtakhir","tglsk_calon","tglsk_pppk");
                var arrselect2 = new Array("idjenjab","jab","pejmen","idskpd","idgolru");
                var arrayradio = new Array("sts_kontrak");
                if(ret){
                    for(attrname in ret){
                        $('#form-rpppk #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rpppk #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#form-rpppk #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('#form-rpppk input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                        }
                    }

                    $('input[name=sts_kontrak]').trigger('change');

                    $("#form-rpppk #idskpd").data('select2').trigger('select', {
                        data: {"id":ret.idskpd,"text":ret.skpd}
                    });
                }
            }
        });
        <?php } ?>

        $('#form-rpppk #idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            /*alert($('#form-rpppk #idjnsaksi').val()+' - '+$('#form-rpppk  #id').val()+' vs '+$('#idjnsaksi').val()+' - '+$('#id').val());*/
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatanpppk',
                type:'post',
                data:{'idjenjab': $(this).val(), 'idskpd': $('#form-rpppk  #idskpd').val(), 'nip': $('#form-rpppk  #nip').val(), 'id': $('#form-rpppk  #id').val(), 'tb':  "{!!Input::get('tb')!!}",'_token' : '{!!csrf_token()!!}', 'act': 'biodata'},
                beforeSend:function(){
                    $('#form-rpppk #jenisjabatan').html('Looading...');
                },
                success:function(respose){
                    $('#form-rpppk #xjenisjabatan').html(respose);
                }
            })
        });

        $('#form-rpppk #xreset').on('click', function(e){
            e.preventDefault();
            $("#form-rpppk #idskpd").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });
            $("#form-rpppk #idjenjab").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });
            $("#form-rpppk #pejmen").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });
            $(".tambah-rpppk").val('');
            // alert('ini reset');

            $('#form-rpppk #idjenjab').on('change', function(e){
                e.preventDefault();
                var idjenjab = $(this).val();
                /*alert($('#form-rpppk #idjnsaksi').val()+' - '+$('#form-rpppk  #id').val()+' vs '+$('#idjnsaksi').val()+' - '+$('#id').val());*/
                $.ajax({
                    url:'{{url()}}/epersonal/biodata/jenisjabatanpppk',
                    type:'post',
                    data:{'idjenjab': $(this).val(), 'idskpd': $('#form-rpppk  #idskpd').val(), 'nip': $('#form-rpppk  #nip').val(), 'id': $('#form-rpppk  #id').val(), 'tb':  "",'_token' : '{!!csrf_token()!!}', 'act': 'biodata'},
                    beforeSend:function(){
                        $('#form-rpppk #jenisjabatan').html('Looading...');
                    },
                    success:function(respose){
                        $('#form-rpppk #xjenisjabatan').html(respose);
                    }
                })
            });
        });
    });

    function getgaji(){
          var idgolru = $('#idgolru').val();
          var mkthn = $('#thkerja').val();
          console.log(idgolru);
          console.log(mkthn);

        $.ajax({
            url : '{!!url()!!}/epersonal/biodata/gajipppk',
            type : 'post',
            data : {'idgolru' : idgolru, 'mkthn' : mkthn, '_token' : '{!!csrf_token()!!}'},
            beforeSend : function(){},
            success : function(response){
                var ret = $.parseJSON(response);
            //     $('#form-rpangkat #gapok #gaji').val(ret.gaji);
          console.log(ret);
                $('#gaji').val(ret.gaji);
            }
        });
    }

</script>
