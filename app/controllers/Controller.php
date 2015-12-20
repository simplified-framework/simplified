<?php

namespace App\Controllers;

use App\Models\User;
use Simplified\Core\View;
use Simplified\Http\Response;

class Controller {
    public function newIndex() {
        $user = new User();
        var_dump($user->getTable()->fieldNames());
        /*
        $options = array("opt1" => "Option 1", "opt2" => "Option 2");

        $v = new View();
        $content = $v->render('index.twig', compact('options'));
        (new Response($content))->send();
        */
    }
}