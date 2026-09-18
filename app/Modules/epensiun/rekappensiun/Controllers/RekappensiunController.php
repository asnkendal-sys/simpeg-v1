<?php namespace App\Modules\epensiun\rekappensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\rekappensiun\Models\RekappensiunModel;
use Input,View, Request, Form, File;

/**
* Rekappensiun Controller
* @var Rekappensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RekappensiunController extends Controller {
    protected $rekappensiun;

    public function __construct(RekappensiunModel $rekappensiun){
        $this->rekappensiun = $rekappensiun;
    }

        public function getIndex(){
        cekAjax();
        $where = " tr_pensiun.idjenkedudupeg != 1 and tr_pensiun.nip != '' ";
            // if(session('role_id') > 3){
            //     $where .= " and b.idskpd like \"".session('idskpd')."%\" ";
            // }
            if ((Input::get('tanggal1') != '') or (Input::get('tanggal2') != '') or (Input::get('idskpd') != '')) {
            // if (Input::has('search') or Input::has('idskpd') or Input::has('tahun') or Input::has('bulan') or (Input::get('statussk') != '')) { 

                if((Input::get('tanggal1') != '') and (Input::get('tanggal2') != '')){
                $where .= " and tr_pensiun.tmtpens >= \"".tglFormat(Input::get('tanggal1'))."\" and tr_pensiun.tmtpens <= \"".tglFormat(Input::get('tanggal2'))."\"";
                }

                if((Input::get('tanggal1') != '') and (Input::get('tanggal2') == '')){
                    $where .= " and tr_pensiun.tmtpens = \"".tglFormat(Input::get('tanggal1'))."\""; //hrsnya pake tmtpens bukan tgskpens
                }

                if((Input::get('tanggal1') == '') and (Input::get('tanggal2') != '')){
                    $where .= " and tr_pensiun.tmtpens = \"".tglFormat(Input::get('tanggal2'))."\"";
                }
                
                // if(Input::get('tanggal1') != ''){
                //     $where .= (($where != '')?' AND ':'')." YEAR(tmtpens)= ".Input::get('tahun')."";
                // }
            
                // // /* Kondisi Bulan */
                // if(Input::get('bulan') != '' && Input::get('tahun') != ''){
                //     $where .= " AND MONTH(tmtpens) = \"".Input::get('bulan')."\"";
                // }

                // if(Input::get('bulan') != '' && Input::get('tahun') == ''){
                //     $where .= " MONTH(tmtpens) = \"".Input::get('bulan')."\"";
                // }

                /* Kondisi skpd atau unit kerja */
                if(Input::get('idskpd') != ''){
                    $where.= "and b.idskpd like '".Input::get('idskpd')."%'";
                }

                // if(Input::get('statussk') != ''){
                //     $where .= " and statussk = \"".Input::get('statussk')."\"";
                // }

                // /* Kondisi search */
                // if(Input::get('search') != ''){
                //     $where.= "and (tr_pensiun.nip like '%".Input::get('search')."%' or b.nama like '%".Input::get('search')."%')";
                // }

                $rekappensiuns = $this->rekappensiun
                    ->select(\DB::raw("tr_pensiun.*,
                        b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,b.*,f.esl,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a_agama.agama,a_jenpens.jenpens,g.path_short,
                        b.idgolrupns, b.tmtpns, e.golru, e.pangkat,
                        c.golru as golrucpn,c.pangkat as pangkatcpn,
                        d.golru as golrupns,d.pangkat as pangkatpns, tr_pensiun.tmtpens"),
                        \DB::raw("CONCAT(b.gdp,IF(LENGTH(b.gdp)>0,' ',''),b.nama,IF(LENGTH(b.gdb)>0,', ',''),b.gdb) AS namalengkap"),
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
                    ->join('tb_01 as b', 'tr_pensiun.nip', '=', 'b.nip')
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
            $rekappensiuns = $this->rekappensiun->all();
        }
        return View::make('rekappensiun::index', compact('rekappensiuns'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('rekappensiun::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RekappensiunModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->rekappensiun->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $rekappensiun = $this->rekappensiun->find($id);
        //if (is_null($rekappensiun)){return \Redirect::to('epensiun/rekappensiun/index');}
        return View::make('rekappensiun::edit', compact('rekappensiun'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RekappensiunModel::$rules);
        
        if ($validation->passes()){
            $rekappensiun = $this->rekappensiun->find($id);
            echo ($rekappensiun->update($input))?4:"Gagal Disimpan";
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
                $this->rekappensiun->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->rekappensiun->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk cetak sk rekap Pensiun*/
    function postRekapsk(){
        return View::make('rekappensiun::rekapsk');
    }

    /*function untuk cetak rekap nominatif Pensiun*/
    function postRekapnominatif(){
        return View::make('rekappensiun::rekapnominatif');
    }

}
