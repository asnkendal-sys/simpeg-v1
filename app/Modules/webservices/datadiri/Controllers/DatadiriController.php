<?php namespace App\Modules\webservices\datadiri\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\apibkn\Models\ApibknModel;
use App\Modules\epersonal\biodata\Models\BiodataModel;
use App\Services\DataUtamaBknService;
use Input,View, Request, Form, File;

class DatadiriController extends Controller {

	/**
	 * Datadiri Repository
	 *
	 * @var Datadiri
	 */
	 protected $srv;
	 protected $datadiri;
	 public function __construct(BiodataModel $biodata, DataUtamaBknService $srv)
	 {
			 $this->biodata = $biodata;
			 $this->srv = $srv;
	 }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		$where = ' tb_01.idjenkedudupeg not in (99,21)';
		if (session('role_id') > 3) {
				$where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
		}

		if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '') or (Input::get('idstspeg') != '')) {
				(Input::get('idstspeg')!='')?$where.=" and tb_01.idstspeg = '".Input::get('idstspeg')."'":"";
				(Input::get('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
				(Input::get('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

				if (session('role_id') <= 3) {
						$biodatas = $this->biodata
														->select(
																'tb_01.*',
																'a_golruang.golru',
																'a_skpd.path_short',
																'a_esl.esl',
																'a_tkpendid.tkpendid',
																'a_jenjurusan.jenjurusan',
																\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),
																'a_jenkel.jenkel',
																'a_agama.agama',
																\DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
																\DB::raw("
										CONCAT(
												IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
														(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
																(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
																-
																(IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
																IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
																		IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
														),
														(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
																(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
																+ tb_01.mkthncpn
														)
												),
												RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
								"),
																\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
														)
														->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
														->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
														->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
														->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
														->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
														->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
														->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
														->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
														->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
														->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
														->whereRaw($where)
														->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
														->paginate($_ENV['configurations']['list-limit']);
				} else {
						$biodatas = $this->biodata
														->select(
																'tb_01.*',
																'a_golruang.golru',
																'a_skpd.path_short',
																'a_esl.esl',
																'a_tkpendid.tkpendid',
																'a_jenjurusan.jenjurusan',
																\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),
																'a_jenkel.jenkel',
																'a_agama.agama',
																\DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
																\DB::raw("
												CONCAT(
														IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
																(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
																		(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
																		-
																		(IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
																		IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
																				IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
																),
																(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
																		(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
																		+ tb_01.mkthncpn
																)
														),
														RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
										"),
																\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
														)
														->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
														->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
														->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
														->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
														->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
														->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
														->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
														->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
														->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
														->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
														->whereRaw($where)
														->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
														->paginate($_ENV['configurations']['list-limit']);
				}
		} else {
				$biodatas = $this->biodata->all();
		}

		return View::make('datadiri::index', compact('biodatas'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('datadiri::create');
	}
	public function postSave()
	{

		$input = Input::all();
	  unset($input['_token']);
		unset($input['telp']);
		unset($input['hp']);
		unset($input['id']);

		unset($input['idstskawin']);
		unset($input['idagama']);
		$input['idjenkel'] =($input['idjenkel'] == 'Wanita')?2:1;
		$biodata = $this->biodata->find($input['nip']);
		unset($input['nip']);
		//dd(\DB::table('tb_01')->update($input));
		//dd($this->biodata->update($input));
		return ($biodata->update($input))?4:0;
	}

	public function postValidasiupdate()
	{
		$data = Input::all();
		return View::make('datadiri::validasiupdate', compact('data'));
	}
	public function getEdit($id = false)
	{
			cekAjax();
			$id = ($id == false)?Input::get('id'):'';
			$biodata = $this->biodata->find($id);

			$bkn = $this->srv->fetchDataUtama($biodata->nip);

			return View::make('datadiri::edit', compact('biodata', 'bkn'));
	}
}
