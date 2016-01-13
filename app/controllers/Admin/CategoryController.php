<?php

namespace App\Controllers\Admin;

use App\Models\Categories as Categories;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\View\View;

class CategoryController extends BaseController {

	public function index(Request $req) {
		$errors = array();

		$categories = Categories::all()->toArray();

		$v = new View();
		$content = $v->render('admin/listview.twig',
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
		
		return $v->render('admin/adminview.twig',
			array(
				'errors' => $errors,
				'baseurl' => url('/') . '/',
				'content' => $content,
			)
		);
	}
	
	public function edit(Request $req, $id) {
		$errors = array();
		
		// generate form
		$category = Categories::find($id);

		/*
		$frm = new Forms(null, array('id' => 'CATEGORY_FRM', 'class' => 'form', 'route' => array('categories.save', $category->id)));
		$frm->setTitle('Edit Category');
		$e = new TextInput('title', $category->title, array('id' => 'text1', 'class' => 'textfield long'));
		$e->setLabel("Title");
		$frm->addElement($e);
		$e = new UpdateField('uricomponent', $category->slug);
		$e->setLabel('Slug');
		$e->setSource('text1');
		$frm->addElement($e);
		$content = $frm->render();
		*/

		$v = new View();
		return $v->render('admin/adminview.twig',
			array(
				'errors' => $errors,
				'pagetitle' => 'Edit Category',
				'baseurl' => url('/') . '/',
				'backurl' => url('/') . '/admin/categories',
				'content' => '',
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
			$req->session()->put('msg', 'Element removed.');
			return \Redirect::to( url('/') . '/admin/categories');
		}
	}
	
	public function create(Request $req) {
		$errors = array();
		if ($req->session()->get('msg')) {
			$errors[] = $req->session()->pull('msg', 'unknown message');
		}
		
		// generate form
		$frm = new Forms(null, array('id' => 'CATEGORY_FRM', 'class' => 'form', 'route' => array('categories.save')));
		$frm->setTitle('Create Category');
		$e = new TextInput('title',null, array('id' => 'text1', 'class' => 'textfield long'));
		$e->setLabel("Title");
		$frm->addElement($e);
		$e = new UpdateField('uricomponent', null);
		$e->setLabel('Slug');
		$e->setSource('text1');
		$frm->addElement($e);
		$content = $frm->render();
		
		return $this->template->render('admin/adminview.twig',
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
			'title' => 'required'
		);
		$validator = \Validator::make($req->all(), $rules);
		if ($validator->fails()) {
			$url = ($id == 0) ? '/admin/categories/create' : '/admin/categories/edit/'.$id;
			$req->session()->put('msg', 'title must not be empty');
			return \Redirect::to( url('/') . $url);
		}
		else {
			if ($id == 0) {
				$category = Categories::create( array('title' => \Input::get('title')) );
				$category->slug = \Input::get('uricomponent');
				$category->save();
				$req->session()->put('msg', 'Category was successfully created.');
				return \Redirect::to( url('/') . '/admin/categories/edit/' . $category->id);
			} else {
				$category = Categories::find($id);
				if ($category) {
					$category->title = \Input::get('title');
					$category->slug = \Input::get('uricomponent');
					$category->save();
					$req->session()->put('msg', 'Category was successfully saved.');
					return \Redirect::to( url('/') . '/admin/categories/edit/' . $category->id);
				}
			}
		}
	}
}

?>