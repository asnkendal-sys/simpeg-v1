<?php namespace App\Modules\administrator\pengumuman\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Pengumuman Model
* @var Pengumuman
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PengumumanModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_pengumuman";

	public static $rules = array(
    		'judul' => 'required',
		'pengumuman' => 'required',
		'status' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-pengumuman-listall')){
			return $instance->newQuery()->orderBy('created_at', 'desc')->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
            ->orderBy('created_at', 'desc')
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
