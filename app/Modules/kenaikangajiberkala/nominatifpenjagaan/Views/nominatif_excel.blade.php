<?php
    $where = " tb_01.idjenkedudupeg not in('99','21')";
    $having = "";

    /* Kondisi bulan kgb */
    if(Input::get('bulan') != ''){
        $having .= "MONTH(tmtkgbnext)='".Input::get('bulan')."'";
    }

    /* Kondisi tahun kpr */
    if(Input::get('tahun') != ''){
        $having .= "AND YEAR(tmtkgbnext)='".Input::get('tahun')."'";
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd')!=''){
        //$where .= " and left(tb_01.idskpd,2)='".Input::get('idskpd')."'";
        $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    if(Input::get('idstspeg')!=''){
        $where.= " and tb_01.idstspeg like '".Input::get('idstspeg')."%'";
    }

    $rs = \DB::table('tb_01')
        ->select('tb_01.*',\DB::raw('IF(tb_01.idstspeg=3,a_golruang.golru_p3k,a_golruang.golru) as golru'),'a_golruang.pangkat','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
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
        \DB::raw("IF(tb_01.idstspeg=3,a_golruangcpn.golru_p3k,a_golruangcpn.golru) as golrucpn,a_golruangcpn.pangkat as pangkatcpn, IF(tb_01.idstspeg=3,a_golruangpns.golru_p3k,a_golruangpns.golru) as golrupns,a_golruangpns.pangkat as pangkatpns")
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
    ->whereRaw($where)
    ->havingRaw($having)
    ->orderBy(\DB::raw('tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
    ->get();

    $title = ((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')."".((Input::get('bulan') != '')?' '.strtoupper(formatBulan(Input::get('bulan'))):'')."".((Input::get('tahun')!='')?' '.Input::get('tahun'):'');

$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>Rendy Amdani</Author>
  <LastAuthor>Rendy Amdani</LastAuthor>
  <Created>2017-01-11T06:01:14Z</Created>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>7050</WindowHeight>
  <WindowWidth>20490</WindowWidth>
  <WindowTopX>0</WindowTopX>
  <WindowTopY>0</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
  </Style>
  <Style ss:ID=\"s64\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
  </Style>
  <Style ss:ID=\"s66\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s75\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s88\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s99\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s100\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s101\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s106\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s107\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"10000000\" ss:ExpandedRowCount=\"5000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:StyleID=\"s62\" ss:AutoFitWidth=\"0\" ss:Width=\"24\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"156.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"118.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"224.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"60.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"166.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"154.5\" ss:Span=\"1\"/>
   <Column ss:Index=\"9\" ss:AutoFitWidth=\"0\" ss:Width=\"197.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"184.5\"/>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">DAFTAR NOMINATIF KENAIKAN GAJI BERKALA</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">".$title."</Data></Cell>
   </Row>
   <Row ss:Index=\"4\" ss:Height=\"60\">
    <Cell ss:StyleID=\"s75\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">NAMA&#10;TEMPAT, TGL LAHIR</Data></Cell>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">NIP&#10;KARPEG</Data></Cell>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">JABATAN&#10;UNIT KERJA&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s106\"><Data ss:Type=\"String\">ESELON&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s107\"><Data ss:Type=\"String\">PANGKAT / GOL. CPNS&#10;TMT&#10;MASA KERJA CPNS</Data></Cell>
    <Cell ss:StyleID=\"s88\"><Data ss:Type=\"String\">PANGKAT / GOL. PNS&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s75\"><Data ss:Type=\"String\">KENAIKAN PANGKAT&#10;(GOL. SEKARANG)&#10;TMT&#10;MASA KERJA GOLONGAN</Data></Cell>
    <Cell ss:StyleID=\"s75\"><Data ss:Type=\"String\">KGB TERKAHIR NO. SK KGB&#10;TANGGAL TMT&#10;MASA KERJA&#10;GAJI</Data></Cell>
    <Cell ss:StyleID=\"s75\"><Data ss:Type=\"String\">KGB BARU TMT&#10;MASA KERJA&#10;GAJI</Data></Cell>
   </Row>";
    $n = 0;
        foreach($rs as $item){
            /*cek yang ampir pensiun*/
            $date1 = date(strtotime($item->tmtkgbnext));
            $date2 = date(strtotime($item->pensiunnext));

            $difference = $date2 - $date1;
            $months = floor($difference / 86400 / 30 );
            // if($months > 0){

                $n++;
                if($item->tmtpkt > $item->tmtkgb){
                    $thmker = $item->mkthnpkt;
                }else{
                    $thmker = $item->mkgolthnkgb;
                }

                if (strlen($thmker)==1) $thmker="0".$thmker;
                $thmker2 = intval($thmker)+2;
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');

                if(getgaji($item->idgolrupkt,$thmker2,$item->idstspeg) == getgaji($item->idgolrupkt,$thmker,$item->idstspeg)){
                    $style = 'style="background-color:#f3f99a;"';
                }
   $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"48\">
    <Cell ss:StyleID=\"s100\"><Data ss:Type=\"String\">".$n."</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->namalengkap."&#10;".$item->tmlhr.", ".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".fnip($item->nip)."&#10;".$item->nokarpeg."</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->jabatan." pada ".$item->path_short."&#10;".(($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):'')."</Data></Cell>
    <Cell ss:StyleID=\"s101\"><Data ss:Type=\"String\">".$item->esl."&#10;".(($item->tmtesljbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtesljbt)):'')."</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->golrucpn." - ".$item->pangkatcpn."&#10;".(($item->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item->tmtcpn)):'')."&#10;".$item->mkthncpn." Tahun ".$item->mkblncpn." Bulan&#10;</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->golrupns." - ".$item->pangkatpns."&#10;".(($item->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpns)):'')."&#10;</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->golru." - ".$item->pangkat."&#10;".(($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):'')."&#10;".$item->mkthnpkt." Tahun ".$item->mkblnpkt." Bulan&#10;&#10;</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".(($item->noskkgb=='')?'&nbsp;':$item->noskkgb)."&#10;".(($item->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgb)):'')."&#10;".$item->mkgolthnkgb." Tahun ".$item->mkgolblnkgb." Bulan&#10;Rp. ".number_format(getgaji($item->idgolrupkt,$thmker,$item->idstspeg))."&#10;&#10;&#10;</Data></Cell>
    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".(($item->tmtkgbnext!='0000-00-00')?date('d-m-Y', strtotime($item->tmtkgbnext)):'')."&#10;".$thmker2." Tahun ".$item->mkgolblnkgb." Bulan&#10;Rp. ".number_format(getgaji($item->idgolrupkt,$thmker2,$item->idstspeg))."&#10;&#10;</Data></Cell>
   </Row>";
        } 
    $w.="</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <DoNotDisplayGridlines/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>3</ActiveRow>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download("nominatif_penjagaan_kgb_".date('Ymds').".xls", $w);
?>