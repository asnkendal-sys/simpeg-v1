<?php namespace App\Modules\epersonal\biodatapegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\biodatapegawai\Models\BiodatapegawaiModel;
use Input,View, Request, Form, File;

class BiodatapegawaiController extends Controller {

	/**
	 * Biodatapegawai Repository
	 *
	 * @var Biodatapegawai
	 */
	protected $biodatapegawai;

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
		return View::make('biodatapegawai::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('biodatapegawai::create');
	}
}
