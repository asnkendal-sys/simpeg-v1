<?php namespace App\Modules\kenaikangajiberkala\penetapannonnominatif\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penetapannonnominatif Model
* @var Penetapannonnominatif
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenetapannonnominatifModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kgb";

	public static $rules = array(
        'tmtkgbb' => 'required',
		'tgskkgb' => 'required',
//		'noskkgbb' => 'required',
		'mktkgbb' => 'required',
		'mkbkgbb' => 'required',
		'golru' => 'required',
		'idacuan' => 'required',
    );

	public static function all($columns = array('*')){
		$instance = new static;

        $where = "tr_kgb.statuskgb = 2";
        if(session('role_id') > 3){
            $where .= " and tr_kgb.kdskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-penetapannonnominatif-listall')){
			return $instance->newQuery()
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                        b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                        IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                        IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                        b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                        IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                        IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->where('tr_kgb.role_id', \Session::get('role_id'))
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))
			    ->paginate($_ENV['configurations']['list-limit']);
			
		}
	}

    public static function getnoskkgb($tmtkgbasli, $golru, $date){
        $rs = \DB::table('tr_kgb')
            ->select(\DB::raw("CONCAT_WS('','822.',IFNULL(LEFT(golpnsskr,1),$golru),'/',LPAD(IFNULL(MAX(MID(noskkgbb,7,4))+1,1),4,0),'/BKPP') AS nosk"))
            ->whereRaw("LEFT(golpnsskr,1) = \"".$golru."\" AND tmtkgbb = \"".$tmtkgbasli."\"")
            ->first();
        return $rs->nosk;
    }

    /*function get attribut kgb*/
    public static function getattkgb($nip){
        $rs = \DB::table("tb_01 as a")->select(
                'a.nip', 'a.niplama', 'a.nokarpeg','a.idstspeg',
                \DB::raw("DATE_ADD(IF(a.tmtpkt>a.tmtkgb,a.tmtpkt,a.tmtkgb), INTERVAL 2 YEAR) AS tmtkgbnext"),
                \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.tmlhr', 'a.tglhr', 'a.idgolrupkt', 'a.tmtpkt', \DB::raw('IF(a.idstspeg=3,f.golru_p3k,f.golru) as golru'),\DB::raw("IFNULL(g.esl,'-') AS esl"),'a.idesljbt','a.tmtjbt',
                \DB::raw("IF(a.idesljbt BETWEEN '11' AND '52',a.tmtesljbt,'0000-00-00') AS tmtesljbt"),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tmtcpn)), '%Y%m')+0 AS mkskr"),
                'h.jenjurusan','a.thijaz','i.agama','a.mkthnpkt','a.mkblnpkt',
                \DB::raw("IF(LENGTH(a.mkthnpkt)=1,CONCAT('0',a.mkthnpkt),IF(LENGTH(a.mkthnpkt)=0,'00',a.mkthnpkt)) AS mkthnpkt_"),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"),
                'a.mkthnpkt', 'a.tmtkgb', 'a.mkgolthnkgb','a.mkgolblnkgb',
                \DB::raw("IF(LENGTH(a.mkgolthnkgb)=1,CONCAT('0',a.mkgolthnkgb),IF(LENGTH(a.mkgolthnkgb)=0,'00',a.mkgolthnkgb)) AS mkgolthnkgb_"),
                \DB::raw("CONCAT(a.idgolrupkt, IF(LENGTH(a.mkgolthnkgb)>1, a.mkgolthnkgb, CONCAT(0,a.mkgolthnkgb))) AS kodegolmktkgbl"),
                'a.nosuratkgb',\DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS gkgbl"),
                'a.pejmenkgb', 'a.tgsuratkgb','a.noskkgb', 'a.tgskkgb','a.idjenjab','a.iddiperbantukan','j.nmasekolah',
                \DB::raw("IF(a.idjenjab>=20,a.idjabjbt,IF(a.idjenjab=2,a.idjabfung,IF(a.idjenjab=3,a.idjabfungum,''))) AS kdjabskr"),
                \DB::raw("IF(a.idjenjab=2,b.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',c.jab,IF(a.idjenjab=3,d.jabfungum,''))) AS namajab"),
                'a.idskpd','c.skpd', \DB::raw("a.idgolrupkt AS golruskr"), \DB::raw("e.idskpd AS idskpdskr"), \DB::raw("e.path_short AS skpdskr") //\DB::raw("if(left(e.idskpd, 2) = '01', e.path, e.path_short) AS skpdskr"
            )
            ->leftJoin('a_jabfung as b', 'a.idjabfung','=','b.idjabfung')
            ->leftJoin('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
            ->leftJoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftJoin('a_skpd as e', 'e.idskpd', '=', 'a.idskpd') //\DB::raw("IF(e.issatker = 1, LEFT(a.idskpd,5), LEFT(a.idskpd,2))")
            ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=','f.idgolru')
            ->leftJoin('a_esl as g', 'a.idesljbt', '=', 'g.idesl')
            ->leftJoin('a_jenjurusan as h', 'a.idjenjurusan', '=', 'h.idjenjurusan')
            ->leftJoin('a_agama as i', 'a.idagama', '=', 'i.idagama')
            ->leftJoin('a_sekolahswasta as j', 'a.iddiperbantukan', '=', 'j.id')
            ->where('a.nip', $nip)
            ->orderBy('e.idskpd', 'desc')
            ->first();

        return $rs;
    }

    /*get kepala skpd/ penandatangan sk kgb*/
//    public static function attrKepskpd($idgol,$idskpd,$field){
//        $where = "a.idjenkedudupeg not in (99,21)";
//        $idgol = substr($idgol, 0, 1);
//        if(substr($idskpd, 0, 2) == '04'){
//            /*dinas pendidikan*/
//            if($idgol == 4){
//                /*oleh kepala bkd*/
//                $where .=" and a.idjenjab = 20 and a.idskpd = '25'";
//                $idpenetap = '033';
//            }else{
//                /*oleh kepalla dinas pendidikan*/
//                $where .=" and a.idjenjab = 20 and a.idskpd = '04'";
//                $idpenetap = '054';
//            }
//        }else{
//            /*non dinas pendidikan*/
//            if($idgol == 1){
//                if(substr($idskpd, 0, 2) == '01'){
//                    /*oleh asisten administrasi umum sekretariat daerah*/
//                    $where .=" and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
//                    $idpenetap = '001';
//                }else{
//                    /*oleh kepala skpd*/
//                    $where .=" and a.idjenjab in (20,30,40) and a.idskpd = \"".substr($idskpd, 0, 2)."\""; //$idskpd
//                    $idpenetap = '074';
//                }
//            }else if($idgol == 2){
//                if(substr($idskpd, 0, 2) == '01'){
//                    /*oleh asisten administrasi umum sekretariat daerah*/
//                    $where .=" and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
//                    $idpenetap = '001';
//                }else{
//                    /*oleh kepala skpd*/
//                    $where .=" and a.idjenjab in (20,30,40) and a.idskpd = \"".substr($idskpd, 0, 2)."\""; //$idskpd
//                    $idpenetap = '074';
//                }
//            }else if($idgol == 3){
//                /*oleh Kabid Pembinaan bkppd*/
//                $where .=" and a.idjenjab = 30 and a.idskpd = '25.02'";
//                $idpenetap = '075';
//            }else if($idgol == 4){
//                /*ttd oleh kepala bkd*/
//                $where .=" and a.idjenjab = 20 and a.idskpd = '25'";
//                $idpenetap = '033';
//            }
//        }
//
//        $rs = \DB::table('tb_01 as a')
//            ->select(
//            'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
//            'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
//            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
//            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
//            ->whereRaw($where)
//            ->first();
//
//        $rs->idpenetap = $idpenetap;
//
//        if(count($rs) > 0){
//            /*return $rs->$field;*/
//            if(($field == 'jab_utuh') && ($idpenetap == '075')){
//                //return $rs->$field." BKPP";
//                return $rs->$field;
//            }else if(($field == 'jab') && ($idpenetap == '001')){
//                return "a.n. ".$rs->$field;
//            }else{
//                return $rs->$field;
//            }
//        }else{
//            return '-';
//        }
//    }

    /*get kepala skpd/ penandatangan sk kgb*/
    public static function attrKepskpd($idgol,$idskpd,$idstspeg,$field){
        $where = "a.idjenkedudupeg not in (99,21)";

        if($idstspeg == 3){
            if($idgol >= 31){
                /*ttd oleh kepala bkd*/
                $where .=" and a.idjenjab = 20 and a.idskpd = '25'";
                $idpenetap = '033';
                $idskpdplt = '25'; //statis kepala bkd
            }else{
                /*oleh Kabid Pembinaan bkppd*/
                $where .=" and a.idjenjab = 30 and a.idskpd = '25.02'";
                $idpenetap = '075';
                $idskpdplt = '25.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
            }
        }else{
            $idgol = substr($idgol, 0, 1); //misal gol 31 jadi 3
            if(substr($idskpd, 0, 2) == '04'){
                /*dinas pendidikan*/
                if($idgol == 4){
                    /*oleh kepala bkd*/
                    $where .=" and a.idjenjab = 20 and a.idskpd = '25'";
                    $idpenetap = '033';
                    $idskpdplt = '25'; //statis kepala bkd
                }else{
                    /*oleh kepalla dinas pendidikan*/
                    $where .=" and a.idjenjab = 20 and a.idskpd = '04'";
                    $idpenetap = '054';
                    $idskpdplt = '04'; //statis kepala dinas pendidikan
                }
            }else{
                /*non dinas pendidikan*/
                if($idgol == 1){
                    if(substr($idskpd, 0, 2) == '01'){
                        /*oleh asisten administrasi umum sekretariat daerah*/
                        $where .=" and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
                        $idpenetap = '001';
                        $idskpdplt = '01.01'; //statis Asisten Administrasi Umum
                    }else{
                        /*oleh kepala skpd*/
                        $where .=" and a.idjenjab in (20,30,40) and a.idskpd = \"".substr($idskpd, 0, 2)."\""; //$idskpd
                        $idpenetap = '074';
                        $idskpdplt = substr($idskpd, 0, 2); //dinamis kepala skpd
                    }
                }else if($idgol == 2){
                    if(substr($idskpd, 0, 2) == '01'){
                        /*oleh asisten administrasi umum sekretariat daerah*/
                        $where .=" and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
                        $idpenetap = '001';
                        $idskpdplt = '01.01'; //statis Asisten Administrasi Umum
                    }else{
                        /*oleh kepala skpd*/
                        $where .=" and a.idjenjab in (20,30,40) and a.idskpd = \"".substr($idskpd, 0, 2)."\""; //$idskpd
                        $idpenetap = '074';
                        $idskpdplt = substr($idskpd, 0, 2); //dinamis kepala skpd
                    }
                }else if($idgol == 3){
                    /*oleh Kabid Pembinaan bkppd*/
                    $where .=" and a.idjenjab = 30 and a.idskpd = '25.02'";
                    $idpenetap = '075';
                    $idskpdplt = '25.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
                }else if($idgol == 4){
                    /*ttd oleh kepala bkd*/
                    $where .=" and a.idjenjab = 20 and a.idskpd = '25'";
                    $idpenetap = '033';
                    $idskpdplt = '25'; //statis kepala bkd
                }
            }
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
            'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', \DB::raw('IF(a.idstspeg=3,c.golru_p3k,c.golru) as golru'), 'c.pangkat')
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw($where)
            ->first();

        if(count($rs) > 0){
            $rs->idpenetap = $idpenetap;
            if(($field == 'jab_utuh') && ($idpenetap == '075')){
                //return $rs->$field." BKPP";
                return $rs->$field;
            }else if(($field == 'jab') && ($idpenetap == '001')){
                return "a.n. ".$rs->$field;
            }else{
                return $rs->$field;
            }
        }else{
            $rs2 = \DB::table('a_skpd as b')
                ->select(
                'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
                ->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->whereRaw("b.idskpd = \"".$idskpdplt."\"")
                ->first();

            if(count($rs2) > 0){
                $rs2->idpenetap = $idpenetap;
                if(($field == 'jab_utuh') && ($idpenetap == '075')){
                    //return $rs2->$field." BKPP";
                    return "Plt. ".$rs2->$field;
                }else if(($field == 'jab') && ($idpenetap == '001')){
                    return "a.n. ".$rs2->$field;
                }else{
                    if($field == 'jab_utuh'){
                        return "Plt. ".$rs2->$field;
                    }else{
                        return $rs2->$field;
                    }
                }
            }else{
                return '-';
            }
        }
    }

    /*function untuk mendapatkan data kgb all*/
    public static function getDatanominatif($idkgb, $jnskgb, $idstspeg=''){
        if($jnskgb != '0'){
            $where = "a.statuskgb = 2 and a.idkgb like \"".$idkgb."%\" and a.jnskgb = \"".$jnskgb."\"";
        }else{
            $where = "a.statuskgb = 2 and a.idkgb like \"".$idkgb."%\"";
        }

        $rs = \DB::table("tr_kgb as a")
            ->select('a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, IF(f.idstspeg=3,c.golru_p3k,c.golru) as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
        )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')    
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function untuk mendapatkan data kgb yang sudah verifikasi nominatif*/
    public static function getDatanominatifver($idkgb, $jnskgb, $idstspeg=''){
        if($jnskgb != '0'){
            $where = "a.statussk = 1 and a.statuskgb = 2 and a.idkgb like \"".$idkgb."%\" and a.jnskgb = \"".$jnskgb."\"";
        }else{
            $where = "a.statussk = 1 and a.statuskgb = 2 and a.idkgb like \"".$idkgb."%\"";
        }

        $rs = \DB::table("tr_kgb as a")
            ->select('a.*',
            \DB::raw("b.pangkat as golpnsskr_txt, IF(f.idstspeg=3,c.golru_p3k,c.golru) as golpns_txt, d.jabatan as pejpenkgbl_txt"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
            \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
            \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
            \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
            \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
            \DB::raw("DATE_FORMAT(a.tglskkgbb,'%d-%m-%Y') AS tglskkgbb_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
            \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
        )
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')    
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->whereRaw($where)
            ->get();

        return $rs;
    }
}
