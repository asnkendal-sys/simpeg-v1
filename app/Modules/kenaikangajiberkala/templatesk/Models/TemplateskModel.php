<?php namespace App\Modules\kenaikangajiberkala\templatesk\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templatesk Model
* @var Templatesk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kgb_template";

	public static $rules = array(
    		'template' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-templatesk-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function untuk mendapatkan template*/
    public static function getTemplate($idskpd, $jnskgb){
        $rs = \DB::table('tr_kgb_template')->where('idskpd',$idskpd)->where('jnskgb',$jnskgb)->first();
        if(count($rs) > 0){
            return $rs->template;
        }else{
            return "0";
        }
    }
}
