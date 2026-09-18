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
  <Created>2017-04-04T22:48:13Z</Created>
  <LastSaved>2017-04-04T23:43:46Z</LastSaved>
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
  <Table ss:ExpandedColumnCount=\"33000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Width=\"48.75\"/>
   <Column ss:Index=\"3\" ss:Width=\"101.25\"/>
   <Column ss:Index=\"5\" ss:Width=\"88.5\"/>
   <Column ss:Index=\"9\" ss:Width=\"53.25\"/>
   <Column ss:Index=\"13\" ss:Width=\"53.25\"/>
   <Column ss:Width=\"48.75\"/>
   <Column ss:Index=\"16\" ss:Width=\"48.75\"/>
   <Column ss:Index=\"18\" ss:Width=\"53.25\"/>
   <Column ss:Index=\"24\" ss:Width=\"48.75\"/>
   <Column ss:Index=\"30\" ss:Width=\"48.75\" ss:Span=\"1\"/>
   <Column ss:Index=\"32\" ss:Width=\"95.25\" ss:Span=\"1\"/>
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">niplama</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nip</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjab</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">jab</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">kdunit</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idskpd</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">skpd</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmtjab</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenjab</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idesl</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nosk</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgsk</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nopak</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">pejmen</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">iskepsek</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idkepsek</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmtkepsek</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">noskkepsek</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtugasdokter</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtugasgurudosen</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idmatkulpel</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">matkulpel</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">isdiperbantukan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">iddiperbantukan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idesljbt</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">esl</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">iddesa</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nmadesa</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">user_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">role_id</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">created_at</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">updated_at".count($rs)."</Data></Cell>
   </Row>";
    foreach($rs as $item){
    $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->id_konversi."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->niplama."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjab."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->jab."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->kdunit."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idskpd."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->skpd."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tmtjab."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenjab."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idesl."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nosk."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tgsk."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nopak."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->pejmen."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->iskepsek."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idkepsek."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tmtkepsek."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->noskkepsek."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtugasdokter."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtugasgurudosen."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idmatkulpel."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->matkulpel."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->isdiperbantukan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->iddiperbantukan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idesljbt."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->esl."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->iddesa."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nmadesa."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->user_id."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->role_id."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->created_at."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->updated_at."</Data></Cell>
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
