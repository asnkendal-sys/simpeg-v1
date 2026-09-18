<?php namespace App\Modules\kenaikanpangkat\penjadwalankp\Models;
use Illuminate\Database\Eloquent\Model;


/**
* @var Penjadwalankp
*
* Developed by Dinustek.
*/

class PenjadwalankpModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kenaikan_pangkat_jadwal";
    protected $primaryKey = 'id';

	public static $rules = array(
        'tahun' => 'required',
        'bulan' => 'required',
        'mulai' => 'required',
        'selesai' => 'required',
    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-penjadwalankp-listall')){
			return $instance->newQuery()->orderBy('order')->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
            ->orderBy('order')
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

   
}
