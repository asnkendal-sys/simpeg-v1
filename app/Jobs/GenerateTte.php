<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\KGB\UsulanKGB;
use App\Models\Riwayat\TTE;
use App\Services\KGBService;
use App\Services\TTEService;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateTte extends Job implements SelfHandling, ShouldQueue
{
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $kgbId;
    public $nip;

    public function __construct($kgbId, $nip)
    {
        $this->kgbId = $kgbId;
        $this->nip = $nip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $kgb = UsulanKGB::where('idkgb', $this->kgbId)
            ->where('nip', $this->nip)
            ->first();        
            
        if(!$kgb){
            return;
        }

        $s_kgb = new KGBService($kgb);
        //generate sk        
        if($s_kgb->generateSK()){
            //log generate
//            r_tte_miss_final to r_tte_miss_final_2
            \DB::table('r_tte_miss_final_2')
                ->where('id_sk', $this->kgbId)->where('nip_pengusul', $this->nip)
                ->update(['generate' => 1, 'generate_at' => sekarang()]);

            //ajukan tte
            $kgb2 = UsulanKGB::where('idkgb', $this->kgbId)
            ->where('nip', $this->nip)
            ->first();
            $s_kgb2 = new KGBService($kgb2);

            if($s_kgb2->ajukanTTE()){
                //log generate
                \DB::table('r_tte_miss_final_2')
                ->where('id_sk', $this->kgbId)->where('nip_pengusul', $this->nip)
                ->update(['ajukan' => 1, 'ajukan_at' => sekarang()]);

                // proses sign tte
                $tte = TTE::where('id_sk', $this->kgbId)
                    ->where('nip_pengusul', $this->nip)
                    ->first();
                    
                if($tte->nip_pejabat == '197206261996031003'){ //ABDUL BASIR
                    $pashprase = 'xxxxxxx';
                }else if($tte->nip_pejabat == '197011041990032001'){ //IDA NUR HAYATI
                    $pashprase = '1d4Bkpp_2023';
                }else{
                    $pashprase = 'xxxxxxx';
                }                     
                
                if(!$tte){
                    return;
                }

                $tte_s = new TTEService($tte);
                if($tte_s->sign($pashprase)){
                    //log proses
                    \DB::table('r_tte_miss_final_2')
                    ->where('id_sk', $this->kgbId)->where('nip_pengusul', $this->nip)
                    ->update(['proses' => 1, 'proses_at' => sekarang()]);
                }
            }            
        }          
    }
}
