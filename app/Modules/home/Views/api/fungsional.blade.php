
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_jabfung')->where('idjabfung', $subcontent)->orderBy('idjabfung')->get();
        }else{
            $rs = \DB::table('a_jabfung')->orderBy('idjabfung')->get();
        }

        $json  = '{"fungsional": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idjab":"'.$item->idjabfung.'",
                    "jabatan":"'.$item->jabfung.'",
                    "jenjang":"'.$item->jenjang.'",
                    "kelompok":"'.$item->jabfung2.'",
                    "bup":"'.$item->pens.'"},';
            }
        }else{
            $json .='{"status":"false"},';
        }

        // buat menghilangkan koma diakhir array
        $json = substr($json,0,strlen($json)-1);
        $json .= ']}';

        // print json
        echo $json;
    ?>
