<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Pegawai;
use App\Models\KGB\UsulanKGB;
use App\Services\KGBService;
use App\Jobs\GenerateTte;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerateTtekgb extends Command
{
    use DispatchesJobs;
    protected $signature = 'generate:ttekgb';

    protected $description = 'Generate TTE KGB';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        r_tte_miss_final to r_tte_miss_final_2
        UsulanKGB::join('r_tte_miss_final_2', function ($join) {
            $join->on('tr_kgb.nip', '=', 'r_tte_miss_final_2.nip')
                ->on('tr_kgb.idkgb', '=', 'r_tte_miss_final_2.id_sk');
        })
        ->select('tr_kgb.*')
        // ->where('tr_kgb.idkgb','202201.12.09')
//         ->whereIn('tr_kgb.nip', ['199212162022212018'])
        ->where('r_tte_miss_final_2.proses', 0)
//        ->whereIn('tr_kgb.nip', ['199406092023211005', '198604032017062001'])
        ->orderBy('tr_kgb.tmtkgbb')
        ->orderBy('tr_kgb.idkgb')
        ->orderBy('tr_kgb.nip')
        ->chunk(100, function ($kgbs) {
            foreach ($kgbs as $kgb) {
                $this->dispatch(new GenerateTte($kgb->idkgb, $kgb->nip));                
            }
        }); //gagal

        // UsulanKGB::where('jnskgb',2)
        // // ->where('tmtkgbb','2026-03-01')
        // // ->whereIn('nip', ['197404161998032007', '199211232022212018'])
        // ->where('idkgb','202201.12.09')
        // ->whereIn('nip', ['196705132021211001', '196709122021211001'])
        // ->chunk(100, function ($kgbs) {
        //     foreach ($kgbs as $kgb) {
        //         $this->dispatch(new GenerateTte($kgb->idkgb, $kgb->nip));
        //         // \Log::info("Generate report running ".$x.' Dari '.$jml);
        //     }
        // });

        // $kgbs = UsulanKGB::where('jnskgb','=',2)
        //         ->where('tmtkgbb','=','2026-03-01')
        //         ->get();
        // $x = 0;        
        // $jml = count($kgbs);
        // foreach($kgbs as $kgb){
        //     $x++;
        //     $s_kgb = new KGBService($kgb);
        //     if($s_kgb->generateSK()){
        //         echo $x.' Dari '.$jml;
        //     }
        // }                   
    }
}
