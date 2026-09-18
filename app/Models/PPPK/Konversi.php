<?php namespace App\Models\PPPK;

use Illuminate\Database\Eloquent\Model;

class Konversi extends Model {

	protected $guarded = array();
    
    protected $table = "a_konversidata_mpppk";

    public static $rules = array(
        'konversi' => 'required',
    );

    public static function all($columns = array('*')){
        $instance = new static;
        if (\PermissionsLibrary::hasPermission('mod-konversipppk-listall')){
            return $instance->newQuery()->where('konversi', 2)->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
            ->where('konversi', 2)
            ->where('role_id', \Session::get('role_id'))
            ->paginate($_ENV['configurations']['list-limit']);  
            
        }
    }

    /*function get id jenis kelamin*/
    public static function idKelamin($jenkel = ''){
        if($jenkel == 'Pria'){
            return 1;
        }else if($jenkel == 'Wanita'){
            return 2;
        }else{
            return '';
        }
    }

     public static function idAgama($agama = ''){                    
        if($agama == 'Islam'){
            return 1;
        }else if($agama == 'Kristen'){
            return 2;
        }else if($agama == 'Katholik'){
            return 3;
        }else if($agama == 'Hindu'){
            return 4;
        }else if($agama == 'Budha'){
            return 5;
        }else if($agama == 'Konghucu'){
            return 6;
        }else{
            return '';
        }
    }

    public static function listName($namalengkap='', $list=''){
        $nama = explode(",",$namalengkap);
        $n  =  count($nama);

        if($list == 2){
            $ret = '';
            if($n > 0){
                for($i = 1; $i < $n; $i++){
                    $ret.= $nama[$i].(($i < $n-1)?', ':'');
                }
            }

            return $ret;
        }else{
            return @$nama[0];
        }
    }

    public static function idJenjab($jenjab = ''){
        if($jenjab == 'Fungsional Tertentu'){
            return 2;
        }else if($jenjab == 'Pelaksana'){
            return 3;
        }else if($jenjab == 'Pimpinan Tinggi Pratama'){
            return 20;
        }else if($jenjab == 'Administrator '){
            return 30;
        }else if($jenjab == 'pengawas '){
            return 40;
        }else{
            return '';
        }
    }
}