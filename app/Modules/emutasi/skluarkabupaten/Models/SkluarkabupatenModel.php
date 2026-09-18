<?php namespace App\Modules\emutasi\skluarkabupaten\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Skluarkabupaten Model
* @var Skluarkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkluarkabupatenModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_luar_daerah";

	public static $rules = array(
		'tglusul' => 'required',
		'nousul' => 'required',
		'nip' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-skluarkabupaten-listall')){
			return $instance->newQuery()
                ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
                    \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                    \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
                )
                ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
                ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
                ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
                ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
                ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
                ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
                ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
                ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.nip'))
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
                    \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                    \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
                )
                ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
                ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
                ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
                ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
                ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
                ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
                ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
                ->where('tr_mutasi_luar_daerah.role_id', \Session::get('role_id'))
                ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.nip'))
			    ->paginate($_ENV['configurations']['list-limit']);
			
		}
	}

}
