<?php namespace App\Modules\epensiun\unduhdokumendpcp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\unduhdokumendpcp\Models\UnduhdokumendpcpModel;
use Input,View, Request, Form, File;

class UnduhdokumendpcpController extends Controller {

	/**
	 * Unduhdokumendpcp Repository
	 *
	 * @var Unduhdokumendpcp
	 */
	protected $unduhdokumendpcp;

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
		return View::make('unduhdokumendpcp::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('unduhdokumendpcp::create');
	}
}
