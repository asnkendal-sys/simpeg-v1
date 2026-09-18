<?php namespace App\Modules\emutasi\templateskpengangkatan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Templateskpengangkatan Model
* @var Templateskpengangkatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskpengangkatanModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_mutasi_template_sk";

	public static $rules = array(
    	'jnssurat' => 'required',
		'idskpd' => 'required',
		'nama' => 'required',
		'template' => 'required',
		'author' => 'required',
		'tgin' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-templateskpengangkatan-index')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

	/*function untuk mendapatkan default template*/
    public static function getTemplate($idskpd, $jnssurat, $fields){
        $row = \DB::table('tr_mutasi_template_sk')->where(array('idskpd'=>$idskpd, 'jnssurat'=>$jnssurat))->first();
        if(count($row) > 0){
            return $row->$fields;
        }else{
            //return "<br /><p style='text-align:center;margin:0;margin-top:.1cm;line-height:1em;font-size:15pt;'<center>Template Surat untuk OPD anda belum ada di database template. <br />Harap menyesuaikan format dan unit kerja pada menu template. Terimakasih</center></p>";
             return "0";
        }
    }

    /*function random character*/
    public static function rand_char(){
        $rs = \DB::select("
                SELECT CONCAT(
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1),
                SUBSTRING('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', RAND()*36+1, 1)
                ) AS rand_key;
            ");

        return $rs[0]->rand_key;
    }

    public static function attrPengantar($idskpd){
        $rs = \DB::table('tb_01 as a')
            ->select('a.nip','a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'c.golru', 'c.pangkat',
                    \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama")
                )
            ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw("a.idjenkedudupeg NOT IN('99','21') and a.idskpd = \"".$idskpd."\"")
            ->first();

        if(count($rs) > 0){
            return $rs;
        }else{
            $rs = \DB::table('tb_01 as a')
                    ->select('a.nip','a.idskpd', 'a.idjenjab', 'a.idjabjbt', 'b.skpd', 'b.jab', 'c.golru', 'c.pangkat',
                    \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama")
                )
                ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
                ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
                ->whereRaw("a.idjenkedudupeg NOT IN('99','21') AND a.idtugasgurudosen = 1 AND a.idskpd = \"".$idskpd."\"")
                ->first();

            return $rs;
        }
    }

    /*function untuk mendapatkan penetap sk*/
    public static function getPenetap($idpenetap, $attr){
        $row = \DB::table('a_penetapsk')->where('id',$idpenetap)->first();

        if(count($row) > 0){
            return $row->$attr;
        }else{
            return "";
        }
    }

}
