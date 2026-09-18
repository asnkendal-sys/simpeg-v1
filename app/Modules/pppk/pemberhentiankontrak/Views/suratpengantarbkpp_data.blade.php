<?php
    $idskpd = Input::get('idskpd');
    $bup = Input::get('bup');
    $nip = Input::get('nip');    

    $where = "sts_kontrak = 3 and nip = \"".$nip."\" and  bup = \"".$bup."\" and idskpd like \"".$idskpd."%\"";

    $rs = \DB::table('tr_pppk')->whereRaw($where)->orderBy('nip', 'desc');
    if($rs->count() > 0){
        $jml = $rs->count();
        $item = $rs->first();
    }else{
        echo "Data nominatif tidak tersedia";
        exit();
    }
?>

<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/pppk/pemberhentiankontrak/suratpengantarbkpp" target="_blank" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> ATRIBUT SURAT </h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 data-biodata">
                    {!!csrf_field()!!}
                    <input type="hidden" name="bup" id="jnskgb" value="{!!$bup!!}">
                    <input type="hidden" name="idskpd" id="idskpd" value="{!!$idskpd!!}">
                    <input type="hidden" name="nip" id="idskpd" value="{!!$nip!!}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Surat</label>
                        <div class="controls col-sm-7">
                            <select id="hukpid" name="hukpid" class="form-control">
                                <option value="">.: Jenis Surat :.</option>
                                <option value="1" >Hukuman Disiplin</option>
                                <option value="2" >Pidana</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden" id="noskpens_hukdis">
                        <label class="col-sm-3 control-label">Nomor Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="no_hukdis_bkd" id="no_hukdis_bkd" class="form-control" placeholder="No Surat" value="<?php echo ($item->no_hukdis_bkd=='')?'800.1.6.6/':$item->no_hukdis_bkd?>">
                        </div>
                    </div>
                    <div class="form-group hidden" id="noskpens_pidana">
                        <label class="col-sm-3 control-label">Nomor Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="no_pidana_bkd" id="no_pidana_bkd" class="form-control" placeholder="No Surat" value="<?php echo ($item->no_pidana_bkd=='')?'800.1.6.6/':$item->no_pidana_bkd?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="tgl_hukpid_bkd" id="tgl_hukpid_bkd" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo ($item->tgl_hukpid_bkd=='0000-00-00' or $item->tgl_hukpid_bkd=='')?date('d-m-Y'):tglina($item->tgl_hukpid_bkd)?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIP Penetap</label>
                        <div class="controls col-sm-7">
                            <select name="nipkepalabkd" class="form-control nipkepalabkd" id="nipkepalabkd" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Jabatan</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control jabkepalabkd" name="jabkepalabkd" id="jabkepalabkd" placeholder="Nama Jabatan" value="<?php echo ($item->jabkepalabkd!='')?$item->jabkepalabkd:getKepskpd($idskpd, 'jab')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pejabat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control kepalabkd" name="kepalabkd" id="kepalabkd" placeholder="Pejabat Penetap" value="<?php echo ($item->kepalabkd!='')?$item->kepalabkd:getKepskpd($idskpd, 'nama')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pangkat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pangkatbkd" name="pangkatbkd" id="pangkatbkd" placeholder="Pangkat" value="<?php echo ($item->pangkatbkd!='')?$item->pangkatbkd:getKepskpd($idskpd, 'pangkat')?>">
                        </div>
                    </div>
                    <!-- tak tambahin ini biar nanti bisa keprint, ga kosong -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Golongan Ruang Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control golrubkd" name="golrubkd" id="golrubkd" placeholder="Golongan Ruang" value="<?php echo ($item->golrubkd!='')?$item->golrubkd:getKepskpd($idskpd, 'golru')?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls col-sm-12">
                            <button class="btn btn-success" name="acthukdisbkpp" id="tombol_hukdis" type="submit" value="1" hidden="hidden"><i class="fa fa-print"></i> Hukdis</button>
                            <button class="btn btn-success" name="actpidanabkpp" id="tombol_pidana" type="submit" value="1" hidden="hidden"><i class="fa fa-print"></i> Pidana</button>
                            <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal');"></i> Batalkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.piluptd,.checkmeall').on('change',function(){
            $(this).is(':checked');
        });

        $('.tmt, .date').mask("99-99-9999");

        $('#tombol_hukdis, #tombol_pidana').hide();
        $("#hukpid").change(function() {
            console.log($("#hukpid option:selected").val());
            if ($("#hukpid option:selected").val() == '1') {
                $('#noskpens_hukdis').removeClass("hidden");
                $('#noskpens_hukdis').addClass("show");

                $('#noskpens_pidana').removeClass("show");
                $('#noskpens_pidana').addClass("hidden");

                $('#tombol_hukdis').show();
                $('#tombol_pidana').hide();
            }else if($("#hukpid option:selected").val() == '2'){
                $('#noskpens_pidana').removeClass("hidden");
                $('#noskpens_pidana').addClass("show");

                $('#noskpens_hukdis').removeClass("show");
                $('#noskpens_hukdis').addClass("hidden");

                $('#tombol_hukdis').hide();
                $('#tombol_pidana').show();
            }else {
                $('#noskpens_hukdis').removeClass("show");
                $('#noskpens_hukdis').addClass("hidden");

                $('#noskpens_pidana').removeClass("show");
                $('#noskpens_pidana').addClass("hidden");

                $('#tombol_hukdis, #tombol_pidana').hide();
            }
        }).trigger('change');

        //
        var jikaNipHukpid = "{!! ($item->nipkepalabkd!='')?$item->nipkepalabkd:'' !!}";
        autoCompleteimg('.nipkepalabkd', '{{url()}}/epensiun/nominatifpensiun/caripegawai', value="<?php echo ($item->nipkepalabkd!='')?$item->nipkepalabkd:getKepskpd($idskpd, 'nip')?>", null, jikaNipHukpid, jikaNipHukpid, '');

        $(".nipkepalabkd").on('change', function(e){
				e.preventDefault();
				var nipatasan = $(".nipkepalabkd").val();
                console.log(nipatasan);
				if (nipatasan != null) {
					$.ajax({
						url: '{{url()}}/epensiun/nominatifpensiun/detailpegawai',
						type: 'post',
						data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);

							$(".kepalabkd").val(ret.nama);
							$(".jabkepalabkd").val(ret.jab);
							$(".pangkatbkd").val(ret.pangkat);
							$(".golrubkd").val(ret.golru);

						}
					});
				}
			}).trigger('change');
        //
    });
</script>