<?php namespace App\Modules\kenaikanpangkat\penjagaankenaikanpangkat\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penjagaankenaikanpangkat Model
* @var Penjagaankenaikanpangkat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenjagaankenaikanpangkatModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kenaikan_pangkat";

	public static $rules = array(
    		'nousul' => 'required',
		'tglusul' => 'required',
		'nip' => 'required',
		'idjeniskp' => 'required',
		'user_id' => 'required',
		'role_id' => 'required',
		'created_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-penjagaankenaikanpangkat-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
