<?php
      $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' and tb_01.idstspeg = 3 ";
      $having = '';

      /* Kondisi jabatan jabatan*/
      if(Input::get('idjenjab') != ''){
            $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."' ";
      }    

    /* Kondisi Tahun */
    // if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
    //     $where .= "and YEAR(tmtakhirakhir_pppk) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
    //     $titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
    // }else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
    //     $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun1')."";
    //     $titletahun = ' TAHUN '.Input::get('tahun1');
    // }else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
    //     $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
    //     $titletahun = ' TAHUN '.Input::get('tahun2');
    // }

    /* Kondisi Bulan */
    // if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
    //     $where .= " AND MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
    //     $titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
    // }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
    //     $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')."";
    //     $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
    // }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
    //     $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')."";
    //     $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
    // }

    /* Kondisi Tahun */
    if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
        $having .= " YEAR(pensiunnext) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
        $titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
    }else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
        $having .= " YEAR(pensiunnext)= ".Input::get('tahun1')."";
        $titletahun = ' TAHUN '.Input::get('tahun1');
    }else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
        $having .= " YEAR(pensiunnext)= ".Input::get('tahun2')."";
        $titletahun = ' TAHUN '.Input::get('tahun2');
    }

    /* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $having .= " AND (MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')." or MONTH(pensiunnext) between ".Input::get('bulan1')." and ".Input::get('bulan2').")";
        $titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $having .= " AND (MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')." or MONTH(pensiunnext)= ".Input::get('bulan1').")";
        $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $having .= " AND (MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')." or MONTH(pensiunnext)= ".Input::get('bulan2').")";
        $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
    }

    /* Kondisi skpd atau unit kerja */
      if(Input::get('idskpd') != ''){
            $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
      }
            // dd($where);

      $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_golruang.pangkat','a_skpd.path','a_skpd.skpd','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru','tb_01.alm','a_golruang.golru_p3k',
            \DB::raw("TIMESTAMPDIFF(YEAR, tmtmulaiakhir_pppk, tmtakhirakhir_pppk) AS selisih_tahunkerja"),
            \DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_bulankerja"),
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw("
                                          CONCAT(
                                          IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                                                      (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                                                      -
                                                      (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                                      IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                                      IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                                ),
                                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
                                                      (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                                                      + tb_01.mkthncpn
                                                )
                                          ),
                                          RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0, 2)) AS mkskr
                                          "),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
      )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                  
            ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
            ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
            ->whereRaw($where)
            ->havingRaw($having)
            ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt desc, tb_01.nama'))
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
      <Author>Rendy Amdani</Author>
      <LastAuthor>Rendy Amdani</LastAuthor>
      <Created>2017-01-11T06:01:14Z</Created>
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
      <Style ss:ID=\"m316425232\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
       <Borders>
        <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"m316425252\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
       <Borders>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"m316425272\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
       <Borders>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
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
      <Style ss:ID=\"s73\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
       <Borders>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"s74\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
       <Borders>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"s79\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
       <Borders>
        <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"s80\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
       <Borders>
        <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"s81\">
       <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
       <Borders>
        <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
        <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
       </Borders>
      </Style>
      <Style ss:ID=\"s83\">
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
      <Style ss:ID=\"s84\">
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
     <Worksheet ss:Name=\"Sheet1\">
      <Table ss:ExpandedColumnCount=\"13000000\" ss:ExpandedRowCount=\"6000000\" x:FullColumns=\"1\"
       x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
       <Column ss:StyleID=\"s62\" ss:AutoFitWidth=\"0\" ss:Width=\"24\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"85.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"70\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"60.75\"/>
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"63.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"53.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"33.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"60.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.5\"/>
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"120.5\"/>
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"120.5\"/>	
	   <Column ss:AutoFitWidth=\"0\" ss:Width=\"200.5\"/>

       <Column ss:Width=\"115.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"98.25\"/>
       <Row ss:AutoFitHeight=\"0\">
        <Cell ss:MergeAcross=\"12\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">DAFTAR NOMINATIF PEGAWAI PPPK HABIS KONTRAK DAN BUP</Data></Cell>
       </Row>
       <Row ss:AutoFitHeight=\"0\">
        <Cell ss:MergeAcross=\"12\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">".$title."</Data></Cell>
       </Row>
       <Row ss:Index=\"4\" ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">NO</Data></Cell>
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">NAMA LENGKAP</Data></Cell>
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">NIP</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">TEMPAT LAHIR</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">TGL LAHIR</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">TMT PENSIUN</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">PANGKAT</Data></Cell>
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">GOL.</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">TMT GOL.</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">MSK TAHUN</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">MSK BULAN</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">ALAMAT</Data></Cell>
		
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">SUB UNIT KERJA</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">AWAL PPPK</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">AWAL KONTRAK</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">AKHIR KONTRAK</Data></Cell>
		<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">SELISIH AKHIR KONTRAK SAMPAI BUP</Data></Cell>
      </Row> 
	   
	   ";
	   
$n = 0;
foreach($rs as $item){ $n++;
    /*masa kerja*/
    $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
    if($mkbln > 12){
        $thnmkskr = substr($item->mkskr,0,-2)+1;
        $blnmkskr = "0".($mkbln-12);
    }else{
        $thnmkskr = substr($item->mkskr,0,-2);
        $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
    }

      $tmtmulaiawal_pppk = new \Datetime($item->tmtmulaiawal_pppk);
      $tmtmulaiakhir_pppk = new \Datetime($item->tmtmulaiakhir_pppk);
      $tmtakhirakhir_pppk = new \Datetime($item->tmtakhirakhir_pppk);
      $pensiunnext = new \Datetime($item->pensiunnext);
      $format = 'd-m-Y';

      //PERHITUNGAN JARAK AKHIR KONTRAK DENGAN PENSIUN     
      $hasil = date_diff($pensiunnext,$tmtakhirakhir_pppk);
      $w.="<Row ss:Height=\"33.75\">
            <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$n."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->namalengkap."</Data></Cell>
                  <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>
                  <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->tmlhr."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".(($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):'')."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$pensiunnext->format($format)."</Data></Cell>
		<Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$item->pangkat."</Data></Cell>
		<Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$item->golru_p3k."</Data></Cell>
		<Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".(($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):'')."</Data></Cell>
		<Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$thnmkskr."</Data></Cell> 
		<Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$blnmkskr."</Data></Cell> 
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->jabatan."</Data></Cell> 
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->alm."</Data></Cell> 
		
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$item->skpd."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".ucwords(($item->kdunit!=$item->idskpd)?getSkpd($item->kdunit):getSkpd($item->idskpd))."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtmulaiawal_pppk->format($format)."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtmulaiakhir_pppk->format($format)."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$tmtakhirakhir_pppk->format($format)."</Data></Cell>
		<Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$hasil->y." Tahun ".(($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja)." Bulan</Data></Cell>
	
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
force_download("nominatif_penjagaan_habis_kontrak_".date('Ymds').".xls", $w);
?>
