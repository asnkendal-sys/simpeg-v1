<?php namespace App\Modules\epersonal\nominatifpegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\nominatifpegawai\Models\NominatifpegawaiModel;
use Input,View, Request, Form, File;

/**
* Nominatifpegawai Controller
* @var Nominatifpegawai
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpegawaiController extends Controller {
    protected $nominatifpegawai;

    public function __construct(NominatifpegawaiModel $nominatifpegawai){
        $this->nominatifpegawai = $nominatifpegawai;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $nominatifpegawais = $this->nominatifpegawai
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
                $nominatifpegawais = $this->nominatifpegawai->all();
            }
        }else{
            $nominatifpegawais = $this->nominatifpegawai->all();
        }
        return View::make('nominatifpegawai::index', compact('nominatifpegawais'));
    }

    //{controller-show}
    
    /*function get tingkatan jabatan fungsional*/
    public function postTkjabfung(){
        cekAjax();
        $idtkjabfung = Input::get('idtkjabfung');
        echo comboTkjabfung("idjabfung",$idtkjabfung,"","");
    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpegawai::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpegawai::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpegawai::'.$view.'_excel');
    }
    
}
