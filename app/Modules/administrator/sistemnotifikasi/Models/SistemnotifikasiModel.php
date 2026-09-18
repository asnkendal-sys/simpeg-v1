<?php namespace App\Modules\administrator\sistemnotifikasi\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Sistemnotifikasi Model
 * @var Sistemnotifikasi
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class SistemnotifikasiModel extends Model {
    protected $guarded = array();

    protected $table = "tr_notification_system";

    public static $rules = array(
        'title' => 'required',
        'notification' => 'required',
        'tgl_publish' => 'required',
        /*'flag' => 'required',*/
        /*'publish_at' => 'required',*/

    );

    public static function all($columns = array('*')){
        $instance = new static;
        if (\PermissionsLibrary::hasPermission('mod-sistemnotifikasi-listall')){
            return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
        }else{
            return $instance->newQuery()
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

    /*function untuk mendapatkan detail notifikasi*/
    public static function getNotifikasi($id){
        $rs = \DB::table('tr_notification_system')->where('id', $id)->first();
        return $rs;
    }

    /*function untuk mendapatkan penerima notifikasi*/
    public static function getPenerima($idnotifikasi){
        $penerima = '';
        $dt['idnotifikasi'] = $idnotifikasi;

        $x = 0;
        $rs = \DB::table('tr_notification_system_penerima')->where($dt);
        $n = $rs->count();

        if($n > 0){
            foreach($rs->get() as $item){
                $x++;
                if($item->idkategori == 1){
                    $penerima .= "<a href='javascript:void(0)' recid='".$item->id."' rectxt='Semua OPD' class='pen-remove tag label label-warning'>Semua OPD <span class='fa fa-remove'></span></a>".(($n==$x)?'':' ');
                }else if($item->idkategori == 2){
                    $rspenerima = \DB::table('a_skpd')->where('idskpd', $item->penerima)->first();
                    $penerima .= "<a href='javascript:void(0)' recid='".$item->id."' rectxt='".$rspenerima->path_short."' class='pen-remove tag label label-success'>".$rspenerima->path_short." <span class='fa fa-remove'></span></a>".(($n==$x)?'':' ');
                }else if($item->idkategori >= 3){
                    $rspenerima = \DB::table('tb_01')->where('nip', $item->penerima)->first();
                    $penerima .= "<a href='javascript:void(0)' recid='".$item->id."' rectxt='".$rspenerima->nip.' - '.$rspenerima->nama."' class='pen-remove tag label label-info'>".$rspenerima->nip.' - '.$rspenerima->nama." <span class='fa fa-remove'></span></a>".(($n==$x)?'':' ');
                }
            }
        }else{
            $penerima = "-";
        }

        return $penerima;
    }

}
