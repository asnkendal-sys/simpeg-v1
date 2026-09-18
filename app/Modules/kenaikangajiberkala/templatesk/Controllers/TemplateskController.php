<?php namespace App\Modules\kenaikangajiberkala\templatesk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\templatesk\Models\TemplateskModel;
use Input,View, Request, Form, File;

/**
* Templatesk Controller
* @var Templatesk
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskController extends Controller {
    protected $templatesk;

    public function __construct(TemplateskModel $templatesk){
        $this->templatesk = $templatesk;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templatesks = $this->templatesk
                			->orWhere('template', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templatesks = $this->templatesk->all();
            }
        }else{
            $templatesks = $this->templatesk->all();
        }
        return View::make('templatesk::index', compact('templatesks'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('templatesk::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TemplateskModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->templatesk->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $templatesk = $this->templatesk->find($id);
        //if (is_null($templatesk)){return \Redirect::to('kenaikangajiberkala/templatesk/index');}
        return View::make('templatesk::edit', compact('templatesk'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, TemplateskModel::$rules);
        
        if ($validation->passes()){
            $templatesk = $this->templatesk->find($id);
            echo ($templatesk->update($input))?4:"Gagal Disimpan";
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
                $this->templatesk->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->templatesk->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk mendapatkan template berdasarkan idskpd*/
    public function postTemplate(){
        cekAjax();
        $idskpd = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $jnskgb = Input::get('jnskgb');

        $cek = \DB::table('tr_kgb_template')->where('idskpd',$idskpd)->where('jnskgb',$jnskgb)->count();
        if($cek != 0){
            $rs['template'] = TemplateskModel::getTemplate($idskpd, $jnskgb);
        }else{
            $rs['template'] = TemplateskModel::getTemplate('all', $jnskgb);
        }

        echo json_encode($rs);
    }

    /*function untuk simpan template*/
    public function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $dt['jnskgb'] = Input::get('jnskgb');

        $cek = \DB::table('tr_kgb_template')->where($dt)->count();
        if($cek === 0){
            if($dt['jnskgb'] == '3'){
                $dt['template'] = Input::get('template');
            }else {
                $dt['template'] = Input::get('template2');
            }
            $insert = \DB::table('tr_kgb_template')->insert($dt);
            echo ($insert)?1:"Gagal Disimpan";
        }else{
            if($dt['jnskgb'] == '3'){
                $data['template'] = Input::get('template');
            }else {
                $data['template'] = Input::get('template2');
            }
            $update = \DB::table('tr_kgb_template')->where($dt)->update($data);
            echo ($update)?1:"Gagal Disimpan";
        }
    }

    /*function untuk mendapatkan template surat*/
    function postSurat(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        $jnskgb = Input::get('jnskgb');

        $rs = \DB::table('tr_kgb_template')->where(array('idskpd' => $idskpd, 'jnskgb' => $jnskgb))->get();
        if(count($rs) > 0){
            $rs['template'] = TemplateskModel::getTemplate($idskpd, $jnskgb);
        }else{
            $rs['template'] = TemplateskModel::getTemplate('all', $jnskgb);
        }

        echo json_encode($rs);
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templatesk::'.$view.'_data');
    }
}
