<?php

namespace App\Controllers;

use App\Models\Posts as Posts;
use App\Models\Categories as Categories;
use Simplified\Http\BaseController;
use Simplified\View\View;

class BlogPageController extends BaseController {
    public function showPage($id = 0)
    {	
    	$posts = Posts::all();
    	$categories = Categories::all();

		$v = new View();
    	return $v->render('blogpage.html',
    			array(
    					'baseurl' => url('/') . '/',
    					'homeurl' => url('/') . '/',
    					'posts' => $posts,
    					'categories' => $categories,
    			)
    	);
    }
}