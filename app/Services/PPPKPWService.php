<?php

namespace App\Services;

use App\Models\PPPKPW\UsulanPPPKPW as PPPK;
use App\Models\Riwayat\TTE;
use GuzzleHttp\Client;

use PDF, Storage, View;

class PPPKPWService
{
    protected $pppk;

    public function __construct(PPPK $pppk)
    {
        $this->pppk = $pppk;
    }

    public function ajukanTTE($berkas)
    {
        $tte = TTE::where('nip_pengusul', $this->pppk->nip)->where('id_sk', $this->pppk->idpppk)->where('jenis', $berkas)->first();
        /* deklarasi data baru setelah diupdate filenya */
        $tr_pppk = PPPK::where('nip', $this->pppk->nip)->where('idpppk', $this->pppk->idpppk)->first();

        if ($this->pppk->statussk == 1 && $tr_pppk->surat != "") { //$this->pppk->surat
            if ($tte === null) {
                $tte = new TTE();
                $tte->jenis = $berkas;
                $tte->id_sk = $this->pppk->idpppk;
                $tte->nip_pengusul = $this->pppk->nip;
            }

            $tte->nip_pejabat = $this->pppk->nipkepalabkd;
            switch ($berkas) {
                case 'PPPK':
                    $tte->nik_pejabat = $this->pppk->pejabatPenetap->noktp;
                    break;
                case 'PPPK-PEMBERHENTIAN':
                    $tte->nik_pejabat = getPenetapsk("005", "nik");
                    break;
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
        if ($this->pppk->statussk == 1) {
            $filename = $this->pppk->nip . '_' . $this->pppk->idpppk . '_' . $this->pppk->sts_kontrak . '_' . $this->pppk->idjenpens . '_' . rand(100, 999) . '.pdf';
            $file_path = '/pppkpw/draft/' . $filename;
            $client = new Client();

            $client->post('http://10.5.2.131:8000/api/render/petikanperpanjanganpppkpw', [
                'json' => [
                    'nosk' => $this->pppk->nosk,
                    'nama' => $this->pppk->nama,
                    'nip'  => $this->pppk->nip,
                    'tmlhr'  => $this->pppk->tmlhr,
                    'tglhr'  => formatTanggalPanjang($this->pppk->tglhr),
                    'jenkel'  => substr($this->pppk->nip, 14, 1) == '2' ? 'Wanita' : 'Pria',
                    'tkpendid'  => $this->pppk->jenjurusan,
                    'jabatan'  => $this->pppk->jab,
                    'unitkerja'  => $this->pppk->skpd,
                    'tmtawal'  => formatTanggalPanjang($this->pppk->tmtawal),
                    'tmtakhir'  => formatTanggalPanjang($this->pppk->tmtakhir),
                    'bupati'  => $this->pppk->bupati,
                    'tglsurat'  => formatTanggalPanjang($this->pppk->tgsk),
                    'jabatan_bkpp'  => $this->pppk->jabkepalabkd,
                    'namalengkap_bkpp'  => $this->pppk->kepalabkd,
                    'pangkat_bkpp'  => $this->pppk->pangkatbkd,
                    'nip_bkpp'  => $this->pppk->nipkepalabkd,
                    'no_urut'  => $this->pppk->no_urut,
                    'golongan'  => $this->pppk->golrul,
                    'gaji'  => number_format($this->pppk->gajib, 0, ',', '.'),
                    'masakerja' => $this->pppk->thkerja . " tahun " . $this->pppk->blkerja . " bulan ",

                ],
                'sink' => storage_path('app/pppkpw/draft/' . $filename),
            ]);

            $pppk = PPPK::where('idpppk', $this->pppk->idpppk)
                ->where('nip', '=', $this->pppk->nip)
                ->update(['surat' => 'pppkpw/draft/' . $filename]);

            return $pppk;
            // }
        }

        return 0;
    }
}
