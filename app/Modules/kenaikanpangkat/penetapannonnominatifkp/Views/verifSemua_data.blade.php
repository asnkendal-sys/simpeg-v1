<!DOCTYPE html>
<?php 
$rs = App\Modules\kenaikanpangkat\penetapannominatifkp\Models\PenetapannominatifkpModel::
    select('tr_kenaikan_pangkat.*'
        ,'a_golruang.golru'
        ,'a_golruang.pangkat'
        ,'a_skpd.skpd'
        ,'a_esl.esl'
        ,'a_skpd.path_short', 'tb_01.idjenjab'
        ,\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
        ,\DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
        ,\DB::raw("
                CONCAT(
                    IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                            -
                            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(tb_01.idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(tb_01.idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(tb_01.idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                        ),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                            + tb_01.mkthncpn
                        )
                    ),
                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                ")
        ,\DB::raw("a_golruangcpn.golru as golrucpn,a_golruangcpn.pangkat as pangkatcpn, a_golruangpns.golru as golrupns,a_golruangpns.pangkat as pangkatpns")
    )
    ->leftjoin('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
    ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('a_golruang as a_golruangcpn', 'tb_01.idgolrucpn', '=', 'a_golruangcpn.idgolru')
    ->leftjoin('a_golruang as a_golruangpns', 'tb_01.idgolrupns', '=', 'a_golruangpns.idgolru')
    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
    ->orderby('tr_kenaikan_pangkat.nousul','desc')
    ->where('tr_kenaikan_pangkat.nousul', Input::get('nousul'))
    ->first();

    // echo $rs;
    // foreach($rs as $item){
    //     $nama=$item->kepalabkd;
    //     echo $nama;
    // }
?>
<html>
<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikanpangkat/penetapannonnominatifkp/verifsemua" accept-charset="UTF-8">
    {!!csrf_field()!!}
    <input type="hidden" name="nousul" id="nousul" value="{!!Input::get('nousul')!!}">
    <div class="data-verif">
        <div class="form-group">
            <label class="col-sm-3 control-label">Status Berkas</label>
            <div class="controls col-sm-7">
                <select id="statususul" name="statususul" class="input-large form-control" required style="width: 100%">
                    <option value="0" {!! $rs->statususul==0?'selected':'' !!}>.: Status Usulan :.</option>
                    <option value="1" {!! $rs->statususul==1?'selected':'' !!}>Memenuhi Syarat</option>
                    <option value="2" {!! $rs->statususul==2?'selected':'' !!}>Tidak Memenuhi Syarat</option>
                    <option value="3" {!! $rs->statususul==3?'selected':'' !!}>Berkas Tidak Lengkap</option>
                </select>
            </div>
        </div>
        <div id="tampil_ket_tdkmemenuhi">
            <div class="form-group">
                <label class="col-sm-3 control-label">Keterangan</label>
                <div class="controls col-sm-7">
                    <textarea rows="" cols="6" class="form-control" name="kettms" id="kettms" placeholder="Keterangan Jika Tidak Memenuhi Syarat" >{!! $rs->kettms !!}</textarea>
                </div>
            </div>
        </div>
        <div id="tampil_ket_tdklengkap">
            <div class="form-group">
                <label class="col-sm-3 control-label">Keterangan</label>
                <div class="controls col-sm-7">
                    <textarea rows="" cols="" class="form-control" name="ketbtl" id="ketbtl" placeholder="Keterangan Jika Berkas Tidak Lengkap" >{!! $rs->ketbtl !!}</textarea>
                </div>
            </div>
        </div>
        <div id="tampil_proses">
            <div class="form-group">
                <label class="col-sm-3 control-label">Status proses</label>
                <div class="controls col-sm-7">
                    <select id="statussk" name="statussk" class="form-control" required style="width: 100%">
                        <option value="0" {!! $rs->statussk==0?'selected':'' !!}>.: PILIHAN :.</option>
                        <option value="2" {!! $rs->statussk==2?'selected':'' !!}>Dalam Proses</option>
                        <option value="1" {!! $rs->statussk==1?'selected':'' !!}>Proses Selesai</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="tampil_penetap">
            <div class="form-group">
                <label class="col-sm-3 control-label">Nama Penetap</label>
                <div class="controls col-sm-7">
                    <input name="kepalabkd" id="kepalabkd" value="{!! $rs->kepalabkd !!}" class="form-control" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">NIP Penetap</label>
                <div class="controls col-sm-7">
                    <input name="nipkepalabkd" id="nipkepalabkd" value="{!! $rs->nipkepalabkd !!}" class="form-control nipkepalabkd" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Jab Penetap</label>
                <div class="controls col-sm-7">
                    <input name="jabkepalabkd" id="jabkepalabkd" value="{!! $rs->jabkepalabkd !!}" class="form-control" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pangkat Penetap</label>
                <div class="controls col-sm-7">
                    <input name="pangkatbkd" id="pangkatbkd" value="{!! $rs->pangkatbkd !!}" class="form-control" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nomor SP</label>
                <div class="controls col-sm-7">
                <input type="text" class="input-large form-control" name="nosk" id="nosk" placeholder="Nomor SK Mutasi" value="{!!$rs->nosk!!}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Tanggal SP</label>
                <div class="controls col-sm-7">
                <input type="text" class="input-large tmt form-control" name="tglsurat" id="tglsurat" placeholder="dd-mm-yyyy" value="{!! date("d-m-Y", strtotime($rs->tglsurat)) !!}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">TMT Berlaku</label>
                <div class="controls col-sm-7">
                <input type="text" class="input-large tmt form-control" name="tmt" id="tmt" placeholder="dd-mm-yyyy" value="{!! date("d-m-Y", strtotime($rs->tmt)) !!}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Status SP</label>
                <div class="controls col-sm-7"> 
                <label class="radio a"> 
                    <input type="radio" name="iscetaksk" id="iscetaksk0" value="0" {!! $rs->iscetaksk==0?'checked="checked"': '' !!} class="a"> Belum Cetak SP
                </label>
                <label class="radio a">
                    <input type="radio" name="iscetaksk" id="iscetaksk1" value="1" {!! $rs->iscetaksk==1?'checked="checked"': '' !!} class="a"> Sudah Cetak SP
                </label>
                <label class="radio a ">
                    <input type="radio" name="iscetaksk" id="iscetaksk2" value="2" {!! $rs->iscetaksk==2?'checked="checked"': '' !!} class="a"> Pembatalan Cetak SP
                </label>
                </div>
            </div>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-5" style="float: right;">
        <div class="checkbox">
            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
            <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
        </div>
    </div>
</div>
</form>
</html>

<script type="text/javascript">
$(document).ready(function(){
    $('.tmt').mask("99-99-9999");
    $(".date").mask("99-99-9999");

    $('#tampil_proses').hide();
    $('#tampil_ket_tdkmemenuhi').hide();
    $('#tampil_ket_tdklengkap').hide();
    $('#tampil_penetap').hide();

    $('.data-verif #statususul').on('change',function(e){
            e.preventDefault();
            if($('.data-verif #statususul').val() == 1){
                $('#tampil_proses').show();
                $('#tampil_ket_tdkmemenuhi').hide();
                $('#tampil_ket_tdklengkap').hide();

                $('.data-verif #statussk').on('change',function(e){
                    e.preventDefault();
                    if($('.data-verif #statussk').val() == 1){
                        $('#tampil_penetap').show();
                    }else{
                        $('#tampil_penetap').hide();
                    }
                }).trigger('change');
            }else if($('.data-verif #statususul').val() == 2){
                $('#tampil_proses').hide();
                $('#tampil_ket_tdkmemenuhi').show();
                $('#tampil_ket_tdklengkap').hide();
                $('#tampil_penetap').hide();
            }else if($('.data-verif #statususul').val() == 3){
                $('#tampil_proses').hide();
                $('#tampil_ket_tdkmemenuhi').hide();
                $('#tampil_ket_tdklengkap').show();
                $('#tampil_penetap').hide();
            }else{
                $('#tampil_proses').hide();
                $('#tampil_ket_tdkmemenuhi').hide();
                $('#tampil_ket_tdklengkap').hide();
                $('#tampil_penetap').hide();
            }
        }).trigger('change');
    
//simpan
    $('#form-edit').on('submit',function(e){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm('Update Data ?',function(a){
            if (a == true){
                $.ajax({
                    url : $this.attr('action'),
                    type : 'POST',
                    data : $this.serialize(),
                    beforeSend: function(){
                        $('#loading-state').fadeIn("slow");
                    },
                    success:function(html){
                        $('#loading-state').fadeOut("slow");
                        if(html=='4'){
                            notification('Berhasil Disimpan','success');
                            claravel_modal_close('main_modal');
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