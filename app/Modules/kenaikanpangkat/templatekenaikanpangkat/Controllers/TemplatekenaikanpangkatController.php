<?php namespace App\Modules\kenaikanpangkat\templatekenaikanpangkat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\templatekenaikanpangkat\Models\TemplatekenaikanpangkatModel;
use Input,View, Request, Form, File;

/**
 * Templatekenaikanpangkat Controller
 * @var Templatekenaikanpangkat
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Divisi Software Development - Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class TemplatekenaikanpangkatController extends Controller {
    protected $templatekenaikanpangkat;

    public function __construct(TemplatekenaikanpangkatModel $templatekenaikanpangkat){
        $this->templatekenaikanpangkat = $templatekenaikanpangkat;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templatekenaikanpangkats = $this->templatekenaikanpangkats
                    ->orWhere('template', 'LIKE', '%'.Input::get('search').'%')
                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templatekenaikanpangkats = $this->templatekenaikanpangkat->all();
            }
        }else{
            $templatekenaikanpangkats = $this->templatekenaikanpangkat->all();
        }
        return View::make('templatekenaikanpangkat::index', compact('templatekenaikanpangkats'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('templatekenaikanpangkat::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TemplatekenaikanpangkatModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->templatekenaikanpangkat->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $templatekenaikanpangkat = $this->templatekenaikanpangkat->find($id);
        //if (is_null($templatekenaikanpangkat)){return \Redirect::to('kenaikanpangkat/templatekenaikanpangkat/index');}
        return View::make('templatekenaikanpangkat::edit', compact('templatekenaikanpangkat'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, TemplatekenaikanpangkatModel::$rules);

        if ($validation->passes()){
            $templatekenaikanpangkat = $this->templatekenaikanpangkat->find($id);
            echo ($templatekenaikanpangkat->update($input))?4:"Gagal Disimpan";
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
                $this->templatekenaikanpangkat->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->templatekenaikanpangkat->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk mendapatkan template berdasarkan idskpd*/
    public function postTemplate(){
        cekAjax();
        $idskpd = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $jnskp = Input::get('jnskp');

        $cek = \DB::table('tr_kenaikan_pangkat_template')->where('idskpd',$idskpd)->where('jnskp',$jnskp)->count();
        if($cek != 0){
            $rs['template'] = TemplatekenaikanpangkatModel::getTemplate($idskpd, $jnskp);
        }else{
            $rs['template'] = TemplatekenaikanpangkatModel::getTemplate('all', $jnskp);
        }

        echo json_encode($rs);
    }

    /*function untuk simpan template*/
    public function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $dt['jnskp'] = Input::get('jnskp');

        $cek = \DB::table('tr_kenaikan_pangkat_template')->where($dt)->count();
        if($cek === 0){
            if($dt['jnskp'] == '3'){
                $dt['template'] = Input::get('template');
            }else {
                $dt['template'] = Input::get('template2');
            }
            $insert = \DB::table('tr_kenaikan_pangkat_template')->insert($dt);
            echo ($insert)?1:"Gagal Disimpan";
        }else{
            if($dt['jnskp'] == '3'){
                $data['template'] = Input::get('template');
            }else {
                $data['template'] = Input::get('template2');
            }
            $update = \DB::table('tr_kenaikan_pangkat_template')->where($dt)->update($data);
            echo ($update)?1:"Gagal Disimpan";
        }
    }

    /*function untuk mendapatkan template surat*/
    function postSurat(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        $jnskp = Input::get('jnskp');

        $rs = \DB::table('tr_kenaikan_pangkat_template')->where(array('idskpd' => $idskpd, 'jnskp' => $jnskp))->get();
        if(count($rs) > 0){
            $rs['template'] = TemplatekenaikanpangkatModel::getTemplate($idskpd, $jnskp);
        }else{
            $rs['template'] = TemplatekenaikanpangkatModel::getTemplate('all', $jnskp);
        }

        echo json_encode($rs);
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templatekenaikanpangkat::'.$view.'_data');
    }

}
