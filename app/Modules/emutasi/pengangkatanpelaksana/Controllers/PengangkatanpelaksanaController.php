<?php namespace App\Modules\emutasi\pengangkatanpelaksana\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\pengangkatanpelaksana\Models\PengangkatanpelaksanaModel;
use Input,View, Request, Form, File;

class PengangkatanpelaksanaController extends Controller {

	/**
	 * Pengangkatanpelaksana Repository
	 *
	 * @var Pengangkatanpelaksana
	 */
	protected $pengangkatanpelaksana;

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
		return View::make('pengangkatanpelaksana::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('pengangkatanpelaksana::create');
	}
}
