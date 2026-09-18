<?php
    $nousul = Input::get('nousul');
    $rs = \DB::table("tr_mutasi_pengangkatan")->where('nousul', $nousul);

    if($rs->count() > 0){
        $jml = $rs->count();
        $row = $rs->first();
    }else{
        echo "Data tidak ditemukan.";
    }
?>

<script>

    $(document).ready(function() {
        $(".tmt").mask("99-99-9999");
    });

</script>

<div class="row" style="padding-left: 35px;">
    <div class="span12">
        <form id="form2" name="form2" class="form-horizontal" action="{!!url()!!}/emutasi/nominatifpengangkatan/cetak/nominatifpengangkatan" target="_blank" class="" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" id="nousul" name="nousul" value="<?php echo $nousul?>" />
            <input type="hidden" id="idskpd" name="idskpd" value="<?php echo substr($row->idskpd,0,2)?>" />

            <div class="row">

                <div class="head-line">
                    <h4><i class="fa fa-fire"></i> Formulir Dokumen Nominatif Checklist Bupati</h4>
                </div></br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nomor Surat Pengantar </label>
                    <div class="col-sm-7">
                        <input type="text" name="no_sp" id="no_sp" class="input-medium form-control" placeholder="No Surat Pengantar" value="<?php echo ($row->no_sp=='')?'822.3/...../'.date('Y'):$row->no_sp?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal Surat </label>
                    <div class="col-sm-7">
                        <input type="text" name="tgl_sp" id="tgl_sp" class="tmt input-medium form-control" placeholder="dd-mm-yyyy" value="<?php echo ($row->tgl_sp=='0000-00-00')?date('d-m-Y'):tglina($row->tgl_sp)?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp; </label>
                    <div class="col-sm-7">
                        <button class="btn btn-primary" type="submit">Cetak</button>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>

<script>

    $(document).ready(function() {
        $(".tmt").mask("99-99-9999");
    });

</script>