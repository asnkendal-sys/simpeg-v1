
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_skpd')->where('idesl', '!=', 99)->where('idskpd', $subcontent)->orderBy('idskpd')->get();
        }else{
            $rs = \DB::table('a_skpd')->where('idesl', '!=', 99)->orderBy('idskpd')->get();
        }

        $json  = '{"jabstruk": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idjab":"'.$item->idskpd.'",
                    "jabatan":"'.$item->jab_utuh.'",
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
