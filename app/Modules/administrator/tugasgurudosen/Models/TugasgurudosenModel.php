<?php namespace App\Modules\administrator\tugasgurudosen\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Tugasgurudosen Model
* @var Tugasgurudosen
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TugasgurudosenModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_tugasgurudosen";
    protected $primaryKey = 'idtugasgurudosen'; // or null

	public static $rules = array(
    		'tugasgurudosen' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-tugasgurudosen-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
