<?php

namespace App\Models;

use Simplified\Database\Model;

class Tags extends Model {
	public function posts() {
		return $this->hasMany('App\\Models\\Posts');
	}

	public function __toString() {
		return (string)$this->slug;
	}
}

?>