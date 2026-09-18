<?php namespace App\Modules\epersonal\dukpegawai\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Dukpegawai Model
* @var Dukpegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class DukpegawaiModel extends Model {
	protected $guarded = array();
	
	protected $table = "tb_01";

	public static $rules = array(
    		'niplama' => 'required',
		'nama' => 'required',
		'gdp' => 'required',
		'gdb' => 'required',
		'tmlhr' => 'required',
		'tglhr' => 'required',
		'idjenkel' => 'required',
		'idagama' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-dukpegawai-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
