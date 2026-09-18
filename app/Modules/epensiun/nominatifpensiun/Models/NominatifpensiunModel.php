<?php namespace App\Modules\epensiun\nominatifpensiun\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Nominatifpensiun Model
* @var Nominatifpensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpensiunModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_pensiun";
    protected $primaryKey = 'nip'; // or null

	public static $rules = array(
        // 'nip' => 'required',
		/*'idjenpens' => 'required',*/
		// 'tmtpens' => 'required',
		/*'noskpens' => 'required',
		'tglskpens' => 'required',
		'jbtpenetapens' => 'required',*/

    );

	public static function all($columns = array('*')){
		$instance = new static;
        $where = " tr_pensiun.idjenkedudupeg != 1 and tr_pensiun.nip != ''";
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where .= " and tr_pensiun.nip = \"".session('user_id')."\" ";
            }else{       
                $where .= " and b.idskpd like \"".session('idskpd')."%\" ";
            }        
        }

		if (\PermissionsLibrary::hasPermission('mod-nominatifpensiun-index')){
            return $instance->newQuery()        
                    ->select(\DB::raw("tr_pensiun.*,tr_pensiun.idjenpens as jenispensiun,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,b.*,f.esl,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a_agama.agama,a_jenpens.jenpens,g.path_short,
                        b.idgolrupns, b.tmtpns, e.golru, e.pangkat,
                        c.golru as golrucpn,c.pangkat as pangkatcpn,
                        d.golru as golrupns,d.pangkat as pangkatpns, tr_pensiun.tmtpens"),
                        \DB::raw("CONCAT(b.gdp,IF(LENGTH(b.gdp)>0,' ',''),b.nama,IF(LENGTH(b.gdb)>0,', ',''),b.gdb) AS namalengkap"),
                        \DB::raw("DATE_FORMAT(tr_pensiun.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                        \DB::raw('IF(b.idjenjab>4,g.jab,IF(b.idjenjab=2,h.jabfung,IF(b.idjenjab=3,i.jabfungum,IF(b.idjenjab=4,j.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(b.idjenjab>4,g.bup,IF(b.idjenjab=2,h.pens,IF(b.idjenjab=3,i.pens,IF(b.idjenjab=4,j.pens,"-")))) as usiapens'),
                        \DB::raw("
                                CONCAT(
                                    IF((LEFT(b.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(b.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - b.mkthncpn,
                                            IF((LEFT(b.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - b.mkthncpn,
                                                IF((LEFT(b.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - b.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0)-2))
                                            + b.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),
                                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(b.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->join('tb_01 as b', 'tr_pensiun.nip', '=', 'b.nip')
                    ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                    ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                    ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                    ->leftjoin('a_esl as f', 'b.idesljbt', '=', 'f.idesl')
                    ->join('a_skpd as g', 'b.idskpd', '=', 'g.idskpd')
                    ->leftjoin('a_jabfung as h', 'b.idjabfung', '=', 'h.idjabfung')
                    ->leftjoin('a_jabfungum as i', 'b.idjabfungum', '=', 'i.idjabfungum')
                    ->leftjoin('a_jabnonjob as j', 'b.idjabnonjob', '=', 'j.idjabnonjob')
                    ->leftjoin('a_tkpendid', 'b.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'b.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_agama', 'b.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenpens', 'tr_pensiun.idjenpens', '=', 'a_jenpens.idjenpens')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tr_pensiun.tmtpens desc,b.idskpd, a_jenpens.idjenpens')) //nambah idjenpens
                    ->groupBy(\DB::raw('tr_pensiun.tmtpens desc,b.idskpd, a_jenpens.idjenpens')) //nambah ini
                    ->paginate($_ENV['configurations']['list-limit']);               
		}else{
			return $instance->newQuery()
            ->whereRaw($where)
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    public static function data_pensiun($columns = array('*')){
        $instance = new static;
        $where = " tb_01.idjenkedudupeg in('99','21') and tb_01.nip != '' and tb_01.tglhr != '0000-00-00'";
        if(session('role_id') > 3){
            $where.= " and tb_01.idskpd like \"".session('idskpd')."\" ";
        }else{
            $where.= " and tb_01.nip != ''";
        }

        if (\PermissionsLibrary::hasPermission('mod-nominatifpensiun-listall')){
            return $instance->newQuery()
                ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_agama.agama',
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
                \DB::raw("
                            CONCAT(
                                IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        -
                                        (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                        IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                    ),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        + tb_01.mkthncpn
                                    )
                                ),
                                RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                        "),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
            )
                ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->whereRaw($where)
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    public static function getattrpensiun($nip) {
        $rs = \DB::table('tb_01')->select('tb_01.*',\DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"))
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->where('tb_01.nip', $nip)
        ->orderBy('a_skpd.idskpd', 'desc')
        ->first();

        return $rs;
    }

    /*function untuk mendapatkan data kgb yang sudah verifikasi perorangan*/
    public static function getNominatifver($nip){
        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*','a_agama.agama as agama','a_jenkel.jenkel as jenis_kelamin',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_, a.tmtpens"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_agama','f.idagama','=','a_agama.idagama')
            ->leftjoin('a_jenkel','f.idjenkel','=','a_jenkel.idjenkel')
            // ->where('a.idkgb', $idkgb)
            ->where('a.nip', $nip)
            ->first();

        return $rs;
    }

    // /*function untuk mendapatkan data kgb yang sudah verifikasi perorangan*/
    // public static function getNominatifvertmt($tmtpens){
    //     $rs = \DB::table("tr_pensiun as a")
    //         ->select('a.*',
    //             \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan"),
    //             \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
    //             \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
    //             \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
    //             \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
    //             \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
    //             \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
    //             \DB::raw("
    //                             CONCAT(
    //                                 IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
    //                                     (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
    //                                         (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
    //                                         -
    //                                         (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
    //                                         IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
    //                                             IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
    //                                     ),
    //                                     (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
    //                                         (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
    //                                         + f.mkthncpn
    //                                     )
    //                                 ),
    //                                 RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
    //                             "),
    //             \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
    //             \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
    //         )
    //         ->leftJoin('tb_01 as f', 'a.nip', '=', 'f.nip')
    //         ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
    //         ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')
    //         ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')
    //         ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
    //         ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    //         ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
    //         ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    //         ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    //         // ->where('a.idkgb', $idkgb)
    //         ->where('a.tmtpens', $tmtpens)
    //         ->first();

    //     return $rs;
    // }

    /*function untuk mendapatkan data pensiun all*/
    public static function getDatanominatif($nip='', $piluptd=''){
        $where = "a.nip like \"".$nip."%\"";    

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.nama,f.idskpd"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),                                
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab")                
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')          
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')          
            ->whereRaw($where)
            ->get();
            

        return $rs;
    }

    /*function untuk mendapatkan data pensiun nip*/
    public static function getDatanominatifnip($tmtpens='', $idskpd='', $nip=''){
        $where = "a.tmtpens = \"".$tmtpens."\"";
        $where .=" and a.nip = \"".$nip."\"";
        if($idskpd != ''){
            $where .= " and a.idskpdpens like \"".$idskpd."%\" ";
        }

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("a_jenpens.jenpens, b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.nama,f.idskpd,e.path_short"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),                                
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab")                
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')          
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')        
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function untuk mendapatkan data pensiun all*/
    public static function getDatanominatiftmt($tmtpens='', $idskpd='', $nip=''){
        $where = "a.tmtpens = \"".$tmtpens."\"";
        // $where .=" and a.nip = \"".$nip."\"";
        if($idskpd != ''){
            $where .= " and a.idskpdpens like \"".$idskpd."%\" ";
        }

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("a_jenpens.jenpens, b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.nama,f.idskpd,e.path_short"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),                                
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab")                
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')          
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')        
            ->whereRaw($where)
            ->get();

        return $rs;
    }


    public static function getDatapengantar($tmtpens='', $idskpd=''){
        $where = "a.tmtpens = \"".$tmtpens."\"";
        if($idskpd != ''){
            $where .= " and a.idskpdpens like \"".$idskpd."%\" ";
        }

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("a_jenpens.jenpens, b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.nama,f.idskpd,e.path_short"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),                                
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab")                
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')          
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')        
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function untuk mendapatkan data pensiun yang sudah terverifikasi nominatif*/
    public static function getDatanominatifver($nip='', $piluptd=''){
        $where = "a.statussk = 1 and a.nip like \"".$nip."%\"";

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_, a.tmtpens"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),                
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')            
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')    
            ->whereRaw($where)
            ->get();
            

        return $rs;
    }

    /*function untuk mendapatkan data pensiun yang sudah terverifikasi nominatif*/
    public static function getDatanominatiftmtver($tmtpens='', $piluptd=''){
        $where = "a.statussk = 1 and a.tmtpens = \"".$tmtpens."\"";

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a.noskpens"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_, a.tmtpens"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->whereRaw($where)
            ->get();
            

        return $rs;
    }

    public static function getTemplatesk($idskpd,$jenis='',$idgol=''){
        $role = \Session::get('role_id');
        if($jenis == 1){
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', 'all')
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 2){
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', 'all')
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 3){
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', 'all')
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 4){
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', 'all')
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 5){
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', substr($idskpd,0,2))
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 6){ //thukdis opd
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', substr($idskpd,0,2))
                ->where('jenis', $jenis)
                ->first();
        }else if($jenis == 7){ //tpidana opd
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', substr($idskpd,0,2))
                ->where('jenis', $jenis)
                ->first();
        }else{
            $rs = \DB::table('tr_dpcp_template')
                ->where('idskpd', substr($idskpd,0,2))
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
//            ->where('jenis', $jnskgb)
//            ->first();

        if(count($rs) > 0){
            return $rs->template;
        }else{
            return "0";
        }
    }
  
    public static function getRanak($nip,$tunjangan=''){
        $n  = 0;
        $rs = \BiodataModel::getRanak($nip);
        if($tunjangan != '') {
            $rs->where('tunjangan','1')->whereRaw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(r_anak.tglhr)), '%Y%m')+0  < 2500 AND r_anak.stskawin = 1");
        }
      //   dd($rs);
        $ret = '
            <table width="90%" class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Nama</th>
                        <th width="35%">Tempat/Tanggal Lahir</th>
                        <th width="25%">Status</th>
                    </tr>
                </thead>
        ';
        if(count($rs->get()) > 0){
            foreach($rs->get() as $item){
                $n++;
                $ret.="<tr>
                            <td align='center'>".$n.".</td>
                            <td>".$item->nmanak."</td>
                            <td>".$item->tmlhr.", ".date('d-m-Y', strtotime($item->tglhr))."</td>
                            <td align='center'>".$item->stskeluarga."</td>
                        </tr>";
            }
        }else{
            $ret.= "<tr><td colspan='10'>&nbsp;</td></tr>";
        }

        $ret.="</table>";

        return $ret;
    }

    public static function getRissu($nip){
        $n  = 0;
        $rs = \BiodataModel::getRissu($nip);

        $ret = '
            <table width="90%" class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama</th>
                        <th width="25%">Tempat/Tanggal&nbsp;Lahir</th>
                        <th width="15%">Tanggal&nbsp;Nikah</th>
                        <th width="15%">Suami/Istri&nbsp;Ke</th>
                    </tr>
                </thead>
            ';

        if(count($rs->get()) > 0){
            foreach($rs->get() as $item){
                $n++;
                $ret.="<tr>
                        <td align='center'>".$n.".</td>
                        <td>".$item->nmissu."</td>
                        <td align='center'>".$item->tmlhr.", ".date('d-m-Y', strtotime($item->tglhr))."</td>
                        <td align='center'>".date('d-m-Y', strtotime($item->tgnikah))."</td>
                        <td align='center'>".$n."</td>
                    </tr>";
            }
        }else{
            $ret.="<tr><td colspan='7'>&nbsp;</td></tr>";
        }

        $ret.="</table>";

        return $ret;
    }

    public static function attrPengantar($idskpd){
        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.nip', 'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'c.golru', 'c.pangkat',
                \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama")
            )
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->where('b.idskpd', $idskpd)
            ->whereNotIn('a.idjenkedudupeg',[99,21])
            ->first();

        if(count($rs) == 0){
            $rs = \DB::table('a_skpd as b')
                ->select(
                'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'c.golru', 'c.pangkat',
                \DB::raw('concat("Plt. ", b.jab) as jab'), \DB::raw('concat("Plt. ", b.jab_utuh) as jab_utuh'))
                ->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->whereRaw("b.idskpd = \"".$idskpd."\"")
                ->first();
        }

        return $rs;
    }

    /*function combo jenis pensiun*/
    public static function comboJenpens($id="idjenpens",$sel="",$required="", $class="", $idx="1"){
        $ret = '<select data-id="'.$idx.$id.'" id="idjenpens" idx="'.$idx.'"  name="'.$idx.$id.'"  $required style="width: 100%;" class="form-control '.$class.' idjenpens">';
        $ret.= '<option value="">.: Pilihan :.</option>';

        $rs = \DB::table('a_jenpens')
            ->where('idjenpens','!=',1)
            ->where('idjenpens','!=',4)
            ->orderBy('idjenpens','asc')
            ->get();
        foreach($rs as $item){
            $isSel = (($item->idjenpens==$sel)?"selected":"");
            $ret.= '<option value="'.$item->idjenpens.'" '.$isSel.' >'.$item->jenpens.'</option>';
        }
        $ret.='</select>';
        return $ret;
    }

    //semua jenis pensiun
    public static function comboJenispens($id="idjenpens",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('a_jenpens')->orderBy('idjenpens','asc')->get();
        foreach($rs as $item){
            $isSel = (($item->idjenpens==$sel)?"selected":"");
            $ret.="<option value=\"".$item->idjenpens."\" $isSel >".$item->jenpens."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    public static function btnCreatebup($caption = '',$n="",$nip=""){
		if (\PermissionsLibrary::canAdd()){
            //return "<a id='".$id."' href=\"/".\Request::path().'/create'."\" class=\"btn btn-primary ".\Config::get('claravel::ajax')."\"><span class=\"glyphicon glyphicon-plus-sign\"></span>$caption</a>";
            if(session('role_id') == 5){
                if($caption == 'BUP') {
                    return "<a id='buatbup' href='".url().'/'.\Request::path().'/createpegawaibup?n='.$n.'&nip='.$nip."' class='btn".\Config::get('claravel::ajax')."'><i class='fa fa-bookmark'></i> $caption</a>";
                }else {
                    return "<a id='buataps' href='".url().'/'.\Request::path().'/createpegawainonbup?n='.$n.'&nip='.$nip."' class='btn".\Config::get('claravel::ajax')."'><i class='fa fa-bookmark-o'></i> $caption</a>";
                }
            }else{
                if($caption == 'BUP') {
                    return "<a id='buatbup' href='".url().'/'.\Request::path().'/create'."' class='btn".\Config::get('claravel::ajax')."'><i class='fa fa-bookmark'></i> $caption</a>";
                }else {
                    return "<a id='buataps' href='".url().'/'.\Request::path().'/createaps'."' class='btn".\Config::get('claravel::ajax')."'><i class='fa fa-bookmark-o'></i> $caption</a>";
                }
            }
			
		}
    }
}
