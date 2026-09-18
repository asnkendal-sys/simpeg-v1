<script>

    $(document).ready(function() {

        $('.mdl-editluardaerah select').select2();
        $('.mdl-editluardaerah .tmt').mask("99-99-9999");

        $.ajax({
            url:'{!!url()!!}/emutasi/nominatifluarkabupaten/edit',
            data: { 'idusul': '{!!Input::get("id")!!}','nip': '{!!Input::get("nip")!!}', '_token': '{!!csrf_token()!!}' },
            type:'post',
            success:function(data){
                var ret = $.parseJSON(data);
                $('.mdl-editluardaerah #nip').html(ret.nip);
                $('.mdl-editluardaerah #namalengkap').html(ret.namalengkap);
                $('.mdl-editluardaerah #golrujabjbt').html(ret.pangkat+' ('+ret.golru+")");
                $('.mdl-editluardaerah #pendid').html(ret.tkpendid+' - '+ret.jenjurusan);
                $('.mdl-editluardaerah #jabatan').html(ret.jabatan);
                $('.mdl-editluardaerah #skpd').html(ret.path);
                $('.mdl-editluardaerah #id_edit1').val(ret.idusul);
                $('.mdl-editluardaerah #id_edit2').val(ret.nip);
                $('.mdl-editluardaerah #tglusul').val(ret.tglusul_);

                $('.mdl-editluardaerah #idpemerintah').select2('val',ret.idpemerintah);
                $('.mdl-editluardaerah #provinsi').val(ret.provinsi);
                $('.mdl-editluardaerah #kabupaten').val(ret.kabupaten);
                $('.mdl-editluardaerah #instansi').val(ret.instansi);
                $('.mdl-editluardaerah #noskpermintaan').val(ret.noskpermintaan);
                $('.mdl-editluardaerah #tglskpermintaan').val(ret.tglskpermintaan_);
                $('.mdl-editluardaerah #keterangan').val(ret.keterangan);
            }
        });

        $(".mdl-editluardaerah #idpemerintah").change(function(){

            var jos = $(".mdl-editluardaerah #idpemerintah").val();
            //alert(jos);
            if(jos == 1 ||  jos == 2 || jos == 3){
                $(".mdl-editluardaerah #provkabkota").show();
                $(".mdl-editluardaerah #kemlem").hide();
            }else{
                $(".mdl-editluardaerah #provkabkota").hide();
                $(".mdl-editluardaerah #kemlem").show();
            }

        }).trigger('change');
        $(".{!!Input::get('n')!!}provkabkota").show();
        $(".{!!Input::get('n')!!}kemlem").hide();

        $('.mdl-editluardaerah').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Nominatif Luar Daerah ?',function(a){
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

    });

</script>

<form id="form2" name="form2" class="form-horizontal mdl-editluardaerah" action="{!!url()!!}/emutasi/nominatifluarkabupaten/update" method="post" enctype="multipart/form-data">

    <input type="hidden" id="id_edit1" name="id_edit1" value="" />
    <input type="hidden" id="id_edit2" name="id_edit2" value="" />
    {!!csrf_field()!!}

    <div class="row" style="margin-left: 15px;">
        <div class="col-md-6">
            <div class="head-line">
                <h4><i class="fa fa-fw fa-child"></i> BIODATA</h4>
            </div></br>
            <div class="form-group">
                <label class="col-sm-3 control-label">NIP </label>
                <div class="col-sm-7">
                    <span id="nip"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nama Lengkap </label>
                <div class="col-sm-7">
                    <span id="namalengkap"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Gol. Ruang</label>
                <div class="col-sm-7">
                    <span id="golrujabjbt"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pendidikan Terkahir</label>
                <div class="col-sm-7">
                    <span id='pendid'></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Jabatan Lama</label>
                <div class="col-sm-7">
                    <span id="jabatan"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">SKPD Lama</label>
                <div class="col-sm-7">
                    <span id="skpd"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="head-line">
                <h4><i class="fa fa-fw fa-paper-plane-o"></i> MUTASI LUAR DAERAH</h4>
            </div></br>
            <div class="form-group">                
                <label class="col-sm-3 control-label">Tanggal Usulan</label>
                <div class="col-sm-7">
                    <input type="text" name="tglusul" class="tmt form-control" id='tglusul' placeholder='dd-mm-yyyy' readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pemerintah</label>
                <div class="col-sm-7">
                    {!!NominatifluarkabupatenModel::comboPemerintah("idpemerintah","","")!!}
                </div>
            </div>
            <div id="provkabkota">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Provinsi Pindah</label>
                    <div class="col-sm-7">
                        <input type="text" name="provinsi" id="provinsi" class="input-large form-control" placeholder="Provinsi Pindah">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Kab/Kota Pindah</label>
                <div class="col-sm-7">
                    <input type="text" name="kabupaten" id="kabupaten" class="input-large form-control" placeholder="Kabupaten Pindah">
                </div>
            </div>
            <div id="kemlem">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Instansi</label>
                    <div class="col-sm-7">
                        <input type="text" name="instansi" id="instansi" class="input-xlarge form-control" placeholder="Instansi Pindah">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Tanggal Rujukan</label>
                <div class="col-sm-7">
                    <input type="text" name="tglskpermintaan" id="tglskpermintaan" required class="input-medium tmt form-control" placeholder="dd-mm-yyyy">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Keterangan Mutasi</label>
                <div class="col-sm-7">
                    <input type="text" name="keterangan" class="input-xlarge form-control" id='keterangan' placeholder='Keterangan Mutasi'>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-7">
                    <button class="btn btn-primary">Simpan</button>
                    <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Batal</button>
                </div>
            </div>
        </div>
    </div>

</form>