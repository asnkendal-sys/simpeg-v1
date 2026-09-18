<?php
      $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 3 ";
      $having = '';      

      /* Kondisi Tahun */
      if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
            $where .= "and YEAR(tmtakhirakhir_pppk) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
            $titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
      }else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
            $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun1')."";
            $titletahun = ' TAHUN '.Input::get('tahun1');
      }else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
            $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
            $titletahun = ' TAHUN '.Input::get('tahun2');
      }

      /* Kondisi Bulan */
      if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
            $titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
      }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')."";
            $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
      }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
            $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')."";
            $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
      }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd') != ''){
        $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    $rs = \DB::table('tb_01')
            ->select(\DB::raw('
                tb_01.kdunit, a_skpd.skpd, COUNT(*) AS jml, SUM(IF(tr_pppk.sts_kontrak=2,1,0)) AS perpanjang, SUM(IF(tr_pppk.sts_kontrak=3,1,0)) AS berhenti,SUM(IF(tr_pppk.status=2,1,0)) AS tidakdiusulkan,
                SUM(IF(tr_pppk.statussk=0,1,0)) AS belum, SUM(IF(tr_pppk.statususul>1,1,0)) AS tms, SUM(IF(tr_pppk.statussk=2,1,0)) AS proses, 
                SUM(IF(tr_pppk.statussk=1,1,0)) AS selesai
            '))
            ->join('a_skpd', 'tb_01.kdunit', '=', 'a_skpd.idskpd')
            ->leftJoin('tr_pppk', function($join){
                $join->on('tb_01.nip', '=', 'tr_pppk.nip')
                ->on('tb_01.tmtakhirakhir_pppk', '=', 'tr_pppk.tmtakhirl');
            }) 
            ->whereRaw($where)      
            ->groupBy('tb_01.kdunit')
            ->orderBy('tb_01.kdunit')
            ->get();

      $title = "";
      $title .=((Input::get('idskpd') != '')?' PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'');
      $title .=(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'');
      $title .=(((Input::get('tahun1') != '') or (Input::get('tahun2') != ''))?$titletahun:'');

$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>User</Author>
  <LastAuthor>User</LastAuthor>
  <Created>2025-07-14T11:28:32Z</Created>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>9336</WindowHeight>
  <WindowWidth>23040</WindowWidth>
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
  <Style ss:ID=\"m2161783127928\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"m2161783127948\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"m2161783127968\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"m2161783128008\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"m2161783128028\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"m2161783128048\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
  </Style>
  <Style ss:ID=\"s65\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s70\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s71\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s72\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s73\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s76\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"9000000\" ss:ExpandedRowCount=\"7000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"14.4\">
   <Column ss:Width=\"19.8\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"228\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"93\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"83.4\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"88.2\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"63.599999999999994\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"60\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"61.8\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"65.400000000000006\"/>
   <Row>
    <Cell ss:MergeAcross=\"8\" ss:StyleID=\"s76\"><Data ss:Type=\"String\">DAFTAR NOMINATIF PEGAWAI PPPK HABIS KONTRAK</Data></Cell>
   </Row>
   <Row>
    <Cell ss:MergeAcross=\"8\" ss:StyleID=\"s76\"><Data ss:Type=\"String\">".$title."</Data></Cell>
   </Row>
   <Row>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2161783127928\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2161783127948\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2161783127968\"><Data ss:Type=\"String\">JUMLAH KONTRAK</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m2161783128048\"><Data ss:Type=\"String\">USULAN</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2161783128008\"><Data ss:Type=\"String\">STATUS VERIFIKASI</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2161783128028\"><Data ss:Type=\"String\">STATUS PROSES</Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index=\"4\" ss:StyleID=\"s65\"><Data ss:Type=\"String\">PERPANJANGAN</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">PEMBERHENTIAN</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">TIDAK DIUSULKAN</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">BELUM</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">TMS</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">ON PROSES</Data></Cell>
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">SELESAI</Data></Cell>
   </Row>";
   
      $x = 0;
      foreach($rs as $item){ 
            $x++;  
            $tot_jml[$x] = $item->jml;
            $tot_perpanjang[$x] = $item->perpanjang;
            $tot_berhenti[$x] = $item->berhenti;
            $tot_tidakdiusulkan[$x] = $item->tidakdiusulkan;
            $tot_belum[$x] = $item->belum;
            $tot_tms[$x] = $item->tms;
            $tot_proses[$x] = $item->proses;
            $tot_selesai[$x] = $item->selesai;

   $w.="<Row>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$x."</Data></Cell>
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">".$item->skpd."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->jml."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->perpanjang."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->berhenti."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->tidakdiusulkan."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->belum."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->tms."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->proses."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".$item->selesai."</Data></Cell>
    </Row>";   
}
  $w.="
  <Row>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">TOTAL</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_jml)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_perpanjang)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_berhenti)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_tidakdiusulkan)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_belum)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_tms)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_proses)."</Data></Cell>
    <Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".array_sum($tot_selesai)."</Data></Cell>
</Row>
  </Table>
  <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
   <PageSetup>
    <Header x:Margin=\"0.3\"/>
    <Footer x:Margin=\"0.3\"/>
    <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <RangeSelection>R1C1:R2C9</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download("statistik_pppk_".date('Ymds').".xls", $w);
?>
