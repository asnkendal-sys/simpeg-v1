<?php namespace App\Modules\ecuti\penyesuaiankuotacuti\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penyesuaiankuotacuti Model
* @var Penyesuaiankuotacuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenyesuaiankuotacutiModel extends Model {
	protected $guarded = array();
	
	protected $table = "tb_01";

	public static $rules = array(
		// 'nip' => 'required',
		// 'hari_kerja' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		// $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
		$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.idskpd like '25%'";
		/*TEMP*/
		// $where.= " AND LEFT(tb_01.idskpd,2) = '25' ";
		// $where.= " AND tb_01.nip = '198305152011011014' ";
		/*TEMP*/
		if(session('role_id') > 3){
			$where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
		}else{
			// $where.= " and tb_01.nip != ''";
			$where.= "";
		}

		if (\PermissionsLibrary::hasPermission('mod-penyesuaiankuotacuti-listall')){
			return $instance->newQuery()
			->select('tr_penyesuaian_cuti.*','tr_penyesuaian_cuti.id','tb_01.nip',
				\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'))

			// ->leftJoin(\DB::raw('(SELECT * FROM tr_penyesuaian_cuti A WHERE A.id = (SELECT MAX(id) FROM tr_penyesuaian_cuti B WHERE A.nip=B.nip)) AS tr_penyesuaian_cuti'), function($join) {
			->leftJoin('tr_penyesuaian_cuti', function($join) {
				$join->on('tb_01.nip', '=', 'tr_penyesuaian_cuti.nip');
				$join->on('tb_01.nip', '!=', \DB::raw("''"));
			})
			->whereRaw($where)
			->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.idjenjab,tb_01.idesljbt,tb_01.idtkpendid desc,tb_01.tglhr'))
			->orderByRaw('tr_penyesuaian_cuti.id desc')
			->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
