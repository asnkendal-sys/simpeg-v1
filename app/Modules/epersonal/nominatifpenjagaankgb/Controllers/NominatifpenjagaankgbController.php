<?php namespace App\Modules\epersonal\nominatifpenjagaankgb\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpenjagaankgb\Models\NominatifpenjagaankgbModel;
use Input,View, Request, Form, File;

/**
* Nominatifpenjagaankgb Controller
* @var Nominatifpenjagaankgb
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpenjagaankgbController extends Controller {
    protected $nominatifpenjagaankgb;

    public function __construct(NominatifpenjagaankgbModel $nominatifpenjagaankgb){
        $this->nominatifpenjagaankgb = $nominatifpenjagaankgb;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpenjagaankgbs = $this->nominatifpenjagaankgb
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
                $nominatifpenjagaankgbs = $this->nominatifpenjagaankgb->all();
            }
        }else{
            $nominatifpenjagaankgbs = $this->nominatifpenjagaankgb->all();
        }
        return View::make('nominatifpenjagaankgb::index', compact('nominatifpenjagaankgbs'));
    }

    //{controller-show}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankgb::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankgb::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaankgb::'.$view.'_excel');
    }
}
