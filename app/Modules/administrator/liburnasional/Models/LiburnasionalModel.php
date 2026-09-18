<?php namespace App\Modules\administrator\liburnasional\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Liburnasional Model
* @var Liburnasional
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class LiburnasionalModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_libur_nasional";

	public static $rules = array(
		'tgl' => 'required',
		'keterangan' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-liburnasional-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
