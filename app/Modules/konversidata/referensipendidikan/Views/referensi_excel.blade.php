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
  <Created>2017-03-19T21:07:21Z</Created>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>4575</WindowHeight>
  <WindowWidth>15345</WindowWidth>
  <WindowTopX>0</WindowTopX>
  <WindowTopY>0</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\">
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Color=\"#0000FF\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s63\">
   <NumberFormat ss:Format=\"yyyy\-mm\-dd\ hh:mm:ss\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"10000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenjurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">jenjurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtkpendid</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idgolru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idfungsional</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idkeljurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">user_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">role_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">created_at</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">updated_at</Data></Cell>
   </Row>";
    foreach($rs as $item){
    $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->idjenjurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->jenjurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtkpendid."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idgolru."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idfungsional."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idkeljurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->user_id."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->role_id."</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">".$item->created_at."</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">".$item->updated_at."</Data></Cell>
   </Row>";
    }
    $w.="</Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download($file."_".date('Ymds').".xls", $w);
?>