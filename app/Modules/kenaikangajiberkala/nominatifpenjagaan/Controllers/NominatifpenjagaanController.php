<?php namespace App\Modules\kenaikangajiberkala\nominatifpenjagaan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\nominatifpenjagaan\Models\NominatifpenjagaanModel;
use Input,View, Request, Form, File;

class NominatifpenjagaanController extends Controller {

	/**
	 * Nominatifpenjagaan Repository
	 *
	 * @var Nominatifpenjagaan
	 */
	protected $nominatifpenjagaan;

	public function __construct()
	{
	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		return View::make('nominatifpenjagaan::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('nominatifpenjagaan::create');
	}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpenjagaan::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaan::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpenjagaan::'.$view.'_excel');
    }
}
