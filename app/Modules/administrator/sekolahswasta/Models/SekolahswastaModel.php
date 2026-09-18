<?php namespace App\Modules\administrator\sekolahswasta\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Sekolahswasta Model
* @var Sekolahswasta
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SekolahswastaModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_sekolahswasta";

	public static $rules = array(
    		'nmasekolah' => 'required',
    		'status' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-sekolahswasta-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*combo list ya atau tidak */
    public static function comboStatus($id="status",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\" ".(($sel == '')?"selected":"").">.: Pilihan :.</option>";
        $ret.="<option value=\"1\" ".(($sel == 1)?"selected":"").">Sekolah</option>";
        $ret.="<option value=\"2\" ".(($sel == 2)?"selected":"").">Non Sekolah</option>";
        $ret.="</select>";
        return $ret;
    }


}
