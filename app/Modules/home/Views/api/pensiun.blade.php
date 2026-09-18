
    <?php
        $where = "nip != ''";
        if((!empty($offset)) or ($limit)){
            if($subcontent != 'all'){
                $where.= " and idskpd like \"".$subcontent."%\" ";
                $rs = \DB::table('v_api_pensiun')                    
                    ->whereRaw($where)
                    ->orderBy('tmtpens', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
            }else{
                $rs = \DB::table('v_api_pensiun')
                    ->whereRaw($where)
                    ->orderBy('tmtpens', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
            }
        }else{
            if($subcontent != 'all'){
                $where.= " and idskpd like \"".$subcontent."%\" ";
                $rs = \DB::table('v_api_pensiun')
                    ->whereRaw($where)
                    ->orderBy('tmtpens', 'desc')
                    ->get();
            }else{
                $rs = \DB::table('v_api_pensiun')
                    ->whereRaw($where)
                    ->orderBy('tmtpens', 'desc')
                    ->get();
            }
        }

        $json  = '{"pegawai": [';
        $char = '"';
        if(count($rs) > 0){
            foreach($rs as $item){
                $json .='{
                    "status":"true",
                    "nip_pejabat":"'.$item->nip.'",
                    "nama_pejabat":"'.$item->namalengkap.'",
                    "kd_jns_jab":"'.$item->idjenjab.'",
                    "kd_jabatan":"'.$item->idjabatan.'",
                    "jabatan":"'.$item->jabatan.'",
                    "kd_golongan":"'.$item->idgolrupkt.'",
                    "golongan":"'.$item->golru.'",
                    "pangkat":"'.$item->pangkat.'",
                    "kd_unker":"'.$item->idskpd.'",
                    "unker":"'.$item->path_short.'",                    
                    "status_kedudukan":"'.$item->idjenkedudupeg.'"},';
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
