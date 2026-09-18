    <?php
        $where = "tb_01.idjenkedudupeg not in('99','21')";
        $where.= " and tb_01.nip = \"".$subcontent."\" ";
        $rs = \DB::table('tb_01')
            ->select('tb_01.nip','tb_01.idjenjab','tb_01.idjenkedudupeg','tb_01.idesljbt','tb_01.idskpd','tb_01.photo','a_golruang.golru','a_golruang.pangkat','a_skpd.skpd','a.skpd as skpd_induk','a_skpd.path_short','a_esl.esl',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'tb_01.idgolrupkt',
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjabatan'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
            )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->leftJoin('a_skpd as a', \DB::raw("left(tb_01.idskpd,2)"), '=', 'a.idskpd')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->whereRaw($where)
            ->get();

        $json  = '{"pegawaidetail": [';
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
                    "img":"'.url('/').'/packages/upload/photo/pegawai/'.$item->photo.'",
                    "pangkat":"'.$item->pangkat.'",
                    "kd_unker":"'.$item->idskpd.'",
                    "unker":"'.$item->skpd.'",
                    "kd_induk":"'.substr($item->idskpd,0,2).'",
                    "nama_induk":"'.$item->skpd_induk.'",
                    "kd_esselon":"'.$item->idesljbt.'",
                    "esselon":"'.$item->esl.'",
                    "status":"'.$item->idjenkedudupeg.'"},';
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
