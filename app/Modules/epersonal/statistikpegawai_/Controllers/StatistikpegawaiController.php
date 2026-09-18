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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.nip != ''";
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
        $where = " b.nip != ''";
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
        $where = " b.nip != ''";
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
        $where = " b.nip != ''";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 1";
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
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 1";
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
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 1";
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
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 1";
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
        $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 1";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " idjenkedudupeg not in('21','99')";
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
        $where = " idjenkedudupeg not in('21','99')";
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
        $where = " idjenkedudupeg not in('21','99')";
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
        $where = " idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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
        $where = " b.idjenkedudupeg not in('21','99')";
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

    /* Graph Jabatan Fungsional Guru */
    function graphJabfungguru1(){
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '004'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'SMA',IF(a.issek=5,'SMK','-'))))) AS jenjang"),
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

    function graphJabfungguru2(){
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '004'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'SMA',IF(a.issek=5,'SMK','-'))))) AS jenjang"),
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

    function graphJabfungguru3(){
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '004'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'SMA',IF(a.issek=5,'SMK','-'))))) AS jenjang"),
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

    function graphJabfungguru4(){
        $where = " b.idjenkedudupeg not in('21','99') AND b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '004'";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
            \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'SMA',IF(a.issek=5,'SMK','-'))))) AS jenjang"),
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
}
