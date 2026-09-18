<?php namespace App\Modules\epersonal\mekanismepegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\mekanismepegawai\Models\MekanismepegawaiModel;
use Input,View, Request, Form, File;

/**
* Mekanismepegawai Controller
* @var Mekanismepegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MekanismepegawaiController extends Controller {
    protected $mekanismepegawai;

    public function __construct(MekanismepegawaiModel $mekanismepegawai){
        $this->mekanismepegawai = $mekanismepegawai;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $mekanismepegawais = $this->mekanismepegawai
                			->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $mekanismepegawais = $this->mekanismepegawai->all();
            }
        }else{
            $mekanismepegawais = $this->mekanismepegawai->all();
        }
        return View::make('mekanismepegawai::index', compact('mekanismepegawais'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('mekanismepegawai::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('mekanismepegawai::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('mekanismepegawai::'.$view.'_excel');
    }

    function postFilter(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        return View::make('mekanismepegawai::mekenismedata', compact('idskpd'));
    }
}
