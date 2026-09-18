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
    $having = "";
    $idkgb = $data['tahun']."".$data['bulan'].".".$data['idskpd'];
    $where = "  tb_01.nip NOT IN (SELECT nip FROM tr_kgb WHERE idkgb like \"".$idkgb."%\")
                and tb_01.idjenkedudupeg not in('99','21')";

    /* Kondisi bulan kgb */
    if($data['bulan'] != ''){
        $having .= "MONTH(tmtkgbnext)='".$data['bulan']."'";
    }else{
        $having .= "";
    }

    /* Kondisi tahun kpr */
    if($data['tahun'] != ''){
        $having .= "AND YEAR(tmtkgbnext)='".$data['tahun']."'";
    }else{
        $having .= "";
    }

    /* Kondisi skpd atau unit kerja */
    switch($data['idskpd']){
        case "": $where .= " "; break;
        default:
            $xkpd = $data['idskpd'];
            $where .= " and tb_01.idskpd like '$xkpd%'";
    }

    //status pegawai
    if($data['idstspeg'] != ''){
        $where .= " and tb_01.idstspeg = '".$data['idstspeg']."'";
    }

    $urutan = "tmtpkt < tmtkgb, tb_01.idgolrupkt, tmtpkt, tb_01.nama";

    $ret = '<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">';
    $ret .='<thead class="bg-primary">
                <tr>
                    <th><input type="checkbox" name="checkall"  id="checkall" checked></th>
                    <th><div class="text-center">No.</div></th>
                    <th>
                        <div class="text-center">NAMA</div>
                        <div class="text-center">TEMPAT, TGL LAHIR</div>
                    </th>
                    <th>
                        <div class="text-center">NIP</div>
                        <div class="text-center">KARPEG</div>
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
                    </th>
                    <th>
                        <div class="text-center">KENAIKAN PANGKAT<br>(GOL. SEKARANG)</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA GOLONGAN</div>
                    </th>
                    <th>
                        <div class="text-center">KGB TERKAHIR</div>
                        <div class="text-center">NO. SK KGB</div>
                        <div class="text-center">TANGGAL</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA</div>
                        <div class="text-center">GAJI</div>
                    </th>
                    <th>
                        <div class="text-center">KGB BARU</div>
                        <div class="text-center">TMT</div>
                        <div class="text-center">MASA KERJA</div>
                        <div class="text-center">GAJI</div>
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
                </th>
                <th>
                    <div class="text-center">KENAIKAN PANGKAT<br>(GOL. SEKARANG)</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA GOLONGAN</div>
                </th>
                <th>
                    <div class="text-center">KGB TERKAHIR</div>
                    <div class="text-center">NO. SK KGB</div>
                    <div class="text-center">TANGGAL</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA</div>
                    <div class="text-center">GAJI</div>
                </th>
                <th>
                    <div class="text-center">KGB BARU</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA</div>
                    <div class="text-center">GAJI</div>
                </th>';

    $periode = $data['tahun']."-".$data['bulan']."-01";

    $input_periode = date('Y-m-d', strtotime($periode . ' -3 months'));
    $tgl_sekarang = date('Y-m-d');
    // echo $input_periode.",".$tgl_sekarang; exit();
    if($tgl_sekarang >= $input_periode){

        $rs = \DB::table('tb_01')
                ->select('tb_01.*','a_golruang.golru','a_golruang.pangkat','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                \DB::raw('DATE_ADD(tb_01.tmtkgb, INTERVAL 2 YEAR) AS tmtkgbnext'),
                \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
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
                \DB::raw("a_golruangcpn.golru as golrucpn,a_golruangcpn.pangkat as pangkatcpn, a_golruangpns.golru as golrupns,a_golruangpns.pangkat as pangkatpns, a_golruangkgb.golru as golrukgb,a_golruangkgb.pangkat as pangkatkgb")
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
            ->leftjoin('a_golruang as a_golruangcpn', 'tb_01.idgolrucpn', '=', 'a_golruangcpn.idgolru')
            ->leftjoin('a_golruang as a_golruangpns', 'tb_01.idgolrupns', '=', 'a_golruangpns.idgolru')
            ->leftjoin('a_golruang as a_golruangkgb', 'tb_01.idgolkgb', '=', 'a_golruangkgb.idgolru')
            ->whereRaw($where)
            ->havingRaw($having)
            ->orderBy(\DB::raw($urutan))
            ->get();

    $i=0; $x=0; $yellow = 0; $heads = '';
    
        if(count($rs) > 0){
        $ret .= '<tbody>';
        /* penomoran skkgb */
        $nourut = (int) PenetapannominatifModel::getcountersk($periode);
        

        foreach($rs as $item){
            /*cek yang ampir pensiun*/
            $kgb = $item->tmtkgbnext;
            $pen = $item->pensiunnext;
            $months = getMonth($pen, $kgb);

            if($months > 0){
                if($data['idstspeg']==3 and PenetapannominatifModel::cekKgbP3k($item->nip,$data['tahun'])==1){
                //start kgb p3k
                $x++;
                /*Perikas jika tmmt pkt lebih bsar dari tmtkgb lama*/
                if($item->tmtpkt > $item->tmtkgb){
                    $thmker = $item->mkgolthnkgb;
                    $thmker2 = intval($thmker)+2;
                    if(substr($item->idgolrupkt,0,1) != substr($item->idgolkgb,0,1)){
                        if(substr($item->idgolrupkt,0,1) == '2'){
                            /*jika golongan 1 ke 2 - 6*/
                            $thmker2 = $thmker2 - 6;
                        }else if(substr($item->idgolrupkt,0,1) == '3'){
                            /*jika golongan 2 ke 3 - 5*/
                            $thmker2 = $thmker2 - 5;
                        }
                    }
                }else{
                    $thmker = $item->mkgolthnkgb;
                    $thmker2 = intval($thmker)+2;
                }
                /*endof cek*/
                //$thmker = $item->mkgolthnkgb;

                if (strlen($thmker)==1) $thmker="0".$thmker;
                //$thmker2 = intval($thmker)+2;
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
                $disabled = (($item->nip=='')?'disabled':'');
                $class = (($item->nip=='')?'disabled':'pilihnip');

                if(getgaji($item->idgolrupkt,$thmker2) == getgaji($item->idgolrupkt,$thmker)){
                    $style = ' style="background-color:#f3f99a"';
                    $iscek = 1;
                    $yellow++;
                }else{
                    $iscek = 0;
                }

                if($x>1){
                    $heads = $head;
                }

                $ret .= '<thead class="bg-primary">'.$heads.'</thead>
                    <tr '.$style.'>
                        <td><input type="checkbox" name="nip['.$i.']" value="'.$item->nip.'" class="'.$class.'" '.$disabled.' '.(($iscek != 1)?"checked":"").'></td>
                        <td align="center">'.$x.'</td>
                        <td>
                            <span class="ed1" style="display:none">'.$item->nip.'</span>
                            <div class="text-left"><a href="javascript:void(0);" class="prev-hudis" title="Preview Riwayat" isnip="'.$item->nip.'">'.$item->nama.'</a></div>
                            <small><div class="text-left">'.$item->tmlhr.', '.(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'').'</div></small>
                            <input type="hidden" name="skpd['.$item->nip.']" value="'.$item->idskpd.'" id="skpd['.$item->nip.']" style="width:40px">
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->nip.'</div>
                            <div class="text-center">'.$item->nokarpeg.'</div>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.ucword($item->jabatan).' pada '.$item->path_short.'</div>
                                <div class="text-left">TMT : '.(($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):'').'</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->esl.'</div>
                            <div class="text-center">'.(($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):'').'</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">'.$item->golrucpn.' - '.ucword($item->pangkatcpn).'</div>
                                <div class="text-left">'.(($item->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item->tmtcpn)):'').'</div>
                                <div class="text-left">'.$item->mkthncpn.' Tahun '.$item->mkblncpn.' Bulan</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golrupns.' - '.ucword($item->pangkatpns).'</div>
                                <div class="text-left">'.(($item->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpns)):'').'</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golru.' - '.ucword($item->pangkat).'</div>
                                <div class="text-left">'.(($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):'').'</div>
                                <div class="text-left">'.$item->mkthnpkt.' Tahun '.$item->mkblnpkt.' Bulan</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golrukgb.' - '.ucword($item->pangkatkgb).'</div>
                                <div class="text-left">'.(($item->noskkgb=='')?'&nbsp;':ucword($item->noskkgb)).'</div>
                                <div class="text-left">'.(($item->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgb)):'').'</div>
                                <div class="text-left">'.$item->mkgolthnkgb.' Tahun '.$item->mkgolblnkgb.' Bulan</div>
                                <div class="text-left">Rp. '.number_format(getgaji($item->idgolrupkt,$thmker)).'</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">&nbsp;</div>
                                <div class="text-left">'.(($item->tmtkgbnext!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgbnext)):'').'</div>
                                <div class="text-left">'.$thmker2.' Tahun '.$item->mkgolblnkgb.' Bulan</div>
                                <div class="text-left">Rp. '.number_format(getgaji($item->idgolrupkt,$thmker2)).'</div>
                            </small>
                        </td>
                    </tr>
                ';

                $ret .= '<tr '.$style.'>
                    <td colspan="11">
                        <table width="100%" style="border: 1px solid #ececec">
                            <tr style="background-color: #ececec">
                                <td rowspan="2" style="vertical-align:middle; border-right: 1px solid #ececec" width="40%">
                                    <div align="center">Atribut SK <br> Kenaikan Gaji Berkala</div>
                                </td>
                                <td>Golongan : </td>
                                <td colspan="4">Masa Kerja : </td>
                                <td>Tanggal SK KGB : </td>
                            </tr>
                            <tr>
                                <td>'.comboGolru($name="golpnsskr[".$item->nip."]",$item->idgolrupkt,$required="required").'</td>
                                <td><input type="text" name="mktkgbb['.$item->nip.']" value="'.$thmker2.'" id="mkthncpn['.$item->nip.']" class="mkthncpn['.$item->nip.'] form-control" maxlength="2" style="width:45px"></td>
                                <td style="vertical-align: middle">Tahun</td>
                                <td><input type="text" name="mkbkgbb['.$item->nip.']" value="'.((strlen($item->mkgolblnkgb)==1)?'0'.$item->mkgolblnkgb:$item->mkgolblnkgb).'" id="mkblncpn['.$item->nip.']" class="mkblncpn['.$item->nip.'] form-control" maxlength="2" style="width:45px"></td>
                                <td style="vertical-align: middle">Bulan</td>
                                <td><input type="text" class="input-medium tmt form-control" name="tgskkgb['.$item->nip.']" id="tgskkgb['.$item->nip.']" placeholder="dd-mm-yyyy" value="'.$data['tglskkgb'].'" '.$disabled.' required></td>
                            </tr>
                        </table>
                    </td>
                </tr>';

                $i++;
                $nourut++;
            }
            elseif($item->idstspeg!=3){
                //start kgb pns
                $x++;
                /*Perikas jika tmmt pkt lebih bsar dari tmtkgb lama*/
                if($item->tmtpkt > $item->tmtkgb){
                    $thmker = $item->mkgolthnkgb;
                    $thmker2 = intval($thmker)+2;
                    if(substr($item->idgolrupkt,0,1) != substr($item->idgolkgb,0,1)){
                        if(substr($item->idgolrupkt,0,1) == '2'){
                            /*jika golongan 1 ke 2 - 6*/
                            $thmker2 = $thmker2 - 6;
                        }else if(substr($item->idgolrupkt,0,1) == '3'){
                            /*jika golongan 2 ke 3 - 5*/
                            $thmker2 = $thmker2 - 5;
                        }
                    }
                }else{
                    $thmker = $item->mkgolthnkgb;
                    $thmker2 = intval($thmker)+2;
                }
                /*endof cek*/
                //$thmker = $item->mkgolthnkgb;

                if (strlen($thmker)==1) $thmker="0".$thmker;
                //$thmker2 = intval($thmker)+2;
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
                $disabled = (($item->nip=='')?'disabled':'');
                $class = (($item->nip=='')?'disabled':'pilihnip');

                if(getgaji($item->idgolrupkt,$thmker2,$item->idstspeg) == getgaji($item->idgolrupkt,$thmker,$item->idstspeg)){
                    $style = ' style="background-color:#f3f99a"';
                    $iscek = 1;
                    $yellow++;
                }else{
                    $iscek = 0;
                }

                if($x>1){
                    $heads = $head;
                }

                $ret .= '<thead class="bg-primary">'.$heads.'</thead>
                    <tr '.$style.'>
                        <td><input type="checkbox" name="nip['.$i.']" value="'.$item->nip.'" class="'.$class.'" '.$disabled.' '.(($iscek != 1)?"checked":"").'></td>
                        <td align="center">'.$x.'</td>
                        <td>
                            <span class="ed1" style="display:none">'.$item->nip.'</span>
                            <div class="text-left"><a href="javascript:void(0);" class="prev-hudis" title="Preview Riwayat" isnip="'.$item->nip.'">'.$item->nama.'</a></div>
                            <small><div class="text-left">'.$item->tmlhr.', '.(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'').'</div></small>
                            <input type="hidden" name="skpd['.$item->nip.']" value="'.$item->idskpd.'" id="skpd['.$item->nip.']" style="width:40px">
                            <input type="hidden" name="idstspeg['.$item->nip.']" value="'.$item->idstspeg.'" id="idstspeg['.$item->nip.']">
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->nip.'</div>
                            <div class="text-center">'.$item->nokarpeg.'</div>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.ucword($item->jabatan).' pada '.$item->path_short.'</div>
                                <div class="text-left">TMT : '.(($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):'').'</div>
                            </small>
                        </td>
                        <td align="center">
                            <div class="text-center">'.$item->esl.'</div>
                            <div class="text-center">'.(($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):'').'</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">'.$item->golrucpn.' - '.ucword($item->pangkatcpn).'</div>
                                <div class="text-left">'.(($item->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item->tmtcpn)):'').'</div>
                                <div class="text-left">'.$item->mkthncpn.' Tahun '.$item->mkblncpn.' Bulan</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golrupns.' - '.ucword($item->pangkatpns).'</div>
                                <div class="text-left">'.(($item->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpns)):'').'</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golru.' - '.ucword($item->pangkat).'</div>
                                <div class="text-left">'.(($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):'').'</div>
                                <div class="text-left">'.$item->mkthnpkt.' Tahun '.$item->mkblnpkt.' Bulan</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">'.$item->golrukgb.' - '.ucword($item->pangkatkgb).'</div>
                                <div class="text-left">'.(($item->noskkgb=='')?'&nbsp;':ucword($item->noskkgb)).'</div>
                                <div class="text-left">'.(($item->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgb)):'').'</div>
                                <div class="text-left">'.$item->mkgolthnkgb.' Tahun '.$item->mkgolblnkgb.' Bulan</div>
                                <div class="text-left">Rp. '.number_format(getgaji($item->idgolrupkt,$thmker,$item->idstspeg)).'</div>
                            </small>
                        </td>
                        <td align="center">
                            <small>
                                <div class="text-left">&nbsp;</div>
                                <div class="text-left">'.(($item->tmtkgbnext!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgbnext)):'').'</div>
                                <div class="text-left">'.$thmker2.' Tahun '.$item->mkgolblnkgb.' Bulan</div>
                                <div class="text-left">Rp. '.number_format(getgaji($item->idgolrupkt,$thmker2,$item->idstspeg)).'</div>
                            </small>
                        </td>
                    </tr>
                ';

                $ret .= '<tr '.$style.'>
                    <td colspan="11">
                        <table width="100%" style="border: 1px solid #ececec">
                            <tr style="background-color: #ececec">
                                <td rowspan="2" style="vertical-align:middle; border-right: 1px solid #ececec" width="40%">
                                    <div align="center">Atribut SK <br> Kenaikan Gaji Berkala</div>
                                </td>
                                <td>Golongan : </td>
                                <td colspan="4">Masa Kerja : </td>
                                <td>Tanggal SK KGB : </td>
                            </tr>
                            <tr>
                                <td>'.comboGolru($name="golpnsskr[".$item->nip."]",$item->idgolrupkt,$required="required",($item->idstspeg==3?'2':'1')).'</td>
                                <td><input type="text" name="mktkgbb['.$item->nip.']" value="'.$thmker2.'" id="mkthncpn['.$item->nip.']" class="mkthncpn['.$item->nip.'] form-control" maxlength="2" style="width:45px"></td>
                                <td style="vertical-align: middle">Tahun</td>
                                <td><input type="text" name="mkbkgbb['.$item->nip.']" value="'.((strlen($item->mkgolblnkgb)==1)?'0'.$item->mkgolblnkgb:$item->mkgolblnkgb).'" id="mkblncpn['.$item->nip.']" class="mkblncpn['.$item->nip.'] form-control" maxlength="2" style="width:45px"></td>
                                <td style="vertical-align: middle">Bulan</td>
                                <td><input type="text" class="input-medium tmt form-control" name="tgskkgb['.$item->nip.']" id="tgskkgb['.$item->nip.']" placeholder="dd-mm-yyyy" value="'.$data['tglskkgb'].'" '.$disabled.' required></td>
                            </tr>
                        </table>
                    </td>
                </tr>';

                $i++;
                $nourut++;
                //end kgb pns    
                }               
            }
            $ret .= '</tbody>';
        }//end foreach
    }else{
        $ret.='<tbody><tr><td colspan="11">Daftar Nominasi Kenaikan Gaji Berkala Tidak Tersedia.</td></tr></tbody>';
    }
    $ret.='</table>';

    if($yellow > 0){
        $ret.="<span style='background-color:#f3f99a; border: 1px solid #ececec;'>&nbsp;&nbsp;&nbsp;&nbsp;</span> : Kenaikan gaji berkala pada masa kerja dan golongan sudah habis.";
    }
    
    }else{
        $ret.='<tbody><tr><td colspan="11"><div class="callout callout-danger" style="font-size: 15px"><i class="fa fa-info-circle"></i> Penetapan KGB hanya bisa dilakukan minimal 3 bulan sebelum TMT KGB dari tanggal sekarang.</div></td></tr></tbody>';
    }

    echo $ret;
?>