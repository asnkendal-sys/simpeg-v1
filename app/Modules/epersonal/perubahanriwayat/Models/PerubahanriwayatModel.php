<?php namespace App\Modules\epersonal\perubahanriwayat\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Perubahanriwayat Model
* @var Perubahanriwayat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PerubahanriwayatModel extends Model {
	protected $guarded = array();
	
	protected $table = "r_jab";

	public static $rules = array(
    		'niplama' => 'required',
		'nip' => 'required',
		'idjab' => 'required',
		'jab' => 'required',
		'idskpd' => 'required',
		'skpd' => 'required',
		'tmtjab' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-perubahanriwayat-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
