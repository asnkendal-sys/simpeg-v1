<?php namespace App\Modules\administrator\jabatanfungsionalumum\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jabatanfungsionalumum Model
* @var Jabatanfungsionalumum
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanfungsionalumumModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_jabfungum";
    protected $primaryKey = 'idjabfungum'; // or null

	public static $rules = array(
    		'idjabfungum' => 'required',
		'jabfungum' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jabatanfungsionalumum-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
