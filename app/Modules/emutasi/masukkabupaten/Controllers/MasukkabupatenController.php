<?php namespace App\Modules\emutasi\masukkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\masukkabupaten\Models\MasukkabupatenModel;
use Input,View, Request, Form, File;

class MasukkabupatenController extends Controller {

	/**
	 * Masukkabupaten Repository
	 *
	 * @var Masukkabupaten
	 */
	protected $masukkabupaten;

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
		return View::make('masukkabupaten::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('masukkabupaten::create');
	}
}
