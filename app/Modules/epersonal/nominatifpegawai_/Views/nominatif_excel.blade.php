<?php
    $where = " tb_01.idjenkedudupeg not in('99','21')";

    /* Kondisi golongan */
    if(Input::get('opt') == ''){
        $where .= " and tb_01.idgolrupkt = '".Input::get('idgolru')."'";
    }else if(Input::get('opt') != ''){
        if(Input::get('opt') == '1'){
            $where .= " and tb_01.idgolrupkt > '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '2'){
            $where .= " and tb_01.idgolrupkt < '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '3'){
            $where .= " and tb_01.idgolrupkt between '".Input::get('idgolru')."' and '".Input::get('idgolru2')."'";
        }
    }

    /* Kondisi eselon */
    if(Input::get('idesl') != ''){
        $where .= " and tb_01.idesljbt = '".Input::get('idesl')."'";
    }

    /* Kondisi jenjang kedudukan pegawai */
    if(Input::get('idjenkedudupeg') != ''){
        $where .= " and tb_01.idjenkedudupeg = '".Input::get('idjenkedudupeg')."'";
    }

    /* Kondisi diklat */
    if(Input::get('iddikstru') != ''){
        $where .= " and tb_01.iddikstru = '".Input::get('iddikstru')."'";
    }

    /* Kondisi jenis kelamin */
    if(Input::get('idjenkel') != ''){
        $where .= " and tb_01.idjenkel = '".Input::get('idjenkel')."'";
    }

    /* Kondisi agama */
    if(Input::get('idagama') != ''){
        $where .= " and tb_01.idagama = '".Input::get('idagama')."'";
    }

    /* Kondisi pendidikan */
    if(Input::get('idtkpendid') != ''){
        $where .= " and tb_01.idtkpendid = '".Input::get('idtkpendid')."'";
    }

    /* Kondisi jenis jabatan */
    if(Input::get('idjenjab') != ''){
        $where .= " and tb_01.idjenjab = '".Input::get('idjenjab')."'";

        if(Input::get('idjenjab') == 2){
            /*Kondisi jika jabatan fungsional umum*/
            if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }else if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') == '')){
                $where .= " and tb_01.idjabfung like '".Input::get('idtkjabfung')."%'";
            }else if((Input::get('idtkjabfung') == '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }
        }else if(Input::get('idjenjab') == 3){
            /*Kondisi jika jabatan fungsional tertentu*/
            if(Input::get('idjabfungum') != ''){
                $where .= " and tb_01.idjabfungum = '".Input::get('idjabfungum')."'";
            }
        }
    }

    /* Kondisi status pegawai */
    if(Input::get('idstspeg') != ''){
        $where .= " and tb_01.idstspeg = '".Input::get('idstspeg')."'";
    }

    /* Kondisi skpd atau unit kerja */
    switch(Input::get('idskpd')){
        case "":
            $where .= " ";
            break;
        default:
            $where .= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
            break;
    }

    /* Kondisi urut data */
    $order = (Input::get('order')=='')?'':Input::get('order');
    switch(Input::get('urutan')){
        case "1":
            $urutan = "tb_01.idgolrupkt $order, tmtpkt, tb_01.iddikstru, tb_01.nama";
            break;
        case "2":
            $urutan = "tb_01.nip $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        case "3":
            $urutan = "tb_01.nama $order, tb_01.idgolrupkt, tmtpkt, tb_01.nip";
            break;
        case "4":
            $urutan = "tb_01.tglhr $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        default:
            $urutan = "tb_01.idgolrupkt $order, tmtpkt, tb_01.nama, tb_01.tglhr";
            break;
    }

    if(Input::get('idjenjab') != '' || Input::get('idskpd') != '')
    {
    $rs = \DB::table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab',
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
        ->whereRaw($where)
        ->orderBy(\DB::raw($urutan))
        ->get();
    }else{
        $rs = [];
    }
    
    $jumdata = count($rs);
    
$w="<?xml version=\"1.0\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>Rendy</Author>
  <LastAuthor>rendy</LastAuthor>
  <Created>2014-02-02T08:16:59Z</Created>
  <Company>Dinus</Company>
  <Version>12.00</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>8640</WindowHeight>
  <WindowWidth>18975</WindowWidth>
  <WindowTopX>120</WindowTopX>
  <WindowTopY>30</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID=\"Default\" ss:Name=\"Normal\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s64\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
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
  <Style ss:ID=\"s66\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
   <Interior/>
  </Style>
  <Style ss:ID=\"s67\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s68\">
   <Alignment ss:Vertical=\"Top\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s69\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s70\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <NumberFormat ss:Format=\"Short Date\"/>
  </Style>
  <Style ss:ID=\"s71\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s72\">
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s74\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"12\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"1700000\" ss:ExpandedRowCount=\"6000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"23.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"140.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"86.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"61.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"55.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"77.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"88.5\"/>
   <Column ss:Width=\"157.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"108\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"143.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"171.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"159\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"168\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"189\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</Data></Cell>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">".((Input::get('idskpd')!='')?'PADA '.getSkpd(Input::get('idskpd')):'')."</Data></Cell>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
    <Cell ss:StyleID=\"s74\"/>
   </Row>
   <Row ss:Index=\"5\" ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NAMA</Data></Cell>
    <Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NIP</Data></Cell>";
	if(Input::get('idagama2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">AGAMA</Data></Cell>";
	}
	
	if(Input::get('idjenjab2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JENIS JABATAN</Data></Cell>";
	}
	
	if(Input::get('idesljbt2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">ESELON</Data></Cell>";
	}
	
	if(Input::get('idgolrupkt2') != ''){
		$w.="<Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">GOL.</Data></Cell>";
	}
	
	if(Input::get('tmtpkt2') != ''){
		$w.="<Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">TMT GOL</Data></Cell>";
	}
	
	if(Input::get('idjenkel2') != ''){
		$w.="<Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">JENIS KELAMIN</Data></Cell>";
	}
	
	if(Input::get('idsekolah2') != ''){
		/*$w.="<Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">SEKOLAH DASAR</Data></Cell>";*/
	}
	
	if(Input::get('idtkpendid2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">TINGKAT PENDIDIKAN</Data></Cell>";
	}
	
	if(Input::get('idjenjurusan2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">JURUSAN</Data></Cell>";
	}
	
	if(Input::get('sekolah2') != ''){
		$w.="<Cell ss:StyleID=\"s64\"><Data ss:Type=\"String\">NAMA SEKOLAH</Data></Cell>";
	}
	
	if(Input::get('thijaz2') != ''){
		$w.="<Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">TAHUN LULUS</Data></Cell>";
	}
	
    $w.="<Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">JABATAN</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">UNIT KERJA</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">SUB UNIT KERJA</Data></Cell>
   </Row>";

  if($jumdata != ''){
    $no = 0;
    foreach ($rs as $item) {
        $no++;

   $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"18\">
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"Number\">".$no."</Data></Cell>
    <Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">".$item->nama."</Data></Cell>
    <Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">".$item->nip."</Data></Cell>";

    if(Input::get('idagama2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->agama."</Data></Cell>";
    }

    if(Input::get('idjenjab2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->jenjab."</Data></Cell>";
    }

    if(Input::get('idesljbt2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->esl."</Data></Cell>";
    }

    if(Input::get('idgolrupkt2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->golru."</Data></Cell>";
    }

    if(Input::get('tmtpkt2') != ''){
        $w.="<Cell ss:StyleID=\"s70\"><Data ss:Type=\"String\">".date('d-m-Y', strtotime($item->tmtpkt))."</Data></Cell>";
    }

    if(Input::get('idjenkel2') != ''){
        $w.="<Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">".$item->jenkel."</Data></Cell>";
    }

    if(Input::get('idsekolah2') != ''){
        /*$w.="<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">SEKOLAH DASAR</Data></Cell>";*/
    }

    if(Input::get('idtkpendid2') != ''){
        $w.="<Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">".$item->tkpendid."</Data></Cell>";
    }

    if(Input::get('idjenjurusan2') != ''){
        $w.="<Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">".$item->jenjurusan."</Data></Cell>";
    }

    if(Input::get('sekolah2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->namasekolah."</Data></Cell>";
    }

    if(Input::get('thijaz2') != ''){
        $w.="<Cell ss:StyleID=\"s69\"><Data ss:Type=\"String\">".$item->thijaz."</Data></Cell>";
    }

    $w.="<Cell ss:StyleID=\"s72\"><Data ss:Type=\"String\">".ucwords($item->jabatan)."</Data></Cell>
    <Cell ss:StyleID=\"s72\"><Data ss:Type=\"String\">".ucwords(($item->kdunit!=$item->idskpd)?getSkpd($item->kdunit):getSkpd($item->idskpd))."</Data></Cell>
    <Cell ss:StyleID=\"s72\"><Data ss:Type=\"String\">".ucwords($item->path_short)."</Data></Cell>
   </Row>";
    } 
  }else{
    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"18\">
        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"String\">Data yang anda cari tidak ditemukan</Data></Cell>
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
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>-3</HorizontalResolution>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Zoom>85</Zoom>
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";

force_download("nominatif_pegawai_".date('Ymds').".xls", $w);
?>
