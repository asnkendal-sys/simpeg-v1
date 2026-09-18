<?php namespace App\Modules\kenaikanpangkat\rekapusulankenaikanpangkat\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Rekapusulankenaikanpangkat Model
 * @var Rekapusulankenaikanpangkat
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class RekapusulankenaikanpangkatModel extends Model {
    protected $guarded = array();

    protected $table = "tr_kenaikan_pangkat";

    public static $rules = array(
        'nousul' => 'required',
        'tglusul' => 'required',
        'nip' => 'required',
        'idjeniskp' => 'required',
        'username' => 'required',
        'user_id' => 'required',
        'role_id' => 'required',
        'created_at' => 'required',

    );

    public static function all($columns = array('*')){
        $instance = new static;
        $where = "tr_kenaikan_pangkat.idusul != 0";
        if(session('role_id') > 3){
            $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
        }

        if (\PermissionsLibrary::hasPermission('mod-rekapusulankenaikanpangkat-listall')){
            return $instance->newQuery()//get rekap dr sini
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
                ->orderBy('tmt')
                ->orderBy('idskpd')
                ->orderBy('idjeniskp')
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
                ->orderBy('tmt')
                ->orderBy('idskpd')
                ->orderBy('idjeniskp')
                ->where('tr_kenaikan_pangkat.role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    public static function attrPengantar($idskpd){
        $where = "b.idjenkedudupeg NOT IN('99','21') and b.idjenjab > 4 and b.idjabjbt = \"".substr($idskpd, 0,2)."\"";
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
