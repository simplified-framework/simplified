<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 17.01.2016
 * Time: 19:14
 */

namespace App\Models;


use Simplified\Database\Model;

class Galleries extends Model {
    public function images() {
        $images = $this->hasMany(GalleryImages::class);
        return $images;
    }
}