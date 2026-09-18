
    <?php
        if(!empty($subcontent)){
            $rs = \DB::table('a_esl')->where('idesl', $subcontent)->orderBy('idesl')->get();
        }else{
            $rs = \DB::table('a_esl')->orderBy('idesl')->get();
        }

        $json  = '{"eselon": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "idesl":"'.$item->idesl.'",
                    "esl":"'.$item->esl.'"},';
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
