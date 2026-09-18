<?php
    $nousul = Input::get('id');
    $rs = \DB::table("tr_mutasi_luar_daerah")->where('nousul', $nousul);

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
        <form id="form2" name="form2" class="form-horizontal" action="<?=url().'/emutasi/nominatifluarkabupaten/cetak/pengantar'?>" target="_blank" class="" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" id="nousul" name="nousul" value="<?php echo $nousul?>" />
            <input type="hidden" id="idskpd" name="idskpd" value="<?php echo substr($row->idskpd,0,2)?>" />

            <div class="row">

                <div class="head-line">
                    <h4><i class="fa fa-fire"></i> Formulir Dokumen pengantar</h4>
                </div></br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nomor Surat Pengantar </label>
                    <div class="col-sm-7">
                        <input type="text" name="no_sp" id="no_sp" class="input-medium form-control" placeholder="No Surat Pengantar" value="<?php echo ($row->no_sp=='')?'822.3/...../'.date('Y'):$row->no_sp?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Banyak Berkas </label>
                    <div class="col-sm-7">
                        <input type="text" name="berkas_sp" id="berkas_sp" class="input-mini form-control" placeholder="Jumlah berkas" value="<?php echo ($row->berkas_sp=='0')?$jml:$row->berkas_sp?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal Surat </label>
                    <div class="col-sm-7">
                        <input type="text" name="tgl_sp" id="tgl_sp" class="tmt input-medium form-control" placeholder="dd-mm-yyyy" value="<?php echo ($row->tgl_sp=='0000-00-00')?date('d-m-Y'):tglina($row->tgl_sp)?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="jabpengantar">Jabatan Penetap</label>
                    <div class="col-sm-7">
                        <input type="text" class="input-large form-control" name="jabpengantar" id="jabpengantar" placeholder="Pejabat Penetap" value="<?php echo ($row->jabpengantar!='')?$row->jabpengantar:''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="namapengantar">Nama Pengantar</label>
                    <div class="col-sm-7">
                        <input type="text" class="input-large form-control" name="namapengantar" id="namapengantar" placeholder="Nama Pengantar" value="<?php echo ($row->namapengantar!='')?$row->namapengantar:''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nippengantar">NIP Pengantar</label>
                    <div class="col-sm-7">
                        <input type="text" class="input-large form-control" name="nippengantar" id="nippengantar" placeholder="NIP Pengantar" value="<?php echo ($row->nippengantar!='')?$row->nippengantar:''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pangkatpengantar">Pangkat Pengantar</label>
                    <div class="col-sm-7">
                        <input type="text" class="input-large form-control" name="pangkatpengantar" id="pangkatpengantar" placeholder="Pangkat Pengantar" value="<?php echo ($row->pangkatpengantar!='')?$row->pangkatpengantar:''?>">
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