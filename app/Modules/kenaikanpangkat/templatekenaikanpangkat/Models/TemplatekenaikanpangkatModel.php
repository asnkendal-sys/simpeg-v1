<?php namespace App\Modules\kenaikanpangkat\templatekenaikanpangkat\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Templatekenaikanpangkat Model
 * @var Templatekenaikanpangkat
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class TemplatekenaikanpangkatModel extends Model {
    protected $guarded = array();

    protected $table = "tr_kenaikan_pangkat_template";

    public static $rules = array(
        'template' => 'required',

    );

    public static function all($columns = array('*')){
        $instance = new static;
        if (\PermissionsLibrary::hasPermission('mod-templatekenaikanpangkat-listall')){
            return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    /*function untuk mendapatkan template*/
    public static function getTemplate($idskpd, $jnskp){
        $rs = \DB::table('tr_kenaikan_pangkat_template')->where('idskpd',$idskpd)->where('jnskp',$jnskp)->first();
        if(count($rs) > 0){
            return $rs->template;
        }else{
            return "0";
        }
    }

    

}
