<?php namespace App\Modules\ecuti\skcuti\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Skcuti Model
* @var Skcuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkcutiModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_ijin_cuti";

	public static $rules = array(
		'nousul' => 'required',
		'tgl_usul' => 'required',
		'nip' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		$where = "tr_ijin_cuti.nousul != '' ";
		if(session('role_id') > 3){
			$where .= " and tr_ijin_cuti.idskpd like \"".session('idskpd')."%\" ";
		}
		if(session('role_id') == 5){
			$where .= " and tr_ijin_cuti.nip like \"".session('user_id')."%\" ";
		}
		if (\PermissionsLibrary::hasPermission('mod-nominatifcuti-listall')){
			return $instance->newQuery()
			->select('tr_ijin_cuti.*',
				'a_golruang.golru','a_golruang.pangkat',
				'tb_01.idgolrupkt','tb_01.nip','tb_01.idjenjab','tb_01.idskpd','tb_01.idjenjab',
				\DB::raw('tb_01.hp as telepon'),
				\DB::raw('IF(tb_01.idjenjab>4,b.jab,IF(tb_01.idjenjab=2,c.jabfung,IF(tb_01.idjenjab=3,d.jabfungum,IF(tb_01.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
				\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap')
			)
			->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
			->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
			->leftjoin('a_skpd as b', 'tr_ijin_cuti.idskpd', '=', 'b.idskpd')
			->leftjoin('a_jabfung as c', 'tb_01.idjabfung', '=', 'c.idjabfung')
			->leftjoin('a_jabfungum as d', 'tb_01.idjabfungum', '=', 'd.idjabfungum')
			->leftjoin('a_jabnonjob as e', 'tb_01.idjabnonjob', '=', 'e.idjabnonjob')
			->whereRaw($where)
			->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
			->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->select('tr_ijin_cuti.*',
				'a_golruang.golru','a_golruang.pangkat',
				'tb_01.idgolrupkt','tb_01.nip','tb_01.idjenjab','tb_01.idskpd','tb_01.idjenjab',
				\DB::raw('tb_01.hp as telepon'),
				\DB::raw('IF(tb_01.idjenjab>4,b.jab,IF(tb_01.idjenjab=2,c.jabfung,IF(tb_01.idjenjab=3,d.jabfungum,IF(tb_01.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
				\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap')
			)
			->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
			->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
			->leftjoin('a_skpd as b', 'tr_ijin_cuti.idskpd', '=', 'b.idskpd')
			->leftjoin('a_jabfung as c', 'tb_01.idjabfung', '=', 'c.idjabfung')
			->leftjoin('a_jabfungum as d', 'tb_01.idjabfungum', '=', 'd.idjabfungum')
			->leftjoin('a_jabnonjob as e', 'tb_01.idjabnonjob', '=', 'e.idjabnonjob')
			->whereRaw($where)
			->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
