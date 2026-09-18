<?php namespace App\Modules\administrator\imageslider\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Imageslider Model
* @var Imageslider
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class ImagesliderModel extends Model {
	protected $guarded = array();
	
	protected $table = "a_image_slider";

	public static $rules = array(
    		/*'img' => 'required',*/
		'caption' => 'required',
		'flag' => 'required',
		'order' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-imageslider-listall')){
			return $instance->newQuery()->orderBy('order')->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
            ->orderBy('order')
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
