<?php
    $nousul = Input::get('nousul');
    $rs = \DB::table("tr_mutasi_pengangkatan")->where('nousul', $nousul)->where('statususul',1)->where('statussk',1);

    if($rs->count() > 0){
        $jml = $rs->count();
        $row = $rs->first();
    }else{
        echo "Data pada no usul ini belum ada yang disetujui.";
    }
?>

<script>

    $(document).ready(function() {
        $(".tmt").mask("99-99-9999");
    });

</script>

<div class="row" style="padding-left: 35px;">
    <div class="span12">
        @if(isset($row))
        <form id="form2" name="form2" class="form-horizontal" action="{!!url()!!}/emutasi/skpengangkatan/cetak/skdalamdaftar" class="" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
            <input type="hidden" id="nousul" name="nousul" value="<?php echo $nousul?>" />
            <input type="hidden" id="idskpd" name="idskpd" value="<?php echo substr($row->idskpd,0,2)?>" />

            <div class="row">

                <div class="head-line">
                    <h4><i class="fa fa-fire"></i> Formulir Dokumen Nominatif</h4>
                </div></br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Periode </label>
                    <div class="col-sm-3">
                     <div class='input-group datepicker'>
                        <input type="text" class="form-control date" name="periode_tgl1" id="periode_tgl1" placeholder="dd-mm-yyyy" value="<?php echo ($row->periode_tgl1!='0000-00-00')?tglina($row->periode_tgl1):'00-00-0000'?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                     </div>
                    </div>
                    <label class="col-sm-1 control-label">sd</label>
                    <div class="col-sm-3">
                     <div class='input-group datepicker'>
                        <input type="text" class="form-control date" name="periode_tgl2" id="periode_tgl2" placeholder="dd-mm-yyyy" value="<?php echo ($row->periode_tgl2!='0000-00-00')?tglina($row->periode_tgl2):'00-00-0000'?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                     </div>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label class="col-sm-3 control-label">Nomor Surat Pengantar </label>
                    <div class="col-sm-7">
                        <input type="text" name="no_sp" id="no_sp" class="input-medium form-control" placeholder="No Surat Pengantar" value="<?php echo ($row->no_sp=='')?'822.3/...../'.date('Y'):$row->no_sp?>">
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label class="col-sm-3 control-label">Banyak Berkas </label>
                    <div class="col-sm-7">
                        <input type="text" name="berkas_sp" id="berkas_sp" class="input-mini form-control" placeholder="Jumlah berkas" value="<?php echo ($row->berkas_sp=='0')?$jml:$row->berkas_sp?>">
                    </div>
                </div>
                <div class="form-group" style="display: none">
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
        @endif

    </div>
</div>

<script>

    $(document).ready(function(){
        $("#form2 .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#form2 .date").mask("99-99-9999");

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
    });
</script>