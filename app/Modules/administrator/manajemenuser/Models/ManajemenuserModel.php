<?php namespace App\Modules\administrator\manajemenuser\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Manajemenuser Model
* @var Manajemenuser
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class ManajemenuserModel extends Model {
	protected $guarded = array();
	
	protected $table = "users";

	public static $rules = array(
        'name' => 'required',
		'username' => 'required',
		'email' => 'required',
		/*'password' => 'required',*/
		'role_id' => 'required',
		'idskpd' => 'required',

    );

    public static $rules_setting = array(
        'username' => 'required',
        'aktif_mulai' => 'required',
        'aktif_selesai' => 'required',
        'keterangan' => 'required'
    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-manajemenuser-listall')){
			return $instance->newQuery()
                ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
                ->leftjoin('a_skpd', 'users.idskpd', '=', 'a_skpd.idskpd')
                ->select('users.*', \DB::raw('roles.name as rolename'), 'a_skpd.skpd', \DB::raw('if(NOW() BETWEEN users.aktif_mulai AND users.aktif_selesai, 1, 0) as aktif'))
                ->where('users.role_id', '!=', 1)
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftjoin('a_skpd', 'users.idskpd', '=', 'a_skpd.idskpd')
            ->select('users.*', \DB::raw('roles.name as rolename'), 'a_skpd.skpd', \DB::raw('if(NOW() BETWEEN users.aktif_mulai AND users.aktif_selesai, 1, 0) as aktif'))
			->where('role_id', \Session::get('role_id'))
            ->where('users.role_id', '!=', 1)
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*cobo list user*/
    public static function comboPengguna($id="username",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"all\">.: Semua Pengguna :.</option>";

        $rs = \DB::table('users')->orderBy('name','asc')->where('role_id', '!=', 1)->get();
        foreach($rs as $item){
            $isSel = (($item->username==$sel)?"selected":"");
            $ret.="<option value=\"".$item->username."\" $isSel >".$item->username." - ".$item->name."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    /*function untuk mendapatkan list context module*/
    public static function getContextmodule(){
        $ret = \DB::table('contexts')->whereNotin('id', [2,3,5,6])->orderBy('order')->get();
        return $ret;
    }
}
