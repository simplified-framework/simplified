<?php
/**
 * Created by PhpStorm.
 * User: bratfisch
 * Date: 26.01.2016
 * Time: 11:49
 */

namespace App\Controllers\Admin;

use App\Models\File;
use Cocur\Slugify\Slugify;
use Simplified\Http\BaseController;
use Simplified\Http\Request;

function file_upload_max_size() {
    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $max_size = parse_size(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = parse_size(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }
    return $max_size;
}

function parse_size($size) {
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    }
    else {
        return round($size);
    }
}

class FilesController extends BaseController {
    public function index() {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $files = File::all();

        // TODO save mime type in database
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        foreach ($files as $file) {
            $file->mime = $finfo->file(public_path()."/uploads/".$file->name);
        }

        $content = view('admin/listview.twig',
            array(
                'listtitle' => 'Files',
                'headers' => array(
                    'Name',
                    'Mime-Type'
                ),
                'keys' => array(
                    'name',
                    'mime'
                ),
                'moduleurl' => url('/') . '/admin/files',
                'items' => $files,
                'delete' => true,
                'edit' => false,
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

    public function create() {
        $errors = array();
        if (\Session::has('msg'))
            $errors[] = \Session::pull('msg');

        $uploadSize = $displaySize = file_upload_max_size();
        $unit = "Bytes";
        if ($uploadSize >= 1024) {
            $displaySize /= 1024;
            $unit = "KB";
        }
        if ($displaySize >= 1024) {
            $displaySize /= 1024;
            $unit = "MB";
        }

        $content = view('admin/fileupload', array(
            'backurl' => url('/') . '/admin/files',
            'displaysize' => $displaySize, "unit" => $unit, "uploadsize" => $uploadSize
        ));

        return view('admin/adminview.twig',
            array(
                'errors' => $errors,
                'baseurl' => url('/') . '/',
                'content' => $content,
                'pagetitle' => 'Upload file(s)',
                'backurl' => url('/') . '/admin/files',
            )
        );
    }

    public function upload(Request $req) {
        $file = $req->getUploadedFile('file');

        if ($file) {
            if ($file->getError () != 0) {
                $json = new \stdClass();
                $json->error = 'Upload error';
                return $json;
            } else {
                $slugify = new Slugify();
                $info = new \SplFileInfo($file->getClientFilename());
                $ext = pathinfo($file->getClientFilename(),PATHINFO_EXTENSION);
                $basename = basename($file->getClientFilename(), $ext);

                $model = new File();
                $model->name = $slugify->slugify($basename) . ($ext ? "." : "") . $ext;
                $model->save();

                $targetPath = public_path() . "/uploads/" . $model->name;
                $file->copyTo($targetPath);
            }
        }
    }

    public function remove($id) {
        $file = File::find($id);
        if ($file) {
            $file->delete();
            \Session::put('msg', 'Element removed.');
        }
        redirect( url('/') . '/admin/files');
    }
}