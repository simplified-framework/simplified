<?php

namespace App\Models;
use Simplified\Database\Model;

class Categories extends Model {
	static $table = 'categories';

	public function posts() {
		$records = CategoriesRelations::select('post_id')->where('category_id', $this->id)->get();
		$ids = array();
		foreach ($records as $record) {
			$ids[] = $record->post_id;
		}
		
		if (!empty($ids) && count($ids) > 0) {
			return Posts::whereIn('id', $ids)->get();
		}
		return array();
	}
}

?>