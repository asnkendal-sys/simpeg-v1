<?php
namespace App\Http\Controllers;

use View, Input;
use App\Models\Riwayat\TTE;
use App\Services\TTEService;

class TTEController extends Controller {

	public function sign(){
		//looping disini, bkin method baru
		$id = Input::get('id'); //id tte
		// dd($id); die();
		if ($id != '') {
		    $tte = TTE::find($id); //get data yg mau tte
			// dd($tte); die();
		    $tte_s =  new TTEService($tte);
		    return $tte_s->sign(Input::get('passphrase'));
		}

		return 0;
	}

	public function signMultiple(){
		$ids = explode(",",Input::get('id'));
		if(is_array($ids)) {
			// dd($ids); 
			$ada_error = false;
			//$nip = ""; //
			$message= "";
			foreach($ids as $id){
				$tte = TTE::find($id);
		    	$tte_s =  new TTEService($tte);
				$tte_temp=$tte_s->sign(Input::get('passphrase'));
				// dd($tte_temp); die();
				if($tte_temp['code'] != "200"){
					$ada_error = true;
					//$nip .= " ".$tte_temp['nip']; //
					$message .= " ".$tte_temp['message']; //
				}
			}
			if($ada_error){
				$sign_result['code'] = "500";
				//kalo ada salah data misal nip
        		// $sign_result['message'] = "Dokumen gagal ditandatangani nip: ".$nip;
				$sign_result['message'] = $message;
			}else{
				$sign_result['code'] = "200";
        		$sign_result['message'] = "Dokumen Sudah ditandatangani.";
			}
			
			return $sign_result;
		}

		return 0;
	}

    /* sign pppk */
    public function signPppk(){
        //looping disini, bkin method baru
        $id = Input::get('id'); //id tte
        // dd($id); die();
        if ($id != '') {
            $tte = TTE::find($id); //get data yg mau tte
            // dd($tte); die();
            $tte_s =  new TTEService($tte);
            return $tte_s->signPppk(Input::get('passphrase'));
        }

        return 0;
    }

    public function signPppkMultiple(){
        $ids = explode(",",Input::get('id'));
        if(is_array($ids)) {
            // dd($ids);
            $ada_error = false;
            //$nip = ""; //
            $message= "";
            foreach($ids as $id){
                $tte = TTE::find($id);
                $tte_s =  new TTEService($tte);
                $tte_temp=$tte_s->signPppk(Input::get('passphrase'));
                // dd($tte_temp); die();
                if($tte_temp['code'] != "200"){
                    $ada_error = true;
                    //$nip .= " ".$tte_temp['nip']; //
                    $message .= " ".$tte_temp['message']; //
                }
            }
            if($ada_error){
                $sign_result['code'] = "500";
                //kalo ada salah data misal nip
                // $sign_result['message'] = "Dokumen gagal ditandatangani nip: ".$nip;
                $sign_result['message'] = $message;
            }else{
                $sign_result['code'] = "200";
                $sign_result['message'] = "Dokumen Sudah ditandatangani.";
            }

            return $sign_result;
        }

        return 0;
    }

    /* sign pppk */
    public function signPppkpw(){
        //looping disini, bkin method baru
        $id = Input::get('id'); //id tte
        // dd($id); die();
        if ($id != '') {
            $tte = TTE::find($id); //get data yg mau tte
            // dd($tte); die();
            $tte_s =  new TTEService($tte);
            return $tte_s->signPppkpw(Input::get('passphrase'));
        }

        return 0;
    }

    public function signPppkpwMultiple(){
        $ids = explode(",",Input::get('id'));
        if(is_array($ids)) {
            // dd($ids);
            $ada_error = false;
            //$nip = ""; //
            $message= "";
            foreach($ids as $id){
                $tte = TTE::find($id);
                $tte_s =  new TTEService($tte);
                $tte_temp=$tte_s->signPppkpw(Input::get('passphrase'));
                // dd($tte_temp); die();
                if($tte_temp['code'] != "200"){
                    $ada_error = true;
                    //$nip .= " ".$tte_temp['nip']; //
                    $message .= " ".$tte_temp['message']; //
                }
            }
            if($ada_error){
                $sign_result['code'] = "500";
                //kalo ada salah data misal nip
                // $sign_result['message'] = "Dokumen gagal ditandatangani nip: ".$nip;
                $sign_result['message'] = $message;
            }else{
                $sign_result['code'] = "200";
                $sign_result['message'] = "Dokumen Sudah ditandatangani.";
            }

            return $sign_result;
        }

        return 0;
    }
}