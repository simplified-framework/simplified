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
			return (new Admin\PostController())->index($request);
		} 
		else {
			$categories = Categories::all();
			$post = Posts::where('slug', $slug)->first();

			return view('blogpostsingle.html',
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