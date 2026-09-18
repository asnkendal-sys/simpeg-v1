<?php namespace App\Modules\emutasi\skpengangkatan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Skpengangkatan Model
* @var Skpengangkatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkpengangkatanModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_pengangkatan";

	public static $rules = array(
    		'nousul' => 'required',
			'tglusul' => 'required',
			'nip' => 'required',
			'idtkpendid' => 'required',
    );

	public static function all($columns = array('*')){
		$instance = new static;
		$where = "tr_mutasi_pengangkatan.nip != '' ";
		if(session('role_id') > 3){
                $where .= " and tr_mutasi_pengangkatan.idskpd like \"".session('idskpd')."%\" ";
            }
		if (\PermissionsLibrary::hasPermission('mod-skpengangkatan-listall')){
			return $instance->newQuery()
				->select('tr_mutasi_pengangkatan.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
					,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
					\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

					\DB::raw('IF(tr_mutasi_pengangkatan.idjenjab>4,skpdlama.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

					\DB::raw('IF(tr_mutasi_pengangkatan.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_pengangkatan.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_pengangkatan.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

				->leftJoin('a_skpd as skpdlama', 'tr_mutasi_pengangkatan.idskpd', '=', 'skpdlama.idskpd')
				->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_pengangkatan.idskpdbaru', '=', 'skpdbaru.idskpd')
				->leftjoin('a_tkpendid', 'tr_mutasi_pengangkatan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
				->leftjoin('a_jenjurusan', 'tr_mutasi_pengangkatan.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
				->leftjoin('a_golruang', 'tr_mutasi_pengangkatan.idgolrupkt', '=', 'a_golruang.idgolru')
				->leftjoin('tb_01', 'tr_mutasi_pengangkatan.nip', '=', 'tb_01.nip')
				->leftjoin('a_jabfung', 'tr_mutasi_pengangkatan.idjabfung', '=', 'a_jabfung.idjabfung')
				->leftjoin('a_jabfungum', 'tr_mutasi_pengangkatan.idjabfungum', '=', 'a_jabfungum.idjabfungum')
				->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_pengangkatan.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
				->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_pengangkatan.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
				->whereRaw($where)
				->orderby('tr_mutasi_pengangkatan.idskpd','asc')
				->paginate($_ENV['configurations']['list-limit']);
			
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

	public static function listopd($columns = array('*')){
		$instance = new static;
		$where = "tr_mutasi_pengangkatan.nip != '' ";
		if(session('role_id') > 3){
                $where .= " and tr_mutasi_pengangkatan.idskpd like \"".session('idskpd')."%\" ";
            }
		if (\PermissionsLibrary::hasPermission('mod-skpengangkatan-listall')){
			return $instance->newQuery()
				->select('tr_mutasi_pengangkatan.idskpd')
				->whereRaw($where)
				->distinct()
				->orderby('tr_mutasi_pengangkatan.nousul','desc');
			
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

}
