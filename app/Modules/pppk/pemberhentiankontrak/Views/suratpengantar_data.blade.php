<?php        
    $bup = Input::get('bup');
    $idskpd = Input::get('idskpd');
    $where = "sts_kontrak = 3 and bup = \"".$bup."\" and idskpd like \"".$idskpd."%\"";

    $attr = \NominatifpensiunModel::attrPengantar($idskpd);
    $rs = \DB::table('tr_pppk')->whereRaw($where)->orderBy('nip', 'desc');
    if($rs->count() > 0){
        $jml = $rs->count();
        $item = $rs->first();
    }else{
        echo "Data nominatif tidak tersedia";
        exit();
    }
?>

<div class="callout callout-success">
    <h4><i class="fa fa-info-circle"></i> PERHATIAN !</h4>
    <ul style="padding-left: 15px">        
        <li>Setelah melakukan input nomor dan tanggal sk pengantar, data yang disusulkan tidak dapat dilakukan perubahan</li>
        <li>Patikan semua usulan sudah benar dan sesuai dengan persyaratan.</li>
    </ul>    
</div>

<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/pppk/pemberhentiankontrak/suratpengantar" target="_blank" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> ATRIBUT SURAT PENGANTAR </h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 data-biodata">
                    {!!csrf_field()!!}
                    <input type="hidden" name="bup" id="bup" value="{!!$bup!!}">
                    <input type="hidden" name="idskpd" id="idskpd" value="{!!$idskpd!!}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Surat Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="nosk_pengantar" id="nosk_pengantar" class="form-control" placeholder="No Surat Pengantar" value="<?php echo ($item->nosk_pengantar=='')?'822.3/...../'.date('Y'):$item->nosk_pengantar?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Banyak Berkas</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="berkas_pengantar" id="berkas_pengantar" class="form-control" placeholder="Jumlah berkas" readonly value="<?php echo ($item->berkas_pengantar=='0')?$jml:$item->berkas_pengantar?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="tgl_skpengantar" id="tgl_skpengantar" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo ($item->tgl_skpengantar=='0000-00-00')?date('d-m-Y'):tglina($item->tgl_skpengantar)?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIP Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <select name="nippen_sp" class="form-control nippen_sp" id="nippen_sp" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Jabatan Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control jabpen_sp" name="jabpen_sp" id="jabpen_sp" placeholder="Nama Jabatan Pengantar" value="<?php echo ($item->jabpen_sp!='')?$item->jabpen_sp:(strtoupper((count($attr)!='')?$attr->jab:'')."".((strlen($idskpd)>2)?" ".strtoupper(getSkpdgroup(substr($idskpd,0,2))):''))?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pejabat Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control pejpen_sp" name="pejpen_sp" id="pejpen_sp" placeholder="Pejabat Penetap Pengantar" value="<?php echo ($item->pejpen_sp!='')?$item->pejpen_sp:((count($attr)!='')?$attr->nama:'')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pangkat Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control golpen_sp" name="golpen_sp" id="golpen_sp" placeholder="Golongan Ruang Pengantar" value="<?php echo ($item->golpen_sp!='')?$item->golpen_sp:(ucword((count($attr)!='')?$attr->pangkat:''))?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-7">
                            <button class="btn btn-success" name="actpengantar" type="submit" value="1"><i class="fa fa-print"></i> Pengantar</button>
                            <button class="btn btn-success" name="actnominatif" type="submit" value="1"><i class="fa fa-print"></i> Nominatif</button>                            
                            {{-- <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal');"></i> Batalkan</button> --}}
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
        $('.tmt, .date').mask("99-99-9999");

        var jikaNipSp = "{!! ($item->nippen_sp!='')?$item->nippen_sp:((count($attr)!='')?$attr->nip:'') !!}";
        autoCompleteimg('.nippen_sp', '{{url()}}/epensiun/nominatifpensiun/caripegawai', ".: Pilihan :.", null, jikaNipSp, jikaNipSp, '');

        $(".nippen_sp").on('change', function(e){
            e.preventDefault();
            var nipatasan = $(".nippen_sp").val();
            if (nipatasan != null) {
                $.ajax({
                    url: '{{url()}}/epensiun/nominatifpensiun/detailpegawai',
                    type: 'post',
                    data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
                    success:function(response){
                        var ret = $.parseJSON(response);

                        $(".pejpen_sp").val(ret.nama);
                        $(".jabpen_sp").val(ret.jab);
                        $(".golpen_sp").val(ret.pangkat);

                    }
                });
            }
        }).trigger('change');
    });
</script>