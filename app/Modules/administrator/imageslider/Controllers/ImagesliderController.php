<?php namespace App\Modules\administrator\imageslider\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\administrator\imageslider\Models\ImagesliderModel;
use Input,View, Request, Form, File;

/**
* Imageslider Controller
* @var Imageslider
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class ImagesliderController extends Controller {
    protected $imageslider;

    public function __construct(ImagesliderModel $imageslider){
        $this->imageslider = $imageslider;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $imagesliders = $this->imageslider
                			->orWhere('img', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('caption', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('flag', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('order', 'LIKE', '%'.Input::get('search').'%')
            ->orderBy('order')
                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $imagesliders = $this->imageslider->all();
            }
        }else{
            $imagesliders = $this->imageslider->all();
        }
        return View::make('imageslider::index', compact('imagesliders'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('imageslider::create');
    }

    public function postCreate(){
        cekAjax();
        if(\Input::hasFile('img')){
            $fotos = \Input::file('img');
            $destinationPath = base_path().'/packages/upload/photo/slider/';
            $tipefile = $fotos->getClientOriginalExtension();
            $filename = str_random(6).'.'.$tipefile;
            $file = $fotos;
            $uploadSuccess  = $file->move($destinationPath, $filename);
            $input = array(
                'caption' => \Input::get('caption'),
                'order' => \Input::get('order'),
                'flag' => \Input::get('flag'),
                'img' => $filename,
            );
        }else{
            $input = array(
                'caption' => \Input::get('caption'),
                'order' => \Input::get('order'),
                'flag' => \Input::get('flag'),
            );
        }

        $validation = \Validator::make($input, ImagesliderModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->imageslider->create($input))?'1':'Gagal Disimpan';
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $imageslider = $this->imageslider->find($id);
        //if (is_null($imageslider)){return \Redirect::to('administrator/imageslider/index');}
        return View::make('imageslider::edit', compact('imageslider'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $gambar = $this->imageslider
            ->Where('id', '=', $id)->first();
        $destinationPath = base_path().'/packages/upload/photo/slider/';
        //$input = Input::all();
        if(\Input::hasFile('img')){
            @unlink($destinationPath.$gambar->img);
            $gambars = \Input::file('img');
            //$destinationPath = base_path().'/packages/upload/photo/slider/';

            $tipefile = $gambars->getClientOriginalExtension();
            $filename = str_random(6).'.'.$tipefile;
            $file = $gambars;
            $uploadSuccess  = $file->move($destinationPath, $filename);
            $input = array(
                '_token' => \Input::get('_token'),
                'caption' => \Input::get('caption'),
                'order' => \Input::get('order'),
                'flag' => \Input::get('flag'),
                'img' => $filename,
            );
        }else{
            $input = array(
                '_token' => \Input::get('_token'),
                'caption' => \Input::get('caption'),
                'order' => \Input::get('order'),
                'flag' => \Input::get('flag'),
            );
        }

        $validation = \Validator::make($input, ImagesliderModel::$rules);

        if ($validation->passes()){
            $imageslider = $this->imageslider->find($id);
            echo ($imageslider->update($input))?4:"Gagal Disimpan";
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
                $this->imageslider->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->imageslider->find($ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function untuk save sort image slider*/
    function postSortslider(){
        $input = Input::all();
        $arr = explode(",",Input::get('id'));
        $min = min($arr);
        foreach($arr as $key=>$value){
            $arr2 = explode("-",$value);

            \DB::table('a_image_slider')
                ->where('id', $arr2[1])
                ->update(array('order' => ($key+$min)));
        }
    }

}
