<?php

namespace App\Models;
use Simplified\Orm\Model;

class User extends Model {
    static $primaryKey = 'user_id';

    public function posts() {
        return $this->hasMany('App\Models\Posts');
    }
}