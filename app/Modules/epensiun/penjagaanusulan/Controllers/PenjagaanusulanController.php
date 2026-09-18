<?php namespace App\Modules\epensiun\penjagaanusulan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\penjagaanusulan\Models\PenjagaanusulanModel;
use Input,View, Request, Form, File;

class PenjagaanusulanController extends Controller {

	/**
	 * Penjagaanusulan Repository
	 *
	 * @var Penjagaanusulan
	 */
	protected $penjagaanusulan;

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
		return View::make('penjagaanusulan::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('penjagaanusulan::create');
	}
}
