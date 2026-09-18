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
  <Created>2017-01-07T07:49:42Z</Created>
  <LastSaved>2017-01-07T08:12:29Z</LastSaved>
  <Version>15.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>12885</WindowHeight>
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
   <Font ss:FontName=\"Arial\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"5000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Index=\"2\" ss:Width=\"52.5\"/>
   <Column ss:Width=\"101.25\"/>
   <Row>
    <Cell><Data ss:Type=\"String\">id</Data></Cell>
    <Cell><Data ss:Type=\"String\">niplama</Data></Cell>
    <Cell><Data ss:Type=\"String\">nip</Data></Cell>
    <Cell><Data ss:Type=\"String\">gdp</Data></Cell>
    <Cell><Data ss:Type=\"String\">gdb</Data></Cell>
   </Row>";
    foreach($rs as $item){ 
   $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->id_konversi."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->niplama."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->gdp."</Data></Cell>
    <Cell><Data ss:Type=\"String\">M".$item->gdb."Si</Data></Cell>
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
