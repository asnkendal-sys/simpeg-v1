<?php 
//{!!Input::get('idusul')!!}",'nip':"{!!Input::get('nip')!!}", 'nousul':"{!!Input::get('nousul')!!}"
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
    ->where('tr_kenaikan_pangkat.idusul', Input::get('idusul'))
    ->where('tr_kenaikan_pangkat.nip', Input::get('nip'))
    ->first();

    //App\Modules\kenaikanpangkat\penetapannominatifkp\Models
    //$idspkdnya = $rs->idskpd;
    //    if ($rs->kepalabkd == ""){
    //       $rs->kepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'namalengkap');   
    //       $rs->nipkepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'nip');   
    //       $rs->jabkepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'jab');   
    //       $rs->pangkatbkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'pangkat');   
    //   }
?>
<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikanpangkat/penetapannominatifkp/verifikasinominatifkp" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA</h3>
                </div>
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-md-12 data-biodata">
                            {!!csrf_field()!!}
                            <input type="hidden" name="idusul" id="idusul" value="{!!Input::get('idusul')!!}">
                            <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">
                            <table class="table table-hovered table-stripped" width="100%">
                                <tr>
                                    <td width="18%"><label class="control-label">NIP </label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nip">{!! $rs->nip !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">KARPEG </label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nip">{!! $rs->pegawai->nokarpeg !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Nama </label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nama">{!! $rs->namalengkap !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Tempat, Tanggal Lahir </label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-lahir">{!! $rs->pegawai->tmlhr.', '.(($rs->pegawai->tglhr!="0000-00-00")?date("d-m-Y", strtotime($rs->pegawai->tglhr)):"") !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Gol Ruang </label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-golru">{!! $rs->golru !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Jabatan</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nmjabatan">{!! $rs->jabatan !!}</span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Unit Kerja</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! $rs->path_short !!}</td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">TMT</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! ($rs->tmtjbt!="0000-00-00")?date("d-m-Y", strtotime($rs->tmtjbt)):"" !!}</td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Eselon TMT</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! $rs->esl !!}</td>
                                </tr>
                                {{-- cpns --}}
                                <tr>
                                    <td width="18%"><label class="control-label">Pangkat /Gol. CPNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! $rs->golrucpn .' - '.ucword($rs->pangkatcpn)!!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">TMT CPNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->pegawai->tmtcpn!="0000-00-00")?date("d-m-Y", strtotime($rs->pegawai->tmtcpn)):"") !!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">Masa Kerja CPNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->pegawai->mkthncpn!="")?$rs->pegawai->mkthncpn:"0").' Tahun '.(($rs->pegawai->mkblncpn!="")?$rs->pegawai->mkblncpn:"0").' Bulan' !!}</td>
                                </tr>
                                {{--  end cpns --}}
                                {{-- pns --}}
                                <tr>
                                    <td width="18%"><label class="control-label">Pangkat /Gol. PNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! $rs->golrupns.' - '.ucword($rs->pangkatpns) !!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">TMT PNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->pegawai->tmtpns!="0000-00-00")?date("d-m-Y", strtotime($rs->pegawai->tmtpns)):"") !!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">Masa Kerja PNS</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->pegawai->mkthnpns!="")?$rs->pegawai->mkthnpns:"0").' Tahun '.(($rs->pegawai->mkblnpns!="")?$rs->pegawai->mkblnpns:"0").' Bulan' !!}</td>
                                </tr>
                                {{--  end pns --}}
                                {{-- sekarang --}}
                                <tr>
                                    <td width="18%"><label class="control-label">Pangkat /Gol. Sekarang</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! $rs->golru.' - '.ucword($rs->pangkat) !!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">TMT Sekarang</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->tmtpkt!="0000-00-00")?date("d-m-Y", strtotime($rs->tmtpkt)):"") !!}</td>
                                </tr><tr>
                                    <td width="18%"><label class="control-label">Masa Kerja Golongan</label></td><td class="text-center" width="2%"> : </td>
                                    <td width="38%">{!! (($rs->pegawai->mkthnpkt!="")?$rs->pegawai->mkthnpkt:"0").' Tahun '.(($rs->pegawai->mkblnpkt!="")?$rs->pegawai->mkblnpkt:"0").' Bulan' !!}</td>
                                </tr>
                                {{--  end sekarang --}}
                            </table>
                            <div class="box box-warning">
                               <div class="box-body">
                                   <table class="table table-striped">
                                       <thead>
                                       <tr class="bg-primary">
                                           <th width="5%">No</th>
                                           <th width="35%">Dokumen Persyaratan</th>
                                           <th width="10%">Jumlah</th>
                                           <th width="10%">Preview</th>
                                       </tr>
                                       </thead>
                                       <tbody id="tbl_dokumenpersyaratan"> <!--1-->
                                       </tbody>
                                   </table>
                                   <a id="download_zip"></a> <!--2-->
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT SK KENAIKAN PANGKAT </h3>
                </div>
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-md-12 data-atribut">
                       {!!csrf_field()!!}
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="idjeniskp">Jenis KP :</label>
                            <div class="controls col-sm-7">
                                {!! PenetapannonnominatifkpModel::comboJeniskp("idjeniskp",$rs->idjeniskp,".: Jenis KP :.") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="idgolrupktb">Golru Baru :</label>
                            <div class="controls col-sm-7">
                                {!! comboGolru("idgolrupktb",$rs->idgolrupktb,"") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mktkpb">Masa Kerja :</label>
                            <div class="col-sm-2">
                                <input name="mktkpb" value="{!! $rs->mktkpb !!}" id="mktkpb" class="form-control hitunggaji" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkbkpb" value="{!! $rs->mkbkpb !!}" id="mkbkpb" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="gkpb">Gaji Golru :</label>
                            <div class="controls col-sm-7">
                                <input name="gkpb" value="{!! $rs->gkpb !!}" id="gkpb" maxlength="13" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmt">TMT KP :</label>
                            <div class="controls col-sm-7">
                                <input name="tmt" value="{!! date("d-m-Y", strtotime($rs->tmt)) !!}" id="tmt" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>
                       @if($rs->idjenjab == 2)
                       <div class="form-group">
                           <label class="col-sm-3 control-label" for="tmt">Angka Kredit</label>
                           <div class="controls col-sm-7">
                               <input type="text" name="nopak" value="{!! $rs->nopak !!}" id="tmt" maxlength="10" class="form-control" placeholder="Angka Kredit">
                           </div>
                       </div>
                       @else
                       <input type="hidden" name="nopak" value="{!! $rs->nopak !!}" id="tmt" maxlength="10" class="form-control" placeholder="Angka Kredit">
                       @endif

                    @if(session('role_id') < 3)
                    <div class="data-berkas">
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
                        <div id="ftampil2">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="" cols="6" class="form-control" name="kettms" id="kettms" placeholder="Keterangan Jika Tidak Memenuhi Syarat" >{!! $rs->kettms !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div id="ftampil3">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="" cols="" class="form-control" name="ketbtl" id="ketbtl" placeholder="Keterangan Jika Berkas Tidak Lengkap" >{!! $rs->ketbtl !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div id="ftampil1">
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
                        <div id="ftampil11">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Penetap</label>
                                <div class="controls col-sm-7">
                                    <input name="kepalabkd" id="kepalabkd" value="{!! $rs->kepalabkd !!}" class="form-control" type="text" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NIP Penetap</label>
                                <div class="controls col-sm-7">
                                    <input name="nipkepalabkd" id="nipkepalabkd" value="{!! $rs->nipkepalabkd !!}" class="form-control" type="text" >
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
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Proses</label>
                            <div class="controls col-sm-7">
                                <?php
                                    if($rs->statususul==1){
                                        echo '<span style="color:green"><i class="fa fa-check-circle"/></span> Memenuhi Syarat';
                                    }else if($rs->statususul==2){
                                        echo '<span style="color:red"><i class="fa fa-times-circle"/></span> Tidak Memenuhi Syarat';
                                    }else if($rs->statususul==3){
                                        echo '<span style="color:orange"><i class="fa fa-info-circle"/></span> Berkas Tidak Lengkap';
                                    }else{
                                        echo 'Belum ada tanggapan.';
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                        if($rs->statususul==1){
                            if($rs->statususul=='1' && $rs->statussk=='2'){
                                echo '<div class="form-group">
                                        <label class="col-sm-3 control-label">Status Berkas</label>
                                        <div class="controls col-sm-7">
                                            <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses
                                        </div>
                                    </div>';
                            }else if($rs->statussk=='1'){
                                echo '<div class="form-group">
                                        <label class="col-sm-3 control-label">Status Berkas</label>
                                        <div class="controls col-sm-7">
                                            <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses
                                        </div>
                                    </div>';
                                    if($rs->iscetaksk == 1){
                                        echo '<div class="form-group">
                                                <label class="col-sm-3 control-label">Status SK</label>
                                                <div class="controls col-sm-7">
                                                    <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                                </div>
                                            </div>';
                                    }else if($rs->iscetaksk == 2){
                                        echo '<div class="form-group">
                                                <label class="col-sm-3 control-label">Status SK</label>
                                                <div class="controls col-sm-7">
                                                    <span style="color:#000000"><i class="fa fa-star" title="SK Dibatalkan"/></span> SK Dibatalkan
                                                </div>
                                            </div>';
                                    }
                            }
                        } else if($rs->statususul==2){
                            echo '<div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <span style="color:red"><i class="fa fa-times-circle"/></span> '.$rs->kettms.'
                                </div>
                            </div>';
                        }else if($rs->statususul==3){
                            echo '<div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <span style="color:orange"><i class="fa fa-info-circle"/></span> '.$rs->ketbtl.'
                                </div>
                            </div>';
                        }?>
                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    //
    function clickModal(jenis,subjenis,syarat,nip){
        claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
        $.ajax({
            type:'post',
            url : '{!!url()!!}/epensiun/nominatifpensiun/data/prefile',
            data: {'nip': nip, 'jenis': jenis, 'subjenis': subjenis, 'syarat': syarat, '_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    }

    function getDokumenPersyaratan(response,nip,nama,folderName){
        var html = "";
        var x = 1;
        if(response.length > 0){
            response.forEach(item => {
                if (typeof item.jmlfile !== 'undefined') {
                html += `
                <tr>
                    <td width="5%" class="text-center">${x++}</td>
                    <td width="35%">${item.syarat}</td>
                    <td width="10%" class="text-center">${item.jmlfile}</td>
                    <td width="10%" class="text-center"><a href="javascript:void(0)" class="prefile btn btn-success" onclick="clickModal('${item.jenis}','${item.subjenis}','${item.syarat}','${nip}')"><i class="fa fa-search"></i> Preview</a></td>
                </tr>
                `;
                }else{
                    html += `
                    <tr>
                        <td width="5%" class="text-center">${x++}</td>
                        <td width="35%" colspan="2">${item.syarat}</td>
                        <td width="10%" class="text-center"><a href="javascript:void(0)" class="btn btn-default" onclick="bootbox.alert('Data belum tersedia.');"><i class="fa fa-search"></i> Preview</a></td>
                    </tr>
                    `;
                }
            })
        }else{
            html = `<tr>
            <td colspan="4">Data tidak ditemukan.</td>
            </tr>`
        }

        $("#tbl_dokumenpersyaratan").html(html);
        var hostname = "https://simpeg.kendalkab.go.id/efile/"
        // var hostname = "http://localhost:8001/"

        var rtr = response.filter(item => item.jmlfile < 1 ? false : true)

        $("#download_zip").attr("href",`${hostname}jadikanzip?nip=${nip}&pegawai=${nama}&nama_folder=${folderName}&data=${JSON.stringify(rtr)}`)
        .attr("target","_blank")
        .attr("class","btn btn-primary float-right")
        .html("Download Zip")

    }
        //
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
        $(".date").mask("99-99-9999");
        $('.data-atribut select').select2();

        // id 1
        $.ajax({
            url:'{!!url()!!}/kenaikanpangkat/penetapannominatifkp/editkp',
            data: {'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            beforeSend : function(){
                $("#tbl_dokumenpersyaratan").html("Loading..");
            },
            success:function(response){
                // alert('hola');
                var reb = $.parseJSON(response);
                var ret = reb.data1
                if(ret == null){
                    $("#tbl_dokumenpersyaratan").html("<tr><td colspan='3'>Data tidak ditemukan di E File</td></tr>");

                }else{
                    getDokumenPersyaratan(reb.data2,ret.nip,ret.nama,reb.folder);

                }
            }

        });
        //

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Data Nominatif Mutasi Dalam SKPD ?',function(a){
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
                                claravel_modal_close('main_modal2');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#xjab1,#xjab2,#xjab3').hide();  

        $('.data-atribut #idjenjabbaru').on('change', function(e){
            e.preventDefault();
            var vId1 = $(".data-atribut #idjenjabbaru").val();

            if(vId1 >= 20){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').show();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').hide();
            }else if(vId1 == 2){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').show();
                $('.data-atribut #xjab3').hide();
            }else if(vId1 == 3){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').show();
            }else{
                $('.data-atribut #xjab').show();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').hide();
            }            
        }).trigger('change');

        $('a.prefile').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epensiun/nominatifpensiun/data/prefile',
                data: {'nip': $(this).attr('recnip'), 'jenis': $(this).attr('recjenis'), 'subjenis': $(this).attr('recsubjenis'), 'syarat': $(this).attr('recsyarat'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });
    });

    $('.hitunggaji').on('change',function(e){
        e.preventDefault();
        $.ajax({
            url  : '<?php echo url()?>/kenaikanpangkat/penetapannonnominatifkp/gaji',
            type : 'POST',
            data : {'idgolrupktb': $('#idgolrupktb').val(), 'mktkpb': $('#mktkpb').val(), '_token' : '{!!csrf_token()!!}'},
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#gkpb').val(html);
            }
        });
    });

    $('#ftampil1').hide();
    $('#ftampil2').hide();
    $('#ftampil3').hide();
    $('#ftampil11').hide();

    $('.data-berkas #statususul').on('change',function(e){
        e.preventDefault();
        if($('.data-berkas #statususul').val() == 1){
            $('#ftampil1').show();
            $('#ftampil2').hide();
            $('#ftampil3').hide();

            $('.data-berkas #statussk').on('change',function(e){
                e.preventDefault();
                if($('.data-berkas #statussk').val() == 1){
                    $('#ftampil11').show();
                }else{
                    $('#ftampil11').hide();
                }
            }).trigger('change');
        }else if($('.data-berkas #statususul').val() == 2){
            $('#ftampil1').hide();
            $('#ftampil2').show();
            $('#ftampil3').hide();
            $('#ftampil11').hide();
        }else if($('.data-berkas #statususul').val() == 3){
            $('#ftampil1').hide();
            $('#ftampil2').hide();
            $('#ftampil3').show();
            $('#ftampil11').hide();
        }else{
            $('#ftampil1').hide();
            $('#ftampil2').hide();
            $('#ftampil3').hide();
            $('#ftampil11').hide();
        }
    }).trigger('change');
</script>
