<?php namespace App\Modules\administrator\jabatannonjabatan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jabatannonjabatan Model
* @var Jabatannonjabatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatannonjabatanModel extends Model {
	protected $guarded = array();

	protected $table = "a_jabnonjob";
    protected $primaryKey = 'idjabnonjob'; // or null

	public static $rules = array(
    		'jabnonjob' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jabatannonjabatan-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
