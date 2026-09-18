<?php namespace App\Modules\administrator\tingkatpendidikan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Tingkatpendidikan Model
* @var Tingkatpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TingkatpendidikanModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_tkpendid";
    protected $primaryKey = 'idtkpendid'; // or null

	public static $rules = array(
        'tkpendid' => 'required',
		'maxgol' => 'required',
		'singkatan' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-tingkatpendidikan-listall')){
			return $instance->newQuery()
                ->leftjoin('a_golruang','a_tkpendid.maxgol','=','a_golruang.idgolru')
                ->select('a_tkpendid.*', 'a_golruang.golru', 'a_golruang.pangkat')
                ->orderBy('a_tkpendid.idtkpendid', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->lefetjoin('a_golruang','a_tkpendid.maxgol','=','a_golruang.idgolru')
            ->select('a_tkpendid.*', 'a_golruang.golru', 'a_golruang.pangkat')
            ->where('a_tkpendid.role_id', \Session::get('role_id'))
            ->orderBy('a_tkpendid.idtkpendid', 'asc')
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
