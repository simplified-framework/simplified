<?php

namespace App\Controllers;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use App\Models\Posts;
use App\Models\Categories;
use Simplified\View\View;

class BlogPostController extends BaseController {
	public function showPost(Request $request, $slug) {
		if ($slug == "admin") {
			return \App::make('App\Http\Controllers\Admin\PostController')->index($request);
		} 
		else {
			$categories = Categories::all();
			$post = Posts::where('slug', $slug)->first();

			$v = new View();
			return $v->render('blogpostsingle.html',
				array(
					'baseurl' => url(''),
					'homeurl' => url(''),
					'post' => $post,
					'categories' => $categories,
				)
			);
		}
	}
}