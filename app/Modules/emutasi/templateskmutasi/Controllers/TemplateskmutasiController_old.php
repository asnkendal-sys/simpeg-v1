<?php namespace App\Modules\emutasi\templateskmutasi\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\templateskmutasi\Models\TemplateskmutasiModel;
use Input,View, Request, Form, File;

/**
* Templateskmutasi Controller
* @var Templateskmutasi
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplateskmutasiController extends Controller {
    protected $templateskmutasi;

    public function __construct(TemplateskmutasiModel $templateskmutasi){
        $this->templateskmutasi = $templateskmutasi;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templateskmutasis = $this->templateskmutasi
                ->orWhere('jnssurat', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('template', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('author', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('tgin', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templateskmutasis = $this->templateskmutasi->all();
            }
        }else{
            $templateskmutasis = $this->templateskmutasi->all();
        }
        return View::make('templateskmutasi::index', compact('templateskmutasis'));
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templateskmutasi::'.$view.'_data');
    }

    /*function save template mutasi luar daerah*/
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
            if($dt['jnssurat'] == '1.2'){
                $data['template'] = Input::get('template3');
            }
            else if($dt['jnssurat'] == '1.3'){
                $data['template'] = Input::get('template1');
            }

            echo (\DB::table('tr_mutasi_template_sk')->where($dt)->update($data))?4:"Gagal Disimpan";
        }else{
            $dt['nama'] = Input::get('nama');
            if($dt['jnssurat'] == '1.2'){
                $dt['template'] = Input::get('template3');
            }
            else if($dt['jnssurat'] == '1.3'){
                $dt['template'] = Input::get('template1');
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
            $rs['nama'] = TemplateskmutasiModel::getTemplate($idskpd, $jnssurat, 'nama');
            $rs['template'] = TemplateskmutasiModel::getTemplate($idskpd, $jnssurat, 'template');
        }else{
            $rs['nama'] = TemplateskmutasiModel::getTemplate('all', $jnssurat, 'nama');
            $rs['template'] = TemplateskmutasiModel::getTemplate('all', $jnssurat, 'template');
        }

        echo json_encode($rs);
    }
}
