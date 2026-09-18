<?php namespace App\Modules\epersonal\rekapkenaikanpangkat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\rekapkenaikanpangkat\Models\RekapkenaikanpangkatModel;
use Input,View, Request, Form, File;

class RekapkenaikanpangkatController extends Controller {

	/**
	 * Rekapkenaikanpangkat Repository
	 *
	 * @var Rekapkenaikanpangkat
	 */
	protected $rekapkenaikanpangkat;

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
		return View::make('rekapkenaikanpangkat::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('rekapkenaikanpangkat::create');
	}

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rekapkenaikanpangkat::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('rekapkenaikanpangkat::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('rekapkenaikanpangkat::'.$view.'_excel');
    }
}
