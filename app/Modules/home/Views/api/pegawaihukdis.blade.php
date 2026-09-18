
    <?php
    $where = "r_hukdis.nip = \"" . $subcontent . "\" ";
    $rs = \DB::table('r_hukdis')
        ->select(
            'r_hukdis.nip',
            'r_hukdis.idtkhukum'
        )
        ->leftJoin('a_kathukdis as a', 'r_hukdis.idtkhukum', '=', 'a.idkathukdis')
        ->whereRaw($where)
        ->get();

    $json  = '{"pegawaidetail": [';
    $char = '"';
    if (count($rs) > 0) {
        foreach ($rs as $item) {
            $json .= '{
                    "status":"true",
                    "nip_pejabat":"' . $item->nip . '",
                    "tkhukdis":"' . $item->idtkhukum . '"},';
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
