<!-- {!!Input::get('idskpd')!!} -->
<?php 
$attr = \NominatifpensiunModel::attrPengantar(Input::get('idskpd'));
// dd($attr); die();

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
?>
<style type="text/css">
    .form-horizontal .control-label{
        text-align: left;
    }
</style>
<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikanpangkat/penetapannominatifkp/updatenominatifkp" accept-charset="UTF-8">
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
                        </div>
                    </div>
                </div>
            </div>
           {{--  <div class="col-md-6">
               <div class="box-body">
                    <table class="table table-bordered table-stripped" width="100%">
                    </table>
                </div>
            </div> --}}
            <div class="col-md-6">
               <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT SK KENAIKAN PANGKAT </h3>
            </div>
            <div class="box box-warning">
               <div class="box-body">
                   <div class="col-md-12 data-atribut">
                       {!!csrf_field()!!}
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="idjeniskp">Jenis KP</label>
                            <div class="controls col-sm-7">
                                {!! PenetapannominatifkpModel::comboJenisKpNominatif("idjeniskp",$rs->idjeniskp,".: Jenis KP :.") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="idgolrupktb">Golru Baru</label>
                            <div class="controls col-sm-7">
                                {!! comboGolru("idgolrupktb",$rs->idgolrupktb,"") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mktkpb">Masa Kerja</label>
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
                            <label class="col-sm-3 control-label" for="gkpb">Gaji Golru</label>
                            <div class="controls col-sm-7">
                                <input name="gkpb" value="{!! $rs->gkpb !!}" id="gkpb" maxlength="13" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmt">TMT KP</label>
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
                   </div>
                </div>
            </div>
                   
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT ATASAN LANGSUNG </h3>
            </div>
            <div class="box box-warning">
               <div class="box-body">
                   <div class="col-md-12 data-atribut">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIP Atasan</label>
                            <div class="controls col-sm-7">
                                <select name="atasan_nip" class="form-control atasan_nip" id="atasan_nip" style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Atasan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control atasan_nama" name="atasan_nama" id="atasan_nama" placeholder="Nama Atasan" value="{!!$rs->atasan_nama!!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jabatan Atasan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control atasan_jab" name="atasan_jab" id="atasan_jab" placeholder="Jabatan Atasan" value="{!!$rs->atasan_jab!!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pangkat Atasan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control atasan_pkt" name="atasan_pkt" id="atasan_pkt" placeholder="Pangkat Atasan" value="{!!$rs->atasan_pkt!!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Golongan Atasan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control atasan_gol" name="atasan_gol" id="atasan_gol" placeholder="Golongan Atasan" value="{!!$rs->atasan_gol!!}">
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
</div>
</div>
</div>
</div>
</div>
</div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
        $(".date").mask("99-99-9999");
        $('.data-atribut select').select2();


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

        //
        var jikaNipAtasan = "{!! ($rs->atasan_nip!='')?$rs->atasan_nip:'' !!}";
        autoCompleteimg('.atasan_nip', '{{url()}}/epensiun/nominatifpensiun/caripegawai', value="<?php echo ($rs->atasan_nip!='')?$rs->atasan_nip:((count($attr)!='')?$attr->nip:'')?>", null, jikaNipAtasan, jikaNipAtasan, '');

        $(".atasan_nip").on('change', function(e){
            e.preventDefault();
            var nipatasan = $(".atasan_nip").val();
            console.log(nipatasan);
            if (nipatasan != null) {
                $.ajax({
                    url: '{{url()}}/epensiun/nominatifpensiun/detailpegawai',
                    type: 'post',
                    data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
                    success:function(response){
                        var ret = $.parseJSON(response);

                        $(".atasan_nama").val(ret.nama);
                        $(".atasan_jab").val(ret.jab);
                        $(".atasan_pkt").val(ret.pangkat);
                        $(".atasan_gol").val(ret.golongan);
                    }
                });
            }
        })//.trigger('change');
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
</script>
