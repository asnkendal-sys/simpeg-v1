<?php namespace App\Modules\emutasi\templatemasukkabupaten\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\emutasi\templatemasukkabupaten\Models\TemplatemasukkabupatenModel;
use Input,View, Request, Form, File;

/**
* Templatemasukkabupaten Controller
* @var Templatemasukkabupaten
* Generate from Custom Laravel 5.1 by Aa Gun.
*
* Developed by Divisi Software Development - Dinustek.
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class TemplatemasukkabupatenController extends Controller {
    protected $templatemasukkabupaten;

    public function __construct(TemplatemasukkabupatenModel $templatemasukkabupaten){
        $this->templatemasukkabupaten = $templatemasukkabupaten;
    }

    public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $templatemasukkabupatens = $this->templatemasukkabupaten
                			->orWhere('jnssurat', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('template', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('author', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('tgin', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $templatemasukkabupatens = $this->templatemasukkabupaten->all();
            }
        }else{
            $templatemasukkabupatens = $this->templatemasukkabupaten->all();
        }
        return View::make('templatemasukkabupaten::index', compact('templatemasukkabupatens'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('templatemasukkabupaten::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, TemplatemasukkabupatenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->templatemasukkabupaten->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $templatemasukkabupaten = $this->templatemasukkabupaten->find($id);
        //if (is_null($templatemasukkabupaten)){return \Redirect::to('emutasi/templatemasukkabupaten/index');}
        return View::make('templatemasukkabupaten::edit', compact('templatemasukkabupaten'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, TemplatemasukkabupatenModel::$rules);

        if ($validation->passes()){
            $templatemasukkabupaten = $this->templatemasukkabupaten->find($id);
            echo ($templatemasukkabupaten->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->templatemasukkabupaten->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->templatemasukkabupaten->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    public function getPersetujuanpindahprov(){
        cekAjax();
        $templatemasukkabupatens = $this->templatemasukkabupaten->all();
        return View::make('templatemasukkabupaten::persetujuanpindahprov', compact('templatemasukkabupatens'));
    }

    public function getPengantarpersetujuan(){
        cekAjax();
        $templatemasukkabupatens = $this->templatemasukkabupaten->all();
        return View::make('templatemasukkabupaten::pengantarpersetujuan', compact('templatemasukkabupatens'));
    }

    public function getSurattugas(){
        cekAjax();
        $templatemasukkabupatens = $this->templatemasukkabupaten->all();
        return View::make('templatemasukkabupaten::surattugas', compact('templatemasukkabupatens'));
    }

    public function getPengantarsurattugas(){
        cekAjax();
        $templatemasukkabupatens = $this->templatemasukkabupaten->all();
        return View::make('templatemasukkabupaten::pengantarsurattugas', compact('templatemasukkabupatens'));
    }

    /*function untuk simpan template*/
    public function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $dt['jnssurat'] = Input::get('jnssurat');

        $cek = \DB::table('tr_mutasi_template_sk')->where($dt)->count();
        if($cek === 0){
            $dt['nama'] = Input::get('nama');
            $dt['template'] = Input::get('template');
            $insert = \DB::table('tr_mutasi_template_sk')->insert($dt);
            echo ($insert)?1:"Gagal Disimpan";
        }else{
            $data['nama'] = Input::get('nama');
            $data['template'] = Input::get('template');
            $update = \DB::table('tr_mutasi_template_sk')->where($dt)->update($data);
            echo ($update)?1:"Gagal Disimpan";
        }
    }

}
