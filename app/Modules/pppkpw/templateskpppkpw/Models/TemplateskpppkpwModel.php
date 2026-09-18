<?php namespace App\Modules\pppkpw\templateskpppkpw\Models;
use Illuminate\Database\Eloquent\Model;

class TemplateskpppkpwModel extends Model {
	protected $guarded = array();
	
	protected $table = "tb_01";

	public static $rules = array(
        'niplama' => 'required',
		'nama' => 'required',
		'created_at' => 'required',
		'updated_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		// if (\PermissionsLibrary::hasPermission('mod-templateskpppkpw-listall')){
		// 	return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		// }else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		// }
	}

    /*function untuk mendapatkan template*/
    public static function getTemplate($idskpd, $jnssurat){
        $rs = \DB::table('tr_pppkpw_template')->where('idskpd',$idskpd)->where('jnssurat',$jnssurat)->first();
        if(count($rs) > 0){
            return $rs->template;
        }else{
            return "0";
        }
    }

    /*function untuk mendapatkan judul*/
    public static function getTitle($idskpd, $jnssurat){
        $rs = \DB::table('tr_pppkpw_template')->where('idskpd',$idskpd)->where('jnssurat',$jnssurat)->first();
        if(count($rs) > 0){
            return $rs->nama;
        }else{
            return "";
        }
    }
}
