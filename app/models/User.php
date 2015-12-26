<?php

namespace App\Models;
use Simplified\Database\Model;

class User extends Model {
    static $primaryKey = 'user_id';

    public function posts() {
        return $this->hasMany('App\Models\Posts');
    }
}