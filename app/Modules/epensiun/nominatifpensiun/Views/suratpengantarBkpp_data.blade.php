<?php
    $idskpd = Input::get('idskpd');
    $tmtpens = Input::get('tmtpens');
    $nip = Input::get('nip');

    $attr = \NominatifpensiunModel::attrPengantar($idskpd);

    $where = "nip = \"".$nip."\" and  tmtpens = \"".$tmtpens."\" and idskpdpens like \"".$idskpd."%\"";

    $rs = \DB::table('tr_pensiun')->whereRaw($where)->orderBy('nip', 'desc');
    if($rs->count() > 0){
        $jml = $rs->count();
        $item = $rs->first();
    }else{
        echo "Data nominatif tidak tersedia";
        exit();
    }
?>

<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/epensiun/nominatifpensiun/suratpengantarbkpp" target="_blank" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> ATRIBUT SURAT </h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 data-biodata">
                    {!!csrf_field()!!}
                    <input type="hidden" name="tmtpens" id="jnskgb" value="{!!$tmtpens!!}">
                    <input type="hidden" name="idskpdpens" id="idskpd" value="{!!$idskpd!!}">
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
                            <input type="text" name="nosk_hukdis" id="nosk_hukdis" class="form-control" placeholder="No Surat" value="<?php echo ($item->nosk_hukdis=='')?'800.1.6.6/':$item->nosk_hukdis?>">
                        </div>
                    </div>
                    <div class="form-group hidden" id="noskpens_pidana">
                        <label class="col-sm-3 control-label">Nomor Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="nosk_pidana" id="nosk_pidana" class="form-control" placeholder="No Surat" value="<?php echo ($item->nosk_pidana=='')?'800.1.6.6/':$item->nosk_pidana?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Surat</label>
                        <div class="controls col-sm-7">
                            <!--<input type="text" name="tgskpens" id="tgskpens" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo ($item->tgskpens=='0000-00-00')?date('d-m-Y'):tglina($item->tgskpens)?>">-->
                            <input type="text" name="tgskpens" id="tgskpens" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIP Penetap</label>
                        <div class="controls col-sm-7">
                            <select name="nippenpens" class="form-control nippenpens" id="nippenpens" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Jabatan</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control jabpenpens" name="jabpenpens" id="jabpenpens" placeholder="Nama Jabatan" value="<?php echo ($item->jabpenpens!='')?$item->jabpenpens:(strtoupper((count($attr)!='')?$attr->jab:'')."".((strlen($idskpd)>2)?" ".strtoupper(getSkpdgroup(substr($idskpd,0,2))):''))?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pejabat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pejpenpens" name="pejpenpens" id="pejpenpens" placeholder="Pejabat Penetap" value="<?php echo ($item->pejpenpens!='')?$item->pejpenpens:((count($attr)!='')?$attr->nama:'')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pangkat Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pangkatpenpens" name="pangkatpenpens" id="pangkatpenpens" placeholder="Pangkat" value="<?php echo ($item->pangkatpenpens!='')?$item->pangkatpenpens:(ucword((count($attr)!='')?$attr->pangkat:''))?>">
                        </div>
                    </div>
                    <!-- tak tambahin ini biar nanti bisa keprint, ga kosong -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Golongan Ruang Penetap</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control golrupenpens" name="golrupenpens" id="golrupenpens" placeholder="Golongan Ruang" value="<?php echo ($item->golrupenpens!='')?$item->golrupenpens:(ucword((count($attr)!='')?$attr->golru:''))?>">
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
        var jikaNipHukpid = "{!! ($item->nippenpens!='')?$item->nippenpens:'' !!}";
        autoCompleteimg('.nippenpens', '{{url()}}/epensiun/nominatifpensiun/caripegawai', value="<?php echo ($item->nippenpens!='')?$item->nippenpens:((count($attr)!='')?$attr->nip:'')?>", null, jikaNipHukpid, jikaNipHukpid, '');

        $(".nippenpens").on('change', function(e){
				e.preventDefault();
				var nipatasan = $(".nippenpens").val();
                console.log(nipatasan);
				if (nipatasan != null) {
					$.ajax({
						url: '{{url()}}/epensiun/nominatifpensiun/detailpegawai',
						type: 'post',
						data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);

							$(".pejpenpens").val(ret.nama);
							$(".jabpenpens").val(ret.jab);
							$(".pangkatpenpens").val(ret.pangkat);
							$(".golrupenpens").val(ret.golru);

						}
					});
				}
			}).trigger('change');
        //
    });
</script>