<?php namespace App\Modules\webservices\keluarga\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\keluarga\Models\KeluargaModel;
use Input,View, Request, Form, File;

class KeluargaController extends Controller {

	/**
	 * Keluarga Repository
	 *
	 * @var Keluarga
	 */
	protected $keluarga;

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
		return View::make('keluarga::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('keluarga::create');
	}
}
