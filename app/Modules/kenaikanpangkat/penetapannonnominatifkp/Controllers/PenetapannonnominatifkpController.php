<?php namespace App\Modules\kenaikanpangkat\penetapannonnominatifkp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\penetapannonnominatifkp\Models\PenetapannonnominatifkpModel;
use Input,View, Request, Form, File;

/**
 * Penetapannonnominatifkp Controller
 * @var Penetapannonnominatifkp
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Divisi Software Development - Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class PenetapannonnominatifkpController extends Controller {
    protected $penetapannonnominatifkp;

    public function __construct(PenetapannonnominatifkpModel $penetapannonnominatifkp){
        $this->penetapannonnominatifkp = $penetapannonnominatifkp;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_kenaikan_pangkat.isnom = 2";
        if(session('role_id') > 3){
            $where .= " and tr_kenaikan_pangkat.idskpd like \"".session('idskpd')."%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('bulan') != '') or (Input::get('tahun') != '') or (Input::get('idskpd') != '') or (Input::get('statussk') != '') or (Input::get('idjeniskp') != '') or (Input::get('statususul') != '')) {
            if(Input::get('bulan') != ''){
                $where .= " and MID(tr_kenaikan_pangkat.tmt,6,2) = \"".Input::get('bulan')."\"";
            }

            if(Input::get('tahun') != ''){
                $where .= " and MID(tr_kenaikan_pangkat.tmt,1,4) = \"".Input::get('tahun')."\"";
            }

            if(Input::get('statussk') != ''){
                $where .= " and tr_kenaikan_pangkat.statussk = \"".Input::get('statussk')."\"";
            }

            if(Input::get('statususul') != ''){
                $where .= " and tr_kenaikan_pangkat.statususul = \"".Input::get('statususul')."\"";
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

            $penetapannonnominatifkps = $this->penetapannonnominatifkp
                ->select('tr_kenaikan_pangkat.*','a_skpd.issek','a_skpd.path_short','a_jenjab.jenjab','a_golruang.golru','a_golruang.pangkat','tb_01.tmlhr','tb_01.tglhr','tb_01.nokarpeg',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                    \DB::raw('a_golruangbaru.golru as golrubaru, a_golruangbaru.pangkat as pangkatbaru')
                )
                ->join('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
                ->join('a_skpd', 'tr_kenaikan_pangkat.idskpd', '=', 'a_skpd.idskpd')
                ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
                ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
                ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->whereRaw($where)
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt')
                // ->orderBy('idskpd')
                // ->orderBy('tr_kenaikan_pangkat.idjeniskp') //
                // ->groupBy(\DB::raw('tmt, idskpd, idjeniskp'))
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $penetapannonnominatifkps = $this->penetapannonnominatifkp->all();
        }
        return View::make('penetapannonnominatifkp::index', compact('penetapannonnominatifkps'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('penetapannonnominatifkp::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","tglusul","_token","tmtx");
        $arrindex   = array("","idusul","nip");
        $keyin      = array("","idusul","nip");
        $keyout     = array("","idusul","nip");
        $keydate    = array('','tmt');

        $dt['nousul'] = \PenetapannominatifkpModel::nourut(date("Y-m-d", strtotime(Input::get('tmtx'))));
        $dt['created_at']= sekarang();
        $dt['role_id']   = \session::get('role_id') ;
        $dt['user_id']   = \session::get('user_id') ;

        foreach($_POST as $key=>$value){

            if(array_search($key,$arrnot)==""){
                if(array_search($key,$keyin)!=""){
                    $keys =  array_keys($keyin,$key);
                    $key  = $keyout[$keys[0]];
                }
                if(!is_array($value)){
                    $dt[$key] = $value;
                    if(array_search($key,$arrindex)!=""){
                        //$dti[$key] = $value;
                    }
                }

                if(is_array($value)){
                    foreach($value as $key2=>$value2){
                        $dt[$key2] = $value2;
                        if(array_search($key2,$arrindex)!=""){
                            //$dti[$key2] = $value2;
                        }
                        if(array_search($key2,$keydate)!=''){
                            if($value2 != ''){
                                $val = explode("-",$value2);
                                $dt[$key2] = $val[2]."-".$val[1]."-".$val[0];
                            }else{
                                $dt[$key2] = '0000-00-00';
                            }
                        }
                    }
                    $rssimpan = \DB::table('tr_kenaikan_pangkat')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penetapannonnominatifkp = $this->penetapannonnominatifkp->find($id);
        //if (is_null($penetapannonnominatifkp)){return \Redirect::to('kenaikanpangkat/penetapannonnominatifkp/index');}
        return View::make('penetapannonnominatifkp::edit', compact('penetapannonnominatifkp'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannonnominatifkpModel::$rules);

        if ($validation->passes()){
            $penetapannonnominatifkp = $this->penetapannonnominatifkp->find($id);
            echo ($penetapannonnominatifkp->update($input))?4:"Gagal Disimpan";
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
                $this->penetapannonnominatifkp->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penetapannonnominatifkp->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    public function postGaji(){
        cekAjax();
        $golongan = Input::get('idgolrupktb');
        $thmasker = Input::get('mktkpb');
        echo getGaji($golongan, $thmasker);
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('penetapannonnominatifkp::'.$view.'_view');
    }

    /*function print atribut dari link */
    public function postData(){
        $data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('penetapannonnominatifkp::'.$view.'_data', $data);
    }

    //cari data pegawai sesuai jenis kp fungsional
    public function postCarifungsional()
    {
        cekAjax();
        $keyword 	= Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $where = "(a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\" and a.idjenjab=2)";
        if (session('role_id') == 4) {
            $where .= " and a.idskpd like \"".session('idskpd')."%\" and a.idjenkedudupeg not in (99,21) and a.idjenjab=2";
        }

        $rs = \DB::table('tb_01 as a')
            ->select(
                'a.nip',
                'a.nama',
                'a.nip as id',
                'a.nama as text',
                'a.photo',
                'b.skpd',
                \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
            )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
            ->whereRaw($where)
            /*->where('a.nip', 'like', '%'.$keyword. '%')
            ->orwhere('a.nama', 'like', '%'.$keyword. '%')*/
            ->orderBy('a.nama', 'asc')
            ->orderBy('a.nip', 'asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }


    function postCetak(){
        $view = Request::segment(4);
        return View::make('penetapannonnominatifkp::'.$view.'_print');
    }

    function getCetaknonnominatif(){
        return View::make('penetapannonnominatifkp::nonnominatif_print');
    }

    /*function untuk cek usulan sudah ada tau belum*/
    //input get n nominatif pegawai dr sini
    function postCeknominatif(){
        $nip = Input::get('nip');
        $idjeniskp = Input::get('idjeniskp');
        $tmtx = date("Y-m-d", strtotime(Input::get('tmtx')));

        $rs = \DB::table('tr_kenaikan_pangkat')
            ->where('nip','=',$nip)
            ->where('idjeniskp', '=', $idjeniskp)
            ->where('tmt', '=', $tmtx)
            ->count();
        if($rs){
            echo 1;
        } else{
            echo 2;
        }
    }

    function postVerifsemua(){
        cekAjax();
        $input = Input::all();
        
        $dt['nousul'] = $input['nousul'];

        if(Input::get('statususul') == 1){
            $data = array(
                'statususul' => Input::get('statususul'),
                'statussk' => Input::get('statussk'),
                'iscetaksk' => Input::get('iscetaksk'),
                'kepalabkd' =>Input::get('kepalabkd'),
		        'nipkepalabkd' =>Input::get('nipkepalabkd'),
		        'jabkepalabkd' =>Input::get('jabkepalabkd'),
		        'pangkatbkd' =>Input::get('pangkatbkd'),
		        'nosk' =>Input::get('nosk'),
                'tglsurat' => date("Y-m-d", strtotime(Input::get('tglsurat'))),
                'tmt' => date("Y-m-d", strtotime(Input::get('tmt'))),
                'updated_at' => sekarang(),
                'user_id' => session('user_id')
            );
        }else if(Input::get('statususul') == 2){
            $data = array(
                'statususul' => Input::get('statususul'),
                'kettms' => Input::get('kettms'),
                'updated_at' => sekarang(),
                'user_id' => session('user_id')
            );
        }else {
            $data = array(
                'statususul' => Input::get('statususul'),
                'ketbtl' => Input::get('ketbtl'),
                'updated_at' => sekarang(),
                'user_id' => session('user_id')
            );
        }

        if(!\DB::table('tr_kenaikan_pangkat')->where($dt)->update($data)){
            echo "Verifikasi Kenaikan Pangkat gagal disimpan";
        }else{
            echo 4;
        }
       
    }

}
