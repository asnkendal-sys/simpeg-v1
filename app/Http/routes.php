<?php

use App\Modules\settings\configurations\Models\ConfigurationsModel;
use App\Modules\settings\permissionsmatrix\Models\PermissionsmatrixModel;
use App\Services\KpoService;
use App\Services\DataUtamaBknService;
use App\Services\RiwayatDiklatService;
use App\Repositories\IApiBknRepository;
use App\Repositories\DiklatRepository;
use App\Repositories\JabatanRepository;
use App\Repositories\DataUtamaRepository;
use App\Repositories\SkpRepository;
use App\Services\SkpService;
use App\Services\JabatanService;
use App\Models\CutiKuota;
use App\Models\Riwayat\TTE;
use App\Services\TTEService;
//use \Session, \Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

// Route::get('/pandu', "\App\Modules\kenaikangajiberkala\penetapannominatif\Controllers\PenetapannominatifController@pandu");

// Route::get('/pandu', function ()
// {
//     $tte = TTE::find(2);

//     $s_tte = new TTEService($tte);
//     dd($s_tte->downloadDokumen());
//     dd($s_tte->sign("Bsr3mantap.,!"));
//     $form_data = collect($s_tte->getFormData());
// });



Route::get('/test-kpo', function () {
    $repo = new \App\Repositories\KpoRepository;
    $srv = new \App\Services\KpoService($repo);
    dd($srv->fetch()->get());
});

Route::get('/test-kpo', function () {
    $repo = new \App\Repositories\KpoRepository;
    $srv = new \App\Services\KpoService($repo);
    dd($srv->fetch()->get());
});

Route::get('/test-kpo-hist/{tgl_awal}/{tgl_akhir}', function ($tglAwal, $tglAkhir) {
    $repo = new \App\Repositories\KpoRepository;
    $srv = new \App\Services\KpoService($repo);
    dd($srv->fetchHistory($tglAwal, $tglAkhir)->get());
});


Route::get('/test-ppo', function () {
    $repo = new \App\Repositories\PpoRepository;
    $srv = new \App\Services\PpoService($repo);
    dd($srv->fetch()->get());
});

Route::get('/test-ppo-hist/{tgl_awal}/{tgl_akhir}', function ($tglAwal, $tglAkhir) {
    $repo = new \App\Repositories\PpoRepository;
    $srv = new \App\Services\PpoService($repo);
    dd($srv->fetchHistory($tglAwal, $tglAkhir)->get());
});

Route::get('/hemove12345', function () {

    $nip1 = '198211272014032001';
    $file_asal1 = './storage/app/kgb/sign/198211272014032001_202603.05.02_2_635.pdf';
    $file_tujuan1 = './efile/packages/upload/files/' . substr($nip1, 0, 4) . '/' . $nip1 . '/198211272014032001_202603.05.02_2_635.pdf';
    rename($file_asal1, $file_tujuan1);

    $nip2 = '199303012024212011';
    $file_asal2 = './storage/app/kgb/sign/199303012024212011_202603.05.29_2_984.pdf';
    $file_tujuan2 = './efile/packages/upload/files/' . substr($nip2, 0, 4) . '/' . $nip2 . '/199303012024212011_202603.05.29_2_984.pdf';
    rename($file_asal2, $file_tujuan2);

    $nip3 = '198201132006042009';
    $file_asal3 = './storage/app/kgb/sign/198201132006042009_202604.09.03_2_635.pdf';
    $file_tujuan3 = './efile/packages/upload/files/' . substr($nip3, 0, 4) . '/' . $nip3 . '/198201132006042009_202604.09.03_2_635.pdf';
    rename($file_asal3, $file_tujuan3);
});

Route::get('/test-send', function () {
    $skp = new SkpRepository;
    $data = array(
        'id' => '8ae486447aae43ef017c4bbfb4ff02b1',
        'tahun' => 2021,
        'nilaiSkp' => 99.88,
        'orientasiPelayanan' => 86.22,
        'integritas' => 88.23,
        'komitmen' => 90.45,
        'disiplin' => 77.65,
        'kerjasama' => 98.33,
        'nilaiPerilakuKerja' => 80.66,
        'nilaiPrestasiKerja' => 76.45,
        'kepemimpinan' => 80.34,
        'jumlah' => 80.66,
        'nilairatarata' => 87.33,
        'atasanPejabatPenilai' => '',
        'pejabatPenilai' => '',
        'pnsDinilaiOrang' => 'A8ACA7B755C43912E040640A040269BB',
        'penilaiNipNrp' => '',
        'atasanPenilaiNipNrp' => '',
        'penilaiNama' => '',
        'atasanPenilaiNama' => '',
        'penilaiUnorNama' => '',
        'atasanPenilaiUnorNama' => '',
        'penilaiJabatan' => '',
        'atasanPenilaiJabatan' => '',
        'penilaiGolongan' => '',
        'atasanPenilaiGolongan' => '',
        'penilaiTmtGolongan' => '',
        'atasanPenilaiTmtGolongan' => '',
        'statusPenilai' => 'PNS',
        'statusAtasanPenilai' => 'PNS',
        'jenisJabatan' => '2',
        'pnsUserId' => 'A8ACA7B755C43912E040640A040269BB'
    );
    dd($skp->apiPath('/api/skp/save')->store($data));
});

Route::get('/', function () {
    //mainkan Portal Disini
    if (session('role_id') != '') {
        return redirect('/dashboard');
    } else {
        //return view('home::login.index-login');
        /*Perbaikan*/
        //return view('home::index_perbaikan');

        /*Asli*/

        // candra
        // Membuat dua angka acak untuk operasi matematika
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);

        // Memilih operator acak (penjumlahan atau pengurangan)
        $operator = rand(0, 1) == 0 ? '+' : '-';

        // Menyusun soal matematika
        $captchaQuestion = "$num1 $operator $num2";

        // Menyimpan jawaban yang benar di sesi
        $captchaAnswer = $operator == '+' ? $num1 + $num2 : $num1 - $num2;
        Session::put('captcha_answer', $captchaAnswer);

        // Membuat pilihan acak angka
        $choices = [];
        for ($i = 0; $i < 4; $i++) {
            $choices[] = rand(1, 20);  // Membuat angka acak untuk pilihan
        }

        // Memastikan jawaban ada di antara pilihan
        $choices[array_rand($choices)] = $captchaAnswer;

        // Mengacak pilihan
        shuffle($choices);
        // candra end
        return view('home::login.index', compact('captchaQuestion', 'choices'));
    }
});
Route::get('/test-api/{nip}', function ($nip) {
    // $value = new IApiBknRepository;
    // $s = new DataUtamaBknService($value);
    $module = App::make("App\Repositories\IApiBknRepository");
    $s = new DataUtamaBknService($module);
    $sr = $s->fetchDataUtama($nip);
    if ($sr[code]  == 200) {
        return response()->json(["jos"]);
    }
});
Route::get('/test-api2/{nip}', "ApibknController@index");

Route::get('/tracking', function () {
    /*return view('home::portal.index');*/
    return redirect('/dashboard');
});
/*MREZA 16DES19 Penyatuan Route Digital Sign*/
Route::get('digitalsigns/{apl?}/{nip?}/{id?}', function ($apl = '', $nip = '', $id = '') {
    if ($apl == 'ecuti') {
        return View::make("home::portal.digitalsigecuti", array('nip' => $nip, 'nousul' => $id));
    } else {
        /*return view('home::portal.index');*/
        return redirect('/dashboard');
    }
});

Route::get('digitalsign/{nip?}/{idkgb?}', function ($nip = '', $idkgb = '') {
    if (($nip != '') and ($idkgb != '')) {
        return View::make("home::portal.digitalsign", array('nip' => $nip, 'idkgb' => $idkgb));
    } else {
        /*return view('home::portal.index');*/
        return redirect('/dashboard');
    }
});

Route::get('digitalsign/pppk/{nip?}/{idpppk?}', function ($nip = '', $idpppk = '') {
    if (($nip != '') and ($idpppk != '')) {
        return View::make("home::portal.digitalsign_pppk", array('nip' => $nip, 'idpppk' => $idpppk));
    } else {
        /*return view('home::portal.index');*/
        return redirect('/dashboard');
    }
});

Route::get('digitalsign/pppkpw/{nip?}/{idpppk?}', function ($nip = '', $idpppk = '') {
    if (($nip != '') and ($idpppk != '')) {
        return View::make("home::portal.digitalsign_pppkpw", array('nip' => $nip, 'idpppk' => $idpppk));
    } else {
        /*return view('home::portal.index');*/
        return redirect('/dashboard');
    }
});

Route::get('digitalsignature/{module?}/{submodule?}/{jenis?}/{nousul?}/{nip?}', function ($module = '', $submodule = '', $jenis = '', $nousul = '', $nip = '') {
    if (($module != '') and ($submodule != '') and ($jenis != '') and ($nousul != '')) {
        return View::make("home::portal.digitalsignature", array('module' => $module, 'submodule' => $submodule, 'jenis' => $jenis, 'nousul' => $nousul, 'nip' => $nip));
    } else {
        /*return view('home::portal.index');*/
        return redirect('/dashboard');
    }
});

Route::get('dsign/{surat}/{id}', 'App\Modules\pppk\templateskpppk\Controllers\TemplateskpppkController@getDs');
Route::group(['middleware' => 'auth'], function () {
    /*Route::get('/api', 'ApiController@getIndex');*/
    Route::get('api/{content?}/{subcontent?}/{offset?}/{limit?}', function ($content = "", $subcontent = "", $limit = "0", $offset = "0") {
        if ($content == 'pegawai') {
            return view('home::api.pegawai', array('content' => $content, 'subcontent' => $subcontent, 'offset' => $offset, 'limit' => $limit));
        } elseif ($content == 'pensiun') {
            return view('home::api.pensiun', array('content' => $content, 'subcontent' => $subcontent, 'offset' => $offset, 'limit' => $limit));
        } elseif ($content == 'pegawaidetail') {
            return view('home::api.pegawaidetail', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'unitkerja') {
            return view('home::api.unker', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'eselon') {
            return view('home::api.eselon', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'golongan') {
            return view('home::api.golongan', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'jabstruk') {
            return view('home::api.jabstruk', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'fungsional') {
            return view('home::api.fungsional', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'pelaksana') {
            return view('home::api.pelaksana', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'pgwapi') {
            return view('home::api.pegawaiapi', array('content' => $content, 'subcontent' => $subcontent, 'offset' => $offset, 'limit' => $limit));
        } elseif ($content == 'pgwapidetail') {
            return view('home::api.pegawaidetailapi', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'pegawaihukdis') {
            return view('home::api.pegawaihukdis', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'pegawaipenghargaan') {
            return view('home::api.pegawaipenghargaan', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'pegawaidiklat') {
            return view('home::api.pegawaidiklat', array('content' => $content, 'subcontent' => $subcontent));
        } elseif ($content == 'abk') {
            return view('home::api.abk', array('content' => $content, 'subcontent' => $subcontent));
        } else {
            /*return Redirect::to('/api');*/
            return Redirect::to('/');
        }
    });
});


Route::get('sotk/{idskpd?}', function ($idskpd = "") {
    if ($idskpd != '') {
        return view('home::portal.sotkview', array('idskpd' => $idskpd));
    } else {
        return Redirect::to('/');
    }
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/login', function () {
        // candra
        // Membuat dua angka acak untuk operasi matematika
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);

        // Memilih operator acak (penjumlahan atau pengurangan)
        $operator = rand(0, 1) == 0 ? '+' : '-';

        // Menyusun soal matematika
        $captchaQuestion = "$num1 $operator $num2";

        // Menyimpan jawaban yang benar di sesi
        $captchaAnswer = $operator == '+' ? $num1 + $num2 : $num1 - $num2;
        Session::put('captcha_answer', $captchaAnswer);

        // Membuat pilihan acak angka
        $choices = [];
        for ($i = 0; $i < 4; $i++) {
            $choices[] = rand(1, 20);  // Membuat angka acak untuk pilihan
        }

        // Memastikan jawaban ada di antara pilihan
        $choices[array_rand($choices)] = $captchaAnswer;

        // Mengacak pilihan
        shuffle($choices);
        // candra end
        return view('home::login.index', compact('captchaQuestion', 'choices'));
    });

    Route::get('/login-admin', function () {
        return view('home::login.index');
    });

    Route::post('/login', array('as' => 'dologin', 'uses' => 'AuthController@postLogin'));
    Route::post('/loginsie', array('as' => 'dologin', 'uses' => 'AuthController@postLoginsie'));

    Route::get('/loginfefile', array('as' => 'dologin', 'uses' => 'AuthController@getLoginfefile'));

    Route::get('/login-pegawai', function () {
        return view('home::login.index');
    });

    Route::get('/login-eksekutif', function () {
        return view('home::login.index-eksekutif');
    });
    Route::post('/login-pegawai', array('as' => 'dologin', 'uses' => 'AuthController@postLoginpegawai'));
    /*login pegawai dari simpeg*/
    Route::get('/loginpegawai', array('as' => 'dologin', 'uses' => 'AuthController@getLoginpegawai2'));
});
Route::get('roger-sinkronsiasn/', function () {
    return View::make("home::sinkronisasi.index_sinkronisasi");
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/getnotifikasi', 'NotifikasiController@getIndex');
    Route::get('test_pdf', function () {
        $contents = view('home::dashboard.test_pdf');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    });
    Route::get('test_excel', function () {
        //        $contents = view('home::dashboard.test_pdf');
        //        $response = \Response::make($contents);
        //        $response->header('Content-Type', 'application/pdf');
        //        return $response;
        return view('home::dashboard.test_excel');
    });
    Route::get('/profil', array('as' => 'logout', 'uses' => 'AuthController@getProfil'));
    Route::post('/profil', array('as' => 'logout', 'uses' => 'AuthController@postProfil'));
    Route::get('/pass', array('as' => 'logout', 'uses' => 'AuthController@getPass'));
    Route::post('/pass', array('as' => 'logout', 'uses' => 'AuthController@postPass'));
    Route::post('/passpegawai', array('as' => 'logout', 'uses' => 'AuthController@postPasspegawai'));
    Route::get('/efileconfirm', array('as' => 'logout', 'uses' => 'AuthController@getEfileconfirm'));

    /*@RendyAmdani*/
    Route::get('/graphpns', array('as' => 'logout', 'uses' => 'AuthController@getGraphpns'));
    Route::get('/graphcpns', array('as' => 'logout', 'uses' => 'AuthController@getGraphcpns'));
    Route::get('/graphpppk', array('as' => 'logout', 'uses' => 'AuthController@getGraphpppk'));

    /*========= start of sinkron siasn ===========*/
    Route::get('/test', array('as' => 'test', 'uses' => 'SinkronisasiController@getIndex'));

    /*sinkronisasi siasn*/
    // Route::get('roger-sinkronsiasn/', function () {
    //     return View::make("home::sinkronisasi.index_sinkronisasi");
    // });

    /*function index dir siasn*/
    Route::get('roger-siasn/{view}/{nip}', function ($view, $nip) {
        return View::make('home::sinkronisasi.index_sinkronisasi_detail');
    });

    /*function view data sinkronsiasn*/
    Route::post('sinkronsiasn/{view}', function ($view) {
        $data['nip']  = Input::get('nip');
        return View::make('home::sinkronisasi.' . $view . '', $data);
    });

    /*function preview file*/
    Route::get('syncprevfile/{jenis}/{nip}/{idbkn}/{nama}', function ($jenis, $nip, $idbkn, $name) {
        $data['jenis']  = $jenis;
        $data['nip']  = $nip;
        $data['idbkn']  = $idbkn;
        $data['name']  = $name;
        return View::make('home::sinkronisasi.sinkronsiasn_file', $data);
    });

    Route::post('/syncrdikstrubkn', 'SinkronisasiController@postSyncrdikstrubkn');
    Route::post('/syncrdikstrusimpegsiasn', 'SinkronisasiController@postSyncrdikstrusimpegsiasn');
    Route::post('/syncrseminarbkn', 'SinkronisasiController@postSyncrseminarbkn');
    Route::post('/syncrseminarsimpegsiasn', 'SinkronisasiController@postSyncrseminarsimpegsiasn');
    Route::post('/syncrdikfungbkn', 'SinkronisasiController@postSyncrdikfungbkn');
    Route::post('/syncrdikfungsimpegsiasn', 'SinkronisasiController@postSyncrdikfungsimpegsiasn');
    Route::post('/syncrdiktekbkn', 'SinkronisasiController@postSyncrdiktekbkn');
    Route::post('/syncrdikteksimpegsiasn', 'SinkronisasiController@postSyncrdikteksimpegsiasn');
    Route::post('/syncrakreditbkn', 'SinkronisasiController@postSyncrakreditbkn');
    Route::post('/syncrakreditsimpegsiasn', 'SinkronisasiController@postSyncrakreditsimpegsiasn');
    Route::post('/syncrskp22bkn', 'SinkronisasiController@postSyncrskp22bkn');
    Route::post('/syncrskp22simpegsiasn', 'SinkronisasiController@postSyncrskp22simpegsiasn');
    Route::post('/syncrskpbkn', 'SinkronisasiController@postSyncrskpbkn');
    Route::post('/syncrskpsimpegsiasn', 'SinkronisasiController@postSyncrskpsimpegsiasn');
    /*========= end of sinkron siasn ===========*/
    Route::post('/ipasnpersonal', 'SinkronisasiController@postCipasn');
    Route::post('/ipasn', 'SinkronisasiController@postCipasnglobal');
    Route::post('/ipasnopd', 'SinkronisasiController@postIpasnopd');
    Route::get('/download/{filename}', 'SinkronisasiController@download')->name('file.download');
    Route::post('/cetakexcel', 'SinkronisasiController@postCexcelipasn');
    /* candra*/

    Route::get('/dashboard', function () {
        return view('home::dashboard.index');
    });

    Route::get('/login', function () {
        return redirect('/dashboard');
    });
    /*Route::get('/auth/login', function () {
        return redirect('/dashboard') ;
    });
    Route::get('/login-admin', function () {
        return redirect('/dashboard') ;
    });
    Route::get('/login-pegawai', function () {
        return redirect('/dashboard') ;
    });
    Route::get('/login-eksekutif', function () {
        return redirect('/dashboard') ;
    });
    Route::get('/', function () {
        return redirect('/dashboard') ;
    });*/
});

Route::get('/logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

Route::get('/testapi/diklat/{nip}', function ($nip = '') {
    $srv = new RiwayatDiklatService(new DiklatRepository);

    //dd($srv->fetch($nip));
    $bkn = $srv->fetch($nip);
    dd($bkn);
    return ($bkn);
});


Route::get('/testapi/diklatsave/{nip}', function ($nip = '') {
    $pegawai = App\Models\Pegawai::where('nip', '=', $nip)->first();
    $diklat_teknis = $pegawai->diklatTeknis->where('idsapk', '');
    foreach ($diklat_teknis as $key => $diktek) {
        $diklat = new DiklatRepository;
        $data = array(
            "id" => null,
            "jenisKursusId" => "",
            "instansiId" => "A5EB03E23C52F6A0E040640A040252AD",
            "pnsOrangId" => $pegawai->idsapk,
            "namaKursus" => $diktek->nmdiktek,
            "jumlahJam" => $diktek->jamhari,
            "tanggalKursus" => date('d-m-Y', strtotime($diktek->tgmul)),
            "tahun" => date(date('Y'), strtotime($diktek->tgsttpdiktek)),
            "institusiPenyelenggara" => $diktek->penyelenggara,
            "jenisKursusSertipikat" => "T",
            "nomorSertipikat" => $diktek->nosttpdiktek,
            "tanggalSelesaiKursus" => date('d-m-Y', strtotime($diktek->tgsel)),
            "lokasiId" => $diktek->tmdiktek,
            "pnsUserId" => $pegawai->idsapk
        );
        $ret = $diklat->apiPath('/api/kursus/save')->baseUrl(config('bkn.base_url_duplex_resource'))->store($data);
        $diktek->idsapk = @$ret['mapData']['rwKursusId'];
        $diktek->save();
    }
    // array:3 [▼
    //   "success" => true
    //   "message" => "success"
    //   "mapData" => array:1 [▼
    //     "rwKursusId" => "8ae486447f86758c017fd1e783d70271"
    //   ]
    // ]


    // $srv = new RiwayatDiklatService(new DiklatRepository);

    // $bkn = $srv->fetch($nip);
    // dd($bkn);
    // return($bkn);
});

Route::get('/webservices/storediklat/{nip}', function ($nip = '') {
    $h = new RiwayatDiklatService;
    dd($h->storeSapkByNIP($nip));
});

Route::get('/webservices/storediklatbyskpd/{idskpd}', function ($idskpd = '') {
    $pegawai = App\Models\Pegawai::select('nip')->where('idskpd', '=', $idskpd)->aktif()->get();
    foreach ($pegawai as $key => $peg) {
        $h = new RiwayatDiklatService;
        $a[$key] = $h->storeSapkByNIP($peg->nip);
    }
    dd($a);
});

Route::get('/webservices/storediklatall', function () {
    $h = new RiwayatDiklatService;
    $h->storeSapkAll();
});

// Route::get('/webservices/viewstorediklatall', function(){
//     return view('home::login.index');
// });

Route::get('/webservices/storediklatlikeskpd/{idskpd}', function ($idskpd = '') {
    $pegawai = App\Models\Pegawai::select('nip')->where('idskpd', 'like', $idskpd . "%")->aktif()->get();
    foreach ($pegawai as $key => $peg) {
        $h = new RiwayatDiklatService;
        $a[$key] = $h->storeSapkByNIP($peg->nip);
    }
    dd($a);
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/tte/kgb/sign', '\App\Http\Controllers\TTEController@sign');
    Route::post('/tte/kgb/sign_multiple', '\App\Http\Controllers\TTEController@signMultiple');

    Route::post('/tte/pppk/sign', '\App\Http\Controllers\TTEController@signPppk');
    Route::post('/tte/pppk/sign_multiple', '\App\Http\Controllers\TTEController@signPppkMultiple');

    //penamnbahan route untuk tte pppk pw agustus 2026
    Route::post('/tte/pppkpw/sign', '\App\Http\Controllers\TTEController@signPppkpw');
    Route::post('/tte/pppkpw/sign_multiple', '\App\Http\Controllers\TTEController@signPppkpwMultiple');
});

Route::get('/tte/kgb/file/{filename}', '\App\Modules\tte\kenaikangaji\Controllers\KenaikanGajiController@previewFile');
