<?php namespace App\Modules\pppkpw\templateskpppkpw\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pppkpw\templateskpppkpw\Models\TemplateskpppkpwModel;
use Input,View, Request, Form, File;

class TemplateskpppkpwController extends Controller {

	/**
	 * Templateskpppkpw Repository
	 *
	 * @var Templateskpppkpw
	 */
	protected $templateskpppkpw;

	public function __construct()
	{
	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		return View::make('templateskpppkpw::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('templateskpppkpw::create');
	}

	function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('templateskpppkpw::'.$view.'_data');
    }

	/*function untuk simpan template*/
    public function postSavetemplate(){
        cekAjax();
        $dt['idskpd'] = (Input::get('idskpd')!='')?Input::get('idskpd'):'all';
        $dt['jnssurat'] = Input::get('jnssurat');

        $cek = \DB::table('tr_pppkpw_template')->where($dt)->count();
        if($cek === 0){
            $dt['nama'] = Input::get('nama');
            switch ($dt['jnssurat']) {
                case 1: $dt['template'] = Input::get('template1'); break;
                case 2: $dt['template'] = Input::get('template2'); break;
                case 3: $dt['template'] = Input::get('template3'); break;
                case 4: $dt['template'] = Input::get('template4'); break;
                case 5: $dt['template'] = Input::get('template5'); break;
                case 6: $dt['template'] = Input::get('template6'); break;
                case 7: $dt['template'] = Input::get('template7'); break;
                case 8: $dt['template'] = Input::get('template8'); break;
                case 9: $dt['template'] = Input::get('template9'); break;
                case 10: $dt['template'] = Input::get('template10'); break;
                case 11: $dt['template'] = Input::get('template11'); break;
            }

            $insert = \DB::table('tr_pppkpw_template')->insert($dt);
            echo ($insert)?1:"Gagal Disimpan";
        }else{
            $data['nama'] = Input::get('nama');
            switch ($dt['jnssurat']) {
                case 1: $data['template'] = Input::get('template1'); break;
                case 2: $data['template'] = Input::get('template2'); break;
                case 3: $data['template'] = Input::get('template3'); break;
                case 4: $data['template'] = Input::get('template4'); break;
                case 5: $data['template'] = Input::get('template5'); break;
                case 6: $data['template'] = Input::get('template6'); break;
                case 7: $data['template'] = Input::get('template7'); break;
                case 8: $data['template'] = Input::get('template8'); break;
                case 9: $data['template'] = Input::get('template9'); break;
                case 10: $data['template'] = Input::get('template10'); break;
                case 11: $data['template'] = Input::get('template11'); break;
            }

            $update = \DB::table('tr_pppkpw_template')->where($dt)->update($data);
            echo ($update)?1:"Gagal Disimpan";
        }
    }

    public function getDs($surat,$id)
    {
        $data = \App\Models\PPPK\RPPPK::findOrFail($id);
         return View::make('templateskpppkpw::digitalsign',compact('surat','data'));
    }

    /*function untuk mendapatkan template surat*/
    function postSurat(){
        cekAjax();
        $idskpd = Input::get('idskpd');
        $jnssurat = Input::get('jnssurat');

        $rs = \DB::table('tr_pppkpw_template')->where(array('idskpd' => $idskpd, 'jnssurat' => $jnssurat))->get();
        if(count($rs) > 0){
            $rs['template'] = TemplateskpppkpwModel::getTemplate($idskpd, $jnssurat);
        }else{
            $rs['template'] = TemplateskpppkpwModel::getTemplate('all', $jnssurat);
        }

        echo json_encode($rs);
    }
}
