<?php namespace App\Modules\webservices\jabatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\jabatan\Models\JabatanModel;
use Input,View, Request, Form, File;

class JabatanController extends Controller {

	/**
	 * Jabatan Repository
	 *
	 * @var Jabatan
	 */
	protected $jabatan;

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
		return View::make('jabatan::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('jabatan::create');
	}
}
