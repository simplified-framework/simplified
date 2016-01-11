<?php

namespace App\Controllers;

use App\Models\Posts as Posts;
use App\Models\Categories as Categories;
use Simplified\Http\BaseController;
use Simplified\View\View;

class CategoryController extends BaseController
{
    /**
     * Show given page.
     *
     * @param  int  $id
     * @return Response
     * 
     * TODO respect page id
     */
    public function showCategory($slug = null)
    {
    	$cat = Categories::where('slug', $slug)->first();
    	
    	$posts = $cat == null ? array() : $cat->posts();
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