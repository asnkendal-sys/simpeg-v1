<?php namespace App\Modules\pppk\pengangkatankontrak\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pppk\pengangkatankontrak\Models\PengangkatankontrakModel;
use Input,View, Request, Form, File, Session;
use App\Models\PPPK\RPPPK;


class PengangkatankontrakController extends Controller {
    protected $pengangkatankontrak;

    public function __construct(PengangkatankontrakModel $pengangkatankontrak){
        $this->pengangkatankontrak = $pengangkatankontrak;
    }

    public function getIndex(){
        cekAjax();
        $where .=" nip != ''";
        if((strlen(Input::has('search')) > 0) or (strlen(Input::get('idskpd')) != '')){
            (Input::get('search')!='')?$where.=" and nip = '".Input::get('search')."'":"";
            (Input::get('idskpd')!='')?$where.=" and idskpd LIKE '".Input::get('idskpd')."%'":"";
        }

        $rpppk = RPPPK::with([
                'pegawai' => function($query) {
                    $query->aktif();
                }])
            ->whereRaw($where)
            ->where('sts_kontrak','=',1)
            ->orderBy('file_excel')
             ->orderBy('tmtawal', 'desc')
            ->orderBy('idskpd')
            ->orderBy('no_urut');

        if (Session::get('role_id') > 3) {
            $rpppk = $rpppk
                ->whereRaw($where)
                ->where('sts_kontrak','=',1)
                ->where('r_pppk.idskpd','like', Session::get('idskpd')."%")
                ->orderBy('file_excel')
                ->orderBy('tmtawal', 'desc')
                ->orderBy('idskpd')
                ->orderBy('no_urut');
        }

        $rpppk = $rpppk->paginate(10);

        return View::make('pengangkatankontrak::index', compact('rpppk'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('pengangkatankontrak::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PengangkatankontrakModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->pengangkatankontrak->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $pengangkatankontrak = $this->pengangkatankontrak->find($id);
        //if (is_null($pengangkatankontrak)){return \Redirect::to('pppk/pengangkatankontrak/index');}
        return View::make('pengangkatankontrak::edit', compact('pengangkatankontrak'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PengangkatankontrakModel::$rules);
        
        if ($validation->passes()){
            $pengangkatankontrak = $this->pengangkatankontrak->find($id);
            echo ($pengangkatankontrak->update($input))?4:"Gagal Disimpan";
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
                $this->pengangkatankontrak->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->pengangkatankontrak->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    public function getCetak(){
        if (Session::get('role_id') < 3) {
            $view = Request::segment(4);
            $id = Request::segment(5);
            $item = null;
            $tmtawal = Request::segment(7);
            $kdunit = Request::segment(6);

            if($id == "kolektif"){
                $item = \App\Models\PPPK\RPPPK::where('tmtawal','=',$tmtawal)
                    ->where('kdunit','=', $kdunit)->get();
            }else{
                $item = \App\Models\PPPK\RPPPK::where('id','=',$id)->first();
            }

            return View::make('pengangkatankontrak::'.$view.'_print',compact('item','id'));    
        }else{
            abort(404);
        }
    }

    public function getEditspinduk()
    {
        cekAjax();
        return View::make('pengangkatankontrak::editspinduk');
    }

    public function postSimpanspinduk()
    {
        cekAjax();
        
        $rpppk = RPPPK::find(Input::get('id'));
        
        if (!empty($rpppk)) {
            if (Input::get('tipe') == 'kolektif') {
                $rpppks = RPPPK::
                    where('sts_kontrak','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)
                    ->where('file_excel','=',$rpppk->file_excel)
                    ->update([
                        'no_sp_induk' => Input::get('no_sp_induk'),
                        'tgl_sp_induk' => Input::get('tgl_sp_induk')
                    ]);

                return 1;
            }else{
                $rpppk->no_sp_induk = Input::get('no_sp_induk');
                $rpppk->tgl_sp_induk = Input::get('tgl_sp_induk');
                return $rpppk->save()?1:0;
            }
        }
        return 0;
    }

    public function getEditspkinduk()
    {
        cekAjax();
        return View::make('pengangkatankontrak::editspkinduk');
    }

    public function postSimpanspkinduk()
    {
        cekAjax();
        
        $rpppk = RPPPK::find(Input::get('id'));
        
        if (!empty($rpppk)) {
            if (Input::get('tipe') == 'kolektif') {
                $rpppks = RPPPK::
                    where('sts_kontrak','=',1)
                    ->where('tmtawal','=',$rpppk->tmtawal)
                    ->where('file_excel','=',$rpppk->file_excel)
                    ->update([
                        'no_spk_induk' => Input::get('no_spk_induk'),
                        'tgl_spk_induk' => Input::get('tgl_spk_induk')
                    ]);

                return 1;
            }else{
                $rpppk->no_spk_induk = Input::get('no_spk_induk');
                $rpppk->tgl_spk_induk = Input::get('tgl_spk_induk');
                return $rpppk->save()?1:0;
            }
        }
        return 0;
    }
}
