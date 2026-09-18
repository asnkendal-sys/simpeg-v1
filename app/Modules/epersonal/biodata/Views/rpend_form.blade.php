<?php
if (session('role_id') <= 3) {
    $alert = "Simpan data ?";
} else {
    $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat Pendidikan yang terisi ceklist pendidikan awal atau akhir akan langsung terupdate ke biodata.</li></ul>";
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
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverpend':'saverpendtemp'), 'method'=> 'POST', 'files' => true, 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rpend')) !!}
                        @if(session('role_id') <= 3)
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            @else
                            {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                            @if((Input::get('tb') == 'r_pend') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rpend', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                            @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rpend', null, array('id'=> 'id_rpend')) !!}
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
                                    {!! Form::label('idtkpendid', 'Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! comboTkpendidikan($id="idtkpendid",$sel="",$required="") !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('jenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <select name="idjenjurusan" class="form-control" id="idjenjurusan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                        {!! Form::hidden('jenjurusan', null, array('class'=> 'form-control','id'=>'jenjurusan')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('noijaz', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Ijazah')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgijaz', ' Tanggal Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgijaz', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('namasekolah', null, array('class'=> 'form-control', 'placeholder'=> 'Nama Sekolah / Kampus')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tempat', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('tempat', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat Sekolah / Kampus')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('kepsek', null, array('class'=> 'form-control', 'placeholder'=> 'Kepala Sekolah / Rektor')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('dokumen_ijazah', 'Upload Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {{-- Menggunakan Form::file() untuk input file --}}
                                        {!! Form::file('dokumen_ijazah', array('class'=> 'form-control')) !!}
                                        <p class="help-block">Maksimal ukuran file: 2MB (PDF)</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('dokumen_transkrip', 'Upload Transkrip:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {{-- Menggunakan Form::file() untuk input file --}}
                                        {!! Form::file('dokumen_transkrip', array('class'=> 'form-control')) !!}
                                        <p class="help-block">Maksimal ukuran file: 2MB (PDF)</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for=""></label>
                                    <div class="col-sm-7">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="isawal" value="1"> Awal CPNS/PPPK
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="isakhir" value="1"> Akhir PNS/PPPK
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="checkbox">
                                            @if(Input::get('flag') == 1)
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
    $(document).ready(function() {
        $('#form-rpend select').select2();
        $('#form-rpend .num').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rpend .date").mask("99-99-9999");
        $("#form-rpend .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rpend').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            // bootbox.confirm('{!!$alert!!}', function(a) {
            //     if (a == true) {
            //         $.ajax({
            //             url: $this.attr('action'),
            //             type: 'POST',
            //             data: $this.serialize(),
            //             beforeSend: function() {
            //                 preloader.on();
            //             },
            //             success: function(html) {
            //                 preloader.off();
            //                 if ((html == '1') || (html == '4')) {
            //                     notification('Data Berhasil Disimpan.', 'success');
            //                     $('.modal-close').trigger('click');
            //                     claravel_modal_close('main_modal');
            //                     loadBiodata();
            //                     loadRpend();
            //                 } else {
            //                     notification(html, 'danger');
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
                            if ((html == 1) || (html == 4)) {
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

        $('#form-rpend #idtkpendid').on('change', function(e) {
            e.preventDefault();
            autoComplete('#form-rpend #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('#form-rpend #idjenjurusan').on('change', function(e) {
            e.preventDefault();
            $('#form-rpend #jenjurusan').val($(this).find(":selected").text());
        });

        <?php if (Input::get("flag") > 1) { ?>
            $.ajax({
                url: '{!!url()!!}/epersonal/biodata/editriwayat',
                type: 'post',
                data: {
                    'id': '{!!Input::get("id")!!}',
                    'tb': '{!!Input::get("tb")!!}',
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    preloader.on();
                },
                success: function(response) {
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tgijaz");
                    var arraycheck = new Array("isawal", "isakhir");
                    
                    var arrselect2 = new Array("idtkpendid", "idjenjurusan");
                    if (ret) {
                        for (attrname in ret) {
                            $('#form-rpend #' + attrname).val(ret[attrname]);
                            if ($.inArray(attrname, arrselect2) != -1) {
                                $('#form-rpend #' + attrname).val(ret[attrname]).trigger('change.select2');
                            }
                            if ($.inArray(attrname, arraycheck) != -1) {
                                $('#form-rpend input[name=' + attrname + ']').attr('checked', ((ret[attrname] == 1) ? true : false));
                            }
                           
                            if ($.inArray(attrname, arrdate) != -1) {
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rpend #' + attrname).val(res[2] + '-' + res[1] + '-' + res[0]);
                            }
                        }

                        autoComplete('#form-rpend #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, ret.idjenjurusan, ret.jenjurusan, ret.idtkpendid);
                    }
                }
            });
        <?php } ?>
    });
</script>