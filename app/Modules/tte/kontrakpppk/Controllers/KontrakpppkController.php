<?php namespace App\Modules\tte\kontrakpppk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\tte\kontrakpppk\Models\KontrakpppkModel;
use App\Models\Riwayat\TTE;
use App\Modules\tte\kenaikangaji\Models\KenaikangajiModel;
use Input,View, Request, Form, File;

/**
* Kontrakpppk Controller
* @var Kontrakpppk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class KontrakpppkController extends Controller {
    protected $kontrakpppk;

    public function __construct(KontrakpppkModel $kontrakpppk){
        $this->kontrakpppk = $kontrakpppk;
    }

    public function getIndex(){
        cekAjax();
        $jenis = 'PPPK';
        $where = "a.sts_kontrak = 2 and r_tte.jenis = \"".$jenis."\"";

        if (session('role_id') > 3) {
            $where .= ' and nip_pejabat ='.\Session::get('user_id');
        }

        if (Input::has('search') or Input::get('status_tte') != '' or Input::get('idgolru') != '') {
            if(strlen(Input::has('search')) > 0) {
                $where .=" and (a.nip like '%".Input::get('search')."%' or a.nama like '%".Input::get('search')."%')";
            }

            if (Input::get('status_tte') != '') {
                $where .= ' and proses ='.Input::get('status_tte');
            }    
           
            if (Input::get('idgolru') != '') {
                $where .= ' and idgolru ='.Input::get('idgolru');
            }

            $ttes = \DB::table('r_tte')
                ->select('a.*','r_tte.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppk as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idpppk')
                        ->on('r_tte.nip_pengusul','=','a.nip')
                        ->where('r_tte.jenis','=',$jenis);                    
                    })                    
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')
                    ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $ttes = KontrakpppkModel::all();
        }

        return View::make('kontrakpppk::index', compact('ttes'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('kontrakpppk::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KontrakpppkModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->kontrakpppk->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    //{controller-show}

    public function postData(){
        //$data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('kontrakpppk::'.$view.'_data', $data);
    }

    /* Function untuk menampilkan modal atribut surat pengantar*/
    public function getModalpreviewpppk() {
        cekAjax();
        $data = Input::get('data');
        
        $previews=TTE::whereIn('id',$data)->get();

        return View::make('kontrakpppk::previewpppk_modal', compact('data','previews'));
    }
}
