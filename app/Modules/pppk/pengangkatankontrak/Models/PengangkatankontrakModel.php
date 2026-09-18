<?php namespace App\Modules\pppk\pengangkatankontrak\Models;
use Illuminate\Database\Eloquent\Model;

class PengangkatankontrakModel extends Model {
	protected $guarded = array();
	
	protected $table = "tb_01";

	public static $rules = array(
    		'niplama' => 'required',
		'nama' => 'required',
		'created_at' => 'required',
		'updated_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-pengangkatankontrak-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
