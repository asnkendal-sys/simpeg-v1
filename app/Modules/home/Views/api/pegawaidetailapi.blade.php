
    <?php
        $tooken = (!empty($_GET['tooken']))?$_GET['tooken']:'';
        $where = "tb_01.idjenkedudupeg not in('99','21')";
        $where.= " and tb_01.nip = \"".$subcontent."\" ";
        $rs = \DB::table('tb_01')
            ->select('tb_01.nip','tb_01.idjenjab','tb_01.idjenkedudupeg','tb_01.idesljbt','tb_01.idskpd','a_golruang.golru','a_golruang.pangkat','a_skpd.skpd','a.skpd as skpd_induk','a_skpd.path_short','a_esl.esl',
                'tb_01.noktp','tb_01.nonpwp','tb_01.hp','tb_01.email' , 'tb_01.tmlhr', 'tb_01.tglhr', 'tb_01.idjenkel', 'tb_01.tmtpkt', 'tb_01.tmtjbt', 'a_agama.agama', 'a_jenkedudupeg.jenkedudupeg',
                \DB::raw('CONCAT(tb_01.alm, if(almrt!="", CONCAT(" RT : ", almrt, " RW : ", almrw), ""), " ", almdesa, " ", almkec, " ", almkab, " ", almprov, " ", almkdpos) as alamat'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'tb_01.idgolrupkt',
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjabatan'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
            )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->leftJoin('a_skpd as a', \DB::raw("left(tb_01.idskpd,2)"), '=', 'a.idskpd')
            ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_jenkedudupeg', 'tb_01.idjenkedudupeg', '=', 'a_jenkedudupeg.idjenkedudupeg')
            ->whereRaw($where)
            ->get();

        //$json  = '{"pegawaidetail": [';
        //$char = '"';

        if($tooken == '723a04808f1b060685816d1b29ad0f43'){
            if(count($rs) > 0){
                foreach($rs as $item){
                    //$json .='{
                    $json ='{
                        "status":"true",
                        "nip_pejabat":"'.$item->nip.'",
                        "nama_pejabat":"'.$item->namalengkap.'",
                        "tempatlahir":"'.$item->tmlhr.'",
                        "tanggallahir":"'.$item->tglhr.'",
                        "jeniskelamin":"'.$item->idjenkel.'",
                        "agama":"'.$item->agama.'",
                        "alamat":"'.$item->alamat.'",
                        "golongan":"'.$item->golru.'",
                        "pangkat":"'.$item->pangkat.'",
                        "tmtgolongan":"'.$item->tmtpkt.'",
                        "jabatan":"'.$item->jabatan.'",
                        "tmtjabatan":"'.$item->tmtjbt.'",
                        "unker":"'.$item->skpd.'",
                        "nama_induk":"'.$item->skpd_induk.'",
                        "esselon":"'.$item->esl.'",
                        "kabkota":"KABUPATEN KENDAL",
                        "nik":"'.$item->noktp.'",
                        "npwp":"'.$item->nonpwp.'",
                        "hp":"'.$item->hp.'",
                        "email":"'.$item->email.'",
                        "statuspegawai":"'.$item->jenkedudupeg.'"},';
                }
            }else{
                $json .='{"status":"false"},';
            }
        }else{
            $json .='{"status":"false"},';
        }

        // buat menghilangkan koma diakhir array
        $json = substr($json,0,strlen($json)-1);
        //$json .= ']}';

        // print json
        echo $json;
    ?>
