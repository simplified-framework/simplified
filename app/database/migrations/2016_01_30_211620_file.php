<?php 

use Simplified\Database\Schema\Schema;
use Simplified\Database\Schema\Blueprint;
use Simplified\Console\MigrateInterface;

class File extends MigrateInterface {
	public function up() {
		Schema::create('file', function(Blueprint $bp) {
			 $bp->increments('id')->primary('id')
				 ->string('name')
				 ->timestamps();
		});
	}

	public function down() {
		Schema::drop("file");
	}
}
