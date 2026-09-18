<?php namespace App\Modules\emutasi\nominatifmasukkabupaten\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Nominatifmasukkabupaten Model
* @var Nominatifmasukkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifmasukkabupatenModel extends Model {
	protected $guarded = array();

	protected $table = "tr_mutasi_masuk_daerah";
	protected $primaryKey = 'idusul'; // or null

	public static $rules = array(
    	'nousul' => 'required',
		'tglusul' => 'required',
		'nip' => 'required',
		'gdp' => 'required',
		'nama' => 'required',
		'gdb' => 'required',
		'tmlhr' => 'required',
		'tglhr' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		$where = " tr_mutasi_masuk_daerah.nip != ''";
		if (\PermissionsLibrary::hasPermission('mod-nominatifmasukkabupaten-listall')){
			return $instance->newQuery()
			->select('tr_mutasi_masuk_daerah.*','a_golruang.golru','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
				\DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
			)
			->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
			->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
			->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
			->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
			->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
			->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
			->whereRaw($where)
			->orderBy('tr_mutasi_masuk_daerah.nousul','desc')
			->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

	public static function comboPemerintah($id="idpemerintah",$sel="",$required="",$readonly="",$n=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class='form-control idpemerintah$n' $readonly>";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('tr_mutasi_jenis_pemerintah')->orderBy('id','asc')->get();
        foreach($rs as $item){
            $isSel = (($item->id==$sel)?"selected":"");
            $ret.="<option value=\"".$item->id."\" $isSel >".$item->pemerintah."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

}
