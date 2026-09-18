<script type="text/javascript">
    $(document).ready(function(){
        autoComplete('#table-notifikasi #penerimaopd', '{!!url()!!}/epersonal/biodata/skpd', '.: Pilihan Unit Kerja :.', null, '', '', '');
        autoCompleteimg('#table-notifikasi #penerimapgw', '{{url()}}/epersonal/biodata/caripegawai', '.: Pilihan Pegawai :.', null, '', '', '');

        $('#penerimaexcel').fileinput({
            showUpload:false,
            showPreview: false,
            browseLabel: " Browse..",
            allowedFileExtensions: ["xls", "xlsx"],
            maxFileSize: 650 * 1 * 1 ,
            browseIcon: '<i class="fa fa-folder-open"></i>',
            removeLabel: " Hapus",
            removeIcon: '<i class="fa fa-times"></i>'
        });
    })
</script>

<?php
    $idkategori = Input::get('id');
?>

@if($idkategori == 1)
<tr>
    <td><b>Penerima Notifikasi</b></td>
    <td class="text-center" width="2%">&nbsp;</td>
    <td>
        Semua Pegawai<br>
        <p><input type="hidden" name="penerima" class="form-control" value="all"></p>
    </td>
</tr>
@elseif($idkategori == 2)
<tr>
    <td><b>Penerima Notifikasi</b></td>
    <td class="text-center" width="2%">&nbsp;</td>
    <td>
        <select name="penerima[]" class="form-control" id="penerimaopd" style="width: 100%" multiple></select>
    </td>
</tr>
@elseif($idkategori == 3)
<tr>
    <td><b>Penerima Notifikasi</b></td>
    <td class="text-center" width="2%">&nbsp;</td>
    <td>
        <select name="penerima[]" class="form-control" id="penerimapgw" style="width: 100%" multiple></select>
    </td>
</tr>
@elseif($idkategori == 4)
<tr>
    <td><b>Penerima Notifikasi</b></td>
    <td class="text-center" width="2%">&nbsp;</td>
    <td>
        <div class="row">
            <div class="col-md-9">
                <input type="file" name="penerima" id="penerimaexcel" title=".xls .xlsx" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
            </div>
            <div class="col-md-2">
                <a href="{!!url()!!}/packages/upload/excel/notifikasi/format_penerima_notifikasi.xlsx" target="_blank" title="Format Penerima Notifikasi" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> Format Excel</a>
            </div>
        </div>
    </td>
</tr>
@endif