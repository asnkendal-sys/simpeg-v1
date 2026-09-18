
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_golruang')->where('idgolru', $subcontent)->orderBy('idgolru')->get();
        }else{
            $rs = \DB::table('a_golruang')->orderBy('idgolru')->get();
        }

        $json  = '{"golongan": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idgolru":"'.$item->idgolru.'",
                    "golru":"'.$item->golru.'",
                    "pangkat":"'.$item->pangkat.'"},';
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
