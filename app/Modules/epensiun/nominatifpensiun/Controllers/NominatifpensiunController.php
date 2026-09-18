<?php namespace App\Modules\epensiun\nominatifpensiun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\epensiun\nominatifpensiun\Models\NominatifpensiunModel;
use Input,View, Request, Form, File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

/**
* Nominatifpensiun Controller
* @var Nominatifpensiun
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifpensiunController extends Controller {

	/**
	 * Nominatifpensiun Repository
	 *
	 * @var Nominatifpensiun
	 */
	protected $nominatifpensiun;

	public function __construct(NominatifpensiunModel $nominatifpensiun){
		$this->nominatifpensiun = $nominatifpensiun;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex(){
            cekAjax();
            // dd('jooos');
            $where = " tr_pensiun.idjenkedudupeg != 1 and tr_pensiun.nip != '' ";
            if(session('role_id') > 3){
                if(session('role_id') == 5){
                    $where .= " and tr_pensiun.nip = \"".session('user_id')."\" ";
                }else{       
                    $where .= " and b.idskpd like \"".session('idskpd')."%\" ";
                }        
            }
            if (Input::has('search') or Input::has('idskpd') or Input::has('tahun') or Input::has('bulan') or (Input::get('statussk') != '') or (Input::get('idjenpens') != '')) {                    
                if(Input::get('tahun') != ''){
                    $where .= (($where != '')?' AND ':'')." YEAR(tr_pensiun.tmtpens)= ".Input::get('tahun')."";
                }
            
                // /* Kondisi Bulan */
                if(Input::get('bulan') != '' && Input::get('tahun') != ''){
                    $where .= " AND MONTH(tr_pensiun.tmtpens) = \"".Input::get('bulan')."\"";
                }

                if(Input::get('bulan') != '' && Input::get('tahun') == ''){
                    $where .= "AND MONTH(tr_pensiun.tmtpens) = \"".Input::get('bulan')."\"";
                }

                /* Kondisi skpd atau unit kerja */
                if(Input::get('idskpd') != ''){
                    $where.= " and b.idskpd like '".Input::get('idskpd')."%'";
                }

                if(Input::get('statussk') != ''){
                    $where .= " and statussk = \"".Input::get('statussk')."\"";
                }
                
                /* Kondisi jenis pensiun */
                if(Input::get('idjenpens') != ''){
                    $where.= "and tr_pensiun.idjenpens like '".Input::get('idjenpens')."'";
                }

                /* Kondisi search */
                if(Input::get('search') != ''){
                    $where.= "and (tr_pensiun.nip like '%".Input::get('search')."%' or b.nama like '%".Input::get('search')."%')";
                }

                $nominatifpensiuns = $this->nominatifpensiun
                    ->select(\DB::raw("tr_pensiun.*,tr_pensiun.idjenpens as jenispensiun,
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
                    ->orderBy(\DB::raw('tr_pensiun.tmtpens desc,b.idskpd, a_jenpens.idjenpens'))
                    ->paginate($_ENV['configurations']['list-limit']);                 
        }else{                        
            $nominatifpensiuns = $this->nominatifpensiun->all();
        }
        return View::make('nominatifpensiun::index', compact('nominatifpensiuns'));
    }

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('nominatifpensiun::create');
    }
    
    public function getCreateaps()
	{
		return View::make('nominatifpensiun::createaps');
    }

    //menampilkan create bup jika login pegawai
    public function getCreatepegawaibup()
	{
		//modif query dmn bisa tampil data yg bersangkutan aja di where nya
        
        return View::make('nominatifpensiun::createpegawaibup'); //trus disini compact atau parse
    }

    //menampilkan create non bup jika login pegawai
    public function getCreatepegawainonbup()
	{
		return View::make('nominatifpensiun::create_pegawainonbup');
    }
    
    public function postCreate() {
        cekAjax();
        $input = Input::All();
        // dd($input);
        $validation = \Validator::make($input, NominatifpensiunModel::$rules);
        if ($validation->passes()){
            $data = array();
            $nip = $input['nip'];
            $skpd = $input['skpd'];
            $almskrpens = $input['almskrpens'];
            $almrtskrpens = $input['almrtskrpens'];
            $almrwskrpens = $input['almrwskrpens'];
            $almdesaskrpens = $input['almdesaskrpens'];
            $almkecskrpens = $input['almkecskrpens'];
            $almkabskrpens = $input['almkabskrpens'];
            $almprovskrpens = $input['almprovskrpens'];

            $bupati = $input['bupati'];
            $idpejabpens = $input['idpejabpens'];
            $pejpenpens = $input['pejpenpens'];
            $jabpenpens = $input['jabpenpens'];
            $nippenpens = $input['nippenpens'];
            $pangkatpenpens = $input['pangkatpenpens'];
            $golrupenpens = $input['golrupenpens'];
            $pejpen_sp = $input['pejpen_sp'];
            $jabpen_sp = $input['jabpen_sp'];
            $nippen_sp = $input['nippen_sp'];
            $golpen_sp = $input['golpen_sp'];
            $pejpen_hukpid = $input['pejpen_hukpid'];
            $jabpen_hukpid = $input['jabpen_hukpid'];
            $nippen_hukpid = $input['nippen_hukpid'];
            $golpen_hukpid = $input['golpen_hukpid'];
            $pangpen_hukpid = $input['pangpen_hukpid'];

            // dd($input);

            $data = array();
            foreach($nip as $key => $item){
                $attr = NominatifpensiunModel::getattrpensiun($item);
                $statussk = 0;
                $idjenkedudupeg = 99;
                $idjenpens = 1;

                $temp_arr = array(                
                    'nip' => $item,
                    'idskpdpens' => $skpd[$item],
                    'tmtpens' => $attr->pensiunnext,
                    'almskrpens' => $almskrpens[$item],
                    'almrtskrpens' => $almrtskrpens[$item],
                    'almrwskrpens' => $almrwskrpens[$item],
                    'almdesaskrpens' => $almdesaskrpens[$item],
                    'almkecskrpens' => $almkecskrpens[$item],
                    'almkabskrpens' => $almkabskrpens[$item],
                    'almprovskrpens' => $almprovskrpens[$item],
                    'almpens' => $almskrpens[$item],
                    'almrtpens' => $almrtskrpens[$item],
                    'almrwpens' => $almrwskrpens[$item],
                    'almdesapens' => $almdesaskrpens[$item],
                    'almkecpens' => $almkecskrpens[$item],
                    'almkabpens' => $almkabskrpens[$item],
                    'almprovpens' => $almprovskrpens[$item],
                    'idjenkedudupeg' => $idjenkedudupeg,
                    'idjenpens' => $idjenpens,
                    'statussk' => $statussk,
                    'bupati' => $bupati[$item],
                    'idpejabpens' => $idpejabpens[$item],
                    'pejpenpens' => $pejpenpens[$item],
                    'jabpenpens' => $jabpenpens[$item],
                    'nippenpens' => $nippenpens[$item],
                    'pangkatpenpens' => $pangkatpenpens[$item],
                    'golrupenpens' =>$golrupenpens[$item],
                    'pejpen_sp' => $pejpen_sp[$item],
                    'jabpen_sp' => $jabpen_sp[$item],
                    'nippen_sp' => $nippen_sp[$item],
                    'golpen_sp' => $golpen_sp[$item],
                    'pejpen_hukpid' => $pejpen_hukpid[$item],
                    'jabpen_hukpid' => $jabpen_hukpid[$item],
                    'nippen_hukpid' => $nippen_hukpid[$item],
                    'pangpen_hukpid' => $pangpen_hukpid[$item],
                    'role_id' => \Session::get('role_id'),
                    'created_at' => sekarang(),
                    'user_id' => \Session::get('user_id')
                );
                array_push($data,$temp_arr);
            }
            
            if (! empty($nip)){
                if(!\DB::table('tr_pensiun')->insert($data)){
                    echo "Nominatif Pensiun gagal disimpan.";
                }else{
                    echo 1;
                }
            }else{
                echo 'Input tidak valid';
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    //create nomnatif per pegawai
    public function postCreatepegawaibup() {
        cekAjax();
        $input = Input::All();
        // dd($input);
        $validation = \Validator::make($input, NominatifpensiunModel::$rules);
        if ($validation->passes()){
            $data = array();
            $nip = $input['nip'];
            $skpd = $input['skpd'];
            $almskrpens = $input['almskrpens'];
            $almrtskrpens = $input['almrtskrpens'];
            $almrwskrpens = $input['almrwskrpens'];
            $almdesaskrpens = $input['almdesaskrpens'];
            $almkecskrpens = $input['almkecskrpens'];
            $almkabskrpens = $input['almkabskrpens'];
            $almprovskrpens = $input['almprovskrpens'];

            $bupati = $input['bupati'];
            $idpejabpens = $input['idpejabpens'];
            $pejpenpens = $input['pejpenpens'];
            $jabpenpens = $input['jabpenpens'];
            $nippenpens = $input['nippenpens'];
            $pangkatpenpens = $input['pangkatpenpens'];
            $golrupenpens = $input['golrupenpens'];
            $pejpen_sp = $input['pejpen_sp'];
            $jabpen_sp = $input['jabpen_sp'];
            $nippen_sp = $input['nippen_sp'];
            $golpen_sp = $input['golpen_sp'];
            $pejpen_hukpid = $input['pejpen_hukpid'];
            $jabpen_hukpid = $input['jabpen_hukpid'];
            $nippen_hukpid = $input['nippen_hukpid'];
            $golpen_hukpid = $input['golpen_hukpid'];
            $pangpen_hukpid = $input['pangpen_hukpid'];

            // dd($input);

            $data = array();
            foreach($nip as $key => $item){
                $attr = NominatifpensiunModel::getattrpensiun($item);
                $statussk = 0;
                $idjenkedudupeg = 99;
                $idjenpens = 1;

                $temp_arr = array(                
                    'nip' => $item,
                    'idskpdpens' => $skpd[$item],
                    'tmtpens' => $attr->pensiunnext,
                    'almskrpens' => $almskrpens[$item],
                    'almrtskrpens' => $almrtskrpens[$item],
                    'almrwskrpens' => $almrwskrpens[$item],
                    'almdesaskrpens' => $almdesaskrpens[$item],
                    'almkecskrpens' => $almkecskrpens[$item],
                    'almkabskrpens' => $almkabskrpens[$item],
                    'almprovskrpens' => $almprovskrpens[$item],
                    'almpens' => $almskrpens[$item],
                    'almrtpens' => $almrtskrpens[$item],
                    'almrwpens' => $almrwskrpens[$item],
                    'almdesapens' => $almdesaskrpens[$item],
                    'almkecpens' => $almkecskrpens[$item],
                    'almkabpens' => $almkabskrpens[$item],
                    'almprovpens' => $almprovskrpens[$item],
                    'idjenkedudupeg' => $idjenkedudupeg,
                    'idjenpens' => $idjenpens,
                    'statussk' => $statussk,
                    'bupati' => $bupati[$item],
                    'idpejabpens' => $idpejabpens[$item],
                    'pejpenpens' => $pejpenpens[$item],
                    'jabpenpens' => $jabpenpens[$item],
                    'nippenpens' => $nippenpens[$item],
                    'pangkatpenpens' => $pangkatpenpens[$item],
                    'golrupenpens' =>$golrupenpens[$item],
                    'pejpen_sp' => $pejpen_sp[$item],
                    'jabpen_sp' => $jabpen_sp[$item],
                    'nippen_sp' => $nippen_sp[$item],
                    'golpen_sp' => $golpen_sp[$item],
                    'pejpen_hukpid' => $pejpen_hukpid[$item],
                    'jabpen_hukpid' => $jabpen_hukpid[$item],
                    'nippen_hukpid' => $nippen_hukpid[$item],
                    'pangpen_hukpid' => $pangpen_hukpid[$item],
                    'role_id' => \Session::get('role_id'),
                    'created_at' => sekarang(),
                    'user_id' => \Session::get('user_id')
                );
                array_push($data,$temp_arr);
            }
            
            if (! empty($nip)){
                if(!\DB::table('tr_pensiun')->insert($data)){
                    echo "Nominatif Pensiun gagal disimpan.";
                }else{
                    echo 1;
                }
            }else{
                echo 'Input tidak valid';
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postCreateaps() {
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","tglusul","_token","tmtx");
        $arrindex   = array("","idusul","nip");
        // dd($arrnot);
        $keyin      = array("","idusul","nip");
        $keyout     = array("","idusul","nip");
        $keydate    = array('','tmtpens');

        //$tglusul = date("Y-m-d", strtotime(Input::get('tmtx')));
        //$dti['tglusul'] = $tglusul;
        $dt['role_id']   =\session::get('role_id') ;
        $dt['user_id']   =\session::get('user_id') ;


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
                    $rssimpan = \DB::table('tr_pensiun')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    //nominatif pegawai non bup
    public function postCreatepegawainonbup() {
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","tglusul","_token","tmtx");
        $arrindex   = array("","idusul","nip");
        $keyin      = array("","idusul","nip");
        $keyout     = array("","idusul","nip");
        $keydate    = array('','tmtpens');
        // dd($keydate);

        //$tglusul = date("Y-m-d", strtotime(Input::get('tmtx')));
        //$dti['tglusul'] = $tglusul;
        $dt['role_id']   =\session::get('role_id') ;
        $dt['user_id']   =\session::get('user_id') ;
        // dd($dt['user_id']);
        // dd($_POST);
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
                    $rssimpan = \DB::table('tr_pensiun')->insert($dt);
                    if($rssimpan!=1){
                        print_r($rssimpan); exit();
                    }
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifpensiun::'.$view.'_view');
    }

	/*function print atribut dari link */
    public function postData(){
        $data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('nominatifpensiun::'.$view.'_data', $data);
    }

    function postAttrpengantar() {
        $nip = Input::get('nip');
        $rs = \DB::table('tb_01 as a')
                ->select('a.kdunit')->where('a.nip','=',$nip)->first();

        $rs1 = \NominatifpensiunModel::attrPengantar($rs->kdunit);

        echo json_encode($rs1);
    }

    /*function preview edit pensiun*/
    function postEditpensiun(){
        $nip = Input::get('nip');

        $rs = \DB::table("tr_pensiun as a")
            ->select('a.*',
                \DB::raw("b.pangkat as golpnsskr_txt, b.golru as golpns_txt, d.jabatan as pejpenkgbl_txt,f.*,e.skpd,e.path_short,a_tkpendid.tkpendid,a_jenjurusan.jenjurusan,a_esl.esl,a.idjenkedudupeg as idjenkedudupeg_,a.idjenpens as idjenpens_,a.noskpens as noskpensiun"),
                \DB::raw("CONCAT(f.gdp,IF(LENGTH(f.gdp)>0,' ',''),f.nama,IF(LENGTH(f.gdb)>0,', ',''),f.gdb) AS namalengkap"),
                \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tglhr,'%d-%m-%Y') AS tgllahir_"),
                \DB::raw("DATE_FORMAT(f.tmtpkt,'%d-%m-%Y') AS tmtgollama_"),
                \DB::raw("DATE_FORMAT(f.tmtesljbt,'%d-%m-%Y') AS tmteselon_"),
                \DB::raw("DATE_FORMAT(f.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                // \DB::raw("DATE_FORMAT(a.tmtpens,'%d-%m-%Y') AS tmtpens_"),
                \DB::raw("DATE_FORMAT(f.tmtcpn,'%d-%m-%Y') AS tmtcpn_"),
                \DB::raw("DATE_FORMAT(a.tgskpens,'%d-%m-%Y') AS tgskpens_"),
                \DB::raw("
                                CONCAT(
                                    IF((LEFT(f.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            -
                                            (IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - f.mkthncpn,
                                            IF((LEFT(f.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - f.mkthncpn,
                                                IF((LEFT(f.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - f.mkthncpn, 0 ))))
                                        ),
                                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0,1,
                                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0)-2))
                                            + f.mkthncpn
                                        )
                                    ),
                                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(f.tmtcpn='0000-00-00',f.tmtpns,f.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                                "),               
                \DB::raw("IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idesljbt BETWEEN '11' AND '51',e.jab,IF(f.idjenjab=3,a_jabfungum.jabfungum,''))) AS namajab"),
                \DB::raw('IF(f.idjenjab>4,e.jab,IF(f.idjenjab=2,a_jabfung.jabfung,IF(f.idjenjab=3,a_jabfungum.jabfungum,IF(f.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(f.tglhr)), '%Y%m')+0 AS usia")
            )
            ->join('tb_01 as f', 'a.nip', '=', 'f.nip')
            ->join('a_skpd as e', 'f.idskpd', '=', 'e.idskpd')
            ->leftJoin('a_golruang as b', 'f.idgolrupkt', '=', 'b.idgolru')           
            ->leftJoin('a_penetapsk as d', 'f.pejmenpkt', '=', 'd.id')  
            ->leftjoin('a_jabfung', 'f.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'f.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'f.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->leftjoin('a_tkpendid', 'f.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'f.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftjoin('a_esl', 'f.idesljbt', '=', 'a_esl.idesl')          
            ->where('a.nip', $nip)
            ->first();

        $id="";
        $folder="";
        if($rs->idgolrupkt<42){
            if($rs->idjenpens_==1){
                $id=28;
            }else if($rs->idjenpens_==2){
                $id=34;
            }else if($rs->idjenpens_==6){
                $id=29;
            }else if($rs->idjenpens_==3){
                $id=31;
            }else if($rs->idjenpens_==7){
                $id=33;
            }else if($rs->idjenpens_==4){
                $id=36;
            }else{
                $id=28;
            }
        }else{
            if($rs->idjenpens_==1){
                $id=27;
            }else if($rs->idjenpens_==6){
                $id=30;
            }else if($rs->idjenpens_==3){
                $id=32;
            }else if($rs->idjenpens_==2){
                $id=34;
            }else if($rs->idjenpens_==7){
                $id=35;
            }else if($rs->idjenpens_==4){
                $id=37;
            }else{
                $id=27;
            }
        }

        if($id==28){
            $folder="Pensiun IV/b ke bawah Jenis BUP";
        }else if($id==29){
            $folder="Pensiun IV/b ke bawah Jenis Janda/Duda";
        }else if($id==31){
            $folder="Pensiun IV/b ke bawah Jenis APS";
        }else if($id==33){
            $folder="Pensiun IV/b ke bawah Jenis Keuzuran";
        }else if($id==36){
            $folder="Pensiun IV/b ke bawah Jenis PDH/TAPS";
        }else if($id==27){
            $folder="Pensiun IV/c ke atas Jenis BUP";
        }else if($id==30){
            $folder="Pensiun IV/c ke atas Jenis Janda/Duda";
        }else if($id==32){
            $folder="Pensiun IV/c ke atas Jenis APS";
        }else if($id==34){
            $folder="Pensiun IV/c ke atas Jenis Tewas";
        }else if($id==35){
            $folder="Pensiun IV/c ke atas Jenis Keuzuran";
        }else if($id==37){
            $folder="Pensiun IV/c ke atas Jenis PDH TAPS";
        }

        if(Input::has('id')){
            $id = Input::get('id');
            $folder = "Kenaikan Pangkat";
        }

        $rs2 = callApi('get', 'https://simpeg.kendalkab.go.id/efile/dokumenpersyaratan?id='.$id.'&nip='.$nip);
        $response = [
            'data1'=> $rs,
            'data2' => $rs2,
            "folder" => $folder
        ];
        echo json_encode($response);
    }

    public function postUploadfiles()
    {
        if (Request::hasFile('filenames')) { 
            foreach (Request::file('filenames') as $file) { 
                $name = $file->getClientOriginalName();
                $get_nip = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file->move(public_path('pensiun'), $name); 
                $data[] = $name;

                // Update data pegawai
                \DB::table('tb_01')
                    ->where('nip', $get_nip)
                    ->update([
                        'idjenkedudupeg' => 99,
                        'file_pensiun' => $name,
                    ]);
            }

            return back()->with('success', 'Data Added!');
        }

        return back()->withErrors('No files were uploaded.');
    }



    /*function untuk simpan update pensiun*/
    function postUpdatepensiun(){
        cekAjax();
        $input = Input::all();
        $dt['nip'] = $input['nip'];
        
        $data['tmtpens'] = date("Y-m-d", strtotime($input['tmtpens']));
        $data['idjenkedudupeg'] = $input['idjenkedudupeg'];
        $data['idjenpens'] = $input['idjenpens'];
        $data['keterangan'] = $input['keterangan'];
        $data['almskrpens'] = $input['alm'];
        $data['almrtskrpens'] = $input['almrt'];
        $data['almrwskrpens'] = $input['almrw'];
        $data['almdesaskrpens'] = $input['almdesa'];
        $data['almkecskrpens'] = $input['almkec'];
        $data['almkabskrpens'] = $input['almkab'];
        $data['almprovskrpens'] = $input['almprov'];
        $data['almpens'] = $input['almpens'];
        $data['almrtpens'] = $input['almrtpens'];
        $data['almrwpens'] = $input['almrwpens'];
        $data['almdesapens'] = $input['almdesapens'];
        $data['almkecpens'] = $input['almkecpens'];
        $data['almkabpens'] = $input['almkabpens'];
        $data['almprovpens'] = $input['almprovpens'];

        if(!\DB::table("tr_pensiun")->where($dt)->update($data)){
            echo "Edit Pensiun gagal disimpan";
        }else{
            echo 4;
        }
    }

    /*function untuk verifikasi pensiun*/
    function postVerifikasipensiun(){
        cekAjax();
        $input = Input::all();
        
        $dt['nip'] = $input['nip'];

        $noskpens = $input['noskpens'];

        if(Input::get('statususul') == 1){
            $data = array(
                // 'ispengantar' => Input::get('ispengantar'),
                // 'isnominatif' => Input::get('isnominatif'),
                // 'isskpkt' => Input::get('isskpkt'),
                // 'isskkgb' => Input::get('isskkgb'),
                // 'isdp3' => Input::get('isdp3'),
                // 'isskhukdis' => Input::get('isskhukdis'),
                // 'isskpmk' => Input::get('isskpmk'),
                'mkthnpktpens' => Input::get('mkthnpkt'),
                'mkblnpktpens' => Input::get('mkblnpkt'),
                'mkthnpens' => Input::get('mkthnpens'),
                'mkblnpens' => Input::get('mkblnpens'),
                'mkthnpnspens' => Input::get('mkthnpnspens'),
                'mkblnpnspens' => Input::get('mkblnpnspens'),
                'tglmasukpns' => date("Y-m-d", strtotime(Input::get('tglmasukpns'))),
                'almskrpens' => Input::get('alm'),                
                'almrtskrpens' => Input::get('almrt'),
                'almrwskrpens' => Input::get('almrw'),
                'almdesaskrpens' => Input::get('almdesa'),
                'almkecskrpens' => Input::get('almkec'),
                'almkabskrpens' => Input::get('almkab'),
                'almprovskrpens' => Input::get('almprov'),
                'almpens' => Input::get('almpens'),                
                'almrtpens' => Input::get('almrtpens'),
                'almrwpens' => Input::get('almrwpens'),
                'almdesapens' => Input::get('almdesapens'),
                'almkecpens' => Input::get('almkecpens'),
                'almkabpens' => Input::get('almkabpens'),
                'almprovpens' => Input::get('almprovpens'),
                'statususul' => Input::get('statususul'),
                'statussk' => Input::get('statussk'),
                'iscetaksk' => Input::get('iscetaksk'),
                'kettms' => '',
                'ketbtl' => '',
                'idpejabpens' => Input::get('idpejabpens'),
                'noskpens' => $noskpens,
                'tgskpens' => date("Y-m-d", strtotime(Input::get('tgskpens'))),
                // 'jabpenpens' => Input::get('jabpenpens'),
                // 'pejpenpens' => Input::get('pejpenpens'),
                // 'nippenpens' => Input::get('nippenpens'),
                // 'golrupenpens' => Input::get('golrupenpens'),
                'updated_at' => sekarang(),
                'user_id' => session('user_id')
            );

            /*if(Input::get('iscetaksk') == 1){
                $this->insertIntorkgb($dt['idkgb'], $dt['nip']);
            }else if(Input::get('iscetaksk') == 2){
                $this->batalIntorkgb($dt['idkgb'], $dt['nip']);
            }*/
        }else if(Input::get('statususul') == 2){
            $data = array(
                // 'ispengantar' => Input::get('ispengantar'),
                // 'isnominatif' => Input::get('isnominatif'),
                // 'isskpkt' => Input::get('isskpkt'),
                // 'isskkgb' => Input::get('isskkgb'),
                // 'isdp3' => Input::get('isdp3'),
                // 'isskhukdis' => Input::get('isskhukdis'),
                // 'isskpmk' => Input::get('isskpmk'),
                'mkthnpens' => Input::get('mkthnpens'),
                'mkblnpens' => Input::get('mkblnpens'),
                'mkthnpnspens' => Input::get('mkthnpnspens'),
                'mkblnpnspens' => Input::get('mkblnpnspens'),                
                'almpens' => Input::get('almpens'),
                'tglmasukpns' => date("Y-m-d", strtotime(Input::get('tglmasukpns'))),
                'almrtpens' => Input::get('almrtpens'),
                'almrwpens' => Input::get('almrwpens'),
                'almdesapens' => Input::get('almdesapens'),
                'almkecpens' => Input::get('almkecpens'),
                'almkabpens' => Input::get('almkabpens'),
                'almprovpens' => Input::get('almprovpens'),
                'statususul' => Input::get('statususul'),
                'statussk' => '',
                'kettms' => Input::get('kettms'),
                'ketbtl' => '',
                'tgskpens' => '',
                'updated_at' => sekarang(),
                /*'userver' => session('user_id')
                'noskkgbb' => '',                ,
                'jabpenkgbb' => '',
                'pejpenkgbb' => '',
                'nippb' => '',
                'golrupb' => ''*/
            );
        }else {
            $data = array(
                // 'ispengantar' => Input::get('ispengantar'),
                // 'isnominatif' => Input::get('isnominatif'),
                // 'isskpkt' => Input::get('isskpkt'),
                // 'isskkgb' => Input::get('isskkgb'),
                // 'isdp3' => Input::get('isdp3'),
                // 'isskhukdis' => Input::get('isskhukdis'),
                // 'isskpmk' => Input::get('isskpmk'),
                'mkthnpens' => Input::get('mkthnpens'),
                'mkblnpens' => Input::get('mkblnpens'),
                'mkthnpnspens' => Input::get('mkthnpnspens'),
                'mkblnpnspens' => Input::get('mkblnpnspens'),                
                'almpens' => Input::get('almpens'),
                'tglmasukpns' => date("Y-m-d", strtotime(Input::get('tglmasukpns'))),
                'almrtpens' => Input::get('almrtpens'),
                'almrwpens' => Input::get('almrwpens'),
                'almdesapens' => Input::get('almdesapens'),
                'almkecpens' => Input::get('almkecpens'),
                'almkabpens' => Input::get('almkabpens'),
                'almprovpens' => Input::get('almprovpens'),
                'statususul' => Input::get('statususul'),
                'statussk' => '',
                'kettms' => '',
                'ketbtl' => Input::get('ketbtl'),
                'tgskpens' => '',
                'updated_at' => sekarang(),
                'user_id' => session('user_id')/*,
                'noskkgbb' => '',
                'jabpenkgbb' => '',
                'pejpenkgbb' => '',
                'nippb' => '',
                'golrupb' => ''*/
            );
        }

        if(!\DB::table('tr_pensiun')->where($dt)->update($data)){
            echo "Verifikasi Pensiun gagal disimpan";
        }else{
            echo 4;
        }
    }
    
    function postNominatif(){
        cekAjax();        
        $data['idskpd'] = Input::get('idskpd');
        $data['idjenjab'] = Input::get('idjenjab');
        $data['bulan1'] = Input::get('bulan1');
        $data['bulan2'] = Input::get('bulan2');
        $data['tahun'] = Input::get('tahun');    

        return View::make('nominatifpensiun::nominatif', compact('data'));
    }
	
	public function getDatapensiun(){
        cekAjax();

        $where = " tb_01.idjenkedudupeg in('99','21') and tb_01.nip != '' ";
        if (Input::has('search') or Input::has('idskpd') or Input::has('tahun') or Input::has('bulan1') or Input::has('bulan2')) {
            $having = '';

            /* Kondisi jabatan jabatan*/
            if(Input::get('idjenjab') != ''){
                $where.= "and tb_01.idjenjab = '".Input::get('idjenjab')."'";
            }

            /* Kondisi Tahun */
            if(Input::get('tahun') != ''){
                $having .= (($having != '')?' AND ':'')." YEAR(tmtpens)= ".Input::get('tahun')."";
            }

            /* Kondisi Bulan */
            if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
            }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens)= ".Input::get('bulan1')."";
            }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
                $having .= (($having != '')?' AND ':'')." MONTH(tmtpens)= ".Input::get('bulan2')."";
            }

            /* Kondisi skpd atau unit kerja */
            if(Input::get('idskpd') != ''){
                $where.= "and tb_01.idskpd like '".Input::get('idskpd')."%'";
            }

            /* Kondisi jenis pensiun */
            if(Input::get('idjenpens') != ''){
                $where.= "and tb_01.idjenpens = '".Input::get('idjenpens')."'";
            }

            /* Kondisi search */
            if(Input::get('search') != ''){
                $where.= "and (tb_01.nama like '%".Input::get('search')."%' or tb_01.nip like '%".Input::get('search')."%')";
            }

            if($having != ''){
                $nominatifpensiuns = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF((tb_01.idjenjab=3) OR (tb_01.idesljbt >=31 and tb_01.idesljbt <= 52) /*OR (tb_01.idjenjab=2 AND tb_01.idgolrupkt <= 34)*/,58,60) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                    ->havingRaw($having)
                    ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
            }else{
                $nominatifpensiuns = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                        \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
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
                    ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'));
            }

            /*$page           = (Input::has('page'))?Input::get('page'):1;*/
            //$nominatifpensiuns= $nominatifpensiuns->skip($page - 1)->take(25)->get();
            $nominatifpensiuns  = $nominatifpensiuns->get();
            $perPage        = $_ENV['configurations']['list-limit'];
            //this is my array
            $pageStart      = (Input::has('page'))?Input::get('page'):1;
            $offset         = ($pageStart * $perPage) - $perPage;

            if(count($nominatifpensiuns)> 0){
                $data = new Paginator (
                    array_slice($nominatifpensiuns, $offset,  $perPage, true),
                    count($nominatifpensiuns),$perPage,Paginator::resolveCurrentPage(),
                    array('path' =>  Paginator::resolveCurrentPath())
                );
                $nominatifpensiuns = $data;
            }
        }else{
            $nominatifpensiuns = $this->nominatifpensiun->data_pensiun();
        }
        return View::make('nominatifpensiun::index_pensiun', compact('nominatifpensiuns'));
	}

	/*function penetapan pensiun */
    public function postPensiun(){
        cekAjax();
        $input = Input::all();
        $id = Input::get('nip');
        $validation = \Validator::make($input, NominatifpensiunModel::$rules);

        if ($validation->passes()){
            $arrnot = array('','_token','id');
            $keydate = array('','tmtpens','tglskpens');

            foreach($input as $key=>$value){
                if(array_search($key,$keydate)!=''){
                    if($value != ''){
                        $val = explode("-",$value);
                        $value = $val[2]."-".$val[1]."-".$val[0];
                    }else{
                        $value = '0000-00-00';
                    }
                }
                if(array_search($key,$arrnot)==""){
                    $data[$key] = $value;
                }
            }

            $data['idjenkedudupeg'] = Input::get('idjenkedudupeg');
            $nominatifpensiun = $this->nominatifpensiun->find($id);
            echo ($nominatifpensiun->update($data))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

	/*function batalkan pensiun*/
    public function postBtlpensiun(){
        cekAjax();
        $nip = Input::get('id');

        $data = array(
            'tmtpens' => '',
            'idjenkedudupeg' => '1',
            'idjenpens' => '',
            'noskpens' => '',
            'tglskpens' => '',
            'jbtpenetapens' => '',
        );

        if(\DB::table('tb_01')->where('nip', $nip)->update($data)){
            echo "9";
        }else{
            echo "Pensiun Gagal Dibatalkan";
        }
    }
	
	function postPrint(){
        $view = Request::segment(4);
        return View::make('nominatifpensiun::'.$view.'_print');
    }

    function postExcel(){
        $view = Request::segment(4);
        return View::make('nominatifpensiun::'.$view.'_excel');
    }

    /*function view data epensiun kolektif */
    function getCetaknominatif(){
        return View::make('nominatifpensiun::sknominatif');
    }

    /*function cetak sperorangan*/
    function getCetaksk(){        
        return View::make('nominatifpensiun::skpens');
    }

    /*function cetak dpcp meninggal perorangan*/
    function getCetakskmen(){        
        return View::make('nominatifpensiun::skpens_men');
    }

    /*function view data pensiun tanda diterima */
    function getCetakditerima(){
        return View::make('nominatifpensiun::skditerima');
    }

    /*function cetak sk pensiun kolektif */
    function getCetakskkolektif(){
        return View::make('nominatifpensiun::skpensiunkolektif');
    }

    /*function post cetak sk*/
    public function postCetaksk(){
        cekAjax();
        $tmtpens = Input::get('rectmtpens');
        // dd($tmtpens);
        $idskpd = Input::get('recidskpd');
        $data['iscetaksk'] = Input::get('iscetaksk');

        /*update iscetak sk*/
        echo (\DB::table('tr_pensiun')
        // ->leftJoin('tb_01 as b', 'tr_pensiun.nip', '=', 'b.nip')
        ->where('tr_pensiun.tmtpens', $tmtpens)->where('statussk', 1)->where('tr_pensiun.idskpdpens','like',''.$idskpd. '%')->update($data))?4:"Gagal Disimpan";
    }

    public function postDelete(){
        cekAjax();
        // $data['idkgb'] = Input::get('id');
        $data['nip'] = Input::get('nip');

        echo (\DB::table('tr_pensiun')->where($data)->delete())?9:'Gagal Dihapus';
    }

    /*function untuk cek usulan sudah ada tau belum*/
    //input get n nominatif pegawai dr sini
    function postCeknominatif(){
        $nip = Input::get('nip');

        $rs = \DB::table('tr_pensiun')
            ->where('nip','=',$nip)
            ->count();
        if($rs>0){
            echo 1;
        } else{
            echo 0;
        }
    }

    /*function untuk simpan attribut pengantar*/
    public function postSuratpengantar(){
        $tmtpens = Input::get('tmtpens');
        $idskpdpens = Input::get('idskpdpens');

        $data['no_sp'] = Input::get('no_sp');
        $data['berkas_sp'] = Input::get('berkas_sp');
        $data['tgl_sp'] = date('Y-m-d', strtotime(Input::get('tgl_sp')));
        $data['jabpen_sp'] = Input::get('jabpen_sp');
        $data['pejpen_sp'] = Input::get('pejpen_sp');
        $data['nippen_sp'] = Input::get('nippen_sp');
        $data['golpen_sp'] = Input::get('golpen_sp');

        if(($tmtpens != '') and ($idskpdpens != '')){
            \DB::table('tr_pensiun')->where('tmtpens', $tmtpens)->where('idskpdpens','like',''.$idskpdpens. '%')->update($data);
            if(Input::get('actpengantar') == 1){
                return View::make('nominatifpensiun::surat_pengantar', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens));
            }

            if(Input::get('actnominatif') == 1){
                return View::make('nominatifpensiun::surat_nominatif', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens));
            }

            // if(Input::get('acthukdis') == 1){
            //     return View::make('nominatifpensiun::surat_thukdis', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens));
            // }
            // if(Input::get('actpidana') == 1){
            //     return View::make('nominatifpensiun::surat_tpidana', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens));
            // }
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    //surat pengantar bkpp
    public function postSuratpengantarbkpp(){
        $tmtpens = Input::get('tmtpens');
        $idskpdpens = Input::get('idskpdpens');
        $nip = Input::get('nip');

        $data['hukpid'] = Input::get('hukpid');
        $data['nosk_hukdis'] = Input::get('nosk_hukdis');
        $data['nosk_pidana'] = Input::get('nosk_pidana');
        $data['tgskpens'] = date('Y-m-d', strtotime(Input::get('tgskpens')));
        $data['jabpenpens'] = Input::get('jabpenpens');
        $data['pejpenpens'] = Input::get('pejpenpens');
        $data['nippenpens'] = Input::get('nippenpens');
        $data['pangkatpenpens'] = Input::get('pangkatpenpens');
        $data['golrupenpens'] = Input::get('golrupenpens');

        if(($tmtpens != '') and ($idskpdpens != '')){
            \DB::table('tr_pensiun')->where('nip', $nip)->where('tmtpens', $tmtpens)->where('idskpdpens','like',''.$idskpdpens. '%')->update($data);

            if(Input::get('acthukdisbkpp') == 1){
                return View::make('nominatifpensiun::surat_thukdisbkpp', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens, 'nip'=>$nip));
            }

            if(Input::get('actpidanabkpp') == 1){
                return View::make('nominatifpensiun::surat_tpidanabkpp', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens, 'nip'=>$nip));
            }
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    //hukdis opd
    public function postSurathukpid(){
        $tmtpens = Input::get('tmtpens');
        $idskpdpens = Input::get('idskpdpens');
        $nip = Input::get('nip');

        $data['hukpid'] = Input::get('hukpid');
        $data['no_hukdis'] = Input::get('no_hukdis');
        $data['no_pidana'] = Input::get('no_pidana');
        $data['tgl_hukpid'] = date('Y-m-d', strtotime(Input::get('tgl_hukpid')));
        $data['nippen_hukpid'] = Input::get('nippen_hukpid');
        $data['jabpen_hukpid'] = Input::get('jabpen_hukpid');
        $data['pejpen_hukpid'] = Input::get('pejpen_hukpid');
        $data['pangpen_hukpid'] = Input::get('pangpen_hukpid');
        $data['golpen_hukpid'] = Input::get('golpen_hukpid');

        if(($tmtpens != '') and ($idskpdpens != '')){
            \DB::table('tr_pensiun')->where('nip', $nip)->where('tmtpens', $tmtpens)->where('idskpdpens','like',''.$idskpdpens. '%')->update($data); //tambah nip

            if(Input::get('acthukdisopd') == 1){
                return View::make('nominatifpensiun::surat_thukdis', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens, 'nip'=>$nip));
            }

            if(Input::get('actpidanaopd') == 1){
                return View::make('nominatifpensiun::surat_tpidana', array('tmtpens'=>$tmtpens, 'idskpdpens'=>$idskpdpens, 'nip'=>$nip));
            // echo "tes";
            }
        }else{
            echo "Data tidak ditemukan.";
        }
    }

    //
    function postCaripegawai(){
        cekAjax();
        $keyword    = Input::get('keyword');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));
        /*ADD KONDISI KHUSUS BUPATI*/
        $where1 = "b.id = 004 AND (b.jabatan like \"%".$keyword."%\" or b.namalengkap like \"%".$keyword."%\")";
        $where2 = "(a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\")";
        
        $rs1 = \DB::table('a_penetapsk as b')
        ->select('b.nip', 'b.namalengkap as nama', 'b.nip as id', 'b.namalengkap as text',\DB::raw('"default.png" as photo'),\DB::raw('"-" as skpd'), 'b.jabatan as jabatan',\DB::raw('b.namalengkap as namalengkap') )
        ->whereRaw($where1);

        $rs2 = \DB::table('tb_01 as a')
        ->select(
            'a.nip', 'a.nama', 'a.nip as id', 'a.nama as text', 'a.photo', 'b.skpd',
            \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
            \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
        )
        ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
        ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
        ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
        ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
        ->whereRaw($where2)
        ->orderBy('a.nama','asc')
        ->orderBy('a.nip','asc');
        $rs = $rs1->union($rs2);
        $arr['result']      = count($rs->get());
        $arr['per_page']    = $per_page;
        $arr['page']        = (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    //
    public function postDetailpegawai(){
        $nip = Input::get('nip');
        if ($nip == "-") {
            $rs = \DB::table('a_penetapsk as b')
            ->select('b.jabatan as jabatan',\DB::raw('b.namalengkap as namalengkap') )
            ->whereRaw('b.id = 004')
            ->first();

            $ret['nama']     = $rs->namalengkap;
            $ret['jab']      = $rs->jabatan;
            $ret['pangkat']  = "-";
            $ret['golongan'] = $rs->golru;
            $ret['idjenjab'] = "-";
            $ret['idjab']    = "-";
            $ret['idskpd']   = "-";
            $ret['skpd']     = "-";
        }else{
            $rs = \DB::table('tb_01')
            ->select('tb_01.*','a_golrupkt.golru','a_skpd.skpd','a_esl.esl',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap, b_skpd.skpd as unit'),

                \DB::raw('
                    IF(tb_01.iskepsek=1 AND LEFT(tb_01.idskpd,2)="04",a_skpd.jab,
                    IF(tb_01.idjenjab>4,a_skpd.jab,
                    IF(tb_01.idjenjab=2,a_jabfung.jabfung,
                    IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,
                    IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-"))))) as jabatan'),

                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.idskpd,IF(tb_01.idjenjab=2,a_jabfung.idjabfung,IF(tb_01.idjenjab=3,a_jabfungum.idjabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.idjabnonjob,"-")))) as idjab'),

                \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia, a_golrucpn.golru as golrucpn, a_golrucpn.pangkat as pangkatcpn, a_golrupns.golru as golrupns, a_golrupns.pangkat as pangkatpns, a_golrupkt.golru as golrupkt, a_golrupkt.pangkat as pangkatpkt")
            )
            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
            ->join('a_skpd as b_skpd', 'tb_01.kdunit', '=', 'b_skpd.idskpd')
            ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
            ->leftjoin('a_golruang as a_golrucpn', 'tb_01.idgolrucpn', '=', 'a_golrucpn.idgolru')
            ->leftjoin('a_golruang as a_golrupns', 'tb_01.idgolrupns', '=', 'a_golrupns.idgolru')
            ->leftjoin('a_golruang as a_golrupkt', 'tb_01.idgolrupkt', '=', 'a_golrupkt.idgolru')
            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
            ->where('nip', $nip)
            ->orderBy('tb_01.idjenjab', 'asc')
            ->orderBy('tb_01.idgolrupkt', 'desc')
            ->orderBy('tb_01.tmtpkt', 'asc')
            ->first();
            $ret['nama']     = $rs->namalengkap;
            $ret['jab']      = $rs->jabatan;
            $ret['pangkat']  = $rs->pangkatpkt;
            $ret['golongan']  = $rs->golru;
            $ret['idjenjab'] = $rs->idjenjab;
            $ret['idjab']    = $rs->idjab;
            $ret['idskpd']   = $rs->idskpd;
            $ret['skpd']     = $rs->skpd;
        }

        echo json_encode($ret);
    }

    //download zip efile
    public function getJadikanzip(){
        $nip = Input::get('nip');
        dd($nip);
        $all = \Input::all();
        // dd($all);
        $json = json_decode($all['data'],1);
        $i = 1;
        foreach($json as $bro){
            $jenis = isset($bro['jenis'])  ? $bro['jenis']: "undefined";
            $subjenis = isset($bro['subjenis'])  ? $bro['subjenis']: "undefined";
            $subsubjenis = isset($bro['subsubjenis'])  ? $bro['subsubjenis']: "undefined";

            // Tidak akan membuat pdf jika kosong semua
            if($jenis == "undefined" && $subjenis == "undefined" && $subsubjenis == "undefined"){continue;}
            
            \Input::merge([
                'nip'=>$all['nip'],
                'nama'=>$all['pegawai'],
                'jenis'=>$jenis,
                'subjenis'=>$subjenis,
                'subsubjenis'=>$subsubjenis,
                'iterasi' => $i,
                'data' => '',
            ]);
            $contents = view('uploadhasilscandokumen::cetakdokumenzip');
            $response = \Response::make($contents);
            $i++;
        }
        $namaZip = str_replace("/"," ",$all['nama_folder'])."_".$all['nip'].".zip";
        $basePath = base_path(\Session::get('filePathZip'));
        $filePath = $basePath."/".$namaZip;
        $folder = $basePath."/zip"."/";

        $zip = $this->runZipArchive($filePath,$folder);
        if($zip){
            return \Redirect::to(url(\Session::get('filePathZip')."/".$namaZip));

        }
        exit();
        \Session::remove('filePathZip');

   
    }

    private function runZipArchive($zipName,$folder){
        $zip = new \ZipArchive;

        //Initialize
        // $zipName = "test_dir.zip";
        // $folder = 'brokerz';
        // $filename = "okesiap";
        $i = 1;

        // Check Zip Exist

        if(file_exists($zipName)){
            unlink($zipName);
        }
        if ($zip->open($zipName, \ZipArchive::CREATE) === TRUE)
        {
            // Open Folder
            if ($handle = opendir($folder))
            {
                // Add all files inside the directory
                while (false !== ($entry = readdir($handle)))
                {
                    if ($entry != "." && $entry != ".." && !is_dir($folder.'/' . $entry))
                    {
                        //Change file name

                        // $extension = explode(".",$entry);
                        // $fileType = end($extension);
                        
                        $zip->addFromString($entry,file_get_contents($folder.'/' . $entry));
                        unlink($folder."/".$entry);
                        $i++;

                    }
                }
                closedir($handle);
            }
        
            $zip->close();
            return true;
        }
        return false;
    }
}
