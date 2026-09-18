<?php namespace App\Modules\emutasi\nominatifantarskpd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\nominatifantarskpd\Models\NominatifantarskpdModel;
use Input,View, Request, Form, File;

/**
* Nominatifantarskpd Controller
* @var Nominatifantarskpd
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class NominatifantarskpdController extends Controller {
    protected $nominatifantarskpd;

    public function __construct(NominatifantarskpdModel $nominatifantarskpd){
        $this->nominatifantarskpd = $nominatifantarskpd;
    }

    public function getIndex(){
        cekAjax();
        if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {
            $where = "tr_mutasi_dalam_daerah.idusul != ''";
            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_mutasi_dalam_daerah.idskpd like '$idskpd%'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (tr_mutasi_dalam_daerah.nip like '%".Input::get('search')."%' or nama like '%".Input::get('search')."%')";
            }
            if(session('role_id') > 3){
                $where .= " and tr_mutasi_dalam_daerah.idskpd like \"".session('idskpd')."%\" ";
            }
            if(\session::get('role_id')<=3){
                $nominatifantarskpds = $this->nominatifantarskpd
                ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                    ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

                ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
                ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
                ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
                ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                ->whereRaw($where)
                ->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
                ->paginate($_ENV['configurations']['list-limit']);
            }
            else
            {   
                $nominatifantarskpds = $this->nominatifantarskpd
                ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
                    ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

                    \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

                ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
                ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
                ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
                ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
                ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                ->whereRaw($where)
                ->where('tr_mutasi_dalam_daerah.no_suratrek','!=','')
                ->orderBy(\DB::raw('tr_mutasi_dalam_daerah.nousul desc,tr_mutasi_dalam_daerah.idusul'))
                ->paginate($_ENV['configurations']['list-limit']);
            }
        }else{
            $nominatifantarskpds = $this->nominatifantarskpd->all();
        }
        return View::make('nominatifantarskpd::index', compact('nominatifantarskpds'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('nominatifantarskpd::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $arrnot     = array("","nip","nousulx","tglusul","_token","idjabjbtbarux","tmtx","tgl_suratrek");
        $arrindex   = array("","idusul","nip");
        $keyin      = array("","idusul","nousul");
        $keyout     = array("","idusul","nousul");
        $keydate    = array('','','');
        
        $tglusul = date("Y-m-d", strtotime(Input::get('tmtx')));
        $dti['tglusul'] = $tglusul;
        $dt['tglusul'] = $tglusul;

        $tgl_suratrek = date("Y-m-d", strtotime(Input::get('tgl_suratrek')));
        $dti['tgl_suratrek'] = $tgl_suratrek;
        $dt['tgl_suratrek'] = $tgl_suratrek;
        
        $dt['nousul'] = Input::get('nousul');
        $dt['role_id']   =\session::get('role_id') ;  


        foreach($_POST as $key=>$value){

            if(array_search($key,$arrnot)==""){
                if(array_search($key,$keyin)!=""){
                    $keys =  array_keys($keyin,$key);
                    $key  = $keyout[$keys[0]];
                }
                if(!is_array($value)){
                    $dt[$key] = $value;
                    if(array_search($key,$arrindex)!=""){
                        $dti[$key] = $value;
                    }
                }

                if($dt['nousul']==''){
                    $rs = \DB::table('tr_mutasi_dalam_daerah')->select(\DB::raw("CONCAT(DATE_FORMAT('".$dti['tglusul']."','%y%m%d'),
                        LPAD(IFNULL(MAX(RIGHT(nousul,3))+1,1),3,0)) AS kd"))->where('tglusul', $dti['tglusul'])->first();

                    $dt['nousul'] = $rs->kd;
                }

                if(is_array($value)){
                    foreach($value as $key2=>$value2){
                        $dt[$key2] = $value2;                                                
                        if(array_search($key2,$arrindex)!=""){
                            $dti[$key2] = $value2;
                        }
                        if(array_search($key2,$keydate)!=''){
                        // if(array_search($key2)!=''){
                            if($value2 != ''){
                                $val = explode("-",$value2);
                                $dt[$key2] = $val[2]."-".$val[1]."-".$val[0];
                            }else{
                                $dt[$key2] = '0000-00-00';
                            }
                        }                        
                    }
                    $rssimpan = \DB::table('tr_mutasi_dalam_daerah')->insert($dt);
                }
            }
        }
        echo ($rssimpan)?1:"Gagal Disimpan";
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $nominatifantarskpd = $this->nominatifantarskpd->find($id);
        //if (is_null($nominatifantarskpd)){return \Redirect::to('emutasi/nominatifantarskpd/index');}
        return View::make('nominatifantarskpd::edit', compact('nominatifantarskpd'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, nominatifantarskpdModel::$rules);

        if ($validation->passes()){
            $nominatifantarskpd = $this->nominatifantarskpd->find($id);
            echo ($nominatifantarskpd->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    public function postUsdelete(){
        cekAjax();
        $nousuls = Input::get('nousul');
        if (is_array($nousuls)){
            foreach($nousuls as $nousul){
                $this->nominatifantarskpd->find($nousul)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->nominatifantarskpd->where('nousul',$nousuls)->delete())?9:'Gagal Dihapus';
        }
    }
    public function postDelete(){
        cekAjax();
        $idusuls = Input::get('idusul');
        if (is_array($idusuls)){
            foreach($idusuls as $idusul){
                $this->nominatifantarskpd->find($idusul)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->nominatifantarskpd->where('idusul',$idusuls)->delete())?9:'Gagal Dihapus';
        }
    }

    /*MAIN FOCUS 23 UPDATE*/
    function postEditmutasi(){
        $idusul = Input::get('idusul');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_mutasi_dalam_daerah')
        ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
            ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

            \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

            \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

        ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
        ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
        ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
        ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
        ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
        ->orderby('tr_mutasi_dalam_daerah.nousul','desc')
        ->where('tr_mutasi_dalam_daerah.idusul', $idusul)
        ->where('tr_mutasi_dalam_daerah.nip', $nip)
        ->first();

        echo json_encode($rs);
    }
    /*function untuk simpan update Mutasi Dalam SKPD*/
    function postUpdatemutasi(){
        cekAjax();
        $input = Input::all();
        //kondisi where
        $dt['idusul'] = $input['idusul'];
        $dt['nip'] = $input['nip'];

        //data yang akan di update

        $data['idjabfungbaru'] = Input::get('idjabfungbaru');    

        $data['idjabfungumbaru'] = Input::get('idjabfungumbaru');   

        $data['idjabjbtbaru'] = Input::get('idjabjbtbaru');   


        $data['idjenjabbaru'] = $input['idjenjabbaru'];
        $data['idskpdbaru'] = $input['idskpdbaru'];
        $data['keterangan'] = $input['keterangan'];

        if(!\DB::table("tr_mutasi_dalam_daerah")->where($dt)->update($data)){
            echo "Update mutasi dalam skpd gagal disimpan";
        }else{
            echo 4;
        }
    }
    /*Belum Jalan*/
    function postVerantarskpd(){
        $idusul = Input::get('idusul');
        $nip = Input::get('nip');

        $rs = \DB::table('tr_mutasi_dalam_daerah')
        ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan'
            ,'skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),

            \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),

            \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))

        ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
        ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
        ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
        ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
        ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
        ->where('tr_mutasi_dalam_daerah.idusul', $idusul)
        ->where('tr_mutasi_dalam_daerah.nip', $nip)
        ->first();
        $idspkdnya = $rs->idskpd;
        if ($rs->kepalabkd == "")
        {
           $rs->kepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'namalengkap');   
           $rs->nipkepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'nip');   
           $rs->jabkepalabkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'jab');   
           $rs->pangkatbkd = \NominatifdalamskpdModel::attrPengantarskpd($idspkdnya, 'pangkat');   
       }
       echo json_encode($rs);
   }


   function postVerifikasimutasiantarskpd(){
    cekAjax();
    $input = Input::all();
    $dt['idusul'] = $input['idusul'];
    $dt['nip'] = $input['nip'];

    $data['idjenjabbaru'] = $input['idjenjabbaru'];
    $data['nousul'] = $input['nousul'];

    //data yang akan di update
    if($input['idjenjabbaru'] == 2){
        $data['idjabfungbaru'] = $input['idjabfungbaru'];    
    }
    else if($input['idjenjabbaru'] == 3){
        $data['idjabfungumbaru'] = $input['idjabfungumbaru'];   
    }
    else if($input['idjenjabbaru'] >= 20){
       $data['idjabjbtbaru'] = $input['idjabjbtbaru'];   
   }


   $data['idskpdbaru'] = $input['idskpdbaru'];
   $data['keterangan'] = $input['keterangan'];

   $data['ispengantar'] = Input::get('ispengantar');
   $data['ispermohonan'] = Input::get('ispermohonan');
   $data['isskpkt'] = Input::get('isskpkt');

   $data['isdiperbantukan'] = Input::get('isdiperbantukan');

   if($data['isdiperbantukan'] == 1){
       $data['iddiperbantukan'] = Input::get('iddiperbantukan');
   }else{
    $data['iddiperbantukan'] = '';
}

$data['statususul'] = $input['statususul'];
if($data['statususul'] == 2){
    $data['kettms'] = $input['kettms'];
    $data['ketbtl'] = '';
}else if($data['statususul'] == 3){
    $data['kettms'] = '';
    $data['ketbtl'] = $input['ketbtl'];
}else{
    $data['kettms'] = '';
    $data['ketbtl'] = '';
}

$data['statussk'] = $input['statussk'];
if($data['statussk'] == 1 || $input['iscetaksk'] == 1){
    $data['nosk'] = Input::get('nosk');
    $data['tglsurat'] = date("Y-m-d", strtotime(Input::get('tglsurat')));
    $data['tmt'] = date("Y-m-d", strtotime(Input::get('tmt')));
    $data['iscetaksk'] = Input::get('iscetaksk');
    $data['kepalabkd'] = Input::get('kepalabkd');
    $data['nipkepalabkd'] = Input::get('nipkepalabkd');
    $data['pangkatbkd'] = Input::get('pangkatbkd');
    $data['jabkepalabkd'] = Input::get('jabkepalabkd');
}else{
    $data['nosk'] = '';
    $data['tglsurat'] = '';
    $data['tmt'] = '';
    $data['iscetaksk'] = '';
}

if(!\DB::table("tr_mutasi_dalam_daerah")->where($dt)->update($data)){
    echo "Update mutasi dalam skpd gagal disimpan";
}else{
    echo 4;
}

}
/*MAIN FOCUS 23 UPDATE*/




/*function cari pegawai*/
function postCaripegawai(){
    cekAjax();
    $keyword    = Input::get('keyword');
    $per_page   = intval(Input::get('per_page'));
    $start      = (intval(Input::get('page'))-1)*$per_page;
    $page       = intval(Input::get('page'));

    $where = "a.idjenkedudupeg not in('21','99') and (a.nip like \"%".$keyword."%\" or a.nama like \"%".$keyword."%\")";
    if(session('role_id') == 4){
        $where .= " and a.idskpd like \"".session('idskpd')."%\" ";
    }

    $rs = \DB::table('tb_01 as a')
    ->select(
        'a.nip', 'a.nama', 'a.nip as id', 'a.nama as text', 'a.photo', 'b.skpd','f.jenkedudupeg',
        \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
        \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
    )
    ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
    ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
    ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
    ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
    ->leftjoin('a_jenkedudupeg as f', 'a.idjenkedudupeg', '=', 'f.idjenkedudupeg')
    ->whereRaw($where)
            /*->where('a.nip', 'like', '%'.$keyword. '%')
            ->orwhere('a.nama', 'like', '%'.$keyword. '%')*/
            ->orderBy('a.nama','asc')
            ->orderBy('a.nip','asc');

            $arr['result']      = count($rs->get());
            $arr['per_page']    = $per_page;
            $arr['page']        = (($page>0)?$page:1);
            $arr['rows']        = $rs->skip($start)->take($per_page)->get();
            echo json_encode($arr);
        }

        /*function list jabatan struktural selact 2*/
        function postListjabstruk2(){
            cekAjax();
            $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
            /*$id         = substr(Input::get('id'),0,2);*/
            $per_page   = intval(Input::get('per_page'));
            $start      = (intval(Input::get('page'))-1)*$per_page;
            $page       = intval(Input::get('page'));

            $where = "a.jab like '%".$keyword."%' or a.idskpd like '%".$keyword."%'";

            $rs = \DB::table('a_skpd as a')
            ->select('a.idskpd as id','a.jab as text')
            ->where('flag', 1)
            ->whereRaw($where)
            ->orderBy('a.idskpd','asc');

            $arr['result']      = count($rs->get());
            $arr['per_page']    = $per_page;
            $arr['page']        = (($page>0)?$page:1);
            $arr['rows']        = $rs->skip($start)->take($per_page)->get();
            echo json_encode($arr);
        }
        /*function list jabatan fungsional select 2*/
        function postListjabfung2(){
            cekAjax();
            $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
            $id         = substr(Input::get('id'),0,2);
            $per_page   = intval(Input::get('per_page'));
            $start      = (intval(Input::get('page'))-1)*$per_page;
            $page       = intval(Input::get('page'));
            
            $where      = "a.jabfung like '%".$keyword."%' or a.idjabfung like '%".$keyword."%'";

            $rs = \DB::table('a_jabfung as a')
            ->select('a.idjabfung as id','a.jabfung as text')
            ->where('flag', 1)
            ->whereRaw($where)
            ->orderBy('a.jabfung','asc');

            $arr['result']      = count($rs->get());
            $arr['per_page']    = $per_page;
            $arr['page']        = (($page>0)?$page:1);
            $arr['rows']        = $rs->skip($start)->take($per_page)->get();
            echo json_encode($arr);
        }

        /*function list jabatan fungsional umum select 2*/
        function postListjabfungum2(){
            cekAjax();
            $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
            $id         = substr(Input::get('id'),0,2);
            $per_page   = intval(Input::get('per_page'));
            $start      = (intval(Input::get('page'))-1)*$per_page;
            $page       = intval(Input::get('page'));

            $where      = "a.jabfungum like '%".$keyword."%' or a.idjabfungum like '%".$keyword."%'";

            $rs = \DB::table('a_jabfungum as a')
            ->select('a.idjabfungum as id','a.jabfungum as text')
            ->where('flag', 1)
            ->whereRaw($where)
            ->orderBy('a.jabfungum','asc');
            
            $arr['result']      = count($rs->get());
            $arr['per_page']    = $per_page;
            $arr['page']        = (($page>0)?$page:1);
            $arr['rows']        = $rs->skip($start)->take($per_page)->get();
            echo json_encode($arr);
        }

        /*KODE C (CONTROLLER)*/
        function postCariwhereskpd2(){
            $keyword    = (is_array(Input::get('keyword')))?Input::get('keyword')['term']:Input::get('keyword');
            $per_page   = intval(Input::get('per_page'));
            $start      = (intval(Input::get('page'))-1)*$per_page;
            $page       = intval(Input::get('page'));
            
            /*MASIH BOCOR Cek Ke Mas Rendy Dulu*/ 
            $where      = "(LEFT(skpd,14) = 'UPTD Pendidika' OR LEFT(skpd,14) = 'UPTD Puskesmas' OR LEFT(skpd,9) = 'Kelurahan' OR idparent='' OR 
            LEFT(skpd,4) = 'SMP ' OR LEFT(skpd,4) = 'SDN 'OR LEFT(skpd,4) = 'SD N' OR (idskpd LIKE '01%' AND LENGTH(idskpd)='8'))
            AND (idskpd like '%".$keyword."%' or skpd like '%".$keyword."%')";

            //$where      = "left(idskpd, 2) = \"".substr($parent,0,2)."\" AND (idskpd like '%".$keyword."%' or skpd like '%".$keyword."%')";
            
            $rs = \DB::table('a_skpd')
            ->select('idskpd', 'skpd', 'idskpd as id', 'skpd as text','idparent')
            ->where('flag', 1)
            ->whereRaw($where)
            ->orderBy('idskpd','asc')
            ->orderBy('skpd','asc');

            $arr['result']      = count($rs->get());
            $arr['per_page']    = $per_page;
            $arr['page']        = (($page>0)?$page:1);
            $arr['rows']        = $rs->skip($start)->take($per_page)->get();
            echo json_encode($arr);
        }

        /*function view data atribut dari link */
        function postView(){
            cekAjax();
            $view = Request::segment(4);
            return View::make('nominatifantarskpd::'.$view.'_view');

        }

        /*function view data atribut dari link */
        function postData(){
            cekAjax();
            $view = Request::segment(4);
            return View::make('nominatifantarskpd::'.$view.'_data');
        }

        /*function view data atribut dari link */
        function postCetak(){
            $view = Request::segment(4);
            return View::make('nominatifantarskpd::'.$view.'_print');
        }
        /*function view data atribut dari link */
        function getCetak(){
            $view = Request::segment(4);
            return View::make('nominatifantarskpd::'.$view.'_print');
        }

        function getCetaknominatif(){
            return View::make('nominatifantarskpd::nominatif_print');
        }


    }
