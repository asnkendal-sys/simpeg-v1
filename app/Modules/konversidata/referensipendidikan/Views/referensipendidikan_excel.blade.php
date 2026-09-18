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
  <Created>2017-03-19T14:44:15Z</Created>
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
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"3000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\">
   <Column ss:Width=\"62.25\"/>
   <Column ss:Index=\"7\" ss:Width=\"53.25\"/>
   <Column ss:Index=\"15\" ss:Width=\"53.25\" ss:Span=\"1\"/>
   <Row>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">no</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nip</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">nama</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">gdp</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">gdb</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmlhr</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tglhr</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenkel</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idagama</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">alm</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idstskawin</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idgolrucpn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">mkthncpn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">mkblncpn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tmtcpn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">tgskcpn</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtkpendid</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenjurusan</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">noijaz</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">thijaz</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idtkpendidawal</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenjurusanawal</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">noijazawal</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">thijazawal</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjabfung</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjabfungum</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">kdunit</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idskpd</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idstspeg</Data></Cell>
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">idjenkedudupeg</Data></Cell>
   </Row>";
    foreach($rs as $item){
    $w.="<Row>
    <Cell><Data ss:Type=\"String\">".$item->id_konversi."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->nama."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->gdp."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->gdb."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tmlhr."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tglhr."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenkel."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idagama."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->alm."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idstskawin."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idgolrucpn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->mkthncpn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->mkblncpn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tmtcpn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->tgskcpn."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtkpendid."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenjurusan."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->noijaz."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->thijaz."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idtkpendidawal."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenjurusanawal."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->noijazawal."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->thijazawal."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjabfung."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjabfungum."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->kdunit."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idskpd."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idstspeg."</Data></Cell>
    <Cell><Data ss:Type=\"String\">".$item->idjenkedudupeg."</Data></Cell>
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
