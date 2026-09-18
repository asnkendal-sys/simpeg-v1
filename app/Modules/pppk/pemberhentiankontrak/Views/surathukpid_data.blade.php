<?php
    $idskpd = Input::get('idskpd');
    $bup = Input::get('bup');
    $nip = Input::get('nip');    

    $where = " sts_kontrak = 3 and nip = \"".$nip."\" and bup = \"".$bup."\" and idskpd like \"".$idskpd."%\"";

    $rs = \DB::table('tr_pppk')->whereRaw($where)->orderBy('nip', 'desc');
    if($rs->count() > 0){
        $jml = $rs->count();
        $item = $rs->first();
    }else{
        echo "Data nominatif tidak tersedia";
        exit();
    }
?>

<style>
    .hidden{
        display: none;
    }
    .show{
        display: block;
    }
</style>
<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/pppk/pemberhentiankontrak/surathukpid" target="_blank" accept-charset="UTF-8">

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
                    <input type="hidden" name="nip" id="nip" value="{!!$nip!!}">
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
                    <div class="form-group hidden" id="no_srthukdis">
                        <label class="col-sm-3 control-label">Nomor Surat</label>
                        <div class="controls col-sm-7"> <!--nambah field hukpid,no_hukdis_opd dan no_pidana_opd, no_hukpid blm dihapus-->
                            <input type="text" name="no_hukdis_opd" id="no_hukdis_opd" class="form-control" placeholder="No Surat" value="<?php echo ($item->no_hukdis_opd=='')?'800.1.6.6/':$item->no_hukdis_opd?>">
                        </div>
                    </div>
                    <div class="form-group hidden" id="no_srtpidana">
                        <label class="col-sm-3 control-label">Nomor Surat</label>
                        <div class="controls col-sm-7"> <!--nambah field no_hukdis_opd dan no_pidana_opd-->
                            <input type="text" name="no_pidana_opd" id="no_pidana_opd" class="form-control" placeholder="No Surat" value="<?php echo ($item->no_pidana_opd=='')?'800.1.6.6/':$item->no_pidana_opd?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="tgl_hukpid_opd" id="tgl_hukpid_opd" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo ($item->tgl_hukpid_opd=='0000-00-00' or $item->tgl_hukpid_opd=='')?date('d-m-Y'):tglina($item->tgl_hukpid_opd)?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIP Penetap</label>
                        <div class="controls col-sm-7">
                            <select name="nippen_hukpid" class="form-control nippen_hukpid" id="nippen_hukpid" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Jabatan</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control jabpen_hukpid" name="jabpen_hukpid" id="jabpen_hukpid" placeholder="Nama Jabatan" value="<?php echo ($item->jabpen_hukpid!='')?$item->jabpen_hukpid:getKepskpd($idskpd, 'jab')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pejabat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pejpen_hukpid" name="pejpen_hukpid" id="pejpen_hukpid" placeholder="Pejabat Penetap" value="<?php echo ($item->pejpen_hukpid!='')?$item->pejpen_hukpid:getKepskpd($idskpd, 'nama')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pangkat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control golpen_hukpid" name="golpen_hukpid" id="golpen_hukpid" placeholder="Pangkat" value="<?php echo ($item->golpen_hukpid!='')?$item->golpen_hukpid:getKepskpd($idskpd, 'pangkat')?>">
                        </div>
                    </div>
                    <!-- tak tambahin ini biar nanti bisa keprint, ga kosong -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Golongan Ruang Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pangpen_hukpid" name="pangpen_hukpid" id="pangpen_hukpid" placeholder="Golongan Ruang" value="<?php echo ($item->pangpen_hukpid!='')?$item->pangpen_hukpid:getKepskpd($idskpd, 'golru')?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls col-sm-12">
                            <button class="btn btn-success" name="acthukdisopd" id="tombol_hukdis" type="submit" value="1" hidden="hidden"><i class="fa fa-print"></i> Hukdis</button>
                            <button class="btn btn-success" name="actpidanaopd" id="tombol_pidana" type="submit" value="1" hidden="hidden"><i class="fa fa-print"></i> Pidana</button>
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
        $('#tombol_hukdis, #tombol_pidana').hide();
        $("#hukpid").change(function() {
            console.log($("#hukpid option:selected").val());
            if ($("#hukpid option:selected").val() == '1') {
                $('#no_srthukdis').removeClass("hidden");
                $('#no_srthukdis').addClass("show");

                $('#no_srtpidana').removeClass("show");
                $('#no_srtpidana').addClass("hidden");

                $('#tombol_hukdis').show();
                $('#tombol_pidana').hide();
            }else if($("#hukpid option:selected").val() == '2'){
                $('#no_srtpidana').removeClass("hidden");
                $('#no_srtpidana').addClass("show");

                $('#no_srthukdis').removeClass("show");
                $('#no_srthukdis').addClass("hidden");

                $('#tombol_hukdis').hide();
                $('#tombol_pidana').show();
            }else {
                $('#no_srthukdis').removeClass("show");
                $('#no_srthukdis').addClass("hidden");

                $('#no_srtpidana').removeClass("show");
                $('#no_srtpidana').addClass("hidden");

                $('#tombol_hukdis, #tombol_pidana').hide();
            }
        }).trigger('change');
        //
        $('.piluptd,.checkmeall').on('change',function(){
            $(this).is(':checked');
        });

        $('.tmt, .date').mask("99-99-9999");

        //
        var jikaNipHukpid = "{!! ($item->nippen_hukpid!='')?$item->nippen_hukpid:getKepskpd($idskpd, 'nip') !!}";
        autoCompleteimg('.nippen_hukpid', '{{url()}}/epensiun/nominatifpensiun/caripegawai', '.: Pilihan :.', null, jikaNipHukpid, jikaNipHukpid, '');

        $(".nippen_hukpid").on('change', function(e){
				e.preventDefault();
				var nipatasan = $(".nippen_hukpid").val();
                console.log(nipatasan);
				if (nipatasan != null) {
					$.ajax({
						url: '{{url()}}/epensiun/nominatifpensiun/detailpegawai',
						type: 'post',
						data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);

							$(".pejpen_hukpid").val(ret.nama);
							$(".jabpen_hukpid").val(ret.jab);
							$(".golpen_hukpid").val(ret.pangkat);
							$(".pangpen_hukpid").val(ret.golru);

						}
					});
				}
			}).trigger('change');
        //
    });
</script>