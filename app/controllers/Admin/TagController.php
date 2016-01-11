<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tags as Tags;

class TagController extends Controller {
	public function index(Request $req) {
		$errors = array();
		if ($req->session()->get('msg')) {
			$errors[] = $req->session()->pull('msg', 'unknown message');
		}
		$tags = Tags::all()->toArray();
		$content = $this->template->render('admin/listview.twig',
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
		
		return $this->template->render('admin/adminview.twig',
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