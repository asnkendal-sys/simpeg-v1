<?php namespace App\Modules\ecuti\penyesuaiankuotacuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\penyesuaiankuotacuti\Models\PenyesuaiankuotacutiModel;
use Input,View, Request, Form, File;

/**
* Penyesuaiankuotacuti Controller
* @var Penyesuaiankuotacuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PenyesuaiankuotacutiController extends Controller {
    protected $penyesuaiankuotacuti;

    public function __construct(PenyesuaiankuotacutiModel $penyesuaiankuotacuti){
        $this->penyesuaiankuotacuti = $penyesuaiankuotacuti;
    }

    public function getIndex(){
        cekAjax();
        $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' ";
        if(session('role_id') > 3){
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }else{
            $where.= " and tb_01.nip != ''";
        }
        if (Input::get('nip') != "" || Input::get('idskpd') !="" ) {
            (Input::get('nip')!='')?$where.=" and (tb_01.nip like '%".Input::get('nip')."%')":"";
            (Input::get('idskpd')!='' && \Session::get('role_id') != 4)?$where.=" and tb_01.idskpd LIKE '%".Input::get('idskpd')."%'":"";
            $penyesuaiankuotacutis = $this->penyesuaiankuotacuti
            ->select('tr_penyesuaian_cuti.*','tb_01.*',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'))
            ->leftjoin('tr_penyesuaian_cuti', 'tb_01.nip', '=', 'tr_penyesuaian_cuti.nip')
            ->whereRaw($where)
            ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
            ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $penyesuaiankuotacutis = $this->penyesuaiankuotacuti->all();
        }
        return View::make('penyesuaiankuotacuti::index', compact('penyesuaiankuotacutis'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('penyesuaiankuotacuti::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenyesuaiankuotacutiModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->penyesuaiankuotacuti->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        // $penyesuaiankuotacuti = $this->penyesuaiankuotacuti->find($id);
        //if (is_null($penyesuaiankuotacuti)){return \Redirect::to('ecuti/penyesuaiankuotacuti/index');}
        return View::make('penyesuaiankuotacuti::edit', compact('penyesuaiankuotacuti'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenyesuaiankuotacutiModel::$rules);
        
        if ($validation->passes()){
            $penyesuaiankuotacuti = $this->penyesuaiankuotacuti->find($id);
            echo ($penyesuaiankuotacuti->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->penyesuaiankuotacuti->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penyesuaiankuotacuti->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
