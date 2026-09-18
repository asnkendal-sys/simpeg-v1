<div class="table-responsive">
    <div align="center">
        REKAPITULASI : JUMLAH CALON / PEGAWAI NEGERI SIPIL<br>
        {!! (($idskpd!='')?'PADA '.strtoupper(getSkpd($idskpd)):'') !!}
        {!!strtoupper(getUtility('kab_instansi'))!!}<br/>
        KEADAAN : {!!formatTanggalPanjang(date('Y-m-d'))!!}
    </div>

    <table class="table table-striped table-bordered table-hover table-condensed ">
    <thead class="bg-primary">
    <tr>
        <th rowspan="3"><div align='center'>No</div></th>
        <th rowspan="3"><div align='center'>Unit Organisasi</div></th>
        <th colspan="22"><div align='center'>Pegawai</div></th>
        <th colspan="8"><div align='center'>Calon Pegawai</div></th>
        <th colspan="18"><div align='center'>PPPK </div></th>
        <th colspan="11"><div align='center'>Tingkat Pendidikan</div></th>
        <th colspan="2"><div align='center'>Jenis Kelamin</div></th>
        <th colspan="8"><div align='center'>Tingkat Umur (tahun)</div></th>
    </tr>
    <tr>
        <th rowspan="2"><div align='center'>Jml Total</div></th>
        <th rowspan="2"><div align='center'>Jml Gol I</div></th>
        <th colspan="4"><div align='center'>Golongan I</div></th>
        <th rowspan="2"><div align='center'>Jml Gol II</div></th>
        <th colspan="4"><div align='center'>Golongan II</div></th>
        <th rowspan="2"><div align='center'>Jml Gol III</div></th>
        <th colspan="4"><div align='center'>Golongan III</div></th>
        <th rowspan="2"><div align='center'>Jml Gol IV</div></th>
        <th colspan="5"><div align='center'>Golongan IV</div></th>
        <th rowspan="2">JML</th>
        <th colspan="2" nowrap>Gol I</th>
        <th colspan="3" nowrap>Gol II</th>
        <th colspan="2" nowrap>Gol III</th>
        <th rowspan="2">JML</th>
        <th colspan="17">Golongan</th>
        <th rowspan="2">JML</th>
        <th rowspan="2">SD</th>
        <th rowspan="2">SLTP</th>
        <th rowspan="2">SLTA</th>
        <th rowspan="2">D1</th> 
        <th rowspan="2">D2</th> 
        <th rowspan="2">D3</th>
        <th rowspan="2">D4</th>
        <th rowspan="2">S1</th>
        <th rowspan="2">S2</th>
        <th rowspan="2">S3</th>
        <th rowspan="2"><div align='center'>L</div></th>
        <th rowspan="2"><div align='center'>P</div></th>
        <th rowspan="2">18-25</th>
        <th rowspan="2">26-30</th>
        <th rowspan="2">31-35</th>
        <th rowspan="2">36-40</th>
        <th rowspan="2">41-45</th>
        <th rowspan="2">46-50</th>
        <th rowspan="2">51-55</th>
        <th rowspan="2">>56</th>
    </tr>
    <tr>
        <th>a</th>
        <th>b</th>
        <th>c</th>
        <th>d</th>
        <th>a</th>
        <th>b</th>
        <th>c</th>
        <th>d</th>
        <th>a</th>
        <th>b</th>
        <th>c</th>
        <th>d</th>
        <th>a</th>
        <th>b</th>
        <th>c</th>
        <th>d</th>
        <th>e</th>
        <th>a</th>
        <th>b</th>
        <th>a</th>
        <th>b</th>
        <th>c</th>
        <th>a</th>
        <th>b</th>
        <th>I</th>
        <th>II</th>
        <th>III</th>
        <th>IV</th>
        <th>V</th>
        <th>VI</th>
        <th>VII</th>
        <th>VIII</th>
        <th>IX</th>
        <th>X</th>
        <th>XI</th>
        <th>XII</th>
        <th>XIII</th>
        <th>XIV</th>
        <th>XV</th>
        <th>XVI</th>
        <th>XVII</th>
    </tr>
    </thead>
    <tbody>

    <?php
    if(\Input::get('idskpd') != ''){
        $rs = \DB::table('tb_01')
                ->select('a_skpd.idskpd','a_skpd.skpd',
                \DB::raw("COUNT(*) AS jml"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=11,1,0)) AS gol1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=12,1,0)) AS gol1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=13,1,0)) AS gol1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=14,1,0)) AS gol1d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=1, 1,0)) jmlgol1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=21,1,0)) AS gol2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=22,1,0)) AS gol2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=23,1,0)) AS gol2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=24,1,0)) AS gol2d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=2, 1,0)) jmlgol2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=31,1,0)) AS gol3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=32,1,0)) AS gol3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=33,1,0)) AS gol3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=34,1,0)) AS gol3d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=3, 1,0)) jmlgol3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=41,1,0)) AS gol4a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=42,1,0)) AS gol4b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=43,1,0)) AS gol4c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=44,1,0)) AS gol4d"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=45,1,0)) AS gol4e"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=4, 1,0)) jmlgol4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=11,1,0)) AS g1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=12,1,0)) AS g1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=21,1,0)) AS g2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=22,1,0)) AS g2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=23,1,0)) AS g2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=31,1,0)) AS g3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=32,1,0)) AS g3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt IN (11,12,21,22,23,31,32),1,0)) AS jmlcpns"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=11,1,0)) AS g1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=12,1,0)) AS g2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=13,1,0)) AS g3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=14,1,0)) AS g4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=21,1,0)) AS g5"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=22,1,0)) AS g6"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=23,1,0)) AS g7"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=24,1,0)) AS g8"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=31,1,0)) AS g9"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=32,1,0)) AS g10"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=33,1,0)) AS g11"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=34,1,0)) AS g12"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=41,1,0)) AS g13"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=42,1,0)) AS g14"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=43,1,0)) AS g15"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=44,1,0)) AS g16"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=45,1,0)) AS g17"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt IN (11,12,13,14,21,22,23,24,31,32,33,34,41,42,43,44,45),1,0)) AS jmlpppk"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='05',1,0)) AS sd"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='10' or tb_01.idtkpendid='12',1,0)) AS smp"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='15' or tb_01.idtkpendid='17' or tb_01.idtkpendid='18',1,0)) AS sma"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='20',1,0)) AS d1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='25',1,0)) AS d2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='30',1,0)) AS d3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='35',1,0)) AS d4"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=50,1,0)) AS sarnon"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=60,1,0)) AS sarmud"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='40',1,0)) AS s1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='45',1,0)) AS s2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='50',1,0)) AS s3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid IN (05,10,12,15,17,18,20,25,30,35,60,40,45,50),1,0)) AS jmlpend"),
                \DB::raw("SUM(IF(tb_01.idjenkel=1,1,0)) AS jmll"),
                \DB::raw("SUM(IF(tb_01.idjenkel=2,1,0)) AS jmlp"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 18 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 25,1,0)) AS u1825"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 26 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 30,1,0)) AS u2630"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 31 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 35,1,0)) AS u3135"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 36 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 40,1,0)) AS u3640"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 41 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 45,1,0)) AS u4145"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 46 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 50,1,0)) AS u4650"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 51 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 55,1,0)) AS u5155"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 56,1,0)) AS u56")
            )
            ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->whereRaw("a_skpd.idskpd like  '".Input::get('idskpd')."%' and a_skpd.idskpd != 99 and tb_01.idjenkedudupeg not in(99,21)")
            ->orderBy('tb_01.idskpd','asc')
            ->groupBy('tb_01.idskpd')
            ->get();
    }else{
        $rs = \DB::table('tb_01')
                ->select('a_skpd.idskpd','a_skpd.skpd',
                \DB::raw("COUNT(*) AS jml"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=11,1,0)) AS gol1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=12,1,0)) AS gol1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=13,1,0)) AS gol1c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=14,1,0)) AS gol1d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=1, 1,0)) jmlgol1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=21,1,0)) AS gol2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=22,1,0)) AS gol2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=23,1,0)) AS gol2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=24,1,0)) AS gol2d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=2, 1,0)) jmlgol2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=31,1,0)) AS gol3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=32,1,0)) AS gol3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=33,1,0)) AS gol3c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=34,1,0)) AS gol3d"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=3, 1,0)) jmlgol3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=41,1,0)) AS gol4a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=42,1,0)) AS gol4b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=43,1,0)) AS gol4c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=44,1,0)) AS gol4d"),
                \DB::raw("SUM(IF(tb_01.idstspeg=2 AND tb_01.idgolrupkt=45,1,0)) AS gol4e"),
                \DB::raw("SUM(IF(LEFT(tb_01.idgolrupkt,1)=4, 1,0)) jmlgol4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=11,1,0)) AS g1a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=12,1,0)) AS g1b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=21,1,0)) AS g2a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=22,1,0)) AS g2b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=23,1,0)) AS g2c"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=31,1,0)) AS g3a"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt=32,1,0)) AS g3b"),
                \DB::raw("SUM(IF(tb_01.idstspeg=1 AND tb_01.idgolrupkt IN (11,12,21,22,23,31,32),1,0)) AS jmlcpns"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=11,1,0)) AS g1"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=12,1,0)) AS g2"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=13,1,0)) AS g3"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=14,1,0)) AS g4"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=21,1,0)) AS g5"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=22,1,0)) AS g6"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=23,1,0)) AS g7"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=24,1,0)) AS g8"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=31,1,0)) AS g9"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=32,1,0)) AS g10"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=33,1,0)) AS g11"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=34,1,0)) AS g12"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=41,1,0)) AS g13"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=42,1,0)) AS g14"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=43,1,0)) AS g15"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=44,1,0)) AS g16"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt=45,1,0)) AS g17"),
                \DB::raw("SUM(IF(tb_01.idstspeg=3 AND tb_01.idgolrupkt IN (11,12,13,14,21,22,23,24,31,32,33,34,41,42,43,44,45),1,0)) AS jmlpppk"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='05',1,0)) AS sd"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='10' or tb_01.idtkpendid='12',1,0)) AS smp"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='15' or tb_01.idtkpendid='17' or tb_01.idtkpendid='18',1,0)) AS sma"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='20',1,0)) AS d1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='25',1,0)) AS d2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='30',1,0)) AS d3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='35',1,0)) AS d4"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=50,1,0)) AS sarnon"),
                \DB::raw("SUM(IF(tb_01.idtkpendid=60,1,0)) AS sarmud"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='40',1,0)) AS s1"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='45',1,0)) AS s2"),
                \DB::raw("SUM(IF(tb_01.idtkpendid='50',1,0)) AS s3"),
                \DB::raw("SUM(IF(tb_01.idtkpendid IN (05,10,12,15,17,18,20,25,30,35,60,40,45,50),1,0)) AS jmlpend"),
                \DB::raw("SUM(IF(tb_01.idjenkel=1,1,0)) AS jmll"),
                \DB::raw("SUM(IF(tb_01.idjenkel=2,1,0)) AS jmlp"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 18 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 25,1,0)) AS u1825"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 26 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 30,1,0)) AS u2630"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 31 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 35,1,0)) AS u3135"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 36 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 40,1,0)) AS u3640"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 41 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 45,1,0)) AS u4145"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 46 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 50,1,0)) AS u4650"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 51 AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 <= 55,1,0)) AS u5155"),
                \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 >= 56,1,0)) AS u56")
            )
            ->leftjoin('a_skpd', DB::raw('left(tb_01.idskpd,2)'), '=', DB::raw('left(a_skpd.idskpd,2)'))
            ->whereRaw("a_skpd.idparent = '' and a_skpd.idskpd != 99 and tb_01.idjenkedudupeg not in(99,21)")
            ->orderBy('tb_01.idskpd','asc')
            ->groupBy(\DB::raw('LEFT(tb_01.idskpd,2)'))
            ->get();
    }


    $n = 0;

    $jml[$n] = 0; $jmlgol1[$n] = 0; $gol1a[$n] = 0;
    $gol1b[$n] = 0; $gol1c[$n] = 0; $gol1d[$n] = 0;
    $jmlgol2[$n] = 0; $gol2a[$n] = 0; $gol2b[$n] = 0;
    $gol2c[$n] = 0; $gol2d[$n] = 0; $jmlgol3[$n] = 0;
    $gol3a[$n] = 0; $gol3b[$n] = 0; $gol3c[$n] = 0;
    $gol3d[$n] = 0; $jmlgol4[$n] = 0;
    $gol4a[$n] = 0; $gol4b[$n] = 0; $gol4c[$n] = 0; $gol4d[$n] = 0;
    $gol4e[$n] = 0; $jmlcpns[$n] = 0; $g1a[$n] = 0;
    $g1b[$n] = 0; $g2a[$n] = 0;
    $g2b[$n] = 0; $g2c[$n] = 0;
    $g3a[$n] = 0; $g3b[$n] = 0;
    $jmlpppk[$n] = 0;
    $g1[$n] = 0; $g2[$n] = 0; $g3[$n] = 0;
    $g4[$n] = 0; $g5[$n] = 0; $g6[$n] = 0;
    $g7[$n] = 0; $g8[$n] = 0; $g9[$n] = 0;
    $g10[$n] = 0; $g11[$n] = 0; $g12[$n] = 0;
    $g13[$n] = 0; $g14[$n] = 0; $g15[$n] = 0; $g16[$n] = 0; $g17[$n] = 0;
    $jmlpend[$n] = 0;
    $sd[$n] = 0; $smp[$n] = 0;
    $sma[$n] = 0; $d2[$n] = 0;
    $d1[$n] = 0; $d4[$n] = 0;
    $d3[$n] = 0; $s1[$n] = 0;
    $s2[$n] = 0; $s3[$n] = 0;
    $jmll[$n] = 0; $jmlp[$n] = 0;
    $u1825[$n] = 0; $u2630[$n] = 0;
    $u3135[$n] = 0; $u3640[$n] = 0;
    $u4145[$n] = 0; $u4650[$n] = 0;
    $u5155[$n] = 0; $u56[$n] = 0;

    foreach ($rs as $item) {
        $n++;

        $jml[$n] = $item->jml; $jmlgol1[$n] = $item->jmlgol1; $gol1a[$n] = $item->gol1a;
        $gol1b[$n] = $item->gol1b; $gol1c[$n] = $item->gol1c; $gol1d[$n] = $item->gol1d;
        $jmlgol2[$n] = $item->jmlgol2; $gol2a[$n] = $item->gol2a; $gol2b[$n] = $item->gol2b;
        $gol2c[$n] = $item->gol2c; $gol2d[$n] = $item->gol2d; $jmlgol3[$n] = $item->jmlgol3;
        $gol3a[$n] = $item->gol3a; $gol3b[$n] = $item->gol3b; $gol3c[$n] = $item->gol3c;
        $gol3d[$n] = $item->gol3d; $jmlgol4[$n] = $item->jmlgol4;
        $gol4a[$n] = $item->gol4a; $gol4b[$n] = $item->gol4b; $gol4c[$n] = $item->gol4c; $gol4d[$n] = $item->gol4d;
        $gol4e[$n] = $item->gol4e; $jmlcpns[$n] = $item->jmlcpns; $g1a[$n] = $item->g1a;
        $g1b[$n] = $item->g1b; $g2a[$n] = $item->g2a;
        $g2b[$n] = $item->g2b; $g2c[$n] = $item->g2c;
        $g3a[$n] = $item->g3a; $g3b[$n] = $item->g3b;
        $jmlpppk[$n] = $item->jmlpppk;
        $g1[$n] = $item->g1; $g2[$n] = $item->g2; $g3[$n] = $item->g3;
        $g4[$n] = $item->g4; $g5[$n] = $item->g5; $g6[$n] = $item->g6;
        $g7[$n] = $item->g7; $g8[$n] = $item->g8; $g9[$n] = $item->g9;
        $g10[$n] = $item->g10; $g11[$n] = $item->g11; $g12[$n] = $item->g12;
        $g13[$n] = $item->g13; $g14[$n] = $item->g14; $g15[$n] = $item->g15; $g16[$n] = $item->g16; $g17[$n] = $item->g17;
        $jmlpend[$n] = $item->jmlpend;
        $sd[$n] = $item->sd; $smp[$n] = $item->smp;
        $sma[$n] = $item->sma; $d2[$n] = $item->d2;
        $d1[$n] = $item->d1; $d4[$n] = $item->d4;
        $d3[$n] = $item->d3; $s1[$n] = $item->s1;
        $s2[$n] = $item->s2; $s3[$n] = $item->s3;
        $jmll[$n] = $item->jmll; $jmlp[$n] = $item->jmlp;
        $u1825[$n] = $item->u1825; $u2630[$n] = $item->u2630;
        $u3135[$n] = $item->u3135; $u3640[$n] = $item->u3640;
        $u4145[$n] = $item->u4145; $u4650[$n] = $item->u4650;
        $u5155[$n] = $item->u5155; $u56[$n] = $item->u56;
        ?>
    <tr>
        <td><div align='center'>{!!$n!!}</div></td>
        <td><div align='left'>{!!$item->skpd!!}</div></td>
        <td><div align='right'>{!!$item->jml!!}</div></td>
        <td><div align='right'>{!!$item->jmlgol1!!}</div></td>
        <td><div align='right'>{!!$item->gol1a!!}</div></td>
        <td><div align='right'>{!!$item->gol1b!!}</div></td>
        <td><div align='right'>{!!$item->gol1c!!}</div></td>
        <td><div align='right'>{!!$item->gol1d!!}</div></td>
        <td><div align='right'>{!!$item->jmlgol2!!}</div></td>
        <td><div align='right'>{!!$item->gol2a!!}</div></td>
        <td><div align='right'>{!!$item->gol2b!!}</div></td>
        <td><div align='right'>{!!$item->gol2c!!}</div></td>
        <td><div align='right'>{!!$item->gol2d!!}</div></td>
        <td><div align='right'>{!!$item->jmlgol3!!}</div></td>
        <td><div align='right'>{!!$item->gol3a!!}</div></td>
        <td><div align='right'>{!!$item->gol3b!!}</div></td>
        <td><div align='right'>{!!$item->gol3c!!}</div></td>
        <td><div align='right'>{!!$item->gol3d!!}</div></td>
        <td><div align='right'>{!!$item->jmlgol4!!}</div></td>
        <td><div align='right'>{!!$item->gol4a!!}</div></td>
        <td><div align='right'>{!!$item->gol4b!!}</div></td>
        <td><div align='right'>{!!$item->gol4c!!}</div></td>
        <td><div align='right'>{!!$item->gol4d!!}</div></td>
        <td><div align='right'>{!!$item->gol4e!!}</div></td>
        <td><div align='right'>{!!$item->jmlcpns!!}</div></td>
        <td><div align='right'>{!!$item->g1a!!}</div></td>
        <td><div align='right'>{!!$item->g1b!!}</div></td>
        <td><div align='right'>{!!$item->g2a!!}</div></td>
        <td><div align='right'>{!!$item->g2b!!}</div></td>
        <td><div align='right'>{!!$item->g2c!!}</div></td>
        <td><div align='right'>{!!$item->g3a!!}</div></td>
        <td><div align='right'>{!!$item->g3b!!}</div></td>
        <td><div align='right'>{!!$item->jmlpppk!!}</div></td>
        <td><div align='right'>{!!$item->g1!!}</div></td>
        <td><div align='right'>{!!$item->g2!!}</div></td>
        <td><div align='right'>{!!$item->g3!!}</div></td>
        <td><div align='right'>{!!$item->g4!!}</div></td>
        <td><div align='right'>{!!$item->g5!!}</div></td>
        <td><div align='right'>{!!$item->g6!!}</div></td>
        <td><div align='right'>{!!$item->g7!!}</div></td>
        <td><div align='right'>{!!$item->g8!!}</div></td>
        <td><div align='right'>{!!$item->g9!!}</div></td>
        <td><div align='right'>{!!$item->g10!!}</div></td>
        <td><div align='right'>{!!$item->g11!!}</div></td>
        <td><div align='right'>{!!$item->g12!!}</div></td>
        <td><div align='right'>{!!$item->g13!!}</div></td>
        <td><div align='right'>{!!$item->g14!!}</div></td>
        <td><div align='right'>{!!$item->g15!!}</div></td>
        <td><div align='right'>{!!$item->g16!!}</div></td>
        <td><div align='right'>{!!$item->g17!!}</div></td>
        <td><div align='right'>{!!$item->jmlpend!!}</div></td>
        <td><div align='right'>{!!$item->sd!!}</div></td>
        <td><div align='right'>{!!$item->smp!!}</div></td>
        <td><div align='right'>{!!$item->sma!!}</div></td>
        <td><div align='right'>{!!$item->d1!!}</div></td>
        <td><div align='right'>{!!$item->d2!!}</div></td>
        <td><div align='right'>{!!$item->d3!!}</div></td>
        <td><div align='right'>{!!$item->d4!!}</div></td>
        <td><div align='right'>{!!$item->s1!!}</div></td>
        <td><div align='right'>{!!$item->s2!!}</div></td>
        <td><div align='right'>{!!$item->s3!!}</div></td>
        <td><div align='right'>{!!$item->jmll!!}</div></td>
        <td><div align='right'>{!!$item->jmlp!!}</div></td>
        <td><div align='right'>{!!$item->u1825!!}</div></td>
        <td><div align='right'>{!!$item->u2630!!}</div></td>
        <td><div align='right'>{!!$item->u3135!!}</div></td>
        <td><div align='right'>{!!$item->u3640!!}</div></td>
        <td><div align='right'>{!!$item->u4145!!}</div></td>
        <td><div align='right'>{!!$item->u4650!!}</div></td>
        <td><div align='right'>{!!$item->u5155!!}</div></td>
        <td><div align='right'>{!!$item->u56!!}</div></td>
    </tr>
        <?php } ?>

    <tr>
        <td>&nbsp;</td>
        <td>TOTAL</td>
        <td><div align='right'>{!!array_sum($jml)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlgol1)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol1a)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol1b)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol1c)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol1d)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlgol2)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol2a)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol2b)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol2c)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol2d)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlgol3)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol3a)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol3b)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol3c)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol3d)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlgol4)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol4a)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol4b)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol4c)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol4d)!!}</div></td>
        <td><div align='right'>{!!array_sum($gol4e)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlcpns)!!}</div></td>
        <td><div align='right'>{!!array_sum($g1a)!!}</div></td>
        <td><div align='right'>{!!array_sum($g1b)!!}</div></td>
        <td><div align='right'>{!!array_sum($g2a)!!}</div></td>
        <td><div align='right'>{!!array_sum($g2b)!!}</div></td>
        <td><div align='right'>{!!array_sum($g2c)!!}</div></td>
        <td><div align='right'>{!!array_sum($g3a)!!}</div></td>
        <td><div align='right'>{!!array_sum($g3b)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlpppk)!!}</div></td>
        <td><div align='right'>{!!array_sum($g1)!!}</div></td>
        <td><div align='right'>{!!array_sum($g2)!!}</div></td>
        <td><div align='right'>{!!array_sum($g3)!!}</div></td>
        <td><div align='right'>{!!array_sum($g4)!!}</div></td>
        <td><div align='right'>{!!array_sum($g5)!!}</div></td>
        <td><div align='right'>{!!array_sum($g6)!!}</div></td>
        <td><div align='right'>{!!array_sum($g7)!!}</div></td>
        <td><div align='right'>{!!array_sum($g8)!!}</div></td>
        <td><div align='right'>{!!array_sum($g9)!!}</div></td>
        <td><div align='right'>{!!array_sum($g10)!!}</div></td>
        <td><div align='right'>{!!array_sum($g11)!!}</div></td>
        <td><div align='right'>{!!array_sum($g12)!!}</div></td>
        <td><div align='right'>{!!array_sum($g13)!!}</div></td>
        <td><div align='right'>{!!array_sum($g14)!!}</div></td>
        <td><div align='right'>{!!array_sum($g15)!!}</div></td>
        <td><div align='right'>{!!array_sum($g16)!!}</div></td>
        <td><div align='right'>{!!array_sum($g17)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlpend)!!}</div></td>
        <td><div align='right'>{!!array_sum($sd)!!}</div></td>
        <td><div align='right'>{!!array_sum($smp)!!}</div></td>
        <td><div align='right'>{!!array_sum($sma)!!}</div></td>
        <td><div align='right'>{!!array_sum($d1)!!}</div></td>
        <td><div align='right'>{!!array_sum($d2)!!}</div></td>
        <td><div align='right'>{!!array_sum($d3)!!}</div></td>
        <td><div align='right'>{!!array_sum($d4)!!}</div></td>
        <td><div align='right'>{!!array_sum($s1)!!}</div></td>
        <td><div align='right'>{!!array_sum($s2)!!}</div></td>
        <td><div align='right'>{!!array_sum($s3)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmll)!!}</div></td>
        <td><div align='right'>{!!array_sum($jmlp)!!}</div></td>
        <td><div align='right'>{!!array_sum($u1825)!!}</div></td>
        <td><div align='right'>{!!array_sum($u2630)!!}</div></td>
        <td><div align='right'>{!!array_sum($u3135)!!}</div></td>
        <td><div align='right'>{!!array_sum($u3640)!!}</div></td>
        <td><div align='right'>{!!array_sum($u4145)!!}</div></td>
        <td><div align='right'>{!!array_sum($u4650)!!}</div></td>
        <td><div align='right'>{!!array_sum($u5155)!!}</div></td>
        <td><div align='right'>{!!array_sum($u56)!!}</div></td>
    </tr>
    </tbody>
    </table><br><br><br>
</div> <!-- .bungkus-table -->