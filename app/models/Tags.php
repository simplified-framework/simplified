<?php

namespace App\Models;

use Simplified\Database\Model;

class Tags extends Model {
	static $table = 'tags';
	
	/**
	 * get all posts from this tag by slug
	 */
	public function posts() {
		return $this->hasMany('App\\Models\\Posts');
	}
}

?>