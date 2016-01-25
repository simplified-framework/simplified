<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 22.01.2016
 * Time: 22:18
 */

namespace App\Models;


use Simplified\Database\Model;

class GalleryImages extends Model {
    public function thumbnailUrl() {
        return public_url() . 'uploads/thumb-'.$this->filename();
    }

    public function imageUrl() {
        return public_url() . 'uploads/'.$this->filename();
    }

    public function metadata() {
        return $this->hasOne(GalleryImageMeta::class);
    }
}