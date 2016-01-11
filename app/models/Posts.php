<?php

namespace App\Models;
use Simplified\Database\Model;

class Posts extends Model {
	/**
	 * Get tags for a post
	 */
	public function tags()
	{
		return $this->hasMany('App\\Models\\Tags');
	}
	
	/**
	 * Get categories for a post
	 */
	public function categories()
	{
		$records = CategoriesRelations::select('category_id')->where('post_id', $this->id)->all();
		if (!empty($records) && count($records) > 0) {
			$ids = array();
			foreach ($records as $record) {
				$ids[] = $record->category_id;
			}
			
			return Categories::whereIn('id', $ids)->get();
		}
		
		return array();
	}
}

?>