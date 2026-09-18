<?php namespace App\Modules\epersonal\perubahanbiodata\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\perubahanbiodata\Models\PerubahanbiodataModel;
use Input,View, Request, Form, File;

/**
* Perubahanbiodata Controller
* @var Perubahanbiodata
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PerubahanbiodataController extends Controller {
    protected $perubahanbiodata;

    public function __construct(PerubahanbiodataModel $perubahanbiodata){
        $this->perubahanbiodata = $perubahanbiodata;
    }

    public function getIndex(){
        cekAjax();
        // $where = ' tb_01_temp.idjenkedudupeg not in (99,21)';
        $where = " tb_01_temp.idjenkedudupeg != '0'";
        if(session('role_id') > 3){
            if(session('role_id') == 5){
                $where.= " and tb_01_temp.nip = \"".session('user_id')."\" ";
            }else{
                $where.= " and tb_01_temp.idskpd like \"".session('idskpd')."%\" ";
                $where.= " and tb_01_temp.status like \"".session('status')."%\" ";
            }
        }

        if (Input::has('search') or Input::has('idskpd') or Input::has('status')) {
            (Input::has('status')!='')?$where.=" and tb_01_temp.status = '".Input::get('status')."%'":"";
            (Input::has('idskpd')!='')?$where.=" and tb_01_temp.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::has('search')!='')?$where.=" and (tb_01_temp.nama LIKE '%".Input::get('search')."%' or tb_01_temp.nip LIKE '%".Input::get('search')."%')":"";

            $perubahanbiodatas = $this->perubahanbiodata
                ->select('tb_01_temp.*','a_golruang.golru','a_skpd.path','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                \DB::raw('CONCAT(tb_01_temp.gdp,IF(LENGTH(tb_01_temp.gdp)>0," ",""),tb_01_temp.nama,IF(LENGTH(tb_01_temp.gdb)>0,", ",""),tb_01_temp.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                \DB::raw('IF(tb_01_temp.idjenjab>4,a_skpd.jab,IF(tb_01_temp.idjenjab=2,a_jabfung.jabfung,IF(tb_01_temp.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01_temp.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("
                        CONCAT(
                            IF((LEFT(tb_01_temp.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0,1,
                                    (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0)-2))
                                    -
                                    (IF((LEFT(tb_01_temp.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01_temp.mkthncpn,
                                    IF((LEFT(tb_01_temp.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01_temp.mkthncpn,
                                        IF((LEFT(tb_01_temp.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01_temp.mkthncpn, 0 ))))
                                ),
                                (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0,1,
                                    (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0)-2))
                                    + tb_01_temp.mkthncpn
                                )
                            ),
                            RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01_temp.tmtcpn='0000-00-00',tb_01_temp.tmtpns,tb_01_temp.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                    "),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01_temp.tglhr)), '%Y%m')+0 AS usia")
            )
                ->leftjoin('a_skpd', 'tb_01_temp.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_esl', 'tb_01_temp.idesljbt', '=', 'a_esl.idesl')
                ->leftjoin('a_tkpendid', 'tb_01_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tb_01_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tb_01_temp.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_agama', 'tb_01_temp.idagama', '=', 'a_agama.idagama')
                ->leftjoin('a_jenkel', 'tb_01_temp.idjenkel', '=', 'a_jenkel.idjenkel')
                ->leftjoin('a_jabfung', 'tb_01_temp.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tb_01_temp.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabnonjob', 'tb_01_temp.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                ->whereRaw($where)
                ->orderBy('tb_01_temp.updated_at', 'desc')
                ->orderBy('tb_01_temp.idskpd', 'asc')
                ->orderBy('tb_01_temp.idgolrupkt', 'desc')
                ->orderBy('tb_01_temp.tmtpkt', 'asc')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $perubahanbiodatas = $this->perubahanbiodata->all();
        }
        return View::make('perubahanbiodata::index', compact('perubahanbiodatas'));
    }

    //{controller-show}

    public function postBtlbiodata(){
        cekAjax();
        $nip = Input::get('id');
        if(\DB::table('tb_01_temp')->where('nip', $nip)->update(array('status'=>1,'ketditolak'=>''))){
            echo "9";
        }else{
            echo "Data Gagal Dibatalkan";
        }
    }
}
