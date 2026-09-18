<?php namespace App\Modules\ecuti\verifikasicuti\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Verifikasicuti Model
* @var Verifikasicuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class VerifikasicutiModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_ijin_cuti";

	public static $rules = array(
		'nousul' => 'required',
		'tgl_usul' => 'required',
		'nip' => 'required',
		'nama' => 'required',
		'idskpd' => 'required',
		'skpd' => 'required',
		'id_jenis_cuti' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		$where2 = "tr_ijin_cuti.opd_status = '1' ";
		// $where2 = "tr_ijin_cuti.opd_status = '1' ";
		
		if (\Session::get('role_id') == 3 || \Session::get('role_id') == 4) {
			$where2 .= "AND tr_ijin_cuti.idskpd like '".\Session::get('idskpd')."%'";
		}
		if (\Session::get('role_id') == 5) {
			$where2 .= "AND (tr_ijin_cuti.atasan_nip = '".\Session::get('user_id')."' OR tr_ijin_cuti.nip = '".\Session::get('user_id')."')";
		}
		$where = "tr_ijin_cuti.nousul != ''";

		if (\PermissionsLibrary::hasPermission('mod-verifikasicuti-listall')){
			return $instance->newQuery()
			->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
			->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
			->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
			->whereRaw($where2)
			->whereRaw($where)
			->orderBy(\DB::raw('tr_ijin_cuti.nousul desc,tr_ijin_cuti.id'))
			// ->paginate($_ENV['configurations']['list-limit']);
			->get();
			
		}else{
			return $instance->newQuery()
			->select('tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat','tb_01.idgolrupkt')
			->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
			->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
			->whereRaw($where2)
			->whereRaw($where)
			->orderBy(\DB::raw('tr_ijin_cuti.nousul desc,tr_ijin_cuti.id'))
			->get();
			// ->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
