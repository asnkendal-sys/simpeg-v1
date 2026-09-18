<?php namespace App\Modules\epensiun\cetakdpcp\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Cetakdpcp Model
* @var Cetakdpcp
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class CetakdpcpModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_pensiun";
	protected $primaryKey = 'nip'; // or null

	public static $rules = array(
		'nip' => 'required',
		'tmtpens' => 'required',
		// 'tmtcpn' => 'required',
		// 'idjenkedudupeg' => 'required',
		// 'idjenpens' => 'required',
		// 'noskpens' => 'required',
		// 'tgskpens' => 'required',
		// 'idpejabpens' => 'required',
		// 'statussk' => 'required',
		// 'jabpenpens' => 'required',
		// 'pejpenpens' => 'required',
		// 'nippenpens' => 'required',
		// 'golrupenpens' => 'required',
		// 'mkthnpktpens' => 'required',
		// 'mkblnpktpens' => 'required',
		// 'mkthnpens' => 'required',
		// 'mkblnpens' => 'required',
		// 'mkthnpnspens' => 'required',
		// 'mkblnpnspens' => 'required',
		// 'tglmasukpns' => 'required',
		// 'almpens' => 'required',
		// 'almrtpens' => 'required',
		// 'almrwpens' => 'required',
		// 'almdesapens' => 'required',
		// 'almkecpens' => 'required',
		// 'almkabpens' => 'required',
		// 'almprovpens' => 'required',
		// 'iscetaksk' => 'required',
		// 'statususul' => 'required',
		// 'kettms' => 'required',
		// 'ketbtl' => 'required',
		// 'user_id' => 'required',
		// 'role_id' => 'required',
		// 'created_at' => 'required',
		// 'updated_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
        $where = " tr_pensiun.idjenkedudupeg != 1 and tr_pensiun.nip != ''";
        if(session('role_id') > 3){
            $where .= " and b.idskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-cetakdpcp-index')){
            return $instance->newQuery()        
                    ->select(\DB::raw("tr_pensiun.*,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,b.*,tr_pensiun.tmtpens,f.esl,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a_agama.agama,a_jenpens.jenpens,g.path_short,
                        b.idgolrupns, b.tmtpns, e.golru, e.pangkat,
                        c.golru as golrucpn,c.pangkat as pangkatcpn,
                        d.golru as golrupns,d.pangkat as pangkatpns"),
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
                    ->leftJoin('tb_01 as b', 'tr_pensiun.nip', '=', 'b.nip')
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
                    ->orderBy(\DB::raw('tr_pensiun.tmtpens desc,tr_pensiun.nip'))
                    ->paginate($_ENV['configurations']['list-limit']);               
		}else{
			return $instance->newQuery()
            ->whereRaw($where)
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    public static function comboStatussk($id="statussk",$sel="",$required="",$holder=".: Pilihan :."){
        $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html.="<option value=\"\">".$holder."</option>";
        $html.="<option value=\"0\" ".(($sel=='0')?"selected":"").">Belum Diproses</option>";
        $html.="<option value=\"2\" ".(($sel=='2')?"selected":"").">Dalam Proses</option>";
        $html.="<option value=\"1\" ".(($sel=='1')?"selected":"").">Proses Selesai</option>";
        $html.="</select>";
        return $html;
    }

}
