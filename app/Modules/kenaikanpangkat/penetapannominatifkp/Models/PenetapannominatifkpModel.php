<?php namespace App\Modules\kenaikanpangkat\penetapannominatifkp\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Penetapannominatifkp Model
* @var Penetapannominatifkp
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenetapannominatifkpModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_kenaikan_pangkat";
    protected $primaryKey = 'idusul';

	public static $rules = array(
        'bulan' => 'required',
        'tahun' => 'required'

    );

	public static function all($columns = array('*')){
		$instance = new static;
        $where = "tr_kenaikan_pangkat.idusul != 0";
        if(session('role_id') > 3){
            $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-penetapannominatifkp-listall')){
			return $instance->newQuery()
                ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id')
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt', 'desc')
                // ->orderBy('nousul','desc')
                // ->orderBy('idskpd')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
                ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id')
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt', 'desc')
                // ->orderBy('nousul','desc')
                // ->orderBy('idskpd')
			    ->where('tr_kenaikan_pangkat.role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function get attribut kp*/
    public static function getattkp($nip){
        $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat',
                \DB::raw('IF(tb_01.idjenjab=2,DATE_ADD(tb_01.tmtpkt, INTERVAL 5 YEAR),DATE_ADD(tb_01.tmtpkt, INTERVAL 4 YEAR)) AS tmtpktnext'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                \DB::raw("
                    CONCAT(
                        IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                -
                                (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                    IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                            ),
                            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                + tb_01.mkthncpn
                            )
                        ),
                        RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                    "),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
                \DB::raw("a_golruangcpn.golru as golrucpn,a_golruangcpn.pangkat as pangkatcpn, a_golruangpns.golru as golrupns,a_golruangpns.pangkat as pangkatpns")
            )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_golruang as a_golruangcpn', 'tb_01.idgolrucpn', '=', 'a_golruangcpn.idgolru')
            ->leftjoin('a_golruang as a_golruangpns', 'tb_01.idgolrupns', '=', 'a_golruangpns.idgolru')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->where('tb_01.nip', $nip)
            ->first();

        return $rs;
    }

    public static function attrPengantarskpd($idskpd, $attr){
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
            return $rs->$attr;
        }else{
            return "";
        }
    }

    /*function nomor urut usulan kp*/
    public static function nourut($tmt){
        $rs = \DB::table('tr_kenaikan_pangkat')->select(\DB::raw("CONCAT(DATE_FORMAT('".$tmt."','%y%m%d'),
                        LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))->where('tmt', $tmt)->first();

        return $rs->kd;
    }

    public static function attrKepskpd($idskpd,$field){
        $idskpd = substr($idskpd,0,2);
        $where = "a.idjenkedudupeg not in (99,21)";
        $where.=" and a.idjenjab > 4 and a.idskpd = \"".$idskpd."\"";

        $rs = \DB::table('tb_01 as a')
            ->select(
            'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw($where)
            ->first();

        if(count($rs) > 0){
            return $rs->$field;
        }else{
            $rs2 = \DB::table('a_skpd as b')
                ->select(
                'a.nip', \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'b.jab_utuh', 'c.golru', 'c.pangkat')
                ->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->whereRaw("b.idskpd = \"".$idskpd."\"")
                ->first();

            if(count($rs2) > 0){
                if($field == 'jab_utuh'){
                    return "Plt. ".$rs2->$field;
                }else{
                    return $rs2->$field;
                }
            }else{
                return '-';
            }
        }
    }

    /*cobo list jenis KP*/
    public static function comboJenisKpNominatif($id="idjeniskp",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('a_jenis_kp')->where('id','<','4')->orderBy('id','asc')->get();
        foreach($rs as $item){
            $isSel = (($item->id==$sel)?"selected":"");
            $ret.="<option value=\"".$item->id."\" $isSel >".$item->jenis_kp."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    /*combo status sk*/
    public static function comboStatussk($id="statussk",$sel="",$required="",$holder=".: Pilihan :."){
        $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html.="<option value=\"\">".$holder."</option>";
        $html.="<option value=\"0\" ".(($sel=='0')?"selected":"").">Belum Diproses</option>";
        $html.="<option value=\"2\" ".(($sel=='2')?"selected":"").">Dalam Proses</option>";
        $html.="<option value=\"1\" ".(($sel=='1')?"selected":"").">Proses Selesai</option>";
        $html.="</select>";
        return $html;
    }

    //combo status berkas
    public static function comboStatusBerkas($id="statususul",$sel="",$required="",$holder=".: Pilihan :."){
        $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html.="<option value=\"\">".$holder."</option>";
        $html.="<option value=\"1\" ".(($sel=='1')?"selected":"").">Memenuhi Syarat</option>";
        $html.="<option value=\"2\" ".(($sel=='2')?"selected":"").">Tidak Memenuhi Syarat</option>";
        $html.="<option value=\"3\" ".(($sel=='3')?"selected":"").">Berkas Tidak Lengkap</option>";
        $html.="</select>";
        return $html;
    }

    public function pegawai()
    {
        return $this->hasOne('App\Modules\epersonal\biodata\Models\BiodataModel','nip','nip');
    }

    /*combo status sk*/
    public static function comboJenjabkp($id="idjenjab",$sel="",$required=""){
        $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html.="<option value=\"0\" ".(($sel=='0')?"selected":"").">.:Pilihan:.</option>";
        $html.="<option value=\"2\" ".(($sel=='2')?"selected":"").">Fungsional</option>";
        $html.="<option value=\"3\" ".(($sel=='3')?"selected":"").">Pelaksana</option>";
        $html.="<option value=\"20\" ".(($sel=='20')?"selected":"").">Struktural</option>"; //20,30,40
        $html.="</select>";
        return $html;
    }

    public static function comboKp($id="blnkpr", $sel="", $required="")
    {
        $ret = "<select id=\"$id\" name=\"$id\" class=\"form-control\" $required style=\"width:100%\">";
        $ret.="<option value=\"\">.:Pilihan:.</option>";
        $ret.="<option value=\"01\" ".(($sel=='01')?"selected":"").">Januari</option>";
        $ret.="<option value=\"02\" ".(($sel=='02')?"selected":"").">Februari</option>";
        $ret.="<option value=\"03\" ".(($sel=='03')?"selected":"").">Maret</option>";
        $ret.="<option value=\"04\" ".(($sel=='04')?"selected":"").">April</option>"; //tambah 0,biar tmt kp pas create nominatif bisa auto keisi
        $ret.="<option value=\"05\" ".(($sel=='05')?"selected":"").">Mei</option>";
        $ret.="<option value=\"06\" ".(($sel=='06')?"selected":"").">Juni</option>";
        $ret.="<option value=\"07\" ".(($sel=='07')?"selected":"").">Juli</option>";
        $ret.="<option value=\"08\" ".(($sel=='08')?"selected":"").">Agustus</option>";
        $ret.="<option value=\"09\" ".(($sel=='09')?"selected":"").">September</option>";
        $ret.="<option value=\"10\" ".(($sel=='10')?"selected":"").">Oktober</option>";
        $ret.="<option value=\"11\" ".(($sel=='11')?"selected":"").">November</option>";
        $ret.="<option value=\"12\" ".(($sel=='12')?"selected":"").">Desember</option>";
        $ret.="</select>";
        return $ret;
    }

    public static function comboCreateKp($id="blnkpr", $sel="", $required="")
    {
        $ret = "<select id=\"$id\" name=\"$id\" class=\"form-control\" $required style=\"width:100%\" disabled>";
        $ret.="<option value=\"\">.:Pilihan:.</option>";
        $ret.="<option value=\"02\" ".(($sel=='02')?"selected":"").">Februari</option>";
        $ret.="<option value=\"04\" ".(($sel=='04')?"selected":"").">April</option>"; //tambah 0,biar tmt kp pas create nominatif bisa auto keisi
        $ret.="<option value=\"06\" ".(($sel=='06')?"selected":"").">Juni</option>";
        $ret.="<option value=\"08\" ".(($sel=='08')?"selected":"").">Agustus</option>";
        $ret.="<option value=\"10\" ".(($sel=='10')?"selected":"").">Oktober</option>";
        $ret.="<option value=\"12\" ".(($sel=='12')?"selected":"").">Desember</option>";
        $ret.="</select>";
        $ret.="<input type='hidden' name=\"$id\" value=\"$sel\" />";
        return $ret;
    }

    public static function comboCreateTahun($id="tahun", $sel="", $required="", $holder='.: Pilihan :.')
    {
        $html="<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\" disabled>";
        $html .= "<option value=''>".$holder."</option>";
        for ($i=date('Y')-5;$i<=date('Y')+30;$i++) {
            $html.="<option value='$i' ".(($i==$sel)?"selected":"").">$i</option>";
        }
        $html.="</select>";
        $html.="<input type='hidden' name=\"$id\" value=\"$sel\" />";
        return $html;
    }


}
