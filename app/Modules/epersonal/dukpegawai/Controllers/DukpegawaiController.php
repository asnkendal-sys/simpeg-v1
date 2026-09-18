<?php namespace App\Modules\epersonal\dukpegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\dukpegawai\Models\DukpegawaiModel;
use Input,View, Request, Form, File;

/**
* Dukpegawai Controller
* @var Dukpegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class DukpegawaiController extends Controller {
    protected $dukpegawai;

    public function __construct(DukpegawaiModel $dukpegawai){
        $this->dukpegawai = $dukpegawai;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $dukpegawais = $this->dukpegawai
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
                $dukpegawais = $this->dukpegawai->all();
            }
        }else{
            $dukpegawais = $this->dukpegawai->all();
        }
        return View::make('dukpegawai::index', compact('dukpegawais'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('dukpegawai::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('dukpegawai::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('dukpegawai::'.$view.'_excel');
    }
	
    
}
