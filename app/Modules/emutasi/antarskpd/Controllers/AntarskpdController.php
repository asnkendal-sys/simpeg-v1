<?php namespace App\Modules\emutasi\antarskpd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\antarskpd\Models\AntarskpdModel;
use Input,View, Request, Form, File;

class AntarskpdController extends Controller {

	/**
	 * Antarskpd Repository
	 *
	 * @var Antarskpd
	 */
	protected $antarskpd;

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
		return View::make('antarskpd::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('antarskpd::create');
	}
}
