<?php namespace App\Modules\ecuti\templateskcuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\templateskcuti\Models\TemplateskcutiModel;
use Input,View, Request, Form, File;

/**
* Templateskcuti Controller
* @var Templateskcuti
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskcutiController extends Controller {
    protected $templateskcuti;

    public function __construct(TemplateskcutiModel $templateskcuti){
        $this->templateskcuti = $templateskcuti;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templateskcutis = $this->templateskcuti
                ->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('template', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templateskcutis = $this->templateskcuti->all();
            }
        }else{
            $templateskcutis = $this->templateskcuti->all();
        }
        return View::make('templateskcuti::index', compact('templateskcutis'));
    }


    

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templateskcuti::'.$view.'_data');
    }

    /*function save template mutasi luar daerah*/
    function postSavetemplatecuti(){
        cekAjax();
        $dt['idskpd'] = Input::get('idskpd');
        if($dt['idskpd']=="")
        {
            $dt['idskpd'] = "all";
        }
        $dt['jnssurat'] = Input::get('jnssurat');

        $rs = \DB::table('tr_ijin_cuti_template_sk')->where($dt)->first();

        if(count($rs) > 0){
            $data['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '1.1'){
                $data['template'] = Input::get('templatecuti1');
            }else if($dt['jnssurat'] == '1.2'){
                $data['template'] = Input::get('templatecuti2');
            }

            echo (\DB::table('tr_ijin_cuti_template_sk')->where($dt)->update($data))?4:"Gagal Disimpan";
        }else{
            $dt['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '1.1'){
                $dt['template'] = Input::get('templatecuti1');
            }else if($dt['jnssurat'] == '1.2'){
                $dt['template'] = Input::get('templatecuti2');
            }

            echo (\DB::table('tr_ijin_cuti_template_sk')->insert($dt))?4:"Gagal Disimpan";
        }
    }

    /*function untuk mendapatkan template surat*/
    function postSurat(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        $jnssurat = Input::get('jnssurat');

        $rs = \DB::table('tr_ijin_cuti_template_sk')->where(array('idskpd' => $idskpd, 'jnssurat' => $jnssurat))->get();
        if(count($rs) > 0){
            $rs['nama'] = TemplateskcutiModel::getTemplatecuti($idskpd, $jnssurat, 'nama');
            $rs['template'] = TemplateskcutiModel::getTemplatecuti($idskpd, $jnssurat, 'template');
        }else{
            $rs['nama'] = TemplateskcutiModel::getTemplatecuti('all', $jnssurat, 'nama');
            $rs['template'] = TemplateskcutiModel::getTemplatecuti('all', $jnssurat, 'template');
        }

        echo json_encode($rs);
    }

    
}
