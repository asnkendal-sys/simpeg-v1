<?php namespace App\Modules\administrator\utility\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Utility Model
* @var Utility
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UtilityModel extends Model {
	protected $guarded = array();
	
	protected $table = "utility";

	public static $rules = array(
    		'nma_aplikasi' => 'required',
		'nma_instansi' => 'required',
		'kab_instansi' => 'required',
		'link_instansi' => 'required',
		'email_instansi' => 'required',
		'logo_instansi' => 'required',
		'thn_develop' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-utility-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
