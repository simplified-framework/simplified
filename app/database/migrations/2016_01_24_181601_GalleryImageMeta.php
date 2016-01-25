<?php 

use Simplified\Database\Schema\Schema;
use Simplified\Database\Schema\Blueprint;
use Simplified\Console\MigrateInterface;

class GalleryImageMeta extends MigrateInterface {
	public function up() {
		Schema::create('gallery_image_meta', function(Blueprint $bp) {
			 $bp->increments('id')->primary('id')
				 ->integer('gallery_images_id')
				 ->string('title')
				 ->string('copyright')->nullable();
		});
	}

	public function down() {
		Schema::drop("gallery_image_meta");
	}
}
