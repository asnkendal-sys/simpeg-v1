<?php namespace App\Modules\epersonal\nominatifpenjagaankgb\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Nominatifpenjagaankgb Model
* @var Nominatifpenjagaankgb
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaankgbModel extends Model {
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
		if (\PermissionsLibrary::hasPermission('mod-nominatifpenjagaankgb-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}
	
	public static function comboStsPegawai($id="idstspeg",$sel="",$required="",$name="idstspeg[]"){
		$ret = "<select id=\"$id\" name=\"$name\" $required style='width: 100%;' class=\"idstspeg form-control\" data-placeholder=\".: Pilihan :.\">";
		$ret.="<option value=\"1\" ".(($sel=='1')?'selected':'').">CPNS</option>";
		$ret.="<option value=\"2\" ".(($sel=='2')?'selected':'').">PNS</option>";
		$ret.="</select>";
		return $ret;
	}

}
