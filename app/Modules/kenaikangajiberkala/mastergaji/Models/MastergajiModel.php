<?php namespace App\Modules\kenaikangajiberkala\mastergaji\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Mastergaji Model
* @var Mastergaji
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MastergajiModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_gaji";

	public static $rules = array(
        'pkt' => 'required',
        'msk' => 'required',
        'gaji' => 'required',
        'tahun' => 'required',
        'status' => 'required',
		/*'dasarhukum' => 'required',
		'ket' => 'required',*/

    );

    public static $rules_mastergaji = array(
        'tahun' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-mastergaji-listall')){
			return $instance->newQuery()
                ->select('a_gaji.*','a_golruang.golru', 'a_golruang.pangkat')
                ->leftJoin('a_golruang', 'a_gaji.pkt', '=', 'a_golruang.idgolru')
                ->orderBy('a_gaji.tahun')
                ->orderBy('a_gaji.pkt')
                ->orderBy('a_gaji.msk')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->select('a_gaji.*','a_golruang.golru', 'a_golruang.pangkat')
            ->leftJoin('a_golruang', 'a_gaji.pkt', '=', 'a_golruang.idgolru')
            ->orderBy('a_gaji.tahun')
            ->orderBy('a_gaji.pkt')
            ->orderBy('a_gaji.msk')
			->where('a_gaji.role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function untuk masa kerja*/
    public static function masakerja($id='msk',$issel='',$required='required'){
        $ret = "<select name=\"".$id."\" id=\"".$id."\" class='form-control' $required>";
        $ret.= "<option value=''>.: Pilihan :.</option>";
        $i = 0;
        while($i <= 32){
            if(strlen($i) < 2){
                $msk = "0".$i;
            }else{
                $msk = $i;
            }
            $ret.= "<option value=\"".$msk."\" ".(($msk==$issel)?'selected':'').">".$msk."</option>";
            $i++;
        }
        $ret.= "</select>";

        return $ret;
    }

    /*function get tahun kgb pns aktif*/
    public static function getTahunkgb(){
        $rs = \DB::table('a_gaji')->where('status', 1)->groupBy('tahun')->first();
        return $rs->tahun;
    }

    /*function get tahun kgb p3k aktif*/
    public static function getTahunKgbP3k(){
        $rs = \DB::table('a_gaji_pppk')->where('status', 1)->groupBy('tahun')->first();
        return $rs->tahun;
    }

    /*function pilihan tahun master gaji*/
    public static function comboMastergaji($id="tahun",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('a_gaji')->orderBy('tahun','asc')->groupBy('tahun')->get();
        foreach($rs as $item){
            $isSel = (($item->tahun==$sel)?"selected":"");
            $ret.="<option value=\"".$item->tahun."\" $isSel >".$item->tahun."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    public static function comboMasterGajiP3k($id="tahun",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"\">.: Pilihan :.</option>";

        $rs = \DB::table('a_gaji_pppk')->orderBy('tahun','asc')->groupBy('tahun')->get();
        foreach($rs as $item){
            $isSel = (($item->tahun==$sel)?"selected":"");
            $ret.="<option value=\"".$item->tahun."\" $isSel >".$item->tahun."</option>";
        }
        $ret.="</select>";
        return $ret;
    }
}
