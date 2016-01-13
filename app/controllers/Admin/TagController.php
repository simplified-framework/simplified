<?php

namespace App\Controllers\Admin;

use App\Models\Tags as Tags;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\View\View;

class TagController extends BaseController {
	public function index(Request $req) {
		$errors = array();
		$tags = Tags::all()->toArray();
		$v = new View();
		$content = $v->render('admin/listview.twig',
			array(
				'listtitle' => 'Tags',
				'headers' => array(
					'Slug',
				),
				'keys' => array(
					'slug'
				),
				'moduleurl' => url('/') . '/admin/tags',
				'items' => $tags,
				'delete' => true,
				'edit' => false
			)
		);
		
		return $v->render('admin/adminview.twig',
			array(
				'pagetitle' => 'Tags',
				'errors' => $errors,
				'baseurl' => url('/') . '/',
				'content' => $content,
			)
		);
	}
	
	public function remove(Request $req, $id) {
		$tag = Tags::find($id);
		if ($tag) {
			$tag->delete();
			$req->session()->put('msg', 'Element removed.');
			return \Redirect::to( url('/') . '/admin/tags');
		}
	}
}

?>