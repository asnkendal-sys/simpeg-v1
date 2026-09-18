<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
* Kenaikangaji Migration
* @var Kenaikangaji
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class Kenaikangaji extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('r_tte', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('jenis', 20);
			$table->string('file', 20);
			$table->string('id_sk', 20);
			$table->string('nip_pengusul', 20);
			$table->string('nip_pejabat', 20);
			$table->string('proses', 20);
			$table->bigInteger('user_id');
			$table->bigInteger('role_id');

			$table->dateTime('created_at');
			$table->dateTime('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
		public function down()
	{
		Schema::drop('r_tte');
	}

}
