<?php
namespace App\Services;

use App\Repositories\DiklatRepository;
use App\Models\Pegawai;
use App\Models\Riwayat\DiklatTeknis;
use App\Models\Riwayat\DiklatFungsional;
use App\Models\Riwayat\DiklatStruktural;

class RiwayatDiklatService
{
    public function fetch($nip)
    {
        $diklat = new DiklatRepository;
        return $diklat->apiPath('/api/pns/rw-diklat')->baseUrl(config('bkn.base_url_duplex_resource'))->fetch($nip);
    }

    public function kirimDiklatBKN($jenis_diklat="teknis", $id=[])
    {
        if($jenis_diklat == "teknis"){
            $list_diklat = DiklatTeknis::whereIn('id',$id)->get();
        }else if($jenis_diklat == "fungsional"){
            $list_diklat = DiklatFungsional::whereIn('id',$id)->get();
        }else if($jenis_diklat == "struktural"){
            // $list_diklat = DiklatStruktural::whereIn('id',$id)->get();
        }

        if(!empty($list_diklat)){
            foreach ($list_diklat as $diklat) {
                $tgmul = date('Y',strtotime($diklat->tgmul));
                $pegawai_idsapk = @Pegawai::where('nip','=',$diklat->nip)->aktif()->first()->idsapk;
                if($pegawai_idsapk){
                    $data = array(
                        "id" => null,
                        "jenisKursusId" => "",
                        "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
                        "pnsOrangId" => $pegawai_idsapk,
                        "namaKursus" => $diklat->nama_diklat,
                        "jumlahJam" => $diklat->jamhari,
                        "tanggalKursus" => date('d-m-Y' , strtotime($diklat->tgmul)),
                        "tahun" => $tgmul,
                        "institusiPenyelenggara" => $diklat->penyelenggara,
                        "jenisKursusSertipikat" => "T",
                        "nomorSertipikat" => $diklat->nomor_sttp,
                        "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diklat->tgsel)),
                        "lokasiId" => $diklat->tempat_diklat,
                        "pnsUserId" => env('PNS_USER_ID'),
                    );
                    $diklat_repo = new DiklatRepository;
                    $ret = $diklat_repo->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
                    $diklat_idsapk = @$ret['mapData']['rwKursusId'];
                    if(!empty($diklat_idsapk)){
                        $diklat->idsapk = $diklat_idsapk;
                        if($diklat->save()){
                           // $jml_data = $jml_data+1;
                           //this->info('Berhasil '.($jml_data).' # '.$diklat_idsapk); 
                        }
                    }
                }
            }
        }
        return 1;
    }

    // public function storeSapkByNIP($nip)
    // {
    //     $pegawai_idsapk = Pegawai::select('idsapk')->where('nip','=',$nip)->first()->idsapk;
    //     if($nip != '' && $pegawai_idsapk != ''){
    //         $diklat_teknis = DiklatTeknis::where('nip','=',$nip)
    //             ->where('tgmul', '!=', '')
    //             ->orWhereNotNull('tgmul')
    //             ->where(function ($query)
    //             {
    //              $query->where('idsapk', '=', '')
    //                     ->orWhereNull('idsapk');
    //             })
    //             ->get();
    //         foreach ($diklat_teknis as $key=>$diktek) {
    //             $tgmul = date('Y',strtotime($diktek->tgmul));
    //             if ($tgmul == "2020" || $tgmul == "2021") {
    //                 $diklat = new DiklatRepository;
    //                 $data = array(
    //                     "id" => null,
    //                     "jenisKursusId" => "",
    //                     "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
    //                     "pnsOrangId" => $pegawai_idsapk,
    //                     "namaKursus" => $diktek->nmdiktek,
    //                     "jumlahJam" => $diktek->jamhari,
    //                     "tanggalKursus" => date('d-m-Y' , strtotime($diktek->tgmul)),
    //                     "tahun" => $tgmul,
    //                     "institusiPenyelenggara" => $diktek->penyelenggara,
    //                     "jenisKursusSertipikat" => "T",
    //                     "nomorSertipikat" => $diktek->nosttpdiktek,
    //                     "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diktek->tgsel)),
    //                     "lokasiId" => $diktek->tmdiktek,
    //                     "pnsUserId" => $pegawai_idsapk
    //                 );
    //                 $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
    //                 $diktek->idsapk = @$ret['mapData']['rwKursusId'];
    //                 $diktek->save();
    //             }
    //         }
    //     }
    //     return "Selesai";
    // }

    // public function storeSapkAll()
    // {
    //     DiklatTeknis::
    //         where('id','>','7200')
    //         ->orWhereNotNull('tgmul')
    //         ->where(function ($query){
    //              $query->where('idsapk', '=', '')
    //                   ->orWhereNull('idsapk');
    //             })
    //         ->groupBy('nip')
    //         ->chunk(100, function ($diklat_teknis) {
    //             foreach ($diklat_teknis as $diktek) {
    //                 $pegawai_idsapk = @Pegawai::where('nip','=',$diktek->nip)->aktif()->first()->idsapk;
    //                 if(!empty($pegawai_idsapk)){
    //                     $tgmul = date('Y',strtotime($diktek->tgmul));
    //                     if ($tgmul == "2020" || $tgmul == "2021") {
    //                         $data = array(
    //                             "id" => null,
    //                             "jenisKursusId" => "",
    //                             "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
    //                             "pnsOrangId" => $pegawai_idsapk,
    //                             "namaKursus" => $diktek->nmdiktek,
    //                             "jumlahJam" => $diktek->jamhari,
    //                             "tanggalKursus" => date('d-m-Y' , strtotime($diktek->tgmul)),
    //                             "tahun" => $tgmul,
    //                             "institusiPenyelenggara" => $diktek->penyelenggara,
    //                             "jenisKursusSertipikat" => "T",
    //                             "nomorSertipikat" => $diktek->nosttpdiktek,
    //                             "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diktek->tgsel)),
    //                             "lokasiId" => $diktek->tmdiktek,
    //                             "pnsUserId" => $pegawai_idsapk
    //                         );
    //                         $diklat = new DiklatRepository;
    //                         $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
    //                         $diktek_idsapk = @$ret['mapData']['rwKursusId'];
    //                         if(!empty($diktek_idsapk)){
    //                             $diktek->idsapk = $diktek_idsapk;
    //                             $diktek->save();
    //                         }
    //                     }

    //                 }
    //             }
    //         });
    // }

    // public function storeSapkByNIP($nip)
    // {
    //     $pegawai_idsapk = Pegawai::select('idsapk')->where('nip','=',$nip)->first()->idsapk;
    //     if($nip != '' && $pegawai_idsapk != ''){
    //         $diklat_teknis = DiklatTeknis::where('nip','=',$nip)
    //             ->where('idsapk', '=', '')
    //             ->orWhereNull('idsapk')
    //             ->get();
    //         foreach ($diklat_teknis as $key=>$diktek) {
    //             $tgmul = date('Y',strtotime($diktek->tgmul));
    //             if ($tgmul == "2020" || $tgmul == "2021") {
    //                 $diklat = new DiklatRepository;
    //                 $data = array(
    //                     "id" => null,
    //                     "jenisKursusId" => "",
    //                     "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
    //                     "pnsOrangId" => $pegawai_idsapk,
    //                     "namaKursus" => $diktek->nmdiktek,
    //                     "jumlahJam" => $diktek->jamhari,
    //                     "tanggalKursus" => date('d-m-Y' , strtotime($diktek->tgmul)),
    //                     "tahun" => $tgmul,
    //                     "institusiPenyelenggara" => $diktek->penyelenggara,
    //                     "jenisKursusSertipikat" => "T",
    //                     "nomorSertipikat" => $diktek->nosttpdiktek,
    //                     "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diktek->tgsel)),
    //                     "lokasiId" => $diktek->tmdiktek,
    //                     "pnsUserId" => $pegawai_idsapk
    //                 );
    //                 $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
    //                 $diktek->idsapk = @$ret['mapData']['rwKursusId'];
    //                 $diktek->save();
    //             }
    //         }
    //     }
    //     return "Selesai";
    // }

}
