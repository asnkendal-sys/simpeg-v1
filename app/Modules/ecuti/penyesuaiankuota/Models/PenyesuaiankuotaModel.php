<?php namespace App\Modules\ecuti\penyesuaiankuota\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penyesuaiankuota Model
* @var Penyesuaiankuota
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenyesuaiankuotaModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_penyesuaian_cuti";

	public static $rules = array(
		'nip' => 'required',
		'hari_kerja' => 'required',
		'k_tahunan_n2' => 'required',
		'k_tahunan_n1' => 'required',
		'k_tahunan_n' => 'required',
		'k_besar_bulan' => 'required',
		'k_besar_hari' => 'required',
		'k_sakit_tahun' => 'required',
		'k_sakit_bulan' => 'required',
		'k_sakit_hari' => 'required',
		'k_lahir_bulan' => 'required',
		'k_lahir_hari' => 'required',
		'k_penting_bulan' => 'required',
		'k_penting_hari' => 'required',
		'k_cltn_tahun' => 'required',
		'k_cltn_bulan' => 'required',
		'k_cltn_hari' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
		if(session('role_id') > 3){
			$where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
		}else{
			$where.= " and tb_01.nip != ''";
		}
		if (\PermissionsLibrary::hasPermission('mod-penyesuaiankuota-listall')){
			return $instance->newQuery()

			->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
