
    <?php
    $where = "r_tandajasa.nip = \"" . $subcontent . "\" ";
    $rs = \DB::table('r_tandajasa')
        ->select(
            'r_tandajasa.nip',
            'r_tandajasa.pejab',
            'r_tandajasa.tandajasa',
            'r_tandajasa.tgsk'
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
                    "pemberi":"' . $item->pejab . '",
                    "tandajasa":"' . $item->tandajasa . '",
                    "tgsk":"' . $item->tgsk . '"},';
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
