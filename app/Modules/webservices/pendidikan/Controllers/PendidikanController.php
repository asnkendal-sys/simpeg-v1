<?php namespace App\Modules\webservices\pendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\pendidikan\Models\PendidikanModel;
use Input,View, Request, Form, File;

class PendidikanController extends Controller {

	/**
	 * Pendidikan Repository
	 *
	 * @var Pendidikan
	 */
	protected $pendidikan;

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
		return View::make('pendidikan::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('pendidikan::create');
	}
}
