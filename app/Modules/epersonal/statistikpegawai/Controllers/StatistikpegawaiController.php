<?php namespace App\Modules\epersonal\statistikpegawai\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epersonal\statistikpegawai\Models\StatistikpegawaiModel;
use Input,View, Request, Form, File;

/**
* Statistikpegawai Controller
* @var Statistikpegawai
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class StatistikpegawaiController extends Controller {
    protected $statistikpegawai;

    public function __construct(StatistikpegawaiModel $statistikpegawai){
        $this->statistikpegawai = $statistikpegawai;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $statistikpegawais = $this->statistikpegawai
                			->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $statistikpegawais = $this->statistikpegawai->all();
            }
        }else{
            $statistikpegawais = $this->statistikpegawai->all();
        }
        return View::make('statistikpegawai::index', compact('statistikpegawais'));
    }

    public function getRekappegawai(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $statistikpegawais = $this->statistikpegawai
                            ->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $statistikpegawais = $this->statistikpegawai->all();
            }
        }else{
            $statistikpegawais = $this->statistikpegawai->all();
        }
        return View::make('statistikpegawai::index_rekappegawai', compact('statistikpegawais'));
    }

    public function getRekappensiun(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $statistikpegawais = $this->statistikpegawai
                            ->orWhere('niplama', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('gdp', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('gdb', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('tmlhr', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('tglhr', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('idjenkel', 'LIKE', '%'.Input::get('search').'%')
            ->orWhere('idagama', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $statistikpegawais = $this->statistikpegawai->all();
            }
        }else{
            $statistikpegawais = $this->statistikpegawai->all();
        }
        return View::make('statistikpegawai::index_rekappensiun', compact('statistikpegawais'));
    }

public function getStatistikabk()
    {
        cekAjax();
        if (Input::has('search')) {
            if (strlen(Input::has('search')) > 0) {
                $bez = \DB::table('db_bezeting.tr_petajab as b')
                    ->selectRaw('a.path_short, b.kdunit, SUM(b.abk) as abk')
                    ->leftJoin('db_simpeg_2017.a_skpd as a', 'a.idskpd', '=', 'b.idskpd')
                	->where('a.flag','=','1')
                    ->groupBy('a.path_short');

                $sim = \DB::table('tb_01')
                    ->selectRaw('a_skpd.idskpd, a_skpd.path_short, COUNT(nip) as jumlah')
                    ->leftJoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->whereNotIn('idjenkedudupeg', [21, 99])
                    ->groupBy('a_skpd.path_short');

                $statistikpegawais = \DB::table(\DB::raw("({$bez->toSql()}) as bez"))
                    ->selectRaw('bez.path_short,bez.abk,sim.jumlah')
                    ->mergeBindings($bez) // penting supaya binding ikut
                    ->leftJoin(\DB::raw("({$sim->toSql()}) as sim"), 'sim.path_short', '=', 'bez.path_short')
                    ->mergeBindings($sim)
                ->orWhere('bez.path_short', 'LIKE', '%' . Input::get('search') . '%')
                    ->paginate($_ENV['configurations']['list-limit']);
            } else {
                $bez = \DB::table('db_bezeting.tr_petajab as b')
                    ->selectRaw('a.path_short, b.kdunit, SUM(b.abk) as abk')
                    ->leftJoin('db_simpeg_2017.a_skpd as a', 'a.idskpd', '=', 'b.idskpd')
               ->where('a.flag','=','1')
                    ->groupBy('a.path_short');

                $sim = \DB::table('tb_01')
                    ->selectRaw('a_skpd.idskpd, a_skpd.path_short, COUNT(nip) as jumlah')
                    ->leftJoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->whereNotIn('idjenkedudupeg', [21, 99])
                    ->groupBy('a_skpd.path_short');

                $statistikpegawais = \DB::table(\DB::raw("({$bez->toSql()}) as bez"))
                    ->selectRaw('bez.path_short,bez.abk,sim.jumlah')
                    ->mergeBindings($bez) // penting supaya binding ikut
                    ->leftJoin(\DB::raw("({$sim->toSql()}) as sim"), 'sim.path_short', '=', 'bez.path_short')
                    ->mergeBindings($sim)
                ->orWhere('bez.path_short', 'LIKE', '%' . Input::get('search') . '%')
                    ->paginate($_ENV['configurations']['list-limit']);
            }
        } else {
            $bez = \DB::table('db_bezeting.tr_petajab as b')
                ->selectRaw('a.path_short, b.kdunit, SUM(b.abk) as abk')
                ->leftJoin('db_simpeg_2017.a_skpd as a', 'a.idskpd', '=', 'b.idskpd')
           ->where('a.flag','=','1')
                ->groupBy('a.path_short');

            $sim = \DB::table('tb_01')
                ->selectRaw('a_skpd.idskpd, a_skpd.path_short, COUNT(nip) as jumlah')
                ->leftJoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->whereNotIn('idjenkedudupeg', [21, 99])
                ->groupBy('a_skpd.path_short');

            $statistikpegawais = \DB::table(\DB::raw("({$bez->toSql()}) as bez"))
                ->selectRaw('bez.path_short,bez.abk,sim.jumlah')
                ->mergeBindings($bez) // penting supaya binding ikut
                ->leftJoin(\DB::raw("({$sim->toSql()}) as sim"), 'sim.path_short', '=', 'bez.path_short')
                ->mergeBindings($sim)
                ->paginate($_ENV['configurations']['list-limit']);
        }
        
        return View::make('statistikpegawai::index_abk', compact('statistikpegawais'));
    }

    //{controller-show}
    /*function view data atribut dari link */
    function postData(){
        $view = Request::segment(4);
        return View::make('statistikpegawai::'.$view.'_data');
    }

    /*function print atribut dari link */
    public function postPrint(){
        $view = Request::segment(4);
        return View::make('statistikpegawai::'.$view.'_print');
    }

    /*statistik pendidikan formal golongan 1*/
    public function postGraphpendformal1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_tkpendid as a')
            ->select(
                'a.tkpendid',
                \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
                \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
                \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
                \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
            )
            ->leftjoin('tb_01 as b', 'a.idtkpendid', '=', 'b.idtkpendid')
            ->whereRaw($where)
            ->orderBy('a.idtkpendid', 'asc')
            ->groupBy('a.idtkpendid');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tkpendid.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    /*statistik pendidikan formal golongan 2*/
    public function postGraphpendformal2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_tkpendid as a')
            ->select(
                'a.tkpendid',
                \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
                \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
                \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
                \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
            )
            ->leftjoin('tb_01 as b', 'a.idtkpendid', '=', 'b.idtkpendid')
            ->whereRaw($where)
            ->orderBy('a.idtkpendid', 'asc')
            ->groupBy('a.idtkpendid');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tkpendid.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    /*statistik pendidikan formal golongan 3*/
    public function postGraphpendformal3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_tkpendid as a')
            ->select(
                'a.tkpendid',
                \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
                \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
                \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
                \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
            )
            ->leftjoin('tb_01 as b', 'a.idtkpendid', '=', 'b.idtkpendid')
            ->whereRaw($where)
            ->orderBy('a.idtkpendid', 'asc')
            ->groupBy('a.idtkpendid');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tkpendid.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    /*statistik pendidikan formal golongan 4*/
    public function postGraphpendformal4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_tkpendid as a')
            ->select(
                'a.tkpendid',
                \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
                \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
                \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
                \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
                \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
            )
            ->leftjoin('tb_01 as b', 'a.idtkpendid', '=', 'b.idtkpendid')
            ->whereRaw($where)
            ->orderBy('a.idtkpendid', 'asc')
            ->groupBy('a.idtkpendid');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tkpendid.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /*end of statistik pendidikan formal golongan*/

    /*statistik unitkerja dan pendidikan formal*/
    public function postGraphukerjapendidformal(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
                \DB::raw("left(a.idskpd,2) as idskpd,replace(a.skpd,',',' ') as skpd"),
                \DB::raw("SUM(IF(b.idtkpendid='05',1,0)) AS 'sd'"),
                \DB::raw("SUM(IF(b.idtkpendid='10',1,0)) AS 'sp'"),
                \DB::raw("SUM(IF(b.idtkpendid='12',1,0)) AS 'spk'"),
                \DB::raw("SUM(IF(b.idtkpendid='15',1,0)) AS 'sa'"),
                \DB::raw("SUM(IF(b.idtkpendid='17',1,0)) AS 'sak'"),
                \DB::raw("SUM(IF(b.idtkpendid='18',1,0)) AS 'sag'"),
                \DB::raw("SUM(IF(b.idtkpendid='20',1,0)) AS 'd1'"),
                \DB::raw("SUM(IF(b.idtkpendid='25',1,0)) AS 'd2'"),
                \DB::raw("SUM(IF(b.idtkpendid='30',1,0)) AS 'd3'"),
                \DB::raw("SUM(IF(b.idtkpendid='35',1,0)) AS 'd4'"),
                \DB::raw("SUM(IF(b.idtkpendid='40',1,0)) AS 's1'"),
                \DB::raw("SUM(IF(b.idtkpendid='45',1,0)) AS 's2'"),
                \DB::raw("SUM(IF(b.idtkpendid='50',1,0)) AS 's3'")
            )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(a.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "TK PENDIDIKAN,SD,SMP,SMPK,SMA,SMAK,SMAG,D1,D2,D3,D4,S1,S2,S3";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->sd.",".$item->sp.",".$item->spk.",".$item->sa.",".$item->sak.",".$item->sag.",".$item->d1.",".$item->d2.",".$item->d3.",".$item->d4.",".$item->s1.",".$item->s2.",".$item->s3."\r\n";
        }
    }
    /*end of statistik unitkerja dan pendidikan formal*/

    /* Graph Unit Kerja dan Golongan */
    function postGraphukerjagol1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(a.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphukerjagol2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(a.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphukerjagol3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(a.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphukerjagol4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(a.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Unit Kerja dan Golongan */

    /* Graph Jenis Kelmain dan Golongan */
    function postGraphjenkelgol1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjenkelgol2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjenkelgol3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphjenkelgol4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jenis Kelamin dan Golongan */

    /* Graph Status Kedudukan Pegawai */
    function postGraphstatuskedudupeg1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.nip != '' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkedudupeg as a')
            ->select('a.idjenkedudupeg','a.jenkedudupeg',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkedudupeg', '=', 'b.idjenkedudupeg')
            ->whereRaw($where)
            ->groupBy('a.idjenkedudupeg')
            ->orderBy('a.idjenkedudupeg', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenkedudupeg.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphstatuskedudupeg2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.nip != '' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkedudupeg as a')
            ->select('a.idjenkedudupeg','a.jenkedudupeg',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkedudupeg', '=', 'b.idjenkedudupeg')
            ->whereRaw($where)
            ->groupBy('a.idjenkedudupeg')
            ->orderBy('a.idjenkedudupeg', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenkedudupeg.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphstatuskedudupeg3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.nip != '' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkedudupeg as a')
            ->select('a.idjenkedudupeg','a.jenkedudupeg',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkedudupeg', '=', 'b.idjenkedudupeg')
            ->whereRaw($where)
            ->groupBy('a.idjenkedudupeg')
            ->orderBy('a.idjenkedudupeg', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenkedudupeg.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphstatuskedudupeg4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.nip != '' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkedudupeg as a')
            ->select('a.idjenkedudupeg','a.jenkedudupeg',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkedudupeg', '=', 'b.idjenkedudupeg')
            ->whereRaw($where)
            ->groupBy('a.idjenkedudupeg')
            ->orderBy('a.idjenkedudupeg', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenkedudupeg.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Status Kedudukan Pegawai */

    /* Graph Diklat Struktural */
    function postGraphdiklatstruktural1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_dikstru as a')
            ->select('a.iddikstru','a.dikstru',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
            ->whereRaw($where)
            ->groupBy('a.iddikstru')
            ->orderBy('a.iddikstru', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->dikstru.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphdiklatstruktural2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_dikstru as a')
            ->select('a.iddikstru','a.dikstru',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
            ->whereRaw($where)
            ->groupBy('a.iddikstru')
            ->orderBy('a.iddikstru', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->dikstru.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphdiklatstruktural3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_dikstru as a')
            ->select('a.iddikstru','a.dikstru',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
            ->whereRaw($where)
            ->groupBy('a.iddikstru')
            ->orderBy('a.iddikstru', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->dikstru.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphdiklatstruktural4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_dikstru as a')
            ->select('a.iddikstru','a.dikstru',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
            ->whereRaw($where)
            ->groupBy('a.iddikstru')
            ->orderBy('a.iddikstru', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->dikstru.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Of Diklat Struktural */

    /* Graph Diklat Eselon */
    function postGrapheselon1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_esl as a')
            ->select('a.idesl','a.esl',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idesl', '=', 'b.idesljbt')
            ->whereRaw($where)
            ->groupBy('a.idesl')
            ->orderBy('a.idesl', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->esl.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGrapheselon2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_esl as a')
            ->select('a.idesl','a.esl',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idesl', '=', 'b.idesljbt')
            ->whereRaw($where)
            ->groupBy('a.idesl')
            ->orderBy('a.idesl', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->esl.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGrapheselon3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_esl as a')
            ->select('a.idesl','a.esl',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idesl', '=', 'b.idesljbt')
            ->whereRaw($where)
            ->groupBy('a.idesl')
            ->orderBy('a.idesl', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->esl.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGrapheselon4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_esl as a')
            ->select('a.idesl','a.esl',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idesl', '=', 'b.idesljbt')
            ->whereRaw($where)
            ->groupBy('a.idesl')
            ->orderBy('a.idesl', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->esl.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Diklat  Eselon */

    /* Graph Jenis Kelmain dan Eselon */
    function postGraphjenkelesl1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idesljbt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idesljbt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idesljbt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idesljbt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjenkelesl2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idesljbt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idesljbt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idesljbt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idesljbt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjenkelesl3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idesljbt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idesljbt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idesljbt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idesljbt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphjenkelesl4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idesljbt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idesljbt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idesljbt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idesljbt='44',1,0)) AS 'ivd'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd."\r\n";
        }
    }

    function postGraphjenkelesl5(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jenkel as a')
            ->select('a.idjenkel','a.jenkel',
            \DB::raw("SUM(IF(b.idesljbt='51',1,0)) AS 'va'"),
            \DB::raw("SUM(IF(b.idesljbt='52',1,0)) AS 'vb'"),
            \DB::raw("SUM(IF(b.idesljbt='53',1,0)) AS 'vc'"),
            \DB::raw("SUM(IF(b.idesljbt='54',1,0)) AS 'vd'")
        )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->groupBy('a.idjenkel')
            ->orderBy('a.idjenkel', 'asc');

        $categories = "TK PENDIDIKAN,V/a,V/b,V/c,V/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
            echo $jnskl.",".$item->va.",".$item->vb.",".$item->vc.",".$item->vd."\r\n";
        }
    }
    /* End Graph Jenis Kelamin dan Eselon */

    /* Graph Agama golongan  */
    function postGraphagama1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_agama as a')
            ->select('a.agama',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idagama', '=', 'b.idagama')
            ->whereRaw($where)
            ->groupBy('a.idagama')
            ->orderBy('a.idagama', 'asc');

        $categories = "AGAMA,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->agama.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphagama2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_agama as a')
            ->select('a.agama',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idagama', '=', 'b.idagama')
            ->whereRaw($where)
            ->groupBy('a.idagama')
            ->orderBy('a.idagama', 'asc');

        $categories = "AGAMA,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->agama.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphagama3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_agama as a')
            ->select('a.agama',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idagama', '=', 'b.idagama')
            ->whereRaw($where)
            ->groupBy('a.idagama')
            ->orderBy('a.idagama', 'asc');

        $categories = "AGAMA,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->agama.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphagama4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_agama as a')
            ->select('a.agama',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idagama', '=', 'b.idagama')
            ->whereRaw($where)
            ->groupBy('a.idagama')
            ->orderBy('a.idagama', 'asc');

        $categories = "AGAMA,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->agama.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Agama golongan */

    /* Graph usia */
    function postGraphusia1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " idjenkedudupeg not in('21','99') and idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01')
            ->select(
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 AS tahun"),
            \DB::raw("SUM(IF(idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(idgolrupkt='14',1,0)) AS 'id'")
        )
            ->whereRaw($where)
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc');

        $categories = "USIA ,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tahun.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphusia2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " idjenkedudupeg not in('21','99') and idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01')
            ->select(
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 AS tahun"),
            \DB::raw("SUM(IF(idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->whereRaw($where)
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc');

        $categories = "USIA,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tahun.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphusia3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " idjenkedudupeg not in('21','99') and idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01')
            ->select(
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 AS tahun"),
            \DB::raw("SUM(IF(idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->whereRaw($where)
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc');

        $categories = "USIA,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tahun.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphusia4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " idjenkedudupeg not in('21','99') and idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01')
            ->select(
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tglhr)), '%Y')+0 AS tahun"),
            \DB::raw("SUM(IF(idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->whereRaw($where)
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc');

        $categories = "USIA,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tahun.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph usia */

    /* Graph Perkawinan */
    function postGraphperkawinan1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_stskawin as a')
            ->select('a.stskawin',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idstskawin', '=', 'b.idstskawin')
            ->whereRaw($where)
            ->groupBy('a.idstskawin')
            ->orderBy('a.idstskawin', 'asc');

        $categories = "STS KAWIN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->stskawin.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphperkawinan2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_stskawin as a')
            ->select('a.stskawin',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idstskawin', '=', 'b.idstskawin')
            ->whereRaw($where)
            ->groupBy('a.idstskawin')
            ->orderBy('a.idstskawin', 'asc');

        $categories = "STS KAWIN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->stskawin.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphperkawinan3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_stskawin as a')
            ->select('a.stskawin',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idstskawin', '=', 'b.idstskawin')
            ->whereRaw($where)
            ->groupBy('a.idstskawin')
            ->orderBy('a.idstskawin', 'asc');

        $categories = "STS KAWIN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->stskawin.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphperkawinan4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_stskawin as a')
            ->select('a.stskawin',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idstskawin', '=', 'b.idstskawin')
            ->whereRaw($where)
            ->groupBy('a.idstskawin')
            ->orderBy('a.idstskawin', 'asc');

        $categories = "STS KAWIN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->stskawin.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Perkawinan*/

    /* Graph Jabatan Fungsional */
    function postGraphJabfung1(){
        $where = " b.idjenkedudupeg not in('21','99')";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.jabfung2',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', function($join){
            $join->on('a.idjabfung', '=', 'b.idjabfung')->where('b.idjenjab', '=', 2);
        })
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idjabfung,3)"))
            ->orderBy('a.jabfung2', 'asc');

        $categories = "JABATAN FUNGSIONAL,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphJabfung2(){
        $where = " b.idjenkedudupeg not in('21','99')";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.jabfung2',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', function($join){
            $join->on('a.idjabfung', '=', 'b.idjabfung')->where('b.idjenjab', '=', 2);
        })
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idjabfung,3)"))
            ->orderBy('a.jabfung2', 'asc');

        $categories = "JABATAN FUNGSIONAL,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphJabfung3(){
        $where = " b.idjenkedudupeg not in('21','99')";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.jabfung2',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', function($join){
            $join->on('a.idjabfung', '=', 'b.idjabfung')->where('b.idjenjab', '=', 2);
        })
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idjabfung,3)"))
            ->orderBy('a.jabfung2', 'asc');

        $categories = "JABATAN FUNGSIONAL,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }

    function postGraphJabfung4(){
        $where = " b.idjenkedudupeg not in('21','99')";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.jabfung2',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', function($join){
            $join->on('a.idjabfung', '=', 'b.idjabfung')->where('b.idjenjab', '=', 2);
        })
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idjabfung,3)"))
            ->orderBy('a.jabfung2', 'asc');

        $categories = "JABATAN FUNGSIONAL,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jabatan Fungsional */

    /* Graph Jabatan Fungsional Guru dan Golongan*/
    function postGraphjabfungguru1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) AS jenjang"),
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy('a.issek')
            ->orderBy('a.issek', 'asc');

        $categories = "TK PENDIDIKAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenjang.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabfungguru2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) AS jenjang"),
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy('a.issek')
            ->orderBy('a.issek', 'asc');

        $categories = "TK PENDIDIKAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenjang.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjabfungguru3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) AS jenjang"),
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy('a.issek')
            ->orderBy('a.issek', 'asc');

        $categories = "TK PENDIDIKAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenjang.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }


    function postGraphjabfungguru4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) AS jenjang"),
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
            ->whereRaw($where)
            ->groupBy('a.issek')
            ->orderBy('a.issek', 'asc');

        $categories = "TK PENDIDIKAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenjang.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jabatan Fungsional Guru */

    /*statistik unitkerja dan pendidikan formal*/
    public function postGraphjabfungguruunker(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

                $rs = \DB::table('a_skpd as a')
              ->select('a.idskpd','a.issek','a.skpd',
                // \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) as jenjang"),
                // \DB::raw("SUM(IF(a.issek!='',1,0)) AS 'total'"),
                // \DB::raw("COUNT(*) AS 'total'"),
                \DB::raw("left(a.idskpd,2) as idskpd,replace(a.skpd,',',' ') as skpd"),
                \DB::raw("SUM(IF(a.issek='',1,0)) AS 'empty'"),
                \DB::raw("SUM(IF(a.issek='1',1,0)) AS 'tk'"),
                \DB::raw("SUM(IF(a.issek='2',1,0)) AS 'sd'"),
                \DB::raw("SUM(IF(a.issek='3',1,0)) AS 'smp'"),
                \DB::raw("SUM(IF(a.issek='4',1,0)) AS 'dpk'"),
                \DB::raw("SUM(IF(a.issek='5',1,0)) AS 'sma'")
                )
              ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
              ->whereRaw($where)
              ->orderBy('a.idskpd', 'asc')
              // ->groupBy(\DB::raw('left(a.idskpd,2)'));
              ->groupBy('a.idskpd');

        $categories = "Jabatan Fungsional Guru,TK,SD,SMP,DPK,SMA/SMK";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->tk.",".$item->sd.",".$item->smp.",".$item->dpk.",".$item->sma."\r\n";
        }
    }
    /*end of statistik unitkerja dan pendidikan formal*/

    /* Graph Jabatan Pelaksana dan Golongan*/
    function postGraphjabpelaksanagol1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 3 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfungum as a')
            ->select('a.idjabfungum','a.jabfungum',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfungum', '=', 'b.idjabfungum')
            ->whereRaw($where)
            ->groupBy('a.idjabfungum')
            ->orderBy('a.idjabfungum', 'asc');

        $categories = "JABATAN PELAKSANA,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfungum.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabpelaksanagol2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 3 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfungum as a')
            ->select('a.idjabfungum','a.jabfungum',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfungum', '=', 'b.idjabfungum')
            ->whereRaw($where)
            ->groupBy('a.idjabfungum')
            ->orderBy('a.idjabfungum', 'asc');

        $categories = "JABATAN PELAKSANA,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfungum.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjabpelaksanagol3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 3 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfungum as a')
            ->select('a.idjabfungum','a.jabfungum',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfungum', '=', 'b.idjabfungum')
            ->whereRaw($where)
            ->groupBy('a.idjabfungum')
            ->orderBy('a.idjabfungum', 'asc');

        $categories = "JABATAN PELAKSANA,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfungum.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }


    function postGraphjabpelaksanagol4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 3 and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfungum as a')
            ->select('a.idjabfungum','a.jabfungum',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfungum', '=', 'b.idjabfungum')
            ->whereRaw($where)
            ->groupBy('a.idjabfungum')
            ->orderBy('a.idjabfungum', 'asc');

        $categories = "JABATAN PELAKSANA,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfungum.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jabatan Pelaksana dan Golongan */

    /* Graph Jabatan Fungsional Kesehatan dan Golongan*/
    function postGraphjabfungkesehatan1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '2' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG KESEHATAN,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabfungkesehatan2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '2' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG KESEHATAN,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjabfungkesehatan3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '2' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG KESEHATAN,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }


    function postGraphjabfungkesehatan4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '2' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG KESEHATAN,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jabatan Fungsional kesehatan */

    /* Graph Jabatan Fungsional Kesehatan dan Golongan*/
    function postGraphjabfungteknis1(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '3' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG TEKNIS,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabfungteknis2(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '3' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG TEKNIS,II/a,II/b,II/c,II/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
        }
    }

    function postGraphjabfungteknis3(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '3' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
            \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
            \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
            \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG TEKNIS,III/a,III/b,III/c,III/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
        }
    }


    function postGraphjabfungteknis4(){
        $idstspeg = implode(",",Input::get('idstspeg'));
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND a.isguru = '3' and b.idstspeg in(".$idstspeg.")";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung','a.jabfung2','a.tingkat',
            \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
            \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
            \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
            \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
            \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
        )
            ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
            ->whereRaw($where)
            ->groupBy('a.tingkat')
            ->orderBy('a.tingkat', 'asc');

        $categories = "JABFUNG TEKNIS,IV/a,IV/b,IV/c,IV/d,IV/e";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
        }
    }
    /* End Graph Jabatan Fungsional Guru */
    /* Graph Rekap Unit Kerja jabatan dan Golongan */
    function postGraphrekapjabatangol1(){
          $where = " b.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
            \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'strukdua'"),
            \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'struktiga'"),
            \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'strukempat'"),
            \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='5',1,0)) AS 'struklima'")
        )
            ->leftjoin('tb_01 as b', \DB::raw("LEFT(b.idskpd,2)"), '=', 'a.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('left(b.idskpd,2)'))
            ->orderBy('a.idskpd', 'asc');

        $categories = "JABATAN STRUKTURAL,II,III,IV,V";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->skpd.",".$item->strukdua.",".$item->struktiga.",".$item->strukempat.",".$item->struklima."\r\n";
        }
    }

    function postGraphrekapjabatangol2(){
      $where = " b.idjenkedudupeg not in('21','99')";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

    $rs = \DB::table('a_skpd as a')
        ->select(
        \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
        \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='1',1,0)) AS 'fungsatu'"),
        \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'fungdua'"),
        \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'fungtiga'"),
        \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'fungempat'")
    )
        ->leftjoin('tb_01 as b', \DB::raw("LEFT(b.idskpd,2)"), '=', 'a.idskpd')
        ->whereRaw($where)
        ->groupBy(\DB::raw('left(b.idskpd,2)'))
        ->orderBy('a.idskpd', 'asc');

    $categories = "JABATAN FUNGSIONAL,II,III,IV,V";
    echo $categories."\r\n";
    foreach($rs->get() as $item){
        echo $item->skpd.",".$item->fungsatu.",".$item->fungdua.",".$item->fungtiga.",".$item->fungempat."\r\n";
    }
    }

    function postGraphrekapjabatangol3(){
      $where = " b.idjenkedudupeg not in('21','99')";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

    $rs = \DB::table('a_skpd as a')
        ->select(
        \DB::raw("a.idskpd,replace(a.skpd,',',' ') as skpd"),
        \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='1',1,0)) AS 'pelsatu'"),
        \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'peldua'"),
        \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'peltiga'"),
        \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'pelempat'")
    )
        ->leftjoin('tb_01 as b', \DB::raw("LEFT(b.idskpd,2)"), '=', 'a.idskpd')
        ->whereRaw($where)
        ->groupBy(\DB::raw('left(b.idskpd,2)'))
        ->orderBy('a.idskpd', 'asc');

    $categories = "JABATAN PELAKSANA,II,III,IV,V";
    echo $categories."\r\n";
    foreach($rs->get() as $item){
        echo $item->skpd.",".$item->pelsatu.",".$item->peldua.",".$item->peltiga.",".$item->pelempat."\r\n";
    }
    }

    /* End Graph Rekap Unit Kerja jabatan dan Golongan */
    /* Graph Rekap Jabatan Struktural dan Golongan*/
    function postGraphjabstrugol1(){
        $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab>='20'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
            \DB::raw("SUM(IF(a.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(a.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(a.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(a.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->whereRaw($where);

        $categories = "JABSTRU I,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo "JABSTRU I ,".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabstrugol2(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab>='20'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='21',1,0)) AS 'iia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='22',1,0)) AS 'iib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='23',1,0)) AS 'iic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='24',1,0)) AS 'iid'")
      )
          ->whereRaw($where);

      $categories = "JABSTRU II,II/a,II/b,II/c,II/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABSTRU II ,".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
      }
    }

    function postGraphjabstrugol3(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab>='20'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='31',1,0)) AS 'iiia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='32',1,0)) AS 'iiib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='33',1,0)) AS 'iiic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='34',1,0)) AS 'iiid'")
      )
          ->whereRaw($where);

      $categories = "JABSTRU III,III/a,III/b,III/c,III/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABSTRU III ,".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
      }
    }


    function postGraphjabstrugol4(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab>='20'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='41',1,0)) AS 'iva'"),
          \DB::raw("SUM(IF(a.idgolrupkt='42',1,0)) AS 'ivb'"),
          \DB::raw("SUM(IF(a.idgolrupkt='43',1,0)) AS 'ivc'"),
          \DB::raw("SUM(IF(a.idgolrupkt='44',1,0)) AS 'ivd'"),
          \DB::raw("SUM(IF(a.idgolrupkt='45',1,0)) AS 'ive'")
      )
          ->whereRaw($where);

      $categories = "JABSTRU IV,IV/a,IV/b,IV/c,IV/d,IVe";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABSTRU IV ,".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
      }
    }

    /* End Graph Rekap Jabatan Struktural dan Golongan */
    /* Graph Rekap Jabatan Fungsional dan Golongan*/
    function postGraphjabfunggol1(){
        $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='2'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
            \DB::raw("SUM(IF(a.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(a.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(a.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(a.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->whereRaw($where);

        $categories = "JABFUNG I,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo "JABFUNG I ,".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabfunggol2(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='2'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='21',1,0)) AS 'iia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='22',1,0)) AS 'iib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='23',1,0)) AS 'iic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='24',1,0)) AS 'iid'")
      )
          ->whereRaw($where);

      $categories = "JABFUNG II,II/a,II/b,II/c,II/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNG II ,".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
      }
    }

    function postGraphjabfunggol3(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='2'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='31',1,0)) AS 'iiia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='32',1,0)) AS 'iiib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='33',1,0)) AS 'iiic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='34',1,0)) AS 'iiid'")
      )
          ->whereRaw($where);

      $categories = "JABFUNG III,III/a,III/b,III/c,III/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNG III ,".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
      }
    }


    function postGraphjabfunggol4(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='2'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='41',1,0)) AS 'iva'"),
          \DB::raw("SUM(IF(a.idgolrupkt='42',1,0)) AS 'ivb'"),
          \DB::raw("SUM(IF(a.idgolrupkt='43',1,0)) AS 'ivc'"),
          \DB::raw("SUM(IF(a.idgolrupkt='44',1,0)) AS 'ivd'"),
          \DB::raw("SUM(IF(a.idgolrupkt='45',1,0)) AS 'ive'")
      )
          ->whereRaw($where);

      $categories = "JABFUNG IV,IV/a,IV/b,IV/c,IV/d,IVe";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNG IV ,".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
      }
    }

    /* End Graph Rekap Jabatan Fungsional dan Golongan */
    /* Graph Rekap Jabatan Fungsional Umum dan Golongan*/
    function postGraphjabfungumgol1(){
        $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='3'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
            \DB::raw("SUM(IF(a.idgolrupkt='11',1,0)) AS 'ia'"),
            \DB::raw("SUM(IF(a.idgolrupkt='12',1,0)) AS 'ib'"),
            \DB::raw("SUM(IF(a.idgolrupkt='13',1,0)) AS 'ic'"),
            \DB::raw("SUM(IF(a.idgolrupkt='14',1,0)) AS 'id'")
        )
            ->whereRaw($where);

        $categories = "JABFUNGUM I,I/a,I/b,I/c,I/d";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo "JABFUNGUM I ,".$item->ia.",".$item->ib.",".$item->ic.",".$item->id."\r\n";
        }
    }

    function postGraphjabfungumgol2(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='3'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='21',1,0)) AS 'iia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='22',1,0)) AS 'iib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='23',1,0)) AS 'iic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='24',1,0)) AS 'iid'")
      )
          ->whereRaw($where);

      $categories = "JABFUNGUM II,II/a,II/b,II/c,II/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNGUM II ,".$item->iia.",".$item->iib.",".$item->iic.",".$item->iid."\r\n";
      }
    }

    function postGraphjabfungumgol3(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='3'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='31',1,0)) AS 'iiia'"),
          \DB::raw("SUM(IF(a.idgolrupkt='32',1,0)) AS 'iiib'"),
          \DB::raw("SUM(IF(a.idgolrupkt='33',1,0)) AS 'iiic'"),
          \DB::raw("SUM(IF(a.idgolrupkt='34',1,0)) AS 'iiid'")
      )
          ->whereRaw($where);

      $categories = "JABFUNGUM III,III/a,III/b,III/c,III/d";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNGUM III ,".$item->iiia.",".$item->iiib.",".$item->iiic.",".$item->iiid."\r\n";
      }
    }


    function postGraphjabfungumgol4(){
      $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab='3'";
      if(Input::get('idskpd') != ''){
          $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
      }else{
          $where .= "";
      }

      $rs = \DB::table('tb_01 as a')
          ->select(
          \DB::raw("SUM(IF(a.idgolrupkt='41',1,0)) AS 'iva'"),
          \DB::raw("SUM(IF(a.idgolrupkt='42',1,0)) AS 'ivb'"),
          \DB::raw("SUM(IF(a.idgolrupkt='43',1,0)) AS 'ivc'"),
          \DB::raw("SUM(IF(a.idgolrupkt='44',1,0)) AS 'ivd'"),
          \DB::raw("SUM(IF(a.idgolrupkt='45',1,0)) AS 'ive'")
      )
          ->whereRaw($where);

      $categories = "JABFUNGUM IV,IV/a,IV/b,IV/c,IV/d,IVe";
      echo $categories."\r\n";
      foreach($rs->get() as $item){
          echo "JABFUNGUM IV ,".$item->iva.",".$item->ivb.",".$item->ivc.",".$item->ivd.",".$item->ive."\r\n";
      }
    }

    /* End Graph Rekap Jabatan Fungsional Umum dan Golongan */

    /* End Graph Rekap Profil PNS Menurut Golongan */
    function postGraphrekapgol(){
          $where = " a.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('tb_01 as a')
              ->select(
                  'a.idgolrupkt', 'b.idgolru', 'a.idjenkel',
                    \DB::raw("
                    IF(LEFT(a.idgolrupkt,1)=1 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan I',
                    IF(LEFT(a.idgolrupkt,1)=1 && IF(idstspeg = 3,1,0),'PPPK - Golongan I - IV',
                    IF(LEFT(a.idgolrupkt,1)=2 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan II',
                    IF(LEFT(a.idgolrupkt,1)=2 && IF(idstspeg = 3,1,0),'PPPK - Golongan V - VIII',
                    IF(LEFT(a.idgolrupkt,1)=3 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan III',
                    IF(LEFT(a.idgolrupkt,1)=3 && IF(idstspeg = 3,1,0),'PPPK - Golongan IX - XII',
                    IF(LEFT(a.idgolrupkt,1)=4 && IF(idstspeg <> 3,1,0),'CPNS/PNS - Golongan IV',
                    IF(LEFT(a.idgolrupkt,1)=4 && IF(idstspeg = 3,1,0),'PPPK - Golongan XIII - XVII',
                    '- Golongan Kosong')))))))) as golongan
                  "),
                  \DB::raw("COUNT(*) AS 'totalgol'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
            ->join('a_golruang as b', \DB::raw("a.idgolrupkt"), '=', 'b.idgolru')
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idgolru,1), golongan"));

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->golongan.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Golongan */

    /* End Graph Rekap Profil PNS Menurut Tingkat Pendidikan */
    function postGraphrekappendidikan(){
          $where = " a.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('tb_01 as a')
              ->select(
                  'a.idtkpendid', 'b.tkpendid',
                  \DB::raw("COUNT(*) AS 'totalpendid'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
            ->join('a_tkpendid as b', \DB::raw("a.idtkpendid"), '=', 'b.idtkpendid')
            ->whereRaw($where)
            ->groupBy('a.idtkpendid');

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->tkpendid.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Tingkat Pendidikan */

    /* End Graph Rekap Profil PNS Menurut Jabatan Struktural */
    function postGraphrekapjabstru(){
          $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab >= '20'";
          if(Input::get('idskpd') != ''){
              $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('tb_01 as a')
              ->select(
                  'a.idesljbt', 'b.esl',
                  \DB::raw("COUNT(*) AS 'totaleslstruk'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
            ->join('a_esl as b', \DB::raw("a.idesljbt"), '=', 'b.idesl')
            ->whereRaw($where)
            ->groupBy('a.idesljbt');

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->esl.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Jabatan Struktural */

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Pendidik */
    function postGraphrekaptenagapendidik(){
          $where = " a.idjenkedudupeg not in('21','99') and a.idjenjab = 2 and LEFT(a.idjabfung,3) = '300'";
          if(Input::get('idskpd') != ''){
              $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('tb_01 as a')
              ->select(
                  'b.issek',
                  \DB::raw("IF(b.issek=1,'TK',IF(b.issek=2,'SD',IF(b.issek=3,'SMP',IF(b.issek=4,'DPK',IF(b.issek=5,'SMA/SMK','-'))))) as jenjang"),
                  \DB::raw("COUNT(*) AS 'totalguru'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
              ->join('a_skpd as b', \DB::raw("a.idskpd"), '=', 'b.idskpd')
              ->whereRaw($where)
              ->groupBy('b.issek');

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenjang.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Pendidik */

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Kesehatan */
    function postGraphrekaptenagakesehatan(){
          $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND a.isguru = '2'";
          if(Input::get('idskpd') != ''){
              $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('a_jabfung as a')
              ->select(
                  'a.idjabfung','a.jabfung2','a.tingkat',
                  \DB::raw("COUNT(*) AS 'totalkesehatan'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
              ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
              ->whereRaw($where)
              ->groupBy('a.tingkat');

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Kesehatan */

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Teknis */
    function postGraphrekaptenagateknis(){
          $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND a.isguru = '3'";
          if(Input::get('idskpd') != ''){
              $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('a_jabfung as a')
              ->select(
                  'a.idjabfung','a.jabfung2','a.tingkat',
                  \DB::raw("COUNT(*) AS 'totalteknis'"),
                  \DB::raw("SUM(IF(idjenkel=1,1,0)) AS 'pria'"),
                  \DB::raw("SUM(IF(idjenkel=2,1,0)) AS 'wanita'")
              )
              ->leftjoin('tb_01 as b', 'a.idjabfung', '=', 'b.idjabfung')
              ->whereRaw($where)
              ->groupBy('a.tingkat');

        $categories = "JENIS KELAMIN,PRIA,WANITA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jabfung2.",".$item->pria.",".$item->wanita."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Jabfung Tenaga Teknis */

    /* End Graph Rekap Profil PNS Menurut Diklat Struktural */
    function postGraphrekapdiklatstruktural(){
          $where = " b.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('a_dikstru as a')
              ->select(
                  'a.iddikstru','a.dikstru',
                  \DB::raw("COUNT(*) AS 'totaldikstru'")
              )
              ->leftjoin('tb_01 as b', 'a.iddikstru', '=', 'b.iddikstru')
              ->whereRaw($where)
              ->groupBy('a.iddikstru');

        $categories = "DIKLAT STRUKTURAL,JUMLAH";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->dikstru.",".$item->totaldikstru."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Diklat Struktural */

    /* End Graph Rekap Profil PNS Menurut Jenis Kelamin */
    function postGraphrekapjeniskelamin(){
          $where = " b.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('a_jenkel as a')
              ->select(
                  'a.idjenkel','a.jenkel',
                  \DB::raw("COUNT(*) AS 'totaljenkel'")
              )
              ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
              ->whereRaw($where)
              ->groupBy('a.idjenkel');

        $categories = "JENIS KELAMIN,JUMLAH";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            echo $item->jenkel.",".$item->totaljenkel."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Jenis Kelamin */

    /* End Graph Rekap Profil PNS Menurut Usia */
    function postGraphrekapusia(){
          $where = " a.idjenkedudupeg not in('21','99')";
          if(Input::get('idskpd') != ''){
              $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
          }else{
              $where .= "";
          }

          $rs = \DB::table('tb_01 as a')
              ->select(
                  'a.tglhr',
                  // \DB::raw("COUNT(*) AS 'totalusia'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 != '',1,0)) AS 'totalusia'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '1800'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '2000',1,0)) AS 'usia1'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2100'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '2500',1,0)) AS 'usia2'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '2600'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '3000',1,0)) AS 'usia3'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3100'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '3500',1,0)) AS 'usia4'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '3600'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '4000',1,0)) AS 'usia5'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4100'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '4500',1,0)) AS 'usia6'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '4600'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '5000',1,0)) AS 'usia7'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5100'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '5500',1,0)) AS 'usia8'"),
                  \DB::raw("SUM(IF(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 >= '5600'
                            AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 <= '6000',1,0)) AS 'usia9'")
              )
              ->whereRaw($where);

        $categories = "RENTANG USIA, USIA 18 - 20, USIA 21 - 25, USIA 26 - 30, USIA 31 - 35, USIA 36 - 40, USIA 41 - 45, USIA 46 - 50, USIA 51 - 55, USIA 56 - 60";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            // echo $item->jenkel.",".$item->totaljenkel."\r\n";
            echo "Jumlah,".$item->usia1.",".$item->usia2.",".$item->usia3.",".$item->usia4.",".$item->usia5.",".$item->usia6.",".$item->usia7.",".$item->usia8.",".$item->usia9."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Usia */

    /* End Graph Rekap Profil PNS Menurut Pensiun PNS */
    function postGraphrekappensiun(){
        $where = " a.idjenkedudupeg not in ('21') and a.idjenkedudupeg='99' and a.nip !=''";
        if(Input::get('idskpd') != ''){
            $where .= " and a.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        /* Kondisi Tahun */
        if(Input::get('tahun') != ''){
            $where .= " and YEAR(a.tmtpens)= ".Input::get('tahun')."";
        }

        /* Kondisi Bulan */
        if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
            $where .= " and MONTH(a.tmtpens) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
        }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
            $where .= " and MONTH(a.tmtpens)= ".Input::get('bulan1')."";
        }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
            $where .= " and MONTH(a.tmtpens)= ".Input::get('bulan2')."";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.idjenpens',
                \DB::raw("SUM(IF(a.idjenpens='1',1,0)) AS 'bup'"),
                \DB::raw("SUM(IF(a.idjenpens='2',1,0)) AS 'meninggal'"),
                \DB::raw("SUM(IF(a.idjenpens='3',1,0)) AS 'aps'"),
                \DB::raw("SUM(IF(a.idjenpens='4',1,0)) AS 'pindah'"),
                \DB::raw("SUM(IF(a.idjenpens='5',1,0)) AS 'berhenti'"),
                \DB::raw("SUM(IF(a.idjenpens='6',1,0)) AS 'dujan'")
            )
            ->whereRaw($where);

        $categories = "KATEGORI,BUP, MENINGGAL, ATAS PERMINTAAN SENDIRI, PINDAH KE LAIN DAERAH, DIBERHENTIKAN, JANDA/DUDA";
        echo $categories."\r\n";
        foreach($rs->get() as $item){
            // echo $item->jenkel.",".$item->totaljenkel."\r\n";
            echo "JUMLAH,".$item->bup.",".$item->meninggal.",".$item->aps.",".$item->pindah.",".$item->berhenti.",".$item->dujan."\r\n";
        }
    }

    /* End Graph Rekap Profil PNS Menurut Pensiun PNS */
}
