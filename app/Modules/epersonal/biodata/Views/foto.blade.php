<?php
    if(count($rs) > 0){
        $image = url()."/packages/upload/photo/pegawai/".$rs->photo;
    }else{
        $image = url()."/packages/upload/photo/pegawai/default.jpg";
    }

    if(session('role_id') <= 3){
        $alert = "Simpan data ?";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Foto Profil akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Update Foto Profil ?</li></ul>";
    }
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#uploadfoto').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            e.stopImmediatePropagation();
            var formData = new FormData(this);

            bootbox.confirm('{!!$alert!!}',function(a){
                $.ajax({
                    url : $this.attr('action'),
                    type : 'POST',
                    data : formData,
                    contentType: false,
                    processData: false,
                    success:function(html){
                        if(html == 4){
                            notification('Berhasil Ubah Foto Pegawai','success');
                            $('.modal-close').trigger('click');
                            claravel_modal_close('main_modal');
                            $('#simpan #nip').trigger('change');
                        }else{
                            notification(html,'danger');
                        }
                    }
                });
            });
        });

        var btnCust = '<button type="submit" class="btn btn-success" title="Simpan Foto">' +
            '<i class="glyphicon glyphicon-ok"></i> Simpan' +
            '</button>';

        $("#uploadfoto #photos").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i> Batalkan',
            removeTitle: 'Batalkan Foto Pegawai',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="{!!$image!!}" alt="Foto Pegawai" style="width:160px"><h6 class="text-muted">Ganti Foto Pegawai</h6>',
            layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    });
</script>

<!-- some CSS styling changes and overrides -->
<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
</style>

<div class="row">
    <div class="col-md-12" align="center">
        <!-- the avatar markup -->
        <div id="kv-avatar-errors-2" class="center-block" style="width:100%";display:none"></div>
        <form id="uploadfoto" class="text-center" action="{!!url()!!}/epersonal/biodata/updatefoto" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" name="nip" value="{!!$rs->nip!!}">
            <div class="kv-avatar center-block" style="width:200px">
                <input id="photos" name="photo" type="file" class="file-loading" title=".jpg .jpeg .png" accept="image/*" placeholder=".jpg .jpeg .png">
            </div>
            <!-- include other inputs if needed and include a form submit (save) button -->
        </form>
        <!-- your server code `avatar_upload.php` will receive `$_FILES['avatar']` on form submission -->
    </div>
</div>