<?php namespace App\Modules\tte\kenaikangaji\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Kenaikangaji Model
* @var Kenaikangaji
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class KenaikangajiModel extends Model {
	protected $guarded = array();
	
	protected $table = "r_tte";

	public static $rules = array(
    		'jenis' => 'required',
		'file' => 'required',
		'id_sk' => 'required',
		'nip_pengusul' => 'required',
		'nip_pejabat' => 'required',
		'proses' => 'required',

    );

	// public static function all($columns = array('*')){
	// 	$instance = new static;
	// 	if (\PermissionsLibrary::hasPermission('mod-kenaikangaji-listall')){
	// 		return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
	// 	}else{
	// 		return $instance->newQuery()
	// 		->where('role_id', \Session::get('role_id'))
	// 		->paginate($_ENV['configurations']['list-limit']);	
			
	// 	}
	// }

    public static function all($columns = array('*')){
		$instance = new static;
        $jenis = 'KGB';
        $where = "a.jnskgb = 2 and r_tte.jenis = \"".$jenis."\"";
        if(session('role_id') > 3){
            $where .= " and a.kdskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-kenaikangaji-listall')){
			return $instance->newQuery()
                    ->select('a.*','r_tte.*',
                        \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                        \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                        \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                        \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                        \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                        \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
                    )
                    ->join('tr_kgb as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idkgb')
                            ->on('r_tte.nip_pengusul','=','a.nip')
                            ->where('r_tte.jenis','=',$jenis);
                    })
                    ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
                    ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
                    ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('a.idkgb desc,a.idjabskr,a.golpnsskr,a.nama'))
                    ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                    ->select('a.*','r_tte.*',
                        \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                        \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                        \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                        \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                        \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                        \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                        \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
                    )
                    ->join('tr_kgb as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idkgb')
                            ->on('r_tte.nip_pengusul','=','a.nip')
                            ->where('r_tte.jenis','=',$jenis);
                    })
                    ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
                    ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
                    ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('a.idkgb desc,a.idjabskr,a.golpnsskr,a.nama'))
                    ->paginate($_ENV['configurations']['list-limit']);

		}
	}

	public static function getNominatifver($idkgb, $nip){
        $rs = \DB::table("tr_kgbaa as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
            )
            ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
            ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
            ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
            ->where('a.idkgb', $idkgb)
            ->where('a.nip', $nip)
            ->first();

        return $rs;
    }

}
