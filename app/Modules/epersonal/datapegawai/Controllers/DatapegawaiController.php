<?php namespace App\Modules\epersonal\datapegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\datapegawai\Models\DatapegawaiModel;
use Input,View, Request, Form, File;

class DatapegawaiController extends Controller {

	/**
	 * Datapegawai Repository
	 *
	 * @var Datapegawai
	 */
	protected $datapegawai;

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
		return View::make('datapegawai::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('datapegawai::create');
	}
}
