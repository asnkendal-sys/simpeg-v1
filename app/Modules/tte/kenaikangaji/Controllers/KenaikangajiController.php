<?php

namespace App\Modules\tte\kenaikangaji\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Riwayat\TTE;
use App\Modules\tte\kenaikangaji\Models\KenaikangajiModel;
use Input, View, Request, Form, File, Auth;

use App\Services\DigitalSignatureService;

class KenaikangajiController extends Controller
{
    protected $kenaikangaji;

    public function __construct(TTE $kenaikangaji)
    {
        $this->kenaikangaji = $kenaikangaji;
    }

    public function getIndex()
    {
        cekAjax();
        $jenis = 'KGB';
        $where = "a.jnskgb = 2 and r_tte.jenis = \"" . $jenis . "\"";

        if (session('role_id') > 3) {
            $where .= ' and nip_pejabat =' . \Session::get('user_id');
        }

        if (Input::has('search') or Input::get('status_tte') != '' or Input::get('idgolru') != '' or Input::get('idstspeg') != '') {
            if (strlen(Input::has('search')) > 0) {
                $where .= " and (a.nip like '%" . Input::get('search') . "%' or a.nama like '%" . Input::get('search') . "%')";
            }

            if (Input::get('status_tte') != '') {
                $where .= ' and proses =' . Input::get('status_tte');
            }

            if (Input::get('idgolru') != '') {
                $where .= ' and a.golpnsskr =' . Input::get('idgolru');
            }

            if (Input::get('idstspeg') != '') {
                $where .= ' and a.idstspeg =' . Input::get('idstspeg');
            }

            $ttes = \DB::table('r_tte')
                ->select(
                    'a.*',
                    'r_tte.*',
                    \DB::raw("b.pangkat as golpnsskr_txt, b.golru_p3k as golru_p3k, c.golru as golpns_txt, d.jabatan as pejpenkgbl_txt"),
                    \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_"),
                    \DB::raw("DATE_FORMAT(a.tgllahir,'%d-%m-%Y') AS tgllahir_"),
                    \DB::raw("DATE_FORMAT(a.tmtgollama,'%d-%m-%Y') AS tmtgollama_"),
                    \DB::raw("DATE_FORMAT(a.tmteselon,'%d-%m-%Y') AS tmteselon_"),
                    \DB::raw("DATE_FORMAT(a.tmtjbt,'%d-%m-%Y') AS tmtjbt_"),
                    \DB::raw("DATE_FORMAT(a.tglskkgbl,'%d-%m-%Y') AS tglskkgbl_"),
                    \DB::raw("DATE_FORMAT(a.tmtkgbl,'%d-%m-%Y') AS tmtkgbl_"),
                    \DB::raw("DATE_FORMAT(a.tmtkgbb,'%d-%m-%Y') AS tmtkgbb_")
                )
                ->join('tr_kgb as a', function ($join) use ($jenis) {
                    $join->on('r_tte.id_sk', '=', 'a.idkgb')
                        ->on('r_tte.nip_pengusul', '=', 'a.nip')
                        ->where('r_tte.jenis', '=', $jenis);
                })
                ->leftJoin('a_golruang as b', 'a.golpns', '=', 'b.idgolru')
                ->leftJoin('a_golruang as c', 'a.golpnsskr', '=', 'c.idgolru')
                ->leftJoin('a_penetapsk as d', 'a.pejpenkgbl', '=', 'd.id')
                ->whereRaw($where)
                ->orderBy(\DB::raw('a.idkgb desc,a.idjabskr,a.golpnsskr,a.nama'))
                ->paginate($_ENV['configurations']['list-limit']);
        } else {
            $ttes = KenaikangajiModel::all();
        }

        return View::make('kenaikangaji::index', compact('ttes'));
    }


    public function getCreate()
    {
        cekAjax();
        return View::make('kenaikangaji::create');
    }

    public function postCreate()
    {
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KenaikangajiModel::$rules);
        if ($validation->passes()) {
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->kenaikangaji->create($input)) ? 1 : "Gagal Disimpan";
        } else {
            echo 'Input tidak valid';
        }
    }



    public function getPandu(DigitalSignatureService $srv)
    {
        // DS
        $form_data = $this->getFormData();
        // $srv = new DigitalSignatureService();
        $handleSign = $srv->handle($form_data);
        dd($handleSign);

        // End DS

        // $input[0];
        // $ds  = DigitalSignatureService::handle($form_data)
        // Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) 

        // // return View::make('penetapannominatif::sk_pandu');
        // $pdf = PDF::loadview('penetapannominatif::sk_pandu');
        // return $pdf->stream();
        // $output = $pdf->stream();

        // if (Storage::disk('packages')->put('/pdf/kgb/Brochure.pdf', $output)) {
        //     return "berhasil";
        // }else{
        //     return "gagal";
        // }
    }

    public function postTandatangan(DigitalSignatureService $srv)
    {
        cekAjax();

        $form_data = [
            [
                'name'     => 'file',
                'contents' => fopen(base_path('packages/pdf/kgb/198302192014061003_202401.04.05.02.17.3_1.pdf'), 'r')
            ],
            [
                'name'     => 'imageTTD',
                'contents' => fopen(base_path('packages/tte/logo.png'), 'r')
            ],
            [
                'name'     => 'passphrase',
                'contents' => '!Bsre1221*'
            ],
            [
                'name'     => 'nik',
                'contents' => '0803202100007062'
            ],
            [
                'name'     => 'tampilan',
                'contents' => 'visible'
            ],

            [
                'name'     => 'image',
                'contents' => 'true'
            ],

            [
                'name'     => 'width',
                'contents' => '100'
            ],
            [
                'name'     => 'height',
                'contents' => '50'
            ],
            [
                'name'     => 'tag_koordinat',
                'contents' => '#'
            ],
        ];

        // $srv = new DigitalSignatureService();
        $handleSign = $srv->handle($form_data);
        dd($handleSign);
    }

    public function postPrevall()
    {
        // cekAjax();
        // $ids = Input::get('id');
        // if (is_array($ids)){
        //     foreach($ids as $id){
        // //         $this->mastergaji->find($id)->delete();
        // echo $id;
        //     }
        // //     echo 'Data berhasil dihapus';
        // }
        // // else{
        // //     echo ($this->mastergaji->find($ids)->delete())?9:'Gagal Dihapus';
        // // }
        echo "tes";
    }

    public function postData()
    {
        //$data['nip']  = Input::get('nip');
        $view = Request::segment(4);
        return View::make('kenaikangaji::' . $view . '_data', $data);
    }

    /*function view Modal atribut dari link */
    // function postModal(){
    //     cekAjax();
    //     // $view = Request::segment(4);
    //     $view = \Input::get('view');
    //     return View::make('kenaikangaji::'.$view.'_modal');
    // }

    /* Function untuk menampilkan modal atribut surat pengantar*/
    public function getModalpreviewkgb()
    {
        cekAjax();
        $data = Input::get('data');

        $previews = TTE::whereIn('id', $data)->get();

        return View::make('kenaikangaji::previewkgb_modal', compact('data', 'previews'));
    }

    public function previewFile($filename)
    {
        $path = storage_path('app/kgb/draft/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function postPreviewsktte()
    {
        cekAjax();
        return View::make('kenaikangaji::preview_sk_modal');
    }
}
