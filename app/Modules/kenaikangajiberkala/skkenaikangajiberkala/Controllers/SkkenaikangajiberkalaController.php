<?php

namespace App\Modules\kenaikangajiberkala\skkenaikangajiberkala\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikangajiberkala\skkenaikangajiberkala\Models\SkkenaikangajiberkalaModel;
use Input, View, Request, Form, File;

class SkkenaikangajiberkalaController extends Controller
{
    protected $skkenaikangajiberkala;

    public function __construct(SkkenaikangajiberkalaModel $skkenaikangajiberkala)
    {
        $this->skkenaikangajiberkala = $skkenaikangajiberkala;
    }

    public function getIndex()
    {
        cekAjax();

        $where = "tr_kgb.jnskgb != 0 and tr_kgb.statuskgb = 2";
        if (session('role_id') > 3) {
            $where .= " and tr_kgb.kdskpd like \"" . session('idskpd') . "%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('tglawal') != '') or (Input::get('tglakhir') != '') or (Input::get('jnskgb') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idstspeg') != '')) {
            if (Input::get('tglawal') != '') {
                $where .= " and date(tmtkgbb) >= \"" . date(Input::get('tglawal')) . "\"";
            }

            if (Input::get('tglakhir') != '') {
                $where .= " and date(tmtkgbb) <= \"" . date(Input::get('tglakhir')) . "\"";
            }

            if (Input::get('jnskgb') != '') {
                $where .= " and jnskgb = \"" . Input::get('jnskgb') . "\"";
            }

            if (Input::get('statussk') != '') {
                $where .= " and statussk = \"" . Input::get('statussk') . "\"";
            }

            if (Input::get('idstspeg') != '') {
                $where .= " and b.idstspeg = \"" . Input::get('idstspeg') . "\"";
            }

            if (Input::get('idskpd') != '') {
                $idskpd = Input::get('idskpd');
                $where .= " and MID(idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'";
            }

            if (strlen(Input::has('search')) > 0) {
                $where .= " and (tr_kgb.nip like '%" . Input::get('search') . "%' or tr_kgb.karpeg like '%" . Input::get('search') . "%' or tr_kgb.nama like '%" . Input::get('search') . "%')";
            }

            $skkenaikangajiberkalas = $this->skkenaikangajiberkala
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                    b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                    b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                    IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                    IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))

                ->paginate($_ENV['configurations']['list-limit']);
        } else {
            $skkenaikangajiberkalas = $this->skkenaikangajiberkala->all();
        }
        return View::make('skkenaikangajiberkala::index', compact('skkenaikangajiberkalas'));
    }

    /*function cetak berkas pendaftaran*/
    public function getRekap()
    {
        cekAjax();
        if ((Input::get('tanggal1') != '') or (Input::get('tanggal2') != '') or (Input::get('tmt1') != '') or (Input::get('tmt2') != '') or (Input::get('idskpd') != '') or (Input::get('jnskgb') != '')) {
            $where = "tr_kgb.jnskgb != ''";

            if (Input::get('jnskgb') != '') {
                $where .= " and tr_kgb.jnskgb = \"" . Input::get('jnskgb') . "\"";
            }

            if ((Input::get('tanggal1') != '') and (Input::get('tanggal2') != '')) {
                $where .= " and tr_kgb.tglskkgbb >= \"" . tglFormat(Input::get('tanggal1')) . "\" and tr_kgb.tglskkgbb <= \"" . tglFormat(Input::get('tanggal2')) . "\"";
            }

            if ((Input::get('tanggal1') != '') and (Input::get('tanggal2') == '')) {
                $where .= " and tr_kgb.tglskkgbb = \"" . tglFormat(Input::get('tanggal1')) . "\"";
            }

            if ((Input::get('tanggal1') == '') and (Input::get('tanggal2') != '')) {
                $where .= " and tr_kgb.tglskkgbb = \"" . tglFormat(Input::get('tanggal2')) . "\"";
            }
            // candra tambahan tmtkgb
            if ((Input::get('tmt1') != '') and (Input::get('tmt2') != '')) {
                $where .= " and tr_kgb.tmtkgbb >= \"" . tglFormat(Input::get('tmt1')) . "\" and tr_kgb.tmtkgbb <= \"" . tglFormat(Input::get('tmt2')) . "\"";
            }

            if ((Input::get('tmt1') != '') and (Input::get('tmt2') == '')) {
                $where .= " and tr_kgb.tmtkgbb = \"" . tglFormat(Input::get('tmt1')) . "\"";
            }

            if ((Input::get('tmt1') == '') and (Input::get('tmt2') != '')) {
                $where .= " and tr_kgb.tmtkgbb = \"" . tglFormat(Input::get('tmt2')) . "\"";
            }
            // candra tambahan tmtkgb

            if (Input::get('idskpd') != '') {
                $idskpd = Input::get('idskpd');
                $where .= " and MID(idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'";
            }

            $skkenaikangajiberkalas = $this->skkenaikangajiberkala
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                    b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                    b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                    IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                    IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))

                ->paginate($_ENV['configurations']['list-limit']);
        } else {
            $skkenaikangajiberkalas = $this->skkenaikangajiberkala->all();
        }
        return View::make('skkenaikangajiberkala::rekap', compact('skkenaikangajiberkalas'));
    }


    //{controller-show}

    /*function untuk cetak sk rekap kgb*/
    function postRekapsk()
    {
        return View::make('skkenaikangajiberkala::rekapsk');
    }

    /*function untuk cetak rekap nominatif kgb*/
    function postRekapnominatif()
    {
        return View::make('skkenaikangajiberkala::rekapnominatif');
    }
    function getExcel()
    {

        if (session('role_id') > 3) {
            $where .= " and tr_kgb.kdskpd like \"" . session('idskpd') . "%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('tglawal') != '') or (Input::get('tglakhir') != '') or (Input::get('jnskgb') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idstspeg') != '')) {
            if (Input::get('tglawal') != '') {
                $where .= " and date(tmtkgbb) >= \"" . date(Input::get('tglawal')) . "\"";
            }

            if (Input::get('tglakhir') != '') {
                $where .= " and date(tmtkgbb) <= \"" . date(Input::get('tglakhir')) . "\"";
            }

            if (Input::get('jnskgb') != '') {
                $where .= " and jnskgb = \"" . Input::get('jnskgb') . "\"";
            }

            if (Input::get('statussk') != '') {
                $where .= " and statussk = \"" . Input::get('statussk') . "\"";
            }

            if (Input::get('idstspeg') != '') {
                $where .= " and b.idstspeg = \"" . Input::get('idstspeg') . "\"";
            }

            if (Input::get('idskpd') != '') {
                $idskpd = Input::get('idskpd');
                $where .= " and MID(idkgb,8,LENGTH(idkgb)-7) like '$idskpd%'";
            }

            if (strlen(Input::has('search')) > 0) {
                $where .= " and (tr_kgb.nip like '%" . Input::get('search') . "%' or tr_kgb.karpeg like '%" . Input::get('search') . "%' or tr_kgb.nama like '%" . Input::get('search') . "%')";
            }

            $skkenaikangajiberkalas = $this->skkenaikangajiberkala
                ->select(\DB::raw("tr_kgb.*,b.idstspeg,
                    b.idgolrucpn, b.tmtcpn, b.mkthncpn, b.mkblncpn,
                    b.idgolrupns, b.tmtpns, IF(b.idstspeg=3,e.golru_p3k,e.golru) as golru, e.pangkat,
                    IF(b.idstspeg=3,c.golru_p3k,c.golru) as golrucpn,c.pangkat as pangkatcpn,
                    IF(b.idstspeg=3,d.golru_p3k,d.golru) as golrupns,d.pangkat as pangkatpns"))
                ->leftJoin('tb_01 as b', 'tr_kgb.nip', '=', 'b.nip')
                ->leftJoin('a_golruang as c', 'b.idgolrucpn', '=', 'c.idgolru')
                ->leftJoin('a_golruang as d', 'b.idgolrupns', '=', 'd.idgolru')
                ->leftJoin('a_golruang as e', 'b.idgolrupkt', '=', 'e.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_kgb.idkgb desc,tr_kgb.idjabskr,tr_kgb.golpnsskr,tr_kgb.nama'))

                ->paginate($_ENV['configurations']['list-limit']);
        } else {
            $skkenaikangajiberkalas = $this->skkenaikangajiberkala->all();
        }

        return View::make('skkenaikangajiberkala::skkenaikangajiberkala_excel', compact('skkenaikangajiberkalas'));
    }
}
