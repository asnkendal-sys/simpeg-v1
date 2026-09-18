<?php namespace App\Modules\epersonal\rekaphukdis\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Rekaphukdis Model
* @var Rekaphukdis
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RekaphukdisModel extends Model {
	protected $guarded = array();
	
	protected $table = "tb_01";

	public static $rules = array(
    		'nama' => 'required',
		'gdp' => 'required',
		'gdb' => 'required',
		'tmlhr' => 'required',
		'tglhr' => 'required',
		'idjenkel' => 'required',
		'idagama' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-rekaphukdis-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

	public static function getDatahukdis($data) {
		$where = "b.idskpd like '".$data['idskpd']."%' AND (MONTH(a.tgmul) BETWEEN '".$data['bulan1']."' AND '".$data['bulan2']."')";
		$rs = \DB::table('r_hukdis as a')
			->select('a.nip', 'e.jabatan as namapejab', 'a.nosk', 'a.tgsk', 'c.jenhukum', 'd.kathukdis', 'a.tgmul', 'a.tgsel', 'a.ket', 'b.tmlhr', 'b.tglhr', \DB::raw('CONCAT(b.gdp,IF(LENGTH(b.gdp)>0," ",""),b.nama,IF(LENGTH(b.gdb)>0,", ",""),b.gdb) AS namalengkap'))
			->join('tb_01 as b', 'a.nip', '=', 'b.nip')
			->join('a_jenhukum as c', 'a.idjenhukum', '=', 'c.idjenhukum')
			->join('a_kathukdis as d', 'a.idtkhukum', '=', 'd.idkathukdis')
			->leftJoin('a_penetapsk as e', 'a.pejab', '=', 'e.id');
			// ->where('b.idskpd', 'like', $data['idskpd'].'%');
			if($data['idjenjab'] != "" OR $data['tahun'] != "" OR $data['idtkhukdis']) {
				($data['idjenjab']!='')?$where .= " AND b.idjenjab = '".$data['idjenjab']."'":"";
				($data['tahun']!='')?$where.=" AND YEAR(a.tgmul) = '".$data['tahun']."'":"";
				($data['idtkhukdis']!='')?$where.=" AND a.idtkhukum = '".$data['idtkhukdis']."'":"";
			}
		$rs = $rs->whereRaw($where)
			->orderbyRaw('a.idtkhukum ASC, a.tgsk DESC')
			->get();

		return $rs;
	}

}
