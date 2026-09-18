<?php namespace App\Modules\emutasi\nominatifantarskpd\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Nominatifantarskpd Model
* @var Nominatifantarskpd
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifantarskpdModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_dalam_daerah";

	public static $rules = array(
/*		'nousul' => 'required',
		'tglusul' => 'required',
		'nip' => 'required',*/

	);

	public static function all($columns = array('*')){
		$instance = new static;
		$where = "tr_mutasi_dalam_daerah.idusul != ''";
		if(session('role_id') > 3){
			$where .= " and tr_mutasi_dalam_daerah.idskpd like \"".session('idskpd')."%\" ";
		}
		if(\Session::get('role_id') <=3){
			if (\PermissionsLibrary::hasPermission('mod-nominatifantarskpd-listall')){
				return $instance->newQuery()
				->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
					,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
					\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
					
					\DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

					\DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

				->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
				->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
				->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
				->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
				->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
				->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
				->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
				->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
				->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
				->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
				->whereRaw($where)
				->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
				->paginate($_ENV['configurations']['list-limit']);
			}
		}else{
			return $instance->newQuery()
			->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
				,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
				\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
				
				\DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

				\DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

			->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
			->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
			->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
			->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
			->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
			->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
			->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
			->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
			->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
			->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
			->whereRaw('tr_mutasi_dalam_daerah.no_suratrek != ""')
			->whereRaw($where)
			->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}
	/*function combo jenis jabatan*/
	public static function comboJnsjabatan($id="idjenjab",$sel="",$required="", $class="", $idx="1"){
		$ret = '<select data-id="'.$idx.$id.'" id="idjenjabbaru" idx="'.$idx.'"  name="'.$idx.$id.'"  $required style="width: 100%;" class="form-control '.$class.' idjenjabbaru">';
		$ret.= '<option value="">.: Pilihan :.</option>';

		/*$rs = \DB::table('a_jenjab')->orderBy('idjenjab','asc')->get();*/
		$rs = \DB::table('a_jenjab')
		->where('idjenjab','<=',3)
		->orderBy('idjenjab','asc')
		->get();
		foreach($rs as $item){
			$isSel = (($item->idjenjab==$sel)?"selected":"");
			$ret.= '<option value="'.$item->idjenjab.'" '.$isSel.' >'.$item->jenjab.'</option>';
		}
		$ret.='</select>';
		return $ret;
	}

	/*function combo Diperbantukan*/
	public static function comboDiperbantukan($id="iddiperbantukan",$sel="",$required="", $class="", $idx=""){
		$ret = '<select data-id="'.$idx.$id.'" id="iddiperbantukan" idx="'.$idx.'"  name="'.$idx.$id.'"  $required style="width: 100%;" class="form-control jos '.$class.' iddiperbantukan">';
		$ret.= '<option value="">.: Pilihan :.</option>';

		$rs = \DB::table('a_sekolahswasta')
		->orderBy('id','asc')
		->get();
		foreach($rs as $item){
			$isSel = (($item->id==$sel)?"selected":"");
			$ret.= '<option value="'.$item->id.'" '.$isSel.' >'.$item->nmasekolah.'</option>';
		}
		$ret.='</select>';
		return $ret;
	}

	/*function untuk mendapatkan atribut nominatif*/
	public static function getAttrnominatif($nousul){
		$where = "a.nousul = \"".$nousul."\"";
		$rs=\DB::table('tr_mutasi_dalam_daerah as a')
		->select('a.*','c.skpd',
			\DB::raw("DATE_FORMAT(a.tgl_sp,'%d-%m-%Y') AS tgl_sp_"),
			\DB::raw('CONCAT(b.gdp,IF(LENGTH(b.gdp)>0," ",""),b.nama,IF(LENGTH(b.gdb)>0,", "," "),b.gdb) as namalengkap'))

		->leftjoin('tb_01 as b', 'a.nip', '=', 'b.nip')
		->leftjoin('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
		->whereRaw($where)
		->orderby('a.idgolrupkt');
		return $rs;
	}

	

	/*function untuk mendapatkan data data mutasi*/
	public static  function getDatanominatif($nousul){
		$where = "nousul = \"".$nousul."\"";
		$rs=\DB::table('tr_mutasi_dalam_daerah')
		->whereRaw($where);
		return $rs;
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

	/*funciton untuk get sekdes*/
	public static function isSekdes($nip,$idjabfungun){
        if($idjabfungun == 'xxxxxxx'){ //xxxxxxx diisi kode jabfung sekdes
        	$row = \DB::table('tb_01')->where(array('nip'=>$nip, 'idjabfungum'=>$idjabfungun))->first();
        	if(count($row) > 0){
        		return $row->nmadesa;
        	}
        }
    }

    public static function attrPengantar($idskpd){
    	$where = "b.idjenkedudupeg NOT IN('99','21') and b.idjenjab>=20 and b.idjabjbt = \"".substr($idskpd, 0,2)."\"";
		// $where = "b.idjenkedudupeg NOT IN('99','21') and b.idjenjab<=20 and b.idjabjbt = \"".substr($idskpd, 0,2)."\"";
		// $where = "b.idjenjab<=20 and b.idjabjbt = \"".substr($idskpd, 0,2)."\"";
    	$rs=\DB::table('a_skpd')
    	->select('a_skpd.*','b.nip','c.golru','c.pangkat',
    		\DB::raw('CONCAT(b.gdp,IF(LENGTH(b.gdp)>0," ",""),b.nama,IF(LENGTH(b.gdb)>0,", "," "),b.gdb) as namalengkap'))
    	->leftjoin('tb_01 as b', 'b.idjabjbt', '=', 'a_skpd.idskpd')
    	->leftjoin('a_golruang as c', 'b.idgolrupkt', '=', 'c.idgolru')
    	->whereRaw($where)
    	->first()
    	;

    	if(count($rs) > 0){
    		return $rs;
    	}else{
    		$rs = \DB::table('a_skpd as b')
    		->select(
    			'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
    			'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
    		->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
    		->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
    		->whereRaw("b.idskpd = \"".$idskpd."\"")
    		->first();

    		return $rs;
    	}
    }

}
