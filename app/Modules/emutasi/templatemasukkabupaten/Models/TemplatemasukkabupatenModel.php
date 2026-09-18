<?php namespace App\Modules\emutasi\templatemasukkabupaten\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templatemasukkabupaten Model
* @var Templatemasukkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplatemasukkabupatenModel extends Model {
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
		if (\PermissionsLibrary::hasPermission('mod-templatemasukkabupaten-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

	public static function getTemplate($idskpd='', $jenis='', $field=''){
        $rs = \DB::table('tr_mutasi_template_sk')->where('idskpd',$idskpd)->where('jnssurat',$jenis)->first();
        if(count($rs) > 0){
            return $rs->$field;
        }else{
            //return "<br /><p style='text-align:center;margin:0;margin-top:.1cm;line-height:1em;font-size:15pt;'<center>Template Surat untuk OPD anda belum ada di database template. <br />Harap menyesuaikan format dan unit kerja pada menu template. Terimakasih</center></p>";
            return "Data Tidak Ditemukan";
        }
    }
}
