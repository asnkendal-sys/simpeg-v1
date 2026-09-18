<?php 

if ((strlen(Input::has('search')) > 0) or (Input::get('bulan') != '') or (Input::get('tahun') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idjeniskp') != '')) {
    $where = "tr_kenaikan_pangkat.idusul != 0";
    if(Input::get('bulan') != ''){
        $where .= " and MID(tr_kenaikan_pangkat.tglusul,6,2) = \"".Input::get('bulan')."\"";
    }

    if(Input::get('tahun') != ''){
        $where .= " and MID(tr_kenaikan_pangkat.tglusul,1,4) = \"".Input::get('tahun')."\"";
    }

    if(Input::get('statussk') != ''){
        $where .= " and tr_kenaikan_pangkat.statussk = \"".Input::get('statussk')."\"";
    }

    if(Input::get('idjeniskp') != ''){
        $where .= " and tr_kenaikan_pangkat.idjeniskp = \"".Input::get('idjeniskp')."\"";
    }

    if(Input::get('idskpd') != ''){
        $idskpd = Input::get('idskpd');
        $where .= " and tr_kenaikan_pangkat.idskpd like '$idskpd%'";
    }

    if(strlen(Input::has('search')) > 0) {
        $where .=" and (tr_kenaikan_pangkat.nip like '%".Input::get('search')."%' or tb_01.nama like '%".Input::get('search')."%')";
    }

    $rs = \DB::table('tr_kenaikan_pangkat')
        ->select('tr_kenaikan_pangkat.*','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
        \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
        )
        ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
        ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
        ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id')
        ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
        ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->whereRaw($where)
        ->orderBy('tmt')
        ->orderBy('idskpd')
        ->orderBy('idjeniskp')
        ->get();
}else{
    $rs = \DB::table('tr_kenaikan_pangkat')
        ->select('tr_kenaikan_pangkat.*','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
        \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
        )
        ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
        ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
        ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id')
        ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
        ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->orderBy('tmt')
        ->orderBy('idskpd')
        ->orderBy('idjeniskp')
        ->get();
}
$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>AULIA</Author>
  <LastAuthor>AULIA</LastAuthor>
  <Created>2022-09-21T07:46:50Z</Created>
  <LastSaved>2022-09-21T08:02:17Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>7050</WindowHeight>
  <WindowWidth>19200</WindowWidth>
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
  <Style ss:ID=\"m2875810299200\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s71\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s74\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s78\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s79\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s80\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s100\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior/>
  </Style>
  <Style ss:ID=\"s106\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s107\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#333333\"/>
  </Style>
  <Style ss:ID=\"s109\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s110\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\"/>
   <Borders/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s113\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s114\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s115\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <NumberFormat ss:Format=\"Short Date\"/>
  </Style>
  <Style ss:ID=\"s116\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s117\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <NumberFormat ss:Format=\"Short Date\"/>
  </Style>
  <Style ss:ID=\"s118\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s119\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s130\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"6000000\" ss:ExpandedRowCount=\"8000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"14.5\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"31.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"178\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"149.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"205\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"194\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"170.5\"/>
   <Row>
    <Cell ss:MergeAcross=\"5\" ss:StyleID=\"s130\"><Data ss:Type=\"String\">REKAP DATA USULAN KENAIKAN PANGKAT</Data></Cell>
   </Row>
   <Row ss:Index=\"3\">
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">NAMA</Data></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">NIP</Data></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:StyleID=\"s78\"><Data ss:Type=\"String\">PANGKAT/GOL. PNS</Data></Cell>
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">KENAIKAN GOLONGAN</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s79\"/>
    <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">TEMPAT, TGL LAHIR</Data></Cell>
    <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">KARPEG</Data></Cell>
    <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
    <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">TMT</Data></Cell>
    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">TMT</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s80\"/>
    <Cell ss:StyleID=\"s80\"/>
    <Cell ss:StyleID=\"s80\"/>
    <Cell ss:StyleID=\"s80\"><Data ss:Type=\"String\">TMT</Data></Cell>
    <Cell ss:StyleID=\"s80\"><Data ss:Type=\"String\">MASA KERJA PNS</Data></Cell>
    <Cell ss:StyleID=\"s80\"><Data ss:Type=\"String\">MASA KERJA GOLONGAN</Data></Cell>
   </Row>";
   $n = 0;
   foreach($rs as $item){
    $n++;
   $w.="<Row>
    <Cell ss:MergeDown=\"2\" ss:StyleID=\"m2875810299200\"><Data ss:Type=\"String\">".$n."</Data></Cell>
    <Cell ss:StyleID=\"s107\"><Data ss:Type=\"String\">".$item->namalengkap."</Data></Cell>
    <Cell ss:StyleID=\"s106\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
    <Cell ss:StyleID=\"s106\"><Data ss:Type=\"String\">".$item->jabatan."</Data></Cell>
    <Cell ss:StyleID=\"s116\"><Data ss:Type=\"String\">".$item->golru."</Data></Cell>
    <Cell ss:StyleID=\"s100\"><Data ss:Type=\"String\">".$item->golrubaru."</Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index=\"2\" ss:StyleID=\"s109\"><Data ss:Type=\"String\">".$item->tmlhr.",". $item->tglhr."</Data></Cell>
    <Cell ss:StyleID=\"s109\"><Data ss:Type=\"String\">".$item->nokarpeg."</Data></Cell>
    <Cell ss:StyleID=\"s110\"><Data ss:Type=\"String\">".$item->path_short."</Data></Cell>
    <Cell ss:StyleID=\"s117\"><Data ss:Type=\"String\">".date("d-m-Y", strtotime($item->tmtpkt))."</Data></Cell>
    <Cell ss:StyleID=\"s117\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tmt))."</Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index=\"2\" ss:StyleID=\"s113\"/>
    <Cell ss:StyleID=\"s114\"/>
    <Cell ss:StyleID=\"s115\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tmtjbt))."</Data></Cell>
    <Cell ss:StyleID=\"s118\"><Data ss:Type=\"String\">".$item->mktkp." tahun ".$item->mkbkp." bulan</Data></Cell> //ini ambil drmn
    <Cell ss:StyleID=\"s119\"><Data ss:Type=\"String\">".$item->mktkpb." tahun ".$item->mkbkpb." bulan</Data></Cell>
   </Row>";
   }
   
  $w.="</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>-3</HorizontalResolution>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>6</ActiveRow>
     <ActiveCol>1</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";

force_download("rekap_data_kp_".date('Ymds').".xls", $w);
?>
