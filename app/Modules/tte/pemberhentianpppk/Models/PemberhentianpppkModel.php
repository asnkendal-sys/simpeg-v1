<?php namespace App\Modules\tte\pemberhentianpppk\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Pemberhentianpppk Model
* @var Pemberhentianpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PemberhentianpppkModel extends Model {
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
		$jenis = 'PPPK-PEMBERHENTIAN';
		$where = "a.sts_kontrak = 3 and r_tte.jenis = \"".$jenis."\"";
        if(session('role_id') > 3){
            $where .= " and tr_pppk.kdskpd like \"".session('idskpd')."%\" ";
        }		
		if (\PermissionsLibrary::hasPermission('mod-kontrakpppk-listall')){
			return $instance->newQuery()
			->select('a.*','r_tte.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppk as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idpppk')
                        ->on('r_tte.nip_pengusul','=','a.nip')
                        ->where('r_tte.jenis','=',$jenis);
                    })
					->join('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')                    
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')
                    ->paginate($_ENV['configurations']['list-limit']);				
		}else{
			return $instance->newQuery()
			->select('a.*','r_tte.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppk as a', function($join)use($jenis){
						$join->on('r_tte.id_sk', '=', 'a.idpppk')
						->on('r_tte.nip_pengusul','=','a.nip')
						->where('r_tte.jenis','=',$jenis);
                    })
					->join('a_jenpens', 'a.idjenpens', '=', 'a_jenpens.idjenpens')
					->where('role_id', \Session::get('role_id'))
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')                    
					->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
