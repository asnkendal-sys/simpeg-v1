<?php namespace App\Modules\administrator\jabatanfungsional\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jabatanfungsional Model
* @var Jabatanfungsional
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanfungsionalModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_jabfung";
    protected $primaryKey = 'idjabfung'; // or null

    public $incrementing = false;

	public static $rules = array(
        'jabfung' => 'required',
        'tingkat' => 'required',
		'jabfung2' => 'required'

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jabatanfungsional-listall')){
			return $instance->newQuery()
                ->select('a_jabfung.*', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'))
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->select('a_jabfung.*', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'))
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
