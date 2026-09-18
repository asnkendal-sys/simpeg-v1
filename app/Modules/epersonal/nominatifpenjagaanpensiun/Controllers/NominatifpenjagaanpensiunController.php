<?php namespace App\Modules\epersonal\nominatifpenjagaanpensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpenjagaanpensiun\Models\NominatifpenjagaanpensiunModel;
use Input,View, Request, Form, File;

/**
* Nominatifpenjagaanpensiun Controller
* @var Nominatifpenjagaanpensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaanpensiunController extends Controller {
    protected $nominatifpenjagaanpensiun;

    public function __construct(NominatifpenjagaanpensiunModel $nominatifpenjagaanpensiun){
        $this->nominatifpenjagaanpensiun = $nominatifpenjagaanpensiun;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpenjagaanpensiuns = $this->nominatifpenjagaanpensiun
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
                $nominatifpenjagaanpensiuns = $this->nominatifpenjagaanpensiun->all();
            }
        }else{
            $nominatifpenjagaanpensiuns = $this->nominatifpenjagaanpensiun->all();
        }
        return View::make('nominatifpenjagaanpensiun::index', compact('nominatifpenjagaanpensiuns'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanpensiun::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanpensiun::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaanpensiun::'.$view.'_excel');
    }
}
