<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
    });
</script>

<style type='text/css'>
    table {
        font-family: 'Arial';
        font-size: 9pt;
        background: white;
        line-height:1.5;
    }

    table{
        border-collapse:collapse;
        border-width:1px;
        width:100%;
    }

    table thead tr th,table tfoot tr th{
        background-color:#337ab7;
        font-weight:bold;
        padding:4px;
    }

    table tbody tr td{
        padding:4px;
        vertical-align:top;
    }

    table.gen tbody tr td{
        /*height:40px; */
    }

    small{
        font-size: 11px;
    }

    table tbody td div.r,table tfoot td div.r,table tfoot th div.r{
        text-align:right;
    }
</style>

<?php
    $urutan = "tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama";

    $ret = '<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">';
    $ret .='<thead class="bg-primary">
                <tr>
                    <th rowspan="2"><input type="checkbox" name="checkall"  id="checkall" checked></th>
                    <th rowspan="2"><div class="text-center">No.</div></th>
                    <th rowspan="2">
                        <div class="text-center">NAMA LENGKAP</div>
                        <div class="text-center">TEMPAT TANGGAL LAHIR</div>
                    </th>
                    <th rowspan="2" width="7%">
                        <div class="text-center">NIP</div>
                        <div class="text-center">NIP LAMA</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">GOL.</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">ESL</div>                        
                    </th>
                    <th rowspan="3" width="17%">
                        <div class="text-center">JABATAN </div>
                        <div class="text-center">UNIT KERJA</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th colspan="2">
                        <div class="text-center">MASA KERJA</div>                        
                    </th>
                    <th colspan="2">
                        <div class="text-center">S/D SEKARANG</div>                        
                    </th>
                    <th colspan="2">
                        <div class="text-center">PENDIDIKAN TERAKHIR</div>                        
                    </th>
                    <th rowspan="2">
                        <div class="text-center">AGAMA</div> 
                        <div class="text-center">USIA</div>                       
                    </th>
                    <th rowspan="2">
                        <div class="text-center">TMT</div>
                        <div class="text-center">USIA PENSIUN</div>                         
                    </th>
                </tr>
                <tr>
                    <th>
                        <divclass="text-center">THN</div>
                    </th>
                    <th>
                        <divclass="text-center">BLN</div>
                    </th>
                    <th>
                        <divclass="text-center">THN</div>
                    </th>
                    <th>
                        <divclass="text-center">BLN</div>
                    </th>
                    <th>
                        <divclass="text-center">TINGKAT</div>
                    </th>
                    <th>
                        <divclass="text-center">JURUSAN</div>
                    </th>                
                </tr>            
            </thead>';            

    $head = '<tr>
                    <th colspan="2" rowspan="2">&nbsp;</th>
                    <th rowspan="2">
                        <div class="text-center">NAMA LENGKAP</div>
                        <div class="text-center">TEMPAT TANGGAL LAHIR</div>
                    </th>
                    <th rowspan="2" width="7%">
                        <div class="text-center">NIP</div>
                        <div class="text-center">NIP LAMA</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">GOL.</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th rowspan="2">
                        <div class="text-center">ESL</div>                        
                    </th>
                    <th rowspan="3" width="17%">
                        <div class="text-center">JABATAN </div>
                        <div class="text-center">UNIT KERJA</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th colspan="2">
                        <div class="text-center">MASA KERJA</div>                        
                    </th>
                    <th colspan="2">
                        <div class="text-center">S/D SEKARANG</div>                        
                    </th>
                    <th colspan="2">
                        <div class="text-center">PENDIDIKAN TERAKHIR</div>                        
                    </th>
                    <th rowspan="2">
                        <div class="text-center">AGAMA</div> 
                        <div class="text-center">USIA</div>                       
                    </th>
                    <th rowspan="2">
                        <div class="text-center">TMT</div>
                        <div class="text-center">USIA PENSIUN</div>                         
                    </th>
                </tr>
                <tr>
                    <th>
                        <divclass="text-center">THN</div>
                    </th>
                    <th>
                        <divclass="text-center">BLN</div>
                    </th>
                    <th>
                        <divclass="text-center">THN</div>
                    </th>
                    <th>
                        <divclass="text-center">BLN</div>
                    </th>
                    <th>
                        <divclass="text-center">TINGKAT</div>
                    </th>
                    <th>
                        <divclass="text-center">JURUSAN</div>
                    </th>                
                </tr>';

    //Job Bradi Sibarani
    $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
    if (Input::has('search') or Input::has('idskpd') or Input::has('idjenjab') or Input::has('tahun') or Input::has('bulan1') or Input::has('bulan2')) {
        $having = '';

        /* Kondisi jabatan jabatan*/
        if(Input::get('idjenjab') != ''){
            $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."'";
        }

        /* Kondisi Tahun */
        if(Input::get('tahun') != ''){
            $having .= (($having != '')?' AND ':'')." YEAR(pensiunnext)= ".Input::get('tahun')."";
        }

        /* Kondisi Bulan */
        if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
            $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
        }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
            $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext)= ".Input::get('bulan1')."";
        }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
            $having .= (($having != '')?' AND ':'')." MONTH(pensiunnext)= ".Input::get('bulan2')."";
        }

        /* Kondisi skpd atau unit kerja */
        if(Input::get('idskpd') != ''){
            $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
        }

        /* Kondisi search */
        if(Input::get('search') != ''){
            $where.= "and (tb_01.nama like '%".Input::get('search')."%' or tb_01.nip like '%".Input::get('search')."%')";
        }

        if($having != ''){
            $entripensiuns = \DB::table('tb_01')
                ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
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
                ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                ->whereRaw($where)
                ->havingRaw($having)
                ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
                ->get();
        }else{
            $entripensiuns = \DB::table('tb_01')
                ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                    \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF((tb_01.idjenjab=3) OR (tb_01.idesljbt >=31 and tb_01.idesljbt <= 52) /*OR (tb_01.idjenjab=2 AND tb_01.idgolrupkt <= 34)*/,58,60) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
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
                ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))                
                ->paginate($_ENV['configurations']['list-limit']);
        }       
    }        
    
    $i=0; $x=0; $yellow = 0; $heads = '';
    if(count($entripensiuns) > 0){
        $ret .= '<tbody>';       

        foreach($entripensiuns as $item){           
                $x++;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
                $disabled = (($item->nip=='')?'disabled':'');
                $class = (($item->nip=='')?'disabled':'pilihnip');

                if($x>1){
                    $heads = $head;
                }

                $ret .= '<thead class="bg-primary">'.$heads.'</thead>
                    <tr '.$style.'>
                        <td><input type="checkbox" name="nip['.$i.']" value="'.$item->nip.'" class="'.$class.'" '.$disabled.' checked></td>
                        <td align="center">'.$x.'</td>
                        <td>
                            <span class="ed1" style="display:none">'.$item->nip.'</span>
                            <div class="text-left"><a href="javascript:void(0);" class="prev-hudis" title="Preview Riwayat" isnip="'.$item->nip.'">'.$item->nama.'</a></div>
                            <small><div class="text-left">'.$item->tmlhr.', '.(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'').'</div></small>
                            <input type="hidden" name="skpd['.$item->nip.']" value="'.$item->idskpd.'" id="skpd['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="tmtpens['.$item->nip.']" value="'.$item->pensiunnext.'" id="tmtpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almskrpens['.$item->nip.']" value="'.$item->alm.'" id="almskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almrtskrpens['.$item->nip.']" value="'.$item->almrt.'" id="almrtskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almrwskrpens['.$item->nip.']" value="'.$item->almrw.'" id="almrwskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almdesaskrpens['.$item->nip.']" value="'.$item->almdesa.'" id="almdesaskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almkecskrpens['.$item->nip.']" value="'.$item->almkec.'" id="almkecskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almkabskrpens['.$item->nip.']" value="'.$item->almkab.'" id="almkabskrpens['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="almprovskrpens['.$item->nip.']" value="'.$item->almprov.'" id="almprovskrpens['.$item->nip.']" style="width:40px">

                            <input type="hidden" class="form-control" name="bupati['.$item->nip.']" value="'.getPenetapsk('005','namalengkap').'">
                            <input type="hidden" class="form-control" name="idpejabpens['.$item->nip.']" value="033">
                            <input type="hidden" class="form-control" name="pejpenpens['.$item->nip.']" value="'.getKepskpd('25','nama').'"> <!--$item->kdunit-->
                            <input type="hidden" class="form-control" name="jabpenpens['.$item->nip.']" value="'.getKepskpd('25','jab').'">
                            <input type="hidden" class="form-control" name="nippenpens['.$item->nip.']" value="'.getKepskpd('25','nip').'">
                            <input type="hidden" class="form-control" name="pangkatpenpens['.$item->nip.']" value="'.getKepskpd('25','pangkat').'">
                            <input type="hidden" class="form-control" name="golrupenpens['.$item->nip.']" value="'.getKepskpd('25','golru').'">

                            <input type="hidden" class="form-control" name="pejpen_sp['.$item->nip.']" value="'.getKepskpd($item->kdunit,'nama').'"> <!--$item->kdunit-->
                            <input type="hidden" class="form-control" name="jabpen_sp['.$item->nip.']" value="'.getKepskpd($item->kdunit,'jab').'">
                            <input type="hidden" class="form-control" name="nippen_sp['.$item->nip.']" value="'.getKepskpd($item->kdunit,'nip').'">
                            <input type="hidden" class="form-control" name="golpen_sp['.$item->nip.']" value="'.getKepskpd($item->kdunit,'pangkat').'">

                            <input type="hidden" class="form-control" name="pejpen_hukpid['.$item->nip.']" value="'.getKepskpd($item->kdunit,'nama').'"> 
                            <input type="hidden" class="form-control" name="jabpen_hukpid['.$item->nip.']" value="'.getKepskpd($item->kdunit,'jab').'">
                            <input type="hidden" class="form-control" name="nippen_hukpid['.$item->nip.']" value="'.getKepskpd($item->kdunit,'nip').'">
                            <input type="hidden" class="form-control" name="golpen_hukpid['.$item->nip.']" value="'.getKepskpd($item->kdunit,'pangkat').'">
                            <input type="hidden" class="form-control" name="pangpen_hukpid['.$item->nip.']" value="'.getKepskpd($item->kdunit,'golru').'">
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->nip.'</div>
                            <div class="text-center">'.$item->nokarpeg.'</div>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golru.'</div>
                                <div class="text-left">'.(($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):'').'</div>                                
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->esl.'</div>                            
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.ucword($item->jabatan).' pada '.$item->path_short.'</div>
                                <div class="text-left">TMT : '.(($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):'').'</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->mkthnpkt.'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->mkblnpkt.'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.substr($item->mkskr,0,-2).'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.substr($item->mkskr,-2).'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->tkpendid.'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->jenjurusan.'</div>                            
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->agama.'</div>   
                            <div class="text-center">'.substr($item->usia,0,2)." thn ".substr($item->usia,2,2).' bln</div> 
                        </td>
                        <td align="center">
                            <div class="text-center">'.(($item->pensiunnext!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($item->pensiunnext)):'').'</div>   
                            <div class="text-center">'.$item->usiapens.' thn</div> 
                        </td>
                        
                    </tr>
                ';

                

                $i++;               
            $ret .= '</tbody>';
        }
    }else{
        $ret.='<tbody><tr><td colspan="11">Daftar Nominasi Pensiun Tidak Tersedia.</td></tr></tbody>';
    }
    $ret.='</table>';

    if($yellow > 0){
        $ret.="<span style='background-color:#f3f99a; border: 1px solid #ececec;'>&nbsp;&nbsp;&nbsp;&nbsp;</span> : Kenaikan gaji berkala pada masa kerja dan golongan sudah habis.";
    }

    echo $ret;
?>