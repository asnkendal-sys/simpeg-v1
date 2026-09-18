<?php

namespace App\Services;

use App\Models\KGB\UsulanKGB as KGB;
use App\Models\Riwayat\TTE;
use App\Models\PenetapannominatifModel;
use GuzzleHttp\Client;
use PDF, Storage, View;

class KGBService
{
    protected $kgb;

    public function __construct(KGB $kgb)
    {
        $this->kgb = $kgb;
    }

    public function ajukanTTE()
    {
        $tte = TTE::where('nip_pengusul', $this->kgb->nip)->where('id_sk', $this->kgb->idkgb)->where('jenis', 'KGB')->first();

        if ($this->kgb->statussk == 1 && $this->kgb->surat != "") {
            if ($tte === null) {
                $tte = new TTE();
                $tte->jenis = "KGB";
                $tte->id_sk = $this->kgb->idkgb;
                $tte->nip_pengusul = $this->kgb->nip;
            }

            $tte->nip_pejabat = $this->kgb->nippb;
            $tte->nik_pejabat = $this->kgb->pejabatPenetap->noktp;
            $tte->user_id = \Session::get('user_id');
            $tte->role_id = \Session::get('role_id');
            $tte->created_at = sekarang();
            $tte->file_awal = $this->kgb->surat;

            return $tte->save();
        }

        return 0;
    }

    public function generateSK()
    {
        if ($this->kgb->statussk == 1) {
            $pdf = PDF::setOptions([
                'enable_html5_parser' => TRUE,
                'isRemoteEnabled' => true,
            ])->setPaper('legal', 'potrait');

            $template = View::make('penetapannominatif::sk_tte', [
                'nip' => $this->kgb->nip,
                'idkgb' => $this->kgb->idkgb,
                'jnskgb' => $this->kgb->jnskgb
            ]);

            if ($this->kgb->idstspeg == 3) { //p3k font

                //candra uji coba kgb generate 26 februari 2026

                $item = \PenetapannominatifModel::getNominatifver($this->kgb->idkgb, $this->kgb->nip);

                //     $arrsearch = array("search","[noskkgbb]","[nama]","[nip]","[golpns_txt]","[nmajab]","[tmtmulaiawal_pppk]","[tmtakhirawal_pppk]",
                // "[tmtmulaiakhir_pppk]","[tmtakhirakhir_pppk]","[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]",
                // "[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]","[mktkgbb]","[mkbkgbb]","[tmtkgbb]","[tglskkgbb]","[jabpenkgbb]",
                // "[pejpenkgbb]","[qrcode]","[img_logo]",'[img_logo_tte]');

                // $arrreplace = array("replace",$item->noskkgbb,$item->nama,$item->nip,$item->golpns_txt,$item->nmajab,formatTanggalPanjang($item->tmtmulaiawal_pppk),
                // formatTanggalPanjang($item->tmtakhirawal_pppk),formatTanggalPanjang($item->tmtmulaiakhir_pppk),formatTanggalPanjang($item->tmtakhirakhir_pppk),
                // $item->tmpskpdskr,uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),
                // $item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
                // $item->mktkgbb,$item->mkbkgbb,formatTanggalPanjang($item->tmtkgbb),formatTanggalPanjang($item->tglskkgbb),
                // $item->jabpenkgbb,$item->pejpenkgbb,'<div id="qrcode"></div>',base_path().'/packages/tugumuda/img/logo.png',base_path().'/packages/tte/logo.png');

                $client = new Client();
                $filename  = $this->kgb->nip . '_' . $this->kgb->idkgb . '_' . $this->kgb->jnskgb . '_' . rand(100, 999) . '.pdf';
                $client->post('http://10.5.2.131:8000/api/render/sk', [
                    'json' => [
                        'noskkgb' => $item->noskkgb,
                        'nama' => $item->nama,
                        'nip'  => $item->nip,
                        'nmajab' => $item->nmajab,
                        'golpns_txt' => $item->golpns_txt,
                        'tmtmulaiawal_pppk' => formatTanggalPanjang($item->tmtmulaiawal_pppk),
                        'tmtakhirawal_pppk' => formatTanggalPanjang($item->tmtakhirawal_pppk),
                        'tmtmulaiakhir_pppk' => formatTanggalPanjang($item->tmtmulaiakhir_pppk),
                        'tmtakhirakhir_pppk' => formatTanggalPanjang($item->tmtakhirakhir_pppk),
                        'tmpskpdskr' => $item->tmpskpdskr,
                        'gaji' => uang($item->gkgbl),
                        'gajinominal' => $item->nomgpl,
                        'pejmen' => ucword($item->pejpenkgbl_txt),

                        'tgsk' => formatTanggalPanjang($item->tglskkgbl),
                        'nosk' => $item->noskkgbl,
                        'tmt' => formatTanggalPanjang($item->tmtkgbl),
                        'mkgolthn' => $this->kgb->mktkgbl,
                        'mkgolbln' => $this->kgb->mkbkgbl,
                        'gkgbb' => uang($item->gkgbb),
                        'nomgpb' => $item->nomgpb,
                        'mktkgbb' => $item->mktkgbb,
                        'mkbkgbb' => $item->mkbkgbb,
                        'tmtkgbb' => formatTanggalPanjang($item->tmtkgbb),
                        'tglskkgbb' => formatTanggalPanjang($item->tglskkgbb),
                        'jabpenkgbb' => $item->jabpenkgbb,
                        'pejpenkgbb' => $item->pejpenkgbb,



                    ],
                    'sink' => storage_path('app/ckgb/draft/' . $filename),
                ]);
                // end candra uji coba kgb generate 26 februari 2026
                $customFontDir = storage_path('fonts');
                $css = "
                             <style>
                                 @font-face {
                                     font-family: 'bookos';
                                     src: url('" . $customFontDir . "/BOOKOS.TTF') format('truetype');
                                     font-weight: normal;
                                     font-style: normal;
                                 }
                                 @font-face {
                                     font-family: 'bookos';
                                     src: url('" . $customFontDir . "/BOOKOSB.TTF') format('truetype');
                                     font-weight: bold;
                                     font-style: normal;
                                 }
                                 body {
                                     font-family: 'bookos', sans-serif;
                                     font-size: 12px;
                                     background: white;
                                     line-height:1;
                                     letter-spacing: 0.5pt;
                                 }

                                 @page {
                                     size: F4 potrait;
                                     margin-left: 1cm;
                                     margin-right: 1cm;
                                     margin-top: 1cm;
                                     margin-bottom: 1cm;
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
                                     font-family:'bookos', sans-serif;
                                     font-size: 11pt;
                                     bottom: 1cm;
                                     left: 0cm;
                                     right: 0cm;
                                     height: 1cm;

                                     /** Extra personal styles **/
                                     text-align: center;font-size: 12px;font-family:'bookos', sans-serif;
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
            } else {
                $pdf_render = $pdf->loadHTML(View::make('penetapannominatif::sk_tte', [
                    'nip' => $this->kgb->nip,
                    'idkgb' => $this->kgb->idkgb,
                    'jnskgb' => $this->kgb->jnskgb
                ])->render())->stream();

                //                 $pdf_render = $pdf
                //                     ->loadHTML(
                //                     View::make('penetapannominatif::sk_tte',[
                //                         'nip' => $this->kgb->nip,
                //                         'idkgb' => $this->kgb->idkgb,
                //                         'jnskgb' => $this->kgb->jnskgb
                //                     ])->render()
                //                 )->output();
            }

            $filename = $this->kgb->nip . '_' . $this->kgb->idkgb . '_' . $this->kgb->jnskgb . '_' . rand(100, 999) . '.pdf';
            $file_path = '/kgb/draft/' . $filename;

            if (Storage::disk('local')->has($file_path) && $filename != '') {
                // Storage::disk('packages')->delete($file_path);
                unlink(storage_path('app' . $file_path));
            }

            if (Storage::disk('local')->put($file_path, $pdf_render)) {
                if (Storage::disk('local')->has('/kgb/draft/' . $this->kgb->surat) && $this->kgb->surat != '') {
                    unlink(storage_path('app/kgb/draft/' . $this->kgb->surat));
                }

                $kgb = KGB::where('idkgb', $this->kgb->idkgb)
                    ->where('nip', '=', $this->kgb->nip)
                    ->update(['surat' => 'kgb/draft/' . $filename]);

                return $kgb;
            }
        }

        return 0;
    }


    // public static function OldgenerateSK($nip, $idkgb, $jnskgb)
    // {
    //     $pdf = PDF::loadHTML(View::make('penetapannominatif::sk_tte',[
    //         'nip' => $nip,
    //         'idkgb' => $idkgb,
    //         'jnskgb' => $jnskgb
    //     ]))->setPaper('legal', 'potrait');

    //     $output = $pdf->stream();
    //     $filename = $nip.'_'.$idkgb.'_'.$jnskgb.'_'.rand(100,999).'.pdf';
    //     $file_path = '/kgb/'.$filename;

    //     if (Storage::disk('local')->has($file_path)) {
    //         // Storage::disk('packages')->delete($file_path);
    //         unlink(storage_path('app'.$file_path));
    //     }

    //     if (Storage::disk('local')->put($file_path, $output)) {
    //         $tte = TTE::where('nip_pengusul',$nip)->where('id_sk',$idkgb)->first();

    //         if (empty($tte)) {
    //             $tte = new TTE();
    //             $tte->jenis = "KGB";
    //             $tte->id_sk = $idkgb;
    //             $tte->nip_pengusul = $nip;
    //             $tte->user_id = \Session::get('user_id');
    //             $tte->role_id = \Session::get('role_id');
    //             $tte->created_at = sekarang();
    //             $tte->file_awal = $nip.'_'.$idkgb.'_'.$jnskgb.'.pdf';
    //             $tte->save();
    //         }
    //         return true;
    //     }

    //     return 0;
    // }
}
