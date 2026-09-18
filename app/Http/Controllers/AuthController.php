<?php

namespace App\Http\Controllers;

use View, Validator, Input, Session, Redirect, Auth;

class AuthController extends Controller
{

    public function getIndex()
    {
        return View::make("claravel::portal.index");
    }

    public function getTest()
    {
        die('Sukses Bro');
    }


    public function getPass()
    {
        cekAjax();
        if (session('role_id') == 5) {
            return View::make("home::dashboard.pass_pegawai");
        } else {
            return View::make("home::dashboard.pass");
        }
    }
    public function postPass()
    {
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        $a = \UsersModel::find($input['id']);
        $cek = \Hash::check($input['password'], $a->password);
        if (!$cek) {
            die('Password Lama Anda Salah');
        } else {
            if ($input['password_baru1'] === $input['password_baru2']) {
                if (!ctype_alnum($input['password_baru1'])) {
                    die('Hanya Boleh Huruf dan Angka');
                }
                $ubah = $a->update(array('password' => \Hash::make($input['password_baru1'])));
                echo ($ubah) ? 4 : 0;
            } else {
                die('Konfirmasi Password Tidak Cocok');
            }
        }
    }

    public function postPasspegawai()
    {
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        $cek = \DB::table('tb_01')->where('nip', $input['nip'])->where('password', md5($input['password']))->first();
        if (!$cek) {
            die('Password Lama Anda Salah');
        } else {
            if ($input['password_baru1'] === $input['password_baru2']) {
                if (!ctype_alnum($input['password_baru1'])) {
                    die('Hanya Boleh Huruf dan Angka');
                }
                $ubah = \DB::table('tb_01')->where('nip', $input['nip'])->update(array('password' => md5($input['password_baru1'])));
                echo ($ubah) ? 4 : 0;
            } else {
                die('Konfirmasi Password Tidak Cocok');
            }
        }
    }

    public function getEfileconfirm()
    {
        cekAjax();
        return View::make("home::dashboard.efileconfirm");
    }

    public function getProfil()
    {
        cekAjax();
        return View::make("home::dashboard.profil");
    }

    public function postProfil()
    {
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        if (Input::hasFile('foto')) {
            $destinationPath = base_path() . '/packages/upload/photo/' . \Session::get('user_id');
            $mode = 0777;
            $recursive = false;
            $f = Input::file('foto');
            if ((substr_count($f->getClientOriginalName(), '.') == 1) and (($f->getClientOriginalExtension() == 'jpg') or ($f->getClientOriginalExtension() == 'png'))) {
                //echo $f->getClientOriginalName()." vs ".$f->getClientOriginalExtension()." vs ".substr_count($f->getClientOriginalName(), '.'); exit();
                if ($f != '') {
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, $mode, $recursive);
                    }
                    //                die($destinationPath);
                    $tipefile = $f->getClientOriginalExtension();
                    $filename = str_replace(' ', '-', $f->getClientOriginalName());
                    $rs = \DB::table('users')->where('id', $input['id'])->first();
                    @unlink($destinationPath . '/' . $rs->foto);
                    $f->move($destinationPath, $filename);
                    $input['foto'] = $filename;
                }
            } else {
                echo "Ubah profil gagal. Format foto yang diijinkan hanya .jpg";
                exit();
            }
        } else {
        }
        $ubah = \UsersModel::find($input['id'])->update($input);
        echo ($ubah) ? 4 : 0;
    }



    public function postLogin()
    {

        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'captcha' => 'required|numeric',
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        //candra
        // Memeriksa apakah jawaban CAPTCHA sesuai dengan yang disimpan di sesi
        if (Input::get('captcha') == Session::get('captcha_answer')) {

            //candra end
            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);
            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                \Session::put('msgerr', 'Harap isi username dan password');
                return Redirect::to('/')
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
            } else {
                // create our user data for the authentication
                $userdata = array(
                    'username'     => Input::get('username'),
                    'password'     => Input::get('password')
                );

                // attempt to do the login
                if (Auth::attempt($userdata)) {
                    $role = \DB::table('roles')
                        ->where('id', '=', Auth::user()->role_id)
                        ->first()->name;

                    /*cek jadwal login ya brother*/
                    if (getJadwal(Auth::user()->role_id, Auth::user()->idskpd)) {

                        /*echo "OPSS.. Terjadi Kesalahan ".getJadwal(Auth::user()->role_id, Auth::user()->idskpd);
                                exit();*/

                        $rolesModel = \RolesModel::find(Auth::user()->role_id);
                        \Session::put('role_id', Auth::user()->role_id);
                        \Session::put('role', $role);
                        \Session::put('user_id', Auth::user()->id);
                        \Session::put('user_name', Auth::user()->username);
                        \Session::put('name', Auth::user()->name);
                        \Session::put('foto', Auth::user()->foto);
                        \Session::put('idskpd', Auth::user()->idskpd);
                        \Session::put('skpd', getSkpd(Auth::user()->idskpd));
                        \Session::put('_key', Input::get('password'));

                        $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                            $q->where('name', '=', 'site-login');
                        }))->where('role_id', \Session::get('role_id'))->get();

                        if ($pms->count() > 0) {
                            return Redirect::to('/' . $rolesModel->login_destination);
                            /*echo "<pre>";
                                        print_r(Session::all());
                                    echo "</pre>";
                                    echo "<br>".$rolesModel->login_destination;*/
                        } else {
                            Auth::logout();
                            \Session::flash('msgerr', 'You don\'t have permission to sign in into this applications.');
                            return Redirect::to('/login');
                        }
                    } else {
                        Session::flush();
                        \Session::put('msgerr', getKeterangan(Auth::user()->role_id, Auth::user()->idskpd));
                        return Redirect::to('/login');
                    }
                } else {
                    //return Redirect::to('/login-admin');
                    //return Redirect::to('/login');

                    // validate the info, create rules for the inputs
                    $rules = array(
                        'username'    => 'required', // make sure the email is an actual email
                        'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
                    );

                    // run the validation rules on the inputs from the form
                    $validator = Validator::make(Input::all(), $rules);
                    // if the validator fails, redirect back to the form
                    if ($validator->fails()) {
                        \Session::put('msgerr', 'Harap isi username dan password');
                        return Redirect::to('/login')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
                    } else {

                        // create our user data for the authentication
                        $userdata1['nip'] = Input::get('username');
                        $userdata1['password'] = md5(Input::get('password'));

                        $item = \DB::table('tb_01')->where($userdata1)->first();

                        // attempt to do the login
                        if (count($item) > 0) {
                            /*cek aktifasi user pns*/
                            if ($item->usiapens == 1) {
                                /*cek jadwal login ya brother*/
                                if (getJadwal(4, $item->idskpd, 5)) {
                                    $role = \DB::table('roles')->where('id', '=', 5)->first()->name;
                                    $rolesModel = \RolesModel::find(5);
                                    \Session::put('role_id', 5);
                                    \Session::put('role', $role);
                                    \Session::put('user_id', $item->nip);
                                    \Session::put('user_name', $item->nama);
                                    \Session::put('name', (($item->gdp != '') ? $item->gdp . ', ' : '') . "" . $item->nama . "" . (($item->gdb != '') ? ' ,' . $item->gdb : ''));
                                    \Session::put('foto', $item->photo);
                                    \Session::put('idskpd', $item->idskpd);
                                    \Session::put('skpd', getSkpd($item->idskpd));
                                    \Session::put('_key', $userdata['password']);


                                    $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                                        $q->where('name', '=', 'site-login');
                                    }))->where('role_id', \Session::get('role_id'))->get();

                                    if ($pms->count() > 0) {
                                        return Redirect::to('/' . $rolesModel->login_destination);
                                        /*echo "<pre>";
                                                    print_r(Session::all());
                                                echo "</pre>";
                                                echo "<br>".$rolesModel->login_destination;*/
                                    } else {
                                        Auth::logout();
                                        \Session::flash('msgerr', 'You don\'t have permission to sign in into this applications.');
                                        return Redirect::to('/login');
                                    }
                                } else {
                                    Session::flush();
                                    \Session::put('msgerr', getKeterangan(4, $item->idskpd, 5));
                                    return Redirect::to('/login');
                                }
                            } else {
                                Auth::logout();
                                \Session::put('msgerr', 'Mohon maaf. Access login pegawai saat ini dinonaktifkan.');
                                return Redirect::to('/login');
                            }
                        } else {
                            \Session::put('msgerr', 'Kombinasi username dan password salah');
                            return Redirect::to('/login');
                            //return Redirect::to('/login');

                        }
                    }
                }
            }
        } else {
            \Session::flash('msgerr', 'Jawaban anda salah !!!');
            return Redirect::to('/login');
            // return Redirect::to('/tello');
        }
    }

    //login dari efile
    public function getLoginfefile()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            \Session::put('msgerr', 'Harap isi username dan password');
            return Redirect::to('/')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'username'  => Input::get('username'),
                'password'  => Input::get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                $role = \DB::table('roles')
                    ->where('id', '=', Auth::user()->role_id)
                    ->first()->name;

                /*cek jadwal login ya brother*/
                if (getJadwal(Auth::user()->role_id, Auth::user()->idskpd)) {

                    /*echo "OPSS.. Terjadi Kesalahan ".getJadwal(Auth::user()->role_id, Auth::user()->idskpd);
                    exit();*/

                    $rolesModel = \RolesModel::find(Auth::user()->role_id);
                    \Session::put('role_id', Auth::user()->role_id);
                    \Session::put('role', $role);
                    \Session::put('user_id', Auth::user()->id);
                    \Session::put('user_name', Auth::user()->username);
                    \Session::put('name', Auth::user()->name);
                    \Session::put('foto', Auth::user()->foto);
                    \Session::put('idskpd', Auth::user()->idskpd);
                    \Session::put('skpd', getSkpd(Auth::user()->idskpd));
                    \Session::put('_key', Input::get('password'));

                    $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                        $q->where('name', '=', 'site-login');
                    }))->where('role_id', \Session::get('role_id'))->get();

                    if ($pms->count() > 0) {
                        return Redirect::to('/' . $rolesModel->login_destination);
                        /*echo "<pre>";
                            print_r(Session::all());
                        echo "</pre>";
                        echo "<br>".$rolesModel->login_destination;*/
                    } else {
                        Auth::logout();
                        \Session::flash('msgerr', 'You don\'t have permission to sign in into this applications.');
                        return Redirect::to('/login');
                    }
                } else {
                    Session::flush();
                    \Session::put('msgerr', getKeterangan(Auth::user()->role_id, Auth::user()->idskpd));
                    return Redirect::to('/login');
                }
            } else {
                //return Redirect::to('/login-admin');
                //return Redirect::to('/login');

                // validate the info, create rules for the inputs
                $rules = array(
                    'username'    => 'required', // make sure the email is an actual email
                    'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
                );

                // run the validation rules on the inputs from the form
                $validator = Validator::make(Input::all(), $rules);
                // if the validator fails, redirect back to the form
                if ($validator->fails()) {
                    \Session::put('msgerr', 'Harap isi username dan password');
                    return Redirect::to('/login')
                        ->withErrors($validator) // send back all errors to the login form
                        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
                } else {

                    // create our user data for the authentication
                    $userdata1['nip'] = Input::get('username');
                    $userdata1['password'] = md5(Input::get('password'));

                    $item = \DB::table('tb_01')->where($userdata1)->first();

                    // attempt to do the login
                    if (count($item) > 0) {
                        /*cek aktifasi user pns*/
                        if ($item->usiapens == 1) {
                            /*cek jadwal login ya brother*/
                            if (getJadwal(4, $item->idskpd, 5)) {
                                $role = \DB::table('roles')->where('id', '=', 5)->first()->name;
                                $rolesModel = \RolesModel::find(5);
                                \Session::put('role_id', 5);
                                \Session::put('role', $role);
                                \Session::put('user_id', $item->nip);
                                \Session::put('user_name', $item->nama);
                                \Session::put('name', (($item->gdp != '') ? $item->gdp . ', ' : '') . "" . $item->nama . "" . (($item->gdb != '') ? ' ,' . $item->gdb : ''));
                                \Session::put('foto', $item->photo);
                                \Session::put('idskpd', $item->idskpd);
                                \Session::put('skpd', getSkpd($item->idskpd));
                                \Session::put('_key', $userdata['password']);


                                $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                                    $q->where('name', '=', 'site-login');
                                }))->where('role_id', \Session::get('role_id'))->get();

                                if ($pms->count() > 0) {
                                    return Redirect::to('/' . $rolesModel->login_destination);
                                    /*echo "<pre>";
                                        print_r(Session::all());
                                    echo "</pre>";
                                    echo "<br>".$rolesModel->login_destination;*/
                                } else {
                                    Auth::logout();
                                    \Session::flash('msgerr', 'You don\'t have permission to sign in into this applications.');
                                    return Redirect::to('/login');
                                }
                            } else {
                                Session::flush();
                                \Session::put('msgerr', getKeterangan(4, $item->idskpd, 5));
                                return Redirect::to('/login');
                            }
                        } else {
                            Auth::logout();
                            \Session::put('msgerr', 'Mohon maaf. Access login pegawai saat ini dinonaktifkan.');
                            return Redirect::to('/login');
                        }
                    } else {
                        \Session::put('msgerr', 'Kombinasi username dan password salah');
                        return Redirect::to('/login');
                        //return Redirect::to('/login');

                    }
                }
            }
        }
    }

    /*login sie eksekutif*/
    public function postLoginsie()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/login-eksekutif')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'username'     => Input::get('username'),
                'password'     => Input::get('password'),
                'role_id'   => 3
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                $role = \DB::table('roles')
                    ->where('id', '=', Auth::user()->role_id)
                    ->first()->name;

                $rolesModel = \RolesModel::find(Auth::user()->role_id);
                \Session::put('role_id', Auth::user()->role_id);
                \Session::put('role', $role);
                \Session::put('user_id', Auth::user()->id);
                \Session::put('user_name', Auth::user()->username);
                \Session::put('name', Auth::user()->name);
                \Session::put('foto', Auth::user()->foto);
                \Session::put('idskpd', Auth::user()->idskpd);
                \Session::put('skpd', getSkpd(Auth::user()->idskpd));


                $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                    $q->where('name', '=', 'site-login');
                }))->where('role_id', \Session::get('role_id'))->get();

                if ($pms->count() > 0) {
                    return Redirect::to('/' . $rolesModel->login_destination);
                    /*echo "<pre>";
                        print_r(Session::all());
                    echo "</pre>";
                    echo "<br>".$rolesModel->login_destination;*/
                } else {
                    Auth::logout();
                    \Session::flash('message', 'You don\'t have permission to sign in into this applications.');
                    return Redirect::to('/login-eksekutif');
                }
            } else {
                return Redirect::to('/login-eksekutif');
                //return Redirect::to('/login');

            }
        }
    }

    /*function login kepegawain*/
    public function postLoginpegawai()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/login-pegawai')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata['nip'] = Input::get('username');
            $userdata['password'] = md5(Input::get('password'));

            $item = \DB::table('tb_01')->where($userdata)->first();

            // attempt to do the login
            if (count($item) > 0) {
                $role = \DB::table('roles')->where('id', '=', 5)->first()->name;
                $rolesModel = \RolesModel::find(5);
                \Session::put('role_id', 5);
                \Session::put('role', $role);
                \Session::put('user_id', $item->nip);
                \Session::put('user_name', $item->nama);
                \Session::put('name', (($item->gdp != '') ? $item->gdp . ', ' : '') . "" . $item->nama . "" . (($item->gdb != '') ? ' ,' . $item->gdb : ''));
                \Session::put('foto', $item->photo);
                \Session::put('idskpd', $item->idskpd);
                \Session::put('skpd', getSkpd($item->idskpd));
                \Session::put('_key', $userdata['password']);


                $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                    $q->where('name', '=', 'site-login');
                }))->where('role_id', \Session::get('role_id'))->get();

                if ($pms->count() > 0) {
                    return Redirect::to('/' . $rolesModel->login_destination);
                    /*echo "<pre>";
                        print_r(Session::all());
                    echo "</pre>";
                    echo "<br>".$rolesModel->login_destination;*/
                } else {
                    Auth::logout();
                    \Session::flash('message', 'You don\'t have permission to sign in into this applications.');
                    return Redirect::to('/login-pegawai');
                }
            } else {
                return Redirect::to('/login-pegawai');
                //return Redirect::to('/login');

            }
        }
    }

    /*function login kepegawain dari efile*/
    public function getLoginpegawai2()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/login-pegawai')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata['nip'] = Input::get('username');
            $userdata['password'] = Input::get('password');

            $item = \DB::table('tb_01')->where($userdata)->first();

            // attempt to do the login
            if (count($item) > 0) {
                $role = \DB::table('roles')->where('id', '=', 5)->first()->name;
                $rolesModel = \RolesModel::find(5);
                \Session::put('role_id', 5);
                \Session::put('role', $role);
                \Session::put('user_id', $item->nip);
                \Session::put('user_name', $item->nama);
                \Session::put('name', (($item->gdp != '') ? $item->gdp . ', ' : '') . "" . $item->nama . "" . (($item->gdb != '') ? ' ,' . $item->gdb : ''));
                \Session::put('foto', $item->photo);
                \Session::put('idskpd', $item->idskpd);
                \Session::put('skpd', getSkpd($item->idskpd));
                \Session::put('_key', $userdata['password']);


                $pms = \PermissionsmatrixModel::with(array('permissions' => function ($q) {
                    $q->where('name', '=', 'site-login');
                }))->where('role_id', \Session::get('role_id'))->get();

                if ($pms->count() > 0) {
                    return Redirect::to('/' . $rolesModel->login_destination);
                    /*echo "<pre>";
                        print_r(Session::all());
                    echo "</pre>";
                    echo "<br>".$rolesModel->login_destination;*/
                } else {
                    Auth::logout();
                    \Session::flash('message', 'You don\'t have permission to sign in into this applications.');
                    return Redirect::to('/login-pegawai');
                }
            } else {
                return Redirect::to('/login-pegawai');
                //return Redirect::to('/login');

            }
        }
    }

    /*function untuk mendapatkan graph cpns*/
    public function getGraphcpns()
    {
        $rs = \DB::table('tb_01')
            ->join('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->select('a_golruang.golru', \DB::raw('SUM(IF(idstspeg = 1,1,0)) AS cpns'))
            ->where('tb_01.idjenkedudupeg', '!=', 99)
            ->where('tb_01.idjenkedudupeg', '!=', 21)
            ->groupBy('tb_01.idgolrupkt');

        $categories = "golru,cpns";
        echo $categories . "\r\n";
        foreach ($rs->get() as $item) {
            echo $item->golru . "," . $item->cpns . "\r\n";
        }
    }

    /*function untuk mendapatkan graph pns*/
    public function getGraphpns()
    {
        $rs = \DB::table('tb_01')
            ->join('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->select('a_golruang.golru', \DB::raw('SUM(IF(idstspeg = 2,1,0)) AS pns'))
            ->where('tb_01.idjenkedudupeg', '!=', 99)
            ->where('tb_01.idjenkedudupeg', '!=', 21)
            ->groupBy('tb_01.idgolrupkt');

        $categories = "golru,pns";
        echo $categories . "\r\n";
        foreach ($rs->get() as $item) {
            echo $item->golru . "," . $item->pns . "\r\n";
        }
    }

    /*function untuk mendapatkan graph pppk*/
    public function getGraphpppk()
    {
        $rs = \DB::table('tb_01')
            ->join('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
            ->select('a_golruang.golru_p3k', \DB::raw('SUM(IF(idstspeg = 3,1,0)) AS pppk'))
            ->where('tb_01.idjenkedudupeg', '!=', 99)
            ->where('tb_01.idjenkedudupeg', '!=', 21)
            ->groupBy('tb_01.idgolrupkt');

        $categories = "golru_p3k,pppk";
        echo $categories . "\r\n";
        foreach ($rs->get() as $item) {
            echo $item->golru_p3k . "," . $item->pppk . "\r\n";
        }
    }

    public function getLogout()
    {
        if (session('role_id') == 3) {
            Session::flush();
            //return Redirect::to('/login-eksekutif');
            return Redirect::to('/');
        } else if (session('role_id') == 5) {
            Session::flush();
            //return Redirect::to('/login-pegawai');
            return Redirect::to('/');
        } else {
            /*Auth::logout();*/
            Session::flush();
            return Redirect::to('/');
        }
    }
}
