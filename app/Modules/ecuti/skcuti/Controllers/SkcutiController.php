<?php namespace App\Modules\ecuti\skcuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\skcuti\Models\SkcutiModel;
use Input,View, Request, Form, File;

/**
* Skcuti Controller
* @var Skcuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class SkcutiController extends Controller {
    protected $skcuti;

    public function __construct(SkcutiModel $skcuti){
        $this->skcuti = $skcuti;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_ijin_cuti.nousul != '' ";
        if(session('role_id') > 3){
            $where .= " and tr_ijin_cuti.idskpd like \"".session('idskpd')."%\" ";
        }
        if(session('role_id') == 5){
            $where .= " and tr_ijin_cuti.nip like \"".session('user_id')."%\" ";
        }
        if (Input::has('search') or Input::get('bulan') != '' or Input::get('id_jenis_cuti') != '' or Input::get('idskpd') != '' ) {
            (Input::get('search')!='')?$where.=" and (tr_ijin_cuti.nip like '%".Input::get('search')."%' or tr_ijin_cuti.nama like '%".Input::get('search')."%')":"";
            (Input::get('bulan')!='')?$where.=" and month(tr_ijin_cuti.tgl_usul) = '".Input::get('bulan')."'":"";
            (Input::get('id_jenis_cuti')!='')?$where.=" and tr_ijin_cuti.id_jenis_cuti = '".Input::get('id_jenis_cuti')."'":"";
            (Input::get('idskpd')!='' && \Session::get('role_id') != 4)?$where.=" and tr_ijin_cuti.idskpd = '".Input::get('idskpd')."'":"";
            
            $skcutis = $this->skcuti
            ->select('tr_ijin_cuti.*',
                'a_golruang.golru','a_golruang.pangkat',
                'tb_01.nip','tb_01.idjenjab','tb_01.idskpd','tb_01.idjenjab',
                \DB::raw('tb_01.hp as telepon'),
                \DB::raw('IF(tb_01.idjenjab>4,b.jab,IF(tb_01.idjenjab=2,c.jabfung,IF(tb_01.idjenjab=3,d.jabfungum,IF(tb_01.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap')
            )
            ->join('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
            ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->leftjoin('a_skpd as b', 'tr_ijin_cuti.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'tb_01.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'tb_01.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as e', 'tb_01.idjabnonjob', '=', 'e.idjabnonjob')
            ->whereRaw($where)
            ->orderByRaw('tr_ijin_cuti.nousul DESC, tr_ijin_cuti.id ASC')
            ->paginate($_ENV['configurations']['list-limit']);
            
        }else{
            $skcutis = $this->skcuti->all();
        }
        return View::make('skcuti::index', compact('skcutis'));
    }
    /*function view Print atribut dari link */
    public function getPrint(){
        $view = Request::segment(4);
        return View::make('skcuti::'.$view.'_print');
    }
    /*function view Print atribut dari link */
    public function postCetak(){
        $view = Request::segment(4);
        return View::make('skcuti::'.$view.'_print');
    }
}
