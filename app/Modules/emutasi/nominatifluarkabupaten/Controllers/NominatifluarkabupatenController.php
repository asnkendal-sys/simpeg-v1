<?php namespace App\Modules\emutasi\nominatifluarkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\nominatifluarkabupaten\Models\NominatifluarkabupatenModel;
use Input,View, Request, Form, File;

/**
* Nominatifluarkabupaten Controller
* @var Nominatifluarkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifluarkabupatenController extends Controller {
    protected $nominatifluarkabupaten;

    public function __construct(NominatifluarkabupatenModel $nominatifluarkabupaten){
        $this->nominatifluarkabupaten = $nominatifluarkabupaten;
    }

        public function getIndex(){
        cekAjax();
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {
            $where = "tr_mutasi_luar_daerah.idusul != ''";
            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_mutasi_luar_daerah.idskpd like '$idskpd%'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_mutasi_luar_daerah.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
            }
            if(session('role_id') > 3){
                $where .= " and tr_mutasi_luar_daerah.idskpd like \"".session('idskpd')."%\" ";
            }
            $nominatifluarkabupatens = $this->nominatifluarkabupaten
                ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat','tb_01.nama',
                    \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                    \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
                )
                ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
                ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
                ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
                ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
                ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
                ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
                ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.nip'))
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $nominatifluarkabupatens = $this->nominatifluarkabupaten->all();
        }
        return View::make('nominatifluarkabupaten::index', compact('nominatifluarkabupatens'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('nominatifluarkabupaten::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, NominatifluarkabupatenModel::$rules);
        if ($validation->passes()){
            $arrnot     = array("","nip","nousulx","tmtx");
            $arrindex   = array("","idusul","nip");
            $keyin		= array("","idusul","nousul");
            $keyout		= array("","idusul","nousul");

            $tglusul = date("Y-m-d", strtotime(Input::get('tmtx')));

            $dti['tglusul'] = $tglusul;
            $dt['tglusul'] = $tglusul;
            $dt['nousul'] = Input::get('nousul');

            foreach($_POST as $key=>$value){
                if(array_search($key,$arrnot)==""){
                    if(array_search($key,$keyin)!=""){
                        $keys =  array_keys($keyin,$key);
                        $key = $keyout[$keys[0]];
                    }
                    if(!is_array($value)){
                        $dt[$key] = $value;
                        if(array_search($key,$arrindex)!=""){
                            $dti[$key] = $value;
                        }
                    }

                    if($dt['nousul']==''){
                        $rs = \DB::table('tr_mutasi_luar_daerah')
                            ->select(\DB::raw("CONCAT(DATE_FORMAT('".$dti['tglusul']."','%y%m%d'),LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))
                            ->where('tglusul', $dti['tglusul'])
                            ->first();

                        $dt['nousul'] = $rs->kd;
                    }

                    if(is_array($value)){
                        foreach($value as $key2=>$value2){
                            if($key2 == 'tglskpermintaan'){
                                $dt[$key2] = date("Y-m-d", strtotime($value2));
                            }else{
                                $dt[$key2] = $value2;
                            }

                            if(array_search($key2,$arrindex)!=""){
                                $dti[$key2] = $value2;
                            }
                        }

                        $dt['user_id'] = \Session::get('user_id');
                        $dt['role_id'] = \Session::get('role_id');
                        echo ($this->nominatifluarkabupaten->create($dt))?1:"Gagal Disimpan";
                    }
                }
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
        $nominatifluarkabupaten = $this->nominatifluarkabupaten->find($id);
        //if (is_null($nominatifluarkabupaten)){return \Redirect::to('emutasi/nominatifluarkabupaten/index');}
        return View::make('nominatifluarkabupaten::edit', compact('nominatifluarkabupaten'));
    }
    
    public function postEdit(){
        cekAjax();
        $idusul = Input::get('idusul');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_mutasi_luar_daerah')
            ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
                \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan"),
                \DB::raw("
                    if(tr_mutasi_luar_daerah.tglskpermintaan!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglskpermintaan,'%d-%m-%Y'),'') AS tglskpermintaan_
                    ,if(tr_mutasi_luar_daerah.tglusul!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglusul,'%d-%m-%Y'),'') AS tglusul_
                    ,if(tr_mutasi_luar_daerah.tglsurat!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglsurat,'%d-%m-%Y'),'') AS tglsurat_
                    ,if(tr_mutasi_luar_daerah.tgl_sp!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tgl_sp,'%d-%m-%Y'),'') AS tgl_sp
                    ,if(tr_mutasi_luar_daerah.tmt!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tmt,'%d-%m-%Y'),'') AS tmt_
                    ,if(tr_mutasi_luar_daerah.tglsk_persetujuan!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglsk_persetujuan,'%d-%m-%Y'),'') AS tglsk_persetujuan_
                    ,tr_mutasi_luar_daerah.nosk_pengantar,if(tr_mutasi_luar_daerah.tglsk_pengantar!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglsk_pengantar,'%d-%m-%Y'),'') AS tglsk_pengantar_
                    ,tr_mutasi_luar_daerah.penetapsk_kanreg,tr_mutasi_luar_daerah.nosk_kanreg,if(tr_mutasi_luar_daerah.tglsk_kanreg!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tglsk_kanreg,'%d-%m-%Y'),'') AS tglsk_kanreg_,if(tr_mutasi_luar_daerah.tmt_berlaku!='0000-00-00',DATE_FORMAT(tr_mutasi_luar_daerah.tmt_berlaku,'%d-%m-%Y'),'') AS tmt_berlaku
                ")
            )
            ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
            ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
            ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
            ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
            ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
            ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
            ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
            ->where('tr_mutasi_luar_daerah.idusul', $idusul)
            ->where('tr_mutasi_luar_daerah.nip', $nip)
            ->first();

        echo json_encode($rs);
    }

    public function postUpdate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, NominatifluarkabupatenModel::$rules_edit);

        if ($validation->passes()){
            $dt['idusul'] = Input::get('id_edit1');
            $dt['nip'] = Input::get('id_edit2');

            $data['tglusul'] = date("Y-m-d", strtotime(Input::get('tglusul')));
            $data['tglskpermintaan'] = date("Y-m-d", strtotime(Input::get('tglskpermintaan')));
            //$data['noskpermintaan'] = Input::get('noskpermintaan');
            $data['idpemerintah'] = Input::get('idpemerintah');
            $data['provinsi'] = Input::get('provinsi');
            $data['kabupaten'] = Input::get('kabupaten');
            $data['instansi'] = Input::get('instansi');
            $data['keterangan'] = Input::get('keterangan');           
            
            echo (\DB::table("tr_mutasi_luar_daerah")->where($dt)->update($data))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postVerifikasi(){
        cekAjax();
        $dt['idusul'] = Input::get('id_edit1');
        $dt['nip'] = Input::get('id_edit2');

        $data['tglusul'] = date("Y-m-d", strtotime(Input::get('tglusul')));
        $data['tglskpermintaan'] = date("Y-m-d", strtotime(Input::get('tglskpermintaan')));
        
        $data['no_sp'] = Input::get('no_sp');
        $data['tgl_sp'] = date("Y-m-d", strtotime(Input::get('tgl_sp')));
        
        $data['noskpermintaan'] = Input::get('noskpermintaan');
        $data['idpemerintah'] = Input::get('idpemerintah');
        $data['provinsi'] = Input::get('provinsi');
        $data['kabupaten'] = Input::get('kabupaten');
        $data['instansi'] = Input::get('instansi');
        $data['keterangan'] = Input::get('keterangan');

        $data['ispengantar'] = Input::get('ispengantar');
        $data['ispermohonan'] = Input::get('ispermohonan');
        $data['isskcpns'] = Input::get('isskcpns');
        $data['isskpns'] = Input::get('isskpns');
        $data['isskpkt'] = Input::get('isskpkt');
        $data['iskarpeg'] = Input::get('iskarpeg');
        $data['isdhr'] = Input::get('isdhr');
        $data['isspskpd'] = Input::get('isspskpd');
        $data['isijazah'] = Input::get('isijazah');
        $data['issnikah'] = Input::get('issnikah');
        $data['isskjabfung'] = Input::get('isskjabfung');

        $data['statususul'] = Input::get('statususul');
        if($data['statususul'] == 2){
            $data['kettms'] = Input::get('kettms');
            $data['ketbtl'] = '';
        }else if($data['statususul'] == 3){
            $data['kettms'] = '';
            $data['ketbtl'] = Input::get('ketbtl');
        }else{
            $data['kettms'] = '';
            $data['ketbtl'] = '';
        }

        $data['statussk'] = Input::get('statussk');
        if($data['statussk'] == 1){
            $data['nosk'] = Input::get('nosk');
            $data['tglsurat'] = (Input::get('tglsurat')!='')?date("Y-m-d", strtotime(Input::get('tglsurat'))):'';
            $data['tmt'] = (Input::get('tmt')!='')?date("Y-m-d", strtotime(Input::get('tmt'))):'';
            $data['iscetaksk'] = Input::get('iscetaksk');
            $data['kepalabkd'] = Input::get('kepalabkd');
            $data['nipkepalabkd'] = Input::get('nipkepalabkd');
            $data['pangkatbkd'] = Input::get('pangkatbkd');
            $data['bupati'] = Input::get('bupati');
        }else if($data['statussk'] == 2){
            $data['nosk_persetujuan'] = Input::get('nosk_persetujuan');
            $data['tglsk_persetujuan'] = (Input::get('tglsk_persetujuan')!='')?date("Y-m-d", strtotime(Input::get('tglsk_persetujuan'))):'';
            $data['bupati'] = Input::get('bupati');
            $data['nosk_pengantar'] = Input::get('nosk_pengantar');
            $data['tglsk_pengantar'] = (Input::get('tglsk_pengantar')!='')?date("Y-m-d", strtotime(Input::get('tglsk_pengantar'))):'';
            $data['penetapsk_kanreg'] = Input::get('penetapsk_kanreg');
            $data['nosk_kanreg'] = Input::get('nosk_kanreg');
            $data['tglsk_kanreg'] = (Input::get('tglsk_kanreg')!='')?date("Y-m-d", strtotime(Input::get('tglsk_kanreg'))):'';
            /*$data['ditujukan_kepada'] = Input::get('ditujukan_kepada');
            $data['lokasi_ditujukan'] = Input::get('lokasi_ditujukan');*/
            $data['tmt_berlaku'] = (Input::get('tmt_berlaku')!='')?date("Y-m-d", strtotime(Input::get('tmt_berlaku'))):'';

            $data['iscetaksk'] = '';
        }else{
            $data['nosk'] = '';
            $data['tglsurat'] = '';
            $data['tmt'] = '';
            $data['iscetaksk'] = '';            
        }

        echo (\DB::table("tr_mutasi_luar_daerah")->where($dt)->update($data))?4:"Gagal Disimpan";
    }

    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        echo ($this->nominatifluarkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
    }

    public function postUsdelete(){
        cekAjax();
        $dt['nousul'] = Input::get('nousul');
        echo (\DB::table('tr_mutasi_luar_daerah')->where($dt)->delete())?9:'Gagal Dihapus';
    }

    /*function view data atribut dari link */
    function postView(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifluarkabupaten::'.$view.'_view');

    }

    /*function view data atribut dari link */
    function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('nominatifluarkabupaten::'.$view.'_data');
    }

    /*function view data atribut dari link */
    function postCetak(){
        $view = Request::segment(4);
        return View::make('nominatifluarkabupaten::'.$view.'_print');
    }
}
