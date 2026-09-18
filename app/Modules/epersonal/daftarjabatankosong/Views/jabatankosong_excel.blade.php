<?php
$where = 'tb_01.nip IS NULL';
if (Input::has('idskpd')) {
  $where .= " and a_skpd.idskpd like \"" . Input::get('idskpd') . "%\"";
} else {
  if (session('role_id') > 3) {
    $where .= " and a_skpd.idskpd like \"" . session('idskpd') . "%\"";
  }
}

$daftarjabatankosongs = \DB::table('a_skpd')
  ->select(
    'a_skpd.idskpd',
    'a_skpd.jab',
    'a_skpd.path_short',
    'a_esl.esl',
    'tb_01.nip',
    'a_skpd.flag',
    'a_skpd.plt_nip',
    'a_skpd.plt_nosk',
    'a_skpd.plt_tgl',
    'a_skpd.plt_tmt',
    \DB::raw("d.golru AS golrumin"),
    \DB::raw("e.golru AS golrumax"),
    \DB::raw("CONCAT(IFNULL(a.gdp,''),' ',a.nama,IF(a.gdb IS NULL,'',CONCAT(', ',a.gdb))) AS namalengkap"),
    \DB::raw("IF(tb_01.nip IS NOT NULL,DATE_FORMAT(tb_01.tmtjbt,'%d-%m-%Y'),'') AS tmtjbt")
  )
  ->leftjoin('tb_01', function ($join) {
    $join->on('a_skpd.idskpd', '=', 'tb_01.idjabjbt')
      ->where('a_skpd.flag', '=', 1)
      ->where('tb_01.idjenkedudupeg', '!=', 99)
      ->where('tb_01.idjenkedudupeg', '!=', 21);
  })
  ->leftJoin('tb_01 as a', 'a_skpd.plt_nip', '=', 'a.nip')
  ->join('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
  ->join('a_golruang as d', 'a_esl.idgolrumin', '=', 'd.idgolru')
  ->join('a_golruang as e', 'a_esl.idgolrumax', '=', 'e.idgolru')
  ->whereRaw($where)
  ->orderBy("a_skpd.idskpd", 'asc')->get();

$w = "<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>Rendy Amdani</Author>
  <LastAuthor>Rendy Amdani</LastAuthor>
  <Created>2014-10-20T05:53:58Z</Created>
  <Version>15.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>7905</WindowHeight>
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
  <Style ss:ID=\"m300444552\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300444572\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300444592\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300444612\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300444632\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
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
  <Style ss:ID=\"m300450892\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300450912\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300450932\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300450952\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m300450972\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s63\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s64\">
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s77\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
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
 </Styles>
 <Worksheet ss:Name=\"Page 1\">
  <Table ss:ExpandedColumnCount=\"160000\" ss:ExpandedRowCount=\"9000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"30\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"200\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"200\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"50\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"50\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"50\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"200\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"150\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"100\"/>

   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"8\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">DAFTAR URUT KEPANGKATAN</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"8\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">PNS DI " . strtoupper(getSkpd($idskpd)) . "</Data></Cell>
   </Row>
   
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"8\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">KEADAAN : " . strtoupper(formatTanggalPanjang(date('Y-m-d'))) . "</Data></Cell>
   </Row>
   
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"1\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">No</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">OPD</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">ESELON</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">GOL. MINIMAL</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">GOL. MAX</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">PEJABAT SEMENTARA</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NIP</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">TMT</Data></Cell>
   
   </Row>";
error_reporting(0);
$n = 0;
$m = 1;
foreach ($daftarjabatankosongs as $daftarjabatankosong) {
  
  if ($daftarjabatankosong->flag == 1) {
  $n++;
    $w .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"35.8125\">
    <Cell ss:Index=\"1\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">" . $n . "</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">" . $daftarjabatankosong->path_short . "</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">" . $daftarjabatankosong->jab . "</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">" . $daftarjabatankosong->esl . "</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">" . $daftarjabatankosong->golrumin . "</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">" . $daftarjabatankosong->golrumax . "</Data></Cell>";
    if (!empty($daftarjabatankosong->plt_nip)) {
      $w .= "<Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">" . $daftarjabatankosong->namalengkap . "</Data></Cell>
           <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">" . $daftarjabatankosong->plt_nip . "</Data></Cell>
           <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($daftarjabatankosong->plt_tmt)) . "</Data></Cell>";
    } else {
      $w .= "<Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">-</Data></Cell>
           <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">-</Data></Cell>
           <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">-</Data></Cell>";
    }

    $w .= "</Row>";
  }
}

$w .= "</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Layout x:Orientation=\"Landscape\"/>
    <PageMargins x:Bottom=\"0.38\" x:Left=\"0.38\" x:Right=\"0.38\" x:Top=\"0.38\"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>5</ActiveRow>
     <ActiveCol>1</ActiveCol>
     <RangeSelection>R6C2:R6C3</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download("daftar_jabatan_kosong_" . date('Ymds') . ".xls", $w);
