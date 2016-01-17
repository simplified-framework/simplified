<?php

namespace App\Controllers\Admin;

use App\Models\Tags as Tags;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\View\View;

class TagController extends BaseController {
	public function index(Request $req) {
		$errors = array();
		if (\Session::has('msg'))
			$errors[] = \Session::pull('msg');

		$tags = Tags::all();
		$content = view('admin/listview.twig',
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
		
		return view('admin/adminview.twig',
			array(
				'pagetitle' => 'Tags',
				'errors' => $errors,
				'baseurl' => url('/') . '/',
				'content' => $content,
			)
		);
	}
	
	public function remove($id) {
		$tag = Tags::find($id);
		if ($tag) {
			$tag->delete();
			\Session::put('msg', 'Element removed.');
			redirect( url('/') . '/admin/tags');
		}
	}
}

?>