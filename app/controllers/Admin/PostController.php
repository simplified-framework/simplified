<?php

namespace App\Controllers\Admin;

use App\Models\Categories;
use App\Models\Posts as Posts;
use App\Models\Tags as Tags;
use App\Models\CategoriesRelations;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\Validator\Validator;

class PostController extends BaseController {
	use Validator;
	public function index(Request $req) {
		$errors = array();
		if (\Session::get('msg')) {
			$errors[] = \Session::pull('msg', 'unknown message');
		}
		
		$posts = Posts::all()->toArray();
		$content = view('admin/listview.twig',
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
		if (\Session::get('msg')) {
			$errors[] = \Session::pull('msg', 'unknown message');
		}
		
		$post = Posts::find($id);
		if (empty(($post))) {
			\Session::put('msg', 'Unable to save non existent post.');
			redirect( url('/') . '/admin/posts/create');
		}

		$categories = Categories::all();
		$selection = array();
		foreach ($post->categories() as $pcat) {
			$selection[] = $pcat->id;
		}
		foreach ($categories as $cat) {
			if (in_array($cat->id, $selection))
				$cat->checked = 'checked';
		}
		$content = view('admin/postedit', compact('post', 'categories'));

		return view('admin/adminview.twig',
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
		if (\Session::has('msg')) {
			$errors[] = \Session::pull('msg', 'unknown message');
		}

		$categories = Categories::all();
		$content = view('admin/postedit', compact('categories'));
		
		return view('admin/adminview.twig',
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
			'title' => 'required',
			'slug'  => 'required'
		);

		if (!$this->validate($req, $rules)) {
			$url = ($id == 0) ? '/admin/posts/create' : '/admin/posts/edit/'.$id;
			\Session::put('msg', 'title must not be empty');
			redirect( url('/') . $url);
		}
		else {			
			if ($id == 0) {
				$post = Posts::create( array('title' => \Input::get('title'), 'author_id' => 1) );
				$post->body = \Input::get('body');
				$post->slug = \Input::get('slug');
				$post->teasertext = strip_tags(\Input::get('teasertext'));
				$post->save();
				
				$categories = !empty($req->input('categories')) ? $req->input('categories') : array();
				if (!empty($categories) && count($categories) > 0) {
					foreach ($categories as $category_id) {
						$relation = new CategoriesRelations();
						$relation->post_id = $post->id;
						$relation->category_id = $category_id;
						$relation->save();
					}
				}
				
				Tags::where('post_id', $post->id)->delete();
				$tags = explode(",", $req->input('tags'));
				if (!empty($tags)) {
					foreach ($tags as $tag) {
						if (empty(trim($tag)))
							continue;
						$t = Tags::create(array('slug' => $tag));
						$t->post_id = $post->id;
						$t->save();
					}
				}
				
				\Session::put('msg', 'Post was successfully created.');
				redirect( url('/') . '/admin/posts/edit/' . $post->id);
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