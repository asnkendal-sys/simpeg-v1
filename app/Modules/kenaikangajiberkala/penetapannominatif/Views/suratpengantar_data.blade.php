<?php
    $periode = Input::get('idkgb');
    $idkgb = Input::get('idkgb').".".Input::get('idskpd');
    $idskpd = Input::get('idskpd');
    $jnskgb = Input::get('jnskgb');

    $attr = \PenetapannominatifModel::attrPengantar($idskpd);

    if($jnskgb != '0'){
        $where = "idkgb like \"".$idkgb."%\" and jnskgb = \"".$jnskgb."\"";
    }else{
        $where = "idkgb like \"".$idkgb."%\"";
    }

    $rs = \DB::table('tr_kgb')->whereRaw($where)->orderBy('golpns', 'desc');
    if($rs->count() > 0){
        $jml = $rs->count();
        $item = $rs->first();
    }else{
        echo "Data nominatif tidak tersedia";
        exit();
    }
?>

<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikangajiberkala/penetapannominatif/suratpengantar" target="_blank" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> ATRIBUT SURAT PENGANTAR </h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 data-biodata">
                    {!!csrf_field()!!}
                    <input type="hidden" name="periode" id="periode" value="{!!$periode!!}">
                    <input type="hidden" name="idkgb" id="idkgb" value="{!!$idkgb!!}">
                    <input type="hidden" name="jnskgb" id="jnskgb" value="{!!$jnskgb!!}">
                    <input type="hidden" name="idskpd" id="idskpd" value="{!!$idskpd!!}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Surat Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="no_sp" id="no_sp" class="form-control" placeholder="No Surat Pengantar" value="<?php echo ($item->no_sp=='')?'822.3/...../'.date('Y'):$item->no_sp?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Banyak Berkas</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="berkas_sp" id="berkas_sp" class="form-control" placeholder="Jumlah berkas" value="<?php echo ($item->berkas_sp=='0')?$jml:$item->berkas_sp?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Surat</label>
                        <div class="controls col-sm-7">
                            <input type="text" name="tgl_sp" id="tgl_sp" class="tmt form-control" placeholder="dd-mm-yyyy" value="<?php echo ($item->tgl_sp=='0000-00-00')?date('d-m-Y'):tglina($item->tgl_sp)?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Jabatan Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control" name="jabpen_sp" id="jabpen_sp" placeholder="Nama Jabatan Pengantar" value="<?php echo ($item->jabpen_sp!='')?$item->jabpen_sp:(strtoupper((count($attr)!='')?$attr->jab:'')."".((strlen($idskpd)>2)?" ".strtoupper(getSkpdgroup(substr($idskpd,0,2))):''))?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pejabat Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control" name="pejpen_sp" id="pejpen_sp" placeholder="Pejabat Penetap Pengantar" value="<?php echo ($item->pejpen_sp!='')?$item->pejpen_sp:((count($attr)!='')?$attr->nama:'')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIP Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control" name="nippen_sp" id="nippen_sp" placeholder="NIP Penetap Pengantar" value="<?php echo ($item->nippen_sp!='')?$item->nippen_sp:((count($attr)!='')?$attr->nip:'')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pangkat Penetap Pengantar</label>
                        <div class="controls col-sm-7">
                            <input type="text" class="form-control" name="golpen_sp" id="golpen_sp" placeholder="Golongan Ruang Pengantar" value="<?php echo ($item->golpen_sp!='')?$item->golpen_sp:(ucword((count($attr)!='')?$attr->pangkat:''))?>">
                        </div>
                    </div>

                    @if($idskpd == '04')
                    <?php
                        $rsuptd = \DB::table('a_skpd')
                            ->leftJoin('tr_kgb', 'a_skpd.idskpd', '=', \DB::raw('left(kdskpdskr, 5)'))
                            ->whereRaw($where)
                            ->where('a_skpd.idparent', '04')
                            ->where('a_skpd.issatker', 1)
                            ->orderBy('a_skpd.skpd')
                            ->groupBy('a_skpd.idskpd')
                            ->get();
                    ?>
                    <div style="max-height: 350px; overflow-y: scroll;">
                        <table class="table">
                            <tr class="bg-primary">
                                <th><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua" checked=""></th>
                                <th class="text-left">PILIHAN UNIT KERJA</th>
                            </tr>
                            <tr>
                                <td width="5%"><input class="piluptd" name="piluptd[]" value="04" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih untuk dicetak" type="checkbox" checked=""></td>
                                <td width="95%">Dinas Pendidikan dan Kebudayaan</td>
                            </tr>
                            @foreach($rsuptd as $item)
                                <tr>
                                    <td width="5%"><input class="piluptd" name="piluptd[]" value="{!!$item->idskpd!!}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih untuk dicetak" type="checkbox" checked=""></td>
                                    <td width="95%">{!!$item->skpd!!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div><br/>
                    @endif

                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="controls col-sm-9">
                            <button class="btn btn-success" name="actpengantar" type="submit" value="1"><i class="fa fa-print"></i> Pengantar</button>
                            <button class="btn btn-success" name="actnominatif" type="submit" value="1"><i class="fa fa-print"></i> Nominatif</button>
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

        /*$('#form-pengantar').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan Atribut Surat Pengantar ?',function(a){
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
                                claravel_modal_close('main_modal');
                                $('.cari').trigger('submit');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });*/
    });
</script>