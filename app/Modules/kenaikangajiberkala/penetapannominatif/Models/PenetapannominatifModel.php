<?php

namespace App\Modules\kenaikangajiberkala\penetapannominatif\Models;
// use Illuminate\Database\Eloquent\Model;
use App\Models\KGB\UsulanKGB;

class PenetapannominatifModel extends UsulanKGB
{
    protected $guarded = array();

    protected $table = "tr_kgb";

    public static $rules = array(
        'idskpd' => 'required',
        'bulan' => 'required',
        'tahun' => 'required'
    );

    public static function all($columns = array('*'))
    {
        $instance = new static;

        $where = "tr_kgb.jnskgb != 0";
        if (session('role_id') > 3) {
            $where .= " and tr_kgb.kdskpd like \"" . session('idskpd') . "%\" ";
        }

        if (\PermissionsLibrary::hasPermission('mod-penetapannominatif-listall')) {
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
        } else {
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

    /*function untuk mendapatkan counter sk*/
    public static function getcountersk($tmtkgbasli)
    {
        $rs = \DB::table('tr_kgb')
            ->select(\DB::raw("LPAD(IFNULL(MAX(MID(noskkgbb,7,4))+1,1),4,0) AS nosk"))
            ->where('tmtkgbb', $tmtkgbasli)
            ->first();

        return $rs->nosk;
    }

    /*function get attribut kgb*/
    //    public static function getattkgb($nip){
    //        $rs = \DB::table("tb_01 as a")->select(
    //            'a.nip', 'a.niplama', 'a.nokarpeg',
    //            \DB::raw("DATE_ADD(IF(a.tmtpkt>a.tmtkgb,a.tmtpkt,a.tmtkgb), INTERVAL 2 YEAR) AS tmtkgbnext"),
    //            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
    //            'a.tmlhr', 'a.tglhr', 'a.idgolrupkt', 'a.tmtpkt', 'f.golru',\DB::raw("IFNULL(g.esl,'-') AS esl"),'a.idesljbt','a.tmtjbt',
    //            \DB::raw("IF(a.idesljbt BETWEEN '11' AND '52',a.tmtesljbt,'') AS tmtesljbt"),
    //            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tmtcpn)), '%Y%m')+0 AS mkskr"),
    //            'h.jenjurusan','a.thijaz','i.agama','a.mkthnpkt','a.mkblnpkt',
    //            \DB::raw("IF(LENGTH(a.mkthnpkt)=1,CONCAT('0',a.mkthnpkt),IF(LENGTH(a.mkthnpkt)=0,'00',a.mkthnpkt)) AS mkthnpkt_"),
    //            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"),
    //            'a.mkthnpkt', 'a.tmtkgb', 'a.mkgolthnkgb','a.mkgolblnkgb',
    //            \DB::raw("IF(LENGTH(a.mkgolthnkgb)=1,CONCAT('0',a.mkgolthnkgb),IF(LENGTH(a.mkgolthnkgb)=0,'00',a.mkgolthnkgb)) AS mkgolthnkgb_"),
    //            \DB::raw("CONCAT(a.idgolrupkt, IF(LENGTH(a.mkgolthnkgb)>1, a.mkgolthnkgb, CONCAT(0,a.mkgolthnkgb))) AS kodegolmktkgbl"),
    //            'a.nosuratkgb',\DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS gkgbl"),
    //            'a.pejmenkgb', 'a.tgsuratkgb','a.noskkgb', 'a.tgskkgb','a.idjenjab','a.iddiperbantukan','j.nmasekolah',
    //            \DB::raw("IF(a.idjenjab>=20,a.idjabjbt,IF(a.idjenjab=2,a.idjabfung,IF(a.idjenjab=3,a.idjabfungum,''))) AS kdjabskr"),
    //            \DB::raw("IF(a.idjenjab=2,b.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',c.jab,IF(a.idjenjab=3,d.jabfungum,''))) AS namajab"),
    //            'a.idskpd','c.skpd', \DB::raw("a.idgolrupkt AS golruskr"), \DB::raw("e.idskpd AS idskpdskr"), \DB::raw("e.path_short AS skpdskr") //\DB::raw("if(left(e.idskpd, 2) = '01', e.path, e.path_short) AS skpdskr"
    //        )
    //        ->leftJoin('a_jabfung as b', 'a.idjabfung','=','b.idjabfung')
    //        ->leftJoin('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
    //        ->leftJoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
    //        ->leftJoin('a_skpd as e', 'e.idskpd', '=', 'a.idskpd') //\DB::raw("IF(e.issatker = 1, LEFT(a.idskpd,5), LEFT(a.idskpd,2))")
    //        ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=','f.idgolru')
    //        ->leftJoin('a_esl as g', 'a.idesljbt', '=', 'g.idesl')
    //        ->leftJoin('a_jenjurusan as h', 'a.idjenjurusan', '=', 'h.idjenjurusan')
    //        ->leftJoin('a_agama as i', 'a.idagama', '=', 'i.idagama')
    //        ->leftJoin('a_sekolahswasta as j', 'a.iddiperbantukan', '=', 'j.id')
    //        ->where('a.nip', $nip)
    //        ->orderBy('e.idskpd', 'desc')
    //        ->first();
    //
    //        return $rs;
    //    }

    /*function get attribut kgb*/
    public static function getattkgb($nip)
    {
        $rs = \DB::table("tb_01 as a")->select(
            'a.nip',
            'a.niplama',
            'a.nokarpeg',
            'a.idstspeg',
            'a.tmtmulaiawal_pppk',
            'a.tmtakhirawal_pppk',
            'a.tmtmulaiakhir_pppk',
            'a.tmtakhirakhir_pppk',
            \DB::raw("DATE_ADD(IF(a.tmtpkt>a.tmtkgb,a.tmtpkt,a.tmtkgb), INTERVAL 2 YEAR) AS tmtkgbnext"),
            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.tmlhr',
            'a.tglhr',
            'a.idgolrupkt',
            'a.tmtpkt',
            \DB::raw('IF(a.idstspeg=3,f.golru_p3k,f.golru) as golru'),
            \DB::raw("IFNULL(g.esl,'-') AS esl"),
            'a.idesljbt',
            'a.tmtjbt',
            \DB::raw("IF(a.idesljbt BETWEEN '11' AND '52',a.tmtesljbt,'0000-00-00') AS tmtesljbt"),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tmtcpn)), '%Y%m')+0 AS mkskr"),
            'h.jenjurusan',
            'a.thijaz',
            'i.agama',
            'a.mkthnpkt',
            'a.mkblnpkt',
            \DB::raw("IF(LENGTH(a.mkthnpkt)=1,CONCAT('0',a.mkthnpkt),IF(LENGTH(a.mkthnpkt)=0,'00',a.mkthnpkt)) AS mkthnpkt_"),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"),
            'a.mkthnpkt',
            \DB::raw("IF(LENGTH(a.mkgolthnkgb)=1,CONCAT('0',a.mkgolthnkgb),IF(LENGTH(a.mkgolthnkgb)=0,'00',a.mkgolthnkgb)) AS mkgolthnkgb_"),
            \DB::raw("CONCAT(a.idgolrupkt, IF(LENGTH(a.mkgolthnkgb)>1, a.mkgolthnkgb, CONCAT(0,a.mkgolthnkgb))) AS kodegolmktkgbl"),
            'a.nosuratkgb',
            'a.tgsuratkgb',
            'a.idjenjab',
            'a.iddiperbantukan',
            'j.nmasekolah',
            'a.tmtkgb as tmtkgbl',

            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS gkgbl"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.pejmenpkt, a.pejmenkgb) AS pejmenkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.noskpkt, a.noskkgb) AS noskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tgskpkt, a.tgskkgb) AS tgskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tmtpkt, a.tmtkgb) AS tmtkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS mkgolthnkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkblnpkt, a.mkgolblnkgb) AS mkgolblnkgb"),

            \DB::raw("IF(a.idjenjab>=20,a.idjabjbt,IF(a.idjenjab=2,a.idjabfung,IF(a.idjenjab=3,a.idjabfungum,''))) AS kdjabskr"),
            \DB::raw("IF(a.idjenjab=2,b.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',c.jab,IF(a.idjenjab=3,d.jabfungum,''))) AS namajab"),
            'a.idskpd',
            'c.skpd',
            \DB::raw("a.idgolrupkt AS golruskr"),
            \DB::raw("e.idskpd AS idskpdskr"),
            \DB::raw("e.path_short AS skpdskr") //\DB::raw("if(left(e.idskpd, 2) = '01', e.path, e.path_short) AS skpdskr"
        )
            ->leftJoin('a_jabfung as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->leftJoin('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
            ->leftJoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftJoin('a_skpd as e', 'e.idskpd', '=', 'a.idskpd') //\DB::raw("IF(e.issatker = 1, LEFT(a.idskpd,5), LEFT(a.idskpd,2))")
            ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=', 'f.idgolru')
            ->leftJoin('a_esl as g', 'a.idesljbt', '=', 'g.idesl')
            ->leftJoin('a_jenjurusan as h', 'a.idjenjurusan', '=', 'h.idjenjurusan')
            ->leftJoin('a_agama as i', 'a.idagama', '=', 'i.idagama')
            ->leftJoin('a_sekolahswasta as j', 'a.iddiperbantukan', '=', 'j.id')
            ->where('a.nip', $nip)
            ->orderBy('e.idskpd', 'desc')
            ->first();

        return $rs;
    }

    /*function mendapatkan gaji terkhir pada riwayat*/
    public static function getGajiterakhir($nip)
    {
        $rs = \DB::table('r_kgb')->where('nip', $nip)->orderBy('tmtkgb', 'desc')->first();
        return $rs->gaji;
    }

    //    /*get kepala skpd/ penandatangan sk kgb*/
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
    //                'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
    //                'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
    //            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
    //            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
    //            ->whereRaw($where)
    //            ->first();
    //
    //        if(count($rs) > 0){
    //            $rs->idpenetap = $idpenetap;
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
    public static function attrKepskpd($idgol, $idskpd, $idstspeg, $field)
    {
        $where = "a.idjenkedudupeg not in (99,21)";

        if ($idstspeg == 3) {
            if ($idgol >= 31) { //pak basir
                /*ttd oleh kepala bkd*/
                $where .= " and a.idjenjab = 20 and a.idskpd = '56'";
                $idpenetap = '158';
                $idskpdplt = '56'; //statis kepala bkd
                // GANTI BKPSDM
                // $where .= " and a.idjenjab = 20 and a.idskpd = '25'";
                // $idpenetap = '033';
                // $idskpdplt = '25'; //statis kepala bkd
            } else {
                /*oleh Kabid Pembinaan bkppd*/
                $where .= " and a.idjenjab = 30 and a.idskpd = '56.02'";
                $idpenetap = '159';
                $idskpdplt = '56.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
                // GANTI BKPSDM
                // $where .= " and a.idjenjab = 30 and a.idskpd = '25.02'";
                // $idpenetap = '075';
                // $idskpdplt = '25.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
            }
        } else {
            $idgol = substr($idgol, 0, 1);
            if (substr($idskpd, 0, 2) == '04') {
                /*dinas pendidikan*/
                if ($idgol == 4) {
                    /*oleh kepala bkd*/
                    $where .= " and a.idjenjab = 20 and a.idskpd = '56'";
                    $idpenetap = '158';
                    $idskpdplt = '56'; //statis kepala bkd
                    // GANTI BKPSDM
                    // $where .= " and a.idjenjab = 20 and a.idskpd = '25'";
                    // $idpenetap = '033';
                    // $idskpdplt = '25'; //statis kepala bkd
                } else {
                    /*oleh kepalla dinas pendidikan*/
                    $where .= " and a.idjenjab = 20 and a.idskpd = '04'";
                    $idpenetap = '054';
                    $idskpdplt = '04'; //statis kepala dinas pendidikan
                }
            } else {
                /*non dinas pendidikan*/
                if ($idgol == 1) {
                    if (substr($idskpd, 0, 2) == '01') {
                        /*oleh asisten administrasi umum sekretariat daerah*/
                        $where .= " and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
                        $idpenetap = '001';
                        $idskpdplt = '01.01'; //statis Asisten Administrasi Umum
                    } else {
                        /*oleh kepala skpd*/
                        $where .= " and a.idjenjab in (20,30,40) and a.idskpd = \"" . substr($idskpd, 0, 2) . "\""; //$idskpd
                        $idpenetap = '074';
                        $idskpdplt = substr($idskpd, 0, 2); //dinamis kepala skpd
                    }
                } else if ($idgol == 2) {
                    if (substr($idskpd, 0, 2) == '01') {
                        /*oleh asisten administrasi umum sekretariat daerah*/
                        $where .= " and a.idjenjab in (20,30,40) and a.idskpd = '01.01'";
                        $idpenetap = '001';
                        $idskpdplt = '01.01'; //statis Asisten Administrasi Umum
                    } else {
                        /*oleh kepala skpd*/
                        $where .= " and a.idjenjab in (20,30,40) and a.idskpd = \"" . substr($idskpd, 0, 2) . "\""; //$idskpd
                        $idpenetap = '074';
                        $idskpdplt = substr($idskpd, 0, 2); //dinamis kepala skpd
                    }
                } else if ($idgol == 3) {
                    /*oleh Kabid Pembinaan bkppd*/
                    $where .= " and a.idjenjab = 30 and a.idskpd = '56.02'";
                    $idpenetap = '159';
                    $idskpdplt = '56.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
                    // GANTI BKPSDM
                    // $where .= " and a.idjenjab = 30 and a.idskpd = '25.02'";
                    // $idpenetap = '075';
                    // $idskpdplt = '25.02'; //statis kepala Bidang Pembinaan, Kesejahteraan dan Data Pegawai
                } else if ($idgol == 4) {
                    /*ttd oleh kepala bkd*/
                    $where .= " and a.idjenjab = 20 and a.idskpd = '56'";
                    $idpenetap = '158';
                    $idskpdplt = '56'; //statis kepala bkd
                    // GANTI BKPSDM
                    // $where .= " and a.idjenjab = 20 and a.idskpd = '25'";
                    // $idpenetap = '033';
                    // $idskpdplt = '25'; //statis kepala bkd
                }
            }
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.nip',
                \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd',
                'a.idjenjab',
                'a.idjabjbt',
                'b.skpd',
                'b.jab',
                'b.jab_utuh',
                \DB::raw('IF(a.idstspeg=3,c.golru_p3k,c.golru) as golru'),
                'c.pangkat'
            )
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw($where)
            ->first();

        if (count($rs) > 0) {
            $rs->idpenetap = $idpenetap;
            if (($field == 'jab_utuh') && ($idpenetap == '075')) {
                //return $rs->$field." BKPP";
                return $rs->$field;
            } else if (($field == 'jab') && ($idpenetap == '001')) {
                return "a.n. " . $rs->$field;
            } else {
                return $rs->$field;
            }
        } else {
            $rs2 = \DB::table('a_skpd as b')
                ->select(
                    'a.nip',
                    \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                    'a.idskpd',
                    'a.idjenjab',
                    'a.idjabjbt',
                    'b.skpd',
                    'b.jab',
                    'b.jab_utuh',
                    'c.golru',
                    'c.pangkat'
                )
                ->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->whereRaw("b.idskpd = \"" . $idskpdplt . "\"")
                ->first();

            if (count($rs2) > 0) {
                $rs2->idpenetap = $idpenetap;
                if (($field == 'jab_utuh') && ($idpenetap == '075')) {
                    //return $rs2->$field." BKPP";
                    return "Plt. " . $rs2->$field;
                } else if (($field == 'jab') && ($idpenetap == '001')) {
                    return "a.n. " . $rs2->$field;
                } else {
                    if ($field == 'jab_utuh') {
                        return "Plt. " . $rs2->$field;
                    } else {
                        return $rs2->$field;
                    }
                }
            } else {
                return '-';
            }
        }
    }

    /*function untuk mendapatkan data kgb yang sudah verifikasi perorangan*/
    public static function getNominatifver($idkgb, $nip)
    {
        $rs = \DB::table("tr_kgb as a")
            ->select(
                'a.*',
                'tb_01.tmtmulaiawal_pppk',
                'tb_01.tmtakhirawal_pppk',
                'tb_01.tmtmulaiakhir_pppk',
                'tb_01.tmtakhirakhir_pppk',
                \DB::raw("b.pangkat as golpnsskr_txt, IF(tb_01.idstspeg=3,c.golru_p3k,c.golru) as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
            )
            ->leftJoin('tb_01', 'a.nip', '=', 'tb_01.nip')
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->where('a.idkgb', $idkgb)
            ->where('a.nip', $nip)
            ->first();

        return $rs;
    }

    /*function untuk mendapatkan data kgb all*/
    public static function getDatanominatif($idkgb = '', $jnskgb = '', $piluptd = '', $idstspeg = '')
    {
        if ($jnskgb != '0') {
            /*jika opd dinas pendidikan*/
            if ($piluptd == '04') {
                $where = "a.idkgb like \"" . $idkgb . "%\" and a.jnskgb = \"" . $jnskgb . "\" and e.id_unorindukflag = \"" . $piluptd . "\"";
            } else {
                $where = "a.idkgb like \"" . $idkgb . "%\" and a.jnskgb = \"" . $jnskgb . "\"";
            }
        } else {
            $where = "a.idkgb like \"" . $idkgb . "%\"";
        }

        $rs = \DB::table("tr_kgb as a")
            ->select(
                'a.*',
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
            ->join('a_skpd as e', 'a.kdskpd', '=', 'e.idskpd')
            ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function untuk mendapatkan data kgb yang sudah verifikasi nominatif*/
    public static function getDatanominatifver($idkgb, $jnskgb, $idstspeg = '')
    {
        if ($jnskgb != '0') {
            $where = "a.statussk = 1 and a.idkgb like \"" . $idkgb . "%\" and a.jnskgb = \"" . $jnskgb . "\"";
        } else {
            $where = "a.statussk = 1 and a.idkgb like \"" . $idkgb . "%\"";
        }

        $rs = \DB::table("tr_kgb as a")
            ->select(
                'a.*',
                'f.tmtmulaiawal_pppk',
                'f.tmtakhirawal_pppk',
                'f.tmtmulaiakhir_pppk',
                'f.tmtakhirakhir_pppk',
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

    /*function untuk mendapatkan default template*/
    public static function getTemplate($idskpd, $jnskgb)
    {
        $rs = \DB::table('tr_kgb_template')
            ->where('idskpd', $idskpd)
            ->where('jnskgb', $jnskgb)
            ->first();

        if (count($rs) > 0) {
            return $rs->template;
        } else {
            return "0";
        }
    }

    public static function getTemplateskp3k($idskpd, $jnskgb)
    {
        $rs = \DB::table('tr_kgb_template')
            ->where('idskpd', $idskpd)
            ->where('jnskgb', $jnskgb)
            ->first();

        if (count($rs) > 0) {
            return $rs->template;
        } else {
            return "0";
        }
    }

    public static function getTemplatesk($idskpd, $jnskgb, $idgol = '')
    {
        if ($jnskgb == 1) {
            $rs = \DB::table('tr_kgb_template')
                ->where('idskpd', substr($idskpd, 0, 2))
                ->where('jnskgb', $jnskgb)
                ->first();
        } else if ($jnskgb == 2) {
            $rs = \DB::table('tr_kgb_template')
                ->where('idskpd', 'all')
                ->where('jnskgb', $jnskgb)
                ->first();
        } else if ($jnskgb == 3) {
            $rs = \DB::table('tr_kgb_template')
                ->where('idskpd', substr($idskpd, 0, 2))
                ->where('jnskgb', $jnskgb)
                ->first();
        } else {
            $rs = \DB::table('tr_kgb_template')
                ->where('idskpd', substr($idskpd, 0, 2))
                ->first();
        }

        //        if((substr($idgol,0,1) >= 3) && (substr($idskpd,0,2) != '04')){ /*gol 3 - 4 non disdik*/
        //            $idskpd = 'all';
        //        }else{
        //            $idskpd = substr($idskpd,0,2);
        //        }
        //
        //        $rs = \DB::table('tr_kgb_template')
        //            ->where('idskpd', $idskpd)
        //            ->where('jnskgb', $jnskgb)
        //            ->first();

        if (count($rs) > 0) {
            return $rs->template;
        } else {
            return "0";
        }
    }

    /*function untuk mendapatkan nama skpd*/
    public static function getSkpd($idskpd)
    {
        $rs = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
        if (count($rs) > 0) {
            return $rs->skpd;
        } else {
            return '-';
        }
    }

    /*function untuk mendapatkan nomor sk*/
    public static function getNomorsk($jnskgb = '', $gol = '', $thnkgb = '')
    {
        if ($thnkgb == 2018) {
            $rs = \DB::table('tr_kgb')
                ->select(\DB::raw("LPAD(IFNULL(MAX(MID(noskkgbb,7,4))+1,1),4,0) AS nosk"))
                ->whereRaw('jnskgb = \'' . $jnskgb . '\' and left(tmtkgbb,4) = \'' . ($thnkgb + 1) . '\' and left(tglskkgbb,4) = \'' . $thnkgb . '\'')
                ->first();
        } else {
            if ($thnkgb >= 2024) {
                $rs = \DB::table('tr_kgb')
                    ->select(\DB::raw("LPAD(IFNULL(MAX(MID(noskkgbb,13,4))+1,1),4,0) AS nosk"))
                    ->whereRaw('jnskgb = \'' . $jnskgb . '\' and left(tglskkgbb,4) = \'' . $thnkgb . '\' AND LEFT(noskkgbb,12)="800.1.11.13/"')
                    ->first(); //tmtkgbb
            } else {
                $rs = \DB::table('tr_kgb')
                    ->select(\DB::raw("LPAD(IFNULL(MAX(MID(noskkgbb,7,4))+1,1),4,0) AS nosk"))
                    ->whereRaw('jnskgb = \'' . $jnskgb . '\' and left(tglskkgbb,4) = \'' . $thnkgb . '\'')
                    ->first(); //tmtkgbb
            }
        }

        if ($jnskgb == 3) {
            // $nosk = '822.'.$gol.'/'.$rs->nosk."/DIK/".$thnkgb;
            $nosk = '800.1.11.13/' . $rs->nosk . "/DIK/" . $thnkgb;
        } else {
            // $nosk = '822.'.$gol.'/'.$rs->nosk."/BKPP";
            $nosk = '800.1.11.13/' . $rs->nosk . "/BKPSDM";
            // $nosk = '800.1.11.13/'.$rs->nosk."/BKPP";
            // dinon aktifkan karena ganti BKPSDM

        }

        return $nosk;
    }

    /*combo status sk*/
    public static function comboStatussk($id = "statussk", $sel = "", $required = "", $holder = ".: Pilihan :.")
    {
        $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html .= "<option value=\"\">" . $holder . "</option>";
        $html .= "<option value=\"0\" " . (($sel == '0') ? "selected" : "") . ">Belum Diproses</option>";
        $html .= "<option value=\"2\" " . (($sel == '2') ? "selected" : "") . ">Dalam Proses</option>";
        $html .= "<option value=\"1\" " . (($sel == '1') ? "selected" : "") . ">Proses Selesai</option>";
        $html .= "</select>";
        return $html;
    }

    /*combo jenis kgb*/
    public static function comboJeniskgb($id = "jnskgb", $sel = "", $required = "", $holder = ".: Pilihan :.")
    {
        $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control validate[required]\">";
        $html .= "<option value=\"\">" . $holder . "</option>";
        $html .= "<option value=\"1\" " . (($sel == 1) ? "selected" : "") . ">OPD</option>";
        $html .= "<option value=\"2\" " . (($sel == 2) ? "selected" : "") . ">BKPP</option>";
        /*$html.="<option value=\"3\" ".(($sel==3)?"selected":"").">DISDIK</option>";
        $html.="<option value=\"4\" ".(($sel==4)?"selected":"").">SEKDA</option>";
        $html.="<option value=\"5\" ".(($sel==5)?"selected":"").">BUPATI</option>";*/
        $html .= "</select>";
        return $html;
    }

    public static function getJeniskgb($idgol = '', $idskpd = '', $idstspeg = '')
    {
        $idgol = substr($idgol, 0, 1);
        // dd($idstspeg); die();
        if ($idstspeg == 3) {
            $jnskgb = 2; //untuk p3k
        } else {
            if (substr($idskpd, 0, 2) == '04') {
                /*dinas pendidikan*/
                if ($idgol == 4) {
                    /*oleh kepala bkd*/
                    $jnskgb = 2;
                } else {
                    /*oleh kepalla dinas pendidikan*/
                    $jnskgb = 1;
                }
            } else {
                /*non dinas pendidikan*/
                if ($idgol >= 3) {
                    $jnskgb = 2;
                } else {
                    $jnskgb = 1;
                }
            }
        }

        return $jnskgb;
    }

    public static function attrPengantar($idskpd)
    {
        $rs = \DB::table("tb_01 as a")
            ->select(
                'a.nip',
                \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd',
                'a.idjenjab',
                'a.idjabjbt',
                'b.skpd',
                'b.jab_utuh as jab',
                \DB::raw('IF(a.idstspeg=3,c.golru_p3k,c.golru) as golru'),
                'c.pangkat'
            )
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw("a.idjenkedudupeg NOT IN('99','21') and b.idskpd = \"" . $idskpd . "\"")
            ->first();

        return $rs;
    }

    public static function cekKgbP3k($nip = "", $tahun = "")
    {
        $rs1 = \DB::table("r_kinerjaasn")
            ->where('nip', $nip)
            ->where('tahun', $tahun - 1)
            ->whereIn('predikatkinerja', ['Baik', 'Sangat baik'])
            ->orderBy('id', 'desc')
            ->latest()->first();

        $rs2 = \DB::table("r_kinerjaasn")
            ->where('nip', $nip)
            ->where('tahun', $tahun - 2)
            ->whereIn('predikatkinerja', ['Baik', 'Sangat baik'])
            ->orderBy('id', 'desc')
            ->latest()->first();

        if (count($rs1) != 0 and count($rs2) != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //fungsi untuk mengecek apakah pegawai dlm pengajuan kp atau tidak
    public static function cekKP($nip = "")
    {
        $rs1 = \DB::table("tr_kgb")
            ->where('tr_kgb.nip', $nip)
            ->orderBy('created_at', 'desc')
            ->first();

        $rs2 = \DB::table("tr_kenaikan_pangkat")
            ->where('tr_kenaikan_pangkat.nip', $nip)
            ->orderBy('created_at', 'desc')
            ->first();

        if (count($rs2) > 0) {
            if ($rs1->iscetaksk != 1 and $rs2->idgolrupktb > $rs1->golpnsskr) {
                echo "<div class='callout callout-danger' style='font-size: 15px'><i class='fa fa-info-circle'></i>Pegawai sedang mengajukan proses kenaikan pangkat</div>";
            } else {
                echo "";
            }
        }
    }
}
