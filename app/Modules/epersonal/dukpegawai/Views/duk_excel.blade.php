<?php
    $where = " tb_01.idjenkedudupeg not in('21','99') ";
    $idskpd = Input::get('idskpd');

    if($idskpd!="") $where .= " and tb_01.idskpd LIKE '".$idskpd."%'";
    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_golruang.golru_p3k','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','tb_01.jamhari_dikstru','tb_01.tgsttp_dikstru',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
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
        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
        \DB::raw("IFNULL(a_dikstru.dikstru,'') AS dikstru")
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
        ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
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
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"24.75\" ss:Span=\"1\"/>
   <Column ss:Index=\"4\" ss:AutoFitWidth=\"0\" ss:Width=\"148.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"66\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"175.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"30\" ss:Span=\"1\"/>
   <Column ss:Index=\"9\" ss:AutoFitWidth=\"0\" ss:Width=\"82.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"30\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"162\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"30\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"90.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"38.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"127.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"1.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"14\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">DAFTAR URUT KEPANGKATAN</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"14\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">PNS DI ".strtoupper(getSkpd($idskpd))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"14\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">GOLONGAN RUANG : I/a SAMPAI DENGAN IV/e</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"14\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">KEADAAN : ".strtoupper(formatTanggalPanjang(date('Y-m-d')))."</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:MergeAcross=\"14\" ss:StyleID=\"s63\"><Data ss:Type=\"String\">TOTAL PNS : ".count($rs)." ORANG</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"2\" ss:MergeAcross=\"1\" ss:StyleID=\"m300450892\"><Data
      ss:Type=\"String\">NO URUT</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300450912\"><Data ss:Type=\"String\">NAMA PEGAWAI&#10;NOMOR INDUK PEGAWAI</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">PANGKAT</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300450932\"><Data ss:Type=\"String\">MKER</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300450952\"><Data ss:Type=\"String\">LAT. JABATAN</Data></Cell>
    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m300450972\"><Data ss:Type=\"String\">PENDIDIKAN</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300444552\"><Data ss:Type=\"String\">TEM LAHIR&#10;TGL LAHIR</Data></Cell>
    <Cell ss:MergeDown=\"1\" ss:StyleID=\"m300444572\"><Data ss:Type=\"String\">CAT&#10;MUT &#10;KEPEG</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:MergeDown=\"1\" ss:StyleID=\"m300444592\"><Data
      ss:Type=\"String\">UNIT KERJA</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"21.9375\">
    <Cell ss:Index=\"2\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">PEG</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">PKT</Data></Cell>
    <Cell ss:Index=\"5\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">G/R AKHIR&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NAMA JABATAN&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">TH</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">BL</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NAMA&#10;TGL LULUS</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JAM</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">TINGKAT PENDIDIKAN</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JURUSAN PENDIDIKAN</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">TH&#10;LLS</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"13.6875\">
    <Cell ss:Index=\"2\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">1</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">2</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">3/4</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">5/6</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">7/8</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">9</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">10</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">11/12</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">13</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">14</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">15</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">16</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">17/18</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">19</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300444612\"><Data ss:Type=\"String\">20</Data></Cell>
   </Row>";
    error_reporting(0);
    $n = 0;
    $m = 1;
    foreach($rs as $item){ $n++;
        $gol1[] = $item->idgolrupkt;
        $gol2[] = $item->idgolrupkt;

        if($gol1[$n-1] == $gol2[$n-2]){
            $m++;
        }else{
            $m=1;
        }

        /*masa kerja*/
        $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
        if($mkbln > 12){
            $thnmkskr = substr($item->mkskr,0,-2)+1;
            $blnmkskr = "0".($mkbln-12);
        }else{
            $thnmkskr = substr($item->mkskr,0,-2);
            $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
        }

    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"35.8125\">
    <Cell ss:Index=\"2\" ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$n."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$m."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".$item->namalengkap."&#10;NIP. ".$item->nip."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".(($item->idstspeg=='3')?$item->golru_p3k:$item->golru)."&#10;".date('d-m-Y', strtotime($item->tmtpkt))."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".$item->jabatan."&#10;".date('d-m-Y', strtotime($item->tmtjbt))."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$thnmkskr."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$blnmkskr."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".(($item->idjenjab==1)?strtoupper($item->dikstru)."&#10;".(($item->tgsttp_dikstru=='0000-00-00')?"":$item->tgsttp_dikstru):'')."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".(($item->idjenjab==1)?(($item->jamhari_dikstru==0)?'':$item->jamhari_dikstru):'')."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->tkpendid)."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".strtoupper($item->jenjurusan)."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">".$item->thijaz."</Data></Cell>
    <Cell ss:StyleID=\"s77\"><Data ss:Type=\"String\">".$item->tmlhr."&#10;".date('d-m-Y', strtotime($item->tglhr))."</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m300444632\"><Data ss:Type=\"String\">".$item->path_short."</Data></Cell>
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
force_download("daftar_urut_kepangkatan_".date('Ymds').".xls", $w);
?>
