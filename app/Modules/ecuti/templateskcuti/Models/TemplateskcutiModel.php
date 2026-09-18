<?php namespace App\Modules\ecuti\templateskcuti\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templateskcuti Model
* @var Templateskcuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskcutiModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_ijin_cuti_template_sk";

	public static $rules = array(
		'idskpd' => 'required',
		'nama' => 'required',
		'template' => 'required',

	);

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-templateskcuti-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

	/*function untuk mendapatkan default template*/
	public static function getTemplatecuti($idskpd, $jnssurat, $fields){
		$row = \DB::table('tr_ijin_cuti_template_sk')->where(array('idskpd'=>$idskpd, 'jnssurat'=>$jnssurat))->first();
		if(count($row) > 0){
			return $row->$fields;
		}else{
			return "0";
		}
	}

    /*function random character*/
    public static function rand_char(){
        $rs = \DB::select("
                SELECT CONCAT(
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1)
                ) AS rand_key;
            ");

        return $rs[0]->rand_key;
    }

}
