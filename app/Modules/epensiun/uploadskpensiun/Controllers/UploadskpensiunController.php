<?php namespace App\Modules\epensiun\uploadskpensiun\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\epensiun\uploadskpensiun\Models\UploadskpensiunModel;
use Input,View, Form, File;
use Illuminate\Support\Facades\Validator;

class UploadskpensiunController extends Controller {

	/**
	 * Uploadskpensiun Repository
	 *
	 * @var Uploadskpensiun
	 */
	protected $uploadskpensiun;

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
		// cekAjax();
		// return View::make('uploadskpensiun::index');

		$pegawais = \DB::table('tb_01')->whereRaw(' file_pensiun!="" ')->get();
        return View::make('uploadskpensiun::index', compact('pegawais'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function postUploadfiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'files.*' => 'required|file|mimes:pdf,jpg,jpeg|max:2048',
		]);
		
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

        $uploadedFiles = $request->file('files');
        $errors = [];

        foreach ($uploadedFiles as $file) {
            // Ambil nama file tanpa ekstensi, misalnya: "123456789012.pdf"
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Cari pegawai berdasarkan NIP (asumsi nama file adalah NIP)
            $pegawai = \DB::table("tb_01")->where('nip', $filename)->first();
			

            if ($pegawai) {
                // Simpan file di storage
                $path = $file->storeAs('sk_pensiun', $file->getClientOriginalName());

                // Update data pegawai
                $pegawai->update([
                    'status_pensiun' => 99,
                    'file_pensiun' => $path,
                ]);
            } else {
                // Tambahkan ke daftar error jika pegawai tidak ditemukan
                $errors[] = $filename;
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['error' => 'Beberapa NIP tidak ditemukan: ' . implode(', ', $errors)]);
        }

        return back()->with('success', 'Semua file berhasil diunggah.');
    }
}
