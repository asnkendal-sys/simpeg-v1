<?php namespace App\Modules\epersonal\biodata\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Biodata Model
 * @var Biodata
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class BiodataModel extends Model
{
    protected $guarded = array();

    protected $table = "tb_01";
    protected $primaryKey = 'nip'; // or null

    public static $rules = array(
        'nama' => 'required',
        'tmlhr' => 'required',
        'tglhr' => 'required',
        /*'idjenkel' => 'required',
        'idagama' => 'required',
        'idstspeg' => 'required',
        'idjenkepeg' => 'required',*/
        'idjenkedudupeg' => 'required',
        /*'idstskawin' => 'required',
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
        'mkgolblnkgb' => 'required',*/
        /*'kdunit' => 'required',
        'idskpd' => 'required',*/
        /*'noskjbt' => 'required',
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
    'ciri' => 'required',*/

    );

    public static $rpangkat = array(
        // 'nip' => 'required',
        // 'idgolru' => 'required',
        // 'pejmenpkt' => 'required',
        // 'nosk' => 'required',
        // 'tgsk' => 'required',
        // 'tmtpkt' => 'required',
        // 'thkerja' => 'required',
        // 'blkerja' => 'required',
        // 'gapok' => 'required',
    );

    public static $rjabatan = array(
        'nip' => 'required',
        /*'idskpd' => 'required',*/
        'idjenjab' => 'required',
        'idjab' => 'required',
        'pejmen' => 'required',
        'nosk' => 'required',
        'tgsk' => 'required',
        'tmtjab' => 'required',
    );

    public static $rkgb = array(
        'nip' => 'required',
        'idgolru' => 'required',
        'idpenetap' => 'required',
        'noskkgb' => 'required',
        'tmtkgb' => 'required',
        'tglkgb' => 'required',
        'mkthn' => 'required',
        'mkbln' => 'required',
        'gaji' => 'required',
    );

    public static $rpend = array(
        'nip' => 'required',
        'idtkpendid' => 'required',
        'idjenjurusan' => 'required',
        'noijaz' => 'required',
        'tgijaz' => 'required',
        'namasekolah' => 'required',
        'tempat' => 'required',
        'kepsek' => 'required',
    );

    public static $rdikstru = array(
        'nip' => 'required',
        'iddikstru' => 'required',
        'tmdikstru' => 'required',
        'penyelenggara' => 'required',
        'angkatan' => 'required',
        'tgmul' => 'required',
        'tgsel' => 'required',
        'jamhari' => 'required',
        'nosttpdikstru' => 'required',
        'tgsttpdikstru' => 'required',
    );

    public static $rdikfung = array(
        'nip' => 'required',
    // disable karena tidak menggunakan dikfung comment by candra 04122025
       // 'iddikfung' => 'required',
        'tmdikfung' => 'required',
        'penyelenggara' => 'required',
        'angkatan' => 'required',
        'tgmul' => 'required',
        'tgsel' => 'required',
        'jamhari' => 'required',
        'nosttpdikfung' => 'required',
        'tgsttpdikfung' => 'required',
    );

    public static $rdiktek = array(
        'nip' => 'required',
        'nmdiktek' => 'required',
        'tmdiktek' => 'required',
        'penyelenggara' => 'required',
        'angkatan' => 'required',
        'tgmul' => 'required',
        'tgsel' => 'required',
        'jamhari' => 'required',
        'nosttpdiktek' => 'required',
        'tgsttpdiktek' => 'required',
    );

    public static $rseminar = array(
        'nip' => 'required',
        'nmseminar' => 'required',
        'penyelenggara' => 'required',
        'tmseminar' => 'required',
        'tgmul' => 'required',
        'tgsel' => 'required',
        'nopiagam' => 'required',
    );

    public static $rbahasa = array(
        'nip' => 'required',
        'jenis_bahasa' => 'required',
        'nama_bahasa' => 'required',
        'kemampuan' => 'required',
    );

    public static $rpenghargaan = array(
        'nip' => 'required',
        'thn' => 'required',
        'jenis' => 'required',
        'tandajasa' => 'required',
        'pejab' => 'required',
        'nosk' => 'required',
        'nosk' => 'required',
        'tgsk' => 'required',
    );

    public static $rhukdis = array(
        'nip' => 'required',
        'idjenhukum' => 'required',
        'idtkhukum' => 'required',
        'pejab' => 'required',
        'nosk' => 'required',
        'tgsk' => 'required',
        'tgsel' => 'required',
        'ket' => 'required',
    );

    public static $rskp = array(
        'nip' => 'required',
        'nilai' => 'required',
        'tahun' => 'required',
        /*'idpejab' => 'required',
        'pejpenilai' => 'required',*/
    );

    public static $rkinerjaasn = array(
        'nip' => 'required',
        'tahun' => 'required',
        'jabpenilai' => 'required',
        'pejpenilai' => 'required',
    );

    public static $rakredit = array(
        'nip' => 'required',
        'idjabfung' => 'required',
        'pak' => 'required',
        'nosk' => 'required',
        'tgsk' => 'required',
        'periodemulai' => 'required',
        'periodeselesai' => 'required',
        'kubaru' => 'required',
        'kpbaru' => 'required',
        'kbtotal' => 'required',
    );

    public static $rortu = array(
        // 'nip' => 'required',
        // 'nama_ortu' => 'required',
        // 'status_ortu' => 'required',
        // 'tempat_lahir' => 'required',
        // 'tgl_lahir' => 'required',
        // 'alamat' => 'required',
    );

    public static $rissu = array(
        // f
    );

    public static $ranak = array(
        // 'nip' => 'required',
        // 'nmanak' => 'required',
        // 'tmlhr' => 'required',
        // 'tglhr' => 'required',
        // 'idjenkel' => 'required',
        // 'stskeluarga' => 'required',
        // 'idpendidum' => 'required',
        // 'peker' => 'required',
        // 'tunjangan' => 'required',
    );

    public static $rsaudara = array(
        'nip' => 'required',
        'nama' => 'required',
        'idjenkel' => 'required',
        'stssaudara' => 'required',
        'tmlhr' => 'required',
        'tglhr' => 'required',
        'peker' => 'required',
        'ket' => 'required',
    );

    public static function all($columns = array('*'))
    {
        $instance = new static;
        $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
        if (session('role_id') > 3) {
            $where .= " and tb_01.idskpd like \"" . session('idskpd') . "%\" ";
        } else {
            $where .= " and tb_01.nip != ''";
        }

        if (\PermissionsLibrary::hasPermission('mod-biodata-listall')) {
            return $instance->newQuery()
                ->select('tb_01.*', 'a_golruang.golru', 'a_golruang.golru_p3k', 'a_skpd.path_short', 'a_esl.esl', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan',
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
        } else {
            return $instance->newQuery()
                ->whereRaw($where)
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    /*select riwayat pangkat*/
    public static function getRpangkat($nip)
    {
        $rs = \DB::table('r_gol')
            ->select('r_gol.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_gol.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_golruang', 'r_gol.idgolru', '=', 'a_golruang.idgolru')
            ->leftjoin('a_penetapsk', 'r_gol.pejmenpkt', '=', 'a_penetapsk.id')
            ->where('r_gol.nip', '=', $nip)
            ->groupby('r_gol.id', 'c.id')
            ->orderBy('r_gol.tgsk', 'desc');

        return $rs;
    }

    public static function getRpangkattemp($nip)
    {
        $rs = \DB::table('r_gol_temp')
            ->select('r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_gol_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
            ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
            ->where('r_gol_temp.nip', '=', $nip)
            ->groupby('r_gol_temp.id', 'c.id')
            ->orderBy('r_gol_temp.tgsk', 'desc');

        return $rs;
    }

    /*select riwayat jabatan*/
    public static function getRjab($nip)
    {
        $rs = \DB::table('r_jab')
            ->select('r_jab.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_jab.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('a_esl', 'r_jab.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_tugasgurudosen', 'r_jab.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
            ->leftjoin('a_tugasdokter', 'r_jab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
            ->where('r_jab.nip', '=', $nip)
            ->groupby('r_jab.id')
            ->orderBy('r_jab.tgsk', 'desc')
            ->orderBy('r_jab.created_at', 'desc')
            ->orderBy('r_jab.updated_at', 'desc');

        return $rs;
    }

    public static function getRjabtemp($nip)
    {
        $rs = \DB::table('r_jab_temp')
            ->select('r_jab_temp.*', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_jab_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
            ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
            ->where('r_jab_temp.nip', '=', $nip)
            ->groupby('r_jab_temp.id')
            ->orderBy('r_jab_temp.tgsk', 'desc')
            ->orderBy('r_jab_temp.created_at', 'desc')
            ->orderBy('r_jab_temp.updated_at', 'desc');

        return $rs;
    }

    /*select riwayat pppk*/
    public static function getRpppk($nip){
        $rs = \DB::table('r_pppk AS a')
            ->select('a.*', 'e.tugasgurudosen', 'f.tugasdokter', \DB::raw('COUNT(b.id) AS jmlfile'), \DB::raw('SUM(CASE WHEN b.verified = 1 THEN 1 ELSE 0 END) AS jmlverified'))
            ->leftJoin('efile.files AS b', function($join){
            $join->on('b.subjenis', '=', 'a.id');
            $join->on('b.nip','=',\DB::raw('"'.\Input::get('nip').'"'));
        })
            ->leftjoin('a_tugasgurudosen AS e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
            ->leftjoin('a_tugasdokter AS f', 'a.idtugasdokter', '=', 'f.idtugasdokter')
            ->where('a.nip', '=', \Input::get('nip'))
            ->groupby('a.id')
            ->orderBy('a.tgsk', 'desc')
            ->orderBy('a.tmtawal', 'desc')
            ->orderBy('a.created_at', 'desc')
            ->orderBy('a.updated_at', 'desc');
        return $rs;
    }
    public static function getRpppktemp($nip){
        $rs = \DB::table('r_pppk_temp AS a')
            ->select('a.*', 'e.tugasgurudosen', 'f.tugasdokter', \DB::raw('COUNT(b.id) AS jmlfile'), \DB::raw('SUM(CASE WHEN b.verified = 1 THEN 1 ELSE 0 END) AS jmlverified'))
            ->leftJoin('efile.files_temp AS b', function($join){
            $join->on('b.subjenis', '=', 'a.id');
            $join->on('b.nip','=',\DB::raw('"'.\Input::get('nip').'"'));
        })
        // ->leftjoin('a_esl AS d', 'a.idesl', '=', 'd.idesl')
            ->leftjoin('a_tugasgurudosen AS e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
            ->leftjoin('a_tugasdokter AS f', 'a.idtugasdokter', '=', 'f.idtugasdokter')
            ->where('a.nip', '=', \Input::get('nip'))
            ->groupby('a.id')
            ->orderBy('a.tgsk', 'desc')
            ->orderBy('a.tmtawal', 'desc')
            ->orderBy('a.created_at', 'desc')
            ->orderBy('a.updated_at', 'desc');
        return $rs;
    }

    /*select riwayat kenaikan gaji berkala*/
    public static function getRkgb($nip)
    {
        $rs = \DB::table('r_kgb')
            ->select('r_kgb.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan', 'b.istte', 'b.filename', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_kgb.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_golruang', 'r_kgb.idgolru', '=', 'a_golruang.idgolru')
            ->leftjoin('a_penetapsk', 'r_kgb.idpenetap', '=', 'a_penetapsk.id')
            ->where('r_kgb.nip', '=', $nip)
            ->groupby('r_kgb.id', 'c.id')
            ->orderBy('r_kgb.tmtkgb', 'desc');

        return $rs;
    }

    public static function getRkgbtemp($nip)
    {
        $rs = \DB::table('r_kgb_temp')
            ->select('r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan', 'b.istte', 'b.filename', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_kgb_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
            ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
            ->where('r_kgb_temp.nip', '=', $nip)
            ->groupby('r_kgb_temp.id', 'c.id')
            ->orderBy('r_kgb_temp.tmtkgb', 'desc');

        return $rs;
    }

    /*select riwayat pendidikan*/
    public static function getRpend($nip)
    {
        $rs = \DB::table('r_pend')
            ->select('r_pend.*', 'a_tkpendid.tkpendid', 'a_tkpendid.singkatan', \DB::raw('COUNT(b.id) AS jmlfile')) /*, 'a_jenjurusan.jenjurusan'*/
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_pend.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_tkpendid', 'r_pend.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'r_pend.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->where('r_pend.nip', '=', $nip)
            ->groupby('r_pend.id', 'c.id')
            ->orderBy('r_pend.tgijaz', 'desc');

        return $rs;
    }

    public static function getRpendtemp($nip)
    {
        $rs = \DB::table('r_pend_temp')
            ->select('r_pend_temp.*', 'a_tkpendid.tkpendid', \DB::raw('COUNT(b.id) AS jmlfile')) /*, 'a_jenjurusan.jenjurusan'*/
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_pend_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->where('r_pend_temp.nip', '=', $nip)
            ->groupby('r_pend_temp.id', 'c.id')
            ->orderBy('r_pend_temp.tgijaz', 'desc');

        return $rs;
    }

    /*select riwayat diklat struktural*/
    public static function getRdikstru($nip)
    {
        $rs = \DB::table('r_dikstru')
            ->select('r_dikstru.*', \DB::raw('COUNT(b.id) AS jmlfile') /*, 'a_dikstru.dikstru'*/)
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_dikstru.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_dikstru', 'r_dikstru.iddikstru', '=', 'a_dikstru.iddikstru')
            ->where('r_dikstru.nip', '=', $nip)
            ->groupby('r_dikstru.id', 'c.id')
            ->orderBy('r_dikstru.tgmul', 'desc');

        return $rs;
    }

    public static function getRdikstrutemp($nip)
    {
        $rs = \DB::table('r_dikstru_temp')
            ->select('r_dikstru_temp.*', \DB::raw('COUNT(b.id) AS jmlfile') /*, 'a_dikstru.dikstru'*/)
            ->leftJoin('efile.files_temp AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_dikstru_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_dikstru', 'r_dikstru_temp.iddikstru', '=', 'a_dikstru.iddikstru')
            ->where('r_dikstru_temp.nip', '=', $nip)
            ->groupby('r_dikstru_temp.id', 'c.id')
            ->orderBy('r_dikstru_temp.tgmul', 'desc');

        return $rs;
    }

    /*select riwayat diklat fungsional*/
    public static function getRdikfung($nip)
    {
        $rs = \DB::table('r_dikfung')
            ->select('r_dikfung.*', \DB::raw('COUNT(b.id) AS jmlfile') /*, 'a_dikfung.dikfung'*/)
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_dikfung.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_dikfung', 'r_dikfung.iddikfung', '=', 'a_dikfung.iddikfung')
            ->where('r_dikfung.nip', '=', $nip)
            ->groupby('r_dikfung.id', 'c.id')
            ->orderBy('r_dikfung.tgmul', 'desc');

        return $rs;
    }

    public static function getRdikfungtemp($nip)
    {
        $rs = \DB::table('r_dikfung_temp')
            ->select('r_dikfung_temp.*', \DB::raw('COUNT(b.id) AS jmlfile') /*, 'a_dikfung.dikfung'*/)
            ->leftJoin('efile.files_temp AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_dikfung_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_dikfung', 'r_dikfung_temp.iddikfung', '=', 'a_dikfung.iddikfung')
            ->where('r_dikfung_temp.nip', '=', $nip)
            ->groupby('r_dikfung_temp.id', 'c.id')
            ->orderBy('r_dikfung_temp.tgmul', 'desc');

        return $rs;
    }

    /*select riwayat diklat teknis*/
    public static function getRdiktek($nip)
    {
        $rs = \DB::table('r_diktek')
            ->select('r_diktek.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_diktek.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_diktek.nip', '=', $nip)
            ->groupby('r_diktek.id', 'c.id')
            ->orderBy('r_diktek.tgmul', 'desc');

        return $rs;
    }

    public static function getRdiktektemp($nip)
    {
        $rs = \DB::table('r_diktek_temp')
            ->select('r_diktek_temp.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files_temp AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_diktek_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_diktek_temp.nip', '=', $nip)
            ->groupby('r_diktek_temp.id', 'c.id')
            ->orderBy('r_diktek_temp.tgmul', 'desc');

        return $rs;
    }

    /*select riwayat seminar*/
    public static function getRseminar($nip)
    {
        $rs = \DB::table('r_seminar')
            ->select('r_seminar.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_seminar.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_seminar.nip', '=', $nip)
            ->groupby('r_seminar.id', 'c.id')
            ->orderBy('r_seminar.tgpiagam', 'desc');

        return $rs;
    }

    public static function getRseminartemp($nip)
    {
        $rs = \DB::table('r_seminar_temp')
            ->select('r_seminar_temp.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_seminar_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_seminar_temp.nip', '=', $nip)
            ->groupby('r_seminar_temp.id', 'c.id')
            ->orderBy('r_seminar_temp.tgpiagam', 'desc');

        return $rs;
    }

    /*select riwayat seminar*/
    public static function getRpenghargaan($nip)
    {
        $rs = \DB::table('r_tandajasa')
            ->select('r_tandajasa.*', 'a_jnstandajasa.tandajasa as namatandajasa', 'a_pejabat.nama', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_tandajasa.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jnstandajasa', 'r_tandajasa.jenis', '=', 'a_jnstandajasa.idtandajasa')
            ->leftjoin('a_pejabat', 'r_tandajasa.idpejab', '=', 'a_pejabat.kode')
            ->where('r_tandajasa.nip', '=', $nip)
            ->groupby('r_tandajasa.id', 'c.id')
            ->orderBy('r_tandajasa.tgsk', 'desc');

        return $rs;
    }

    public static function getRpenghargaantemp($nip)
    {
        $rs = \DB::table('r_tandajasa_temp')
            ->select('r_tandajasa_temp.*', 'a_jnstandajasa.tandajasa as namatandajasa', 'a_pejabat.nama', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_tandajasa_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jnstandajasa', 'r_tandajasa_temp.jenis', '=', 'a_jnstandajasa.idtandajasa')
            ->leftjoin('a_pejabat', 'r_tandajasa_temp.idpejab', '=', 'a_pejabat.kode')
            ->where('r_tandajasa_temp.nip', '=', $nip)
            ->groupby('r_tandajasa_temp.id', 'c.id')
            ->orderBy('r_tandajasa_temp.tgsk', 'desc');

        return $rs;
    }

    /*select riwayat bahasa*/
    public static function getRbahasa($nip)
    {
        $rs = \DB::table('r_bahasa')
            ->select('r_bahasa.*')
            ->where('r_bahasa.nip', '=', $nip)
            ->orderBy('r_bahasa.nama_bahasa', 'desc');

        return $rs;
    }

    public static function getRbahasatemp($nip)
    {
        $rs = \DB::table('r_bahasa_temp')
            ->select('r_bahasa_temp.*')
            ->where('r_bahasa_temp.nip', '=', $nip)
            ->orderBy('r_bahasa_temp.nama_bahasa', 'desc');

        return $rs;
    }

    /*select riwayat hukuman disiplin*/
    public static function getRhukdis($nip)
    {
        $rs = \DB::table('r_hukdis')
            ->select('r_hukdis.*', 'a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_hukdis.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jenhukum', 'r_hukdis.idjenhukum', '=', 'a_jenhukum.idjenhukum')
            ->leftjoin('a_kathukdis', 'r_hukdis.idtkhukum', '=', 'a_kathukdis.idkathukdis')
            ->leftjoin('a_penetapsk', 'r_hukdis.pejab', '=', 'a_penetapsk.id')
            ->where('r_hukdis.nip', '=', $nip)
            ->groupby('r_hukdis.id', 'c.id')
            ->orderBy('r_hukdis.tgmul', 'desc');

        return $rs;
    }

    public static function getRhukdistemp($nip)
    {
        $rs = \DB::table('r_hukdis_temp')
            ->select('r_hukdis_temp.*', 'a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_hukdis_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
            ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
            ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
            ->where('r_hukdis_temp.nip', '=', $nip)
            ->groupby('r_hukdis_temp.id', 'c.id')
            ->orderBy('r_hukdis_temp.tgmul', 'desc');

        return $rs;
    }

    /*select riwayat sasaran kinerja pegawai*/
    public static function getRskp($nip)
    {
        $rs = \DB::table('r_skp')
            ->select('r_skp.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_skp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_skp.nip', '=', $nip)
            ->groupby('r_skp.id', 'c.id')
            ->orderBy('r_skp.tahun', 'desc')
            ->orderBy('r_skp.pejpenilai', 'desc');

        return $rs;
    }

    public static function getRskptemp($nip)
    {
        $rs = \DB::table('r_skp_temp')
            ->select('r_skp_temp.*', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_skp_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_skp_temp.nip', '=', $nip)
            ->groupby('r_skp_temp.id', 'c.id')
            ->orderBy('r_skp_temp.tahun', 'desc')
            ->orderBy('r_skp_temp.pejpenilai', 'desc');

        return $rs;
    }

    public static function getRkinerjaasn($nip)
    {
        $rs = \DB::table('r_kinerjaasn')
            ->select('r_kinerjaasn.*', \DB::raw('COUNT(b.id) AS jmlfile'), \DB::raw('SUM(CASE WHEN b.verified = 1 THEN 1 ELSE 0 END) AS verified'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_kinerjaasn.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->where('r_kinerjaasn.nip', '=', $nip)
            ->groupby('r_kinerjaasn.id', 'c.id')
            ->orderBy('r_kinerjaasn.tahun', 'desc')
            ->orderBy('r_kinerjaasn.pejpenilai', 'desc');

        return $rs;
    }

    /*select riwayat angka kredit*/
    public static function getRakredit($nip)
    {
        $rs = \DB::table('r_akredit')
            ->select('r_akredit.*', \DB::raw('a_jabfung.jabfung as jabatan'), \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_akredit.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jabfung', 'r_akredit.idjabfung', '=', 'a_jabfung.idjabfung')
            ->where('r_akredit.nip', '=', $nip)
            ->groupby('r_akredit.id', 'c.id')
            ->orderBy('r_akredit.tgsk', 'desc');

        return $rs;
    }

    public static function getRakredittemp($nip)
    {
        $rs = \DB::table('r_akredit_temp')
            ->select('r_akredit_temp.*', 'a_jabfung.jabfung', \DB::raw('COUNT(b.id) AS jmlfile'))
            ->leftJoin('efile.files AS b', function ($join) {
                $join->on('b.subjenis', '=', 'r_akredit_temp.id');
                $join->on('b.nip', '=', \DB::raw('"' . \Input::get('nip') . '"'));
            })
            ->leftjoin('efile.kategori_jenis AS c', 'c.id', '=', 'b.subsubjenis')
            ->leftjoin('a_jabfung', 'r_akredit_temp.idjabfung', '=', 'a_jabfung.idjabfung')
            ->where('r_akredit_temp.nip', '=', $nip)
            ->groupby('r_akredit_temp.id', 'c.id')
            ->orderBy('r_akredit_temp.tgsk', 'desc');

        return $rs;
    }

    /*select riwayat cuti*/
    public static function getRcuti($nip) {
        $rs = \DB::table('r_cuti as a')
            ->select('a.*', 'b.jenis_cuti as jenis_cuti', 'c.tgl_usul')
            ->join('a_jenis_cuti as b', 'a.jencuti','=','b.id')
            ->join('tr_ijin_cuti as c',  function($join) {
                $join->on('a.nip','=','c.nip');
                $join->on('a.nousul','=','c.nousul');
            })
            ->where('a.nip', $nip)
            ->orderby('c.tgl_usul', 'desc');
        
        return $rs;
    }
    
    /*select riwayat orangtua*/
    public static function getRortu($nip)
    {
        $rs = \DB::table('r_ortu')
            ->select('r_ortu.*', \DB::raw("if(r_ortu.status_ortu=1,'Ayah',if(r_ortu.status_ortu=2,'Ibu',if(r_ortu.status_ortu=3,'Ayah Mertua',if(r_ortu.status_ortu=4,'Ibu Mertua','')))) as stat"))
            ->where('r_ortu.nip', '=', $nip)
            ->orderBy('r_ortu.status_ortu', 'asc')
            ->orderBy('r_ortu.tgl_lahir', 'desc');

        return $rs;
    }

    public static function getRortutemp($nip)
    {
        $rs = \DB::table('r_ortu_temp')
            ->select('r_ortu_temp.*', \DB::raw("if(r_ortu_temp.status_ortu=1,'Ayah',if(r_ortu_temp.status_ortu=2,'Ibu',if(r_ortu_temp.status_ortu=3,'Ayah Mertua',if(r_ortu_temp.status_ortu=4,'Ibu Mertua','')))) as stat"))
            ->where('r_ortu_temp.nip', '=', $nip)
            ->orderBy('r_ortu_temp.status_ortu', 'asc')
            ->orderBy('r_ortu_temp.tgl_lahir', 'desc');

        return $rs;
    }

    /*select riwayat isteri atau suami*/
    public static function getRissu($nip)
    {
        $rs = \DB::table('r_issu')
            ->select('r_issu.*')
            ->where('r_issu.nip', '=', $nip)
            ->orderBy('r_issu.tglhr', 'desc');

        return $rs;
    }

    public static function getRissutemp($nip)
    {
        $rs = \DB::table('r_issu_temp')
            ->select('r_issu_temp.*')
            ->where('r_issu_temp.nip', '=', $nip)
            ->orderBy('r_issu_temp.tglhr', 'desc');

        return $rs;
    }

    /*select riwayat anak*/
    public static function getRanak($nip)
    {
        $rs = \DB::table('r_anak')
            ->select('r_anak.*',
                \DB::raw("if(r_anak.idjenkel=1,'Laki-laki',if(r_anak.idjenkel=2,'Perempuan','')) as jenkel"),
                \DB::raw("if(r_anak.tunjangan=1,'Dapat',if(r_anak.tunjangan=2,'Tidak','')) as tunjang"))
            ->where('r_anak.nip', '=', $nip)
            ->orderBy('r_anak.tglhr', 'asc');

        return $rs;
    }

    public static function getRanaktemp($nip)
    {
        $rs = \DB::table('r_anak_temp')
            ->select('r_anak_temp.*',
                \DB::raw("if(r_anak_temp.idjenkel=1,'Laki-laki',if(r_anak_temp.idjenkel=2,'Perempuan','')) as jenkel"),
                \DB::raw("if(r_anak_temp.tunjangan=1,'Dapat',if(r_anak_temp.tunjangan=2,'Tidak','')) as tunjang"))
            ->where('r_anak_temp.nip', '=', $nip)
            ->orderBy('r_anak_temp.tglhr', 'asc');

        return $rs;
    }

    /*select riwayat saudara*/
    public static function getRsaudara($nip)
    {
        $rs = \DB::table('r_saudarakandung')
            ->select('r_saudarakandung.*',
                \DB::raw("if(r_saudarakandung.idjenkel=1,'Laki-laki','Perempuan') as jenkel"),
                \DB::raw("if(r_saudarakandung.stssaudara=1,'Saudara Kandung','Saudara Kandung Isteri/Suami') as stssaudara"))
            ->where('r_saudarakandung.nip', '=', $nip)
            ->orderBy('r_saudarakandung.tglhr', 'desc');

        return $rs;
    }

    public static function getRsaudaratemp($nip)
    {
        $rs = \DB::table('r_saudarakandung_temp')
            ->select('r_saudarakandung_temp.*',
                \DB::raw("if(r_saudarakandung_temp.idjenkel=1,'Laki-laki','Perempuan') as jenkel"),
                \DB::raw("if(r_saudarakandung_temp.stssaudara=1,'Saudara Kandung','Saudara Kandung Isteri/Suami') as stssaudara"))
            ->where('r_saudarakandung_temp.nip', '=', $nip)
            ->orderBy('r_saudarakandung_temp.tglhr', 'desc');

        return $rs;
    }

    /*start of simpeg pppk 07-12-2021*/
    public static $rpppk = array(
        'nip' => 'required',
        /*'idskpd' => 'required',*/
        // 'idjenjab' => 'required',
        // 'idjab' => 'required',
        // 'pejmen' => 'required',
        // 'nosk' => 'required',
        // 'tgsk' => 'required',
        'tmtawal' => 'required',
        'tmtakhir' => 'required',
    );
    /*end of simpeg pppk*/

    /*integrasi siasn*/
    public static $rjabsiasn = array(
        'nip' => 'required',
        /*'idskpd' => 'required',*/
        'idjenjab' => 'required',
        'idjab' => 'required',
        /*'pejmen' => 'required',
        'nosk' => 'required',
        'tgsk' => 'required',
        'tmtjab' => 'required',*/
    );
    /*end of integrasi siasn*/

    /*function untuk cek status pegawai*/
    public static function getStatuspegawai($nip=''){
        $rs = \DB::table('tb_01')->where('nip', $nip)->first();
        return @$rs->idstspeg;
    }
}
