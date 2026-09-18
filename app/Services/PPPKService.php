<?php
namespace App\Services;
use App\Models\PPPK\UsulanPPPK as PPPK;
use App\Models\Riwayat\TTE;
use PDF,Storage,View;

class PPPKService
{
    protected $pppk;

    public function __construct(PPPK $pppk)
    {
        $this->pppk = $pppk;
    }

    public function ajukanTTE($berkas)
    {
        $tte = TTE::where('nip_pengusul',$this->pppk->nip)->where('id_sk',$this->pppk->idpppk)->where('jenis',$berkas)->first();
        /* deklarasi data baru setelah diupdate filenya */
        $tr_pppk = PPPK::where('nip',$this->pppk->nip)->where('idpppk', $this->pppk->idpppk)->first();
                
        if ($this->pppk->statussk == 1 && $tr_pppk->surat != "") { //$this->pppk->surat
            if ($tte === null) {
                $tte = new TTE();
                $tte->jenis = $berkas;
                $tte->id_sk = $this->pppk->idpppk;
                $tte->nip_pengusul = $this->pppk->nip;
            }

            $tte->nip_pejabat = $this->pppk->nipkepalabkd;
            switch($berkas){
                case 'PPPK': $tte->nik_pejabat = $this->pppk->pejabatPenetap->noktp; break;
                case 'PPPK-PEMBERHENTIAN': $tte->nik_pejabat = getPenetapsk("005", "nik"); break;
            }            
            
            $tte->user_id = \Session::get('user_id');
            $tte->role_id = \Session::get('role_id');
            $tte->created_at = sekarang();
            $tte->file_awal = $tr_pppk->surat; //$this->pppk->surat

            return $tte->save();
        }

        return 0;
    }

    public function generateSK($berkas)
    {           
        if($this->pppk->statussk == 1){

            $pdf = PDF::setOptions([
                'enable_html5_parser' => TRUE,
                'isRemoteEnabled' => true,
                ])->setPaper('legal', 'potrait');

            switch($berkas){
                case 'PPPK': 
                    $template = View::make('perpanjangankontrak::skpetikan_tte',[
                        'nip' => $this->pppk->nip,
                        'idpppk' => $this->pppk->idpppk,
                        'sts_kontrak' => $this->pppk->sts_kontrak
                    ]);        
                break;
                case 'PPPK-PEMBERHENTIAN': 
                    $template = View::make('pemberhentiankontrak::skpetikan_tte',[
                        'nip' => $this->pppk->nip,
                        'idpppk' => $this->pppk->idpppk,
                        'sts_kontrak' => $this->pppk->sts_kontrak
                    ]);
                break;
            }            

            // if($this->pppk->sts_kontrak == 2){
				$customFontDir = storage_path('fonts');
                $css = "
                    <style>
                        @font-face {
                            font-family: 'bookos';
                            src: url('". $customFontDir ."/BOOKOS.TTF') format('truetype');
                            font-weight: normal;
                            font-style: normal;
                        }
                        @font-face {
                            font-family: 'bookosb';
                            src: url('". $customFontDir ."/BOOKOSB.TTF') format('truetype');
                            font-weight: bold;
                            font-style: normal;
                        }
                        body {
                            font-family: 'Bookman Old Style', serif;
                            font-size: 12px;
                            background: white;
                            line-height:1;
                            letter-spacing: 0.5pt;
                        }

                        @page {
                            size: F4 potrait;
                            margin-left: 2.54cm; 
                            margin-right: 2.54cm;
                            margin-top: 2.54cm;
                            margin-bottom: 3.75cm;
                        }

                        .page-break { display:block; page-break-before:always; }

                        .header{
                            position: fixed;
                            line-height:1;
                            letter-spacing: 0.5pt;
                        }

                        .content{
                            position: fixed;
                            line-height:1;
                            letter-spacing: 0.5pt;
                        }

                        .footer {
                            position: fixed; 
                            font-family:'Bookman Old Style', serif;
                            font-size: 11pt;
                            bottom: 1cm; 
                            left: 0cm; 
                            right: 0cm;
                            height: 1cm;

                            /** Extra personal styles **/
                            text-align: center;font-size: 12px;font-family:'Bookman Old Style', serif;
                            line-height: 1.5cm;
                        }

                        #ttefooter {
                            position: fixed; 
                            font-family:'Bookman Old Style', serif;
                            font-size: 11pt;
                            bottom: 1cm; 
                            left: 0cm; 
                            right: 0cm;
                            height: 1cm;

                            /** Extra personal styles **/
                            text-align: center;font-size: 12px;font-family:'Bookman Old Style', serif;
                            line-height: 1.5cm;
                        }

                        table {
                            border-collapse: collapse;
                        }

                        table tbody > tr > td{
                            vertical-align: top;
                        }
                    </style>
                ";
                
                $html = $css . $template;

                $pdf_render = $pdf->loadHTML($html)->output();
            // }else{
            //     $pdf_render = $pdf->loadHTML(View::make('perpanjangankontrak::skpetikan_tte',[
            //         'nip' => $this->pppk->nip,
            //         'idpppk' => $this->pppk->idpppk,
            //         'sts_kontrak' => $this->pppk->sts_kontrak
            //     ])->render())->stream();
            // }
            
            $filename = $this->pppk->nip.'_'.$this->pppk->idpppk.'_'.$this->pppk->sts_kontrak.'_'.$this->pppk->idjenpens.'_'.rand(100,999).'.pdf';
            $file_path = '/pppk/draft/'.$filename;

            if (Storage::disk('local')->has($file_path) && $filename != '') {
                // Storage::disk('packages')->delete($file_path);
                unlink(storage_path('app'.$file_path));
            }

            if(Storage::disk('local')->put($file_path, $pdf_render)){
                if (Storage::disk('local')->has('/pppk/draft/'.$this->pppk->surat) && $this->pppk->surat != '') {
                    unlink(storage_path('app/pppk/draft/'.$this->pppk->surat));
                }

                $pppk = PPPK::where('idpppk',$this->pppk->idpppk)
                    ->where('nip','=',$this->pppk->nip)
                    ->update(['surat' => 'pppk/draft/'.$filename]);

                return $pppk;
            }
        }
        
        return 0;
    }
    
}
