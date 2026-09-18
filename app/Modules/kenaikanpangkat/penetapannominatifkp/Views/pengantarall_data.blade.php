<?php
    $bulan = Input::get('bulan');
    $tahun = Input::get('tahun');
    $tmt = $tahun."-".$bulan."-";
    $idskpd = session('idskpd');
	
    $rs = \DB::table("tr_kenaikan_pangkat")->where('tmt', 'like', $tmt.'%')->where('idskpd', 'like', $idskpd. '%');
    // echo $rs->count(); exit();
    
	
if($rs->count() > 0){
$jml = $rs->count();
$row = $rs->first(); ?>
<div class="row" style="padding-left: 35px;">
    <div class="span12">
        <form id="form2" name="form2" class="form-horizontal" action="<?=url().'/kenaikanpangkat/penetapannominatifkp/cetaksimpan/pengantarall'?>" target="_blank" class="" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" id="bulan" name="bulan" value="<?php echo $bulan?>" />
            <input type="hidden" id="tahun" name="tahun" value="<?php echo $tahun?>" />
            <input type="hidden" id="idskpd" name="idskpd" value="<?php echo substr($idskpd,0,2)?>" />

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
                        <input type="text" name="berkas_sp" id="berkas_sp" class="input-mini form-control" placeholder="Jumlah berkas" value="{!!$jml!!}"><!--?php echo ($row->berkas_sp=='0')?$jml:$row->berkas_sp?-->
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
<?php }else{ ?>
<p>Data tidak ditemukan</p>
<?php } ?>


<script>

    $(document).ready(function() {
        $(".tmt").mask("99-99-9999");
    });

</script>