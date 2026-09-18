<?php

namespace App\Modules\tte\kontrakpppkpw\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\tte\kontrakpppkpw\Models\KontrakpppkpwModel;
use App\Models\Riwayat\TTE;
use App\Modules\tte\kenaikangaji\Models\KenaikangajiModel;

use Input, View, Request, Form, File;



class KontrakpppkpwController extends Controller
{
	protected $kontrakpppkpw;

	public function __construct(KontrakpppkpwModel $kontrakpppkpw)
	{
		$this->kontrakpppkpw = $kontrakpppkpw;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{

		cekAjax();
		$jenis = 'PPPKPW';
		$where = "a.sts_kontrak = 2 and r_tte.jenis = \"" . $jenis . "\"";

		if (session('role_id') > 3) {
			$where .= ' and nip_pejabat =' . \Session::get('user_id');
		}

		if (Input::has('search') or Input::get('status_tte') != '' or Input::get('idgolru') != '') {
            if(strlen(Input::has('search')) > 0) {
                $where .=" and (a.nip like '%".Input::get('search')."%' or a.nama like '%".Input::get('search')."%')";
            }

            if (Input::get('status_tte') != '') {
                $where .= ' and proses ='.Input::get('status_tte');
            }    
           
            if (Input::get('idgolru') != '') {
                $where .= ' and idgolru ='.Input::get('idgolru');
            }

            $ttes = \DB::table('r_tte')
                ->select('a.*','r_tte.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"))
                    ->join('tr_pppkpw as a', function($join)use($jenis){
                        $join->on('r_tte.id_sk', '=', 'a.idpppk')
                        ->on('r_tte.nip_pengusul','=','a.nip')
                        ->where('r_tte.jenis','=',$jenis);                    
                    })                    
                    ->whereRaw($where)
                    ->orderBy('tmtawal', 'desc')
                    ->orderBy('idskpd')
                    ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $ttes = KontrakpppkpwModel::all();
        }
		
        return View::make('kontrakpppkpw::index', compact('ttes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('kontrakpppkpw::create');
	}
}
