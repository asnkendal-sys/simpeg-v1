<link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/sweetalert2/sweetalert2.min.css')!!}">
<script src="{{ asset('packages/tugumuda/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<?php
$pegawai = \DB::table('tb_01')
    ->where('nip', '=', $nip)
    ->first();

$subsubjenis = \DB::connection('efile_2017')->table('kategori_jenis')
    ->where('level', '=', 3)
    ->where('parent', '=', 6)
    ->get();
?>
<style type="text/css">
    .modal { overflow: auto !important; }
    thead{
        color: black;
    }
    .swal-wide{
        width:700px !important;
        /*margin-left: -350px !important;*/
        /*margin-top: -320px !important;*/
    }
</style>
<form id="fileupload" action="{{url('/')}}/efile/uploaddokumen" method="POST" enctype="multipart/form-data">
<table>
	<tr>
		<td width="130">NIP</td>
		<td width="15">: </td>
		<td>{!!$nip!!}</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>: </td>
		<td>{!!$pegawai->nama!!}. {!!$pegawai->gdb!!}</td>
	</tr>
    <tr>
        <td>Jenis Dokumen</td>
        <td>: </td>
        <td>{!!\Input::get('nama_jenis')!!}{!!\Input::get('jenisdokumen')!!}</td>
    </tr>
    @if(\Input::get('jenis') == 6)
    <tr>
        <td>Sub Jenis</td>
        <td>: </td>
        <td>
            <select class="form-control" id="subsubjenis" name="subsubjenis" required>
                <option value="">.: Pilih Sub Jenis :.</option>
                @foreach($subsubjenis as $row)
                <option value="{{$row->id}}">{{$row->nama}}</option>
                @endforeach
            </select>
        </td>
    </tr>
    @endif
</table>
<hr>
    <input type="hidden" name="nip" value="{!!$nip!!}">
    <input type="hidden" name="jenis" value="{!!$jenis!!}">
    <input type="hidden" id="subjenis" name="subjenis" value="{!!$subjenis!!}">
    <input type="hidden" name="user_id" value="{{\Session::get('user_id')}}">
    <input type="hidden" name="role_id" value="{{\Session::get('role_id')}}">
    <input type="hidden" name="status" value="1">
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-3">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success btn-xs fileinput-button" id="tambahfile" style="display: {{\Input::get('jenis') == 6 ? 'none' : 'inline-block'}}">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Tambah File</span>
                <input type="file" name="files[]">
            </span>
            <a id="cetakdokumen" style="display: {{\Input::get('jenis') == 6 ? 'none' : 'inline-block'}}" role="button" class="btn btn-primary btn-xs"><span><i class="fa fa-file-pdf-o"></i> Cetak Dokumen</span></a>
            {{-- <button type="submit" class="btn btn-primary start btn-xs">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Mulai upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel btn-xs">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Batalkan upload</span>
            </button> --}}
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="col-lg-9 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped">
        <tr>
            {{-- <td>No</td> --}}
            <td>Preview</td>
            <td>Nama</td>
            <td>Jenis</td>
            <td>Act</td>
        </tr>
        <tbody class="files"></tbody>
    </table>
</form>
<script>
/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* global $, window */
function filesize(fileSizeInBytes) {

    var i = -1;
    var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
    do {
        fileSizeInBytes = fileSizeInBytes / 1024;
        i++;
    } while (fileSizeInBytes > 1024);

    return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
};

$(function () {
    'use strict';
    var no = 1;
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        // xhrFields: {withCredentials: true},
        forceIframeTransport: true,
        url: 'server/php/',
        uploadTemplateId: null,
        downloadTemplateId: null,
        uploadTemplate: function (o) {
            var rows = $();
        
            $.each(o.files, function (index, file) {
                var row = $('<tr class="template-upload fade">' +
                    // '<td><center>'+no+'</center></td>' +
                    '<td><span class="preview"></span></td>' +
                    '<td><p class="name"></p>' +
                    '<div class="error"></div>' +
                    '</td>' +
                    '<td><p class="size"></p>' +
                    '<div class="progress"></div>' +
                    '</td>' +
                    '<td>' +
                    (!index && !o.options.autoUpload ?
                        '<button class="start btn btn-success btn-sm" disabled>Start</button>&nbsp;&nbsp;&nbsp;' : '') +
                    (!index ? '<button class="cancel btn btn-warning btn-sm">Cancel</button>' : '') +
                    '</td>' +
                    '</tr>');
                row.find('.name').text(file.name);
                row.find('.size').text(o.formatFileSize(file.size));
                if (file.error) {
                    row.find('.error').text(file.error);
                }
                            rows = rows.add(row);
                // no++;
            });
                    return rows;
        },
        downloadTemplate: function (o) {
            var rows = $();
            $.each(o.files, function (index, file) {
                var row = $('<tr class="template-download fade">' +
                    // '<td><center>'+no+'</center></td>' +
                    '<td><span class="preview"></span></td>' +
                    '<td><p class="name"></p>' +
                    (file.error ? '<div class="error"></div>' : '') +
                    '</td>' +
                    '<td>'+file.jenis+'</td>' +
                    '<td>'+'<button fileid="'+file.id+'" type="button" class="hapus btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>'+'&nbsp;&nbsp;&nbsp;'+'</td>' +
                    '</tr>');
                row.find('.size').text(o.formatFileSize(file.size));
                if (file.error) {
                    row.find('.name').text(file.name);
                    row.find('.error').text(file.error);
                } else {
                    row.find('.name').append($('<a title="Klik untuk preview file" role="button" class="previewdoc" nip="{!!$nip!!}" filename="'+file.name+'"></a>').text(file.name));
                    if (file.thumbnailUrl) {
                        row.find('.preview').append(
                            $('<a title="Klik untuk preview file" role="button" class="previewdoc" nip="{!!$nip!!}" filename="'+file.name+'"></a>').append(
                                $('<img>').prop('src', file.thumbnailUrl)
                            )
                        );
                    }
                    row.find('.size').text(filesize(file.size));
                    // row.find('a')
                    //     .attr('data-gallery', '')
                    //     .prop('href', file.url);
                    row.find('button.delete')
                        .attr('data-type', file.delete_type)
                        .attr('data-url', file.delete_url);
                }
                rows = rows.add(row);
                // no++;
            });
            return rows;
        }
    }).bind('fileuploadprogressall', function (e, data) {
        if(data.loaded==data.total) {
            $('.files').html('');
            // Load existing files:
            $('#fileupload').addClass('fileupload-processing');

            var subjenis = $('#subjenis').val();
            var subsubjenis = $('#subsubjenis').val();

            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: $('#fileupload').fileupload('option', 'url')+'?nip={!!$nip!!}&jenis={!!$jenis!!}&subjenis='+subjenis+'&subsubjenis='+subsubjenis,
                dataType: 'json',
                context: $('#fileupload')[0]
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option', {
        	url: '{{url('/')}}/efile/uploaddokumen',
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 2000000,
            acceptFileTypes: /(\.|\/)(jpe?g|png|pdf)$/i,
            autoUpload:true,
        },
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/test'
        )
    );

    //check server
    if ($.support.cors) {
        $.ajax({
            url: '{{url('/')}}/efile/uploaddokumen',
            type: 'HEAD'
        }).fail(function () {
            $('<div class="alert alert-danger"/>')
                .text('Upload server currently unavailable - ' +
                        new Date())
                .appendTo('#fileupload');
        });
    }

    function loadexist(){
        $('.files').html('');
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url')+'?nip={!!$nip!!}&jenis={!!$jenis!!}&subjenis={!!$subjenis!!}{{\Input::has("subsubjenis")?"&subsubjenis=".\Input::get("subsubjenis"):""}}',
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

    loadexist();

    $('#cetakdokumen').on('click', function(e){
        e.preventDefault();
        var subsubjenis = $('#subsubjenis').val();
        var url = "{!!url()!!}/epersonal/biodata/cetakpdf?nip={!!$nip!!}&nama={!!$pegawai->nama!!}. {!!$pegawai->gdb!!}&ident={!!\Input::get('ident')!!}&jenis={!!$jenis!!}&subjenis={!!$subjenis!!}&subsubjenis="+subsubjenis+"&jenisdokumen={!!\Input::get('nama_jenis')!!}{!!\Input::get('jenisdokumen')!!}"
        window.open(url,'_blank');
    })

    $('#subsubjenis').on('change',function(){
        if($(this).val() == ''){
            $('#tambahfile').hide();
            $('#cetakdokumen').hide();
        }else{
            $('#tambahfile').show();
            $('#cetakdokumen').show();
        }
        $('.files').html('');
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url')+'?nip={!!$nip!!}&jenis={!!$jenis!!}&subjenis={!!$subjenis!!}&subsubjenis='+$('#subsubjenis').val(),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    });

    $('.files').on('click','.hapus', function(){
        var fileid = $(this).attr('fileid');
        if(confirm("Hapus file ini?")){
            $.ajax({
                url: '{{url('/')}}/efile/hapusfile',
                type: 'POST',
                data: 'fileid='+fileid+'&role_id={{\Session::get("role_id")}}'
            }).success(function () {
                loadexist();
            });
        }
    });

    $('.files').on('click','.previewdoc', function(){
        var nip = $(this).attr('nip');
        var filename = $(this).attr('filename');
        $.ajax({
            url: '{!!url()!!}/epersonal/biodata/previewdoc',
            type: 'POST',
            data: 'nip='+nip+'&filename='+filename+'&_token={{csrf_token()}}',
        }).success(function (response) {
            swal({
                html: response,
                showCloseButton: true,
                customClass: 'swal-wide',
                showConfirmButton: false
            })
        });
    });

});
</script>