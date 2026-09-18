<?php namespace App\Modules\emutasi\nominatifluarkabupaten\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Nominatifluarkabupaten Model
* @var Nominatifluarkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifluarkabupatenModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_luar_daerah";
    protected $primaryKey = 'idusul'; // or null

	public static $rules = array(
        /*'nousul' => 'required',*/
		'tmtx' => 'required',
		/*'nip' => 'required',*/

    );

    public static $rules_edit = array(
        // 'provinsi' => 'required',
        // 'kabupaten' => 'required',
        // 'instansi' => 'required',
        'tglskpermintaan' => 'required',
        'keterangan' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
        $where = "tr_mutasi_luar_daerah.idusul != ''";
        if(session('role_id') > 3){
                $where .= " and tr_mutasi_luar_daerah.idskpd like \"".session('idskpd')."%\" ";
            }
		if (\PermissionsLibrary::hasPermission('mod-nominatifluarkabupaten-listall')){
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
                ->whereRaw($where)
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
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.nip'))
                ->paginate($_ENV['configurations']['list-limit']);
			
		}
	}

    /*function untuk mendapatkan penetap sk*/
    public static function getPenetap($idpenetap, $attr){
        $rs = \DB::table('a_penetapsk')->where('id', $idpenetap)->first();

        if(count($rs) > 0){
            return $rs->$attr;
        }else{
            return "";
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
