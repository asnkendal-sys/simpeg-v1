<?php namespace App\Modules\webservices\riwayatdiklat\Controllers;

use App\Http\Controllers\Controller;
use Input,View, Request, Form, File;
use App\Models\Pegawai;
use App\Models\Riwayat\DiklatTeknis;
use App\Models\Riwayat\DiklatFungsional;
use App\Models\Riwayat\DiklatStruktural;
use App\Services\RiwayatDiklatService;

class RiwayatdiklatController extends Controller {

	public function getIndex()
	{
		cekAjax();

		if(Input::get('jenis_diklat') == 'fungsional'){
			$data['diklat'] = DiklatFungsional::ofTahun(Input::has('tahun') ? Input::get('tahun') : '2020')
				->belumSAPK();
		}else if(Input::get('jenis_diklat') == 'struktural'){
			$data['diklat'] = DiklatStruktural::ofTahun(Input::has('tahun') ? Input::get('tahun') : '2020')
				->belumSAPK();
		}else{
			$data['diklat'] = DiklatTeknis::ofTahun(Input::has('tahun') ? Input::get('tahun') : '2020')
				->belumSAPK();
		}

		if (Input::has('search')) {
			$search = Input::get('search');
			$pegawai = Pegawai::select('nip')->where('nip','like','%'.$search.'%')->orWhere('nama','like','%'.$search.'%')->get()->toArray();
			if(!empty($pegawai)){
				$data['diklat'] = $data['diklat']->whereIn('nip',$pegawai);
			}
		}

		$data['diklat'] = $data['diklat']->paginate(10);
		
		return View::make('riwayatdiklat::index',compact('data'));
	}

	public function postKirimsapk()
	{
		cekAjax();
	    $riwayat = new RiwayatDiklatService;

	    return $riwayat->kirimDiklatBKN(Input::get('jenis_diklat'),Input::get('id'));// == 1?1:0;	   
    }

	public function getSinkronRiwayat()
	{
		// $diktek = App\Models\Riwayat\DiklatTeknis::
		// 			->where('tglmul', '!=', '')
  //                   ->orWhereNotNull('tglmul')
  //                   ->where(function ($query)
  //                   {
  //                   	$query->where('idsapk', '=', '')
		//                     ->orWhereNull('idsapk');
  //                   })
	}

	public function sendsapkbyidskpd($idskpd = '')
	{
		// $pegawai = App\Models\Pegawai::where('idskpd','like', $idskpd.'%')->aktif()->get();
		// foreach($pegawai as $peg){

		// }
	}

	public function storeSapkByNIP($nip)
	{
	    if(nip != ''){
		    $diklat_teknis = App\Models\Riwayat\DiklatTeknis::where('nip','=',$nip)
		    	->where('idsapk','=','')
		    	->get();
		    foreach ($diklat_teknis as $key=>$diktek) {
			    $tgmul[$key] = date(date('Y'),strtotime($diktek->tgmul));
			    // if ($tgmul == "2020" && $tgmul == "2021") {
			    //     $diklat = new DiklatRepository;
			    //     $data = array(
			    //         "id" => null,
			    //         "jenisKursusId" => "",
			    //         "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
			    //         "pnsOrangId" => $pegawai->idsapk,
			    //         "namaKursus" => $diktek->nmdiktek,
			    //         "jumlahJam" => $diktek->jamhari,
			    //         "tanggalKursus" => date('d-m-Y' , strtotime($diktek->tgmul)),
			    //         "tahun" => $tgmul,
			    //         "institusiPenyelenggara" => $diktek->penyelenggara,
			    //         "jenisKursusSertipikat" => "T",
			    //         "nomorSertipikat" => $diktek->nosttpdiktek,
			    //         "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diktek->tgsel)),
			    //         "lokasiId" => $diktek->tmdiktek,
			    //         "pnsUserId" => $pegawai->idsapk
			    //     );
			    //     $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
			    //     $diktek->idsapk = @$ret['mapData']['rwKursusId'];
			    //     $diktek->save();
			    // }
		    }
		    dd($tgmul);
		}
		return "Selesai";
	}
}
