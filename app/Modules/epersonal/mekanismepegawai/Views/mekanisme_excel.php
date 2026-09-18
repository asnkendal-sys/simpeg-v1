<?php
$idskpd = \Input::get('idskpd');
$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>rendy</Author>
  <LastAuthor>rendy</LastAuthor>
  <Created>2014-09-30T05:54:14Z</Created>
  <Version>15.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>11595</WindowHeight>
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
  <Style ss:ID=\"m330077980\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330078000\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330078020\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330078040\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330078060\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079752\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079772\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079792\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079812\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079832\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079852\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079872\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330079892\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076632\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076652\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076672\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076692\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076712\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m330076732\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270872\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270892\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270912\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270932\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270952\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m225270972\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355840\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355860\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355880\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355900\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355920\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355940\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355424\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355464\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355484\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355504\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355524\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355544\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355564\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355584\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6355604\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354592\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354612\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354632\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354652\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354672\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354692\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354712\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354732\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354752\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"m6354772\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s63\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s64\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s66\">
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
   <Font ss:FontName=\"Arial\" ss:Size=\"6\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s91\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s93\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" ss:Size=\"8\" ss:Color=\"#000000\" ss:Underline=\"Single\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Page 1\">
  <Table ss:ExpandedColumnCount=\"60000000\" ss:ExpandedRowCount=\"36000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"19.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"1.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"188.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"21.75\" ss:Span=\"1\"/>
   <Column ss:Index=\"6\" ss:AutoFitWidth=\"0\" ss:Width=\"16.5\" ss:Span=\"3\"/>
   <Column ss:Index=\"10\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"16.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"11.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"5.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"16.5\" ss:Span=\"1\"/>
   <Column ss:Index=\"16\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"16.5\" ss:Span=\"3\"/>
   <Column ss:Index=\"21\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"16.5\" ss:Span=\"4\"/>
   <Column ss:Index=\"27\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"16.5\" ss:Span=\"8\"/>
   <Column ss:Index=\"37\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\" ss:Span=\"4\"/>
   <Column ss:Index=\"42\" ss:AutoFitWidth=\"0\" ss:Width=\"3\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"19.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"21.75\" ss:Span=\"2\"/>
   <Column ss:Index=\"47\" ss:AutoFitWidth=\"0\" ss:Width=\"24.75\" ss:Span=\"1\"/>
   <Column ss:Index=\"49\" ss:AutoFitWidth=\"0\" ss:Width=\"21.75\" ss:Span=\"4\"/>
   <Column ss:Index=\"54\" ss:AutoFitWidth=\"0\" ss:Width=\"13.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"8.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"21.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"11.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"1.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"9.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"10.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"5.4375\">
    <Cell ss:MergeAcross=\"59\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\">
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"5\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\"></Data></Cell>
    <Cell ss:MergeAcross=\"55\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">REKAPITULASI : JUMLAH CALON / PEGAWAI NEGERI SIPIL ".strtoupper(getUtility('kab_instansi'))."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"5\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"2.8125\">
    <Cell ss:Index=\"3\" ss:MergeAcross=\"9\" ss:StyleID=\"s64\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:MergeAcross=\"44\" ss:MergeDown=\"1\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\">".(($idskpd!='')?strtoupper(getSkpd($idskpd)):'DINAS DAERAH DAN KECAMATAN DI '.strtoupper(getUtility('kab_instansi')))."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"8.25\">
    <Cell ss:Index=\"3\" ss:MergeAcross=\"9\" ss:MergeDown=\"3\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\"></Data></Cell>
    <Cell ss:Index=\"58\" ss:MergeDown=\"3\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"2.8125\">
    <Cell ss:Index=\"13\" ss:MergeAcross=\"44\" ss:MergeDown=\"1\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\">KEADAAN : ".formatTanggalPanjang(date('Y-m-d'))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"2.8125\">
    <Cell ss:Index=\"13\" ss:MergeAcross=\"44\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\">
    <Cell ss:MergeDown=\"2\" ss:StyleID=\"m6354592\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"2\" ss:StyleID=\"m6354612\"><Data
      ss:Type=\"String\">UNIT ORGANISASI</Data></Cell>
    <Cell ss:MergeAcross=\"22\" ss:StyleID=\"m6354632\"><Data ss:Type=\"String\">PEGAWAI</Data></Cell>
    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"m6354652\"><Data ss:Type=\"String\">CALON PEGAWAI</Data></Cell>
    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"m6354672\"><Data ss:Type=\"String\">PPPK</Data></Cell>
    <Cell ss:MergeAcross=\"18\" ss:StyleID=\"m6354672\"><Data ss:Type=\"String\">TINGKAT PENDIDIKAN</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m6354692\"><Data ss:Type=\"String\">JENIS KELAMIN</Data></Cell>
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"m6355424\"><Data ss:Type=\"String\">TINGKAT UMUR</Data></Cell>
    <Cell ss:MergeDown=\"28\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\">
    <Cell ss:Index=\"4\" ss:MergeDown=\"1\" ss:StyleID=\"m6355464\"><Data
      ss:Type=\"String\">JML&#10;TOTAL</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355484\"><Data ss:Type=\"String\">JML&#10;GOL I</Data></Cell>
    <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m6355504\"><Data ss:Type=\"String\">GOLONGAN I</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355524\"><Data ss:Type=\"String\">JML&#10;GOL II</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m6355544\"><Data ss:Type=\"String\">GOLONGAN II</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355564\"><Data ss:Type=\"String\">JML&#10;GOL III</Data></Cell>
    <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m6355584\"><Data ss:Type=\"String\">GOLONGAN III</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355604\"><Data ss:Type=\"String\">JML&#10;GOL IV</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m6354712\"><Data ss:Type=\"String\">GOLONGAN IV</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6354732\"><Data ss:Type=\"String\">JML</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m6354752\"><Data ss:Type=\"String\">GOL I</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m6354772\"><Data ss:Type=\"String\">GOL II</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m6355840\"><Data ss:Type=\"String\">GOL III</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">JML</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">I</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">II</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">III</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">IV</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">V</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">VI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">VII</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">VIII</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">IX</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">X</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XII</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XIII</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XIV</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XV</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XVI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">XVII</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355860\"><Data ss:Type=\"String\">SD</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355880\"><Data ss:Type=\"String\">SLTP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355900\"><Data ss:Type=\"String\">SLTA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330079892\"><Data ss:Type=\"String\">D1</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m6355920\"><Data ss:Type=\"String\">D2</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"1\" ss:StyleID=\"m6355940\"><Data
      ss:Type=\"String\">D3</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270872\"><Data ss:Type=\"String\">S1</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270892\"><Data ss:Type=\"String\">S2</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270912\"><Data ss:Type=\"String\">S3</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270932\"><Data ss:Type=\"String\">L</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270952\"><Data ss:Type=\"String\">P</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m225270972\"><Data ss:Type=\"String\">18-25</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330076632\"><Data ss:Type=\"String\">26-30</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330076652\"><Data ss:Type=\"String\">31-35</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330076672\"><Data ss:Type=\"String\">36-40</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330076692\"><Data ss:Type=\"String\">41-45</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"1\" ss:StyleID=\"m330076712\"><Data
      ss:Type=\"String\">46-50</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m330076732\"><Data ss:Type=\"String\">51-55</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:MergeDown=\"1\" ss:StyleID=\"m330079752\"><Data
      ss:Type=\"String\">&gt;56</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"6\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">d</Data></Cell>
    <Cell ss:Index=\"11\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330079772\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">d</Data></Cell>
    <Cell ss:Index=\"17\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">d</Data></Cell>
    <Cell ss:Index=\"22\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">d</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">e</Data></Cell>
    <Cell ss:Index=\"28\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">a</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">b</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">c</Data></Cell>
   </Row>";
    if($idskpd != ''){
        $rs = \DB::table('tb_01')
                ->select('a_skpd.idskpd','a_skpd.skpd',
                \DB::raw("COUNT(*) AS jml"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=11,1,0)) AS gol1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=12,1,0)) AS gol1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=13,1,0)) AS gol1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=14,1,0)) AS gol1d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=1, 1,0)) jmlgol1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=21,1,0)) AS gol2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=22,1,0)) AS gol2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=23,1,0)) AS gol2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=24,1,0)) AS gol2d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=2, 1,0)) jmlgol2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=31,1,0)) AS gol3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=32,1,0)) AS gol3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=33,1,0)) AS gol3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=34,1,0)) AS gol3d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=3, 1,0)) jmlgol3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=41,1,0)) AS gol4a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=42,1,0)) AS gol4b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=43,1,0)) AS gol4c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=44,1,0)) AS gol4d"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=45,1,0)) AS gol4e"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=4, 1,0)) jmlgol4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=11,1,0)) AS g1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=12,1,0)) AS g1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=13,1,0)) AS g1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=21,1,0)) AS g2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=22,1,0)) AS g2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=23,1,0)) AS g2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=31,1,0)) AS g3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=32,1,0)) AS g3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=33,1,0)) AS g3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt IN (11,12,21,22,23,31,32),1,0)) AS jmlcpns"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=11,1,0)) AS g1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=12,1,0)) AS g2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=13,1,0)) AS g3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=14,1,0)) AS g4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=21,1,0)) AS g5"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=22,1,0)) AS g6"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=23,1,0)) AS g7"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=24,1,0)) AS g8"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=31,1,0)) AS g9"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=32,1,0)) AS g10"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=33,1,0)) AS g11"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=34,1,0)) AS g12"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=41,1,0)) AS g13"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=42,1,0)) AS g14"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=43,1,0)) AS g15"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=44,1,0)) AS g16"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=45,1,0)) AS g17"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt IN (11,12,13,14,21,22,23,24,31,32,33,34,41,42,43,44,45),1,0)) AS jmlpppk"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='05',1,0)) AS sd"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='10' or tb_01.idtkpendid='12',1,0)) AS smp"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='15' or tb_01.idtkpendid='17' or tb_01.idtkpendid='18',1,0)) AS sma"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='20',1,0)) AS d1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='25',1,0)) AS d2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='30',1,0)) AS d3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='35',1,0)) AS d4"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=50,1,0)) AS sarnon"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=60,1,0)) AS sarmud"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='40',1,0)) AS s1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='45',1,0)) AS s2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='50',1,0)) AS s3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid IN (05,10,12,15,17,18,20,25,30,35,60,40,45,50),1,0)) AS jmlpend"),
                \DB::raw("SUM(IF(tb_01.idjenkel=1,1,0)) AS jmll"),
                \DB::raw("SUM(IF(tb_01.idjenkel=2,1,0)) AS jmlp"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 18 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 25,1,0)) AS u1825"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 26 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 30,1,0)) AS u2630"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 31 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 35,1,0)) AS u3135"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 36 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 40,1,0)) AS u3640"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 41 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 45,1,0)) AS u4145"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 46 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 50,1,0)) AS u4650"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 51 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 55,1,0)) AS u5155"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 56,1,0)) AS u56")
            )
            ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->whereRaw("a_skpd.idskpd like '".Input::get('idskpd')."%' and a_skpd.idskpd != 99 and tb_01.idjenkedudupeg not in(99,21)")
            ->orderBy('tb_01.idskpd','asc')
            ->groupBy('tb_01.idskpd')
            ->get();

            /*select kepala skpd*/
            $rskepala = \DB::table('tb_01 as a')
                ->join('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->select('a.nip', \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", ",""),a.gdb) as namalengkap'), 'b.jab', 'b.path', 'c.golru', 'c.pangkat')
                ->where('a.idskpd', '=', $idskpd)
                ->where('a.idjenjab', '>', '4')
                ->where('a.idjenkedudupeg', '!=', '99')
                ->where('a.idjenkedudupeg', '!=', '21')
                ->first();
    }else{
        $rs = \DB::table('tb_01')
                ->select('a_skpd.idskpd','a_skpd.skpd',
                \DB::raw("COUNT(*) AS jml"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=11,1,0)) AS gol1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=12,1,0)) AS gol1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=13,1,0)) AS gol1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=14,1,0)) AS gol1d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=1, 1,0)) jmlgol1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=21,1,0)) AS gol2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=22,1,0)) AS gol2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=23,1,0)) AS gol2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=24,1,0)) AS gol2d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=2, 1,0)) jmlgol2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=31,1,0)) AS gol3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=32,1,0)) AS gol3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=33,1,0)) AS gol3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=34,1,0)) AS gol3d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=3, 1,0)) jmlgol3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=41,1,0)) AS gol4a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=42,1,0)) AS gol4b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=43,1,0)) AS gol4c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=44,1,0)) AS gol4d"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=45,1,0)) AS gol4e"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=4, 1,0)) jmlgol4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=11,1,0)) AS g1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=12,1,0)) AS g1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=13,1,0)) AS g1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=21,1,0)) AS g2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=22,1,0)) AS g2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=23,1,0)) AS g2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=31,1,0)) AS g3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=32,1,0)) AS g3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=33,1,0)) AS g3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt IN (11,12,21,22,23,31,32),1,0)) AS jmlcpns"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=11,1,0)) AS g1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=12,1,0)) AS g2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=13,1,0)) AS g3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=14,1,0)) AS g4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=21,1,0)) AS g5"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=22,1,0)) AS g6"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=23,1,0)) AS g7"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=24,1,0)) AS g8"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=31,1,0)) AS g9"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=32,1,0)) AS g10"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=33,1,0)) AS g11"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=34,1,0)) AS g12"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=41,1,0)) AS g13"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=42,1,0)) AS g14"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=43,1,0)) AS g15"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=44,1,0)) AS g16"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=45,1,0)) AS g17"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt IN (11,12,13,14,21,22,23,24,31,32,33,34,41,42,43,44,45),1,0)) AS jmlpppk"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='05',1,0)) AS sd"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='10' or tb_01.idtkpendid='12',1,0)) AS smp"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='15' or tb_01.idtkpendid='17' or tb_01.idtkpendid='18',1,0)) AS sma"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='20',1,0)) AS d1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='25',1,0)) AS d2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='30',1,0)) AS d3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='35',1,0)) AS d4"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=50,1,0)) AS sarnon"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=60,1,0)) AS sarmud"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='40',1,0)) AS s1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='45',1,0)) AS s2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='50',1,0)) AS s3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid IN (05,10,12,15,17,18,20,25,30,35,60,40,45,50),1,0)) AS jmlpend"),
                \DB::raw("SUM(IF(tb_01.idjenkel=1,1,0)) AS jmll"),
                \DB::raw("SUM(IF(tb_01.idjenkel=2,1,0)) AS jmlp"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 18 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 25,1,0)) AS u1825"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 26 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 30,1,0)) AS u2630"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 31 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 35,1,0)) AS u3135"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 36 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 40,1,0)) AS u3640"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 41 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 45,1,0)) AS u4145"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 46 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 50,1,0)) AS u4650"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 51 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 55,1,0)) AS u5155"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 56,1,0)) AS u56")
            )
            ->leftjoin('a_skpd', DB::raw('left(tb_01.idskpd,2)'), '=', DB::raw('left(a_skpd.idskpd,2)'))
            ->whereRaw("a_skpd.idparent = '' and a_skpd.idskpd != 99 and tb_01.idjenkedudupeg not in(99,21)")
            ->orderBy('tb_01.idskpd','asc')
            ->groupBy(\DB::raw('LEFT(tb_01.idskpd,2)'))
            ->get();

            /*select kepala skpd*/
            $rskepala = \DB::table('tb_01 as a')
                ->join('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->select('a.nip', \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", ",""),a.gdb) as namalengkap'), 'b.jab', 'b.path', 'c.golru', 'c.pangkat')
                ->where('a.idskpd', '=', '05')
                ->where('a.idjenjab', '>', '4')
                ->where('a.idjenkedudupeg', '!=', '99')
                ->where('a.idjenkedudupeg', '!=', '21')
                ->first();
    }

    if(count($rskepala) > 0){
        $nip = $rskepala->nip;
        $nama = $rskepala->namalengkap;
        $pangkat = $rskepala->pangkat;
        $jabatan = strtoupper($rskepala->jab." ".$rskepala->path);
    }else{
        $nip = "..............................";
        $nama = "..............................";
        $pangkat = "..............................";
        $jabatan = "..............................";
    }

    $n = 0;

    $jml[$n] = 0; $jmlgol1[$n] = 0; $gol1a[$n] = 0;
    $gol1b[$n] = 0; $gol1c[$n] = 0; $gol1d[$n] = 0;
    $jmlgol2[$n] = 0; $gol2a[$n] = 0; $gol2b[$n] = 0;
    $gol2c[$n] = 0; $gol2d[$n] = 0; $jmlgol3[$n] = 0;
    $gol3a[$n] = 0; $gol3b[$n] = 0; $gol3c[$n] = 0;
    $gol3d[$n] = 0; $jmlgol4[$n] = 0;
    $gol4a[$n] = 0; $gol4b[$n] = 0; $gol4c[$n] = 0; $gol4d[$n] = 0;
    $gol4e[$n] = 0; $jmlcpns[$n] = 0;
    $g1a[$n] = 0; $g1b[$n] = 0; $g1c[$n] = 0;
    $g2a[$n] = 0; $g2b[$n] = 0; $g2c[$n] = 0;
    $g3a[$n] = 0; $g3b[$n] = 0; $g3c[$n] = 0;
    $jmlpppk[$n] = 0;
    $g1[$n] = 0; $g2[$n] = 0; $g3[$n] = 0;
    $g4[$n] = 0; $g5[$n] = 0; $g6[$n] = 0;
    $g7[$n] = 0; $g8[$n] = 0; $g9[$n] = 0;
    $g10[$n] = 0; $g11[$n] = 0; $g12[$n] = 0;
    $g13[$n] = 0; $g14[$n] = 0; $g15[$n] = 0; $g16[$n] = 0; $g17[$n] = 0;
    $jmlpend[$n] = 0;
    $sd[$n] = 0; $smp[$n] = 0;
    $sma[$n] = 0; $d1[$n] = 0; $d2[$n] = 0;
    $d3[$n] = 0; $s1[$n] = 0;
    $s2[$n] = 0; $s3[$n] = 0;
    $jmll[$n] = 0; $jmlp[$n] = 0;
    $u1825[$n] = 0; $u2630[$n] = 0;
    $u3135[$n] = 0; $u3640[$n] = 0;
    $u4145[$n] = 0; $u4650[$n] = 0;
    $u5155[$n] = 0; $u56[$n] = 0;

    foreach ($rs as $item) {
        $n++;

        $jml[$n] = $item->jml; $jmlgol1[$n] = $item->jmlgol1; $gol1a[$n] = $item->gol1a;
        $gol1b[$n] = $item->gol1b; $gol1c[$n] = $item->gol1c; $gol1d[$n] = $item->gol1d;
        $jmlgol2[$n] = $item->jmlgol2; $gol2a[$n] = $item->gol2a; $gol2b[$n] = $item->gol2b;
        $gol2c[$n] = $item->gol2c; $gol2d[$n] = $item->gol2d; $jmlgol3[$n] = $item->jmlgol3;
        $gol3a[$n] = $item->gol3a; $gol3b[$n] = $item->gol3b; $gol3c[$n] = $item->gol3c;
        $gol3d[$n] = $item->gol3d; $jmlgol4[$n] = $item->jmlgol4;
        $gol4a[$n] = $item->gol4a; $gol4b[$n] = $item->gol4b; $gol4c[$n] = $item->gol4c; $gol4d[$n] = $item->gol4d;
        $gol4e[$n] = $item->gol4e; $jmlcpns[$n] = $item->jmlcpns;
        $g1a[$n] = $item->g1a; $g1b[$n] = $item->g1b; $g1c[$n] = $item->g1c;
        $g2a[$n] = $item->g2a; $g2b[$n] = $item->g2b; $g2c[$n] = $item->g2c;
        $g3a[$n] = $item->g3a; $g3b[$n] = $item->g3b; $g3c[$n] = $item->g3c;
        $jmlpppk[$n] = $item->jmlpppk;
        $g1[$n] = $item->g1; $g2[$n] = $item->g2; $g3[$n] = $item->g3;
        $g4[$n] = $item->g4; $g5[$n] = $item->g5; $g6[$n] = $item->g6;
        $g7[$n] = $item->g7; $g8[$n] = $item->g8; $g9[$n] = $item->g9;
        $g10[$n] = $item->g10; $g11[$n] = $item->g11; $g12[$n] = $item->g12;
        $g13[$n] = $item->g13; $g14[$n] = $item->g14; $g15[$n] = $item->g15; $g16[$n] = $item->g16; $g17[$n] = $item->g17;
        $jmlpend[$n] = $item->jmlpend;
        $sd[$n] = $item->sd; $smp[$n] = $item->smp;
        $sma[$n] = $item->sma; $d1[$n] = $item->d1; $d2[$n] = $item->d2;
        $d3[$n] = $item->d3; $s1[$n] = $item->s1;
        $s2[$n] = $item->s2; $s3[$n] = $item->s3;
        $jmll[$n] = $item->jmll; $jmlp[$n] = $item->jmlp;
        $u1825[$n] = $item->u1825; $u2630[$n] = $item->u2630;
        $u3135[$n] = $item->u3135; $u3640[$n] = $item->u3640;
        $u4145[$n] = $item->u4145; $u4650[$n] = $item->u4650;
        $u5155[$n] = $item->u5155; $u56[$n] = $item->u56;
   
   $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"8.8125\">
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$n."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330079792\"><Data ss:Type=\"String\">".$item->skpd."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jml."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlgol1."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol1a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol1b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol1c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol1d."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlgol2."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol2a."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330079812\"><Data ss:Type=\"Number\">".$item->gol2b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol2c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol2d."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlgol3."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol3a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol3b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol3c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol3d."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlgol4."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol4a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol4b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol4c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol4d."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->gol4e."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlcpns."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g1a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g1b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g1c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g2a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g2b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g2c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g3a."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g3b."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g3c."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlpppk."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g1."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g2."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g3."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g4."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g5."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g6."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g7."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g8."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g9."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g10."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g11."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g12."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g13."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g14."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g15."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g16."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->g17."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlpend."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->sd."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->smp."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->sma."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->d1."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->d2."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330079832\"><Data ss:Type=\"Number\">".$item->d3."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->s1."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->s2."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->s3."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmll."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->jmlp."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u1825."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u2630."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u3135."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u3640."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u4145."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330079852\"><Data ss:Type=\"Number\">".$item->u4650."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".$item->u5155."</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m330079872\"><Data ss:Type=\"Number\">".$item->u56."</Data></Cell>
   </Row>";
    }
   $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\">
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330077980\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jml)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlgol1)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol1a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol1b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol1c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol1d)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlgol2)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol2a)."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330078000\"><Data ss:Type=\"Number\">".array_sum($gol2b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol2c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol2d)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlgol3)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol3a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol3b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol3c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol3d)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlgol4)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol4a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol4b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol4c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol4d)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($gol4e)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlcpns)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g1a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g1b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g1c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g2a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g2b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g2c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g3a)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g3b)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g3c)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlpppk)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g1)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g2)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g3)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g4)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g5)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g6)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g7)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g8)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g9)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g10)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g11)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g12)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g13)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g14)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g15)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g16)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($g17)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlpend)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($sd)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($smp)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($sma)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($d1)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($d2)."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330078020\"><Data ss:Type=\"Number\">".array_sum($d3)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($s1)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($s2)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($s3)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmll)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($jmlp)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u1825)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u2630)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u3135)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u3640)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u4145)."</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m330078040\"><Data ss:Type=\"Number\">".array_sum($u4650)."</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"Number\">".array_sum($u5155)."</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m330078060\"><Data ss:Type=\"Number\">".array_sum($u56)."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"5.4375\">
    <Cell ss:MergeAcross=\"58\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"11.0625\">
    <Cell ss:MergeAcross=\"41\" ss:MergeDown=\"7\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\"></Data></Cell>
    <Cell ss:MergeAcross=\"11\" ss:StyleID=\"s91\"><Data ss:Type=\"String\">Kendal, ".formatTanggalPanjang(date('Y-m-d'))."</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:MergeDown=\"7\" ss:StyleID=\"s63\"><Data
      ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"2.8125\">
    <Cell ss:Index=\"43\" ss:MergeAcross=\"11\" ss:MergeDown=\"1\" ss:StyleID=\"s91\"><Data
      ss:Type=\"String\">".$jabatan."&#10;".strtoupper(getUtility('kab_instansi'))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"21.9375\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"43\" ss:MergeAcross=\"11\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"8.25\">
    <Cell ss:Index=\"43\" ss:MergeAcross=\"11\" ss:StyleID=\"s93\"><Data ss:Type=\"String\">".$nama."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"5.4375\">
    <Cell ss:Index=\"43\" ss:MergeAcross=\"11\" ss:MergeDown=\"1\" ss:StyleID=\"s91\"><Data
      ss:Type=\"String\">NIP. ".$nip."&#10;".$pangkat."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"16.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"99.1875\">
    <Cell ss:Index=\"43\" ss:MergeAcross=\"11\" ss:StyleID=\"s63\"><Data ss:Type=\"String\"></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Span=\"14\"/>
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Layout x:Orientation=\"Landscape\"/>
    <PageMargins x:Bottom=\"0.19\" x:Left=\"0.19\" x:Right=\"0.19\" x:Top=\"0.38\"/>
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
     <ActiveRow>7</ActiveRow>
     <RangeSelection>R8C1:R10C1</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download("mekanisme_pegawai_".date('Ymds').".xls", $w);
?>
