<?php namespace App\Modules\epersonal\perubahanbiodata\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Perubahanbiodata Model
* @var Perubahanbiodata
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PerubahanbiodataModel extends Model {
	protected $guarded = array();

    protected $table = "tb_01_temp";
    protected $primaryKey = 'nip'; // or null

	public static $rules = array(
        'nama' => 'required',
        'tmlhr' => 'required',
        'tglhr' => 'required',
        'idjenkel' => 'required',
        'idagama' => 'required',
        'idstspeg' => 'required',
        'idjenkepeg' => 'required',
        'idjenkedudupeg' => 'required',
        'idstskawin' => 'required',
        'alm' => 'required',
        'almrt' => 'required',
        'almrw' => 'required',
        'almdesa' => 'required',
        'almkec' => 'required',
        'almkab' => 'required',
        'almprov' => 'required',
        'almkdpos' => 'required',
        'telp' => 'required',
        'hp' => 'required',
        'idgoldarah' => 'required',
        'nokarpeg' => 'required',
        'noaskes' => 'required',
        'notaspen' => 'required',
        'nokaris' => 'required',
        'nonpwp' => 'required',
        'noktp' => 'required',
        'nobapertarum' => 'required',
        'pejmencpn' => 'required',
        'noskcpn' => 'required',
        'tgskcpn' => 'required',
        'idgolrucpn' => 'required',
        'tmtcpn' => 'required',
        'mkthncpn' => 'required',
        'mkblncpn' => 'required',
        'pejmenpns' => 'required',
        'noskpns' => 'required',
        'tgskpns' => 'required',
        'idgolrupns' => 'required',
        'tmtpns' => 'required',
        'pejmenpkt' => 'required',
        'noskpkt' => 'required',
        'tgskpkt' => 'required',
        'idgolrupkt' => 'required',
        'tmtpkt' => 'required',
        'mkthnpkt' => 'required',
        'mkblnpkt' => 'required',
        'pejmenkgb' => 'required',
        'noskkgb' => 'required',
        'tgskkgb' => 'required',
        'idgolkgb' => 'required',
        'tmtkgb' => 'required',
        'mkgolthnkgb' => 'required',
        'mkgolblnkgb' => 'required',
        'kdunit' => 'required',
        'idskpd' => 'required',
        'noskjbt' => 'required',
        'tgskjbt' => 'required',
        'idjenjab' => 'required',
        'pejmenjbt' => 'required',
        'tmtjbt' => 'required',
        'idtkpendid' => 'required',
        'idjenjurusan' => 'required',
        'thijaz' => 'required',
        'idtkpendidawal' => 'required',
        'idjenjurusanawal' => 'required',
        'thijazawal' => 'required',
        'mkthnpns' => 'required',
        'mkblnpns' => 'required',
        'tinggi' => 'required',
        'berat' => 'required',
        'rambut' => 'required',
        'muka' => 'required',
        'kulit' => 'required',
        'ciri' => 'required',

    );

	public static function all($columns = array('*')){
        $instance = new static;
		  // $where = " tb_01_temp.status != '1' and tb_01_temp.idjenkedudupeg not in('99','21') and tb_01_temp.nip != '' ";
		  $where = " tb_01_temp.status != '1' and tb_01_temp.nip != '' ";
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01_temp.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01_temp.idskpd like \"".session('idskpd')."%\" ";
                $where.= " and tb_01_temp.status like \"".session('status')."%\" ";
            }
        }

        if (\PermissionsLibrary::hasPermission('mod-perubahanbiodata-listall')){
            return $instance->newQuery()
                ->select('tb_01_temp.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                    \DB::raw('CONCAT(tb_01_temp.gdp,IF(LENGTH(tb_01_temp.gdp)>0," ",""),tb_01_temp.nama,IF(LENGTH(tb_01_temp.gdb)>0,", ",""),tb_01_temp.gdb) as namalengkap'),'a_agama.agama',
                    \DB::raw('IF(tb_01_temp.idjenjab>4,a_skpd.jab,IF(tb_01_temp.idjenjab=2,a_jabfung.jabfung,IF(tb_01_temp.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01_temp.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                    \DB::raw("
                            CONCAT(
                                IF((LEFT(tb_01_temp.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0)-2))
                                        -
                                        (IF((LEFT(tb_01_temp.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01_temp.mkthncpn,
                                        IF((LEFT(tb_01_temp.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01_temp.mkthncpn,
                                            IF((LEFT(tb_01_temp.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01_temp.mkthncpn, 0 ))))
                                    ),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0)-2))
                                        + tb_01_temp.mkthncpn
                                    )
                                ),
                                RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                        "),
                    \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01_temp.tglhr)), '%Y%m')+0 AS usia")
                )
                ->leftjoin('a_skpd', 'tb_01_temp.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'tb_01_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tkpendid', 'tb_01_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tb_01_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tb_01_temp.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_agama', 'tb_01_temp.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jabfung', 'tb_01_temp.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01_temp.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01_temp.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->whereRaw($where)
                ->orderBy('tb_01_temp.updated_at', 'dsc')
                ->orderBy('tb_01_temp.idskpd', 'asc')
                ->orderBy('tb_01_temp.idgolrupkt', 'desc')
                ->orderBy('tb_01_temp.tmtpkt', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->whereRaw($where)
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
	}

}
