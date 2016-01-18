<?php

namespace App\Controllers\Admin;

use App\Models\Categories as Categories;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\Validator\Validator;

class CategoryController extends BaseController {
	use Validator;
	public function index(Request $req) {
		$errors = array();
		if (\Session::has('msg'))
			$errors[] = \Session::pull('msg');

		$categories = Categories::all();
		$content = view('admin/listview.twig',
			array(
				'listtitle' => 'Categories',
				'headers' => array(
					'Title',
				),
				'keys' => array(
					'title'
				),
				'moduleurl' => url('/') . '/admin/categories',
				'items' => $categories,
				'delete' => true,
				'edit' => true,
				'create' => true
			)
		);
		
		return view('admin/adminview.twig',
			array(
				'errors' => $errors,
				'baseurl' => url('/') . '/',
				'content' => $content,
			)
		);
	}
	
	public function edit(Request $req, $id) {
		$errors = array();
		if (\Session::has('msg'))
			$errors[] = \Session::pull('msg');

		$category = Categories::find($id);
		$content = view('admin/categoryedit', compact('category'));

		return view('admin/adminview.twig',
			array(
				'errors' => $errors,
				'pagetitle' => 'Edit Category',
				'baseurl' => url('/') . '/',
				'backurl' => url('/') . '/admin/categories',
				'content' => $content,
				'buttons' => array(
					array(
						'title' => 'Save',
						'class' => 'btn-success',
						'id' => 'save-btn',
						'icon'  => 'glyphicon glyphicon-ok',
						'action' => "$('#CATEGORY_FRM').submit();",
					),
					array(
						'title' => 'Cancel',
						'class' => 'btn-default',
						'id' => 'cancel-btn',
						'icon'  => 'glyphicon glyphicon-remove icon-red',
						'action' => "openurl('" . url('/') . '/admin/categories' . "')",
					),
				)
			)
		);
	}
	
	public function remove(Request $req, $id) {
		$category = Categories::find($id);
		if ($category) {
			$category->delete();
			\Session::put('msg', 'Element removed.');
			redirect( url('/') . '/admin/categories');
		}
	}
	
	public function create(Request $req) {
		$errors = array();
		if (\Session::has('msg'))
			$errors[] = \Session::pull('msg');

		$content = view('admin/categoryedit');

		return view('admin/adminview.twig',
			array(
				'errors' => $errors,
				'pagetitle' => 'Create Category',
				'baseurl' => url('/') . '/',
				'backurl' => url('/') . '/admin/categories',
				'content' => $content,
				'buttons' => array(
					array(
						'title' => 'Save',
						'class' => 'btn-success',
						'id' => 'save-btn',
						'icon'  => 'glyphicon glyphicon-ok',
						'action' => "$('#CATEGORY_FRM').submit();",
					),
					array(
						'title' => 'Cancel',
						'class' => 'btn-default',
						'id' => 'cancel-btn',
						'icon'  => 'glyphicon glyphicon-remove icon-black',
						'action' => "openurl('" . url('/') . '/admin/categories' . "')",
					),
				)
			)
		);
	}
	
	public function save(Request $req, $id = 0) {
		$id = intval($id);
		$rules = array(
			'title' => 'required',
			'slug'  => 'required'
		);

		if (!$this->validate($req, $rules)) {
			$url = ($id == 0) ? '/admin/categories/create' : '/admin/categories/edit/'.$id;
			\Session::put('msg', implode('\n', $this->validationErrors()));
			redirect( url('/') . $url);
		}
		else {
			if ($id == 0) {
				$category = new Categories();
				$category->title = $req->input('title');
				$category->slug = $req->input('slug');
				$category->save();
				\Session::put('msg', 'Category was successfully created.');
				redirect( url('/') . '/admin/categories/edit/' . $category->id);
			} else {
				$category = Categories::find($id);
				if ($category) {
					$category->title = $req->input('title');
					$category->slug = $req->input('slug');
					$category->save();
					\Session::put('msg', 'Category was successfully saved.');
					redirect( url('/') . '/admin/categories/edit/' . $category->id);
				}
			}
		}
	}
}

?>