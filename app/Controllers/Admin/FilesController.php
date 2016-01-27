<?php
/**
 * Created by PhpStorm.
 * User: bratfisch
 * Date: 26.01.2016
 * Time: 11:49
 */

namespace App\Controllers\Admin;


use App\Models\Files;
use Simplified\Http\BaseController;

class FilesController extends BaseController {
    public function index() {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $files = Files::all()->toArray();
        $content = view('admin/listview.twig',
            array(
                'listtitle' => 'Files',
                'headers' => array(
                    'Name',
                ),
                'keys' => array(
                    'name'
                ),
                'moduleurl' => url('/') . '/admin/files',
                'items' => $files,
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
}