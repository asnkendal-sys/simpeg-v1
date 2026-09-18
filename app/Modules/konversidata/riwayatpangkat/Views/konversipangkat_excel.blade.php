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
  <Created>2017-04-09T06:46:30Z</Created>
  <LastSaved>2017-04-09T06:46:30Z</LastSaved>
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
   <NumberFormat ss:Format=\"yyyy\-mm\-dd\"/>
  </Style>
  <Style ss:ID=\"s64\">
   <NumberFormat ss:Format=\"yyyy\-mm\-dd\ hh:mm:ss\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Names>
   <NamedRange ss:Name=\"_FilterDatabase\" ss:RefersTo=\"=Sheet1!R1C1:R2C16\"
    ss:Hidden=\"1\"/>
  </Names>
  <Table ss:ExpandedColumnCount=\"16000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Width=\"48.75\"/>
   <Column ss:Index=\"6\" ss:AutoFitWidth=\"0\" ss:Width=\"85.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"78.75\"/>
   <Column ss:Width=\"53.25\"/>
   <Column ss:Index=\"12\" ss:Width=\"48.75\" ss:Span=\"2\"/>
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">id</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">niplama</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nip</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idgolru</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">pejmenpkt</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nosk</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgsk</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmtpkt</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">gapok</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">thkerja</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">blkerja</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">stspangkat</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">user_id</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">role_id</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">created_at</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">updated_at</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
   </Row>";
    foreach($rs as $item){
    $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->id."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->niplama."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nip."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idgolru."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->pejmenpkt."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nosk."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">".$item->tgsk."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">".$item->tmtpkt."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->gapok."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->thkerja."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->blkerja."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->stspangkat."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->user_id."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell><Data ss:Type=\"String\">".$item->role_id."</Data><NamedCell ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->created_at."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->updated_at."</Data><NamedCell
      ss:Name=\"_FilterDatabase\"/></Cell>
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
