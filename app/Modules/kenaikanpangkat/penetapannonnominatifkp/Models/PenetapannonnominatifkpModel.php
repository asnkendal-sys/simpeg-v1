<?php namespace App\Modules\kenaikanpangkat\penetapannonnominatifkp\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Penetapannonnominatifkp Model
 * @var Penetapannonnominatifkp
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class PenetapannonnominatifkpModel extends Model {
    protected $guarded = array();

    protected $table = "tr_kenaikan_pangkat";
    protected $primaryKey = 'idusul';

    public static $rules = array(
        'nip' => 'required',
        'idjeniskp' => 'required',
        'idgolrupktb' => 'required',
        'mktkpb' => 'required',
        'mkbkpb' => 'required',
        'gkpb' => 'required',
        'tmt' => 'required',

    );

    public static function all($columns = array('*')){
        $instance = new static;
        $where = "tr_kenaikan_pangkat.isnom = 2";
        if(session('role_id') > 3){
            $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
        }

        if (\PermissionsLibrary::hasPermission('mod-penetapannonnominatifkp-listall')){
            return $instance->newQuery()
                ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id') //nambah ni
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt')
                // ->orderBy('idskpd')
                // ->orderBy('idjeniskp')
                // ->groupBy(\DB::raw('tmt,idjeniskp'))
                // ->groupBy('tmt')
                // ->groupBy('idskpd')
                // ->groupBy('idjeniskp')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )//nambah di select
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id') //nambah ni jg
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt')
                // ->orderBy('idskpd')
                // ->orderBy('idjeniskp') //
                // ->groupBy('tmt')
                // ->groupBy('idskpd')
                // ->groupBy('idjeniskp')
                ->where('tr_kenaikan_pangkat.role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    /*function combo jenis pensiun*/
    public static function comboGolru($id="idgolru",$sel="",$required="", $class="", $idx="1"){
        $ret = '<select data-id="'.$idx.$id.'" id="idgolru" idx="'.$idx.'"  name="'.$idx.$id.'"  $required style="width: 100%;" class="form-control '.$class.' idgolru">';
        $ret.= '<option value="">.: Pilihan :.</option>';

        $rs = \DB::table('a_golruang')->orderBy('idgolru', 'asc')->get();
        foreach($rs as $item){
            $isSel = (($item->idgolru==$sel)?"selected":"");
            $ret.= '<option value="'.$item->idgolru.'" '.$isSel.' >'.$item->golru.'</option>';
        }
        $ret.='</select>';
        return $ret;
    }

    /*cobo list jenis KP*/
    public static function comboJeniskp($id="idjeniskp",$sel="",$required="", $class=""){
        $ret = '<select id="'.$id.'" name="'.$id.'"  $required style="width: 100%;" class="form-control '.$class.'">';
        $ret.= '<option value="">.: Pilihan :.</option>';

        $rs = \DB::table('a_jenis_kp')->orderBy('id','asc')->get();//->where('id', '!=', '1')
        foreach($rs as $item){
            $isSel = (($item->id==$sel)?"selected":"");
            $ret.= '<option value="'.$item->id.'" '.$isSel.' >'.$item->jenis_kp.'</option>';
        }
        $ret.='</select>';
        return $ret;
    }

    
}
