<?php namespace App\Modules\konversidata\riwayatdikstru\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Riwayatdikstru Model
* @var Riwayatdikstru
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatdikstruModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_konversidata";

	public static $rules = array(
    		'konversi' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-riwayatdikstru-listall')){
			return $instance->newQuery()->where('konversi', 6)->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                ->where('konversi', 6)
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
