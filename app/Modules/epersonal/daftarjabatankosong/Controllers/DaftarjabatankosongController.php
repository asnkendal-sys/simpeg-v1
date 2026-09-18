<?php namespace App\Modules\epersonal\daftarjabatankosong\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\daftarjabatankosong\Models\DaftarjabatankosongModel;
use Input,View, Request, Form, File;

/**
* Daftarjabatankosong Controller
* @var Daftarjabatankosong
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class DaftarjabatankosongController extends Controller {
    protected $daftarjabatankosong;

    public function __construct(DaftarjabatankosongModel $daftarjabatankosong){
        $this->daftarjabatankosong = $daftarjabatankosong;
    }

    public function getIndex(){
        cekAjax();
        $where = 'tb_01.nip IS NULL';
        if (Input::has('idskpd')) {
            $where .= " and a_skpd.idskpd like \"".Input::get('idskpd')."%\"";
        }else{
            if(session('role_id') > 3){
                $where .= " and a_skpd.idskpd like \"".session('idskpd')."%\"";
            }
        }

        $daftarjabatankosongs = \DB::table('a_skpd')
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
            ->orderBy("a_skpd.idskpd", 'asc')->get();

        return View::make('daftarjabatankosong::index', compact('daftarjabatankosongs'));
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('daftarjabatankosong::'.$view);
    }

    //{controller-show}

    public function postPenetapan(){
        cekAjax();
        $input = Input::all();
        $id = Input::get('idskpd');
        $validation = \Validator::make($input, DaftarjabatankosongModel::$rules);
        if ($validation->passes()){
            $arrnot = array('','_token','id');
            $keydate = array('','plt_tgl','plt_tmt');

            foreach($input as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    $val = explode("-",$value);
                    $value = $val[2]."-".$val[1]."-".$val[0];
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            $data['iduser'] = \Session::get('user_id');
            $data['plt_update'] = gmdate("Y-m-d H:i", time()+60*60*7);

            if(\DB::table('a_skpd')->where('idskpd', $id)->update($data)){
                echo "4";
            }else{
                echo "Data Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }
	
    public function postBatalkan(){
        cekAjax();
        $id = Input::get('idskpd');
        $data['plt_nip'] = '';
        $data['plt_nosk'] = '';
        $data['plt_tgl'] = '';
        $data['plt_tmt'] = '';
        $data['iduser'] = \Session::get('user_id');
        $data['plt_update'] = gmdate("Y-m-d H:i", time()+60*60*7);

        if(\DB::table('a_skpd')->where('idskpd', $id)->update($data)){
            echo "9";
        }else{
            echo "PLT Gagal Dibatalkan";
        }
    }

    function postEditpenetapan(){
        cekAjax();
        $idskpd = Input::get("idskpd");
        $rs = \DB::table('a_skpd as a')
            ->select(
                'a.plt_nip','a.plt_nosk','a.plt_tgl','a.plt_tmt',
                \DB::raw("CONCAT(IFNULL(b.gdp,''),' ',b.nama,IF(b.gdb IS NULL,'',CONCAT(', ',b.gdb))) AS namalengkap")
            )
            ->leftJoin('tb_01 as b', 'a.plt_nip', '=', 'b.nip')
            ->where('a.idskpd', $idskpd)->first();
        echo json_encode($rs);
    }


    function postExcel()
    {
    $idskpd = Input::get("idskpd");
        $view = Request::segment(4);
        return View::make('daftarjabatankosong::' . $view . '_excel');
        // echo "tello";
    }

}
