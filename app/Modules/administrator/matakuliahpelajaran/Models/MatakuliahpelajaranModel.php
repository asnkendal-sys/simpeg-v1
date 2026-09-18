<?php namespace App\Modules\administrator\matakuliahpelajaran\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Matakuliahpelajaran Model
* @var Matakuliahpelajaran
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MatakuliahpelajaranModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_matkulpel";
    protected $primaryKey = 'idmatkulpel'; // or null

	public static $rules = array(
    		'idtugasgurudosen' => 'required',
		'idmatkulpel' => 'required',
		'matkulpel' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-matakuliahpelajaran-listall')){
			return $instance->newQuery()
                ->leftjoin('a_tugasgurudosen', 'a_matkulpel.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->select('a_matkulpel.*','a_tugasgurudosen.tugasgurudosen')
                ->orderBy('a_tugasgurudosen.idtugasgurudosen', 'asc')
                ->orderBy('a_matkulpel.matkulpel', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                ->leftjoin('a_tugasgurudosen', 'a_matkulpel.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                ->select('a_matkulpel.*','a_tugasgurudosen.tugasgurudosen')
                ->where('role_id', \Session::get('role_id'))
                ->orderBy('a_tugasgurudosen.idtugasgurudosen', 'asc')
                ->orderBy('a_matkulpel.matkulpel', 'asc')
			    ->paginate($_ENV['configurations']['list-limit']);
			
		}
	}

}
