<?php
if (session('role_id') <= 3) {
    $alert = "Data yang disimpan akan langsung tersinkronisasi dengan SIASN. <br>Simpan data ?";
} else {
    $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat diklat Fungsional yang memiliki tmt terbaru akan langsung terupdate ke biodata.</li></ul>";
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
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverdikfung':'saverdikfungtemp'), 'method'=> 'POST', 'files' => true, 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rdikfung')) !!}
                        @if(session('role_id') <= 3)
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            @else
                            {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                            @if((Input::get('tb') == 'r_dikfung') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rdikfung', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                            @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rdikfung', null, array('id'=> 'id_rdikfung')) !!}
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
                                    {!! Form::label('dikfung', 'Nama Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('dikfung', null, array('class'=> 'form-control', 'placeholder'=>'Nama Diklat')) !!}
                                        <!-- <select name="iddikfung" class="form-control" id="iddikfung" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                        {!! Form::hidden('dikfung', null, array('class'=> 'form-control', 'id'=> 'dikfung')) !!} -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tmdikfung', 'Tempat:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('tmdikfung', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Diklat')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('penyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('penyelenggara', null, array('class'=> 'form-control', 'placeholder'=>'Penyelenggara')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('angkatan', 'Angkatan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('angkatan', null, array('class'=> 'form-control', 'placeholder'=>'Angkatan')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Mulai')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Selesai')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('jamhari', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class='input-group'>
                                            {!! Form::text('jamhari', null, array('class'=> 'form-control num', 'placeholder'=>'Lama Dalam Satuan Jam')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nosttpdikfung', 'No. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('nosttpdikfung', null, array('class'=> 'form-control', 'placeholder'=>'No. STTP')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgsttpdikfung', 'Tgl. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgsttpdikfung', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. STTP')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('dokumen_pendukung', 'Upload Dokumen:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {{-- Menggunakan Form::file() untuk input file --}}
                                        {!! Form::file('dokumen_pendukung', array('class'=> 'form-control', 'required' => 'required')) !!}
                                        <p class="help-block">Maksimal ukuran file: 2MB (PDF)</p>
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
        $('#form-rdikfung select').select2();
        autoComplete2('#form-rdikfung #iddikfung', '{{url()}}/epersonal/biodata/dikfung', '.: Pilihan :.', null, '', '', '');
        $('#form-rdikfung .num').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rdikfung .date").mask("99-99-9999");
        $("#form-rdikfung .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rdikfung').on('submit', function(e) {
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

        $('#form-rdikfung #iddikfung').on('change', function(e) {
            e.preventDefault();
            $('#form-rdikfung #dikfung').val($(this).find(":selected").text());
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
                    var arrdate = new Array('tgmul', 'tgsel', 'tgsttpdikfung');
                    if (ret) {
                        for (attrname in ret) {
                            $('#form-rdikfung #' + attrname).val(ret[attrname]);
                            if ($.inArray(attrname, arrdate) != -1) {
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rdikfung #' + attrname).val(res[2] + '-' + res[1] + '-' + res[0]);
                            }
                        }

                        $("#form-rdikfung #iddikfung").data('select2').trigger('select', {
                            data: {
                                "id": ret.iddikfung,
                                "text": ret.dikfung
                            }
                        });
                    }
                }
            });
        <?php } ?>
    });
</script>