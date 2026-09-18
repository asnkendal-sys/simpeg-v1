<?php namespace App\Modules\administrator\unitkerja\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Unitkerja Model
* @var Unitkerja
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UnitkerjaModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_skpd";
    protected $primaryKey = 'idskpd'; // or null

	public static $rules = array(
    		'idparent' => 'required',
		'skpd' => 'required',
		'path' => 'required',
		'jab' => 'required',
		//'idesl' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-unitkerja-listall')){
			return $instance->newQuery()
                ->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
                ->select('a_skpd.*', 'a_esl.esl')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
            ->select('a_skpd.*', 'a_esl.esl')
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

    public static function getLastidskpd(){
        $rs = \DB::table('a_skpd')
            ->select(\DB::raw('IF(idskpd=99,(idskpd + 2), (idskpd + 1)) AS idskpd'))
            ->where('idskpd','<',99)
            ->groupBy(\DB::raw('LEFT(idskpd, 2)'))
            ->orderBy('idskpd','desc')
            ->take(1)
            ->first();
        ;

        return $rs->idskpd;
    }

}
