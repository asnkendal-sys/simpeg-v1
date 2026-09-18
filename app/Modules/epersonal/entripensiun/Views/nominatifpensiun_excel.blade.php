<?php
$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
// if (Input::has('search') or Input::has('idskpd') or Input::has('idjenjab') or Input::has('tahun') or Input::has('bulan1') or Input::has('bulan2')) {
$having = '';

/* Kondisi jabatan jabatan*/
if (Input::get('idjenjab') != '') {
    $where .= "and tb_01.idjenjab = '" . Input::get('idjenjab') . "'";
}

/* Kondisi Tahun */
if (Input::get('tahun') != '') {
    $having .= (($having != '') ? ' AND ' : '') . " YEAR(pensiunnext)= " . Input::get('tahun') . "";
}

/* Kondisi Bulan */
if ((Input::get('bulan1') != '') and (Input::get('bulan2') != '')) {
    $having .= (($having != '') ? ' AND ' : '') . " MONTH(pensiunnext) between " . Input::get('bulan1') . " and " . Input::get('bulan2') . "";
} else if ((Input::get('bulan1') != '') and (Input::get('bulan2') == '')) {
    $having .= (($having != '') ? ' AND ' : '') . " MONTH(pensiunnext)= " . Input::get('bulan1') . "";
} else if ((Input::get('bulan1') == '') and (Input::get('bulan2') != '')) {
    $having .= (($having != '') ? ' AND ' : '') . " MONTH(pensiunnext)= " . Input::get('bulan2') . "";
}

/* Kondisi skpd atau unit kerja */
if (Input::get('idskpd') != '') {
    $where .= "and tb_01.idskpd like '" . Input::get('idskpd') . "%'";
}

/* Kondisi search */
if (Input::get('search') != '') {
    $where .= "and (tb_01.nama like '%" . Input::get('search') . "%' or tb_01.nip like '%" . Input::get('search') . "%')";
}

if ($having != '') {
    $entripensiuns = \DB::table('tb_01')
        ->select(
            'tb_01.*',
            'a_golruang.golru',
            'a_skpd.path_short',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan',
            'a_jenjab.jenjab',
            'a_dikstru.dikstru',
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            'a_jenkel.jenkel',
            'a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
            \DB::raw("
                                CONCAT(
                                    IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                                IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            + tb_01.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
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
        ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
} else {
    $entripensiuns = \DB::table('tb_01')
        ->select(
            'tb_01.*',
            'a_golruang.golru',
            'a_skpd.path_short',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan',
            'a_jenjab.jenjab',
            'a_dikstru.dikstru',
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF((tb_01.idjenjab=3) OR (tb_01.idesljbt >=31 and tb_01.idesljbt <= 52) /*OR (tb_01.idjenjab=2 AND tb_01.idgolrupkt <= 34)*/,58,60) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            'a_jenkel.jenkel',
            'a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
            \DB::raw("
                                CONCAT(
                                    IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                                IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                            + tb_01.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
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
        ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
}

$entripensiuns  = $entripensiuns->get();


$title = "";
$title .= ((Input::get('idskpd') != '') ? ' PADA ' . strtoupper(getSkpd(Input::get('idskpd'))) : '');
if ((Input::get('bulan1') != '') and (Input::get('bulan2') != '')) {

    $title .= ' BULAN ' . strtoupper(formatBulan(Input::get('bulan1'))) . ' - BULAN ' . strtoupper(formatBulan(Input::get('bulan2')));
} else if ((Input::get('bulan1') == '') and (Input::get('bulan2') != '')) {
    $title .= ' BULAN ' . strtoupper(formatBulan(Input::get('bulan2')));
} else if ((Input::get('bulan1') != '') and (Input::get('bulan2') == '')) {
    $title .= ' BULAN ' . strtoupper(formatBulan(Input::get('bulan1a')));
}
$title .= ((Input::get('tahun') != '') ? ' TAHUN ' . Input::get('tahun') : '');


$w = "<?xml version=\"1.0\"?>
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
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"156.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"118.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"69\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"66.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"224.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"33.75\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"29.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"32.25\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"31.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"166.5\"/>
       <Column ss:Width=\"115.5\"/>
       <Column ss:AutoFitWidth=\"0\" ss:Width=\"98.25\"/>
       <Row ss:AutoFitHeight=\"0\">
        <Cell ss:MergeAcross=\"12\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">DAFTAR NOMINATIF PENSIUN PNS</Data></Cell>
       </Row>
       <Row ss:AutoFitHeight=\"0\">
        <Cell ss:MergeAcross=\"12\" ss:StyleID=\"s66\"><Data ss:Type=\"String\">" . $title . "</Data></Cell>
       </Row>
       <Row ss:Index=\"4\" ss:AutoFitHeight=\"0\" ss:Height=\"29.25\">
        <Cell ss:MergeDown=\"1\" ss:StyleID=\"m316425232\"><Data ss:Type=\"String\">NO</Data></Cell>1
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">NAMA LENGKAP</Data></Cell>2
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">NIP</Data></Cell>3
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">GOL. </Data></Cell>4
        <Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">ESELON</Data></Cell>5
        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">JABATAN </Data></Cell>6
        <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m316425252\"><Data ss:Type=\"String\">MASA KERJA</Data></Cell>7
        <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m316425272\"><Data ss:Type=\"String\">s/d SEKARANG</Data></Cell>8
        <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m316425272\"><Data ss:Type=\"String\">PENDIDIKAN TERAKHIR</Data></Cell>9        
        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">AGAMA</Data></Cell>
        <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m316425272\"><Data ss:Type=\"String\">TMT DAN USIA</Data></Cell>10
       </Row>
       <Row ss:AutoFitHeight=\"0\" ss:Height=\"20.25\">1
        <Cell ss:Index=\"2\" ss:StyleID=\"s79\"><Data ss:Type=\"String\"> TEMPAT, TGL LAHIR</Data></Cell>2
        <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\"> NIP LAMA</Data></Cell>3
        <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\">TMT</Data></Cell>4
        <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\"></Data></Cell>5
        <Cell ss:StyleID=\"s80\"><Data ss:Type=\"String\">UNIT KERJA TMT</Data></Cell>6
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">THN</Data></Cell>7
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">BLN</Data></Cell>7
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">THN</Data></Cell>8
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">BLN</Data></Cell>8
        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">Tingkat</Data></Cell>9
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">Jurusan</Data></Cell>9
        <Cell ss:StyleID=\"s79\"><Data ss:Type=\"String\"></Data></Cell>
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">USIA</Data></Cell>10
        <Cell ss:StyleID=\"s81\"><Data ss:Type=\"String\">PENSIUN</Data></Cell>10
       </Row>";

$n = 0;
foreach ($entripensiuns as $entripensiun) {
    $n++;
    $w .= "<Row ss:Height=\"33.75\">
          <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $n . "</Data></Cell>
         <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $entripensiun->namalengkap . "&#10;" . $entripensiun->tmlhr . ", " . (($entripensiun->tglhr != '0000-00-00') ? date('d-m-Y', strtotime($entripensiun->tglhr)) : '-') . "</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . fnip($entripensiun->nip) . "&#10;" . $entripensiun->niplama . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $entripensiun->golru . "&#10;" . (($entripensiun->tmtpkt != '0000-00-00') ? date('d-m-Y', strtotime($entripensiun->tmtpkt)) : '') . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . (($entripensiun->esl != '') ? $entripensiun->esl : '-') . "</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . strtoupper(($entripensiun->jabatan != '') ? $entripensiun->jabatan : '-') . " pada " . (($entripensiun->path_short != '') ? $entripensiun->path_short : '-') . "&#10;" . (($entripensiun->tmtjbt != '0000-00-00') ? date('d-m-Y', strtotime($entripensiun->tmtjbt)) : '-') . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $entripensiun->mkthnpkt . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . $entripensiun->mkblnpkt . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . substr($entripensiun->mkskr, 0, -2) . "</Data></Cell>
        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">" . substr($entripensiun->mkskr, -2) . "</Data></Cell>
        
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $entripensiun->tkpendid . "</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $entripensiun->jenjurusan. "bln</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . $entripensiun->agama . "</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">" . substr($entripensiun->usia, 0, 2) . " thn " . substr($entripensiun->usia, 2, 2) . " bln</Data></Cell>
        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">TMT : " . (($entripensiun->tmtpens != '0000-00-00') ? date('d-m-Y', strtotime($entripensiun->tmtpens)) : '-') . "&#10;" . $entripensiun->usiapens . " thn</Data></Cell>
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
         <ActiveRow>3</ActiveRow>
         <RangeSelection>R4C1:R5C1</RangeSelection>
        </Pane>
       </Panes>
       <ProtectObjects>False</ProtectObjects>
       <ProtectScenarios>False</ProtectScenarios>
      </WorksheetOptions>
     </Worksheet>
    </Workbook>";
force_download("Nominatif_pensiun" . date('Ymds') . ".xls", $w);
