
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_skpd')->where('idparent', '')->where('idskpd', $subcontent)->orderBy('idskpd')->get();
        }else{
            $rs = \DB::table('a_skpd')->where('idparent', '')->orderBy('idskpd')->get();
        }

        $json  = '{"unitkerja": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idskpd":"'.$item->idskpd.'",
                    "skpd":"'.$item->skpd.'",
                    "idesl":"'.$item->idesl.'",
                    "bup":"'.$item->bup.'"},';
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
