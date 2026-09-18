<?php namespace App\Modules\epersonal\rekaphukdis\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\rekaphukdis\Models\RekaphukdisModel;
use Input,View, Request, Form, File;

/**
* Rekaphukdis Controller
* @var Rekaphukdis
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RekaphukdisController extends Controller {
    protected $rekaphukdis;

    public function __construct(RekaphukdisModel $rekaphukdis){
        $this->rekaphukdis = $rekaphukdis;
    }

        public function getIndex(){
            cekAjax();
            if (Input::has('search')) {
                if(strlen(Input::has('search')) > 0){
                    $rekaphukdiss = $this->rekaphukdis
                    			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
    			->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                    ->paginate($_ENV['configurations']['list-limit']);
                }else{
                    $rekaphukdiss = $this->rekaphukdis->all();
                }
            }else{
                $rekaphukdiss = $this->rekaphukdis->all();
            }
            return View::make('rekaphukdis::index', compact('rekaphukdiss'));
        }

        public function postData() {
            $view = Request::segment(4);
            $data = Input::all();
            $rs = RekaphukdisModel::getDatahukdis($data);
            $jumdata = count($rs);
            // print_r($rs);
            // exit();
            return View::make('rekaphukdis::'.$view.'_data', compact('rs'));
        }

        public function postPrint() {
            $view = Request::segment(4);
            $data = Input::all();
            $rs = RekaphukdisModel::getDatahukdis($data);
            $jumdata = count($rs);
            // print_r($rs);
            // exit();
            return View::make('rekaphukdis::'.$view.'_print', compact('rs'));
        }

        public function postExcel() {
            $view = Request::segment(4);
            $data = Input::all();
            $rs = RekaphukdisModel::getDatahukdis($data);
            $jumdata = count($rs);
            // print_r($rs);
            // exit();
            return View::make('rekaphukdis::'.$view.'_excel', compact('rs'));
        }
    

    //{controller-show}

    
	
    
}
