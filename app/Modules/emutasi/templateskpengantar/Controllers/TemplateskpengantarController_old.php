<?php namespace App\Modules\emutasi\templateskpengantar\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\templateskpengantar\Models\TemplateskpengantarModel;
use Input,View, Request, Form, File;

/**
* Templateskpengantar Controller
* @var Templateskpengantar
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskpengantarController extends Controller {
    protected $templateskpengantar;

    public function __construct(TemplateskpengantarModel $templateskpengantar){
        $this->templateskpengantar = $templateskpengantar;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templateskpengantars = $this->templateskpengantar
                			->orWhere('jnssurat', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('template', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('author', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tgin', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templateskpengantars = $this->templateskpengantar->all();
            }
        }else{
            $templateskpengantars = $this->templateskpengantar->all();
        }
        return View::make('templateskpengantar::index', compact('templateskpengantars'));
    }


    

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templateskpengantar::'.$view.'_data');
    }

    /*function save template mutasi antar skpd*/
    function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = Input::get('idskpd');
        if($dt['idskpd']=="")
        {
            $dt['idskpd'] = "all";
        }
        $dt['jnssurat'] = Input::get('jnssurat');

        $rs = \DB::table('tr_mutasi_template_sk')->where($dt)->first();
        if(count($rs) > 0){
            $data['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '2.1'){
                $data['template'] = Input::get('template');
            }else if($dt['jnssurat'] == '2.2'){
                $data['template'] = Input::get('template2');
            }else if($dt['jnssurat'] == '2.3'){
                $data['template'] = Input::get('template3');
            }else if($dt['jnssurat'] == '2.4'){
                $data['template'] = Input::get('template4');
            }else if($dt['jnssurat'] == '2.5'){
                $data['template'] = Input::get('template5');
            }else if($dt['jnssurat'] == '2.6'){
                $data['template'] = Input::get('template6');
            }else if($dt['jnssurat'] == '2.7'){
                $data['template'] = Input::get('template7');
            }else if($dt['jnssurat'] == '2.8'){
                $data['template'] = Input::get('template8');
            }else if($dt['jnssurat'] == '2.9'){
                $data['template'] = Input::get('template9');
            }else if($dt['jnssurat'] == '2.0.1'){
                $data['template'] = Input::get('template10');
            }else if($dt['jnssurat'] == '2.2.1'){
                $data['template'] = Input::get('template11');
            }

            echo (\DB::table('tr_mutasi_template_sk')->where($dt)->update($data))?4:"Gagal Disimpan";
        }else{
            $dt['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '2.1'){
                $dt['template'] = Input::get('template');
            }else if($dt['jnssurat'] == '2.2'){
                $dt['template'] = Input::get('template2');
            }else if($dt['jnssurat'] == '2.3'){
                $dt['template'] = Input::get('template3');
            }else if($dt['jnssurat'] == '2.4'){
                $dt['template'] = Input::get('template4');
            }else if($dt['jnssurat'] == '2.5'){
                $dt['template'] = Input::get('template5');
            }else if($dt['jnssurat'] == '2.6'){
                $dt['template'] = Input::get('template6');
            }else if($dt['jnssurat'] == '2.7'){
                $dt['template'] = Input::get('template7');
            }else if($dt['jnssurat'] == '2.8'){
                $dt['template'] = Input::get('template8');
            }else if($dt['jnssurat'] == '2.9'){
                $dt['template'] = Input::get('template9');
            }else if($dt['jnssurat'] == '2.0.1'){
                $data['template'] = Input::get('template10');
            }else if($dt['jnssurat'] == '2.2.1'){
                $data['template'] = Input::get('template11');
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
            $rs['nama'] = TemplateskpengantarModel::getTemplate($idskpd, $jnssurat, 'nama');
            $rs['template'] = TemplateskpengantarModel::getTemplate($idskpd, $jnssurat, 'template');
        }else{
            $rs['nama'] = TemplateskpengantarModel::getTemplate('all', $jnssurat, 'nama');
            $rs['template'] = TemplateskpengantarModel::getTemplate('all', $jnssurat, 'template');
        }

        echo json_encode($rs);
    }
	
    
}
