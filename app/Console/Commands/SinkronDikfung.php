<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Repositories\DiklatRepository;
use App\Models\Riwayat\DiklatFungsional;
use App\Models\Pegawai;

class SinkronDikfung extends Command
{
    protected $signature = 'sinkron:dikfung {tahun}';

    protected $description = 'sinkrondikfung';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit',-1);

        $tahun = $this->argument('tahun');
        // $jml_data = 0;


        $datass = DiklatFungsional::
            where('id','>','9120')
            ->where(function($query) use ($tahun){
                $query->where('tgmul','like','%'.$tahun);
                $query->orWhere('tgmul','like',$tahun.'%');
            })
            ->whereRaw('LENGTH(idsapk) < 4');
            //->orderBy('nip');
        $jml_data = $datass->count();
        $this->info('Total '.$jml_data); 
        $datass->chunk(10, function ($diklat_fungsional) use ($jml_data) {
            $nip = '';
            foreach ($diklat_fungsional as $dikfung) {
		$this->info('ke '.$jml_data);
                if($nip != $dikfung->nip || empty($nip)){
                    $pegawai_idsapk = @Pegawai::where('nip','=',$dikfung->nip)->aktif()->first()->idsapk;
                }

                if(!empty($pegawai_idsapk)){
                    $tgmul = date('Y',strtotime($dikfung->tgmul));
                    if ($tgmul == "2020" || $tgmul == "2021") {
                        $data = array(
                            "id" => null,
                            "jenisKursusId" => "",
                            "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
                            "pnsOrangId" => $pegawai_idsapk,
                            "namaKursus" => $dikfung->dikfung,
                            "jumlahJam" => $dikfung->jamhari,
                            "tanggalKursus" => date('d-m-Y' , strtotime($dikfung->tgmul)),
                            "tahun" => $tgmul,
                            "institusiPenyelenggara" => $dikfung->penyelenggara,
                            "jenisKursusSertipikat" => "F",
                            "nomorSertipikat" => $dikfung->nosttpdikfung,
                            "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($dikfung->tgsel)),
                            "lokasiId" => $dikfung->tmdikfung,
                            "pnsUserId" => env('PNS_USER_ID'),
                        );
                        $diklat = new DiklatRepository;
                        $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
                        $dikfung_idsapk = @$ret['mapData']['rwKursusId'];
                        if(!empty($dikfung_idsapk)){
                            $dikfung->idsapk = $dikfung_idsapk;
                            if($dikfung->save()){
                                $this->info('Berhasil '.($jml_data).' # '.$dikfung_idsapk); 
                            }
                        }
			$this->info('info '.$ret['message']); 
                        //$this->info('info '.$data['tanggalKursus'].' # '.$data['tanggalSelesaiKursus']); 
                        sleep(2);
                    }
			$jml_data = $jml_data-1;
                }
            }
        }); 
    }
}
