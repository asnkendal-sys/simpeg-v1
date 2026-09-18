<?php namespace App\Modules\administrator\penetapsuratkeputusan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penetapsuratkeputusan Model
* @var Penetapsuratkeputusan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenetapsuratkeputusanModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_penetapsk";

	public static $rules = array(
    		'jabatan' => 'required',
		'namalengkap' => 'required',
		'nip' => 'required',
		'pangkat' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-penetapsuratkeputusan-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
