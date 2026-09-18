<?php namespace App\Modules\webservices\kolaborasidatataspen\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Kolaborasidatataspen Model
 * @var Kolaborasidatataspen
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class KolaborasidatataspenModel extends Model {
    protected $guarded = array();

    protected $table = "tb_01";

    public static $rules = array(
        'no' => 'required',
        'nip' => 'required',
        'niplama' => 'required',
        'email' => 'required',

    );

    public static function all($columns = array('*')){
        $instance = new static;
        $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
        if (session('role_id') > 3) {
            $where .= " and tb_01.idskpd like \"" . session('idskpd') . "%\" ";
        } else {
            $where .= " and tb_01.nip != ''";
        }

        if (\PermissionsLibrary::hasPermission('mod-kolaborasidatataspen-listall')){
            return $instance->newQuery()
                ->select('tb_01.*', 'a_golruang.golru', 'a_skpd.path_short', 'a_esl.esl', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'), 'a_agama.agama',
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
                ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
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

    /*combo list ya atau tidak */
    public static function comboStskolaborasi($id="idstatus", $sel="", $required="")
    {
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\" ".(($sel == '')?"selected":"").">.: Kolaborasi Data :.</option>";
        $ret.="<option value=\"0\" ".(($sel == 0)?"selected":"").">Belum Sinkronisasi</option>";
        $ret.="<option value=\"1\" ".(($sel == 1)?"selected":"").">Sudah Sinkronisasi</option>";
        $ret.="<option value=\"2\" ".(($sel == 2)?"selected":"").">Update Sinkronisasi</option>";
        $ret.="</select>";
        return $ret;
    }

    /*function untuk mendapatkan data pegawai berdasarkan nip*/
    public static function getDatapegawai($nip=""){
        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.id','a.niplama', 'a.nip', \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) AS namalengkap'),
                'a.idstspeg', 'g.idstspeg_taspen', 'g.stspeg_taspen', 'a.idgolrupkt', 'b.pangkat', 'a.gaji', 'a.mkthnpkt', 'a.mkblnpkt', 'a.noskpkt', 'a.tgskpkt', 'a.tmtpkt',
                'c.idskpd_taspen','c.path_short', 'a.kdunit', 'a.nonpwp', 'a.hp', 'a.updated_at', 'a.idjenkedudupeg',
                'i.idjenpens_taspen', 'i.jenpens_taspen', 'h.idjenkedudupeg_taspen', 'h.jenkedudupeg_taspen', 'g.kdsatpeg_taspen', 'g.nmsatpeg_taspen',
                \DB::raw('IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, ""))) AS idjabatan'),
                \DB::raw('DATE_ADD(a.tmtpkt, INTERVAL 3 MONTH) AS bulan_dibayar, DATE_ADD(a.tmtpkt, INTERVAL if(a.idjenjab=2,2,4) YEAR) AS tmtberkalayad'),
                'a.idesljbt', 'f.jabatan as jabatan_penetap', 'f.namalengkap as namalengkap_penetap', 'a.idjenkedudupeg',
                \DB::raw('IF(a.idjenjab>4,c.jab,IF(a.idjenjab=2,d.jabfung,IF(a.idjenjab=3,e.jabfungum,"-"))) AS jabatan')
            )
            ->join('a_golruang as b', 'a.idgolrupkt', '=', 'b.idgolru')
            ->join('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
            ->leftJoin('a_jabfung as d', 'a.idjabfung', '=', 'd.idjabfung')
            ->leftJoin('a_jabfungum as e', 'a.idjabfungum', '=', 'e.idjabfungum')
            ->leftJoin('a_penetapsk as f', 'a.pejmenpkt', '=', 'f.id')
            ->join('a_stspeg as g', 'a.idstspeg', '=', 'g.idstspeg')
            ->join('a_jenkedudupeg as h', 'a.idjenkedudupeg', '=', 'h.idjenkedudupeg')
            ->leftJoin('a_jenpens as i', 'a.idjenpens', '=', 'i.idjenpens')
            ->where('a.nip', $nip)
            ->first();

        return $rs;
    }

    /*function untuk mendapatkan golongan alfabeth*/
    public static function getGolalfa($alfa=''){
        $golalfa = '';
        switch ($alfa) {
            case 1 : $golalfa = 'A'; break;
            case 2 : $golalfa = 'B'; break;
            case 3 : $golalfa = 'C'; break;
            case 4 : $golalfa = 'D'; break;
            case 5 : $golalfa = 'E'; break;
        }

        return $golalfa;
    }
}
