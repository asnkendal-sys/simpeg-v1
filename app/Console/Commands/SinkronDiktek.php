<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Repositories\DiklatRepository;
use App\Models\Riwayat\DiklatTeknis;
use App\Models\Pegawai;

class SinkronDiktek extends Command
{
    protected $signature = 'sinkron:diktek {tahun}';

    protected $description = 'sinkrondiktek';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit',-1);

        $tahun = $this->argument('tahun');
        $jml_data = 0;


        $datass = DiklatTeknis::with(['pegawai' => function($query){
            $query->select('nip','idsapk');
        }])
            ->where('id','>','10007')
            ->where(function($query) use ($tahun){
                $query->where('tgmul','like','%'.$tahun);
                $query->orWhere('tgmul','like',$tahun.'%');
            })
            ->whereRaw('LENGTH(idsapk) < 4')
            ->orderBy('id','DESC');
	$jml_data = $datass->count();
        $this->info('Total '.$jml_data); 
        $datass->chunk(20, function ($diklat_teknis) use(&$jml_data) {
            $nip = '';
            $this->info('ke '.$jml_data); 
//            $jml_data = 0;
            
            foreach ($diklat_teknis as $diktek) {
//                if($nip != $diktek->nip || empty($nip)){
                    // $pegawai_idsapk = @Pegawai::where('nip','=',$diktek->nip)->aktif()->first()->idsapk;
  //              }
                $pegawai_idsapk = $diktek->pegawai->idsapk;

        //        if(!empty($pegawai_idsapk)){
                    // $pegawai_idsapk = @$diklat_teknis->pegawai->idsapk;
      //              $pegawai_idsapk = $diklat_teknis;//->pegawai->idsapk;
    //           }
              if(!empty($pegawai_idsapk)){
		  $tgmul = date('Y',strtotime($diktek->tgmul));
                    // if ($tgmul == "2020" || $tgmul == "2021") {
                        $data = array(
                            "id" => null,
                            "jenisKursusId" => "",
                            "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
                            "pnsOrangId" => $pegawai_idsapk,
                            "namaKursus" => $diktek->nmdiktek,
                            "jumlahJam" => $diktek->jamhari,
                            "tanggalKursus" => date('d-m-Y' , strtotime($diktek->tgmul)),
                            "tahun" => $tgmul,
                            "institusiPenyelenggara" => $diktek->penyelenggara,
                            "jenisKursusSertipikat" => "T",
                            "nomorSertipikat" => $diktek->nosttpdiktek,
                            "tanggalSelesaiKursus" => date('d-m-Y' , strtotime($diktek->tgsel)),
                            "lokasiId" => $diktek->tmdiktek,
                            "pnsUserId" => env('PNS_USER_ID'),
                        );
                        $diklat = new DiklatRepository;
                        $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
                        $diktek_idsapk = @$ret['mapData']['rwKursusId'];
                        if(!empty($diktek_idsapk)){
                            $diktek->idsapk = $diktek_idsapk;
                            if($diktek->save()){
                                $this->info('Berhasil '.($jml_data)); 
                            }
                        }
                        $this->info('info ');//.$ret['message']); 
                        //$this->info('info '.$data['tanggalKursus'].' # '.$data['tanggalSelesaiKursus']);
//                        $i++;
                        //if(fmod($i, 5) ==0){
                            sleep(1);
                        //}
                    // }
              }
		$this->info('ke-'.$jml_data--);
		//sleep(1);

            }
//		sleep(2);
        }); 
    }
}
