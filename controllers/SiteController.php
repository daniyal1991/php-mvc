<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home() {
        return $this->render('home', ['name'=>'Hussain']);
    }

    public function contact() {
        return $this->render('contact');
    }

    public function handleContact(Request $request) {
        $body = $request->getBody();

        echo '<pre>';
        var_dump($body);
        echo '</pre>';
        exit;

        return 'POST';
    }
}