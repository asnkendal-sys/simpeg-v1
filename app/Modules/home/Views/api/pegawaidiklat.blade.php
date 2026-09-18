    <?php
    $where = "r_diktek.nip = \"" . $subcontent . "\" ";
    $rs = \DB::table('r_diktek')
        ->select(
            'r_diktek.nip',
            'r_diktek.nmdiktek',
            'r_diktek.penyelenggara',
            'r_diktek.tgsttpdiktek'
        )
        ->whereRaw($where)
        ->get();

    $json  = '{"pegawaidetail": [';
    $char = '"';
    if (count($rs) > 0) {
        foreach ($rs as $item) {
            $json .= '{
                    "status":"true",
                    "nip":"' . $item->nip . '",
                    "diklat":"' . $item->nmdiktek . '",
                    "penyelenggara":"' . $item->penyelenggara . '",
                    "tgl":"' . $item->tgsttpdiktek . '"},';
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
