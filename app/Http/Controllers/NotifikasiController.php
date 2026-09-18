<?php

namespace App\Http\Controllers;

use View, Validator, Input, Session, Redirect, Auth;

class NotifikasiController extends Controller {

    public function getIndex() {
        $where = "tb_01.idjenkedudupeg not in('99','21')";
        if(session('role_id') == '5'){
            $status = 2;
            $where.= " and tb_01.nip = \"".session('user_id')."\" ";
        }else if(session('role_id') == '4'){
            $status = 2;
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }else if(session('role_id') <= '3'){
            $status = 0;
        }

        $rs['r_biodata']  = \DB::table('tb_01_temp')->leftjoin('tb_01', 'tb_01_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and tb_01_temp.status = \"".$status."\"")->count();
        //$rs['r_biodata']  = \DB::table('tb_01_temp')->leftjoin('tb_01', 'tb_01_temp.nip', '=', 'tb_01.nip')->whereRaw("tb_01_temp.status = \"".$status."\"")->count();
        $rs['r_pangkat']      = \DB::table('r_gol_temp')->leftjoin('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_gol_temp.status = \"".$status."\"")->count();
        $rs['r_jab']      = \DB::table('r_jab_temp')->leftjoin('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_jab_temp.status = \"".$status."\"")->count();
        $rs['r_kgb']          = \DB::table('r_kgb_temp')->leftjoin('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_kgb_temp.status = \"".$status."\"")->count();
        $rs['r_pend']         = \DB::table('r_pend_temp')->leftjoin('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_pend_temp.status = \"".$status."\"")->count();
        $rs['r_dikstru']      = \DB::table('r_dikstru_temp')->leftjoin('tb_01', 'r_dikstru_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_dikstru_temp.status = \"".$status."\"")->count();
        $rs['r_dikfung']      = \DB::table('r_dikfung_temp')->leftjoin('tb_01', 'r_dikfung_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_dikfung_temp.status = \"".$status."\"")->count();
        $rs['r_diktek']       = \DB::table('r_diktek_temp')->leftjoin('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_diktek_temp.status = \"".$status."\"")->count();
        $rs['r_hukdis']       = \DB::table('r_hukdis_temp')->leftjoin('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_hukdis_temp.status = \"".$status."\"")->count();
        $rs['r_pppk']       = \DB::table('r_pppk_temp')->leftjoin('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')->whereRaw($where." and r_pppk_temp.status = \"".$status."\"")->count();

        /*ADD BY REZA, Tuk Notif Verif jika Bupati dan Sekda*/
        $wherecuti   ="tr_ijin_cuti.id != '' ";
        $wherecutiatasan   ="";
        $wherecutiwewenang ="";
        if(session('role_id') <= '2'){
            $wherecutiatasan   .= " AND tr_ijin_cuti.atasan_nip = '-' OR tr_ijin_cuti.atasan_idskpd = '01' AND tr_ijin_cuti.atasan_status != 1";
            $wherecutiwewenang .= " AND tr_ijin_cuti.wewenang_status != 1 AND (tr_ijin_cuti.wewenang_nip = '-' OR tr_ijin_cuti.wewenang_idskpd = '01') ";
        }

        if (\Session::get('role_id') == 4) {
            $wherecuti .= "AND tr_ijin_cuti.idskpd like '%".\Session::get('idskpd')."%' AND tr_ijin_cuti.opd_status = '0' ";
        }
        if (\Session::get('role_id') == 5) {
            $wherecutiatasan   .= "AND (tr_ijin_cuti.atasan_nip = '".\Session::get('user_id')."') AND tr_ijin_cuti.atasan_status != 1";
            $wherecutiwewenang .= "AND (tr_ijin_cuti.wewenang_nip = '".\Session::get('user_id')."') AND tr_ijin_cuti.wewenang_status != 1";
        }
        $rs['v_cutiatasan']    = \DB::table('tr_ijin_cuti')->whereRaw($wherecuti." ".$wherecutiatasan)->count();
        $rs['v_cutiwewenang']  = \DB::table('tr_ijin_cuti')->whereRaw($wherecuti." ".$wherecutiwewenang)->count();

        if(array_sum($rs)){
            $rs['epersonal'] = (array_sum($rs) - ($rs['v_cutiatasan']+$rs['v_cutiwewenang'] )) ;
            $rs['biodatapegawai'] = $rs['epersonal'];
            $rs['perubahanbiodata'] = $rs['r_biodata'];
            $rs['perubahanriwayat'] = $rs['r_pangkat'] + $rs['r_jab'] + $rs['r_kgb'] + $rs['r_pend'] + $rs['r_dikstru'] + $rs['r_dikfung'] + $rs['r_diktek'] + $rs['r_hukdis'] + $rs['r_pppk'];
            $rs['jumlahbiodata'] = $rs['epersonal'];
            $rs['jumlahriwayat'] = $rs['perubahanriwayat'];
            $rs['v_cutiatasan']    = $rs['v_cutiatasan'];
            $rs['v_cutiwewenang']  = $rs['v_cutiwewenang'];

            $rs['ecuti']    = $rs['v_cutiatasan']+$rs['v_cutiwewenang'];
            $rs['verifikasicuti']    = $rs['v_cutiatasan']+$rs['v_cutiwewenang'];
        }else{
            $rs['epersonal'] = 0;
            $rs['biodatapegawai'] = 0;
            $rs['perubahanbiodata'] = 0;
            $rs['perubahanriwayat'] = 0;
            $rs['jumlahbiodata'] = 0;
            $rs['jumlahriwayat'] = 0;
            $rs['v_cutiatasan']    =0;
            $rs['v_cutiwewenang']  =0;
        }

        echo json_encode($rs);
    }
}
