<?php namespace App\Modules\epersonal\daftarjabatankosong\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Daftarjabatankosong Model
* @var Daftarjabatankosong
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class DaftarjabatankosongModel extends Model {
	protected $guarded = array();

    protected $table = "a_skpd";
    protected $primaryKey = 'idskpd'; // or null

	public static $rules = array(
        'plt_nip' => 'required',
		'plt_nosk' => 'required',
		'plt_tgl' => 'required',
		'plt_tmt' => 'required',
    );

	public static function all($columns = array('*')){
		$instance = new static;
        $where = " ";
        if(session('role_id') > 3){
            $where.= " tb_01.idskpd like \"".session('idskpd')."%\" ";
        }

		if (\PermissionsLibrary::hasPermission('mod-daftarjabatankosong-listall')){
			return $instance->newQuery()
                ->select('a_skpd.idskpd','a_skpd.jab','a_skpd.path_short','a_esl.esl','tb_01.nip','a_skpd.flag',
                    'a_skpd.plt_nip','a_skpd.plt_nosk','a_skpd.plt_tgl','a_skpd.plt_tmt',
                    \DB::raw("d.golru AS golrumin"),
                    \DB::raw("e.golru AS golrumax"),
                    \DB::raw("CONCAT(IFNULL(a.gdp,''),' ',a.nama,IF(a.gdb IS NULL,'',CONCAT(', ',a.gdb))) AS namalengkap"),
                    \DB::raw("IF(tb_01.nip IS NOT NULL,DATE_FORMAT(tb_01.tmtjbt,'%d-%m-%Y'),'') AS tmtjbt")
                )
                ->leftjoin('tb_01', function($join){
                    $join->on('a_skpd.idskpd','=','tb_01.idjabjbt')
                        ->where('a_skpd.flag','=',1)
                        ->where('tb_01.idjenkedudupeg','!=',99)
                        ->where('tb_01.idjenkedudupeg','!=',21);
                })
                ->leftJoin('tb_01 as a', 'a_skpd.plt_nip', '=', 'a.nip')
                ->join('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
                ->join('a_golruang as d', 'a_esl.idgolrumin', '=', 'd.idgolru')
                ->join('a_golruang as e', 'a_esl.idgolrumax', '=', 'e.idgolru')
                ->whereRaw($where)
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->whereRaw($where)
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
