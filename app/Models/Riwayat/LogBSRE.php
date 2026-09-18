<?php namespace App\Models\Riwayat;

use Illuminate\Database\Eloquent\Model;

class LogBSRE extends Model {

    protected $guarded = array();
    protected $connection = "tugumuda";
    protected $table = "log_bsre";
    public $timestamps = false;

}

//id              bigint(30)    NO      PRI     (NULL)               auto_increment  
//id_transaction  bigint(30)    YES             (NULL)                               
//url             varchar(255)  YES             (NULL)                               
//user_id         bigint(30)    YES             (NULL)                               
//nik             varchar(20)   YES             (NULL)                               
//status_code     int(5)        YES             (NULL)                               
//message         text          YES             (NULL)                               
//created_at      timestamp     NO              current_timestamp()                  