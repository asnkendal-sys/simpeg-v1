<?php
$where = " tb_01.idjenkedudupeg not in('99','21')";

/*Kondisi list NIP*/
$listpegawai = Input::get('listpegawai');
if (!empty($listpegawai)) {
    $x = 0;
    $data = '';
    foreach ($listpegawai as $item) {
        $x++;
        $data .= $item . ((count($listpegawai) == $x) ? '' : ',');
    }

    $where .= " and tb_01.nip in (" . $data . ")";
}

/* Kondisi golongan */
if (Input::get('opt') == '') {
    $where .= " and tb_01.idgolrupkt = '" . Input::get('idgolru') . "'";
} else if (Input::get('opt') != '') {
    if (Input::get('opt') == '1') {
        $where .= " and tb_01.idgolrupkt > '" . Input::get('idgolru') . "'";
    } else if (Input::get('opt') == '2') {
        $where .= " and tb_01.idgolrupkt < '" . Input::get('idgolru') . "'";
    } else if (Input::get('opt') == '3') {
        $where .= " and tb_01.idgolrupkt between '" . Input::get('idgolru') . "' and '" . Input::get('idgolru2') . "'";
    }
}

/* Kondisi eselon */
if (Input::get('idesl') != '') {
    $where .= " and tb_01.idesljbt = '" . Input::get('idesl') . "'";
}

/* Kondisi struktural */
if (Input::get('idisesl') != '') {
    if (Input::get('idisesl') == 'esl') {
        $where .= " and tb_01.idesljbt in('21','22','31','32','41','42')";
    } else if (Input::get('idisesl') == 'koord') {
        $where .= " and tb_01.idkoord!=''";
    } else {
        $where .= " and tb_01.iskepsek='1'";
    }
}

/* Kondisi jenjang kedudukan pegawai */
if (Input::get('idjenkedudupeg') != '') {
    $where .= " and tb_01.idjenkedudupeg = '" . Input::get('idjenkedudupeg') . "'";
}

/* Kondisi diklat */
if (Input::get('iddikstru') != '') {
    $where .= " and tb_01.iddikstru = '" . Input::get('iddikstru') . "'";
}

/* Kondisi jenis kelamin */
if (Input::get('idjenkel') != '') {
    $where .= " and tb_01.idjenkel = '" . Input::get('idjenkel') . "'";
}

/* Kondisi agama */
if (Input::get('idagama') != '') {
    $where .= " and tb_01.idagama = '" . Input::get('idagama') . "'";
}

/* Kondisi pendidikan */
if (Input::get('idtkpendid') != '') {
    $where .= " and tb_01.idtkpendid = '" . Input::get('idtkpendid') . "'";
}

//kondisi subkoordinator
if (Input::get('idkoord') != '') {
    $where .= " and tb_01.idkoord != ''";
}

/* Kondisi jenis jabatan */
if (Input::get('idjenjab') != '') {
    $where .= " and tb_01.idjenjab = '" . Input::get('idjenjab') . "'";

    if (Input::get('idjenjab') == 2) {
        /*Kondisi jika jabatan fungsional umum*/
        if ((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') != '')) {
            $where .= " and tb_01.idjabfung = '" . Input::get('idjabfung') . "'";
        } else if ((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') == '')) {
            $where .= " and tb_01.idjabfung like '" . Input::get('idtkjabfung') . "%'";
        } else if ((Input::get('idtkjabfung') == '') and (Input::get('idjabfung') != '')) {
            $where .= " and tb_01.idjabfung = '" . Input::get('idjabfung') . "'";
        }
    } else if (Input::get('idjenjab') == 3) {
        /*Kondisi jika jabatan fungsional tertentu*/
        if (Input::get('idjabfungum') != '') {
            $where .= " and tb_01.idjabfungum = '" . Input::get('idjabfungum') . "'";
        }
    }
}

/* Kondisi status pegawai */
$idstspeg = Input::get('idstspeg');
if ($idstspeg != '') {
    $x = 0;
    $data = '';
    foreach ($idstspeg as $item) {
        $x++;
        $data .= $item . ((count($idstspeg) == $x) ? '' : ',');
    }
    $where .= " and tb_01.idstspeg in (" . $data . ")";
}

/* Kondisi skpd atau unit kerja */
switch (Input::get('idskpd')) {
    case "":
        $where .= " ";
        break;
    default:
        $where .= " and tb_01.idskpd like '" . Input::get('idskpd') . "%'";
        break;
}

/* Kondisi urut data */
$order = (Input::get('order') == '') ? '' : Input::get('order');
switch (Input::get('urutan')) {
    case "1":
        $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.idgolrupkt $order, tmtpkt, tb_01.iddikstru, tb_01.nama";
        break;
    case "2":
        $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.nip $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
        break;
    case "3":
        $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.nama $order, tb_01.idgolrupkt, tmtpkt, tb_01.nip";
        break;
    case "4":
        $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.tglhr $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
        break;
    default:
        $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.idgolrupkt $order, tmtpkt, tb_01.nama, tb_01.tglhr";
        break;
}

$rs = \DB::table('tb_01')
    ->select(
        'tb_01.*',
        'z.skpd',
        'a_golruang.golru',
        'a_golruang.pangkat',
        'a_skpd.path_short',
        'a_skpd.skpd as sub_unit',
        'a_esl.esl',
        'a_tkpendid.tkpendid',
        'a_jenjurusan.jenjurusan',
        'a_jenjab.jenjab',
        'a_tugasgurudosen.tugasgurudosen',
        'a_matkulpel.matkulpel',
        'a_sekolahswasta.nmasekolah',
        'a_tugasdokter.tugasdokter',
        'a_jabfung.jenjang',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
        'a_jenkel.jenkel',
        'a_agama.agama',
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
    )
    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
    ->leftjoin('a_skpd as z', 'tb_01.idkoord', '=', 'z.idskpd')
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
    ->leftjoin('a_tugasgurudosen', 'tb_01.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
    ->leftjoin('a_matkulpel', 'tb_01.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
    ->leftjoin('a_sekolahswasta', 'tb_01.iddiperbantukan', '=', 'a_sekolahswasta.id')
    ->leftjoin('a_tugasdokter', 'tb_01.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
    ->whereRaw($where)
    ->orderBy(\DB::raw($urutan))
    ->get();

$w = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<?mso-application progid=\"Excel.Sheet\"?>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:o=\"urn:schemas-microsoft-com:office:office\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">
 <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
  <Author>Rendy</Author>
  <LastAuthor>Rendy Amdani</LastAuthor>
  <Created>2014-02-02T08:16:59Z</Created>
  <Company>Dinus</Company>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
  <WindowHeight>7620</WindowHeight>
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
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID=\"s62\">
   <Alignment ss:Vertical=\"Bottom\"/>
   <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"12\" ss:Color=\"#000000\"
    ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s63\">
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
   <Font ss:FontName=\"Calibri\" x:CharSet=\"1\" x:Family=\"Swiss\" ss:Size=\"11\"
    ss:Color=\"#000000\" ss:Bold=\"1\"/>
  </Style>
  <Style ss:ID=\"s65\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s66\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s67\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s68\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"34000000\" ss:ExpandedRowCount=\"6000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"23.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"110.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"140.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"20\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"33\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</Data></Cell>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
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
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">" . ((Input::get('idskpd') != '') ? 'PADA ' . strtoupper(getSkpd(Input::get('idskpd'))) : '') . "</Data></Cell>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
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
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\"></Data></Cell>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
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
   <Row ss:Index=\"5\" ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NAMA</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NIP</Data></Cell>";

if (Input::get('tmtakhirpppk')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TMT AKHIR PPPK</Data></Cell>";
}

if (Input::get('tmlhr2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TEMPAT LAHIR</Data></Cell>";
}

if (Input::get('tglhr2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TANGGAL LAHIR</Data></Cell>";
}

if (Input::get('idagama2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">AGAMA</Data></Cell>";
}

if (Input::get('idjenkel2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JENIS KELAMIN</Data></Cell>";
}

if (Input::get('alm2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">ALAMAT</Data></Cell>";
}

if (Input::get('telp2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO TELEPON</Data></Cell>";
}
if (Input::get('email')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">EMAIL PRIBADI</Data></Cell>";
}

if (Input::get('nonpwp2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO NPWP</Data></Cell>";
}

if (Input::get('noktp2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO KTP</Data></Cell>";
}

if (Input::get('sipd2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">SIPD</Data></Cell>";
}

if (Input::get('idstspeg2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">STATUS PEGAWAI</Data></Cell>";
}

if (Input::get('tmtcpn2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TMT CPNS</Data></Cell>";
}

if (Input::get('tmtpns2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TMT PNS</Data></Cell>";
}

if (Input::get('golru2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">GOL.</Data></Cell>";
}

if (Input::get('pangkat2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">PANGKAT</Data></Cell>";
}

if (Input::get('tmtpkt2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TMT GOL</Data></Cell>";
}

if (Input::get('idtkpendid2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JENJANG PENDIDIKAN</Data></Cell>";
}

if (Input::get('idjenjurusan2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JURUSAN PENDIDIKAN</Data></Cell>";
}

if (Input::get('sekolah2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NAMA SEKOLAH</Data></Cell>";
}

if (Input::get('thijaz2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TAHUN LULUS</Data></Cell>";
}

if (Input::get('kdunit2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">INSTANSI INDUK</Data></Cell>";
}

if (Input::get('path2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">INSTANSI SUB UNIT</Data></Cell>";
}

if (Input::get('idjenjab2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JENIS JABATAN</Data></Cell>";
}

if (Input::get('jabatan2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JABATAN</Data></Cell>";
}

if (Input::get('tmtjbt2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TMT JABATAN</Data></Cell>";
}

if (Input::get('idesljbt2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">ESELON</Data></Cell>";
}

if (Input::get('tugasgurudosen2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TUGAS GURU</Data></Cell>";
}

if (Input::get('matkulpel2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">MATA PELAJARAN</Data></Cell>";
}

if (Input::get('iskepsek2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">KEPALA SEKOLAH</Data></Cell>";
}

if (Input::get('nmasekolah2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">SEKOLAH DIPERBANTUKAN</Data></Cell>";
}

if (Input::get('tugasdokter2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">TUGAS DOKTER</Data></Cell>";
}

if (Input::get('jenjang2')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JENJANG JABATAN FUNGSIONAL</Data></Cell>";
}

if (Input::get('idkoord')) {
    $w .= "<Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">KOORDINATOR</Data></Cell>";
}
$w .= "</Row>";

$no = 0;
foreach ($rs as $item) {
    $no++;

    $w .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"18\">
    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">" . $no . "</Data></Cell>
    <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">" . $item->namalengkap . "</Data></Cell>
    <Cell ss:StyleID=\"s67\"><Data ss:Type=\"String\">" . $item->nip . "</Data></Cell>";
    if (Input::get('tmtakhirpppk')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->tmtakhirawal_pppk . "</Data></Cell>";
    }
    if (Input::get('tmlhr2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->tmlhr . "</Data></Cell>";
    }

    if (Input::get('tglhr2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($item->tglhr)) . "</Data></Cell>";
    }

    if (Input::get('idagama2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->agama . "</Data></Cell>";
    }

    if (Input::get('idjenkel2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->jenkel . "</Data></Cell>";
    }

    if (Input::get('alm2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->alm . " " . (($item->almrt != '') ? 'RT. ' . $item->almrt . '' : '') . " " . (($item->almrt != '' && $item->almrw != '') ? '/' : '') . " " . (($item->almrw != '') ? 'RW. ' . $item->almrw . '' : '') . " " . (($item->almdesa != '') ? 'Desa/Kel. ' . $item->almdesa . '' : '') . " " . (($item->almkec != '') ? 'Kec. ' . $item->almkec . '' : '') . " " . (($item->almkab != '') ? 'Kab/Kota. ' . $item->almkab . '' : '') . " " . (($item->almprov != '') ? 'Prov. ' . $item->almprov . '' : '') . " " . (($item->almkdpos != '') ? 'Kode Pos.' . $item->almkdpos . '' : '') . "</Data></Cell>";
    }

    if (Input::get('telp2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->hp . "</Data></Cell>";
    }

    if (Input::get('email')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->email . "</Data></Cell>";
    }

    if (Input::get('nonpwp2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->nonpwp . "</Data></Cell>";
    }

    if (Input::get('noktp2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->noktp . "</Data></Cell>";
    }

    if (Input::get('sipd2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">-</Data></Cell>";
    }

    if (Input::get('idstspeg2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . (($item->idstspeg == '1') ? 'CPNS' : (($item->idstspeg == '2') ? 'PNS' : (($item->idstspeg == '3') ? 'PPPK' : 'PPPK PW'))) . "</Data></Cell>";
    }

    if (Input::get('tmtcpn2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($item->tmtcpn)) . "</Data></Cell>";
    }

    if (Input::get('tmtpns2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($item->tmtpns)) . "</Data></Cell>";
    }

    if (Input::get('golru2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->golru . "</Data></Cell>";
    }

    if (Input::get('pangkat2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->pangkat . "</Data></Cell>";
    }

    if (Input::get('tmtpkt2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($item->tmtpkt)) . "</Data></Cell>";
    }

    if (Input::get('idtkpendid2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->tkpendid . "</Data></Cell>";
    }

    if (Input::get('idjenjurusan2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->jenjurusan . "</Data></Cell>";
    }

    if (Input::get('sekolah2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->namasekolah . "</Data></Cell>";
    }

    if (Input::get('thijaz2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->thijaz . "</Data></Cell>";
    }

    if (Input::get('kdunit2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . ucwords(($item->kdunit != $item->idskpd) ? getSkpd($item->kdunit) : getSkpd($item->idskpd)) . "</Data></Cell>";
    }

    if (Input::get('path2')) {
        // $w.="<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">".ucwords($item->path_short)."</Data></Cell>";
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . ucwords($item->sub_unit) . "</Data></Cell>";
    }

    if (Input::get('idjenjab2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->jenjab . "</Data></Cell>";
    }

    if (Input::get('jabatan2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . ucwords($item->jabatan) . "</Data></Cell>";
    }

    if (Input::get('tmtjbt2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . date('d-m-Y', strtotime($item->tmtjbt)) . "</Data></Cell>";
    }

    if (Input::get('idesljbt2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . (($item->esl != '') ? $item->esl : '-') . "</Data></Cell>";
    }

    if (Input::get('tugasgurudosen2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->tugasgurudosen . "</Data></Cell>";
    }

    if (Input::get('matkulpel2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->matkulpel . "</Data></Cell>";
    }

    if (Input::get('iskepsek2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . (($item->iskepsek == 1) ? 'Ya' : '-') . "</Data></Cell>";
    }

    if (Input::get('nmasekolah2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->nmasekolah . "</Data></Cell>";
    }

    if (Input::get('tugasdokter2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->tugasdokter . "</Data></Cell>";
    }

    if (Input::get('jenjang2')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->jenjang . "</Data></Cell>";
    }

    if (Input::get('idkoord')) {
        $w .= "<Cell ss:StyleID=\"s68\"><Data ss:Type=\"String\">" . $item->skpd . "</Data></Cell>";
    }
    $w .= "</Row>";
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

force_download("nominatif_pegawai_" . date('Ymds') . ".xls", $w);
