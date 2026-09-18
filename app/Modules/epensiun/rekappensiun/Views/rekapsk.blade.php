
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>DPCP Pensiun Kolektif</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: F4 potrait;
                margin-left: 0in;
                margin-right: 0in;
                margin-top: 0in;
                margin-bottom: 0.15in;
            }
            .page-break	{ display:block; page-break-before:always; }
        }

        *{
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        html {
            font-family: 'Arial';
            font-size: 11pt;
            background: white;
            line-height:1.5;
            padding: 0;
            margin: 0;
        }

        body{
            position: relative;
        }

        div.print{
            background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
            width:110px;
            height:110px;
            top:20;
            right:50;
            position:fixed;
            opacity:0.1;
            cursor:pointer;
            right: 5px;
        }

        div.print:hover{
            opacity:1;
        }

        table{
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            padding: 0;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>

    <div class="print"></div>
    <?php
        date_default_timezone_set("Asia/Jakarta");
    
        $idskpd = Input::get('idskpd');
        $tanggal1 = Input::get('tanggal1');
        $tanggal2 = Input::get('tanggal2');

        $where = "a.nip != ''";        
        $where.= ((Input::get('tanggal1') != '') and (Input::get('tanggal2') != ''))?" and a.tgskpens >= \"".tglFormat(Input::get('tanggal1'))."\" and a.tgskpens <= \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= ((Input::get('tanggal1') != '') and (Input::get('tanggal2') == ''))?" and a.tgskpens = \"".tglFormat(Input::get('tanggal1'))."\"":"";
        $where.= ((Input::get('tanggal1') == '') and (Input::get('tanggal2') != ''))?" and a.tgskpens = \"".tglFormat(Input::get('tanggal2'))."\"":"";
        $where.= (Input::get('idskpd') != '')?" and b.idskpd like 'like '$idskpd%'":"";          

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where)
            ->get();        

        if(count($rs) > 0){
            $jml = count($rs);
            $i = 0;
            foreach($rs as $item){
                $ranak = \NominatifpensiunModel::getRanak($item->nip,1);
                
                $i++;                
                
                $arrsearch = array("search","[unit_kerja]","[tmt_pensiun]","[tanggal_dpcp]","[nip]","[nama_pegawai]","[tempat_lahir]","[tanggal_lahir]","[jabatan]",
                "[pangkat]","[golongan]","[mkthn_gol]","[mkbln_gol]","[mkthn_pens]","[mkbln_pens]","[mkthn_awal]","[mkbln_awal]","[gaji_pokok]",
                "[tk_pendid]","[tahun_lulus]","[tmt_masukpns]","[riwayat_issu]","[riwayat_anak]","[jalan_sekarang]","[rt_sekarang]","[rw_sekarang]",
                "[desa_sekarang]","[kecamatan_sekarang]","[kabupaten_sekarang]","[provinsi_sekarang]","[jalan_pens]","[rt_pens]","[rw_pens]","[desa_pens]",
                "[kecamatan_pens]","[kabupaten_pens]","[provinsi_pens]","[jabatan_penetap]","[pejabat_penetap]","[golongan_penetap]","[nip_penetap]");
                
                $rs = \DB::table('a_skpd')->where('idskpd', substr($item->idskpd,0,2))->first();
                $tembusan = ucword($rs->jab_utuh);
                $attr = \NominatifpensiunModel::attrPengantar($item->kdunit);
                // dd($attr->jab);
                $arrreplace = array("replace",ucword($item->skpd),formatTanggalPanjang($item->tmtpens),formatTanggalPanjang($item->tgskpens),$item->nip,$item->nama,$item->tmlhr,formatTanggalPanjang($item->tglhr),$item->jabatan,
                $item->golpnsskr_txt,$item->golpns_txt,((strlen($item->mkthnpktpens)==1)?"0".$item->mkthnpktpens:$item->mkthnpktpens),((strlen($item->mkblnpktpens)==1)?"0".$item->mkblnpktpens:$item->mkblnpktpens),((strlen($item->mkthnpens)==1)?"0".$item->mkthnpens:$item->mkthnpens),((strlen($item->mkblnpens)==1)?"0".$item->mkblnpens:$item->mkblnpens),((strlen($item->mkthnpns)==1)?"0".$item->mkthnpns:$item->mkthnpns),((strlen($item->mkblnpns)==1)?"0".$item->mkblnpns:$item->mkblnpns),'Rp. '.number_format($item->gaji),
                $item->tkpendid,$item->thijazawal,formatTanggalPanjang($item->tglmasukpns),\NominatifpensiunModel::getRissu($item->nip),$ranak,$item->almskrpens,$item->almrtskrpens,$item->almrwskrpens,$item->almdesaskrpens,$item->almkecskrpens,$item->almkabskrpens,$item->almprovskrpens,$item->almpens,$item->almrtpens,$item->almrwpens,$item->almdesapens,$item->almkecpens,$item->almkabpens,$item->almprovpens,$item->idpejabpens,$item->pejpenpens,$item->jabpenpens,$item->nippenpens);

                $rstemplate = (\NominatifpensiunModel::getTemplatesk($idskpd) == '0')?'<div align="center"><b>Perhatian!</b> Template SK Pensiun Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\NominatifpensiunModel::getTemplatesk($idskpd);

                echo str_replace($arrsearch,$arrreplace,$rstemplate);
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#barcode{!!$i!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
                    $("#qrcode{!!$i!!}").qrcode({
                        size    : 125,
                        render  : "image",
                        text	: "{!!url().'/digitalsign/'.$item->nip!!}"
                    });
                })
            </script>
        <?php
                if($i != $jml){
                    echo '<div class="page-break"></div>';
                }
            }
        }else{
            echo "Data Pensiun tidak ditemukan.";
            exit();
        }

        ?>

</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
        $('div.print').click(function(){
            $(this).hide();
            window.print();
            /*
                setTimeout(function() {
                    window.close();
                }, 1);
               */
        });

        $('img').each(function(index,item){
            $(item).error(function(){

                $(item).attr('src','no_image.jpg');
            });
        });


        $(document).on('mouseover',function(){
            $('div.print').show();
        });

    });

</script>