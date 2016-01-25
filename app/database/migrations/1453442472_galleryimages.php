<?php 

use Simplified\Database\Schema\Schema;
use Simplified\Database\Schema\Blueprint;
use Simplified\Console\MigrateInterface;

class GalleryImages extends MigrateInterface {
	public function up() {
		Schema::create('gallery_images', function(Blueprint $bp) {
			 $bp->increments('id')->primary('id')
				 ->integer('galleries_id')
				 ->string('title')
				 ->string('filename');
		});
	}

	public function down() {
		Schema::drop("gallery_images");
	}
}
