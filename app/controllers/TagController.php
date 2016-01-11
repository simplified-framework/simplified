<?php

namespace App\Controllers;

use App\Models\Tags as Tags;
use App\Models\Categories as Categories;
use Simplified\Http\BaseController;
use Simplified\View\View;

class TagController extends BaseController
{
    /**
     * Show posts for tag.
     *
     * @param  int  $id
     * @return Response
     * 
     * TODO respect page id
     */
    public function showTag($slug = null)
    {    	
    	$tag = Tags::where('slug', $slug)->first();
    	$posts = !empty($tag) && count($tag) > 0 ? $tag->posts() : array();
    	$categories = Categories::all();

		$v = new View();
    	return $v->render('blogpage.html',
    			array(
    					'baseurl' => url('/') . '/',
    					'homeurl' => url('/'),
    					'posts' => $posts,
    					'categories' => $categories,
    			)
    	);
    }
}