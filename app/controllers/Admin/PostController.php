<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Posts as Posts;
use App\Tags as Tags;

use App\Libraries\Forms\Forms;
use App\Libraries\Forms\TagInput;
use App\Libraries\Forms\TextInput;
use App\Libraries\Forms\UpdateField;
use App\Libraries\Forms\TextArea;
use App\Libraries\Forms\TextEditor;
use App\Libraries\Forms\CategoriesField;
use App\CategoriesRelations;

class PostController extends Controller {
	public function index(Request $req) {
		$errors = array();
		if ($req->session()->get('msg')) {
			$errors[] = $req->session()->pull('msg', 'unknown message');
		}
		
		$posts = Posts::all()->toArray();
		$content = $this->template->render('admin/listview.twig',
			array(
				'listtitle' => 'Posts',
				'headers' => array(
					'Title',
					'Created At'
				),
				'keys' => array(
					'title',
					'created_at'
				),
				'moduleurl' => url('/') . '/admin/posts',
				'items' => $posts,
				'delete' => true,
				'edit' => true,
				'create' => true
			)
		);
		
		return $this->template->render('admin/adminview.twig',
			array(
				'errors' => $errors,
				'baseurl' => url('/') . '/',
				'content' => $content,
			)
		);
	}
	
	public function edit(Request $req, $id) {
		$errors = array();
		if (\Session::get('msg')) {
			$errors[] = $req->session()->pull('msg', 'unknown message');
		}
		
		$post = Posts::find($id);
		if (empty(($post))) {
			$req->session()->put('msg', 'Unable to save non existent post.');
			return \Redirect::to( url('/') . '/admin/posts/create');
		}
		
		$post->tags = Tags::where('post_id', $id)->get();
		
		// generate form	
		$frm = new Forms(null, array('id' => 'POSTS_FRM', 'class' => 'form', 'route' => array('posts.save', $post->id)));
		$frm->setTitle('Edit Post');
		$e = new TextInput('title', $post->title, array('id' => 'text1', 'class' => 'textfield long'));
		$e->setLabel("Title");
		$frm->addElement($e);
		$e = new UpdateField('slug', $post->slug);
		$e->setLabel('Slug');
		$e->setSource('text1');
		$frm->addElement($e);
		$e = new TextArea('teasertext', $post->teasertext, array('class' => 'textarea'));
		$e->setLabel("Teaser Text");
		$frm->addElement($e);
		$e = new TextEditor('body', $post->body);
		$e->setLabel("Content");
		$frm->addElement($e);
		$e = new CategoriesField($post->categories());
		$e->setLabel("Categories");
		$frm->addElement($e);
		$e = new TagInput('tags', $post->tags, array('id' => 'tags1', 'class' => 'textfield long'));
		$e->setLabel("Tags");
		$frm->addElement($e);
		
		$content = $frm->render();
		
		return $this->template->render('admin/adminview.twig',
			array(
				'errors' => $errors,
				'pagetitle' => 'Edit Post',
				'baseurl' => url('/') . '/',
				'backurl' => url('/') . '/admin/posts',
				'content' => $content,
				'buttons' => array(
					array(
						'title' => 'Save',
						'class' => 'btn-success',
						'id' => 'save-btn',
						'icon'  => 'glyphicon glyphicon-ok',
						'action' => "submitform('#POSTS_FRM')",
					),
					array(
						'title' => 'Cancel',
						'class' => 'btn-default',
						'id' => 'cancel-btn',
						'icon'  => 'glyphicon glyphicon-remove icon-red',
						'action' => "openurl('" . url('/') . '/admin/posts' . "')",
					),
				)
			)
		);
	}
	
	public function remove(Request $req, $id) {
		$post = Posts::find($id);
		if ($post) {
			$post->delete();
			$req->session()->put('msg', 'Element removed.');
			return \Redirect::to( url('/') . '/admin/posts');
		}
	}
	
	public function create(Request $req) {
		$errors = array();
		if ($req->session()->get('msg')) {
			$errors[] = $req->session()->pull('msg', 'unknown message');
		}
		
		// generate form
		$frm = new Forms(null, array('id' => 'POSTS_FRM', 'class' => 'form', 'route' => array('posts.save')));
		$frm->setTitle('Create Post');
		$e = new TextInput('title', null, array('id' => 'text1', 'class' => 'textfield long'));
		$e->setLabel("Title");
		$frm->addElement($e);
		$e = new UpdateField('slug', null);
		$e->setLabel('Slug');
		$e->setSource('text1');
		$frm->addElement($e);
		$e = new TextArea('teasertext', null, array('class' => 'textarea'));
		$e->setLabel("Teaser Text");
		$frm->addElement($e);
		$e = new TextEditor('body', null);
		$e->setLabel("Content");
		$frm->addElement($e);
		$e = new CategoriesField();
		$e->setLabel("Categories");
		$frm->addElement($e);
		$e = new TagInput('tags', null, array('id' => 'tags1', 'class' => 'textfield long'));
		$e->setLabel("Tags");
		$frm->addElement($e);
		$content = $frm->render();
		
		return $this->template->render('admin/adminview.twig',
			array(
				'errors' => $errors,
				'pagetitle' => 'Create Post',
				'baseurl' => url('/') . '/',
				'backurl' => url('/') . '/admin/posts',
				'content' => $content,
				'buttons' => array(
					array(
						'title' => 'Save',
						'class' => 'btn-success',
						'id' => 'save-btn',
						'icon'  => 'glyphicon glyphicon-ok',
						'action' => "submitform('#POSTS_FRM')",
					),
					array(
						'title' => 'Cancel',
						'class' => 'btn-default',
						'id' => 'cancel-btn',
						'icon'  => 'glyphicon glyphicon-remove icon-black',
						'action' => "openurl('" . url('/') . '/admin/posts' . "')",
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
			$url = ($id == 0) ? '/admin/posts/create' : '/admin/posts/edit/'.$id;
			$req->session()->put('msg', 'title must not be empty');
			return \Redirect::to( url('/') . $url);
		}
		else {			
			if ($id == 0) {
				$post = Posts::create( array('title' => \Input::get('title'), 'author_id' => 1) );
				$post->body = \Input::get('body');
				$post->slug = \Input::get('slug');
				$post->teasertext = strip_tags(\Input::get('teasertext'));
				$post->save();
				
				$categories = !empty(\Input::get('categories')) ? \Input::get('categories') : array();
				if (!empty($categories) && count($categories) > 0) {
					foreach ($categories as $category_id) {
						$relation = CategoriesRelations::create(array('post_id' => $post->id));
						$relation->category_id = $category_id;
						$relation->save();
					}
				}
				
				Tags::where('post_id', $post->id)->delete();
				$tags = explode(",", \Input::get('tags'));
				if (!empty($tags)) {
					foreach ($tags as $tag) {
						if (empty(trim($tag)))
							continue;
						$t = Tags::create(array('slug' => $tag));
						$t->post_id = $post->id;
						$t->save();
					}
				}
				
				$req->session()->put('msg', 'Post was successfully created.');
				return \Redirect::to( url('/') . '/admin/posts/edit/' . $post->id);
			} else {
				$post = Posts::find($id);				
				if ($post) {
					$post->title = \Input::get('title');
					$post->body = \Input::get('body');
					$post->slug = \Input::get('slug');
					$post->teasertext = strip_tags(\Input::get('teasertext'));
					$post->save();
					
					CategoriesRelations::where('post_id', $post->id)->delete();
					$categories = !empty(\Input::get('categories')) ? \Input::get('categories') : array();
					if (!empty($categories) && count($categories) > 0) {
						var_dump($categories);
						foreach ($categories as $category_id) {
							$relation = CategoriesRelations::create(array('post_id' => $post->id));
							$relation->category_id = $category_id;
							$relation->save();
						}
					} else {
						var_dump($categories); exit;
					}
					
					Tags::where('post_id', $post->id)->delete();
					$tags = explode(",", \Input::get('tags'));
					if (!empty($tags)) {
						foreach ($tags as $tag) {
							if (empty(trim($tag)))
								continue;
							$t = Tags::create(array('slug' => $tag));
							$t->post_id = $post->id;
							$t->save();
						}
					}
					
					$req->session()->put('msg', 'Post was successfully saved.');
					return \Redirect::to( url('/') . '/admin/posts/edit/' . $post->id);
				} else {
					// show error!
					$req->session()->put('msg', 'Unable to save non existent post.');
					return \Redirect::to( url('/') . '/admin/posts/create');
				}
			}
		}
	}
}

?>