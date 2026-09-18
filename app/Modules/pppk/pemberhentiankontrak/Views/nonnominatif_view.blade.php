<script type="text/javascript">
    $(document).ready(function(){
        $(".tmt, .date").mask("99-99-9999");
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $(".status{!!Input::get('n')!!}").on('change', function() {
            var nip = $(this).attr('recnip');
            if ($(this).is(':checked')) {
                let status = $(this).val();                                                        
                cekBerkas(nip, {!!Input::get('n')!!});                
            }
        });

        $(".preview{!!Input::get('n')!!}").on('click', function() {                
            var nip = $(this).attr('recnip');
            claravel_modal('Preview Berkas Pemberhentian PPPK','Loading...','main_modal2');
            $.ajax({
                url : '{{url('')}}/pppk/perpanjangankontrak/data/berkas',
                type : 'post',
                data : {
                    'nip': nip,
                    'sts_kontrak': 3,
                    '_token': '{!!csrf_token()!!}'
                },
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
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
        ->select('tb_01.*','a_golruang.golru_p3k','a_skpd.path_short','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjabatan, a_golruang_akhir.golru_p3k as golru_p3k_akhir'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
        \DB::raw("if(tb_01.idskpd=LEFT(tb_01.idskpd, 2), a_skpd.skpd, concat(a_skpd.skpd, ' - ', a_skpd2.skpd)) AS skpdskr"),
        \DB::raw("
                  CONCAT(
                        IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              -
                              (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                              IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                    IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                        ),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              + tb_01.mkthncpn
                        )
                        ),
                        RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0, 2)) AS mkskr
            "),
        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
    )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as a_skpd2', function($join) {
            $join->on(\DB::raw('LEFT(tb_01.idskpd, 2)'), '=', 'a_skpd2.idskpd');
        })
        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tb_01.idgolruawal_pppk', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruang_akhir', 'tb_01.idgolruakhir_pppk', '=', 'a_golruang_akhir.idgolru')
        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
        ->where('tb_01.nip', Input::get('nip'))
        ->first();

        $pensiunnext = new \Datetime($item->pensiunnext);
        $format = 'd-m-Y';
        /*masa kerja*/
        $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
        if($mkbln > 12){
            $thnmkskr = substr($item->mkskr,0,-2)+1;
            $blnmkskr = "0".($mkbln-12);
        }else{
            $thnmkskr = substr($item->mkskr,0,-2);
            $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
        }
?>

@if(count($item) > 0)
<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
    <table class="tb table-bordered" border="0" width="98%">
        <tbody>            
            <tr>
                <th rowspan="3" class="text-center" width="3%">
                    <input type="checkbox" name="{!!Input::get('n')!!}[status]" value="1" class="status{!!Input::get('n')!!} validate[required]" recnip="{!!$item->nip!!}" ></th>
                </th>
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
                <th rowspan="2" width="20%">JABATAN <br> UNIT KERJA</th>
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
                <td class="text-center">{!!$item->golru_p3k!!}<br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td>
                <td>{!!$item->jabatan!!}<br>{!!$item->path_short!!}</td>
                <td align="center">
                    <div class="text-center">{!!$item->mkthnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->mkblnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$thnmkskr!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$blnmkskr!!}</div>
                </td>
                <td>{!!$item->tkpendid!!}</td>
                <td>{!!$item->jenjurusan!!}</td>
                <td>
                    <div class="text-center">{!!($item->pensiunnext!='0000-00-00')?$pensiunnext->format($format):''!!}</div>
                    <div class="text-center">{!!$item->usiapens!!} thn</div>
                </td>
            </tr>
            <tr>
                <td colspan="13"><div class="alert-danger status_berkas{!!Input::get('n')!!}"></div></td>
            </tr>
            <tr>
                <td colspan="13">
                    <table width="100%" border="0">
                        <tr style="background-color: #ececec">
                            <td width="10%" rowspan="3" style="vertical-align:middle">
                                <div class="text-center">
                                    Atribut Pemberhentian<br>
                                    <a href="javascript:void(0)" class="btn btn-primary preview{!!Input::get('n')!!}" recnip="{!!$item->nip!!}" title="Lihat Berkas Layanan">Preview<br>Berkas</a>
                                </div>
                            </td>
                            <td rowspan="2" class="text-center" width="10%">Jenis Pemberhentian</td>
                            <td rowspan="2" class="text-center" width="5%">Golongan</td>
                            <td colspan="2" class="text-center" width="5%">Masa Kerja</td>                            
                            <td colspan="3" class="text-center" width="25%">Dasar Pemberhentian <br> (APS, Diberhentikan, Keuzuran, Meniggal)</td>                            
                            <td rowspan="2" class="text-center" width="10%">TMT Pemberhentian</td>
                            <td rowspan="2" class="text-center" width="15%">Keterangan Pemberhentian <span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
                        </tr>
                        <tr style="background-color: #ececec">                            
                            <td class="text-center" width="5%">Tahun</td>
                            <td class="text-center" width="5%">Bulan</td>                            
                            <td class="text-center" width="10%">Nomor Dasar</td>
                            <td class="text-center" width="10%">Tanggal Dasar</td>
                            <td class="text-center" width="10%">Berlaku Dasar / Tanggal Meninggal</td>
                        </tr>
                        <tr>
                            <td>
                                {!!PemberhentiankontrakModel::comboJenpens('[idjenpens]',$item->idjenpens,'','idjenpens validate[required]',Input::get('n'))!!}
                            </td>
                            <td>{!! comboGolrupppk(Input::get('n')."[idgolru]",$item->idgolruakhir_pppk,"required") !!}</td>
                            <td><input type="text" name="{!!Input::get('n')!!}[thkerja]" class="validate[required] form-control" value="{!!$item->mkthnpkt!!}" placeholder="00"></td> {{-- $thnmkskr+1 --}}
                            <td><input type="text" name="{!!Input::get('n')!!}[blkerja]" class="validate[required] form-control" value="{!!$item->mkblnpkt!!}" placeholder="00"></td>
                            <td>                                
                                <input type="text" name="{!!Input::get('n')!!}[no_dasar]" class="validate[required] form-control" placeholder="No. Dasar">
                            </td>
                            <td>
                                <div class='input-group datepicker'>
                                    <input type="text" name="{!!Input::get('n')!!}[tgl_dasar]" class="validate[required] form-control date" placeholder="dd-mm-yyyy">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class='input-group datepicker'>
                                    <input type="text" name="{!!Input::get('n')!!}[tmt_dasar]" class="validate[required] form-control date" placeholder="dd-mm-yyyy">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class='input-group datepicker'>
                                    <input type="text" name="{!!Input::get('n')!!}[bup]" class="validate[required] form-control date" placeholder="dd-mm-yyyy">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>                                
                                <input type="hidden" name="{!!Input::get('n')!!}[sts_kontrak]" value="3">                                
                                <input type="hidden" name="{!!Input::get('n')!!}[nipbaru]" value="{!!$item->nip!!}">                                
                                <input type="hidden" name="{!!Input::get('n')!!}[niplama]" value="{!!$item->niplama!!}">                                
                                <input type="hidden" name="{!!Input::get('n')!!}[nama]" value="{!!$item->namalengkap!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmlhr]" value="{!!$item->tmlhr!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tglhr]" value="{!!$item->tglhr!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjab]" value="{!!$item->idjenjab!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjab]" value="{!!$item->idjabatan!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[jab]" value="{!!$item->jabatan!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[kdunit]" value="{!!substr($item->idskpd,0,2)!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[idskpd]" value="{!!$item->idskpd!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[skpd]" value="{!!$item->skpdskr!!}">
                                      
                                <input type="hidden" name="{!!Input::get('n')!!}[nosk_calon]" value="{!!$item->noskcalonawal_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tglsk_calon]" value="{!!$item->tgskcalonawal_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[nosk_pppk]" value="{!!$item->noskawal_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tglsk_pppk]" value="{!!$item->tgskawal_pppk!!}">
                                
                                <input type="hidden" name="{!!Input::get('n')!!}[pejmen]" value="{!!$item->pejmenakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtawall]" value="{!!$item->tmtmulaiakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtakhirl]" value="{!!$item->tmtakhirakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[noskl]" value="{!!$item->nojanjiakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tgskl]" value="{!!$item->tgljanjiakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[idgolrul]" value="{!!$item->idgolruakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[golrul]" value="{!!$item->golru_p3k_akhir!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[thkerjal]" value="{!!$item->mkthnakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[blkerjal]" value="{!!$item->mkblnakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[gajil]" value="{!!$item->gajiakhir_pppk!!}">
                                
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtawal]" value="{!!$item->tmtmulaiakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtakhir]" value="{!!$item->tmtakhirakhir_pppk!!}">
                                {{-- <input type="hidden" name="{!!Input::get('n')!!}[idgolru]" value="{!!$item->idgolruakhir_pppk!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[golru]" value="{!!$item->golru_p3k_akhir!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[thkerja]" value="{!!$thnmkskr!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[blkerja]" value="{!!$blnmkskr!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[gaji]" value="{!!$item->gajiakhir_pppk!!}"> --}}

                                <input type="hidden" name="{!!Input::get('n')!!}[idtkpendid]" value="{!!$item->idtkpendid!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[tkpendid]" value="{!!$item->tkpendid!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjurusan]" value="{!!$item->idjenjurusan!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[jenjurusan]" value="{!!$item->jenjurusan!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[agama]" value="{!!$item->agama!!}">                                                              

                                <!-- BUPATI -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[bupati]" value="{!! getPenetapsk('005','namalengkap') !!}">
                                <!-- KEPALA BKPP -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[idpejab]" value="005">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[kepalabkd]" value="{!! getKepskpd('25','nama') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabkepalabkd]" value="{!! getKepskpd('25','jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nipkepalabkd]" value="{!! getKepskpd('25','nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatbkd]" value="{!! getKepskpd('25','pangkat') !!}">                                
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[golrubkd]" value="{!! getKepskpd('25','golru') !!}">                                

                                <!-- SEKDA -->                                
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[kepalasekda]" value="{!! getKepskpd('01','nama') !!}"> <!--$item->kdunit-->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabkepalasekda]" value="{!! getKepskpd('01','jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nipsekda]" value="{!! getKepskpd('01','nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatsekda]" value="{!! getKepskpd('01','pangkat') !!}">                                
                            
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[keterangan]" class="validate[required] form-control" placeholder="Keterangan Pemberhentian">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <em>* Apabila dalam Surat Dasar tidak terdapat Tanggal Berlaku Dasar diisi sama dengan Tanggal Dasar / diisi Tanggal Meninggal untuk pemberhentian dikarenakan meninggal.<br>* Harap periksa kembali biodata ASN apabila jenis jabatan dan nama jabatan belum sesuai dengan data sebenarnya.</em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif
