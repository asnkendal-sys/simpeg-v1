<?php namespace App\Modules\kenaikanpangkat\rekapusulankenaikanpangkat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\rekapusulankenaikanpangkat\Models\RekapusulankenaikanpangkatModel;
use Input,View, Request, Form, File;

/**
 * Rekapusulankenaikanpangkat Controller
 * @var Rekapusulankenaikanpangkat
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Divisi Software Development - Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class RekapusulankenaikanpangkatController extends Controller {
    protected $rekapusulankenaikanpangkat;

    public function __construct(RekapusulankenaikanpangkatModel $rekapusulankenaikanpangkat){
        $this->rekapusulankenaikanpangkat = $rekapusulankenaikanpangkat;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_kenaikan_pangkat.idusul != 0";
        if(session('role_id') > 3){
            $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('bulan') != '') or (Input::get('tahun') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idjeniskp') != '')) {
            if(Input::get('bulan') != ''){
                $where .= " and MID(tr_kenaikan_pangkat.tglusul,6,2) = \"".Input::get('bulan')."\"";
            }

            if(Input::get('tahun') != ''){
                $where .= " and MID(tr_kenaikan_pangkat.tglusul,1,4) = \"".Input::get('tahun')."\"";
            }

            if(Input::get('statussk') != ''){
                $where .= " and tr_kenaikan_pangkat.statussk = \"".Input::get('statussk')."\"";
            }

            if(Input::get('idjeniskp') != ''){
                $where .= " and tr_kenaikan_pangkat.idjeniskp = \"".Input::get('idjeniskp')."\"";
            }

            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_kenaikan_pangkat.idskpd like '$idskpd%'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_kenaikan_pangkat.nip like '%".Input::get('search')."%' or tb_01.nama like '%".Input::get('search')."%')";
            }

            $rekapusulankenaikanpangkats = $this->rekapusulankenaikanpangkat
                    ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_jenis_kp.jenis_kp','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->join('a_jenis_kp', 'tr_kenaikan_pangkat.idjeniskp', '=', 'a_jenis_kp.id')
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('tmt')
                ->orderBy('idskpd')
                ->orderBy('idjeniskp')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rekapusulankenaikanpangkats = $this->rekapusulankenaikanpangkat->all();
        }
        return View::make('rekapusulankenaikanpangkat::index', compact('rekapusulankenaikanpangkats'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('rekapusulankenaikanpangkat::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, RekapusulankenaikanpangkatModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->rekapusulankenaikanpangkat->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $rekapusulankenaikanpangkat = $this->rekapusulankenaikanpangkat->find($id);
        //if (is_null($rekapusulankenaikanpangkat)){return \Redirect::to('kenaikanpangkat/rekapusulankenaikanpangkat/index');}
        return View::make('rekapusulankenaikanpangkat::edit', compact('rekapusulankenaikanpangkat'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, RekapusulankenaikanpangkatModel::$rules);

        if ($validation->passes()){
            $rekapusulankenaikanpangkat = $this->rekapusulankenaikanpangkat->find($id);
            echo ($rekapusulankenaikanpangkat->update($input))?4:"Gagal Disimpan";
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
                $this->rekapusulankenaikanpangkat->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->rekapusulankenaikanpangkat->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_view');

    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_data');
    }

    /*function view data atribut dari link */
    function postCetak(){
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_print');
    }

    /*function cetak dan simpan nilai yg diubah k db */
    function postCetaksimpan(){
        $nousul             = Input::get('nousul');
        $idskpd             = Input::get('idskpd');
        $dt['no_sp'] 	    = Input::get('no_sp');
        $dt['tgl_sp'] 	    = date('Y-m-d', strtotime(Input::get('tgl_sp')));
        $dt['berkas_sp'] 	= Input::get('berkas_sp');
        
        $update = \DB::table('tr_kenaikan_pangkat')->where('nousul','=',$nousul)->where('idskpd', 'like', $idskpd. '%')->update($dt);
        
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_print');
    }

    /*function view data atribut dari link */
    function getCetak(){
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_print');
    }
	
	//tambahan tab baru
    public function getRekap(){
        cekAjax();
        $where = "a.idusul != 0";
        if(session('role_id') > 3){
            $where .= " and a.idskpd like \"".session('idskpd')."%\" ";
        }

        if ((Input::get('tanggal1') != '') or (Input::get('tanggal2') != '') or (Input::get('idskpd') != '') or (Input::get('idjeniskp') != '')) {
            $where = " a.idusul != 0 ";

            if(Input::get('idjeniskp') != ''){
                $where .= " and a.idjeniskp = \"".Input::get('idjeniskp')."\"";
            }

            if((Input::get('tanggal1') != '') and (Input::get('tanggal2') != '')){
                $where .= " and a.tmt >= \"".tglFormat(Input::get('tanggal1'))."\" and a.tmt <= \"".tglFormat(Input::get('tanggal2'))."\"";
            }

            if((Input::get('tanggal1') != '') and (Input::get('tanggal2') == '')){
                $where .= " and a.tmt = \"".tglFormat(Input::get('tanggal1'))."\"";
            }

            if((Input::get('tanggal1') == '') and (Input::get('tanggal2') != '')){
                $where .= " and a.tmt = \"".tglFormat(Input::get('tanggal2'))."\"";
            }

            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and a.idskpd like '$idskpd%'";
            }

            $rekapusulankenaikanpangkats = \DB::table('tr_kenaikan_pangkat as a')
                    ->select(\DB::raw('a.idskpd, LEFT(a.idskpd,2) AS kdunit, b.skpd, DATE_FORMAT(a.tmt, "%Y") AS tahun, DATE_FORMAT(a.tmt, "%m") AS bulan,
                    COUNT(*) AS jmlusulan, SUM(IF(a.statususul=1,1,0)) AS ms, SUM(IF(a.statususul=2,1,0)) AS tms, SUM(IF(a.statususul=3,1,0)) AS bts,
                    SUM(IF(a.statussk=1,1,0)) AS ps, SUM(IF(a.statussk=2,1,0)) AS dp, SUM(IF(a.statususul=0,1,0)) AS bp'))
                ->join('a_skpd as b', \DB::raw('LEFT(a.idskpd,2)'), '=', 'b.idskpd')
                ->whereRaw($where)
                ->groupBy(\DB::raw('LEFT(a.idskpd,2), DATE_FORMAT(a.tmt, "%Y"), DATE_FORMAT(a.tmt, "%m")')) 
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $rekapusulankenaikanpangkats = \DB::table('tr_kenaikan_pangkat as a')
                    ->select(\DB::raw('a.idskpd, LEFT(a.idskpd,2) AS kdunit, b.skpd, DATE_FORMAT(a.tmt, "%Y") AS tahun, DATE_FORMAT(a.tmt, "%m") AS bulan,
                    COUNT(*) AS jmlusulan, SUM(IF(a.statususul=1,1,0)) AS ms, SUM(IF(a.statususul=2,1,0)) AS tms, SUM(IF(a.statususul=3,1,0)) AS bts,
                    SUM(IF(a.statussk=1,1,0)) AS ps, SUM(IF(a.statussk=2,1,0)) AS dp, SUM(IF(a.statususul=0,1,0)) AS bp'))
                ->join('a_skpd as b', \DB::raw('LEFT(a.idskpd,2)'), '=', 'b.idskpd')
                ->whereRaw($where)
                ->groupBy(\DB::raw('LEFT(a.idskpd,2), DATE_FORMAT(a.tmt, "%Y"), DATE_FORMAT(a.tmt, "%m")')) 
                ->paginate($_ENV['configurations']['list-limit']);
        }
        return View::make('rekapusulankenaikanpangkat::rekap', compact('rekapusulankenaikanpangkats'));
    }

    //fungsi cetak nominatif
    function postRekapnominatif(){
        return View::make('rekapusulankenaikanpangkat::rekapnominatif');
    }

    //fungsi cetak sk
    function postRekapsk(){
        return View::make('rekapusulankenaikanpangkat::rekapsk');
    }

    //fungsi download excel
    function getExcel(){
        $view = Request::segment(4);
        return View::make('rekapusulankenaikanpangkat::'.$view.'_excel');
    }
}
