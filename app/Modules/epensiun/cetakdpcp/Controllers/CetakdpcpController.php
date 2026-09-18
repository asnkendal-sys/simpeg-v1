<?php namespace App\Modules\epensiun\cetakdpcp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\cetakdpcp\Models\CetakdpcpModel;
use Input,View, Request, Form, File;

/**
* Cetakdpcp Controller
* @var Cetakdpcp
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class CetakdpcpController extends Controller {
    protected $cetakdpcp;

    public function __construct(CetakdpcpModel $cetakdpcp){
        $this->cetakdpcp = $cetakdpcp;
    }

        public function getIndex(){
        cekAjax();

            $where = " tr_pensiun.idjenkedudupeg != 1 and tr_pensiun.nip != '' ";
            if(session('role_id') > 3){
                $where .= " and b.idskpd like \"".session('idskpd')."%\" ";
            }
            if (Input::has('search') or Input::has('idskpd') or Input::has('tahun') or Input::has('bulan') or (Input::get('statussk') != '')) {                    
                if(Input::get('tahun') != ''){
                    $where .= (($where != '')?' AND ':'')." YEAR(tr_pensiun.tmtpens)= ".Input::get('tahun')."";
                }
            
                // /* Kondisi Bulan */
                if(Input::get('bulan') != '' && Input::get('tahun') != ''){
                    $where .= " AND MONTH(tr_pensiun.tmtpens) = \"".Input::get('bulan')."\"";
                }

                if(Input::get('bulan') != '' && Input::get('tahun') == ''){
                    $where .= " AND MONTH(tr_pensiun.tmtpens) = \"".Input::get('bulan')."\"";
                }

                /* Kondisi skpd atau unit kerja */
                if(Input::get('idskpd') != ''){
                    $where.= "and b.idskpd like '".Input::get('idskpd')."%'";
                }

                if(Input::get('statussk') != ''){
                    $where .= " and statussk = \"".Input::get('statussk')."\"";
                }

                /* Kondisi search */
                if(Input::get('search') != ''){
                    $where.= "and (tr_pensiun.nip like '%".Input::get('search')."%' or b.nama like '%".Input::get('search')."%')";
                }

                $cetakdpcps = $this->cetakdpcp
                    ->select(\DB::raw("tr_pensiun.*,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,b.*,f.esl,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a_agama.agama,a_jenpens.jenpens,g.path_short,
                        b.idgolrupns, b.tmtpns, e.golru, e.pangkat,
                        c.golru as golrucpn,c.pangkat as pangkatcpn,
                        d.golru as golrupns,d.pangkat as pangkatpns"),
                        \DB::raw('IF(b.idjenjab>4,g.jab,IF(b.idjenjab=2,h.jabfung,IF(b.idjenjab=3,i.jabfungum,IF(b.idjenjab=4,j.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(b.idjenjab>4,g.bup,IF(b.idjenjab=2,h.pens,IF(b.idjenjab=3,i.pens,IF(b.idjenjab=4,j.pens,"-")))) as usiapens'),
                        \DB::raw("
                                CONCAT(
                                    IF((LEFT(b.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(b.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - b.mkthncpn,
                                            IF((LEFT(b.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - b.mkthncpn,
                                                IF((LEFT(b.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - b.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0)-2))
                                            + b.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(b.tmtcpn='0000-00-00',b.tmtpns,b.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),
                                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(b.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->leftJoin('tb_01 as b', 'tr_pensiun.nip', '=', 'b.nip')
                    ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                    ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                    ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                    ->leftjoin('a_esl as f', 'b.idesljbt', '=', 'f.idesl')
                    ->join('a_skpd as g', 'b.idskpd', '=', 'g.idskpd')
                    ->leftjoin('a_jabfung as h', 'b.idjabfung', '=', 'h.idjabfung')
                    ->leftjoin('a_jabfungum as i', 'b.idjabfungum', '=', 'i.idjabfungum')
                    ->leftjoin('a_jabnonjob as j', 'b.idjabnonjob', '=', 'j.idjabnonjob')
                    ->leftjoin('a_tkpendid', 'b.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'b.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_agama', 'b.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenpens', 'tr_pensiun.idjenpens', '=', 'a_jenpens.idjenpens')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tr_pensiun.tmtpens desc,tr_pensiun.nip'))
                    ->paginate($_ENV['configurations']['list-limit']);                 
        }else{                        
            $cetakdpcps = $this->cetakdpcp->all();
        }
        return View::make('cetakdpcp::index', compact('cetakdpcps'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('cetakdpcp::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, CetakdpcpModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->cetakdpcp->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $cetakdpcp = $this->cetakdpcp->find($id);
        //if (is_null($cetakdpcp)){return \Redirect::to('epensiun/cetakdpcp/index');}
        return View::make('cetakdpcp::edit', compact('cetakdpcp'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, CetakdpcpModel::$rules);
        
        if ($validation->passes()){
            $cetakdpcp = $this->cetakdpcp->find($id);
            echo ($cetakdpcp->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


	
        public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->cetakdpcp->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->cetakdpcp->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
