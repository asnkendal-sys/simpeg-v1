<script>

    $(document).ready(function() {

        $('.mdl-verifikasi select').select2();
        $(".mdl-verifikasi .tmt").mask("99-99-9999");

        $.ajax({
            url:'{!!url()!!}/emutasi/nominatifluarkabupaten/edit',            
            data: { 'idusul': '{!!Input::get("id")!!}','nip': '{!!Input::get("nip")!!}', '_token': '{!!csrf_token()!!}' },
            type:'post',
            success:function(data){
                var ret = $.parseJSON(data);
                $('.mdl-verifikasi #nip').html(ret.nip);
                $('.mdl-verifikasi #namalengkap').html(ret.namalengkap);
                $('.mdl-verifikasi #golrujabjbt').html(ret.pangkat+' ('+ret.golru+")");
                $('.mdl-verifikasi #pendid').html(ret.tkpendid+' - '+ret.jenjurusan);
                $('.mdl-verifikasi #jabatan').html(ret.jabatan);
                $('.mdl-verifikasi #skpd').html(ret.path);
                $('.mdl-verifikasi #id_edit1').val(ret.idusul);
                $('.mdl-verifikasi #id_edit2').val(ret.nip);
                $('.mdl-verifikasi #tglusul').val(ret.tglusul_);
                $('.mdl-verifikasi #keterangan').val(ret.keterangan);
                $('.mdl-verifikasi #statussk').val(ret.statussk).trigger('change');
                $('.mdl-verifikasi #statususul').trigger('change');

                <?php if(session('role_id') <= 3) { ?>
                    $('.mdl-verifikasi #statususul').select2('val',ret.statususul);
                    $('.mdl-verifikasi #idpemerintah').select2('val',ret.idpemerintah);
                <?php } ?>
                
                $('.mdl-verifikasi #provinsi').val(ret.provinsi);
                $('.mdl-verifikasi #kabupaten').val(ret.kabupaten);
                $('.mdl-verifikasi #instansi').val(ret.instansi);
                $('.mdl-verifikasi #noskpermintaan').val(ret.noskpermintaan);
                $('.mdl-verifikasi #tglskpermintaan').val(ret.tglskpermintaan_);

                /*untuk preview status berkas*/
                $('.mdl-verifikasi .vtglusul').html(ret.tglusul_);
                $('.mdl-verifikasi .vprovinsi').html(ret.provinsi);
                $('.mdl-verifikasi .vkabupaten').html(ret.kabupaten);
                $('.mdl-verifikasi .vinstansi').html(ret.instansi);
                $('.mdl-verifikasi .vtglrujukan').html(ret.tglskpermintaan_);
                $('.mdl-verifikasi .vketmutasi').html(ret.keterangan);

                $('.mdl-verifikasi #ispengantar').attr('checked',((ret.ispengantar==1)?true:false));
                $('.mdl-verifikasi #ispermohonan').attr('checked',((ret.ispermohonan==1)?true:false));
                $('.mdl-verifikasi #isskcpns').attr('checked',((ret.isskcpns==1)?true:false));
                $('.mdl-verifikasi #isskpns').attr('checked',((ret.isskpns==1)?true:false));
                $('.mdl-verifikasi #isskpkt').attr('checked',((ret.isskpkt==1)?true:false));
                $('.mdl-verifikasi #iskarpeg').attr('checked',((ret.iskarpeg==1)?true:false));
                $('.mdl-verifikasi #isdhr').attr('checked',((ret.isdhr==1)?true:false));
                $('.mdl-verifikasi #isspskpd').attr('checked',((ret.isspskpd==1)?true:false));
                $('.mdl-verifikasi #isijazah').attr('checked',((ret.isijazah==1)?true:false));
                $('.mdl-verifikasi #issnikah').attr('checked',((ret.issnikah==1)?true:false));
                $('.mdl-verifikasi #isskjabfung').attr('checked',((ret.isskjabfung==1)?true:false));

                $('.mdl-verifikasi input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);
                $('.mdl-verifikasi #nosk').val(ret.nosk);
                $('.mdl-verifikasi #tglsurat').val(ret.tglsurat_);
                $('.mdl-verifikasi #tmt').val(ret.tmt_);
                
                $('.mdl-verifikasi #nousul').val(ret.nousul);
                $('.mdl-verifikasi #no_sp').val(ret.no_sp);
                $('.mdl-verifikasi #tgl_sp').val(ret.tgl_sp);

                $('.mdl-verifikasi #kepalabkd').val(ret.kepalabkd);
                $('.mdl-verifikasi #nipkepalabkd').val(ret.nipkepalabkd);
                $('.mdl-verifikasi #pangkatbkd').val(ret.pangkatbkd);
                $('.mdl-verifikasi #bupati').val(ret.bupati);

                $('.mdl-verifikasi #kettms').val(ret.kettms);
                $('.mdl-verifikasi #ketbtl').val(ret.ketbtl);

                $('.mdl-verifikasi #nosk_persetujuan').val(ret.nosk_persetujuan);
                $('.mdl-verifikasi #tglsk_persetujuan').val(ret.tglsk_persetujuan_);
                $('.mdl-verifikasi #bupati').val(ret.bupati);
                /*$('.mdl-verifikasi #ditujukan_kepada').val(ret.ditujukan_kepada);
                $('.mdl-verifikasi #lokasi_ditujukan').val(ret.lokasi_ditujukan);*/
                $('.mdl-verifikasi #nosk_pengantar').val(ret.nosk_pengantar);
                $('.mdl-verifikasi #tglsk_pengantar').val(ret.tglsk_pengantar_);
                // $('.mdl-verifikasi #penetapsk_kanreg').val(ret.penetapsk_kanreg);
                $('.mdl-verifikasi #penetapsk_kanreg').select2('val',ret.penetapsk_kanreg);
                $('.mdl-verifikasi #nosk_kanreg').val(ret.nosk_kanreg);
                $('.mdl-verifikasi #tglsk_kanreg').val(ret.tglsk_kanreg_);
                // TMT BERLAKU, Atribut Tambahan
                $('.mdl-verifikasi #tmt_berlaku').val(ret.tmt_berlaku);
            }
        });

$('.mdl-verifikasi #ftampil1').hide();
$('.mdl-verifikasi #ftampil2').hide();
$('.mdl-verifikasi #ftampil3').hide();
$('.mdl-verifikasi #ftampil11').hide();
$('.mdl-verifikasi #ftampil12').hide();

$('.mdl-verifikasi #statususul').change(function(){
    if($('.mdl-verifikasi #statususul').val() == 1){
        $('.mdl-verifikasi #ftampil1').show();
        $('.mdl-verifikasi #ftampil2').hide();
        $('.mdl-verifikasi #ftampil3').hide();

        $('.mdl-verifikasi #statussk').change(function(){
            if($('.mdl-verifikasi #statussk').val() == 1){
                $('.mdl-verifikasi #ftampil11').show();
                $('.mdl-verifikasi #ftampil12').hide();
            }else if($('.mdl-verifikasi #statussk').val() == 2){
                $('.mdl-verifikasi #ftampil11').hide();
                $('.mdl-verifikasi #ftampil12').show();
            }else{
                $('.mdl-verifikasi #ftampil11').hide();
                $('.mdl-verifikasi #ftampil12').hide();
            }
        }).trigger('change');
    }else if($('.mdl-verifikasi #statususul').val() == 2){
        $('.mdl-verifikasi #ftampil1').hide();
        $('.mdl-verifikasi #ftampil2').show();
        $('.mdl-verifikasi #ftampil3').hide();
        $('.mdl-verifikasi #ftampil11').hide();
        $('.mdl-verifikasi #ftampil12').hide();
    }else if($('.mdl-verifikasi #statususul').val() == 3){
        $('.mdl-verifikasi #ftampil1').hide();
        $('.mdl-verifikasi #ftampil2').hide();
        $('.mdl-verifikasi #ftampil3').show();
        $('.mdl-verifikasi #ftampil11').hide();
        $('.mdl-verifikasi #ftampil12').hide();
    }else{
        $('.mdl-verifikasi #ftampil1').hide();
        $('.mdl-verifikasi #ftampil2').hide();
        $('.mdl-verifikasi #ftampil3').hide();
        $('.mdl-verifikasi #ftampil11').hide();
        $('.mdl-verifikasi #ftampil12').hide();
    }
}).trigger('change');
$('.mdl-verifikasi #fpilpem').hide();
$('.mdl-verifikasi #fpilpemx').hide();

$('.mdl-verifikasi #idpemerintah').change(function(){
    var jos = $('.mdl-verifikasi #idpemerintah').val();
    if(jos == 1 ||  jos == 2 || jos == 3){
        $('.mdl-verifikasi #fpilpem').show();
        $('.mdl-verifikasi #fpilpemx').hide();
    }else{
        $('.mdl-verifikasi #fpilpem').hide();
        $('.mdl-verifikasi #fpilpemx').show();
    }
}).trigger('change');

$('.mdl-verifikasi').on('submit',function(e){
    var $this = $(this);
    e.preventDefault();
    bootbox.confirm('Verifikasi Luar Daerah ?',function(a){
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

<form id="form2" name="form2" class="form-horizontal mdl-verifikasi" action="{!!url()!!}/emutasi/nominatifluarkabupaten/verifikasi" class="" method="post" enctype="multipart/form-data">

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

            <div class="head-line">
                <h4><i class="fa fa-fw fa-check"></i> CEKLIST BERKAS</h4>
            </div></br>
            <div class="form-group">
                <label class="col-sm-3 control-label">Ceklist Berkas</label>
                <div class="col-sm-7">
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="ispengantar" id="ispengantar" value="1"> Surat Pengantar SKPD</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="ispermohonan" id="ispermohonan" value="1"> Surat Permohonan YBS </label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskcpns" id="isskcpns" value="1"> SK CPNS</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskpns" id="isskpns" value="1"> SK PNS</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskpkt" id="isskpkt" value="1"> SK Pangkat Terakhir</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="iskarpeg" id="iskarpeg" value="1"> Karpeg</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isdhr" id="isdhr" value="1"> DHR</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isspskpd" id="isspskpd" value="1"> DP/SKPD</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isijazah" id="isijazah" value="1"> Ijazah Terakhir</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="issnikah" id="issnikah" value="1"> Surat Nikah (Bagi yang ikut suami)</label>
                    <label class="checkbox"> <input type="checkbox" <?php echo ((session('role_id') > 3)?'disabled':'')?> name="isskjabfung" id="isskjabfung" value="1"> SK Jabatan Fungsional</label>
                </div>
            </div>

        </div>

        <?php if(session('role_id') <= 3) { ?>
            <div class="col-md-6">
                <div class="head-line">
                    <h4><i class="fa fa-fw fa-paper-plane-o"></i> MUTASI LUAR DAERAH</h4>
                </div></br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nomor Usulan</label>
                    <div class="col-sm-7">
                        <input type="text" name="nousul" class="form-control" id='nousul' placeholder="Nomor Surat Pengantar" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal Usulan</label>
                    <div class="col-sm-7">
                        <input type="text" name="tglusul" class="tmt form-control" id='tglusul' placeholder='dd-mm-yyyy' readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Nomor SP</label>
                    <div class="col-sm-7">
                        <input type="text" name="no_sp" class="form-control" id='no_sp' placeholder="Nomor Surat Pengantar">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal SP</label>
                    <div class="col-sm-7">
                        <input type="text" name="tgl_sp" class="tmt form-control" id='tgl_sp' placeholder='dd-mm-yyyy'>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Kementarian/Lembaga/Daerah (K/L/D)</label>
                    <div class="col-sm-7">
                        {!!NominatifluarkabupatenModel::comboPemerintah("idpemerintah","","")!!}
                    </div>
                </div>
                <div id='fpilpem'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi Pindah</label>
                        <div class="col-sm-7">
                            <input type="text" name="provinsi" id="provinsi"  class="input-large form-control" placeholder="Provinsi Pindah">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Kab/Kota Pindah</label>
                    <div class="col-sm-7">
                        <input type="text" name="kabupaten" id="kabupaten"  class="input-large form-control" placeholder="Kabupaten Pindah">
                    </div>
                </div>
                <div id='fpilpemx'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Lembaga</label>
                        <div class="col-sm-7">
                            <input type="text" name="instansi" id="instansi"  class="input-large form-control" placeholder="Lembaga Pindah">
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
                    <label class="col-sm-3 control-label">Status Berkas</label>
                    <div class="col-sm-7">
                        <select id="statususul" name="statususul" class="input-large form-control" required>
                            <option value="0">.: Status Usulan :.</option>
                            <option value="1">Memenuhi Syarat</option>
                            <option value="2">Tidak Memenuhi Syarat</option>
                            <option value="3">Berkas Tidak Lengkap</option>
                        </select>
                    </div>
                </div>

                <div id='ftampil1'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status Proses</label>
                        <div class="col-sm-7">
                            <select id="statussk" name="statussk" class="input-large form-control" required>
                                <option value="0">.: PILIHAN :.</option>
                                <option value="2">Dalam Proses</option>
                                <option value="1">Proses Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="ftampil12">
                    <div class="head-line">
                        <h4><i class="fa fa-fw fa-pencil"></i> SURAT PERSETUJUAN</h4> <em style="font-size: 13px">(* Kosongkan jika Surat belum diproses.)</em>
                    </div></br>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nosk_persetujuan">Nomor Surat Persetujuan</label>
                        <div class="col-sm-7">
                            <input type="text" class="input-large form-control" name="nosk_persetujuan" id="nosk_persetujuan" placeholder="Nomor Surat Persetujuan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tglsk_persetujuan">Tanggal Surat Persetujuan</label>
                        <div class="col-sm-7">
                            <input type="text" class="input-large tmt form-control" name="tglsk_persetujuan" id="tglsk_persetujuan" placeholder="dd-mm-yyyy" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bupati">Bupati Kendal (Penetap)</label>
                        <div class="col-sm-7">
                            <input type="text" class="input-large form-control" name="bupati" id="bupati" placeholder="Nama Bupati / Penetap">
                        </div>
                    </div>

                    <!-- <div class="head-line">
                        <h4><i class="fa fa-fw fa-pencil"></i> Surat Menghadapkan</h4> <em style="font-size: 13px">(* Kosongkan jika Surat Menghadapkan belum diproses.)</em>
                    </div></br>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nosk">Nomor Surat Menghadapkan</label>
                        <div class="col-sm-7">
                            <input type="text" class="input-large form-control" name="nosk_pengantar" id="nosk_pengantar" placeholder="Nomor Surat Menghadapkan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tglsurat">Tanggal Surat Menghadapkan</label>
                        <div class="col-sm-7">
                            <input type="text" class="input-large tmt form-control" name="tglsk_pengantar" id="tglsk_pengantar" placeholder="dd-mm-yyyy" value="">
                        </div>
                    </div> -->

                    <div class="head-line">
                        <h4><i class="fa fa-fw fa-pencil"></i> SK Mutasi</h4> <em style="font-size: 13px">(* Kosongkan jika SK belum diproses.)</em>
                    </div></br>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="penetapsk_kanreg">Penetap SK Referensi</label>
                        <!-- <input type="text" class="input-large form-control" name="penetapsk_kanreg" id="penetapsk_kanreg" placeholder="Ex: Kepala Kanreg i Badan Kepegawaian Negara "> -->
                        <div class="col-sm-7">
                                <!-- <select id="penetapsk_kanreg" name="penetapsk_kanreg" class="input-large form-control" required>
                                    <option value="Kepala Badan Kepegawaian Negara">Kepala Badan Kepegawaian Negara</option>
                                    <option value="Kepala Kanreg I Badan Kepegawaian Negara">Kepala Kanreg I Badan Kepegawaian Negara</option>
                                    <option value="Gubernur Jawa Tengah">Gubernur Jawa Tengah</option>
                                </select> -->
                                {!!comboPenMutLuar("penetapsk_kanreg","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="nosk_kanreg">Nomor SK Referensi</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large form-control" name="nosk_kanreg" id="nosk_kanreg" placeholder="Nomor SK Referensi">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tglsk_kanreg">Tanggal SK Referensi</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large tmt form-control" name="tglsk_kanreg" id="tglsk_kanreg" placeholder="dd-mm-yyyy" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tglsurat">TMT SK Mutasi</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large tmt form-control" name="tmt_berlaku" id="tmt_berlaku" placeholder="dd-mm-yyyy" value="">
                            </div>
                        </div>
                    </div>

                    <div id="ftampil11">
                        <div class="form-group">
                            <!-- <label class="col-sm-3 control-label" for="nosk">Nomor SK</label> -->
                            <label class="col-sm-3 control-label" for="nosk">Nomor Surat Menghadapkan</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large form-control" name="nosk" id="nosk" placeholder="Nomor SK Mutasi">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- <label class="col-sm-3 control-label" for="tglsurat">Tanggal SK</label> -->
                            <label class="col-sm-3 control-label" for="tglsurat">Tanggal Surat Menghadapkan</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large tmt form-control" name="tglsurat" id="tglsurat" placeholder="dd-mm-yyyy" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- <label class="col-sm-3 control-label" for="tmt">Tanggal Berlaku</label> -->
                            <label class="col-sm-3 control-label" for="tmt">TMT Berlaku</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large tmt form-control" name="tmt" id="tmt" placeholder="dd-mm-yyyy" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="kepalabkd">Pejabat Penetap</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large form-control" name="kepalabkd" id="kepalabkd" placeholder="Pejabat Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="nipkepalabkd">NIP Penetap</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large form-control" name="nipkepalabkd" id="nipkepalabkd" placeholder="NIP Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pangkatbkd">Pangkat Penetap</label>
                            <div class="col-sm-7">
                                <input type="text" class="input-large form-control" name="pangkatbkd" id="pangkatbkd" placeholder="Pangkat Penetap">
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

                    </div>

                    <div id="ftampil2">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-7">
                                <textarea rows="150" cols="6" class="form-control" name="kettms" id="kettms" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="ftampil3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-7">
                                <textarea rows="150" cols="6" class="form-control" name="ketbtl" id="ketbtl" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>
                            </div>
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

            <?php } else { ?>
                <div class="col-md-6">
                    <div class="head-line">
                        <h4>Mutasi Luar Daerah</h4>
                    </div><br>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Usulan</label>
                        <div class="col-sm-7">
                            <span class="vtglusul"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi Pindah</label>
                        <div class="col-sm-7">
                            <span class="vprovinsi"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kabupaten Pindah</label>
                        <div class="col-sm-7">
                            <span class="vkabupaten"></span>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Instansi</label>
                        <div class="col-sm-7">
                            <span class="vinstansi"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Rujukan</label>
                        <div class="col-sm-7">
                            <span class="vtglrujukan"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan Mutasi</label>
                        <div class="col-sm-7">
                            <span class="vketmutasi"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status Proses</label>
                        <div class="col-sm-7">
                            <?php
                            $item = \DB::table('tr_mutasi_luar_daerah')->where(array('nip'=>Input::get("nip"), 'idusul'=>Input::get("id")))->first();
                            if($item->statususul==1){
                                echo '<span style="color:green"><i class="fa fa-check-circle"/></span> Memenuhi Syarat';
                            }else if($item->statususul==2){
                                echo '<span style="color:red"><i class="fa fa-times-circle"/></span> Tidak Memenuhi Syarat';
                            }else if($item->statususul==3){
                                echo '<span style="color:orange"><i class="fa fa-info-circle"/></span> Berkas Tidak Lengkap';
                            }else{
                                echo 'Belum ada tanggapan.';
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if($item->statususul==1){
                        if($item->statususul=='1' && $item->statussk=='2'){
                            echo '<div class="form-group">
                            <label class="col-sm-3 control-label">Status Berkas</label>
                            <div class="col-sm-7">
                            <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses
                            </div>
                            </div>';
                        }else if($item->statussk=='1'){
                            echo '<div class="form-group">
                            <label class="col-sm-3 control-label">Status Berkas</label>
                            <div class="col-sm-7">
                            <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses
                            </div>
                            </div>';

                            if($item->iscetaksk == 1){
                                echo '<div class="form-group">
                                <label class="col-sm-3 control-label">Status SPT</label>
                                <div class="col-sm-7">
                                <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                </div>
                                </div>';
                            }else if($item->iscetaksk == 2){
                                echo '<div class="form-group">
                                <label class="col-sm-3 control-label">Status SPT</label>
                                <div class="col-sm-7">
                                <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak SK"/></span> SK Dibatalkan
                                </div>
                                </div>';
                            }
                        }
                    } else if($item->statususul==2){
                        echo '<div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-7">
                        <span style="color:red"><i class="fa fa-times-circle"/></span> '.$item->kettms.'
                        </div>
                        </div>';
                    }else if($item->statususul==3){
                        echo '<div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-7">
                        <span style="color:orange"><i class="fa fa-info-circle"/></span> '.$item->ketbtl.'
                        </div>
                        </div>';
                    }
                } 
                ?>
            </div>

        </form>