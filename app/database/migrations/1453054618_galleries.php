<?php 

use Simplified\Database\Schema\Schema;
use Simplified\Database\Schema\Blueprint;
use Simplified\Console\MigrateInterface;

class Galleries extends MigrateInterface {
	public function up() {
		Schema::create('galleries', function(Blueprint $bp) {
			 $bp->increments('id')->primary('id')
				 ->string('title')
				 ->timestamps();
		});
	}

	public function down() {
		Schema::drop("galleries");
	}
}
