<?php
    $where = "tr_pppkpw.sts_kontrak = 2 ";
    if (session('role_id') > 3) {
        $where.= " and tr_pppkpw.idskpd like \"".session('idskpd')."%\" ";
    }

    $title = '';
    $jenis = 'PPPK';
    if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::has('tahun') != '') or (Input::has('bulan') != '') or (Input::has('status') != '') or (Input::has('statussk') != '') or (Input::get('status_tte') != '')) {                    
        
        if(Input::get('idskpd') != ''){
            $where .=" and tr_pppkpw.idskpd LIKE '".Input::get('idskpd')."%'";
            $title .= "PADA ".strtoupper(getSkpd(Input::get('idskpd')));
        }
        
        if(Input::get('bulan') != ''){
            $where .= " and MONTH(tr_pppkpw.tmtawal) = \"".Input::get('bulan')."\"";
            $title .= " BULAN ".strtoupper(formatBulan(Input::get('bulan')));
        }
        
        if(Input::get('tahun') != ''){
            $where .= " and YEAR(tr_pppkpw.tmtawal) = \"".Input::get('tahun')."\"";
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
        
        if(Input::get('status') != ''){
            $where .= " and tr_pppkpw.status = \"".Input::get('status')."\"";
            $title .= " STATUS ".((Input::get('status') == 1)?'DIUSULKAN':'TIDAK DIUSULKAN');
        }

        if(Input::get('statussk') != ''){
            $where .= " and tr_pppkpw.statussk = \"".Input::get('statussk')."\"";
            $title .= " STATUS SK ".((Input::get('statussk') == 1)?'PROSES SELESAI':'DALAM PROSES');
        }

        if(Input::get('search') != ''){
            $where .= " and (tr_pppkpw.nama LIKE '%".Input::get('search')."%' or tr_pppkpw.nip LIKE '%".Input::get('search')."%')";
            $title .= " PENCARIAN : '".Input::get('search')."'";
        }
                
        $rs = PerpanjangankontrakpwModel::select(
                    'tr_pppkpw.*', 'tb_01.alm', 'tb_01.almrt', 'tb_01.almrw', 'tb_01.almdesa', 'tb_01.almkec', 'tb_01.almkab', 'tb_01.almprov', 'tb_01.almkdpos',
                    \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppkpw.tglhr)), '%Y%m')+0 AS usia"),
                    \DB::raw("TIMESTAMPDIFF(YEAR, tmtawall, tmtakhirl) AS selisih_tahunkerja"),
                    \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirl, tr_pppkpw.bup) AS selisih_bulankerja"),
                    \DB::raw("a_skpd.path_short AS unor")
                )
                ->join('tb_01', 'tr_pppkpw.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_pppkpw.kdunit', '=', 'a_skpd.idskpd')
                ->leftJoin('r_tte', function($join)use($jenis){                       
                    $join->on('r_tte.id_sk', '=', 'tr_pppkpw.idpppk')
                    ->on('r_tte.nip_pengusul','=','tr_pppkpw.nip')
                    ->where('r_tte.jenis','=',$jenis); 
                })                
                ->whereRaw($where)
                // ->orderBy('statususul','desc')->orderBy('kdunit','asc')->orderBy('status')->orderBy('unor')->orderBy('no_urut')->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
                ->orderBy('statususul','desc')
                ->orderBy('kdunit','asc')
                ->orderBy('tglhr','asc')
                ->get();
    }else{
        $rs = PerpanjangankontrakpwModel::select('tr_pppkpw.*', 'tb_01.alm', 'tb_01.almrt', 'tb_01.almrw', 'tb_01.almdesa', 'tb_01.almkec', 'tb_01.almkab', 'tb_01.almprov', 'tb_01.almkdpos',
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppkpw.tglhr)), '%Y%m')+0 AS usia"),
                \DB::raw("TIMESTAMPDIFF(YEAR, tmtawall, tmtakhirl) AS selisih_tahunkerja"),
                \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirl, tr_pppkpw.bup) AS selisih_bulankerja"),
                \DB::raw("a_skpd.path_short AS unor")
            )
            ->join('tb_01', 'tr_pppkpw.nip', '=', 'tb_01.nip')
            ->join('a_skpd', 'tr_pppkpw.kdunit', '=', 'a_skpd.idskpd')
            ->leftJoin('r_tte', function($join)use($jenis){
                $join->on('r_tte.id_sk', '=', 'tr_pppkpw.idpppk')
                    ->on('r_tte.nip_pengusul','=','tr_pppkpw.nip')
                    ->where('r_tte.jenis','=',$jenis); 
            })
            ->whereRaw($where)
            // ->orderBy('statususul','desc')->orderBy('kdunit','asc')->orderBy('status')->orderBy('unor')->orderBy('no_urut')->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
            ->orderBy('statususul','desc')
            ->orderBy('kdunit','asc')
            ->orderBy('tglhr','asc')
            ->get();
    }

$w="
<?xml version=\"1.0\"?>
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
  <Style ss:ID=\"m2762674912968\">
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
  <Style ss:ID=\"m2762674912988\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674916672\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674916692\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674916712\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674916732\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674916752\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918544\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918564\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918584\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918604\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918624\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674918644\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674911928\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674911948\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674911968\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674911988\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674912008\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674912028\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674912048\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2762674912068\">
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
  <Style ss:ID=\"s86\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Arial\" x:Family=\"Swiss\" ss:Size=\"8\" ss:Color=\"#000000\"/>
   <Interior ss:Color=\"#FFFFFF\" ss:Pattern=\"Solid\"/>
   <NumberFormat ss:Format=\"#,##0\"/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"25000000\" ss:ExpandedRowCount=\"7000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:StyleID=\"s62\" ss:Width=\"19.8\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"135.6\"/>
   <Column ss:Width=\"80.400000000000006\"/>
   <Column ss:Width=\"71.400000000000006\" ss:Span=\"1\"/>
   <Column ss:Index=\"6\" ss:AutoFitWidth=\"0\" ss:Width=\"145.19999999999999\"
    ss:Span=\"1\"/>
   <Column ss:Index=\"8\" ss:Width=\"27\"/>
   <Column ss:Width=\"59.4\"/>
   <Column ss:Width=\"58.2\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"95.399999999999991\" ss:Span=\"1\"/>
   <Column ss:Index=\"13\" ss:AutoFitWidth=\"0\" ss:Width=\"150.60000000000002\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"153\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"55.800000000000004\"/>
   <Column ss:StyleID=\"s63\" ss:AutoFitWidth=\"0\" ss:Width=\"89.4\" ss:Span=\"2\"/>
   <Column ss:Index=\"19\" ss:StyleID=\"s63\" ss:Width=\"113.39999999999999\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"44.400000000000006\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"113.39999999999999\"/>
   <Column ss:StyleID=\"s63\" ss:Width=\"107.4\" ss:Span=\"2\"/>
   <Column ss:Index=\"25\" ss:StyleID=\"s63\" ss:Width=\"108\"/>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"24\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">NOMINATIF PERPANJANGAN KONTRAK PEGAWAI PPPK</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\">
    <Cell ss:MergeAcross=\"24\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">".$title."</Data></Cell>
   </Row>
   <Row ss:Index=\"4\" ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674911928\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674911948\"><Data ss:Type=\"String\">NAMA LENGKAP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674911968\"><Data ss:Type=\"String\">NIP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674911988\"><Data ss:Type=\"String\">TEMPAT TANGGAL LAHIR</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674912008\"><Data ss:Type=\"String\">JENIS KELAMIN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674912028\"><Data ss:Type=\"String\">ALAMAT</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674912048\"><Data ss:Type=\"String\">PENDIDIKAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674912068\"><Data ss:Type=\"String\">GOL.</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918544\"><Data ss:Type=\"String\">MSK TAHUN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918564\"><Data ss:Type=\"String\">MSK BULAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918584\"><Data ss:Type=\"String\">GAJI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674912988\"><Data ss:Type=\"String\">NOMINAL GAJI</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918604\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918604\"><Data ss:Type=\"String\">UNOR</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918624\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674918644\"><Data ss:Type=\"String\">AWAL PPPK</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2762674916672\"><Data ss:Type=\"String\">PERJANJIAN KONTRAK SEBELUMNYA</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674916692\"><Data ss:Type=\"String\">TMT PENSIUN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674916712\"><Data ss:Type=\"String\">SELISIH AKHIR KONTRAK&#10;SAMPAI BUP</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m2762674916732\"><Data ss:Type=\"String\">URUTAN</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m2762674916752\"><Data ss:Type=\"String\">RENCANA PERJANJIAN KERJA</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
    <Cell ss:Index=\"17\" ss:StyleID=\"s67\"><Data ss:Type=\"String\">AWAL</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">AKHIR</Data></Cell>
    <Cell ss:Index=\"22\" ss:StyleID=\"s67\"><Data ss:Type=\"String\">KONTRAK</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">AWAL</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">AKHIR</Data></Cell>
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

        if($item->status==1){
            $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"33.75\">
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nama."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->tmlhr).", ".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".((substr($item->nip, 14, 1) == 1)?'Pria': 'Wanita')."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->alm.' RT '.$item->almrt.' RW '.$item->almrw.' '.$item->almdesa.' '.$item->almkec.' '.$item->almkab.' '.$item->almprov.' '.$item->almkdpos)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->jenjurusan)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->golru."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->thkerja."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->blkerja."</Data></Cell>
                <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">".uang($item->gaji)."</Data></Cell>
                <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">".terbilang($item->gaji)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->jab)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->unor)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->skpd)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tgskl->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtawall->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtakhirl->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$pensiunnext->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$hasil->y." Tahun ".(($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja)." Bulan</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->no_urut."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->perpanjangan." TAHUN | ".$item->perpanjangan_bulan." BULAN</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtawal->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtakhir->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">".$item->nosk."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".(($item->tgsk!='0000-00-00')?$tgsk->format($format):'')."</Data></Cell>
            </Row>";
        }else{
            $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"33.75\">
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nama."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->tmlhr).", ".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".((substr($item->nip, 14, 1) == 1)?'Pria': 'Wanita')."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->alm.' RT '.$item->almrt.' RW'.$item->almrw.' '.$item->almdesa.' '.$item->almkec.' '.$item->almkab.' '.$item->almprov.' '.$item->almkdpos)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->jenjurusan)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->golru."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->thkerja."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->blkerja."</Data></Cell>
                <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">".uang($item->gaji)."</Data></Cell>
                <Cell ss:StyleID=\"s86\"><Data ss:Type=\"String\">".terbilang($item->gaji)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->jab)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->unor)."</Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".ucword($item->skpd)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tgskl->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtawall->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtakhirl->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$pensiunnext->format($format)."</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$hasil->y." Tahun ".(($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja)." Bulan</Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->no_urut."</Data></Cell>
                <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m2762674912968\"><Data ss:Type=\"String\">Tidak Diusulkan ".$item->status_keterangan."</Data></Cell>
            </Row>";
        }
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
</Workbook>
";
force_download("nominatif_perpanjangan_kontrak_".date('Ymds').".xls", $w);
?>
