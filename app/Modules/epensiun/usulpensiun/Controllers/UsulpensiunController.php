<?php namespace App\Modules\epensiun\usulpensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\usulpensiun\Models\UsulpensiunModel;
use Input,View, Request, Form, File;

class UsulpensiunController extends Controller {

	/**
	 * Usulpensiun Repository
	 *
	 * @var Usulpensiun
	 */
	protected $usulpensiun;

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
		return View::make('usulpensiun::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('usulpensiun::create');
	}
}
