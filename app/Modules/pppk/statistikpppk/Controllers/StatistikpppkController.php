<?php namespace App\Modules\pppk\statistikpppk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pppk\statistikpppk\Models\StatistikpppkModel;
use App\Modules\pppk\perpanjangankontrak\Models\PerpanjangankontrakModel;
use Input,View, Request, Form, File;

class StatistikpppkController extends Controller {

	/**
	 * Statistikpppk Repository
	 *
	 * @var Statistikpppk
	 */
	protected $statistikpppk;

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
		return View::make('statistikpppk::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('statistikpppk::create');
	}

	/*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('statistikpppk::'.$view.'_data');
    }

    function postPrint(){
        $view = Request::segment(4);
        return View::make('statistikpppk::'.$view.'_print');
    }

	function postExcel(){
        $view = Request::segment(4);
        return View::make('statistikpppk::'.$view.'_excel');
    }

	public function postDetail()
	{
		cekAjax();
        $idskpd = Input::get('idskpd');
        $idstatus = Input::get('idstatus');  
		switch($idstatus){
            case 1:           
				$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 3 ";		

				/* Kondisi Tahun */
				if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
						$where .= "and YEAR(tmtakhirakhir_pppk) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
						$titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
				}else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
						$where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun1')."";
						$titletahun = ' TAHUN '.Input::get('tahun1');
				}else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
						$where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
						$titletahun = ' TAHUN '.Input::get('tahun2');
				}

				/* Kondisi Bulan */
				if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
						$where .= " AND MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
						$titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
				}else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
						$where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')."";
						$titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
				}else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
						$where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')."";
						$titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
				}

				/* Kondisi skpd atau unit kerja */
				if(Input::get('idskpd') != ''){
					$where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
				}
			break; 			
			default :
				$where = " tr_pppk.nip != '' ";		

				/* Kondisi Tahun */
				if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
						$where .= "and YEAR(tmtakhirl) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
						$titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
				}else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
						$where .= "and YEAR(tmtakhirl)= ".Input::get('tahun1')."";
						$titletahun = ' TAHUN '.Input::get('tahun1');
				}else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
						$where .= "and YEAR(tmtakhirl)= ".Input::get('tahun2')."";
						$titletahun = ' TAHUN '.Input::get('tahun2');
				}

				/* Kondisi Bulan */
				if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
						$where .= " AND MONTH(tmtakhirl) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
						$titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
				}else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
						$where .= " AND MONTH(tmtakhirl)= ".Input::get('bulan1')."";
						$titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
				}else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
						$where .= " AND MONTH(tmtakhirl)= ".Input::get('bulan2')."";
						$titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
				}

				/* Kondisi skpd atau unit kerja */
				if(Input::get('idskpd') != ''){
					$where.= " and tr_pppk.idskpd like '".Input::get('idskpd')."%'";
				}

		}

		$title  ="DAFTAR NOMINATIF KONTRAK PPPK";
		$title .=((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'');
		$title .=(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'');
		$title .=(((Input::get('tahun1') != '') or (Input::get('tahun2') != ''))?$titletahun:'');

        switch($idstatus){
            case 1:               
				$title .= "<br>"; 
                $detail = \DB::table('tb_01')
				->select('tb_01.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru','a_golruang.golru_p3k',
				\DB::raw("TIMESTAMPDIFF(YEAR, tmtmulaiakhir_pppk, tmtakhirakhir_pppk) AS selisih_tahunkerja"),
            	\DB::raw("TIMESTAMPDIFF(MONTH, tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_bulankerja"),
				\DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
					\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
					\DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
					\DB::raw("
								CONCAT(
									IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
											(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
												(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
											-
												(IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
												IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
												IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
											),
											(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0,1,
												(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0)-2))
												+ tb_01.mkthncpn
											)
									),
									RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tgskcalonawal_pppk)), '%Y%m')+0, 2)) AS mkskr
					"),
					\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
				)
				->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
				->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
				->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
				->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
				->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
				->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
				->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
				->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
				->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
				->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
				->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
				->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
				->whereRaw($where)      
				->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt desc, tb_01.nama'))
				->get();				
                return View::make('statistikpppk::detail_kontrak', compact('detail', 'title'));
            break;
            case 2:
				$title .= "<br>STATUS USULAN PERPANJANGAN KONTRAK";
                $detail = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)->where('status', 1)
                    ->whereRaw($where)					                                					
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
					return View::make('statistikpppk::detail_perpanjangan', compact('detail', 'title'));
            break;
            case 3:                
				$title .= "<br>STATUS USULAN PEMBERHENTIAN KONTRAK";
                $detail = \DB::table('tr_pppk')
					->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
					->select('tr_pppk.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 3)
					->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
					return View::make('statistikpppk::detail_pemberhentian', compact('detail', 'title'));
            break;
			case 8:
				$title .= "<br>STATUS TIDAK DIPERPANJANG KONTRAK";
                $detail = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)->where('status', 2)
                    ->whereRaw($where)					                                					
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
					return View::make('statistikpppk::detail_perpanjangan', compact('detail', 'title'));
            break;
			case 4:
				$title .= "<br>STATUS USULAN BELUM DIVERIFIKASI";
                $detail1 = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)
					->where('statussk', 0)
                    ->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();

				$detail2 = \DB::table('tr_pppk')
					->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
					->select('tr_pppk.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 3)
					->where('statussk', 0)
					->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
                return View::make('statistikpppk::detail_usulan', compact('detail1','detail2', 'title'));
            break;
			case 5:
				$title .= "<br>STATUS USULAN TIDAK MEMENUHI SYARAT";
                $detail1 = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)
					->where('statususul', '>', 1)
                    ->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();

				$detail2 = \DB::table('tr_pppk')
					->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
					->select('tr_pppk.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 3)
					->where('statususul', '>', 1)
					->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
                return View::make('statistikpppk::detail_usulan', compact('detail1','detail2', 'title'));
            break;
			case 6:
				$title .= "<br>STATUS USULAN DALAM PROSES";
                $detail1 = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)
					->where('statussk', 2)
                    ->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();

				$detail2 = \DB::table('tr_pppk')
					->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
					->select('tr_pppk.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 3)
					->where('statussk', 2)
					->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
                return View::make('statistikpppk::detail_usulan', compact('detail1','detail2', 'title'));
            break;
			case 7:          
				$title .= "<br>STATUS USULAN PROSES SELESAI";      
                $detail1 = PerpanjangankontrakModel::
					select('tr_pppk.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 2)
					->where('statussk', 1)
                    ->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();

				$detail2 = \DB::table('tr_pppk')
					->join('a_jenpens', 'tr_pppk.idjenpens', '=', 'a_jenpens.idjenpens')
					->select('tr_pppk.*','a_jenpens.jenpens',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppk.tglhr)), '%Y%m')+0 AS usia"))
					->where('sts_kontrak', 3)
					->where('statussk', 1)
					->whereRaw($where)					                                
					->orderBy('tglhr')->orderBy('idgolru', 'desc')->orderBy('nama')
					->get();
                return View::make('statistikpppk::detail_usulan', compact('detail1','detail2', 'title'));
            break;
        }
	}
}
