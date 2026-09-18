<?php namespace App\Modules\pppk\pemberhentiankontrak\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\PPPK\UsulanPPPK;

class PemberhentiankontrakModel extends UsulanPPPK {
	protected $guarded = array();
	
	protected $table = "tr_pppk";

	public static $rules = array(
        'bulan' => 'required',
		'tahun' => 'required'
    );

    public static $rule_updates = array(
        'bup' => 'required',
        'thkerja' => 'required',
        'blkerja' => 'required',
        'gaji' => 'required',
        'idgolru' => 'required'
    );

    public static $rule_verifikasi = array(
        'statususul' => 'required',
        // 'statussk' => 'required'
    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-pemberhentiankontrak-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function get attribut kgb*/
    public static function getattpppk($nip){
        $rs = \DB::table("tb_01 as a")->select(
            'a.nip', 'a.niplama', 'a.nokarpeg', 'a.tmtmulaiakhir_pppk', 'a.tmtakhirakhir_pppk', 'a.nojanjiakhir_pppk', 'a.tgljanjiakhir_pppk', 'k.tkpendid',
            \DB::raw("DATE_ADD(IF(a.tmtpkt>a.tmtkgb,a.tmtpkt,a.tmtkgb), INTERVAL 2 YEAR) AS tmtkgbnext"),
            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.tmlhr', 'a.tglhr', 'a.idgolrupkt', 'a.tmtpkt', 'f.golru',\DB::raw("IFNULL(g.esl,'-') AS esl"),'a.idesljbt','a.tmtjbt',
            \DB::raw("IF(a.idesljbt BETWEEN '11' AND '52',a.tmtesljbt,'') AS tmtesljbt"),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tmtcpn)), '%Y%m')+0 AS mkskr"),
            'h.jenjurusan','a.thijaz','i.agama','a.mkthnpkt','a.mkblnpkt',
            \DB::raw("IF(LENGTH(a.mkthnpkt)=1,CONCAT('0',a.mkthnpkt),IF(LENGTH(a.mkthnpkt)=0,'00',a.mkthnpkt)) AS mkthnpkt_"),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"),'a.mkthnpkt',
            \DB::raw("IF(LENGTH(a.mkgolthnkgb)=1,CONCAT('0',a.mkgolthnkgb),IF(LENGTH(a.mkgolthnkgb)=0,'00',a.mkgolthnkgb)) AS mkgolthnkgb_"),
            \DB::raw("CONCAT(a.idgolrupkt, IF(LENGTH(a.mkgolthnkgb)>1, a.mkgolthnkgb, CONCAT(0,a.mkgolthnkgb))) AS kodegolmktkgbl"),
            'a.nosuratkgb','a.tgsuratkgb', 'a.idjenjab','a.iddiperbantukan','j.nmasekolah','a.tmtkgb as tmtkgbl',

            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS gkgbl"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.pejmenpkt, a.pejmenkgb) AS pejmenkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.noskpkt, a.noskkgb) AS noskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tgskpkt, a.tgskkgb) AS tgskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tmtpkt, a.tmtkgb) AS tmtkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS mkgolthnkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkblnpkt, a.mkgolblnkgb) AS mkgolblnkgb"),

            \DB::raw("IF(a.idjenjab>=20,a.idjabjbt,IF(a.idjenjab=2,a.idjabfung,IF(a.idjenjab=3,a.idjabfungum,''))) AS kdjabskr"),
            \DB::raw("IF(a.idjenjab=2,b.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',c.jab,IF(a.idjenjab=3,d.jabfungum,''))) AS namajab"),
            'a.idskpd','c.skpd', \DB::raw("a.idgolrupkt AS golruskr"), \DB::raw("e.idskpd AS idskpdskr"), \DB::raw("e.path_short AS skpdskr") //\DB::raw("if(left(e.idskpd, 2) = '01', e.path, e.path_short) AS skpdskr"
        )
            ->join('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
            ->leftJoin('a_jabfung as b', 'a.idjabfung','=','b.idjabfung')
            ->leftJoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftJoin('a_skpd as e', 'e.idskpd', '=', 'a.idskpd') //\DB::raw("IF(e.issatker = 1, LEFT(a.idskpd,5), LEFT(a.idskpd,2))")
            ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=','f.idgolru')
            ->leftJoin('a_esl as g', 'a.idesljbt', '=', 'g.idesl')
            ->leftJoin('a_tkpendid as k', 'a.idtkpendid', '=', 'k.idtkpendid')
            ->leftJoin('a_jenjurusan as h', 'a.idjenjurusan', '=', 'h.idjenjurusan')
            ->leftJoin('a_agama as i', 'a.idagama', '=', 'i.idagama')
            ->leftJoin('a_sekolahswasta as j', 'a.iddiperbantukan', '=', 'j.id')
            ->where('a.nip', $nip)
            ->orderBy('e.idskpd', 'desc')
            ->first();

        return $rs;
    }
    
    /*function untuk mendapatkan data pemberhentian kontrak nip*/
    public static function getDatanominatifnip($bup='', $idskpd='', $nip=''){
        $where = " sts_kontrak = 3 and nip = \"".$nip."\" and bup = \"".$bup."\"";        
        if($idskpd != ''){
            $where .= " and idskpd like \"".$idskpd."%\" ";
        }

        $rs = \DB::table("tr_pppk")                   
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function untuk mendapatkan data pemberhentian kontrak all*/
    public static function getDatanominatiftmt($bup='', $idskpd='', $nip=''){
        $where = " sts_kontrak = 3 and bup = \"".$bup."\"";        
        if($idskpd != ''){
            $where .= " and idskpd like \"".$idskpd."%\" ";
        }

        $rs = \DB::table("tr_pppk")            
            ->whereRaw($where)
            ->get();

        return $rs;
    }

    /*function combo jenis pensiun*/
    public static function comboJenpens($id="idjenpens",$sel="",$required="", $class="", $idx="1"){
        $ret = '<select data-id="'.$idx.$id.'" id="idjenpens" idx="'.$idx.'"  name="'.$idx.$id.'"  $required style="width: 100%;" class="form-control '.$class.' idjenpens">';
        $ret.= '<option value="">.: Pilihan :.</option>';

        $rs = \DB::table('a_jenpens')
            ->where('idjenpens','!=',1)
            ->where('idjenpens','!=',2)
            ->where('idjenpens','!=',4)
            ->where('idjenpens','!=',6)
            ->orderBy('idjenpens','asc')
            ->get();
        foreach($rs as $item){
            $isSel = (($item->idjenpens==$sel)?"selected":"");
            $ret.= '<option value="'.$item->idjenpens.'" '.$isSel.' >'.$item->jenpens.'</option>';
        }
        $ret.='</select>';
        return $ret;
    }

    /*cobo list jenis pensiun edit*/
    public static function comboJenpensiun($id="idjenpens", $sel="", $required="")
    {
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('a_jenpens')
                ->where('idjenpens','!=',2)
                ->where('idjenpens','!=',4)
                ->where('idjenpens','!=',6)
                ->orderBy('jenpens', 'asc')->get();
        foreach ($rs as $item) {
            $isSel = (($item->idjenpens==$sel)?"selected":"");
            $ret.="<option value=\"".$item->idjenpens."\" $isSel >".$item->jenpens."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    /* nominatif pemberhentian kontrak verifikasi */
    public static function getNominatifver($idpppk, $nip){
        $rs =  \DB::table('tr_pppk')
            ->select('tr_pppk.*', "alm", "almrt", "almrw", "almdesa", "almkec", "almkab", "almprov", "almkdpos", \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia")) 
            ->join('tb_01', 'tr_pppk.nip', '=', 'tb_01.nip')
            ->where('tr_pppk.idpppk', $idpppk)
            ->where('tr_pppk.nip', $nip)
            ->orderBy('tr_pppk.tmtawal', 'desc')->orderBy('tr_pppk.idskpd')
            ->first();

        return $rs;
    }
}
