<?php namespace App\Modules\ecuti\rekapcuti\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ecuti\rekapcuti\Models\RekapcutiModel;
use Input,View, Request, Form, File;

class RekapcutiController extends Controller {

	/**
	 * Rekapcuti Repository
	 *
	 * @var Rekapcuti
	 */
	protected $rekapcuti;

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
		return View::make('rekapcuti::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('rekapcuti::create');
	}
}
