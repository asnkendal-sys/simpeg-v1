<?php namespace App\Modules\kenaikangajiberkala\skkenaikangajiberkala\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Skkenaikangajiberkala Model
* @var Skkenaikangajiberkala
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkkenaikangajiberkalaModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kgb";

	public static $rules = array(
    		'jnskgb' => 'required',
		'karpeg' => 'required',
		'nama' => 'required',
		'tmplahir' => 'required',
		'tgllahir' => 'required',
		'golpns' => 'required',
		'golpnsname' => 'required',
		'tmtgollama' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;

        $where = "tr_kgb.jnskgb != 0";
        if(session('role_id') > 3){
            $where .= " and tr_kgb.kdskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-skkenaikangajiberkala-listall')){
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

}
