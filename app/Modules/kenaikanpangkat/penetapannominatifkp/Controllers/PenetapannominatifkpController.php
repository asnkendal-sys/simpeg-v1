<?php namespace App\Modules\kenaikanpangkat\penetapannominatifkp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\kenaikanpangkat\penetapannominatifkp\Models\PenetapannominatifkpModel;
use Input,View, Request, Form, File;

class PenetapannominatifkpController extends Controller {
    protected $penetapannominatifkp;

    public function __construct(PenetapannominatifkpModel $penetapannominatifkp){
        $this->penetapannominatifkp = $penetapannominatifkp;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_kenaikan_pangkat.idusul != 0";
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

            $penetapannominatifkps = $this->penetapannominatifkp
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
                ->orderBy('idusul', 'desc')
                // ->orderBy('tmt', 'desc')
                // ->orderBy('nousul','desc')
                // ->orderBy('idskpd')
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $penetapannominatifkps = $this->penetapannominatifkp->all();
        }
        return View::make('penetapannominatifkp::index', compact('penetapannominatifkps'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('penetapannominatifkp::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannominatifkpModel::$rules);
        if ($validation->passes()){
            $data = array();
            /*ambil post dari inputan*/
            $bulan = $input['bulan'];
            $tahun = $input['tahun'];
            $idskpd = $input['idskpd'];
            $idjeniskp = $input['idjeniskp'];
            $nip = $input['nip'];
            $idgolrupktb = $input['golpnsskr'];
            $mktkpb = $input['mktkpb'];
            $mkbkpb = $input['mkbkpb'];
            $tmt = $input['tmt'];
            $nopak = $input['nopak'];

            $data = array();
            foreach($nip as $key => $item){
                $attr = PenetapannominatifkpModel::getattkp($item);
                $temp_arr = array(
                    'nousul' => PenetapannominatifkpModel::nourut(date("Y-m-d", strtotime($tmt[$item]))),
                    // 'nousul' => PenetapannominatifkpModel::nourut(date('Y-m-d')),
                    'tglusul' => date('Y-m-d'),
                    'nip' => $item,
                    'idjeniskp' => $idjeniskp,
                    'idtkpendid' => $attr->idtkpendid,
                    'idjenjurusan' => $attr->idjenjurusan,
                    'thnlulus' => $attr->thijaz,
                    'idgolrupkt' => $attr->idgolrupkt,
                    'idjenjab' => $attr->idjenjab,
                    'idjabjbt' => $attr->idjabjbt,
                    'idjabfung' => $attr->idjabfung,
                    'idjabfungum' => $attr->idjabfungum,
                    'tmtpkt' => $attr->tmtpkt,
                    'tmtjbt' => $attr->tmtjbt,
                    'idskpd' => $attr->idskpd,
                    'mktkp' => $attr->mkthnpkt,
                    'mkbkp' => $attr->mkblnpkt,

                    'gkp' => getGaji($attr->idgolrupkt,$attr->mkthnpkt),
                    'idgolrupktb' => $idgolrupktb[$item],
                    'mktkpb' => $mktkpb[$item],
                    'mkbkpb' => $mkbkpb[$item],
                    'gkpb' => getGaji($idgolrupktb[$item],$mktkpb[$item]),
                    'keterangan' => 'Kenaikan Pangkat',
                    'isnom' => 1,
                    'tmt' => date("Y-m-d", strtotime($tmt[$item])),
                    'nopak' => $nopak[$item],

                    'kepalabkd' => PenetapannominatifkpModel::attrKepskpd(25,'nama'),
                    'jabkepalabkd' => PenetapannominatifkpModel::attrKepskpd(25,'jab_utuh'),
                    'nipkepalabkd' => PenetapannominatifkpModel::attrKepskpd(25,'nip'),
                    'pangkatbkd' => PenetapannominatifkpModel::attrKepskpd(25,'pangkat'),
                    'bupati' => getPenetapsk('005','namalengkap'),
                    'kepalasekda' => PenetapannominatifkpModel::attrKepskpd('01','nama'),
                    'jabkepalasekda' => PenetapannominatifkpModel::attrKepskpd('01','jab_utuh'),
                    'nipsekda' => PenetapannominatifkpModel::attrKepskpd('01','nama'),
                    'pangkatsekda' => PenetapannominatifkpModel::attrKepskpd('01','pangkat'),
                        
                    'atasan_nip' => getKepskpd($attr->idskpd, 'nip'),
                    'atasan_nama' => getKepskpd($attr->idskpd,'nama'),
                    'atasan_jab' => getKepskpd($attr->idskpd,'jab_utuh'),
                    'atasan_gol' => getKepskpd($attr->idskpd,'golru'),
                    'atasan_pkt' => getKepskpd($attr->idskpd,'pangkat'),

                    'role_id' => \Session::get('role_id'),
                    'created_at' => sekarang(),
                    'user_id' => \Session::get('user_id')
                );
                array_push($data,$temp_arr);
            }
            
            if (! empty($nip)){
                if(!\DB::table('tr_kenaikan_pangkat')->insert($data)){
                    echo "Kenaikan Pangkat gagal disimpan.";
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

    //{controller-show}
    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $penetapannominatifkp = $this->penetapannominatifkp->find($id);
        //if (is_null($penetapannominatifkp)){return \Redirect::to('kenaikanpangkat/penetapannominatifkp/index');}
        return View::make('penetapannominatifkp::edit', compact('penetapannominatifkp'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PenetapannominatifkpModel::$rules);

        if ($validation->passes()){
            $penetapannominatifkp = $this->penetapannominatifkp->find($id);
            echo ($penetapannominatifkp->update($input))?4:"Gagal Disimpan";
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
                $this->penetapannominatifkp->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->penetapannominatifkp->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk menampilkan nominatif kenaikan pagkat*/
    function postNominatif(){
        cekAjax();
        $data['idskpd'] = Input::get('idskpd');
        $data['bulan'] = Input::get('bulan');
        $data['tahun'] = Input::get('tahun');
        $data['idjenjab'] = Input::get('idjenjab');

        return View::make('penetapannominatifkp::nominatif', compact('data'));
    }

    function postUpdatenominatifkp(){
        cekAjax();
        $kp = PenetapannominatifkpModel::where('idusul', Input::get('idusul'))->first();

        if(!empty($kp)){
            $kp->idjeniskp = Input::get('idjeniskp');
            $kp->idgolrupktb = Input::get('idgolrupktb');
            $kp->mktkpb = Input::get('mktkpb');
            $kp->nopak = Input::get('nopak');
            $kp->gkpb = getGaji(Input::get('idgolrupktb'), Input::get('mktkpb'));
            $kp->tmt = date("Y-m-d", strtotime(Input::get('tmt')));
            $kp->atasan_nip = Input::get('atasan_nip');
            $kp->atasan_nama = Input::get('atasan_nama');
            $kp->atasan_jab = Input::get('atasan_jab');
            $kp->atasan_pkt = Input::get('atasan_pkt');
            $kp->atasan_gol = Input::get('atasan_gol');
            $kp->role_id = \Session::get('role_id');
            $kp->user_id = \Session::get('user_id');

            return $kp->save()?4:"Update kenaikan pangkat gagal disimpan!";
        }

        return "Data kenaikan pangkat tidak ditemukan!";
    }

    function postVerifikasinominatifkp(){
        cekAjax();
        $kp = PenetapannominatifkpModel::where('idusul', Input::get('idusul'))->first();

        if(!empty($kp)){
            $kp->idjeniskp = Input::get('idjeniskp');
            $kp->idgolrupktb = Input::get('idgolrupktb');
            $kp->mktkpb = Input::get('mktkpb');
            $kp->nopak = Input::get('nopak');
            $kp->gkpb = getGaji(Input::get('idgolrupktb'), Input::get('mktkpb'));
            $kp->tmt = date("Y-m-d", strtotime(Input::get('tmt')));
            
            $kp->statususul = Input::get('statususul');
            $kp->statussk = Input::get('statussk');
            $kp->nosk = Input::get('nosk');
            $kp->tglsurat = date("Y-m-d", strtotime(Input::get('tglsurat')));
            //$kp->tmt = date("Y-m-d", strtotime(Input::get('tmt')));
            $kp->iscetaksk = Input::get('iscetaksk');
            $kp->kettms = Input::get('kettms');
            $kp->ketbtl = Input::get('ketbtl');
            $kp->kepalabkd = Input::get('kepalabkd');
            $kp->nipkepalabkd = Input::get('nipkepalabkd');
            $kp->jabkepalabkd = Input::get('jabkepalabkd');
            $kp->pangkatbkd = Input::get('pangkatbkd');

            $kp->role_id = \Session::get('role_id');
            $kp->user_id = \Session::get('user_id');

            return $kp->save()?4:"Update kenaikan pangkat gagal disimpan!";
        }

        return "Data kenaikan pangkat tidak ditemukan!";
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

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('penetapannominatifkp::'.$view.'_view');

    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('penetapannominatifkp::'.$view.'_data');
    }

    /*function view data atribut dari link */
    function postCetak(){
        $view = Request::segment(4);
        return View::make('penetapannominatifkp::'.$view.'_print');
    }

    function postCetaksimpan(){
        $bulan             = Input::get('bulan');
        $tahun             = Input::get('tahun');
        $tmt               = $tahun."-".$bulan."-";
        $idskpd            = Input::get('idskpd');
        $dt['no_sp'] 	   = Input::get('no_sp');
        $dt['tgl_sp'] 	   = date('Y-m-d', strtotime(Input::get('tgl_sp')));
        $dt['berkas_sp']   = Input::get('berkas_sp');
        
        $update = \DB::table('tr_kenaikan_pangkat')->where('tmt', 'like', $tmt.'%')->where('idskpd', 'like', $idskpd. '%')->update($dt);
        
        $view = Request::segment(4);
        return View::make('penetapannominatifkp::'.$view.'_print');
    }

    function getPrint(){
        $view = Request::segment(4);
        return View::make('penetapannominatifkp::'.$view.'_print');
    }

    function getCetaknominatif(){
        return View::make('penetapannominatifkp::nominatif_print');
    }

    function postEditkp(){
        $nip = Input::get('nip');

        $rs = \DB::table('tr_kenaikan_pangkat as a')
                ->select('a.nip', 'a.idjeniskp', 'b.id','c.nama')
                ->join('a_jenis_kp as b','a.idjeniskp','=','b.id')
                ->join('tb_01 as c','a.nip','=','c.nip')
                ->where('a.nip', $nip)
                ->first();
            
        $id=$rs->idjeniskp;
        if($id == 1){
            $folder="Reguler";
            $linkid=23;
        }else if($id == 2){
            $folder="Struktural";
            $linkid=25;
        }else if($id == 3){
            $folder="Fungsional";
            $linkid=24;
        }else if($id == 4){
            $folder="Penyesuaian Ijazah";
            $linkid=26;
        }else if($id == 5){
            $folder="Penghargaan";
            // $linkid=;
        }else if($id == 6){
            $folder="Penjatuhan HD";
            // $linkid=;
        }else{
            $folder="Pencabutan HD";
            // $linkid=;
        }

        // if(Input::has('id')){
        //     $id = Input::get('id');
        //     $folder = "Kenaikan Pangkat";
        // }

        $rs2 = callApi('get', 'https://simpeg.kendalkab.go.id/efile/dokumenpersyaratan?id='.$linkid.'&nip='.$nip);
        $response = [
            'data1'=> $rs,
            'data2' => $rs2,
            "folder" => $folder
        ];
        echo json_encode($response);
    }



    // function postEditkp_(){
    //     $idusul = Input::get('idusul');
    //     $nip = Input::get('nip');

    //     $rs = PenetapannominatifkpModel::
    //         select('tr_kenaikan_pangkat.*'
    //             ,'a_golruang.golru'
    //             ,'a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
    //             ,'a_skpd.skpd'
    //             ,\DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap')
    //             ,\DB::raw('IF(tb_01.idjenjab>4, a_skpd.jab, IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
    //         )
    //         ->leftjoin('tb_01', 'tr_kenaikan_pangkat.nip', '=', 'tb_01.nip')
    //         ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
    //         ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')

    //         ->leftjoin('a_tkpendid', 'tr_kenaikan_pangkat.idtkpendid', '=', 'a_tkpendid.idtkpendid')
    //         ->leftjoin('a_jenjurusan', 'tr_kenaikan_pangkat.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
    //         ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
    //         ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
    //         ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    //         ->orderby('tr_kenaikan_pangkat.nousul','desc')
    //         ->where('tr_kenaikan_pangkat.idusul', $idusul)
    //         ->where('tr_kenaikan_pangkat.nip', $nip)
    //         ->first();

    //     echo json_encode($rs);
    // }
}
