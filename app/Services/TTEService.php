<?php

namespace App\Services;

use App\Repositories\BsreApiRepository;
use App\Models\Riwayat\TTE;
use Storage;
use Illuminate\Http\File;

class TTEService
{
    protected $tte;
    protected $passphrase;

    public function __construct(TTE $tte)
    {
        $this->tte = $tte;
    }

    public function sign($passphrase)
    {
        $this->passphrase = $passphrase;
        if ($this->tte->proses != '1') {
            $bsre = new BsreApiRepository();

            //iscetaksk=1 sebbelum sign aar masuk riwayat rkg
            \DB::table('tr_kgb')->where('idkgb', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 1));

            $sign_result = $bsre->signDocument($this->getFormData(), $this->tte->id);
            // // dd($this->tte->id); die();

            if ($sign_result['code'] == "200") {
                $this->tte->id_tte = $sign_result["data"]["id_dokumen"];
                $this->tte->proses = 1;
                $this->tte->updated_at = date("Y-m-d H:i:s");

                if ($this->tte->save()) {
                    //nambah file ke efile.method move
                    if ($this->downloadDokumen() != 1) {
                        $sign_result['code'] = "500";
                        $sign_result['message'] = "Gagal download dokumen.";
                        //ambil nip $this->tte->nip_pengusul
                        $sign_result['nip'] = '$this->tte->nip_pengusul';
                    } else {
                        //pindah file ke folder efile
                        $file_asal = './storage/app/' . $this->tte->file_tte;
                        $file_tujuan = './efile/packages/upload/files/' . substr($this->tte->nip_pengusul, 0, 4) . '/' . $this->tte->nip_pengusul . '/' . substr($this->tte->file_tte, 9);
                        //echo $file_tujuan; exit();
                        rename($file_asal, $file_tujuan);
                    }
                } else {
                    //batalkan iscetaksk jika gagal sign
                    \DB::table('tr_kgb')->where('idkgb', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 0));
                    $sign_result['code'] = "500";
                    $sign_result['message'] = "Gagal menyimpan respon.";
                }
            }

            return $sign_result;
        }

        $sign_result['code'] = "200";
        $sign_result['message'] = "Dokumen Sudah ditandatangani.";

        return $sign_result;
    }

    public function signPppk($passphrase)
    {
        $this->passphrase = $passphrase;
        if ($this->tte->proses != '1') {
            $bsre = new BsreApiRepository();

            //iscetaksk=1 sebbelum sign agar masuk riwayat pppk
            \DB::table('tr_pppk')->where('idpppk', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 1));

            $sign_result = $bsre->signDocument($this->getFormDatapppk(), $this->tte->id);
            // // dd($this->tte->id); die();

            if ($sign_result['code'] == "200") {
                $this->tte->id_tte = $sign_result["data"]["id_dokumen"];
                $this->tte->proses = 1;
                $this->tte->updated_at = date("Y-m-d H:i:s");

                if ($this->tte->save()) {
                    //nambah file ke efile.method move
                    if ($this->downloadDokumen() != 1) {
                        $sign_result['code'] = "500";
                        $sign_result['message'] = "Gagal download dokumen.";
                        //ambil nip $this->tte->nip_pengusul
                        $sign_result['nip'] = '$this->tte->nip_pengusul';
                    } else {
                        //pindah file ke folder efile
                        $file_asal = './storage/app/' . $this->tte->file_tte;
                        $file_tujuan = './efile/packages/upload/files/' . substr($this->tte->nip_pengusul, 0, 4) . '/' . $this->tte->nip_pengusul . '/' . substr($this->tte->file_tte, 10);
                        //echo $file_tujuan; exit();
                        rename($file_asal, $file_tujuan);
                    }
                } else {
                    //batalkan iscetaksk jika gagal sign
                    \DB::table('tr_pppk')->where('idpppk', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 0));
                    $sign_result['code'] = "500";
                    $sign_result['message'] = "Gagal menyimpan respon.";
                }
            }

            return $sign_result;
        }

        $sign_result['code'] = "200";
        $sign_result['message'] = "Dokumen Sudah ditandatangani.";

        return $sign_result;
    }

    public function signPppkpw($passphrase)
    {
        $this->passphrase = $passphrase;
        if ($this->tte->proses != '1') {
            // return $passphrase;
            $bsre = new BsreApiRepository();

            //iscetaksk=1 sebbelum sign agar masuk riwayat pppk
            \DB::table('tr_pppkpw')->where('idpppk', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 1));

            $sign_result = $bsre->signDocument($this->getFormDatapppkpw(), $this->tte->id);
            // dd($this->tte->id); die();

            if ($sign_result['code'] == "200") {
                $this->tte->id_tte = $sign_result["data"]["id_dokumen"];
                $this->tte->proses = 1;
                $this->tte->updated_at = date("Y-m-d H:i:s");

                if ($this->tte->save()) {
                    //nambah file ke efile.method move
                    $bsre = new BsreApiRepository();
                    $path = str_replace('draft/', 'sign/', $this->tte->file_awal); //filenya pindah ke efile efile/packages/upload/files/1983/198305152011011014

                    $response = $bsre->downlodSignDocument($this->tte->id_tte, storage_path("app/" . $path));
                    if ($response['code'] === '200') {
                        $this->tte->file_tte = $path;
                        $this->tte->save();
                        //pindah file ke folder efile
                        $file_asal = './storage/app/' . $this->tte->file_tte;
                        $file_tujuan = './efile/packages/upload/files/' . substr($this->tte->nip_pengusul, 0, 4) . '/' . $this->tte->nip_pengusul . '/' . substr($this->tte->file_tte, 12);
                        //echo $file_tujuan; exit();
                        rename($file_asal, $file_tujuan);
                    } else {
                        $sign_result['code'] = "500";
                        $sign_result['message'] = "Gagal download dokumen.";
                        //ambil nip $this->tte->nip_pengusul
                        $sign_result['nip'] = '$this->tte->nip_pengusul';
                    }

                    // if ($this->downloadDokumen() != 1) {
                    //     $sign_result['code'] = "500";
                    //     $sign_result['message'] = "Gagal download dokumen.";
                    //     //ambil nip $this->tte->nip_pengusul
                    //     $sign_result['nip'] = '$this->tte->nip_pengusul';
                    // }else{
                    //     //pindah file ke folder efile
                    //     $file_asal='./storage/app/'.$this->tte->file_tte;
                    //     $file_tujuan='./efile/packages/upload/files/'.substr($this->tte->nip_pengusul,0,4).'/'.$this->tte->nip_pengusul.'/'.substr($this->tte->file_tte,10);
                    //     //echo $file_tujuan; exit();
                    //     rename($file_asal, $file_tujuan);
                    // }

                } else {
                    //batalkan iscetaksk jika gagal sign
                    \DB::table('tr_pppkpw')->where('idpppk', $this->tte->id_sk)->where('nip', $this->tte->nip_pengusul)->update(array('iscetaksk' => 0));
                    $sign_result['code'] = "500";
                    $sign_result['message'] = "Gagal menyimpan respon.";
                }
            }

            return $sign_result;
        }

        $sign_result['code'] = "200";
        $sign_result['message'] = "Dokumen Sudah ditandatangani.";

        return $sign_result;
    }

    public function getFormData()
    {
        return [
            [
                'name'     => 'file',
                'contents' => fopen(base_path('storage/app/' . $this->tte->file_awal), 'r')
            ],
            // [
            //     'name'     => 'imageTTD',
            //     'contents' => fopen(base_path('packages/tte/logo.png'),'r')
            // ],
            [
                'name'     => 'nik',
                'contents' => $this->tte->nik_pejabat
            ],
            [
                'name'     => 'passphrase',
                'contents' => $this->passphrase
            ],
            [
                'name'     => 'tampilan',
                'contents' => 'visible'
            ],

            [
                'name'     => 'image',
                'contents' => 'false', //'true'
            ],

            [
                'name'     => 'width',
                'contents' => '200'
            ],
            [
                'name'     => 'height',
                'contents' => '100'
            ],
            [
                'name'     => 'tag_koordinat',
                'contents' => '#'
            ],
            [
                'name'     => 'xAxis',
                'contents' => '0'
            ],
            [
                'name'     => 'yAxis',
                'contents' => '0'
            ],
            [
                'name' => 'linkQR',
                'contents' => url('') . '/digitalsign/' . $this->tte->nip_pengusul . '/' . $this->tte->id_sk
            ]
        ];
    }

    public function getFormDatapppk()
    {
        return [
            [
                'name'     => 'file',
                'contents' => fopen(base_path('storage/app/' . $this->tte->file_awal), 'r')
            ],
            // [
            //     'name'     => 'imageTTD',
            //     'contents' => fopen(base_path('packages/tte/logo.png'),'r')
            // ],
            [
                'name'     => 'nik',
                'contents' => $this->tte->nik_pejabat
            ],
            [
                'name'     => 'passphrase',
                'contents' => $this->passphrase
            ],
            [
                'name'     => 'tampilan',
                'contents' => 'visible'
            ],

            [
                'name'     => 'image',
                'contents' => 'false', //'true'
            ],

            [
                'name'     => 'width',
                'contents' => '200'
            ],
            [
                'name'     => 'height',
                'contents' => '100'
            ],
            [
                'name'     => 'tag_koordinat',
                'contents' => '#'
            ],
            [
                'name'     => 'xAxis',
                'contents' => '0'
            ],
            [
                'name'     => 'yAxis',
                'contents' => '0'
            ],
            [
                'name' => 'linkQR',
                'contents' => url('') . '/digitalsign/pppk/' . $this->tte->nip_pengusul . '/' . $this->tte->id_sk
            ]
        ];
    }
    public function getFormDatapppkpw()
    {
        return [
            [
                'name'     => 'file',
                'contents' => fopen(base_path('storage/app/' . $this->tte->file_awal), 'r')
            ],
            // [
            //     'name'     => 'imageTTD',
            //     'contents' => fopen(base_path('packages/tte/logo.png'),'r')
            // ],
            [
                'name'     => 'nik',
                'contents' => $this->tte->nik_pejabat
            ],
            [
                'name'     => 'passphrase',
                'contents' => $this->passphrase
            ],
            [
                'name'     => 'tampilan',
                'contents' => 'visible'
            ],

            [
                'name'     => 'image',
                'contents' => 'false', //'true'
            ],

            [
                'name'     => 'width',
                'contents' => '200'
            ],
            [
                'name'     => 'height',
                'contents' => '100'
            ],
            [
                'name'     => 'tag_koordinat',
                'contents' => '#'
            ],
            [
                'name'     => 'xAxis',
                'contents' => '0'
            ],
            [
                'name'     => 'yAxis',
                'contents' => '0'
            ],
            [
                'name' => 'linkQR',
                'contents' => url('') . '/digitalsign/pppkpw/' . $this->tte->nip_pengusul . '/' . $this->tte->id_sk
            ]
        ];
    }

    public function downloadDokumen()
    {
        $bsre = new BsreApiRepository();
        $path = str_replace('draft/', 'sign/', $this->tte->file_awal); //filenya pindah ke efile efile/packages/upload/files/1983/198305152011011014

        $response = $bsre->downlodSignDocument($this->tte->id_tte, storage_path("app/" . $path));
        if ($response['code'] === '200') {
            $this->tte->file_tte = $path;
            return $this->tte->save() ? 1 : 0; //buat apa?
        }

        return 0;
    }


    //ga jd pake ini
    public function pindahEfile()
    {
        $file_asal = base_path('storage/app/' . $this->tte->file_tte);
        $file_tujuan = base_path('efile/packages/upload/files/' . substr($this->tte->nip_pengusul, 0, 4) . '/' . $this->tte->nip_pengusul . '/' . $this->tte->file_tte);
        // dd($file_asal); die();
        if (Storage::move($file_asal, $file_tujuan)) {
            return 'File berhasil dipindah';
        } else {
            return 'File gagal dipindah';
        }
    }

    public function getTest()
    {
        $file_asal = './storage/app/kgb/sign/197211052006042020_202308.54.05.01_2_920.pdf';
        $file_tujuan = './efile/packages/upload/files/1972/197211052006042020/197211052006042020_202308.54.05.01_2_920.pdf';
        rename($file_asal, $file_tujuan);
    }
}
