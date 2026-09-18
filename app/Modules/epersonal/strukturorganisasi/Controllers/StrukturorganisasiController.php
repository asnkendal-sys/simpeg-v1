<?php namespace App\Modules\Epersonal\Strukturorganisasi\Controllers;

use App\Http\Controllers\Controller;
use Input,View, Request, Form, File;

class StrukturorganisasiController extends Controller {

	/**
	 * Strukturorganisasi Repository
	 *
	 * @var Strukturorganisasi
	 */
	protected $strukturorganisasi;

	public function __construct()
	{
	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function getIndex(){
        cekAjax();
        return View::make('strukturorganisasi::index');
    }

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('strukturorganisasi::create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/*
		$input = Input::all();
		$validation = \Validator::make($input, StrukturorganisasiModel::$rules);

		if ($validation->passes())
		{
			$this->strukturorganisasi->create($input);

			return \Redirect::route('strukturorganisasi.index');
		}

		return \Redirect::route('strukturorganisasi.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
		*/	
	}


		/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$strukturorganisasi = $this->strukturorganisasi->findOrFail($id);
		//return View::make('strukturorganisasi::show', compact('strukturorganisasi'));
	}


		/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		/*
		$strukturorganisasi = $this->strukturorganisasi->find($id);

		if (is_null($strukturorganisasi))
		{
			return \Redirect::route('strukturorganisasi.index');
		}

		return View::make('strukturorganisasi::edit', compact('strukturorganisasi'));
		*/
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		/*
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Strukturorganisasi::$rules);

		if ($validation->passes())
		{
			$strukturorganisasi = $this->strukturorganisasi->find($id);
			$strukturorganisasi->update($input);

			return \Redirect::route('strukturorganisasi.index', $id);
		}

		return \Redirect::route('strukturorganisasi.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
		*/
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/*
		$this->strukturorganisasi->find($id)->delete();

		return \Redirect::route('strukturorganisasi.index');
		*/
	}

    public function postSotkview()
    {
        $idskpd = Input::get('idskpd');
        return View::make('strukturorganisasi::sotkview', compact('idskpd'));
    }
}
