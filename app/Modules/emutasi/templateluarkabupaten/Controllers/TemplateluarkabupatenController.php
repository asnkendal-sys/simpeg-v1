<?php namespace App\Modules\emutasi\templateluarkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\templateluarkabupaten\Models\TemplateluarkabupatenModel;
use Input,View, Request, Form, File;

/**
* Templateluarkabupaten Controller
* @var Templateluarkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateluarkabupatenController extends Controller {
    protected $templateluarkabupaten;

    public function __construct(TemplateluarkabupatenModel $templateluarkabupaten){
        $this->templateluarkabupaten = $templateluarkabupaten;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templateluarkabupatens = $this->templateluarkabupaten
                ->orWhere('jnssurat', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('template', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('author', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('tgin', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templateluarkabupatens = $this->templateluarkabupaten->all();
            }
        }else{
            $templateluarkabupatens = $this->templateluarkabupaten->all();
        }
        return View::make('templateluarkabupaten::index', compact('templateluarkabupatens'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('templateluarkabupaten::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TemplateluarkabupatenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->templateluarkabupaten->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $templateluarkabupaten = $this->templateluarkabupaten->find($id);
        //if (is_null($templateluarkabupaten)){return \Redirect::to('emutasi/templateluarkabupaten/index');}
        return View::make('templateluarkabupaten::edit', compact('templateluarkabupaten'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, TemplateluarkabupatenModel::$rules);
        
        if ($validation->passes()){
            $templateluarkabupaten = $this->templateluarkabupaten->find($id);
            echo ($templateluarkabupaten->update($input))?4:"Gagal Disimpan";
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
                $this->templateluarkabupaten->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->templateluarkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templateluarkabupaten::'.$view.'_data');
    }

    /*function save template mutasi luar daerah*/
    function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $dt['jnssurat'] = Input::get('jnssurat');

        $rs = \DB::table('tr_mutasi_template_sk')->where($dt)->first();

        if(count($rs) > 0){
            $data['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '3.1'){
                $data['template'] = Input::get('template');
            }else if($dt['jnssurat'] == '3.2'){
                $data['template'] = Input::get('template2');
            }else if($dt['jnssurat'] == '3.3'){
                $data['template'] = Input::get('template3');
            }else if($dt['jnssurat'] == '3.4'){
                $data['template'] = Input::get('template4');
            }else if($dt['jnssurat'] == '3.5'){
                $data['template'] = Input::get('template5');
            }else if($dt['jnssurat'] == '3.6'){
                $data['template'] = Input::get('template6');
            }

            echo (\DB::table('tr_mutasi_template_sk')->where($dt)->update($data))?4:"Gagal Disimpan";
        }else{
            $dt['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '3.1'){
                $dt['template'] = Input::get('template');
            }else if($dt['jnssurat'] == '3.2'){
                $dt['template'] = Input::get('template2');
            }else if($dt['jnssurat'] == '3.3'){
                $dt['template'] = Input::get('template3');
            }else if($dt['jnssurat'] == '3.4'){
                $dt['template'] = Input::get('template4');
            }else if($dt['jnssurat'] == '3.5'){
                $dt['template'] = Input::get('template5');
            }else if($dt['jnssurat'] == '3.6'){
                $dt['template'] = Input::get('template6');
            }

            echo (\DB::table('tr_mutasi_template_sk')->insert($dt))?4:"Gagal Disimpan";
        }
    }

    /*function untuk mendapatkan template surat*/
    function postSurat(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        $jnssurat = Input::get('jnssurat');

        $rs = \DB::table('tr_mutasi_template_sk')->where(array('idskpd' => $idskpd, 'jnssurat' => $jnssurat))->get();
        if(count($rs) > 0){
            $rs['nama'] = TemplateluarkabupatenModel::getTemplate($idskpd, $jnssurat, 'nama');
            $rs['template'] = TemplateluarkabupatenModel::getTemplate($idskpd, $jnssurat, 'template');
        }else{
            $rs['nama'] = TemplateluarkabupatenModel::getTemplate('all', $jnssurat, 'nama');
            $rs['template'] = TemplateluarkabupatenModel::getTemplate('all', $jnssurat, 'template');
        }

        echo json_encode($rs);
    }
}
