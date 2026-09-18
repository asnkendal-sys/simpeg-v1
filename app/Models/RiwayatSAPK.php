<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \App\Models\Pegawai;

class RiwayatSAPK extends Model {

	protected $guarded = array();
    
    protected $table = "r_sync_sapk";

    public $timestamps = false;

}