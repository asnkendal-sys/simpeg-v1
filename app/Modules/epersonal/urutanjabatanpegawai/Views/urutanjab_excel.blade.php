<?php
if (Input::has('idskpd')) {
    if(strlen(Input::get('idskpd')) > 2){
        $urutanjabatanpegawais = geturutanpegawai(Input::get('idskpd'),substr(Input::get('idskpd'),0,-3));
    }else{
        $urutanjabatanpegawais = geturutanpegawai(Input::get('idskpd'),'');
    }

}else{
    if(session('role_id') <= 3){
        $idskpd = '25';
    }else{
        $idskpd = session('idskpd');
    }

    if(strlen($idskpd) > 2){
        $urutanjabatanpegawais = geturutanpegawai($idskpd,substr($idskpd,0,- 3));
    }else{
        $urutanjabatanpegawais = geturutanpegawai($idskpd, '');
    }
}

$w="<?xml version=\"1.0\"?>
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
  <Style ss:ID=\"m2583562549328\">
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
  <Style ss:ID=\"m2583562549348\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
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
  <Style ss:ID=\"m2583562549368\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
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
  <Style ss:ID=\"m2583562549388\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"
     ss:Color=\"#000000\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2583562549408\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"m2583562549428\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
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
  <Style ss:ID=\"s74\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s75\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior ss:Color=\"#FF0000\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s83\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s84\">
   <Alignment ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s85\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s94\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior ss:Color=\"#92D050\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s95\">
   <Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
  </Style>
  <Style ss:ID=\"s96\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior ss:Color=\"#FFFF00\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s109\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Top\" ss:WrapText=\"1\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Interior ss:Color=\"#5B9BD5\" ss:Pattern=\"Solid\"/>
  </Style>
 </Styles>
 <Worksheet ss:Name=\"Sheet1\">
  <Table ss:ExpandedColumnCount=\"41000000\" ss:ExpandedRowCount=\"9000000\" x:FullColumns=\"1\"
   x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"23.25\" ss:Span=\"4\"/>
   <Column ss:Index=\"6\" ss:AutoFitWidth=\"0\" ss:Width=\"110.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"140.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"48.75\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"208.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"42\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"36\" ss:Span=\"1\"/>
   <Column ss:Index=\"14\" ss:AutoFitWidth=\"0\" ss:Width=\"38.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"142.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"27\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"124.5\"/>
   <Column ss:AutoFitWidth=\"0\" ss:Width=\"125.25\" ss:Span=\"10\"/>
   <Column ss:Index=\"40\" ss:AutoFitWidth=\"0\" ss:Width=\"116.25\"/>
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
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
   </Row>
   <Row ss:AutoFitHeight=\"0\" ss:Height=\"15.75\">
    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">".((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')."</Data></Cell>
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
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
    <Cell ss:StyleID=\"s62\"/>
   </Row>
   <Row ss:Index=\"5\" ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NO</Data></Cell>
    <Cell ss:MergeAcross=\"4\" ss:StyleID=\"m2583562549328\"><Data ss:Type=\"String\">NAMA LENGKAP&#10;TEMPAT TANGGAL LAHIR</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">NIP&#10;NIP LAMA</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">GOL.&#10;TMT</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">ESL</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">JABATAN&#10;UNIT KERJA TMT</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2583562549348\"><Data ss:Type=\"String\">MASA KERJA</Data></Cell>
    <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2583562549368\"><Data ss:Type=\"String\">S/D SEKARANG</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">PENDIDIKAN TERAKHIR</Data></Cell>
    <Cell ss:StyleID=\"s63\"><Data ss:Type=\"String\">AGAMA&#10;USIA</Data></Cell>
   </Row>";
    $r = 0;
    $arrr[0]= "";
    $tr = 0;

    //looping 1
    $lop1 = 0;
    $arr_lop1[0]= "";

    $x = 0;
    foreach($urutanjabatanpegawais as $urutanjabatanpegawai){

        if(count(getPegawai($urutanjabatanpegawai->idskpdsub, $urutanjabatanpegawai->jab_asn)) == 0){
            $tr++;
            $arrr[$tr] = $urutanjabatanpegawai->idskpdsub;
            if($arrr[$tr]!=$arrr[$tr-1]){
                $x++;
                $r++;
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"34.5\">
                <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai->idesljbt)."\"><Data ss:Type=\"Number\">".$r."</Data></Cell>
                <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m2583562549388\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->jab_utuh." (Jabatan Kosong)</Data></Cell>
                <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
               </Row>";
            }
        }

        $r++;
        $x++;
        if($urutanjabatanpegawai->nip != ''){
           $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"34.5\">
            <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
            <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai->idesljbt)."\"><Data ss:Type=\"Number\">".$r."</Data></Cell>
            <Cell ss:MergeAcross=\"3\" ss:StyleID=\"m2583562549388\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->namalengkap."&#10;".$urutanjabatanpegawai->tmlhr.", ".(($urutanjabatanpegawai->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tglhr)):'')."</Data></Cell>
            <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->nip."&#10;".$urutanjabatanpegawai->niplama."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->golru."&#10;".(($urutanjabatanpegawai->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tmtpkt)):'')."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".(($urutanjabatanpegawai->esl!='')?$urutanjabatanpegawai->esl:'-')."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".strtoupper(($urutanjabatanpegawai->jabatan!='')?$urutanjabatanpegawai->jabatan:'-')." PADA ".(($urutanjabatanpegawai->path !='-')?$urutanjabatanpegawai->path:'')."&#10;".(($urutanjabatanpegawai->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai->tmtjbt)):'')."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->mkthnpkt."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->mkblnpkt."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai->mkskr,0,-2)."</Data></Cell>
            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai->mkskr,-2)."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->tkpendid." - ".$urutanjabatanpegawai->jenjurusan."</Data></Cell>
            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai->agama."&#10;".substr($urutanjabatanpegawai->usia,0,2)." thn ".substr($urutanjabatanpegawai->usia,2,2)." bln</Data></Cell>
           </Row>";
        }

        $lop1++;
        $arr_lop1[$lop1] = $urutanjabatanpegawai->idskpdsub;
        if($arr_lop1[$lop1]!=$arr_lop1[$lop1-1]){

            $y = 0;
            $arry[0]= "";
            $ty = 0;

            //looping 2
            $lop2 = 0;
            $arr_lop2[0]= "";

            foreach(geturutanpegawai($urutanjabatanpegawai->idskpdsub, $urutanjabatanpegawai->idskpdsub) as $urutanjabatanpegawai2) {

                if(count(getPegawai($urutanjabatanpegawai2->idskpdsub, $urutanjabatanpegawai2->jab_asn)) == 0){
                    $ty++;
                    $arry[$ty] = $urutanjabatanpegawai2->idskpdsub;
                    if($arry[$ty]!=$arry[$ty-1]){
                        $y++;
                        $x++;
                        $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"34.5\">
                        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                        <Cell ss:StyleID=\"s74\"/>
                        <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai2->idesljbt)."\"><Data ss:Type=\"Number\">".$y."</Data></Cell>
                        <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m2583562549408\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->jab_utuh." (Jabatan Kosong)</Data></Cell>
                        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                        </Row>";
                    }
                }

                if($urutanjabatanpegawai2->nip != ''){
                    $y++;
                    $x++;
                    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"34.5\">
                    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                    <Cell ss:StyleID=\"s74\"/>
                    <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai2->idesljbt)."\"><Data ss:Type=\"Number\">".$y."</Data></Cell>
                    <Cell ss:MergeAcross=\"2\" ss:StyleID=\"m2583562549408\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->namalengkap."&#10;".$urutanjabatanpegawai2->tmlhr.", ".(($urutanjabatanpegawai2->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tglhr)):'')."</Data></Cell>
                    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->nip."&#10;".$urutanjabatanpegawai2->niplama."</Data></Cell>
                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->golru."&#10;".(($urutanjabatanpegawai2->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tmtpkt)):'')."</Data></Cell>
                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".(($urutanjabatanpegawai2->esl!='')?$urutanjabatanpegawai2->esl:'-')."</Data></Cell>
                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".strtoupper(($urutanjabatanpegawai2->jabatan!='')?$urutanjabatanpegawai2->jabatan:'-')." PADA ".(($urutanjabatanpegawai2->path !='-')?$urutanjabatanpegawai2->path:'')."&#10;".(($urutanjabatanpegawai2->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai2->tmtjbt)):'')."</Data></Cell>
                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->mkthnpkt."</Data></Cell>
                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->mkblnpkt."</Data></Cell>
                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai2->mkskr,0,-2)."</Data></Cell>
                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai2->mkskr,-2)."</Data></Cell>
                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->tkpendid." - ".$urutanjabatanpegawai2->jenjurusan."</Data></Cell>
                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai2->agama."&#10;".substr($urutanjabatanpegawai2->usia,0,2)." thn ".substr($urutanjabatanpegawai2->usia,2,2)." bln</Data></Cell>
                   </Row>";
                }


                $lop2++;
                $arr_lop2[$lop2] = $urutanjabatanpegawai2->idskpdsub;
                if($arr_lop2[$lop2]!=$arr_lop2[$lop2-1]){

                    $z = 0;
                    $arrz[0]= "";
                    $tz = 0;

                    //looping 3
                    $lop3 = 0;
                    $arr_lop3[0]= "";

                    foreach(geturutanpegawai($urutanjabatanpegawai2->idskpdsub, $urutanjabatanpegawai2->idskpdsub) as $urutanjabatanpegawai3){

                        if(count(getPegawai($urutanjabatanpegawai3->idskpdsub, $urutanjabatanpegawai3->jab_asn)) == 0){
                            $tz++;
                            $arrz[$tz] = $urutanjabatanpegawai3->idskpdsub;
                            if($arrz[$tz]!=$arrz[$tz-1]){
                                $z++;
                                $x++;

                                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"36\">
                                <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                                <Cell ss:StyleID=\"s74\"/>
                                <Cell ss:StyleID=\"s74\"/>
                                <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai3->idesljbt)."\"><Data ss:Type=\"Number\">".$z."</Data></Cell>
                                <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2583562549428\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->jab_utuh." (Jabatan Kosong)</Data></Cell>
                                <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                               </Row>";
                            }
                        }

                        if($urutanjabatanpegawai3->nip != ''){
                            $z++;
                            $x++;
                            $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"36\">
                            <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                            <Cell ss:StyleID=\"s74\"/>
                            <Cell ss:StyleID=\"s74\"/>
                            <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai3->idesljbt)."\"><Data ss:Type=\"Number\">".$z."</Data></Cell>
                            <Cell ss:MergeAcross=\"1\" ss:StyleID=\"m2583562549428\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->namalengkap."&#10;".$urutanjabatanpegawai3->tmlhr.", ".(($urutanjabatanpegawai3->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tglhr)):'')."</Data></Cell>
                            <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->nip."&#10;".$urutanjabatanpegawai3->niplama."</Data></Cell>
                            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->golru."&#10;".(($urutanjabatanpegawai3->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tmtpkt)):'')."</Data></Cell>
                            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".(($urutanjabatanpegawai3->esl!='')?$urutanjabatanpegawai3->esl:'-')."</Data></Cell>
                            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".strtoupper(($urutanjabatanpegawai3->jabatan!='')?$urutanjabatanpegawai3->jabatan:'-')." PADA ".(($urutanjabatanpegawai3->path !='-')?$urutanjabatanpegawai3->path:'')."&#10;".(($urutanjabatanpegawai3->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai3->tmtjbt)):'')."</Data></Cell>
                            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->mkthnpkt."</Data></Cell>
                            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->mkblnpkt."</Data></Cell>
                            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai3->mkskr,0,-2)."</Data></Cell>
                            <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai3->mkskr,-2)."</Data></Cell>
                            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->tkpendid." - ".$urutanjabatanpegawai3->jenjurusan."</Data></Cell>
                            <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai3->agama."&#10;".substr($urutanjabatanpegawai3->usia,0,2)." thn ".substr($urutanjabatanpegawai3->usia,2,2)." bln</Data></Cell>
                           </Row>";
                        }

                        $lop3++;
                        $arr_lop3[$lop3] = $urutanjabatanpegawai3->idskpdsub;
                        if($arr_lop3[$lop3]!=$arr_lop3[$lop3-1]){

                            $q = 0;
                            $arrq[0]= "";
                            $tq = 0;

                            foreach(geturutanpegawai($urutanjabatanpegawai3->idskpdsub, $urutanjabatanpegawai3->idskpdsub) as $urutanjabatanpegawai4){

                                if(count(getPegawai($urutanjabatanpegawai4->idskpdsub, $urutanjabatanpegawai4->jab_asn)) == 0){
                                    $tq++;
                                    $arrq[$tq] = $urutanjabatanpegawai4->idskpdsub;
                                    if($arrq[$tq]!=$arrq[$tq-1]){
                                        $q++;
                                        $x++;
                                        $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
                                        <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                                        <Cell ss:StyleID=\"s74\"/>
                                        <Cell ss:StyleID=\"s74\"/>
                                        <Cell ss:StyleID=\"s74\"/>
                                        <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai4->idesljbt)."\"><Data ss:Type=\"Number\">".$q."</Data></Cell>
                                        <Cell ss:StyleID=\"s95\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->jab_utuh." (Jabatan Kosong)</Data></Cell>
                                        <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                        <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\"></Data></Cell>
                                       </Row>";
                                    }
                                }

                                if($urutanjabatanpegawai4->nip != ''){
                                    $q++;
                                    $x++;
                                    $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"32.25\">
                                    <Cell ss:StyleID=\"s74\"><Data ss:Type=\"Number\">".$x."</Data></Cell>
                                    <Cell ss:StyleID=\"s74\"/>
                                    <Cell ss:StyleID=\"s74\"/>
                                    <Cell ss:StyleID=\"s74\"/>
                                    <Cell ss:StyleID=\"".UrutanjabatanpegawaiModel::warnajabatanx($urutanjabatanpegawai4->idesljbt)."\"><Data ss:Type=\"Number\">".$q."</Data></Cell>
                                    <Cell ss:StyleID=\"s95\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->namalengkap."&#10;".$urutanjabatanpegawai4->tmlhr.", ".(($urutanjabatanpegawai4->tglhr != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tglhr)):'')."</Data></Cell>
                                    <Cell ss:StyleID=\"s83\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->nip."&#10;".$urutanjabatanpegawai4->niplama."</Data></Cell>
                                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->golru."&#10;".(($urutanjabatanpegawai4->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tmtpkt)):'')."</Data></Cell>
                                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".(($urutanjabatanpegawai4->esl!='')?$urutanjabatanpegawai4->esl:'-')."</Data></Cell>
                                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".strtoupper(($urutanjabatanpegawai4->jabatan!='')?$urutanjabatanpegawai4->jabatan:'-')." PADA ".(($urutanjabatanpegawai4->path !='-')?$urutanjabatanpegawai4->path:'')."&#10;".(($urutanjabatanpegawai4->tmtjbt != '0000-00-00')?date('d-m-Y', strtotime($urutanjabatanpegawai4->tmtjbt)):'')."</Data></Cell>
                                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->mkthnpkt."</Data></Cell>
                                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->mkblnpkt."</Data></Cell>
                                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai4->mkskr,0,-2)."</Data></Cell>
                                    <Cell ss:StyleID=\"s85\"><Data ss:Type=\"String\">".substr($urutanjabatanpegawai4->mkskr,-2)."</Data></Cell>
                                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->tkpendid." - ".$urutanjabatanpegawai4->jenjurusan."</Data></Cell>
                                    <Cell ss:StyleID=\"s84\"><Data ss:Type=\"String\">".$urutanjabatanpegawai4->agama."&#10;".substr($urutanjabatanpegawai4->usia,0,2)." thn ".substr($urutanjabatanpegawai4->usia,2,2)." bln</Data></Cell>
                                   </Row>";
                                }
                            }
                        }
                    }
                }
            }
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
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>-3</HorizontalResolution>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Zoom>85</Zoom>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>4</ActiveRow>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>";

force_download("nominatif_pegawai_".date('Ymds').".xls", $w);
?>
