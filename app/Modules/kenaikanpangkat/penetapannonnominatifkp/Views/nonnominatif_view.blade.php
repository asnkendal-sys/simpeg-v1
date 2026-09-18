<script type="text/javascript">
    $(document).ready(function(){
        $(".tmt, .date").mask("99-99-9999");
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
    });
</script>

<style>
table.tb td{
    padding:5px;
}

.grad {
    -moz-box-shadow: inset 0 0 50px #888;
    -webkit-box-shadow: inset 0 0 50px#888;
    box-shadow: inner 0 0 50px #888;
}

</style>
<?php
    $item = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab',
        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
        \DB::raw("
                        CONCAT(
                            IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                    (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                    -
                                    (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                    IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                        IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                ),
                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                    (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                    + tb_01.mkthncpn
                                )
                            ),
                            RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                        "),
        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
    )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->where('tb_01.nip', Input::get('nip'))
        ->first();

    if($item->idjenjab == 2){
        /*fungsional*/
        $interval = 2;
    }else{
        /*struktural dan pelaksana*/
        $interval = 4;
    }

    $thmker = $item->mkthnpkt;
    $thmker2 = intval($thmker)+$interval;
?>

@if(count($item) > 0)
<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
    <table class="tb table-bordered" border="0" width="98%">
        <tbody>
            <tr>
                <td rowspan="3" align="center" width="5%">
                    <?php
					if(file_exists("./packages/upload/photo/pegawai/".$item->photo)){
						$pict = $item->photo;
					}else {
						$pict = "default.jpg";
					}
					?>
                    <div align="center"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}"  width="100"></div>
                </td>
                <th rowspan="2" width="17%">NIP <br> NAMA LENGKAP</th>
                <th rowspan="2" width="5%">GOL. RUANG</th>
                <th rowspan="2" width="20%">JABATAN <br> UNIT KERJA <br> <?php if($item->idjenjab == 2) echo "PAK LAMA"; ?></th> <!--pak jika fungsional ubah 2 -->
                <th colspan="4" width="20%">MASA KERJA S/D SEKARANG</th>
                <th colspan="2" width="15%">PENDIDIKAN TERAKHIR</th>
                <th rowspan="2" width="10%">TMT <br> USIA PENSIUN</th>
            </tr>
            <tr>
                <th >THN</th>
                <th >BLN</th>
                <th >THN</th>
                <th >BLN</th>
                <th width="5%">TINGKAT</th>
                <th width="10%">JURUSAN</th>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="{!!Input::get('n')!!}[nip]" value="{!!Input::get('nip')!!}">
                    <span id="ed1" style="display:none"><?=$item->nip?></span>
                    <a title="popdetil" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
                    {!!$item->namalengkap!!}
                </td>
                <td>{!!$item->golru!!}<br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td>
                <td>{!!$item->jabatan!!}<br>{!!$item->path_short!!} <br> @if($item->idjenjab == 2)PAK : {!!$item->nopak!!}@endif</td> <!--lanjut ubah 2 pak -->
                <td align="center">
                    <div class="text-center">{!!$item->mkthnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->mkblnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,0,-2)!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,-2)!!}</div>
                </td>
                <td>{!!$item->tkpendid!!}</td>
                <td>{!!$item->jenjurusan!!}</td>
                <td>
                    <div class="text-center">{!!(($item->pensiunnext!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($item->pensiunnext)):'')!!}</div>
                    <div class="text-center">{!!$item->usiapens!!} thn</div>

                    <input type="hidden" name="{!!Input::get('n')!!}[tglusul]" value="{!!date('Y-m-d')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idtkpendid]" value="{!!$item->idtkpendid!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idjenjurusan]" value="{!!$item->idjenjurusan!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[thnlulus]" value="{!!$item->thijaz!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idgolrupkt]" value="{!!$item->idgolrupkt!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idjenjab]" value="{!!$item->idjenjab!!}"> 
                    <input type="hidden" name="{!!Input::get('n')!!}[idjabjbt]" value="{!!$item->idjabjbt!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idjabfung]" value="{!!$item->idjabfung!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idjabfungum]" value="{!!$item->idjabfungum!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[tmtpkt]" value="{!!$item->tmtpkt!!}">
                     <!-- kondisi tmt tampil yg fungsional tmtjbbtlama, selainfunsional udah ini aja hhidden, selai itu text -->
                    <input type="hidden" name="{!!Input::get('n')!!}[tmtjbt]" value="{!!$item->tmtjbt!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[idskpd]" value="{!!$item->idskpd!!}">

                    <input type="hidden" name="{!!Input::get('n')!!}[mktkp]" value="{!!$item->mkthnpkt!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[mkbkp]" value="{!!$item->mkblnpkt!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[gkp]" value="{!!getGaji($item->idgolrupkt,$item->mkthnpkt)!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[isnom]" value="2">

                    <input type="hidden" name="{!!Input::get('n')!!}[kepalabkd]" value="{!!\PenetapannominatifkpModel::attrKepskpd($item->idskpd,'nama')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[jabkepalabkd]" value="{!!\PenetapannominatifkpModel::attrKepskpd($item->idskpd,'jab_utuh')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[nipkepalabkd]" value="{!!\PenetapannominatifkpModel::attrKepskpd($item->idskpd,'nama')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[pangkatbkd]" value="{!!\PenetapannominatifkpModel::attrKepskpd($item->idskpd,'pangkat')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[bupati]" value="{!!getPenetapsk('005','namalengkap')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[kepalasekda]" value="{!!\PenetapannominatifkpModel::attrKepskpd('01','nama')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[jabkepalasekda]" value="{!!\PenetapannominatifkpModel::attrKepskpd('01','jab_utuh')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[nipsekda]" value="{!!\PenetapannominatifkpModel::attrKepskpd('01','nama')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[pangkatsekda]" value="{!!\PenetapannominatifkpModel::attrKepskpd('01','pangkat')!!}">

                    <input type="hidden" name="{!!Input::get('n')!!}[atasan_nip]" value="{!!getKepskpd($item->idskpd,'nip')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[atasan_nama]" value="{!!getKepskpd($item->idskpd,'nama')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[atasan_pkt]" value="{!!getKepskpd($item->idskpd,'pangkat')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[atasan_gol]" value="{!!getKepskpd($item->idskpd,'golru')!!}">
                    <input type="hidden" name="{!!Input::get('n')!!}[atasan_jab]" value="{!!getKepskpd($item->idskpd,'jab')!!}">
                </td>
            </tr>
            <tr>
                <td colspan="11">
                    <table width="100%" border="0">
                        <tr style="background-color: #ececec">
                            <td width="10%" rowspan="2" style="vertical-align:middle">
                                <div align="center">Atribut Kenaikan Pangkat</div>
                            </td>
                            @if(Input::get('idjeniskp') == 3)
                                <td>Jabatan Lama : </td>
                            @endif
                            <td>Golongan : </td>
                            <td colspan="4">Masa Kerja : </td>
                            <td>TMT KP : </td>
                            @if($item->idjenjab == 2)
                                <td>PAK Baru : </td>
                            @endif
                            <td width="20%">Keterangan KP <span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
                        </tr>
                        <tr>
                            <input type="hidden" name="{!!Input::get('n')!!}[idjenjab_lama]" id ="idjenjab_lama" value="{!!$item->idjenjab!!}">    
                            <input type="hidden" name="{!!Input::get('n')!!}[idjabjbt_lama]" id ="idjabjbt_lama" value="{!!$item->idjabjbt!!}">    
                            <input type="hidden" name="{!!Input::get('n')!!}[idjabfungum_lama]" id ="idjabfungum_lama" value="{!!$item->idjabfungum!!}">    
                            @if(Input::get('idjeniskp') == 3)
                                <td>
                                    <select id="idjabfung_lama{!!Input::get('n')!!}" class="idjabfung_lama idjabfung_lama{!!Input::get('n')!!} input-large form-control" name="<?php echo Input::get('n')."[idjabfung_lama]"?>" style="width: 100%" ></select>
                                    <br>
                                    TMT jabatan lama:
                                    <input type="text" name="{!!Input::get('n')!!}[tmtjbt_lama]" value="{!!$item->tmtjbt!!}" class="form-control">
                                </td>
                            @else
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabfung_lama]" id ="" value="{!!$item->idjabfung!!}"> <!--js-->
                                <!-- TMT jabatan -->
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtjbt_lama]" value="{!!$item->tmtjbt!!}">   
                            @endif
                            <td valign="top">{!!PenetapannonnominatifkpModel::comboGolru('[idgolrupkt]',($item->idgolrupkt+1),'required','idgolrupkt',Input::get('n'))!!}</td>
                            <td valign="top"><input type="text" name="{!!Input::get('n')!!}[mktkpb]" value="{!!$thmker2!!}" class="form-control" maxlength="2" style="width:65px" required></td>
                            <td valign="top">Tahun</td>
                            <td valign="top"><input type="text" name="{!!Input::get('n')!!}[mkbkpb]" value="{!!((strlen($item->mkblnpkt)==1)?'0'.$item->mkblnpkt:$item->mkblnpkt)!!}" class="form-control" maxlength="2" style="width:65px" required></td>
                            <td valign="top">Bulan</td>
                            <td valign="top"><input type="text" class="input-medium tmt form-control" name="{!!Input::get('n')!!}[tmt]" placeholder="dd-mm-yyyy" value="{!!Input::get('tmtx')!!}" required></td>
                            @if($item->idjenjab == 2)
                                <td valign="top"><input type="text" name="{!!Input::get('n')!!}[nopak]" value="" class="form-control" placeholder="PAK Baru" required></td>
                            @endif
                            <td valign="top">
                                <input type="text" name="{!!Input::get('n')!!}[keterangan]" required class=" form-control" placeholder="Keterangan KP">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <em>* Harap periksa kembali biodata PNS apabila jenis jabatan dan nama jabatan belum sesuai dengan data sebenarnya.</em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

<script type="text/javascript">
    $(document).ready(function(){        
        autoComplete("#idjabfung_lama{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifpengangkatan/listjabfung2', 'Jabatan Fungsional ..', null, '{!!$item->idjabfung!!}', '{!!$item->jabatan!!}');
    });
</script>