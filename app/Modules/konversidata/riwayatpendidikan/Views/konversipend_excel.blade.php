<?php
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
  <Created>2017-04-09T09:18:04Z</Created>
  <LastSaved>2017-04-09T09:21:18Z</LastSaved>
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
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\">
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#0000FF\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s63\">
   <NumberFormat ss:Format=\"yyyy\-mm\-dd\"/>
  </Style>
  <Style ss:ID=\"s64\">
   <NumberFormat ss:Format=\"yyyy\-mm\-dd\ hh:mm:ss\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"17000000\" ss:ExpandedRowCount=\"200000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Width=\"48.75\"/>
   <Column ss:Index=\"3\" ss:AutoFitWidth=\"0\" ss:Width=\"146.25\"/>
   <Column ss:Index=\"6\" ss:AutoFitWidth=\"0\" ss:Width=\"129.75\"/>
   <Column ss:Index=\"9\" ss:Width=\"53.25\"/>
   <Column ss:Index=\"12\" ss:Width=\"48.75\" ss:Span=\"3\"/>
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">niplama</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nip</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtkpendid</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenjurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">jenjurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">namasekolah</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">noijaz</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgijaz</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tempat</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">kepsek</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">isawal</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">isakhir</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">user_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">role_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">created_at</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">updated_at</Data></Cell>
   </Row>";
foreach($rs as $item){
    $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->id."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->niplama."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtkpendid."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenjurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->jenjurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->namasekolah."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->noijaz."</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">".$item->tgijaz."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tempat."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->kepsek."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->isawal."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->isakhir."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->user_id."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->role_id."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->created_at."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->updated_at."</Data></Cell>
   </Row>";
}
$w.="</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
";
force_download($file."_".date('Ymds').".xls", $w);
?>
