
    <?php
    $where = "a_skpd.flag='1' AND a_skpd.id_unorindukflag !=''";
    if ($subcontent != 'all') {
        $where .= " and a_skpd.idskpd like \"" . $subcontent . "%\" ";
        // menggunakan query raw biar gampang
        $rs = \DB::select("
    select * from (
        select a.path_short, b.kdunit, sum(b.abk) as abk
        from db_bezeting.tr_petajab b
        left join db_simpeg_2017.a_skpd a on a.idskpd = b.idskpd
        group by a.path_short, b.kdunit
    ) bez 
    left join (
        select 
            a_skpd.idskpd,
            a_skpd.path_short,
            count(nip) as jumlah
        from tb_01
        left join a_skpd on tb_01.idskpd = a_skpd.idskpd
        where idjenkedudupeg not in (21,99)
        group by a_skpd.path_short, a_skpd.idskpd
    ) sim
    on sim.path_short = bez.path_short
");
    } else {

        //menggunakan query builder biar aman dari sql injection
        $bez = \DB::table('db_bezeting.tr_petajab as b')
            ->selectRaw('a.path_short, b.kdunit, SUM(b.abk) as abk')
            ->leftJoin('db_simpeg_2017.a_skpd as a', 'a.idskpd', '=', 'b.idskpd')
            ->groupBy('a.path_short', 'b.kdunit');

        $sim = \DB::table('tb_01')
            ->selectRaw('a_skpd.idskpd, a_skpd.path_short, COUNT(nip) as jumlah')
            ->leftJoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->whereNotIn('idjenkedudupeg', [21, 99])
            ->groupBy('a_skpd.path_short', 'a_skpd.idskpd');

        $rs = \DB::table(\DB::raw("({$bez->toSql()}) as bez"))
            ->mergeBindings($bez) // penting supaya binding ikut
            ->leftJoin(\DB::raw("({$sim->toSql()}) as sim"), 'sim.path_short', '=', 'bez.path_short')
            ->mergeBindings($sim)
            ->get();
    }

    $json  = '{"skpd": [';
    $char = '"';
    if (count($rs) > 0) {
        foreach ($rs as $item) {
            $json .= '{
                    "status":"true",
                    "idskpd":"' . $item->idskpd . '",
                    "skpd":"' . $item->path_short . '",
                    "bezeting":"' . $item->jumlah . ',
                    "kebutuhan":"' . $item->abk . '"},';
        }
    } else {
        $json .= '{"status":"false"},';
    }

    // buat menghilangkan koma diakhir array
    $json = substr($json, 0, strlen($json) - 1);
    $json .= ']}';

    // print json
    echo $json;
    ?>
