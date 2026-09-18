<?php
$pegawais = \DB::table('tb_01')->select(
  'tb_01.nip',
  'nama',
  'tr_ipasn.kinerja',
  'tr_ipasn.hukdis',
  'tr_ipasn.kompetensi',
  'tr_ipasn.kualifikasi',
  'tr_ipasn.subtotal',
  'tr_ipasn.tgipasn',
  'idgolrupkt',
  'idesljbt',
  'idskpd',
  'tmtpkt',
  'tmtesljbt',
  'tmtcpn',
  'a_jenjab.order as order',
  'a_golruang.golru',
  'a_esl.esl',
  'a_tkpendid.tkpendid',
  'a_jenjurusan.jenjurusan'
)

  ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
  ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
  ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
  ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
  ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
  ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
  ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
  ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->where('idstspeg', '=', 2)
  ->orderBy(\DB::raw('a_jenjab.order,tb_01.idesljbt asc,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
  ->get();

$w = "<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>BKPP</Author>
  <LastAuthor>BKPP Kendal</LastAuthor>
  <Created>2014-02-02T08:16:59Z</Created>
  <Company>Dinus</Company>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>7620</WindowHeight>
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
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"12\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s63\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
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
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s65\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s66\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s67\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s68\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"34000000\" ss:ExpandedRowCount=\"6000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"23.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"140.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"20\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"33\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">Indeks Profesionalitas Pada Perangkat Daerah</Data></Cell>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
   </Row>
   
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
   </Row>
   <Row ss:Index=\"5\" ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NAMA</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NIP</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">KINERJA</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">DISIPLIN</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">KOMPETENSI</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">KUALIFIKASI</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TOTAL</Data></Cell>
    ";
$w .= "</Row>";

$no = 0;
foreach ($pegawais as $item) {
  $no++;

  $w .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"18\">
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">" . $no . "</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">" . $item->nama . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->nip . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->kinerja . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->hukdis . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->kompetensi . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->kualifikasi . "</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">" . $item->subtotal . "</Data></Cell>
    ";

  $w .= "</Row>";
}
$w .= "</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>-3</HorizontalResolution>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Zoom>85</Zoom>
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";

force_download("ipasn_" . date('Ymds') . ".xls", $w);
