<?php namespace App\Modules\epersonal\nominatifpenjagaanulangtahun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpenjagaanulangtahun\Models\NominatifpenjagaanulangtahunModel;
use Input,View, Request, Form, File;

/**
* Nominatifpenjagaanulangtahun Controller
* @var Nominatifpenjagaanulangtahun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaanulangtahunController extends Controller {
    protected $nominatifpenjagaanulangtahun;

    public function __construct(NominatifpenjagaanulangtahunModel $nominatifpenjagaanulangtahun){
        $this->nominatifpenjagaanulangtahun = $nominatifpenjagaanulangtahun;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpenjagaanulangtahuns = $this->nominatifpenjagaanulangtahun
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
                $nominatifpenjagaanulangtahuns = $this->nominatifpenjagaanulangtahun->all();
            }
        }else{
            $nominatifpenjagaanulangtahuns = $this->nominatifpenjagaanulangtahun->all();
        }
        return View::make('nominatifpenjagaanulangtahun::index', compact('nominatifpenjagaanulangtahuns'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanulangtahun::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanulangtahun::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanulangtahun::'.$view.'_excel');
    }
}
