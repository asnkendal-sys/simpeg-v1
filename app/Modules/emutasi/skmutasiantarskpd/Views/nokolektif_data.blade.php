
<script>
    $(document).ready(function(){
        $(".tmt").mask("99-99-9999");
        $('.mdl-attrnosk select').select2();

        $("#mdl-attrnosk #form2").submit(function(event) {
            event.preventDefault();
            var $form = $( this );

            $.ajax({
                type :'post',
                url  :$form.attr('action'),
                data :$form.serialize(),
                success:function(data){
                    var ret = $.parseJSON(data);
                    $('#mdl-attrnosk').modal('hide');
                    $('#form2').trigger('reset');
                    refreshMutasiantarskpd();
                    bootbox.alert(ret.text);
                }
            });
        });
    });
</script>

<form id="form2" name="form2" class="form-horizontal" action="url()/emutasi/skmutasiantarskpd/nokolektifMutasidalamskpd" class="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nousul" id="nousul" value="{{!!Input::get('nousul')!!}}">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nomor SK Untuk Status Pengajuan</label>
        <div class="col-sm-7">
            <label class="radio">
                <input type="radio" checked="" value="2" id="verifiksai2" name="verifiksai"> Dalam Proseses
            </label>
            <label class="radio">
                <input type="radio" value="0" id="verifiksai1" name="verifiksai"> Proses Selesai
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="tglsurat">Tanggal SK</label>
        <div class="col-sm-7">
            <input type="text" class="input-large tmt form-control" name="tglsurat" id="tglsurat" placeholder="dd-mm-yyyy" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="nosk">Nomor SK</label>
        <div class="col-sm-7">
            <input type="text" class="input-large form-control" name="nosk" id="nosk" placeholder="Nomor SK Mutasi">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Status SK</label>
        <div class="col-sm-7">
            <label class="radio">
                <input type="radio" name="iscetaksk" id="iscetaksk0" value="0" checked> Belum Cetak SK
            </label>
            <label class="radio">
                <input type="radio" name="iscetaksk" id="iscetaksk1" value="1"> Sudah Cetak SK
            </label>
            <label class="radio">
                <input type="radio" name="iscetaksk" id="iscetaksk2" value="2"> Pembatalan Cetak SK
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">&nbsp;</label>
        <div class="col-sm-7">
            <button class="btn btn-primary">Simpan</button>
            <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
    </div>
</form>