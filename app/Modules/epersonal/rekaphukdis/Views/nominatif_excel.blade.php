<?php
	/* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1')).' S/D '.formatBulan(Input::get('bulan2'));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1'));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan2'));
    }

    $title = "";
    $title .= ((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'');
    $title .= (((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'');
    $title .= ((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'');

	$w = "<?xml version=\"1.0\"?>
		<?mso-application progid=\"Excel.Sheet\"?>
		<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
		 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
		 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
		 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
		 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
		 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
		  <Author>Rendy Amdani</Author>
		  <LastAuthor>ahmad</LastAuthor>
		  <Created>2017-01-11T06:01:14Z</Created>
		  <Version>16.00</Version>
		 </DocumentProperties>
		 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
		  <AllowPNG/>
		 </OfficeDocumentSettings>
		 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
		  <WindowHeight>12225</WindowHeight>
		  <WindowWidth>28800</WindowWidth>
		  <WindowTopX>32767</WindowTopX>
		  <WindowTopY>32767</WindowTopY>
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
		  <Style ss:ID=\"m3023323600692\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"/>
		   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
		   <NumberFormat/>
		   <Protection/>
		  </Style>
		  <Style ss:ID=\"m3023323611320\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611340\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611360\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611380\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611400\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611420\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"m3023323611440\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"m3023323611460\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"s62\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		  </Style>
		  <Style ss:ID=\"s64\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
		  </Style>
		  <Style ss:ID=\"s66\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"s77\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"s79\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"s93\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		  </Style>
		  <Style ss:ID=\"s95\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
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
		  <Style ss:ID=\"s96\">
		   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
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
		  <Style ss:ID=\"s97\">
		   <Alignment ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"9\" ss:Color=\"#333333\"/>
		  </Style>
		  <Style ss:ID=\"s98\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
		     ss:Color=\"#000000\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"9\" ss:Color=\"#333333\"/>
		  </Style>
		  <Style ss:ID=\"s99\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"9\" ss:Color=\"#333333\"/>
		  </Style>
		  <Style ss:ID=\"s101\">
		   <Alignment ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"9\" ss:Color=\"#333333\"/>
		  </Style>
		  <Style ss:ID=\"s113\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"s114\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"s115\">
		   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
		   <Borders>
		    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
		   </Borders>
		   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"9\" ss:Color=\"#333333\"/>
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		  <Style ss:ID=\"s116\">
		   <NumberFormat ss:Format=\"@\"/>
		  </Style>
		 </Styles>
		 <Worksheet ss:Name=\"Sheet1\">
		  <Table ss:ExpandedColumnCount=\"11000000\" ss:ExpandedRowCount=\"7000000\" x:FullColumns=\"1\"
		   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
		   <Column ss:StyleID=\"s62\" ss:AutoFitWidth=\"0\" ss:Width=\"24\"/>
		   <Column ss:StyleID=\"s62\" ss:AutoFitWidth=\"0\" ss:Width=\"113.25\"/>
		   <Column ss:AutoFitWidth=\"0\" ss:Width=\"156.75\"/>
		   <Column ss:Width=\"150.75\"/>
		   <Column ss:AutoFitWidth=\"0\" ss:Width=\"66.75\"/>
		   <Column ss:Width=\"276\"/>
		   <Column ss:AutoFitWidth=\"0\" ss:Width=\"78\"/>
		   <Column ss:StyleID=\"s116\" ss:AutoFitWidth=\"0\" ss:Width=\"78\"/>
		   <Column ss:StyleID=\"s116\" ss:Width=\"57\"/>
		   <Column ss:StyleID=\"s116\" ss:Width=\"62.25\"/>
		   <Column ss:AutoFitWidth=\"0\" ss:Width=\"137.25\"/>
		   <Row ss:AutoFitHeight=\"0\">
		    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">DAFTAR NOMINATIF HUKUMAN DISIPLIN</Data></Cell>
		   </Row>
		   <Row ss:AutoFitHeight=\"0\">
		    <Cell ss:MergeAcross=\"9\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">".$title."</Data></Cell>
		   </Row>
		   <Row ss:Index=\"4\" ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611320\"><Data ss:Type=\"String\">NO</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611340\"><Data ss:Type=\"String\">NIP</Data></Cell>
		    <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">NAMA LENGKAP</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611360\"><Data ss:Type=\"String\">JENIS HUKUMAN DISIPLIN </Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611380\"><Data ss:Type=\"String\">TINGKAT</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611400\"><Data ss:Type=\"String\">PEJABAT</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611420\"><Data ss:Type=\"String\">NO. SK</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m3023323611440\"><Data ss:Type=\"String\">TGL. SK</Data></Cell>
		    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m3023323611460\"><Data ss:Type=\"String\">LAMA HUKUMAN</Data></Cell>
		    <Cell ss:MergeDown=\"1\" ss:StyleID=\"s77\"><Data ss:Type=\"String\">KETERANGAN</Data></Cell>
		   </Row>
		   <Row ss:AutoFitHeight=\"0\" ss:Height=\"20.25\">
		    <Cell ss:Index=\"3\" ss:StyleID=\"s93\"><Data ss:Type=\"String\"> TEMPAT, TGL LAHIR</Data></Cell>
		    <Cell ss:Index=\"9\" ss:StyleID=\"s113\"><Data ss:Type=\"String\">TGL. MULAI</Data></Cell>
		    <Cell ss:StyleID=\"s114\"><Data ss:Type=\"String\">TGL. SELESAI</Data></Cell>
		   </Row>";
		   if(count($rs) != "") {
		   	$n = 0;
		   	foreach($rs as $item) { $n++;
		   		$w .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"33.75\">
			    <Cell ss:StyleID=\"s95\"><Data ss:Type=\"String\">".$n."</Data></Cell>
			    <Cell ss:StyleID=\"s96\"><Data ss:Type=\"String\">".fnip($item->nip)."</Data></Cell>
			    <Cell ss:StyleID=\"s96\"><Data ss:Type=\"String\">".$item->namalengkap."&#10;".$item->tmlhr.", ".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
			    <Cell ss:StyleID=\"s97\"><Data ss:Type=\"String\">".$item->jenhukum."</Data></Cell>
			    <Cell ss:StyleID=\"s95\"><Data ss:Type=\"String\">".$item->kathukdis."</Data></Cell>
			    <Cell ss:StyleID=\"s98\"><Data ss:Type=\"String\">".$item->namapejab."</Data></Cell>
			    <Cell ss:StyleID=\"s99\"><Data ss:Type=\"String\">".$item->nosk."</Data></Cell>
			    <Cell ss:StyleID=\"s115\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tgsk))."</Data></Cell>
			    <Cell ss:StyleID=\"s115\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tgmul))."</Data></Cell>
			    <Cell ss:StyleID=\"s115\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tgsel))."</Data></Cell>
			    <Cell ss:StyleID=\"s101\"><Data ss:Type=\"String\">".$item->ket."</Data></Cell>
			   </Row>";
		   	}
		   } else {
		   		$w .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"24.75\">
					    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"m3023323600692\"><Data ss:Type=\"String\">Data Tidak Ditemukan</Data></Cell>
					   </Row>";
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
		    <HorizontalResolution>600</HorizontalResolution>
		    <VerticalResolution>600</VerticalResolution>
		   </Print>
		   <Selected/>
		   <DoNotDisplayGridlines/>
		   <Panes>
		    <Pane>
		     <Number>3</Number>
		     <ActiveRow>5</ActiveRow>
		     <ActiveCol>3</ActiveCol>
		    </Pane>
		   </Panes>
		   <ProtectObjects>False</ProtectObjects>
		   <ProtectScenarios>False</ProtectScenarios>
		  </WorksheetOptions>
		 </Worksheet>
		</Workbook>";
	force_download("nominatif_hukdis".date('Ymds').".xls", $w);
?>