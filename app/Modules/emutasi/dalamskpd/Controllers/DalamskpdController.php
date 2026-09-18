<?php namespace App\Modules\emutasi\dalamskpd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\dalamskpd\Models\DalamskpdModel;
use Input,View, Request, Form, File;

class DalamskpdController extends Controller {

	/**
	 * Dalamskpd Repository
	 *
	 * @var Dalamskpd
	 */
	protected $dalamskpd;

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
		return View::make('dalamskpd::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('dalamskpd::create');
	}
}
