<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
    });

    $('.prev-hudis').on('click', function(e){
        e.preventDefault();
        var nip = $(this).attr('isnip');

        claravel_modal('Preview Riwayat Hukuman Disiplin','Loading...','main_modal');
        $.ajax({
            type:'post',
            url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/rhukdis',
            data: {'nip': nip, '_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    })
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
    $where = " tb_01.idjenkedudupeg not in('99','21') ";
    $having = "";

    /* Kondisi bulan kpr */
    if(Input::get('bulan') != ''){
        $having .= " MONTH(tmtpktnext) >= '".Input::get('bulan')."'";
    }

    /* Kondisi tahun kpr */
    if(Input::get('tahun') != ''){
        $having .= " AND YEAR(tmtpktnext)<='".Input::get('tahun')."'";
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd') != ''){
        $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    //jenis kp a ikut kondisi where krn ga da di tb_01
    // if(Input::get('idjeniskp') != ''){
    //     $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
    // }

    //jenjab ganti kp
    if(Input::get('idjeniskp') == 3){
        /*fungsional*/
        $interval = 2;
        $where .= " and tb_01.idjenjab = '2'";
        if(Input::get('filter_nopak') != ''){
            $where .= " and tb_01.nopak >= '".Input::get('filter_nopak')."'"; //nambah ini
        }
    }else if(Input::get('idjeniskp') == 1) {
        /*pelaksana*/
        $interval = 4;
        $where .= " and tb_01.idjenjab = 3";
    }else{
        /*struktural*/
        $interval = 4;
        $where .= " and tb_01.idjenjab > 4";
    }

    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_esl.idgolrumax','a_tkpendid.maxgol','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat',
        \DB::raw('IF(tb_01.idjenjab=2,DATE_ADD(tb_01.tmtpkt, INTERVAL 2 YEAR),DATE_ADD(tb_01.tmtpkt, INTERVAL 4 YEAR)) AS tmtpktnext'),
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
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
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
            \DB::raw("a_golruangcpn.golru as golrucpn,a_golruangcpn.pangkat as pangkatcpn, a_golruangpns.golru as golrupns,a_golruangpns.pangkat as pangkatpns")
        )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangcpn', 'tb_01.idgolrucpn', '=', 'a_golruangcpn.idgolru')
        ->leftjoin('a_golruang as a_golruangpns', 'tb_01.idgolrupns', '=', 'a_golruangpns.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->whereRaw($where)
        ->havingRaw($having)
        ->orderBy(\DB::raw('tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
        ->get();

    $ret = '<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">';
    $ret .='<thead class="bg-primary">
                <tr>
                    <th><input type="checkbox" name="checkall"  id="checkall" ></th>
                    <th><div class="text-center">No.</div></th>
                    <th>
                        <div class="text-center">NAMA</div>
                        <div class="text-center">TEMPAT, TGL LAHIR</div>
                    </th>
                    <th>
                        <div class="text-center">NIP</div>
                        <div class="text-center">KARPEG</div>
                        <div class="text-center">PAK LAMA</div>
                    </th>
                    <th width="17%">
                        <div class="text-center">JABATAN </div>
                        <div class="text-center">UNIT KERJA</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th>
                        <div class="text-center">ESELON</div>
                        <div class="text-center">TMT</div>
                    </th>
                    <th>
                        <div class="text-center">PANGKAT / GOL. CPNS</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA CPNS</div>
                    </th>
                    <th>
                        <div class="text-center">PANGKAT / GOL. PNS</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA PNS</div>
                    </th>
                    <th>
                        <div class="text-center">KENAIKAN SEKARANG</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA GOLONGAN</div>
                    </th>
            </thead>';

    $head = '<tr>
                <th colspan="2">&nbsp;</th>
                <th>
                    <div class="text-center">NAMA</div>
                    <div class="text-center">TEMPAT, TGL LAHIR</div>
                </th>
                <th>
                    <div class="text-center">NIP</div>
                    <div class="text-center">KARPEG</div>
                    <div class="text-center">PAK LAMA</div>
                </th>
                <th>
                    <div class="text-center">JABATAN </div>
                    <div class="text-center">UNIT KERJA</div>
                    <div class="text-center">TMT</div>
                </th>
                <th>
                    <div class="text-center">ESELON</div>
                    <div class="text-center">TMT</div>
                </th>
                <th>
                    <div class="text-center">PANGKAT / GOL. CPNS</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA CPNS</div>
                </th>
                <th>
                    <div class="text-center">PANGKAT / GOL. PNS</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA PNS</div>
                </th>
                <th>
                    <div class="text-center">PANGKAT SEKARANG)</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA GOLONGAN</div>
                </th>';

    $i=0; $x=0; $yellow = 0; $heads = '';
    if(count($rs) > 0){
        $ret .= '<tbody>';
        /* penomoran skkp */
        $periode = "01-".$data['bulan']."-".$data['tahun'];

        foreach($rs as $item){
            $golru_next=(in_array($item->idgolrupkt,[14,24,34]))?($item->idgolrupkt+7):($item->idgolrupkt+1);
            //kondisi jika gol. max struktural, pelaksana, fungsional
            if($item->idjenjab>4){
                $color = (($golru_next>$item->idgolrumax)?'style="background-color:yellow"':''); //sruktural
                $checklist = (($golru_next>$item->idgolrumax)?'':'checked'); //sruktural
            }else{
                $color = (($golru_next>$item->maxgol)?'style="background-color:yellow"':''); //fungsional, pelaksana
                $checklist = (($golru_next>$item->maxgol)?'':'checked'); //fungsional, pelaksana
            }

            /*cek yang ampir pensiun*/
            $kp = $item->tmtpktnext;
            $pen = $item->pensiunnext;

            $months = getMonth($pen, $kp);

            if($months > 0){

                $x++;
                $thmker = $item->mkthnpkt;
                $thmker2 = intval($thmker)+$interval; //4 or 2

                if (strlen($thmker)==1) $thmker="0".$thmker;
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
                $disabled = (($item->nip=='')?'disabled':'');
                $class = (($item->nip=='')?'disabled':'pilihnip');

                $iscek = 0;
                if($x>1){
                    $heads = $head;
                }

                $ret .= '<thead class="bg-primary">'.$heads.'</thead>
                    <tr '.$color.';">
                        <td><input type="checkbox" name="nip['.$i.']" value="'.$item->nip.'" class="'.$class.'" '.$disabled.' '.$checklist.'></td>
                        <td align="center">'.$x.'</td>
                        <td>
                            <span class="ed1" style="display:none">'.$item->nip.'</span>
                            <div class="text-left"><a href="javascript:void(0);" class="prev-hudis" title="Preview Riwayat" isnip="'.$item->nip.'">'.$item->namalengkap.'</a></div>
                            <small><div class="text-left">'.$item->tmlhr.', '.(($item->tglhr!="0000-00-00")?date("d-m-Y", strtotime($item->tglhr)):"").'</div></small>
                            <input type="hidden" name="skpd['.$item->nip.']" value="'.$item->idskpd.'" id="skpd['.$item->nip.']" style="width:40px">
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->nip.'</div>
                            <div class="text-center">'.$item->nokarpeg.'</div>
                            <div class="text-center">PAK lama : '.$item->nopak.'</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">'.$item->jabatan.'</div>
                                <div class="text-left"><i>Pada</i></div>
                                <div class="text-left">'.$item->path_short.'</div>
                                <div class="text-left">TMT : '.(($item->tmtjbt!="0000-00-00")?date("d-m-Y", strtotime($item->tmtjbt)):"").'</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->esl.'</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">'.$item->golrucpn.' - '.ucword($item->pangkatcpn).'</div>
                                <div class="text-left">'.(($item->tmtcpn!="0000-00-00")?date("d-m-Y", strtotime($item->tmtcpn)):"").'</div>
                                <div class="text-left">'.(($item->mkthncpn!="")?$item->mkthncpn:"0").' Tahun '.(($item->mkblncpn!="")?$item->mkblncpn:"0").' Bulan</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golrupns.' - '.ucword($item->pangkatpns).'</div>
                                <div class="text-left">'.(($item->tmtpns!="0000-00-00")?date("d-m-Y", strtotime($item->tmtpns)):"").'</div>
                                <div class="text-left">'.(($item->mkthnpns!="")?$item->mkthnpns:"0").' Tahun '.(($item->mkblnpns!="")?$item->mkblnpns:"0").' Bulan</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">'.$item->golru.' - '.ucword($item->pangkat).'</div>
                                <div class="text-left">'.(($item->tmtpkt!="0000-00-00")?date("d-m-Y", strtotime($item->tmtpkt)):"").'</div>
                                <div class="text-left">'.(($item->mkthnpkt!="")?$item->mkthnpkt:"0").' Tahun '.(($item->mkblnpkt!="")?$item->mkblnpkt:"0").' Bulan</div>
                            </small>
                        </td>
                    </tr>
                ';

                if($interval == 2){
                    $ret .= '<tr '.$color.'>
                        <td colspan="11">
                            <table width="100%" style="border: 1px solid #ececec">
                                <tr style="background-color: #ececec">
                                    <td rowspan="2" style="vertical-align:middle; border-right: 1px solid #ececec" width="30%">
                                        <div align="center">Atribut SK <br> Kenaikan Pangkat</div>
                                    </td>
                                    <td>Golongan : </td>
                                    <td colspan="4">Masa Kerja : </td>
                                    <td>TMT KP : </td>
                                    <td>Angka Kredit : </td>
                                </tr>
                                <tr>
                                    <td>'.comboGolru($name="golpnsskr[".$item->nip."]",((in_array($item->idgolrupkt,[14,24,34]))?($item->idgolrupkt+7):($item->idgolrupkt+1)),$required="required").'</td>
                                    <td><input type="text" name="mktkpb['.$item->nip.']" value="'.$thmker2.'" id="mktkpb['.$item->nip.']" class="form-control" maxlength="2" style="width:45px" required></td>
                                    <td style="vertical-align: middle">Tahun hih</td>
                                    <td><input type="text" name="mkbkpb['.$item->nip.']" value="'.((strlen($item->mkblnpkt)==1)?"0".$item->mkblnpkt:$item->mkblnpkt).'" id="mkbkpb['.$item->nip.']" class="form-control" maxlength="2" style="width:45px" required></td>
                                    <td style="vertical-align: middle">Bulan</td>
                                    <td><input type="text" class="input-medium tmt form-control" name="tmt['.$item->nip.']" id="tmt['.$item->nip.']" placeholder="dd-mm-yyyy" value="'.$periode.'" '.$disabled.' required></td>
                                    <td><input type="text" name="nopak['.$item->nip.']" value="'.$item->nopak.'" id="nopak['.$item->nip.']" class="form-control" required></td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
                }else{
                    $ret .= '<tr '.$color.'>
                        <td colspan="11">
                            <table width="100%" style="border: 1px solid #ececec">
                                <tr style="background-color: #ececec">
                                    <td rowspan="2" style="vertical-align:middle; border-right: 1px solid #ececec" width="40%">
                                        <div align="center">Atribut SK <br> Kenaikan Pangkat</div>
                                    </td>
                                    <td>Golongan : </td>
                                    <td colspan="4">Masa Kerja : </td>
                                    <td>TMT KP : </td>
                                </tr>
                                <tr>
                                    <td>'.comboGolru($name="golpnsskr[".$item->nip."]",((in_array($item->idgolrupkt,[14,24,34]))?($item->idgolrupkt+7):($item->idgolrupkt+1)),$required="required").'</td>
                                    <td><input type="text" name="mktkpb['.$item->nip.']" value="'.$thmker2.'" id="mktkpb['.$item->nip.']" class="form-control" maxlength="2" style="width:45px" required></td>
                                    <td style="vertical-align: middle">Tahun</td>
                                    <td><input type="text" name="mkbkpb['.$item->nip.']" value="'.((strlen($item->mkblnpkt)==1)?"0".$item->mkblnpkt:$item->mkblnpkt).'" id="mkbkpb['.$item->nip.']" class="form-control" maxlength="2" style="width:45px" required></td>
                                    <td style="vertical-align: middle">Bulan</td>
                                    <td>
                                    <input type="text" class="input-medium tmt form-control" name="tmt['.$item->nip.']" id="tmt['.$item->nip.']" placeholder="dd-mm-yyyy" value="'.$periode.'" '.$disabled.' required>
                                    <input type="hidden" name="nopak['.$item->nip.']" value="" id="nopak['.$item->nip.']" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
                }

                $i++;
            }
            $ret .= '</tbody>';
        }
    }else{
        $ret.='<tbody><tr><td colspan="8">Daftar Nominasi Kenaikan Pangkat Tidak Tersedia.</td></tr></tbody>';
    }
    $ret.='</table>';

    if($yellow > 0){
        $ret.="<span style='background-color:#f3f99a; border: 1px solid #ececec;'>&nbsp;&nbsp;&nbsp;&nbsp;</span> : Kenaikan Pangkat pada masa kerja dan golongan sudah habis.";
    }

    echo $ret;
?>