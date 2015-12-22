<?php

namespace App\Controllers;

use App\Models\User;
use Simplified\Core\View;
use Simplified\Http\Response;

class Controller {
    public function newIndex() {
        $data = User::all();
        var_dump($data);
/*
        $options = array("opt1" => "Option 1", "opt2" => "Option 2");

        $v = new View();
        $content = $v->render('index.twig', compact('options'));
        (new Response($content))->send();
*/
    }
}