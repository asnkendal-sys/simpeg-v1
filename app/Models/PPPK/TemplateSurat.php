<?php namespace App\Models\PPPK;

use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "tr_pppk_template";
}