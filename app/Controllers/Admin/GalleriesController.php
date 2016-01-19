<?php

namespace App\Controllers\Admin;

use App\Models\Galleries;
use Simplified\Http\BaseController;
use Simplified\Http\Request;
use Simplified\Http\Response;
use Simplified\Validator\Validator;

class GalleriesController extends BaseController {
    use Validator;
    public function index() {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $categories = Galleries::all()->toArray();
        $content = view('admin/listview.twig',
            array(
                'listtitle' => 'Galleries',
                'headers' => array(
                    'Title',
                ),
                'keys' => array(
                    'title'
                ),
                'moduleurl' => url('/') . '/admin/galleries',
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

    public function remove(Request $req, $id) {
        $gallery = Galleries::find($id);
        if ($gallery) {
            $gallery->delete();
            \Session::put('msg', 'Element removed.');
            redirect( url('/') . '/admin/galleries');
        }
    }

    public function create(Request $req) {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $content = view('admin/galleryedit');

        return view('admin/adminview.twig',
            array(
                'errors' => $errors,
                'pagetitle' => 'Create Gallery',
                'baseurl' => url('/') . '/',
                'backurl' => url('/') . '/admin/galleries',
                'content' => $content,
                'buttons' => array(
                    array(
                        'title' => 'Save',
                        'class' => 'btn-success',
                        'id' => 'save-btn',
                        'icon'  => 'glyphicon glyphicon-ok',
                        'action' => "$('#GALLERY_FRM').submit();",
                    ),
                    array(
                        'title' => 'Cancel',
                        'class' => 'btn-default',
                        'id' => 'cancel-btn',
                        'icon'  => 'glyphicon glyphicon-remove icon-black',
                        'action' => "openurl('" . url('/') . '/admin/galleries' . "')",
                    ),
                )
            )
        );
    }

    public function edit(Request $req, $id) {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $gallery = Galleries::find($id);
        $content = view('admin/galleryedit', compact('gallery'));

        return view('admin/adminview.twig',
            array(
                'errors' => $errors,
                'pagetitle' => 'Edit Gallery',
                'baseurl' => url('/') . '/',
                'backurl' => url('/') . '/admin/galleries',
                'content' => $content,
                'buttons' => array(
                    array(
                        'title' => 'Save',
                        'class' => 'btn-success',
                        'id' => 'save-btn',
                        'icon'  => 'glyphicon glyphicon-ok',
                        'action' => "$('#GALLERY_FRM').submit();",
                    ),
                    array(
                        'title' => 'Cancel',
                        'class' => 'btn-default',
                        'id' => 'cancel-btn',
                        'icon'  => 'glyphicon glyphicon-remove icon-red',
                        'action' => "openurl('" . url('/') . '/admin/galleries' . "')",
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

        if (!$this->validate($req, $rules)) {
            $url = ($id == 0) ? '/admin/galleries/create' : '/admin/galleries/edit/'.$id;
            \Session::put('msg', implode('\n', $this->validationErrors()));
            redirect( url('/') . $url);
        }
        else {
            if ($id == 0) {
                $gallery = new Galleries();
                $gallery->title = $req->input('title');
                $gallery->save();
                \Session::put('msg', 'Gallery was successfully created.');
                redirect( url('/') . '/admin/galleries/edit/' . $gallery->id);
            } else {
                $gallery = Categories::find($id);
                if ($gallery) {
                    $gallery->title = $req->input('title');
                    $gallery->save();
                    \Session::put('msg', 'Gallery was successfully saved.');
                    redirect( url('/') . '/admin/galleries/edit/' . $gallery->id);
                }
            }
        }
    }

    public function upload(Request $req, $id) {
        $file = $req->getUploadedFile('file');

        $f = $req->getUploadedFiles();
        var_dump($f);

        if ($file) {
            if ($file->getError() != 0) {
                $json = new \stdClass();
                $json->id = $id;
                $json->error = 'Upload error';
                return $json;
            }
            else {
                $file->copyTo(public_path()."/uploads/".$file->getClientFilename());
                $json = new \stdClass();
                $json->error = false;
                $json->id = $id;
                $json->file = public_url().'uploads/'.$file->getClientFilename();
                return $json;
            }
        } else {
            $json = new \stdClass();
            $json->id = $id;
            $json->error = 'No file uploaded';
            return $json;
        }
    }
}