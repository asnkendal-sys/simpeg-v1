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
  <Created>2017-04-09T07:47:47Z</Created>
  <LastSaved>2017-04-09T08:40:52Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>3975</WindowHeight>
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
  <Style ss:ID=\"s64\">
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"22000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Width=\"48.75\"/>
   <Column ss:Index=\"6\" ss:Width=\"48.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"224.25\"/>
   <Column ss:Index=\"19\" ss:Width=\"48.75\" ss:Span=\"1\"/>
   <Column ss:Index=\"22\" ss:Width=\"95.25\"/>
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">niplama</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nip</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjendiklat</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">laturut</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">iddikstru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">dikstru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">penyelenggara</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmdikstru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">angkatan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgmul</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgsel</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">jamhari</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nosttpdikstru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgsttpdikstru</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nousul</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">latthn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">latsts</Data></Cell>
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
    <Cell><Data ss:Type=\"String\">".$item->idjendiklat."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->laturut."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->iddikstru."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->dikstru."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->penyelenggara."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tmdikstru."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->angkatan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tgmul."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tgsel."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->jamhari."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nosttpdikstru."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tgsttpdikstru."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nousul."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->latthn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->latsts."</Data></Cell>
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
