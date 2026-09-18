
<script>
    $(document).ready(function(){
        $(".tmt").mask("99-99-9999");
        $('select').select2();

        $.ajax({
            url:'{!!url()!!}/emutasi/skmutasidalamskpd/nokolektif',
            data: { 'nousul':"{!!Input::get('nousul')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);
                /*UNTUK FORM*/
                $('#statususul').val(ret.statususul);
                $('.statususul').trigger('change');
                $('#statussk').val(ret.statussk);
                $('.statussk').trigger('change');
                // $('#statussk').select2('val',ret.statussk).trigger('change');
                // $('#statususul').select2('val',ret.statususul).trigger('change');
                var str4 = ret.tglsurat;
                var res4 = str4.split("-");
                $('#tglsurat').val(res4[2]+'-'+res4[1]+'-'+res4[0]);
                
                $('#nosk').val(ret.nosk);
                /*PENETAP*/
                $('#kepalabkd').val(ret.kepalabkd);
                $('#nipkepalabkd').val(ret.nipkepalabkd);
                $('#pangkatbkd').val(ret.pangkatbkd);

                if(ret.iscetaksk==0)
                {
                    $(' #iscetaksk0').val(ret.iscetaksk).attr('checked', 'checked');;
                }
                else if(ret.iscetaksk==1)
                {
                    $(' #iscetaksk1').val(ret.iscetaksk).attr('checked', 'checked');;
                }
                else if(ret.iscetaksk==2)
                {
                    $(' #iscetaksk2').val(ret.iscetaksk).attr('checked', 'checked');;
                }
            }
        });

        $('#form2').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan No Kolektif Dalam OPD ?',function(a){
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
                                claravel_modal_close('main_modal');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
<div class="row" style="padding-left: 35px;">
    <div class="span12">
        <form id="form2" name="form2" class="form-horizontal" action="{!!url()!!}/emutasi/skmutasidalamskpd/nokolektifmutasidalamskpd" target="_blank" class="" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" name="nousul" id="nousul" value="{!!Input::get('nousul')!!}">
            <div class="row">
                <div class="head-line">
                    <h4><i class="fa fa-fire"></i> Formulir Dokumen pengantar</h4>
                </div></br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Status Berkas </label>
                    <div class="col-sm-7">
                     <select id="statususul" name="statususul" class="input-large form-control statususul" required style="width: 100%">
                        <option value="0">.: Status Usulan :.</option>
                        <option value="1">Memenuhi Syarat</option>
                        <option value="2">Tidak Memenuhi Syarat</option>
                        <option value="3">Berkas Tidak Lengkap</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Status Surat Pengantar </label>
                <div class="col-sm-7">
                 <select name="statussk" id="statussk" class="form-control statussk">
                    <option value="0"> .: Status SK :.</option>
                    <option value="2"> Dalam Proses</option>
                    <option value="1"> Proses Selesai</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">No SK </label>
            <div class="col-sm-7">
             <input type="text" class="input-large form-control" name="nosk" id="nosk" value="nosk" required>
         </div>
     </div>
     <div class="form-group">
        <label class="col-sm-3 control-label">Tanggal Surat </label>
        <div class="col-sm-7">
         <input type="text" class="input-large tmt form-control" name="tglsurat" id="tglsurat" placeholder="dd-mm-yyyy" value="tglsurat" required>
     </div>
 </div>
 <div class="form-group">
    <label class="col-sm-3 control-label">Status SK</label>
    <div class="col-sm-7" style="margin-left: 20px;">
        <label class="radio">
            <input type="radio" name="iscetaksk" id="iscetaksk0" value="0"> Belum Cetak SK
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
    <label class="col-sm-3 control-label">Nama Penetap </label>
    <div class="col-sm-7">
     <input name="kepalabkd" id="kepalabkd" class="form-control" type="text" readonly>
 </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">NIP Penetap </label>
    <div class="col-sm-7">
     <input name="nipkepalabkd" id="nipkepalabkd" class="form-control" type="text" readonly>
 </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Pangkat </label>
    <div class="col-sm-7">
     <input name="pangkatbkd" id="pangkatbkd" class="form-control" type="text" readonly>
 </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">&nbsp; </label>
    <div class="col-sm-7">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</div>

</div>

</form>
</div>
</div>