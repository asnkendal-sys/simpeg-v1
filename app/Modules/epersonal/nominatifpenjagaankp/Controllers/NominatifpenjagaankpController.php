<?php namespace App\Modules\epersonal\nominatifpenjagaankp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpenjagaankp\Models\NominatifpenjagaankpModel;
use Input,View, Request, Form, File;

/**
* Nominatifpenjagaankp Controller
* @var Nominatifpenjagaankp
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaankpController extends Controller {
    protected $nominatifpenjagaankp;

    public function __construct(NominatifpenjagaankpModel $nominatifpenjagaankp){
        $this->nominatifpenjagaankp = $nominatifpenjagaankp;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpenjagaankps = $this->nominatifpenjagaankp
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
                $nominatifpenjagaankps = $this->nominatifpenjagaankp->all();
            }
        }else{
            $nominatifpenjagaankps = $this->nominatifpenjagaankp->all();
        }
        return View::make('nominatifpenjagaankp::index', compact('nominatifpenjagaankps'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankp::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankp::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankp::'.$view.'_excel');
    }
}
