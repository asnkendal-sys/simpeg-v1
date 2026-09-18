
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_jabfungum')->where('idjabfungum', $subcontent)->orderBy('idjabfungum')->get();
        }else{
            $rs = \DB::table('a_jabfungum')->orderBy('idjabfungum')->get(); //275
        }

        $json  = '{"pelaksana": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idjab":"'.$item->idjabfungum.'",
                    "jabatan":"'.$item->jabfungum.'",
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
