<?php namespace App\Modules\epensiun\templateskpensiun\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templateskpensiun Model
* @var Templateskpensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskpensiunModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_dpcp_template";

	public static $rules = array(
		'template' => 'required',
		// 'user_id' => 'required',
		// 'role_id' => 'required',
		// 'created_at' => 'required',
		// 'updated_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-templateskpensiun-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

	/*function untuk mendapatkan template*/
    public static function getTemplate($idskpd, $jenis){
        $rs = \DB::table('tr_dpcp_template')->where('idskpd',$idskpd)->where('jenis',$jenis)->first();
        if(count($rs) > 0){
            return $rs->template;
        }else{
            return "0";
        }
    }

}
