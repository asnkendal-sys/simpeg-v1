<?php namespace App\Modules\emutasi\templateskpengantar\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templateskpengantar Model
* @var Templateskpengantar
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskpengantarModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_template_sk";

	public static $rules = array(
    		'jnssurat' => 'required',
		'idskpd' => 'required',
		'nama' => 'required',
		'template' => 'required',
		'author' => 'required',
		'tgin' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-templateskpengantar-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function untuk mendapatkan default template*/
    public static function getTemplate($idskpd, $jnssurat, $fields){
        $row = \DB::table('tr_mutasi_template_sk')->where(array('idskpd'=>$idskpd, 'jnssurat'=>$jnssurat))->first();
        if(count($row) > 0){
            return $row->$fields;
        }else{
            //sreturn "<br /><p style='text-align:center;margin:0;margin-top:.1cm;line-height:1em;font-size:15pt;'<center>Template Surat untuk OPD anda belum ada di database template. <br />Harap menyesuaikan format dan unit kerja pada menu template. Terimakasih</center></p>";
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
