<?php namespace App\Modules\tte\kontrakpppk\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Kontrakpppk Model
* @var Kontrakpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class KontrakpppkModel extends Model {
	protected $guarded = array();
	
	protected $table = "r_tte";

	public static $rules = array(
    		'jenis' => 'required',
		'file_awal' => 'required',
		'file_tte' => 'required',
		'id_sk' => 'required',
		'nik_pejabat' => 'required',
		'nip_pengusul' => 'required',
		'nip_pejabat' => 'required',
		'proses' => 'required',
		'id_tte' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		$jenis = 'PPPK';
		$where = "a.sts_kontrak = 2 and r_tte.jenis = \"".$jenis."\"";
        if(session('role_id') > 3){
            $where .= " and tr_pppk.kdskpd like \"".session('idskpd')."%\" ";
        }		
		if (\PermissionsLibrary::hasPermission('mod-kontrakpppk-listall')){
			return $instance->newQuery()
			->select('a.*','r_tte.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppk as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idpppk')
                        ->on('r_tte.nip_pengusul','=','a.nip')
                        ->where('r_tte.jenis','=',$jenis);
                    })                    
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')
                    ->paginate($_ENV['configurations']['list-limit']);				
		}else{
			return $instance->newQuery()
			->select('a.*','r_tte.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppk as a', function($join)use($jenis){
						$join->on('r_tte.id_sk', '=', 'a.idpppk')
						->on('r_tte.nip_pengusul','=','a.nip')
						->where('r_tte.jenis','=',$jenis);
                    })                    
					->where('role_id', \Session::get('role_id'))
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')                    
					->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
