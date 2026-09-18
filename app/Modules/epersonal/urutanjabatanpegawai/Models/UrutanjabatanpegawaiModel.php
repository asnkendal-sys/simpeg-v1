<?php namespace App\Modules\epersonal\urutanjabatanpegawai\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Urutanjabatanpegawai Model
* @var Urutanjabatanpegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UrutanjabatanpegawaiModel extends Model {
	protected $guarded = array();

    protected $table = "tb_01";
    protected $primaryKey = 'nip'; // or null

	public static $rules = array(
        'nama' => 'required',
		'gdp' => 'required',
		'gdb' => 'required',
		'tmlhr' => 'required',
		'tglhr' => 'required',
		'idjenkel' => 'required',
		'idagama' => 'required',
		'idstspeg' => 'required',
		'idjenkepeg' => 'required',
		'idjenkedudupeg' => 'required',
		'idstskawin' => 'required',

    );

	public static function all($columns = array('*')){
        $instance = new static;
        $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
        if(session('role_id') > 3){
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }else{
            $where.= " and tb_01.nip != ''";
        }

        if (\PermissionsLibrary::hasPermission('mod-urutanjabatanpegawai-listall')){
            return $instance->newQuery()
                ->select('tb_01.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_agama.agama',
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
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
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
            )
                ->join('a_skpd', function($join){
                    $join->on('tb_01.idskpd', '=', 'a_skpd.idskpd')
                        ->where('a_skpd.flag','=',1);
                })
                ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->whereRaw($where)
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
	}

    public static function warnajabatan($idesljbt){
        $idesl = substr($idesljbt, 0, 1);
        if($idesl == 2){
            $color = '#FF3333';
        }else if($idesl == 3){
            $color = '#0080FF';
        }else if($idesl == 4){
            $color = '#00FF80';
        }else{
            $color = '#FFFF66';
        }

        return $color;
    }

    public static function warnajabatanx($idesljbt){
        $idesl = substr($idesljbt, 0, 1);
        if($idesl == 2){
            $color = 's75';
        }else if($idesl == 3){
            $color = 's109';
        }else if($idesl == 4){
            $color = 's94';
        }else{
            $color = 's96';
        }

        return $color;
    }
}
