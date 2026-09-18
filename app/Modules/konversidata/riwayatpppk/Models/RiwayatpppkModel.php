<?php namespace App\Modules\konversidata\riwayatpppk\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Riwayatpppk Model
* @var Riwayatpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RiwayatpppkModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_konversidata";

	public static $rules = array(
            'konversi' => 'required',
      );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-riwayatpppk-listall')){
			return $instance->newQuery()->where('konversi', 8)->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
