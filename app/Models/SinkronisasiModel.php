<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinkronisasiModel extends Model {

    /*start of sinkronisasi siasn*/
    public function getTest(){
        return "Josss";
    }

    /*function id kursus*/
    function getIdkursus($kursus='', $jenis=''){
        switch ($jenis){
            case '2' :
                $table = 'a_dikfung'; $diklat = 'dikfung'; $field = 'iddikfung';
                break;
            default :
                $table = 'a_dikfung'; $diklat = 'dikfung'; $field = 'iddikfung';
        }

        $rs = \DB::table($table)->where($diklat, $kursus)->first();

        return @$rs->$field;
    }

    /*function untuk mendapatkan idsapk pns*/
    function getPnsIdSapk($nip, $jenis=0)
    {
        if($jenis == 1){
            $rs = \DB::table('tb_01')->where('idsapk', $nip)->first();
            return @$rs->nip;
        }else{
            $rs = \DB::table('tb_01')->where('nip', $nip)->first();
            return @$rs->idsapk;
        }
    }

    /*function cek file siasn*/
    function fileSiasn($rspath){
        $return = '';
        $rspath = (array) $rspath;
        foreach($rspath as $file){
            $return = $file->dok_uri;
        }

        return $return;
    }

    /*function get where table parameter*/
    function getTable($table='', $where='', $value='', $filed=''){
        $rs = \DB::table($table)->where($where,$value)->first();
        if($rs){
            return $rs->$filed;
        }else{
            return '';
        }
    }

    /*function clean special character*/
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /*function untuk mendapatkan attribut pegawai*/
    function getAttpegawai($nip="", $field=""){
        $rs = \DB::table('tb_01 as a')
            ->select(
            \DB::raw('a.idjenjab, a.idgolrupkt, a.idskpd, concat(e.pangkat, " (",e.golru,")") as golrupkt, b.skpd'),
            \DB::raw('IF(a.idjenjab=1,b.idskpd,IF(a.idjenjab=2,c.idjabfung,IF(a.idjenjab=3,d.idjabfungum,"-"))) as idjab'),
            \DB::raw('IF(a.idjenjab=1,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,"-"))) as jabatan'),
            \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", ",""),a.gdb) as namalengkap')
        )
            ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
            ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
            ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftjoin('a_golruang as e', 'a.idgolrupkt', '=', 'e.idgolru')
            ->where('a.nip', '=', $nip)
            ->first();

        return $rs->$field;
    }
    /*end of sinkronisasi siasn*/

}