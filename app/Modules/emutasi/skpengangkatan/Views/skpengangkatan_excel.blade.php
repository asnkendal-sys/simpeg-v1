<?php
    	date_default_timezone_set("Asia/Jakarta");

	$periode_tgl1 = Input::get('periode_tgl1');
        $periode_tgl2 = Input::get('periode_tgl2');
	$filterskpd = Input::get('idskpd');
        $where = "(tr_mutasi_pengangkatan.statususul = 1 or tr_mutasi_pengangkatan.statussk = 1)";
        if($periode_tgl1!='' && $periode_tgl2!=''){
            $periode_tgl1 = date('Y-m-d', strtotime($periode_tgl1));
            $periode_tgl2 = date('Y-m-d', strtotime($periode_tgl2));
            $where .= " and tglusul between \"".$periode_tgl1."\" and \"".$periode_tgl2."\"";
        } else{
            $where .= "and tr_mutasi_pengangkatan.nousul = \"".Input::get('nousul')."\"";
        }

        $count = \DB::table("tr_mutasi_pengangkatan")->whereRaw($where)->count();

$rs = \DB::table('tr_mutasi_pengangkatan')
        ->select('tr_mutasi_pengangkatan.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru','tb_01.tmlhr','tb_01.tglhr',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            \DB::raw('IF(tr_mutasi_pengangkatan.idjenjab>4,skpdlama.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
            \DB::raw('IF(tr_mutasi_pengangkatan.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_pengangkatan.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_pengangkatan.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))
        ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_pengangkatan.idskpd', '=', 'skpdlama.idskpd')
        ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_pengangkatan.idskpdbaru', '=', 'skpdbaru.idskpd')
        ->leftjoin('a_tkpendid', 'tr_mutasi_pengangkatan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tr_mutasi_pengangkatan.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tr_mutasi_pengangkatan.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('tb_01', 'tr_mutasi_pengangkatan.nip', '=', 'tb_01.nip')
        ->leftjoin('a_jabfung', 'tr_mutasi_pengangkatan.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_mutasi_pengangkatan.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_pengangkatan.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
        ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_pengangkatan.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
        ->whereRaw($where)
        //->take(1000)
        ->orderby('tr_mutasi_pengangkatan.idskpd','asc')
        ->orderby('tr_mutasi_pengangkatan.nip','asc')
        ->orderby('tr_mutasi_pengangkatan.idusul','asc')
        ->get();

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
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"1.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\" ss:Span=\"1\"/>
   <Column ss:Index=\"4\" ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\" ss:Span=\"1\"/>
   <Column ss:Index=\"9\" ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"1.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">NOMINATIF PENGANGKATAN PELAKSANA</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">PNS DI ".strtoupper(getSkpd($filterskpd))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">GOLONGAN RUANG : I/a SAMPAI DENGAN IV/e</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">PERIODE : ".strtoupper(formatTanggalPanjang($periode_tgl1))." SAMPAI DENGAN ".strtoupper(formatTanggalPanjang($periode_tgl2))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"10\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">TOTAL PNS : ".count($rs)." ORANG</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"2\" ss:MergeDown=\"1\" ss:StyleID=\"m300450912\"><Data
      ss:Type=\"String\">NO URUT</Data></Cell>  
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300450912\"><Data ss:Type=\"String\">NAMA PEGAWAI&#10;NOMOR INDUK PEGAWAI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300450912\"><Data ss:Type=\"String\">PANGKAT / GOL RUANG</Data></Cell>    
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300450932\"><Data ss:Type=\"String\">PENDIDIKAN TERAKHIR</Data></Cell>  
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300450932\"><Data ss:Type=\"String\">USULAN JABATAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300450912\"><Data ss:Type=\"String\">KETERANGAN</Data></Cell>

   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"21.9375\">      
    <Cell ss:Index=\"5\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">TINGKAT PENDIDIKAN</Data></Cell>   
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JURUSAN</Data></Cell>    
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
         
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"2\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">1</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">2/3</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">4/5</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">6</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">7/8</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">9</Data></Cell> 
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">10</Data></Cell> 
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">11</Data></Cell> 
   </Row>";
    error_reporting(0);
    $n = 0;
    $m = 1;
    foreach($rs as $item){ $n++;

    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"35.8125\">
    <Cell ss:Index=\"2\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$n."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->namalengkap."&#10;".$item->nip."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".(($item->idstspeg=='3')?$item->golru_p3k:$item->pangkat).", ".(($item->idstspeg=='3')?$item->golru_p3k:$item->golru)."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->tkpendid)."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->jenjurusan)."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->jabatanbaru)."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->skpdbaru)."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\"></Data></Cell>

   </Row>";
    }
  $w.="</Table>
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
force_download("nominatif_pengangkatan_pelaksana_".date('Ymds').".xls", $w);
?>
