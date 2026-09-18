<?php
    $where = "tr_pppk.sts_kontrak = 3 ";
    if (session('role_id') > 3) {
        $where.= " and tr_pppk.idskpd like \"".session('idskpd')."%\" ";
    }

    $title = '';
    $jenis = 'PPPK-PEMBERHENTIAN';
    if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::has('tahun') != '') or (Input::has('bulan') != '') or (Input::has('statussk') != '') or (Input::get('status_tte') != '')) {                    
        
        if(Input::get('idskpd') != ''){
            $where .=" and tr_pppk.idskpd LIKE '".Input::get('idskpd')."%'";
            $title .= "PADA ".strtoupper(getSkpd(Input::get('idskpd')));
        }
        
        if(Input::get('bulan') != ''){
            $where .= " and MONTH(tr_pppk.tmtawal) = \"".Input::get('bulan')."\"";
            $title .= " BULAN ".strtoupper(formatBulan(Input::get('bulan')));
        }
        
        if(Input::get('tahun') != ''){
            $where .= " and YEAR(tr_pppk.tmtawal) = \"".Input::get('tahun')."\"";
            $title .= " TAHUN ".Input::get('tahun');;
        }        
        
        if(Input::get('status_tte') != '') {
            if (Input::get('status_tte')=='belum_mengusulkan') {
                $where .= " and r_tte.proses IS NULL";
                $title .= " STATUS BELUM MENGUSULKAN TTE";
            }else{
                $where .= " and r_tte.proses = \"".Input::get('status_tte')."\"";
                $title .= " STATUS TTE ".((Input::get('status_tte')==1)?'SELESAI PROSES':'DALAM PROSES');
            }
        }                    

        if(Input::get('statussk') != ''){
            $where .= " and tr_pppk.statussk = \"".Input::get('statussk')."\"";
            $title .= " STATUS SK ".((Input::get('statussk') == 1)?'PROSES SELESAI':'DALAM PROSES');
        }

        if(Input::get('search') != ''){
            $where .=" and (tr_pppk.nama LIKE '%".Input::get('search')."%' or tr_pppk.nip LIKE '%".Input::get('search')."%')";
            $title .= " PENCARIAN : '".Input::get('search')."'";
        }
                
        $rs = PerpanjangankontrakModel::select(
                    'tr_pppk.*','a_jenpens.jenpens',
                    \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"),
                    \DB::raw("TIMESTAMPDIFF(YEAR, tmtawall, tmtakhirl) AS selisih_tahunkerja"),
                    \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirl, bup) AS selisih_bulankerja")
                )
                ->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
                ->leftJoin('r_tte', function($join)use($jenis){                       
                    $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                    ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                    ->where('r_tte.jenis','=',$jenis); 
                })                
                ->whereRaw($where)->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->get();
    }else{
        $rs = PerpanjangankontrakModel::select(
                'tr_pppk.*','a_jenpens.jenpens',
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"),
                \DB::raw("TIMESTAMPDIFF(YEAR, tmtawall, tmtakhirl) AS selisih_tahunkerja"),
                \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirl, bup) AS selisih_bulankerja")
            )
            ->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
            ->leftJoin('r_tte', function($join)use($jenis){
                $join->on('r_tte.id_sk', '=', 'tr_pppk.idpppk')
                    ->on('r_tte.nip_pengusul','=','tr_pppk.nip')
                    ->where('r_tte.jenis','=',$jenis); 
            })
            ->whereRaw($where)->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
            ->get();
    }

$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>Rendy Amdani</Author>
  <LastAuthor>User</LastAuthor>
  <Created>2017-01-11T06:01:14Z</Created>
  <LastSaved>2025-07-26T02:11:54Z</LastSaved>
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
  <Style ss:ID=\"m1197835341060\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335424\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335444\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335464\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335484\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335504\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835335524\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835337960\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835337980\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338000\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338020\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338040\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338060\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338080\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m1197835338100\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s62\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
  </Style>
  <Style ss:ID=\"s63\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
  </Style>
  <Style ss:ID=\"s66\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <NumberFormat ss:Format=\"@\"/>
  </Style>
  <Style ss:ID=\"s67\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s84\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s85\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"18\" ss:ExpandedRowCount=\"6\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:StyleID=\"s62\" ss:Width=\"19.8\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"135.6\"/>
   <Column ss:Width=\"80.400000000000006\"/>
   <Column ss:Width=\"71.400000000000006\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"51\"/>
   <Column ss:Width=\"27\"/>
   <Column ss:Width=\"59.4\"/>
   <Column ss:Width=\"58.2\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"150.60000000000002\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"153\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"55.800000000000004\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"89.4\" ss:Span=\"2\"/>
   <Column ss:Index=\"15\" ss:StyleID=\"s63\" ss:Width=\"113.39999999999999\" ss:Span=\"1\"/>
   <Column ss:Index=\"17\" ss:StyleID=\"s63\" ss:Width=\"107.4\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"108\"/>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"17\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">NOMINATIF PEMBERHENTIAN KONTRAK PEGAWAI PPPK</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"17\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">".$title."</Data></Cell>
   </Row>
   <Row ss:Index=\"4\" ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835337960\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835337980\"><Data ss:Type=\"String\">NAMA LENGKAP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338000\"><Data ss:Type=\"String\">NIP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338020\"><Data ss:Type=\"String\">TEMPAT LAHIR</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338040\"><Data ss:Type=\"String\">TGL LAHIR</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338060\"><Data ss:Type=\"String\">GOL.</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338080\"><Data ss:Type=\"String\">MSK TAHUN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835338100\"><Data ss:Type=\"String\">MSK BULAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835335424\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835335444\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835335464\"><Data ss:Type=\"String\">AWAL PPPK</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m1197835335484\"><Data ss:Type=\"String\">PERJANJIAN KONTRAK SEBELUMNYA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835335504\"><Data ss:Type=\"String\">TMT PENSIUN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m1197835335524\"><Data ss:Type=\"String\">SELISIH AKHIR KONTRAK&#10;SAMPAI BUP</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m1197835341060\"><Data ss:Type=\"String\">PEMBERHENTIAN KONTRAK</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
    <Cell ss:Index=\"12\" ss:StyleID=\"s67\"><Data ss:Type=\"String\">AWAL</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">AKHIR</Data></Cell>
    <Cell ss:Index=\"16\" ss:StyleID=\"s67\"><Data ss:Type=\"String\">JENIS PEMBERHENTIAN</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">NOMOR SK</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">TANGGAL SK</Data></Cell>
   </Row>";
    $x = 0;
    foreach ($rs as $item) {
        $x++;
        $tgskl = new \Datetime($item->tgskl);
        $tmtawall = new \Datetime($item->tmtawall);
        $tmtakhirl = new \Datetime($item->tmtakhirl);
        $tmtawal = new \Datetime($item->tmtawal);
        $tmtakhir = new \Datetime($item->tmtakhir);
        $pensiunnext = new \Datetime($item->bup);
        $tgsk = new \Datetime($item->tgsk);
        $format = 'd-m-Y';

        //PERHITUNGAN JARAK AKHIR KONTRAK DENGAN PENSIUN     
        $hasil = date_diff($pensiunnext,$tmtakhirl);        

        $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"33.75\">
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$x."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nama."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->tmlhr."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->golru."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->thkerja."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->blkerja."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->jab."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".strtoupper($item->skpd)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tgskl->format($format)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtawall->format($format)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtakhirl->format($format)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$pensiunnext->format($format)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$hasil->y." Tahun ".(($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja)." Bulan</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->jenpens."&#10;".$item->keterangan."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->nosk."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".(($item->tgsk!='0000-00-00')?$tgsk->format($format):'')."</Data></Cell>
        </Row>";
    }
  $w.="</Table>
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
     <ActiveRow>3</ActiveRow>
     <RangeSelection>R4C1:R5C1</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";
force_download("nominatif_pemberhentian_kontrak_".date('Ymds').".xls", $w);
?>